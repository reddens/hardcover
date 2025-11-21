@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mx-auto">
    
    <!-- Banner Section -->
    @if($banners->count() > 0)
    <div class="banner-slider">
        <div class="glide" id="banner-glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($banners as $banner)
                    <li class="glide__slide">
                        <div class="banner-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset('storage/' . $banner->image) }}');">
                            <div class="banner-content">
                                <h1 class="banner-title">{{ $banner->title }}</h1>
                                @if($banner->description)
                                <p class="banner-description">{{ $banner->description }}</p>
                                @endif
                                @if($banner->link && $banner->button_text)
                                <a href="{{ $banner->link }}" class="btn-primary">{{ $banner->button_text }}</a>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            @if($banners->count() > 1)
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<">‹</button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">›</button>
            </div>
            @endif
        </div>
    </div>
    @endif
    
    <!-- Text Block Section -->
    <div class="text-block">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="section-title text-center" style="display: inline-block;">Welcome to Our Bookstore</h2>
            <p class="text-lg leading-relaxed mt-6" style="color: #666;">
                Discover your next great read from our carefully curated collection of books. 
                Whether you're looking for bestsellers, classics, or hidden gems, we have something for every reader. 
                Browse our extensive catalog and find the perfect book to transport you to another world.
            </p>
        </div>
    </div>
    
    <!-- Featured Books Section -->
    @if($featuredBooks->count() > 0)
    <section class="mb-12">
        <div class="title-container">
        <h2 class="section-title mb-8">Featured Books</h2>
        </div>
        
        <div class="glide featured-books" id="books-glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($featuredBooks as $book)
                    <li class="glide__slide" style="width: 280px;">
                        <div class="book-card">
                            <a href="{{ route('book.show', $book->slug) }}">
                                @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                @else
                                <img src="https://via.placeholder.com/280x350/FF6B35/FFFFFF?text=No+Image" alt="{{ $book->title }}">
                                @endif
                            </a>
                            
                            <div class="book-card-body">
                                <a href="{{ route('book.show', $book->slug) }}" class="book-title">
                                    {{ Str::limit($book->title, 50) }}
                                </a>
                                <p class="book-author">by {{ $book->author->name }}</p>
                                <p class="book-price">£{{ number_format($book->price, 2) }}</p>
                                <a href="{{ route('book.show', $book->slug) }}" class="btn-primary mt-4 text-center block">View Details</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<">‹</button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">›</button>
            </div>
        </div>
    </section>
    @endif
    
    <!-- Contact Form Section -->
    <section class="mb-12">
        <div class="max-w-2xl mx-auto">

            <div class="title-container">
            <h2 class="section-title mb-8 text-center" style="display: inline-block;">Contact Us</h2>
            </div>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            
            <div class="contact-form">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-grid-3">
                        <div>
                            <label for="name" class="block font-semibold mb-2">Name</label>
                            <input type="text" id="name" name="name" class="form-input" required value="{{ old('name') }}">
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block font-semibold mb-2">Email</label>
                            <input type="email" id="email" name="email" class="form-input" required value="{{ old('email') }}">
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="subject" class="block font-semibold mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-input" required value="{{ old('subject') }}">
                            @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="message" class="block font-semibold mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" class="form-input" required>{{ old('message') }}</textarea>
                        @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-primary w-full">Send Message</button>
                </form>
            </div>
        </div>
    </section>
    
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/glide.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.core.min.css">

<script>
    // Banner slider
    @if($banners->count() > 1)
    new Glide('#banner-glide', {
        type: 'carousel',
        autoplay: 5000,
        hoverpause: true,
        perView: 1
    }).mount();
    @endif
    
    // Books slider
    @if($featuredBooks->count() > 0)
    new Glide('#books-glide', {
        type: 'carousel',
        perView: 4,
        gap: 24,
        breakpoints: {
            1024: {
                perView: 3
            },
            768: {
                perView: 2
            },
            640: {
                perView: 1
            }
        }
    }).mount();
    @endif
</script>
@endpush