@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<style>
.cart-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.cart-item {
    display: grid;
    grid-template-columns: 100px 1fr auto auto auto;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.cart-item:last-child {
    border-bottom: none;
}

@media (max-width: 768px) {
    .cart-grid {
        grid-template-columns: 1fr;
    }
    
    .cart-item {
        grid-template-columns: 80px 1fr;
        gap: 0.75rem;
    }
}
</style>

<div class="container mx-auto px-4 py-8">
    
    <h1 style="font-size:2.5rem;font-weight:bold;margin-bottom:2rem;">🛒 Shopping Cart</h1>

    @if(session('success'))
    <div style="background:#d1fae5;border:1px solid #34d399;color:#065f46;padding:1rem;border-radius:0.5rem;margin-bottom:1.5rem;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background:#fee2e2;border:1px solid #f87171;color:#991b1b;padding:1rem;border-radius:0.5rem;margin-bottom:1.5rem;">
        {{ session('error') }}
    </div>
    @endif

    @if($cartItems->count() > 0)
    <div class="cart-grid">
        
        <!-- Left: Cart Items -->
        <div>
            <div style="background:white;border-radius:0.75rem;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                @foreach($cartItems as $item)
                <div class="cart-item">
                    
                    <!-- Book Image -->
                    <div>
                        @if($item->book->cover_image)
                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                             alt="{{ $item->book->title }}" 
                             style="width:100px;height:130px;object-fit:cover;border-radius:0.5rem;">
                        @else
                        <div style="width:100px;height:130px;background:linear-gradient(135deg, #f97316 0%, #ec4899 100%);border-radius:0.5rem;display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:2rem;color:white;">📖</span>
                        </div>
                        @endif
                    </div>

                    <!-- Book Info -->
                    <div>
                        <h3 style="font-weight:bold;font-size:1.125rem;margin-bottom:0.25rem;">
                            <a href="{{ route('book.show', $item->book->slug) }}" style="color:#111827;" class="hover:text-orange-500">
                                {{ $item->book->title }}
                            </a>
                        </h3>
                        <p style="color:#6b7280;font-size:0.875rem;">by {{ $item->book->author->name }}</p>
                        <p style="color:#f97316;font-weight:bold;margin-top:0.5rem;">${{ number_format($item->book->price, 2) }}</p>
                    </div>

                    <!-- Quantity Controls -->
                    <div>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display:flex;align-items:center;gap:0.5rem;">
                            @csrf
                            @method('PATCH')
                            <input type="number" 
                                   name="quantity" 
                                   value="{{ $item->quantity }}" 
                                   min="1" 
                                   max="{{ $item->book->stock }}" 
                                   style="width:60px;padding:0.5rem;border:1px solid #d1d5db;border-radius:0.375rem;text-align:center;">
                            <button type="submit" 
                                    style="background:#f97316;color:white;padding:0.5rem 0.75rem;border-radius:0.375rem;font-size:0.875rem;border:none;cursor:pointer;">
                                Update
                            </button>
                        </form>
                    </div>

                    <!-- Subtotal -->
                    <div style="text-align:right;">
                        <p style="font-weight:bold;font-size:1.125rem;">${{ number_format($item->book->price * $item->quantity, 2) }}</p>
                    </div>

                    <!-- Remove Button -->
                    <div>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="color:#dc2626;background:transparent;border:none;cursor:pointer;font-size:1.5rem;"
                                    onclick="return confirm('Remove this item from cart?')">
                                ×
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach

                <!-- Clear Cart -->
                <div style="padding:1rem;border-top:1px solid #e5e7eb;">
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear entire cart?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:#dc2626;background:transparent;border:none;font-size:0.875rem;cursor:pointer;">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div>
            <div style="background:white;border-radius:0.75rem;box-shadow:0 1px 3px rgba(0,0,0,0.1);padding:1.5rem;position:sticky;top:100px;">
                <h2 style="font-size:1.5rem;font-weight:bold;margin-bottom:1.5rem;">Order Summary</h2>

                <div style="margin-bottom:1.5rem;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;">
                        <span style="color:#6b7280;">Subtotal:</span>
                        <span style="font-weight:600;">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;">
                        <span style="color:#6b7280;">Tax (10%):</span>
                        <span style="font-weight:600;">${{ number_format($tax, 2) }}</span>
                    </div>
                    <div style="border-top:2px solid #e5e7eb;padding-top:0.75rem;display:flex;justify-content:space-between;margin-top:1rem;">
                        <span style="font-size:1.25rem;font-weight:bold;">Total:</span>
                        <span style="font-size:1.25rem;font-weight:bold;color:#f97316;">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                @auth
                <a href="{{ route('checkout') }}" class="btn-primary" style="display:block;text-align:center;padding:1rem;margin-bottom:0.75rem;">
                    Proceed to Checkout
                </a>
                @else
                <a href="{{ route('login') }}" class="btn-primary" style="display:block;text-align:center;padding:1rem;margin-bottom:0.75rem;">
                    Login to Checkout
                </a>
                @endauth

                <a href="{{ route('shop') }}" class="btn-secondary" style="display:block;text-align:center;padding:1rem;">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div style="background:#f9fafb;border-radius:0.75rem;padding:4rem;text-align:center;">
        <div style="font-size:6rem;margin-bottom:1rem;">🛒</div>
        <h2 style="font-size:2rem;font-weight:bold;margin-bottom:0.5rem;">Your cart is empty</h2>
        <p style="color:#6b7280;margin-bottom:2rem;">Add some books to get started!</p>
        <a href="{{ route('shop') }}" class="btn-primary" style="display:inline-block;">
            Browse Books
        </a>
    </div>
    @endif

</div>

@endsection