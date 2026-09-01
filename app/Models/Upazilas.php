<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upazilas extends Model
{
    use HasFactory;
    protected $fillable = [
        'upazila_name',
        'status',
        'district_id',
        'user_id'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function thanas()
    {
        return $this->hasMany(Thana::class, 'upazila_id');
    }
}
