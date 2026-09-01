<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'address_details',
        'date',
        'mobile',
        'email',
        'img_url',
        'nid',
        'previous_due_amount',
        'location_id',
        'district_id',
        'user_id'
    ];

    public function paymentDetails()
    {
        return $this->hasMany(CustomerPaymentDetails::class, 'customer_id', 'id'); // Ensure matching foreign key and local key
    }

 public function orders()
 {
     return $this->hasMany(Order::class, 'customer_id', 'id');  // Match 'orders.customer_id' with 'customers.id'
 }

 public function locationDetails()
 {
     return $this->belongsTo(Location::class, 'location_id', 'id');
 }

 public function productReturns()
    {
        return $this->hasMany(ProductReturn::class, 'customer_id', 'id');
    }

}


