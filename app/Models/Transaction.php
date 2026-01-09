<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'product_id',
        'quantity',
        'total_harga',
        'metode_pembayaran',
        'status',
        'status_note',
        'status_changed_at',
        'catatan',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'status_changed_at' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
