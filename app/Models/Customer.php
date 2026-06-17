<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'member_code',
        'name',
        'phone',
        'email',
        'address',
        'birth_date',
        'gender',
        'total_points',
        'membership_level',
        'status',
        'registered_by_store_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registeredByStore()
    {
        return $this->belongsTo(Store::class, 'registered_by_store_id');
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }
}
