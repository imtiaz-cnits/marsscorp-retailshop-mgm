<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryUnit extends Model
{
    use HasFactory;

    protected $table = 'battery_units';

    protected $fillable = [
        'unit_name',
        'user_id'
    ];

    public function products()
    {
        return $this->hasMany(BatteryProduct::class, 'unit_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
