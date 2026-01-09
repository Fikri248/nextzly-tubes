<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of products (Admin).
     */
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tipe_akun' => 'required|string|max:100',
            'platform' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . Str::slug($validated['nama_produk']) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('logo'), $logoName);
            $validated['logo'] = $logoName;
        } else {
            $validated['logo'] = $validated['logo'] ?? '';
        }

        if ((int) $validated['stok'] === 0) {
            $validated['status'] = 'habis';
        } else {
            $validated['status'] = 'tersedia';
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified product (Frontend).
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('show', compact('product'));
    }

    /**
     * Store order from product page (Frontend).
     */
    public function storeOrder(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'catatan' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $product = Product::findOrFail($id);

        // Check stock
        if ($product->stok < 1) {
            return back()->with('error', 'Maaf, stok produk habis.');
        }

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['phone' => $request->phone],
            [
                'name' => $request->name,
                'email' => $request->email,
            ]
        );

        // Update customer name/email if different
        if ($customer->name !== $request->name || $customer->email !== $request->email) {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        // Generate unique order ID
        $orderId = 'ORD-' . strtoupper(Str::random(10));

        // Create transaction with status pending
        $transaction = Transaction::create([
            'order_id' => $orderId,
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_harga' => $product->harga,
            'metode_pembayaran' => 'qris_whatsapp',
            'status' => 'pending',
            'catatan' => $request->catatan,
        ]);

        // Return with order data for WhatsApp confirmation
        return back()->with([
            'order_success' => true,
            'order' => [
                'order_id' => $orderId,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_email' => $customer->email,
                'product_name' => $product->nama_produk,
                'product_price' => $product->harga,
                'product_duration' => $product->durasi,
                'catatan' => $request->catatan,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tipe_akun' => 'required|string|max:100',
            'platform' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($product->logo && File::exists(public_path('logo/' . $product->logo))) {
                File::delete(public_path('logo/' . $product->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . Str::slug($validated['nama_produk']) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('logo'), $logoName);
            $validated['logo'] = $logoName;
        }

        if ((int) $validated['stok'] === 0) {
            $validated['status'] = 'habis';
        } else {
            $validated['status'] = 'tersedia';
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete logo file if exists
        if ($product->logo && File::exists(public_path('logo/' . $product->logo))) {
            File::delete(public_path('logo/' . $product->logo));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
