<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->get();

        $featuredBooks = Book::where('is_featured', true)
            ->where('is_active', true)
            ->with(['author', 'category'])
            ->take(12)
            ->get();

        return view('home', compact('banners', 'featuredBooks'));
    }
}