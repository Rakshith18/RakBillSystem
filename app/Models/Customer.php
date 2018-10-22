<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['customer_name', 'customer_address'];

     public function sale()
    {
        return $this->hasMany('App\Models\Sale');
    }
    public function salescart()
    {
        return $this->hasMany('App\Models\Salescart');
    }
}
