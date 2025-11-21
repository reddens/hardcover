<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get session ID for guest users
     */
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => Str::uuid()->toString()]);
        }
        return session('cart_session_id');
    }

    /**
     * Get cart items for current user/session
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())
                ->with('book.author')
                ->get();
        } else {
            return CartItem::where('session_id', $this->getSessionId())
                ->with('book.author')
                ->get();
        }
    }

    /**
     * Display the cart
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        $subtotal = $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });
        
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);

        // Check stock
        if ($book->stock < 1) {
            return back()->with('error', 'Sorry, this book is out of stock.');
        }

        $quantity = $request->input('quantity', 1);

        // Check if item already in cart
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('book_id', $bookId)
                ->first();
        } else {
            $cartItem = CartItem::where('session_id', $this->getSessionId())
                ->where('book_id', $bookId)
                ->first();
        }

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            
            // Check stock
            if ($newQuantity > $book->stock) {
                return back()->with('error', 'Not enough stock available.');
            }
            
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => Auth::id(),
                'session_id' => Auth::check() ? null : $this->getSessionId(),
                'book_id' => $bookId,
                'quantity' => $quantity,
            ]);
        }

        // If "Buy Now" redirect to checkout
        if ($request->input('buy_now')) {
            return redirect()->route('checkout');
        }

        return redirect()->route('cart.index')->with('success', 'Book added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);

        // Verify ownership
        if (Auth::check()) {
            if ($cartItem->user_id != Auth::id()) {
                abort(403);
            }
        } else {
            if ($cartItem->session_id != $this->getSessionId()) {
                abort(403);
            }
        }

        // Check stock
        if ($request->quantity > $cartItem->book->stock) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        // Verify ownership
        if (Auth::check()) {
            if ($cartItem->user_id != Auth::id()) {
                abort(403);
            }
        } else {
            if ($cartItem->session_id != $this->getSessionId()) {
                abort(403);
            }
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            CartItem::where('session_id', $this->getSessionId())->delete();
        }

        return back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });
        
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        return view('checkout', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    /**
     * Process checkout
     */
    public function processCheckout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_zip' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->book->stock) {
                return back()->with('error', "Not enough stock for {$item->book->title}");
            }
        }

        DB::beginTransaction();

        try {
            // Calculate total
            $subtotal = $cartItems->sum(function ($item) {
                return $item->book->price * $item->quantity;
            });
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zip' => $request->shipping_zip,
                'shipping_country' => $request->shipping_country,
            ]);

            // Create order items and update stock
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $cartItem->book_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->book->price,
                ]);

                // Update book stock
                $book = $cartItem->book;
                $book->stock -= $cartItem->quantity;
                $book->save();
            }

            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Show order confirmation
     */
    public function orderConfirmation($orderId)
    {
        $order = Order::with('items.book')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        return view('order-confirmation', compact('order'));
    }
}