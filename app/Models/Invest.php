<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invest extends Model
{
    use HasFactory;
    protected $fillable = [
        'invest_amount',
        'invest_details',
        'date',
        'investor_info_id',
        'user_id'
    ];

    public function investor_infos()
    {
        return $this->belongsTo(InvestorInfo::class, 'investor_info_id', 'id');
    }
}
