<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderdetailsModels extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'order_code', 'product_id', 'product_name','product_price','product_sales_quantity','product_coupon'
    ];
    protected $primaryKey = 'order_details_id';
 	protected $table = 'tbl_order_details';

 	public function product(){
 		return $this->belongsTo('App\Models\ProductModels','product_id');
 	}
}
