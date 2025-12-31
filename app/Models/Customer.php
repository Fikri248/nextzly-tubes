<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Get all transactions for the customer.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get total spent by customer.
     */
    public function getTotalSpentAttribute()
    {
        return $this->transactions()->where('status', 'paid')->sum('total_harga');
    }

    /**
     * Get total transactions count.
     */
    public function getTransactionCountAttribute()
    {
        return $this->transactions()->count();
    }
}
