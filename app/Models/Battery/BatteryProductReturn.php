<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryProductReturn extends Model
{
    use HasFactory;

    protected $table = 'battery_product_returns';

    protected $fillable = [
        'return_number',
        'order_id',
        'order_detail_id',
        'product_id',
        'quantity',
        'unit_price',
        'amount',
        'discount_amount',
        'due_amount',
        'date',
        'customer_id',
        'user_id'
    ];

    public function order()
    {
        return $this->belongsTo(BatteryOrder::class, 'order_id');
    }

    public function orderDetail()
    {
        return $this->belongsTo(BatteryOrderDetail::class, 'order_detail_id');
    }

    public function customer()
    {
        return $this->belongsTo(BatteryCustomer::class, 'customer_id');
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
