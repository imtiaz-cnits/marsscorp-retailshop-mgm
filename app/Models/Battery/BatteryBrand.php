<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryBrand extends Model
{
    use HasFactory;

    protected $table = 'battery_brands';

    protected $fillable = [
        'name',
        'img_url',
        'user_id'
    ];

    public function products()
    {
        return $this->hasMany(BatteryProduct::class, 'brand_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
