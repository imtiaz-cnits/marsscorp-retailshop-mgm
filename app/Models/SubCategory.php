<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_name',
        'category_id',
        'status',
        'user_id'
    ];


       // Relationship with Category
       public function category()
       {
           return $this->belongsTo(Category::class, 'category_id');
       }

       // Relationship with Product
       public function products()
       {
           return $this->hasMany(Product::class, 'sub_category_id');
       }

}
