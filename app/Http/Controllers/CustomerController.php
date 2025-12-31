<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::query()
            ->withCount('transactions')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.customers.index', compact('customers', 'search'));
    }

    /**
     * Show form to create new customer.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a new customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'name.max' => 'Nama pelanggan maksimal 255 karakter.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
        ]);

        Customer::create($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Show form to edit customer.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update customer data.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'name.max' => 'Nama pelanggan maksimal 255 karakter.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Remove customer from database.
     */
    public function destroy(Customer $customer)
    {
        // Check if customer has transactions
        if ($customer->transactions()->exists()) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }

    /**
     * Display customer transaction history.
     */
    public function transactions(Customer $customer)
    {
        $transactions = Transaction::where('customer_id', $customer->id)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customers.transactions', compact('customer', 'transactions'));
    }
}
