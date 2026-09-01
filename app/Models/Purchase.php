<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_id',
        'referance_no',
        'paid_amount',
        'due_amount',
        'date',
        'grand_subtotal',
        'return_adjustment_amount',
        'attach_document',
        'purchase_payable_amount',
        'supplier_id',
        'user_id'
    ];

    // One Purchase has many PurchaseOrderDetails
    public function orderDetails()
    {
        return $this->hasMany(PurchaseOrderDetails::class, 'purchase_id');
    }
   

    // One Purchase belongs to one Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // App/Models/Purchase.php

        public function paymentDetails()
        {
            return $this->hasMany(PurchasePaymentDetails::class, 'purchases_id');
        }

}
