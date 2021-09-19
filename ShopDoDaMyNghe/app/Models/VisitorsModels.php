<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorsModels extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
    	'ip_visitors', 'date_visitors'
    ];
    protected $primaryKey = 'id_visitors';
 	protected $table = 'tbl_visitors';
}
