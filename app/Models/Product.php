<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['productcategory_id', 'name', 'code','measure','quantity', 'stock', 'price',
   'tax', 'status', 'created_by', 'modified_by', 'created_at', 'updated_at'];

}
