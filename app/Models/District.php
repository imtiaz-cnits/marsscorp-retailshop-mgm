<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'district_name',
        'status',
        'user_id'
    ];
    public function upazilas()
    {
        return $this->hasMany(Upazilas::class, 'district_id', 'id');
    }

    public function thanas()
    {
        return $this->hasMany(Thana::class, 'district_id');
    }

}
