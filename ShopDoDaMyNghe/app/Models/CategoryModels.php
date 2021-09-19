<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModels extends Model
{
    // use HasFactory;
	public $timestamps = false;
    protected $fillable = [
    	'category_name', 'category_image','category_slug','meta_cate_keywords', 'category_desc','category_status'
    ];
    protected $primaryKey = 'category_id';
 	protected $table = 'tbl_category_product';

 	public function product(){
 		return $this->hasMany('App\Models\ProductModels');
 	}
}
