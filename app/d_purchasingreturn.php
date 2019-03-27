<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchasingreturn extends Model
{
    protected $table = 'd_purchasingreturn';
    protected $primaryKey = 'd_pcsr_id';
    const CREATED_AT = 'd_pcsr_created';
    const UPDATED_AT = 'd_pcsr_updated';
    
    protected $fillable = [
        'd_pcsr_id', 
        'd_pcsr_pcsid', 
        'd_pcsr_supid',
        'd_pcsr_comp',
        'd_pcsr_code',
        'd_pcsr_method',
        'd_pcs_staff',
        'd_pcsr_datecreated',
        'd_pcsr_dateupdated',
        'd_pcsr_dateconfirm',
        'd_pcsr_datereceived',
        'd_pcsr_pricetotal',
        'd_pcsr_priceresult',
        'd_pcsr_status',
        'd_pcsr_created',
        'd_pcsr_updated'
    ];
}
