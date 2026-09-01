<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchasePaymentDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchases_id',
        'paid_amount',
        'discount_amount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'purchase_due_collection_date',
        'purchase_order_details_id',
        'user_id'
    ];

    // 1. Relationship with PurchaseOrderDetails (Already exists)
    public function orderDetails()
    {
        return $this->belongsTo(PurchaseOrderDetails::class, 'purchase_order_details_id');
    }

    // 2. ✅ NEW: Relationship with the main Purchase model
    // Assuming your Purchase model class is named 'Purchase'
    public function purchase() 
    {
        // We use 'purchases_id' as the foreign key because that's what's defined in $fillable
        return $this->belongsTo(Purchase::class, 'purchases_id'); 
    }
}