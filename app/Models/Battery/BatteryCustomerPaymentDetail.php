<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryCustomerPaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'battery_customer_payment_details';

    protected $fillable = [
        'paid_amount',
        'discount_amount',
        'due_amount',
        'previous_due_amount',
        'due_collection_date',
        'payment_method',
        'transaction_id',
        'payment_status',
        'customer_id',
        'user_id'
    ];

    public function customer()
    {
        return $this->belongsTo(BatteryCustomer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
