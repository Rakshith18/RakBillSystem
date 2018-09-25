<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salescart extends Model
{
    protected $fillable = ['product_id','sale_quantity','tax_amt', 'price', 'customer_name','customer_address','seller_name','sales_date', 'sales_status','created_at', 'updated_at'];
}
