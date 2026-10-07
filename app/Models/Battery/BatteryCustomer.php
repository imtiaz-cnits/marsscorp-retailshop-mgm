<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryCustomer extends Model
{
    use HasFactory;

    protected $table = 'battery_customers';

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
        'district_id',
        'upazila_id',
        'thana_id',
        'location_id',
        'user_id'
    ];

    public function orders()
    {
        return $this->hasMany(BatteryOrder::class, 'customer_id');
    }

    public function paymentDetails()
    {
        return $this->hasMany(BatteryCustomerPaymentDetail::class, 'customer_id');
    }

    public function productReturns()
    {
        return $this->hasMany(BatteryProductReturn::class, 'customer_id');
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id');
    }

    public function upazila()
    {
        return $this->belongsTo(\App\Models\Upazilas::class, 'upazila_id');
    }

    public function thana()
    {
        return $this->belongsTo(\App\Models\Thana::class, 'thana_id');
    }

    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
