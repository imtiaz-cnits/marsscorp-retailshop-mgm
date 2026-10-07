<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryPurchasePaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'battery_purchase_payment_details';

    protected $fillable = [
        'purchases_id',
        'paid_amount',
        'discount_amount',
        'transaction_id',
        'purchase_due_collection_date',
        'payment_method',
        'payment_status',
        'user_id'
    ];

    public function purchase()
    {
        return $this->belongsTo(BatteryPurchase::class, 'purchases_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
