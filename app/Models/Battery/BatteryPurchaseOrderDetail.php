<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryPurchaseOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'battery_purchase_order_details';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'cost_price',
        'subtotal',
        'user_id'
    ];

    public function purchase()
    {
        return $this->belongsTo(BatteryPurchase::class, 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(BatteryProduct::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
