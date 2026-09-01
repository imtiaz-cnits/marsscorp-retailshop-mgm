<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorInfo extends Model
{

    use HasFactory;
    protected $fillable = [
        'investor_id',
        'name',
        'mobile',
        'address',
        'email',
        'status',
        'user_id'
    ];

    public function invests()
    {
        return $this->hasMany(Invest::class, 'investor_info_id', 'id');
    }
}






