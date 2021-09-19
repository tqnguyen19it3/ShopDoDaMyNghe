<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryModels extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
    	'product_id', 'gallery_name','gallery_img'
    ];
    protected $primaryKey = 'gallery_id';
 	protected $table = 'tbl_gallery';
}
