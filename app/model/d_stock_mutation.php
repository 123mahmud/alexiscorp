<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;


use DB;

use Auth;

use Session;


class d_stock_mutation extends Model
{  



    protected $table = 'd_stock_mutation';
    const CREATED_AT = 'sm_insert';
    const UPDATED_AT = 'sm_update';

}
	
	