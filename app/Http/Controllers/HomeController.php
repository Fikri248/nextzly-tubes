<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        $query = Product::with('category');

        // Search
        if ($search) {
            $query->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        // Filter kategori (pakai category_id, bukan kategori)
        if ($kategori && $kategori !== 'all') {
            $query->where('category_id', $kategori);  // ← PERBAIKAN
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('nama_kategori', 'asc')->get();

        return view('home', compact('products', 'categories', 'search', 'kategori'));
    }
}
