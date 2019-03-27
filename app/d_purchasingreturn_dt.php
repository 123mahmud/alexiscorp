<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchasingreturn_dt extends Model
{
    protected $table = 'd_purchasingreturn_dt';
    protected $primaryKey = 'd_pcsrdt_id';
    const CREATED_AT = 'd_pcsrdt_created';
    const UPDATED_AT = 'd_pcsrdt_updated';

    protected $fillable = [
        'd_pcsrdt_id',
        'd_pcsrdt_idpcsr',
        'd_pcsrdt_item',
        'd_pcsrdt_sat',
        'd_pcsrdt_qty',
        'd_pcsrdt_qtyconfirm',
        'd_pcsrdt_price',
        'd_pcsrdt_pricetotal',
        'd_pcsrdt_isconfirm',
        'd_pcsrdt_isreceived',
        'd_pcsrdt_created',
        'd_pcsrdt_updated'
    ];
}
