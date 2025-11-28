<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->where('status', 'tersedia')->paginate(12);
        $categories = Category::all();
        return view('apps', compact('products', 'categories'));
    }
}
