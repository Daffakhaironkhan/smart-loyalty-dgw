<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'store_code',
        'store_name',
        'owner_name',
        'phone',
        'email',
        'address',
        'city',
        'area',
        'total_points',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registeredCustomers()
    {
        return $this->hasMany(Customer::class, 'registered_by_store_id');
    }

    public function customerTransactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function purchaseTransactions()
    {
        return $this->hasMany(StorePurchaseTransaction::class);
    }
}
