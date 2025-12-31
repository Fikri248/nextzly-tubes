<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'product'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Search by order_id, customer (name, email, phone), or product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function ($productQuery) use ($search) {
                      $productQuery->where('nama_produk', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(15)->withQueryString();

        // Stats (apply same year/month filters for accurate count)
        $statsQuery = Transaction::query();

        if ($request->filled('year')) {
            $statsQuery->whereYear('created_at', $request->year);
        }
        if ($request->filled('month')) {
            $statsQuery->whereMonth('created_at', $request->month);
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'success' => (clone $statsQuery)->where('status', 'success')->count(),
            'failed' => (clone $statsQuery)->where('status', 'failed')->count(),
            'cancelled' => (clone $statsQuery)->where('status', 'cancelled')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    /**
     * Update transaction status.
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,success,failed,cancelled',
        ]);

        $oldStatus = $transaction->status;
        $newStatus = $request->status;

        // Kurangi stok jika status berubah dari non-success ke success
        if ($oldStatus !== 'success' && $newStatus === 'success') {
            if ($transaction->product) {
                $transaction->product->decrement('stok', 1);
            }
        }

        // Kembalikan stok jika status berubah dari success ke non-success
        if ($oldStatus === 'success' && $newStatus !== 'success') {
            if ($transaction->product) {
                $transaction->product->increment('stok', 1);
            }
        }

        $transaction->update([
            'status' => $newStatus,
            'paid_at' => $newStatus === 'success' ? now() : $transaction->paid_at,
        ]);

        $statusLabels = [
            'pending' => 'Pending',
            'success' => 'Success',
            'failed' => 'Gagal',
            'cancelled' => 'Dibatalkan',
        ];

        return back()->with('success', "Status transaksi berhasil diubah menjadi {$statusLabels[$newStatus]}!");
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(Transaction $transaction)
    {
        $orderId = $transaction->order_id;

        // Kembalikan stok jika transaksi yang dihapus berstatus success
        if ($transaction->status === 'success' && $transaction->product) {
            $transaction->product->increment('stok', 1);
        }

        $transaction->delete();

        return back()->with('success', "Transaksi {$orderId} berhasil dihapus!");
    }
}
