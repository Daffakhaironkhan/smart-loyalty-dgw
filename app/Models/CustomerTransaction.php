<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'store_id',
        'customer_id',
        'transaction_date',
        'total_amount',
        'total_customer_points',
        'proof_image',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(CustomerTransactionItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
