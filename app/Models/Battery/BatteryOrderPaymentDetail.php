<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryOrderPaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'battery_order_payment_details';

    protected $fillable = [
        'order_id',
        'paid_amount',
        'discount_amount',
        'transaction_id',
        'payment_method',
        'due_collection_date',
        'payment_status',
        'user_id'
    ];

    public function order()
    {
        return $this->belongsTo(BatteryOrder::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
