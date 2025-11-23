@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<style>
.checkout-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

@media (max-width: 768px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="container mx-auto px-4 py-8">
    
    <h1 style="font-size:2.5rem;font-weight:700;margin-bottom:2rem;color:#111827;">Checkout</h1>

    <!-- Progress Steps -->
    <div style="display:flex;justify-content:center;margin-bottom:3rem;">
        <div style="display:flex;align-items:center;gap:1rem;">
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <div style="width:2rem;height:2rem;background:#10b981;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;">✓</div>
                <span style="color:#10b981;font-weight:600;">Cart</span>
            </div>
            <div style="width:3rem;height:2px;background:#d1d5db;"></div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <div style="width:2rem;height:2rem;background:#f97316;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.875rem;">2</div>
                <span style="color:#f97316;font-weight:600;">Checkout</span>
            </div>
            <div style="width:3rem;height:2px;background:#d1d5db;"></div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <div style="width:2rem;height:2rem;background:#d1d5db;color:#6b7280;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.875rem;">3</div>
                <span style="color:#6b7280;">Complete</span>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div style="background:#fee2e2;border:1px solid #f87171;color:#991b1b;padding:1rem;border-radius:0.5rem;margin-bottom:1.5rem;">
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background:#fee2e2;border:1px solid #f87171;color:#991b1b;padding:1rem;border-radius:0.5rem;margin-bottom:1.5rem;">
        <ul style="list-style:disc;padding-left:1.5rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="checkout-grid">
            
            <!-- Left: Shipping Information -->
            <div>
                <div style="background:white;border-radius:0.75rem;box-shadow:0 1px 3px rgba(0,0,0,0.1);padding:2rem;margin-bottom:2rem;">
                    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1.5rem;color:#111827;">Shipping Information</h2>

                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">Full Name</label>
                        <input type="text" 
                               name="shipping_name" 
                               value="{{ old('shipping_name', Auth::user()->name) }}" 
                               required
                               style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;">
                    </div>

                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">Street Address *</label>
                        <input type="text" 
                               name="shipping_address" 
                               value="{{ old('shipping_address') }}" 
                               placeholder="123 Main Street"
                               required
                               style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;">
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                        <div>
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">City *</label>
                            <input type="text" 
                                   name="shipping_city" 
                                   value="{{ old('shipping_city') }}" 
                                   required
                                   style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;">
                        </div>

                        <div>
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">State/Province *</label>
                            <input type="text" 
                                   name="shipping_state" 
                                   value="{{ old('shipping_state') }}" 
                                   required
                                   style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;">
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                        <div>
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">ZIP/Postal Code *</label>
                            <input type="text" 
                                   name="shipping_zip" 
                                   value="{{ old('shipping_zip') }}" 
                                   required
                                   style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;">
                        </div>

                        <div>
                            <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">Country *</label>
                            <input type="text" 
                                   name="shipping_country" 
                                   value="{{ old('shipping_country', 'United States') }}" 
                                   required
                                   style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;">
                        </div>
                    </div>

                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">Phone Number</label>
                        <input type="tel" 
                               name="shipping_phone" 
                               value="{{ old('shipping_phone') }}" 
                               placeholder="+1 (555) 123-4567"
                               style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;">
                    </div>

                    <div>
                        <label style="display:block;font-weight:600;margin-bottom:0.5rem;color:#374151;">Delivery Notes (Optional)</label>
                        <textarea name="delivery_notes" 
                                  rows="3" 
                                  placeholder="Any special delivery instructions..."
                                  style="width:100%;padding:0.75rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;resize:vertical;">{{ old('delivery_notes') }}</textarea>
                    </div>
                </div>

                <!-- Payment Information -->
                <div style="background:white;border-radius:0.75rem;box-shadow:0 1px 3px rgba(0,0,0,0.1);padding:2rem;">
                    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1.5rem;color:#111827;">Payment Method</h2>
                    
                    <div style="background:#fef3c7;border:1px solid #fbbf24;color:#92400e;padding:1rem;border-radius:0.5rem;margin-bottom:1.5rem;">
                        <p style="font-weight:600;margin-bottom:0.5rem;">Demo Mode</p>
                        <p style="font-size:0.875rem;">This is a demo store. No real payments will be processed. Click "Place Order" to complete your test purchase.</p>
                    </div>

                    <div style="border:2px solid #f97316;border-radius:0.5rem;padding:1rem;background:#fff7ed;">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
                            <input type="radio" name="payment_method" value="cash_on_delivery" checked style="width:1.25rem;height:1.25rem;">
                            <label style="font-weight:600;font-size:1.125rem;color:#111827;">Cash on Delivery</label>
                        </div>
                        <p style="color:#6b7280;font-size:0.875rem;margin-left:2rem;">Pay when you receive your order</p>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div>
                <div style="background:white;border-radius:0.75rem;box-shadow:0 1px 3px rgba(0,0,0,0.1);padding:1.5rem;position:sticky;top:100px;">
                    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1.5rem;color:#111827;">Order Summary</h2>

                    <!-- Cart Items -->
                    <div style="margin-bottom:1.5rem;max-height:300px;overflow-y:auto;">
                        @foreach($cartItems as $item)
                        <div style="display:flex;gap:1rem;padding:1rem 0;border-bottom:1px solid #e5e7eb;">
                            <div style="flex-shrink:0;">
                                @if($item->book->cover_image)
                                <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                     alt="{{ $item->book->title }}" 
                                     style="width:60px;height:80px;object-fit:cover;border-radius:0.375rem;">
                                @else
                                <div style="width:60px;height:80px;background:#e5e7eb;border-radius:0.375rem;"></div>
                                @endif
                            </div>
                            <div style="flex:1;">
                                <h4 style="font-weight:600;font-size:0.875rem;margin-bottom:0.25rem;color:#111827;">{{ $item->book->title }}</h4>
                                <p style="color:#6b7280;font-size:0.75rem;margin-bottom:0.25rem;">Qty: {{ $item->quantity }}</p>
                                <p style="color:#f97316;font-weight:700;font-size:0.875rem;">${{ number_format($item->book->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div style="margin-bottom:1.5rem;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;">
                            <span style="color:#6b7280;">Subtotal:</span>
                            <span style="font-weight:600;color:#111827;">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;">
                            <span style="color:#6b7280;">Shipping:</span>
                            <span style="font-weight:600;color:#10b981;">FREE</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;">
                            <span style="color:#6b7280;">Tax (10%):</span>
                            <span style="font-weight:600;color:#111827;">${{ number_format($tax, 2) }}</span>
                        </div>
                        <div style="border-top:2px solid #e5e7eb;padding-top:0.75rem;display:flex;justify-content:space-between;margin-top:1rem;">
                            <span style="font-size:1.25rem;font-weight:700;color:#111827;">Total:</span>
                            <span style="font-size:1.25rem;font-weight:700;color:#f97316;">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" 
                            class="btn-primary" 
                            style="width:100%;padding:1rem;font-size:1.125rem;margin-bottom:0.75rem;">
                        Place Order
                    </button>

                    <a href="{{ route('cart.index') }}" 
                       class="btn-secondary" 
                       style="display:block;text-align:center;padding:0.75rem;text-decoration:none;">
                        Back to Cart
                    </a>

                    <!-- Security Badge -->
                    <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid #e5e7eb;text-align:center;">
                        <p style="color:#6b7280;font-size:0.75rem;display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                            <svg style="width:1rem;height:1rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Secure Checkout
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection