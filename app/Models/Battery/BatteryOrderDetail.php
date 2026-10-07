<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'battery_order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'selling_price',
        'user_id'
    ];

    public function order()
    {
        return $this->belongsTo(BatteryOrder::class, 'order_id');
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
