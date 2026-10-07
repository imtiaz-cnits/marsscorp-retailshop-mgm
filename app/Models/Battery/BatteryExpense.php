<?php

namespace App\Models\Battery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryExpense extends Model
{
    use HasFactory;

    protected $table = 'battery_expenses';

    protected $fillable = [
        'expense_type_id',
        'expense_amount',
        'expense_details',
        'date',
        'user_id',
        'staff_id'
    ];

    public function expenseType()
    {
        return $this->belongsTo(BatteryExpenseType::class, 'expense_type_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
