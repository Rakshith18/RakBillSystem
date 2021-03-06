<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['productcategory_id', 'name', 'code','measure','quantity', 'stock', 'buy_price','sell_price',
   'tax', 'status', 'created_by', 'modified_by', 'created_at', 'updated_at'];

   public function sale()
    {
        return $this->belongsToMany('App\Models\Sale');
    }
    public function salescart()
    {
        return $this->belongsToMany('App\Models\Salescart');
    }

}
