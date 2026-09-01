<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'paid_amount',
        'discount_amount',
        'transaction_id',
        'due_collection_date',
        'payment_method',
        'payment_status',
        'user_id'
    ];    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
