<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_category_id',
        'product_code',
        'product_name',
        'description',
        'price',
        'base_customer_point',
        'base_store_point',
        'stock',
        'image',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function customerTransactionItems()
    {
        return $this->hasMany(CustomerTransactionItem::class);
    }

    public function storePurchaseTransactionItems()
    {
        return $this->hasMany(StorePurchaseTransactionItem::class);
    }
}
