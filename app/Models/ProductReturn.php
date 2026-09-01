<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'amount',
        'discount_amount',
        'due_amount',
        'date',
        'customer_id',
        'user_id'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); // Added relationship to track returned product
    }

}
