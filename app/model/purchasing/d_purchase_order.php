<?php

namespace App\model\purchasing;

use Illuminate\Database\Eloquent\Model;


use DB;

use Auth;

use Session;


class d_purchase_order extends Model
{  



    protected $table = 'd_purchase_order';
    protected $primaryKey = 'po_id';
    const CREATED_AT = 'po_created';
    const UPDATED_AT = 'po_updated';

}
	
	