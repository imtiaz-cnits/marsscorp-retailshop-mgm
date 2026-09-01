<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'order_no',
        'sub_total',
        'return_adjustment_amount',
        'discount_amount',
        'paid_amount',
        'order_note',
        'due_amount',
        'previous_due_amount',
        'invoice_date',
        'user_id'
    ];
public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}

     public function details()
     {
         return $this->hasMany(OrderDetails::class, 'order_id', 'id');
     }
     public function payment()
     {
         return $this->hasOne(OrderPaymentDetails::class, 'order_id', 'id');
     }
     public function productReturns()
    {
        return $this->hasMany(ProductReturn::class, 'order_id', 'id');
    }

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
