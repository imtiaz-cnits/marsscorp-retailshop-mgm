<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterySubCategory extends Model
{
    use HasFactory;

    protected $table = 'battery_sub_categories';

    protected $fillable = [
        'name',
        'category_id',
        'user_id'
    ];

    protected $appends = [
        'sub_category_name'
    ];

    public function getSubCategoryNameAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function category()
    {
        return $this->belongsTo(BatteryCategory::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(BatteryProduct::class, 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
