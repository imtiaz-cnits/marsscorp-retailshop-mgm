<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
        'door_side',
        'sub_category_id',
        'unit_id',
        'user_id'
    ];
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relationship with SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }


    public function buyers()
    {
        return $this->hasMany(BuyerInfo::class, 'product_id');
    }

    // Relationship with OrderDetails
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'product_id');
    }

    public function purchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetails::class, 'product_id');
    }
}
