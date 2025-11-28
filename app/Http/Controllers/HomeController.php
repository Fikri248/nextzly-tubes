<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar: produk yang tersedia
        $query = Product::where('status', 'tersedia');

        // Filter: Jika ada parameter 'category' di URL
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Ambil 16 produk (4x4 grid), urutkan sesuai kolom 'urutan'
        $products = $query->orderBy('urutan', 'asc')->take(16)->get();

        // Ambil semua kategori untuk tombol filter
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }
}
