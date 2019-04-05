<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_terima_pembelian extends Model
{
    protected $table = 'd_terima_pembelian';
    protected $primaryKey = 'd_tb_id';
    const CREATED_AT = 'd_tb_created';
    const UPDATED_AT = 'd_tb_updated';
    
    protected $fillable = [
        'd_tb_id', 
        'd_tb_pid', 
        'd_tb_sup',
        'd_tb_code',
        'd_tb_staff',
        'd_tb_noreff',
        'd_tb_totalnett',
        'd_tb_totalbyr',
        'd_tb_date',
        'd_tb_datepaid',
        'd_tb_duedate',
        'd_tb_created',
        'd_tb_updated'
    ];
}
