<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModels extends Model
{
    // use HasFactory;
    public $timestamps = false;
    protected $fillable = [
    	'customer_email', 'customer_name','customer_password','customer_phone', 'customer_gender', 'customer_avatar', 
    ];
    protected $primaryKey = 'customer_id';
 	protected $table = 'tbl_customer';
}
