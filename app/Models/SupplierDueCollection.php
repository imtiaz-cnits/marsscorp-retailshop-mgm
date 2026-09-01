<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierDueCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'paid_amount',
        'due_amount',
        'discount_amount',
        'payment_method',
        'payment_status',
        'transaction_id',
        'purchase_payable_amount',
        'due_collection_date',
        'supplier_id', // relation with supplier table
        'user_id'
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }



}
