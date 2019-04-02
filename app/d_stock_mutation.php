<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class d_stock_mutation extends Model
{
  protected $table = 'd_stock_mutation';
    protected $primaryKey = ['sm_stock','sm_detailid'];
    protected $fillable = ['sm_stock' ,
              'sm_detailid' ,
              'sm_date' ,
              'sm_comp' ,
              'sm_position',
              'sm_qty_sisa',
              'sm_mutcat' ,
              'sm_item' ,
              'sm_qty' ,
              'sm_qty_used' ,
              'sm_qty_sisa',
              'sm_qty_expired' ,
              'sm_detail' ,
              'sm_stockreff' ,
              'sm_detailreff' ,
              'sm_keterangan',
              'sm_hpp' ,
              'sm_reff' ,
              'sm_insert' ,
              'sm_update'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'sm_insert';
    const UPDATED_AT = 'sm_update';
}
