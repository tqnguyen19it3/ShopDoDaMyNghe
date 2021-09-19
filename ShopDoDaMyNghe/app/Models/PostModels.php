<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModels extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
    	'post_name', 'post_slug','category_post_id','post_image','meta_post_keywords','post_desc','post_content','post_views','post_status','created_at'
    ];
    protected $primaryKey = 'post_id';
 	protected $table = 'tbl_post';
}
