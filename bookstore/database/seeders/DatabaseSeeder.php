<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Banner;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Fiction', 'slug' => 'fiction', 'description' => 'Fictional stories and novels'],
            ['name' => 'Non-Fiction', 'slug' => 'non-fiction', 'description' => 'Real stories and factual books'],
            ['name' => 'Science Fiction', 'slug' => 'science-fiction', 'description' => 'Futuristic and scientific stories'],
            ['name' => 'Mystery', 'slug' => 'mystery', 'description' => 'Mystery and thriller books'],
            ['name' => 'Romance', 'slug' => 'romance', 'description' => 'Romantic stories'],
            ['name' => 'Biography', 'slug' => 'biography', 'description' => 'Life stories of real people'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create authors
        $authors = [
            ['name' => 'J.K. Rowling', 'bio' => 'British author, best known for the Harry Potter series'],
            ['name' => 'Stephen King', 'bio' => 'American author of horror, supernatural fiction, and suspense'],
            ['name' => 'Agatha Christie', 'bio' => 'English writer known for her detective novels'],
            ['name' => 'Isaac Asimov', 'bio' => 'American writer and professor of biochemistry, known for science fiction'],
            ['name' => 'Jane Austen', 'bio' => 'English novelist known for her romantic fiction'],
            ['name' => 'George Orwell', 'bio' => 'English novelist and essayist, journalist and critic'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }

        // Create sample books
        $books = [
            [
                'title' => 'The Great Adventure',
                'slug' => 'the-great-adventure',
                'description' => 'An epic journey through uncharted territories filled with excitement and discovery.',
                'author_id' => 1,
                'category_id' => 1,
                'price' => 24.99,
                'stock' => 50,
                'pages' => 350,
                'publisher' => 'Adventure Press',
                'is_featured' => true,
            ],
            [
                'title' => 'Mystery at Midnight',
                'slug' => 'mystery-at-midnight',
                'description' => 'A thrilling mystery that will keep you guessing until the very last page.',
                'author_id' => 3,
                'category_id' => 4,
                'price' => 19.99,
                'stock' => 35,
                'pages' => 280,
                'publisher' => 'Mystery House',
                'is_featured' => true,
            ],
            [
                'title' => 'Future Worlds',
                'slug' => 'future-worlds',
                'description' => 'Exploring the possibilities of tomorrow through imaginative science fiction.',
                'author_id' => 4,
                'category_id' => 3,
                'price' => 29.99,
                'stock' => 40,
                'pages' => 420,
                'publisher' => 'Sci-Fi Publications',
                'is_featured' => true,
            ],
            [
                'title' => 'Love in Paris',
                'slug' => 'love-in-paris',
                'description' => 'A heartwarming romance set against the backdrop of the City of Light.',
                'author_id' => 5,
                'category_id' => 5,
                'price' => 17.99,
                'stock' => 60,
                'pages' => 320,
                'publisher' => 'Romance Books Inc',
                'is_featured' => true,
            ],
            [
                'title' => 'The Dark Tower',
                'slug' => 'the-dark-tower',
                'description' => 'A chilling tale of horror and suspense that will haunt your dreams.',
                'author_id' => 2,
                'category_id' => 1,
                'price' => 22.99,
                'stock' => 45,
                'pages' => 400,
                'publisher' => 'Horror Publishing',
                'is_featured' => false,
            ],
            [
                'title' => 'Digital Revolution',
                'slug' => 'digital-revolution',
                'description' => 'The story of how technology changed our world forever.',
                'author_id' => 6,
                'category_id' => 2,
                'price' => 26.99,
                'stock' => 30,
                'pages' => 380,
                'publisher' => 'Tech Books',
                'is_featured' => true,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Create banner
        Banner::create([
            'title' => 'Welcome to Our Bookstore',
            'description' => 'Discover thousands of books at amazing prices',
            'image' => 'banners/default-banner.jpg',
            'button_text' => 'Shop Now',
            'link' => '/shop',
            'order' => 1,
            'is_active' => true,
        ]);
    }
}