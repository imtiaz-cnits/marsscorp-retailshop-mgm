<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryProduct extends Model
{
    use HasFactory;

    protected $table = 'battery_products';

    protected $fillable = [
        'img_url',
        'product_name',
        'quantity',
        'cost_price',
        'sell_price',
        'status',
        'product_code',
        'brand_id',
        'category_id',
        'sub_category_id',
        'unit_id',
        'user_id'
    ];

    protected $casts = [
        'product_code' => 'array',
    ];

    public function unit()
    {
        return $this->belongsTo(BatteryUnit::class, 'unit_id');
    }

    public function brand()
    {
        return $this->belongsTo(BatteryBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(BatteryCategory::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(BatterySubCategory::class, 'sub_category_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(BatteryOrderDetail::class, 'product_id');
    }

    public function purchaseOrderDetails()
    {
        return $this->hasMany(BatteryPurchaseOrderDetail::class, 'product_id');
    }

    public function productReturns()
    {
        return $this->hasMany(BatteryProductReturn::class, 'product_id');
    }

    public function purchaseReturns()
    {
        return $this->hasMany(BatteryPurchaseReturn::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
