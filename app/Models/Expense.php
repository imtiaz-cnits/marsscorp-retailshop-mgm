<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'expense_type_id',
        'staff_id',
        'expense_amount',
        'expense_details',
        'date',
        'user_id'
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
