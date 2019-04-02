<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_stock extends Model
{
    protected $table = 'd_stock';
    protected $primaryKey = 's_id';
    protected $fillable = ['s_id',
    						's_comp',
    						's_position', 
    						's_item', 
    						's_qty'];
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';

    
}
