<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thana extends Model
{
    use HasFactory;
    protected $fillable = [
        'Thana_name',
        'status',
        'district_id',
        'upazila_id',
        'user_id'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /**
     * Relationship with Upazila model.
     */
    public function upazila()
    {
        return $this->belongsTo(Upazilas::class, 'upazila_id');
    }


}
