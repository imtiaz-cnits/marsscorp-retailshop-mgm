<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryPurchaseReturn extends Model
{
    use HasFactory;

    protected $table = 'battery_purchase_returns';

    protected $fillable = [
        'purchase_id',
        'supplier_id',
        'product_id',
        'quantity',
        'amount',
        'discount_amount',
        'due_amount',
        'date',
        'user_id'
    ];

    public function purchase()
    {
        return $this->belongsTo(BatteryPurchase::class, 'purchase_id');
    }

    public function supplier()
    {
        return $this->belongsTo(BatterySupplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(BatteryProduct::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
