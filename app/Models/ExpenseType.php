<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseType extends Model
{

    use HasFactory;
    protected $fillable = [
        'type_name',
        'status',
        'user_id'
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_type_id');
    }
}
