<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'purchase_id',
        'quantity',
        'cost_price',
        'subtotal',
        'user_id'
    ];

     // Each PurchaseOrderDetails belongs to one Purchase
// Each PurchaseOrderDetails belongs to one Purchase
public function purchase()
{
    return $this->belongsTo(Purchase::class, 'purchase_id');
}

// Each PurchaseOrderDetails belongs to one Product
public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
     // Each PurchaseOrderDetails has many PaymentDetails
     public function paymentDetails()
     {
         return $this->hasMany(PurchasePaymentDetails::class, 'purchase_order_details_id');
     }

}
