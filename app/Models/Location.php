<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'user_id',
    ];


    public function customers()
    {
        return $this->hasMany(Customer::class, 'location', 'id'); // 'location' is the foreign key in the Customer model
    }


}
