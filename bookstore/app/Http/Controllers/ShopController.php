<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('is_active', true)
            ->with(['author', 'category']);

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('author', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Sort alphabetically by title
        $books = $query->orderBy('title', 'asc')->paginate(12);

        $categories = Category::where('is_active', true)->get();

        return view('shop', compact('books', 'categories'));
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)
            ->where('is_active', true)
            ->with(['author', 'category'])
            ->firstOrFail();

        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('book-detail', compact('book', 'relatedBooks'));
    }
}