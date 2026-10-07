<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryOpeningBalance extends Model
{
    use HasFactory;

    protected $table = 'battery_opening_balances';

    protected $fillable = [
        'amount',
        'date',
        'note',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
