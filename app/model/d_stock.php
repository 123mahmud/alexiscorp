<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;


use DB;

use Auth;

use Session;


class d_stock extends Model
{  



    protected $table = 'd_stock';
    protected $primaryKey = 's_id';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';

}
	
	