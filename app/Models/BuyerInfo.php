<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerInfo extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'img',
        'nid_no',
        'dob',
        'product_id',
        'user_id'
    ];
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

}
