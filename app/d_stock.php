<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_stock extends Model
{
    protected $table = 'd_stock';
    protected $primaryKey = 's_id';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';

    
}
