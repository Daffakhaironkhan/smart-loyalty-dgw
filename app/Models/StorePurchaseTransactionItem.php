<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorePurchaseTransactionItem extends Model
{
    protected $fillable = [
        'store_purchase_transaction_id',
        'product_id',
        'point_rule_id',
        'quantity',
        'price',
        'subtotal',
        'store_points',
    ];

    public function transaction()
    {
        return $this->belongsTo(StorePurchaseTransaction::class, 'store_purchase_transaction_id');
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
