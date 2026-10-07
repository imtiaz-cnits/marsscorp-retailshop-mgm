<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterySupplier extends Model
{
    use HasFactory;

    protected $table = 'battery_suppliers';

    protected $fillable = [
        'supplier_id',
        'name',
        'company',
        'mobile',
        'address',
        'img_url',
        'purchase_payable_amount',
        'user_id'
    ];

    public function purchases()
    {
        return $this->hasMany(BatteryPurchase::class, 'supplier_id');
    }

    public function dueCollections()
    {
        return $this->hasMany(BatterySupplierDueCollection::class, 'supplier_id');
    }

    public function purchaseReturns()
    {
        return $this->hasMany(BatteryPurchaseReturn::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
