<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryPurchase extends Model
{
    use HasFactory;

    protected $table = 'battery_purchases';

    protected $fillable = [
        'purchase_id',
        'purchase_payable_amount',
        'paid_amount',
        'due_amount',
        'delivery_charge',
        'discount_amount',
        'return_adjustment_amount',
        'referance_no',
        'date',
        'grand_subtotal',
        'attach_document',
        'supplier_id',
        'user_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(BatterySupplier::class, 'supplier_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(BatteryPurchaseOrderDetail::class, 'purchase_id');
    }

    public function paymentDetails()
    {
        return $this->hasMany(BatteryPurchasePaymentDetail::class, 'purchases_id');
    }

    public function purchaseReturns()
    {
        return $this->hasMany(BatteryPurchaseReturn::class, 'purchase_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
