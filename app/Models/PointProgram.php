<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointProgram extends Model
{
    protected $fillable = [
        'program_name',
        'description',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];

    public function rules()
    {
        return $this->hasMany(PointRule::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
