<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_return extends Model
{
    protected $table = 'd_sales_return';
    protected $primaryKey = 'dsr_id';
    const CREATED_AT = 'dsr_created';
    const UPDATED_AT = 'dsr_updated';

}
