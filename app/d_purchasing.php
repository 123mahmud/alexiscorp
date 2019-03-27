<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchasing extends Model
{
    protected $table = 'd_purchasing';
    protected $primaryKey = 'd_pcs_id';
    const CREATED_AT = 'd_pcs_created';
    const UPDATED_AT = 'd_pcs_updated';
    
    protected $fillable = [
                            'd_pcs_id', 
                            's_id', 
                            's_pcs_comp',
                            'd_pcs_code',
                            'd_pcs_staff',
                            'd_pcs_method',
                            'd_pcs_total_gross',
                            'd_pcs_disc_percent',
                            'd_pcs_discount',
                            'd_pcs_disc_value',
                            'd_pcs_tax_percent',
                            'd_pcs_tax_value',
                            'd_pcs_total_net',
                            'd_pcs_payment',
                            'd_pcs_sisapayment',
                            'd_pcs_date_created',
                            'd_pcs_date_received',
                            'd_pcs_duedate',
                            'd_pcs_status',
                            'd_pcs_date_confirm'
                        ];
}
