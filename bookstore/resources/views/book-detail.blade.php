@extends('layouts.app')

@section('title', $book->title)

@section('content')

<style>
.book-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

.book-image-column {
    position: sticky;
    top: 100px;
}

.book-image-column img {
    width: 100%;
    max-height: 600px;
    object-fit: contain;
    border-radius: 0.5rem;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    background: #f9fafb;
}

.book-text-column {
    padding: 1rem 0;
}

.related-books-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1.5rem;
}

.related-book-card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: box-shadow 0.3s;
}

.related-book-card:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.related-book-cover {
    height: 200px;
    overflow: hidden;
    background: #f3f4f6;
}

.related-book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 768px) {
    .book-detail-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .related-books-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
</style>

<div class="container mx-auto px-4 py-8">
    
    <!-- Breadcrumbs -->
    <nav class="mb-6" style="font-size:0.875rem;color:#6b7280;">
        <a href="{{ route('home') }}" style="color:#6b7280;text-decoration:none;transition:color 0.3s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#6b7280'">Home</a>
        <span style="margin:0 0.5rem;">→</span>
        <a href="{{ route('shop') }}" style="color:#6b7280;text-decoration:none;transition:color 0.3s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#6b7280'">Shop</a>
        <span style="margin:0 0.5rem;">→</span>
        <span style="color:#111827;font-weight:600;">{{ $book->title }}</span>
    </nav>

    <!-- Main Grid: 50/50 Split -->
    <div class="book-detail-grid">
        
        <!-- LEFT HALF: Book Cover -->
        <div class="book-image-column">
            @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
            @else
            <div style="width:100%;height:600px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg, #f97316 0%, #ec4899 100%);border-radius:0.5rem;box-shadow:0 20px 50px rgba(0,0,0,0.2);">
                <span style="font-size:6rem;color:white;font-weight:700;">BOOK</span>
            </div>
            @endif
        </div>

        <!-- RIGHT HALF: Book Details -->
        <div class="book-text-column">
            
            <!-- Title -->
            <h1 style="font-size:2.5rem;font-weight:700;margin-bottom:1rem;line-height:1.2;color:#111827;">{{ $book->title }}</h1>
            
            <!-- Author -->
            <div style="margin-bottom:1.5rem;">
                <span style="font-size:1.25rem;color:#6b7280;">by <span style="font-weight:600;color:#111827;">{{ $book->author->name }}</span></span>
            </div>

            <!-- Category Badge -->
            <div style="margin-bottom:1.5rem;">
                <span style="display:inline-block;background:#fed7aa;color:#9a3412;padding:0.5rem 1rem;border-radius:9999px;font-size:0.875rem;font-weight:600;">
                    {{ $book->category->name }}
                </span>
            </div>

            <!-- Price -->
            <div style="margin-bottom:1.5rem;">
                <div style="font-size:3rem;font-weight:700;color:#f97316;">${{ number_format($book->price, 2) }}</div>
            </div>

            <!-- Stock Status -->
            <div style="margin-bottom:1.5rem;">
                @if($book->stock > 0)
                <p style="color:#059669;font-weight:600;font-size:1.125rem;display:flex;align-items:center;gap:0.5rem;">
                    <svg style="width:1.5rem;height:1.5rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    In Stock ({{ $book->stock }} available)
                </p>
                @else
                <p style="color:#dc2626;font-weight:600;font-size:1.125rem;display:flex;align-items:center;gap:0.5rem;">
                    <svg style="width:1.5rem;height:1.5rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    Out of Stock
                </p>
                @endif
            </div>

            <!-- Add to Cart Form -->
            @if($book->stock > 0)
            <form action="{{ route('cart.add', $book->id) }}" method="POST" style="margin-bottom:1rem;">
                @csrf
                <div style="display:flex;gap:1rem;align-items:flex-end;margin-bottom:1rem;">
                    <div style="flex-shrink:0;">
                        <label for="quantity" style="display:block;font-weight:600;margin-bottom:0.5rem;font-size:0.875rem;">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $book->stock }}" 
                               style="width:80px;padding:0.75rem 1rem;border:2px solid #d1d5db;border-radius:0.5rem;text-align:center;font-size:1.125rem;">
                    </div>
                    <button type="submit" class="btn-primary" style="flex-grow:1;padding:0.75rem 2rem;font-size:1.125rem;">
                        Add to Cart
                    </button>
                </div>
            </form>

            <!-- Buy Now Button -->
            <form action="{{ route('cart.add', $book->id) }}" method="POST" style="margin-bottom:2rem;">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="buy_now" value="1">
                <button type="submit" style="width:100%;background:#ec4899;color:white;font-weight:700;padding:0.75rem 2rem;border-radius:0.5rem;font-size:1.125rem;border:none;cursor:pointer;transition:background 0.3s;" onmouseover="this.style.background='#db2777'" onmouseout="this.style.background='#ec4899'">
                    Buy Now
                </button>
            </form>
            @else
            <button style="width:100%;background:#d1d5db;color:#6b7280;font-weight:700;padding:1rem 2rem;border-radius:0.5rem;font-size:1.125rem;cursor:not-allowed;margin-bottom:2rem;border:none;" disabled>
                Out of Stock
            </button>
            @endif

            <!-- Divider -->
            <hr style="margin:1.5rem 0;border:none;border-top:1px solid #e5e7eb;">

            <!-- Book Details -->
            <div style="margin-bottom:1.5rem;">
                <h2 style="font-size:1.25rem;font-weight:700;margin-bottom:1rem;color:#111827;">Book Details</h2>
                <div style="background:#f9fafb;border-radius:0.5rem;padding:1rem;">
                    @if($book->isbn)
                    <div style="display:flex;justify-content:space-between;border-bottom:1px solid #e5e7eb;padding-bottom:0.75rem;margin-bottom:0.75rem;">
                        <span style="font-weight:600;color:#374151;">ISBN:</span>
                        <span style="color:#111827;">{{ $book->isbn }}</span>
                    </div>
                    @endif

                    @if($book->publisher)
                    <div style="display:flex;justify-content:space-between;border-bottom:1px solid #e5e7eb;padding-bottom:0.75rem;margin-bottom:0.75rem;">
                        <span style="font-weight:600;color:#374151;">Publisher:</span>
                        <span style="color:#111827;">{{ $book->publisher }}</span>
                    </div>
                    @endif

                    @if($book->published_date)
                    <div style="display:flex;justify-content:space-between;border-bottom:1px solid #e5e7eb;padding-bottom:0.75rem;margin-bottom:0.75rem;">
                        <span style="font-weight:600;color:#374151;">Published:</span>
                        <span style="color:#111827;">{{ $book->published_date->format('F d, Y') }}</span>
                    </div>
                    @endif

                    @if($book->pages)
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-weight:600;color:#374151;">Pages:</span>
                        <span style="color:#111827;">{{ $book->pages }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($book->description)
            <div style="margin-bottom:1.5rem;">
                <h2 style="font-size:1.25rem;font-weight:700;margin-bottom:0.75rem;color:#111827;">Description</h2>
                <div style="color:#374151;line-height:1.75;background:#f9fafb;border-radius:0.5rem;padding:1rem;">
                    {{ $book->description }}
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Related Books Section -->
    <div style="margin-top:4rem;border-top:1px solid #e5e7eb;padding-top:3rem;">
        <div class="title-container">
            <h2 class="section-title">More from {{ $book->category->name }}</h2>
        </div>
        
        @php
        $relatedBooks = \App\Models\Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('is_active', true)
            ->limit(6)
            ->get();
        @endphp

        @if($relatedBooks->count() > 0)
        <div class="related-books-grid">
            @foreach($relatedBooks as $relatedBook)
            <div class="related-book-card">
                <a href="{{ route('book.show', $relatedBook->slug) }}" style="text-decoration:none;">
                    <div class="related-book-cover">
                        @if($relatedBook->cover_image)
                        <img src="{{ asset('storage/' . $relatedBook->cover_image) }}" alt="{{ $relatedBook->title }}">
                        @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);">
                            <span style="font-size:2rem;color:white;font-weight:700;">BOOK</span>
                        </div>
                        @endif
                    </div>
                    <div style="padding:0.75rem;">
                        <h3 style="font-weight:700;font-size:0.75rem;margin-bottom:0.25rem;height:2rem;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;color:#111827;">{{ $relatedBook->title }}</h3>
                        <p style="font-size:0.75rem;color:#6b7280;margin-bottom:0.25rem;">{{ $relatedBook->author->name }}</p>
                        <p style="font-size:1.125rem;font-weight:700;color:#f97316;">${{ number_format($relatedBook->price, 2) }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <p style="color:#6b7280;">No related books found.</p>
        @endif
    </div>

</div>

@endsection