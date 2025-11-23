@extends('layouts.app')

@section('title', 'Shop')

@section('content')

<style>
.books-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.book-card-shop {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: box-shadow 0.3s;
}

.book-card-shop:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.book-cover-container {
    width: 100%;
    height: 320px;
    overflow: hidden;
    background: #f3f4f6;
    position: relative;
}

.book-cover-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-info-section {
    padding: 1rem;
}

@media (max-width: 768px) {
    .books-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<!-- Page Header -->
<div style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); padding: 2rem 0; margin-bottom: 2rem;">
    <div class="container mx-auto px-4 text-center">
        <h1 style="font-size: 2rem; font-weight: 700; color: white;">Discover Your Next Great Read</h1>
        <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9);">Browse our complete collection of books</p>
    </div>
</div>

<div class="container mx-auto px-4 mb-8">
    <!-- Search & Filter Form -->
    <form action="{{ route('shop') }}" method="GET">
        <div style="background:white;padding:1.5rem;">
            <div style="display:grid;grid-template-columns:2fr 1fr auto;gap:1rem;align-items:end;">
                
                <!-- Search Input -->
                <div>
                    <label style="display:block;font-weight:600;margin-bottom:0.5rem;font-size:0.875rem;color:#374151;">Search Books</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search by title or author..." 
                           style="width:100%;padding:0.75rem 1rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#f97316'"
                           onblur="this.style.borderColor='#e5e7eb'">
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label style="display:block;font-weight:600;margin-bottom:0.5rem;font-size:0.875rem;color:#374151;">Category</label>
                    <select name="category" 
                            style="width:100%;padding:0.75rem 1rem;border:2px solid #e5e7eb;border-radius:0.5rem;font-size:1rem;background:white;cursor:pointer;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Button -->
                <div>
                    <button type="submit" 
                            class="btn-primary" 
                            style="padding:0.875rem 2rem;white-space:nowrap;display:flex;align-items:center;gap:0.5rem;">
                        <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                </div>

            </div>

            <!-- Active Filters Display -->
            @if(request('search') || request('category'))
            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #e5e7eb;">
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                    <span style="font-size:0.875rem;color:#6b7280;font-weight:600;">Active filters:</span>
                    
                    @if(request('search'))
                    <span style="display:inline-flex;align-items:center;gap:0.5rem;background:#fef3c7;color:#92400e;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.875rem;">
                        Search: "{{ request('search') }}"
                        <a href="{{ route('shop', ['category' => request('category')]) }}" style="color:#92400e;font-weight:bold;">×</a>
                    </span>
                    @endif

                    @if(request('category'))
                    @php
                        $selectedCategory = $categories->firstWhere('id', request('category'));
                    @endphp
                    @if($selectedCategory)
                    <span style="display:inline-flex;align-items:center;gap:0.5rem;background:#dbeafe;color:#1e40af;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.875rem;">
                        Category: {{ $selectedCategory->name }}
                        <a href="{{ route('shop', ['search' => request('search')]) }}" style="color:#1e40af;font-weight:bold;">×</a>
                    </span>
                    @endif
                    @endif

                    <a href="{{ route('shop') }}" style="font-size:0.875rem;color:#f97316;font-weight:600;margin-left:0.5rem;">Clear all</a>
                </div>
            </div>
            @endif
        </div>
    </form>
</div>

<div class="container mx-auto px-4 mb-12">
    @if($books->count() > 0)
    
    <div class="mt-6 mb-6">
        <p style="color:#6b7280;font-size:0.875rem;">Showing {{ $books->count() }} of {{ $books->total() }} books</p>
    </div>

    <!-- Books Grid -->
    <div class="books-grid">
        @foreach($books as $book)
        <div class="book-card-shop">
            
            <a href="{{ route('book.show', $book->slug) }}">
                <div class="book-cover-container">
                    @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                    @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg, #f97316 0%, #ec4899 100%);">
                        <span style="font-size:4rem;color:white;font-weight:700;">BOOK</span>
                    </div>
                    @endif
                    
                    @if($book->stock > 0 && $book->stock < 5)
                    <div style="position:absolute;top:8px;right:8px;background:#ef4444;color:white;font-size:0.75rem;padding:4px 8px;border-radius:4px;font-weight:600;">
                        Only {{ $book->stock }} left
                    </div>
                    @elseif($book->stock == 0)
                    <div style="position:absolute;top:8px;right:8px;background:#6b7280;color:white;font-size:0.75rem;padding:4px 8px;border-radius:4px;font-weight:600;">
                        Out of Stock
                    </div>
                    @endif
                </div>
            </a>

            <div class="book-info-section">
                <h3 style="font-weight:700;font-size:1rem;margin-bottom:0.5rem;height:3rem;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                    <a href="{{ route('book.show', $book->slug) }}" style="color:#111827;text-decoration:none;" class="hover:text-orange-500">
                        {{ $book->title }}
                    </a>
                </h3>
                <p style="font-size:0.875rem;color:#6b7280;margin-bottom:0.75rem;">by {{ $book->author->name }}</p>
                <p style="font-size:1.5rem;font-weight:700;color:#f97316;margin-bottom:1rem;">£{{ number_format($book->price, 2) }}</p>

                @if($book->stock > 0)
                <form action="{{ route('cart.add', $book->id) }}" method="POST" style="margin-bottom:0.5rem;">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-primary" style="width:100%;padding:0.75rem;text-align:center;">
                        Add to Cart
                    </button>
                </form>
                @else
                <button class="btn-secondary" style="width:100%;padding:0.75rem;cursor:not-allowed;opacity:0.5;" disabled>
                    Out of Stock
                </button>
                @endif

                <a href="{{ route('book.show', $book->slug) }}" style="display:block;text-align:center;font-size:0.875rem;color:#6b7280;margin-top:0.5rem;text-decoration:none;">
                    View Details →
                </a>
            </div>

        </div>
        @endforeach
    </div>

    <div style="display:flex;justify-content:center;margin-top:2rem;">
        {{ $books->links() }}
    </div>

    @else
    <!-- Empty State -->
    <div style="background:#f9fafb;border-radius:0.75rem;padding:4rem;text-align:center;">
        <div style="font-size:4rem;margin-bottom:1rem;color:#9ca3af;">📚</div>
        <h2 style="font-size:2rem;font-weight:700;margin-bottom:0.5rem;color:#111827;">No books found</h2>
        <p style="color:#6b7280;margin-bottom:2rem;font-size:1.125rem;">Try adjusting your search or filters</p>
        <a href="{{ route('shop') }}" class="btn-primary">View All Books</a>
    </div>
    @endif
</div>

@endsection