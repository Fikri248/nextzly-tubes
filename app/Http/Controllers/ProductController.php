<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        // Cari produk berdasarkan ID, jika tidak ketemu tampilkan 404
        $product = Product::findOrFail($id);

        // Tampilkan view detail
        return view('product_detail', compact('product'));
    }
}
