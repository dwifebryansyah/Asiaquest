<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\Tampung;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $book = Book::count();
        $category = Category::count();
        
        return view('dashboard',compact('book','category'));
    }
}
