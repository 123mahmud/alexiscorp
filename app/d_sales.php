<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales extends Model
{
    protected $table = 'd_sales';
    protected $primaryKey = 's_id';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';

}
