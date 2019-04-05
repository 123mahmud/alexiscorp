<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_terima_pembelian_dt extends Model
{
    protected $table = 'd_terima_pembelian_dt';
    protected $primaryKey = 'd_tbdt_id';
    const CREATED_AT = 'd_tbdt_created';
    const UPDATED_AT = 'd_tbdt_updated';
    
    protected $fillable = [
        'd_tbdt_id',
        'd_tbdt_idtb', 
        'd_tbdt_smdetail', 
        'd_tbdt_item',
        'd_tbdt_sat',
        'd_tbdt_idpcsdt',
        'd_tbdt_qty',
        'd_tbdt_price',
        'd_tbdt_pricetotal',
        'd_tbdt_date_received',
        'd_tbdt_created',
        'd_tbdt_updated'
    ];
}
