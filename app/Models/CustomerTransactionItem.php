<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTransactionItem extends Model
{
    protected $fillable = [
        'customer_transaction_id',
        'product_id',
        'point_rule_id',
        'quantity',
        'price',
        'subtotal',
        'customer_points',
    ];

    public function transaction()
    {
        return $this->belongsTo(CustomerTransaction::class, 'customer_transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pointRule()
    {
        return $this->belongsTo(PointRule::class);
    }
}
