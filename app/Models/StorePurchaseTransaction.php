<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorePurchaseTransaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'store_id',
        'transaction_date',
        'total_amount',
        'total_store_points',
        'proof_image',
        'invoice_number',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(StorePurchaseTransactionItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
