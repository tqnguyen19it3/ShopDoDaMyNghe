<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModels extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_name', 'product_slug','category_id','product_cost','product_price','product_image','product_quantity','product_sold','meta_product_keywords','product_desc','product_content','product_status','product_views'
    ];
    protected $primaryKey = 'product_id';
 	protected $table = 'tbl_product';

 	public function category(){
 		return $this->belongsTo('App\Models\CategoryModels','category_id');
 	}
}
