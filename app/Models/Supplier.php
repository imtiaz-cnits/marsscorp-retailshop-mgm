<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_id',
        'name',
        'company',
        'mobile',
        'address',
        'email',
        'img_url',
        'purchase_payable_amount',
        'status',
        'user_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'suppliers_id');
    }

        // A Supplier has many Purchases
        public function purchases()
        {
            return $this->hasMany(Purchase::class, 'supplier_id');
        }

// Supplier Model
public function supplierDueCollections()
{
    return $this->hasMany(SupplierDueCollection::class, 'supplier_id', 'id');
}

public function purchasePaymentDetails()
{
    return $this->hasManyThrough(
        PurchasePaymentDetails::class,
        PurchaseOrderDetails::class,
        'purchase_id',           // Foreign key on purchase_order_details table...
        'purchase_order_details_id',  // Foreign key on purchase_payment_details table...
        'id',                    // Local key on suppliers table...
        'id'                     // Local key on purchase_order_details table...
    )->join('purchases', 'purchases.id', '=', 'purchase_order_details.purchase_id')
     ->where('purchases.supplier_id', $this->id);
}


}
