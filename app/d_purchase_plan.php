<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class d_purchase_plan extends Model
{  
    protected $table = 'd_purchase_plan';
    protected $primaryKey = 'p_id';
    const CREATED_AT = 'p_created';
    const UPDATED_AT = 'p_updated';
    
     protected $fillable = ['p_id',
                            'p_date',
                            'p_code',
                            'p_supplier',
                            'p_position',
                            'p_mem',
                            'p_confirm',
                            'p_status',
                            'p_status_date',
                            'p_comp',
                            'p_gudang'
                          ];

}
	
	