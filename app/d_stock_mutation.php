<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class d_stock_mutation extends Model
{
  protected $table = 'd_stock_mutation';
  const CREATED_AT = 'sm_insert';
  const UPDATED_AT = 'sm_update';

  protected function setKeysForSaveQuery(Builder $query)
  {
    $query
      ->where('sm_stock', '=', $this->getAttribute('sm_stock'))
      ->where('sm_detailid', '=', $this->getAttribute('sm_detailid'));
    return $query;
  }

  public function getGudangCabang()
  {
    return $this->belongsTo('App\d_gudangcabang', 'sm_comp', 'gc_id');
  }
  public function getStock()
  {
    return $this->belongsTo('App\d_stock', 'sm_stock', 's_id');
  }
  // public function getStockMutcat()
  // {
  //   return $this->belongsTo('App\d_stock_mutcat', 'sm_mutcat', 'smc_id');
  // }

}
