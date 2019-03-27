<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

class d_purchasing_dt extends Model {

    protected $table = 'd_purchasing_dt';
    protected $primaryKey = 'd_pcsdt_id';
    protected $fillable = [
					        'd_pcsdt_id',
					        'd_pcs_id',
					        'i_id',
					        'd_pcsdt_sat',
					        'd_pcsdt_idpdt',
					        'd_pcsdt_qty',
					        'd_pcsdt_price',
					        'd_pcsdt_prevcost',
					        'd_pcsdt_total',
					        'd_pcsdt_isconfirm',
					        'd_pcsdt_qtyconfirm',
					        'd_pcsdt_updated'
					    ];
	const CREATED_AT = 'd_pcsdt_created';
    const UPDATED_AT = 'd_pcsdt_updated';

}
