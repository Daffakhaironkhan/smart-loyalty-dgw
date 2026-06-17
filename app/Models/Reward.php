<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'reward_code',
        'reward_name',
        'description',
        'image',
        'required_points',
        'stock',
        'redeemable_by',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function redemptions()
    {
        return $this->hasMany(RewardRedemption::class);
    }
}
