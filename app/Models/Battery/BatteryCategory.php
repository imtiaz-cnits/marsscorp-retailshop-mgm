<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryCategory extends Model
{
    use HasFactory;

    protected $table = 'battery_categories';

    protected $fillable = [
        'name',
        'img_url',
        'user_id'
    ];

    protected $appends = [
        'category_name',
        'status'
    ];

    public function getCategoryNameAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'] ?? 'Active';
    }

    public function products()
    {
        return $this->hasMany(BatteryProduct::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(BatterySubCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
