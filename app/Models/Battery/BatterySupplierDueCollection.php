<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterySupplierDueCollection extends Model
{
    use HasFactory;

    protected $table = 'battery_supplier_due_collections';

    protected $fillable = [
        'paid_amount',
        'discount_amount',
        'due_amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'supplier_id',
        'user_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(BatterySupplier::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
