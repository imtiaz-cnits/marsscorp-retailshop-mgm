<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryOrder extends Model
{
    use HasFactory;

    protected $table = 'battery_orders';

    protected $fillable = [
        'order_no',
        'sub_total',
        'delivery_charge',
        'paid_amount',
        'discount_amount',
        'due_amount',
        'previous_due_amount',
        'return_adjustment_amount',
        'order_note',
        'customer_id',
        'invoice_date',
        'user_id'
    ];

    public function customer()
    {
        return $this->belongsTo(BatteryCustomer::class, 'customer_id');
    }

    public function details()
    {
        return $this->hasMany(BatteryOrderDetail::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(BatteryOrderPaymentDetail::class, 'order_id');
    }

    public function paymentDetails()
    {
        return $this->hasMany(BatteryOrderPaymentDetail::class, 'order_id');
    }

    public function productReturns()
    {
        return $this->hasMany(BatteryProductReturn::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
