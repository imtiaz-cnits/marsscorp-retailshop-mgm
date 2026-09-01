<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpeningBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'date',
        'note',
        'user_id'
    ];

   
    protected $casts = [
        'amount' => 'decimal:2',
        'date'   => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}