<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryExpenseType extends Model
{
    use HasFactory;

    protected $table = 'battery_expense_types';

    protected $fillable = [
        'type_name',
        'user_id'
    ];

    public function expenses()
    {
        return $this->hasMany(BatteryExpense::class, 'expense_type_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
