<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class   CustomerPaymentDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'paid_amount',
        'discount_amount',
        'due_amount',
        'due_collection_date',
        'payment_method',
        'payment_status',
        'transaction_id',
        'previous_due_amount',
        'customer_id', // relation with customer table
        'user_id'
    ];
     // Define the inverse relationship
     public function customer()
     {
         return $this->belongsTo(Customer::class, 'customer_id', 'id'); // Linking the foreign key with local key
     }
}
