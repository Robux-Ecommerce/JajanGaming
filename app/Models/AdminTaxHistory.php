<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminTaxHistory extends Model
{
    protected $table = 'admin_tax_histories';
    
    protected $fillable = [
        'transaction_id',
        'order_id',
        'amount',
        'tax_rate',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_rate' => 'decimal:3',
    ];

    // Relationships
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
