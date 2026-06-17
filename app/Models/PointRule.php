<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointRule extends Model
{
    protected $fillable = [
        'point_program_id',
        'product_id',
        'transaction_type',
        'recipient_type',
        'point_per_item',
        'min_quantity',
        'multiplier',
        'status',
    ];

    public function program()
    {
        return $this->belongsTo(PointProgram::class, 'point_program_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
