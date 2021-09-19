<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderModels extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'slider_img','slider_status','slider_desc'
    ];
    protected $primaryKey = 'slider_id';
 	protected $table = 'tbl_slider';
}
