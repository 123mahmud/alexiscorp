<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_dt extends Model
{
  protected $table = 'd_sales_dt';
  public $timestamps = false;

  protected function setKeysForSaveQuery(Builder $query)
  {
    $query
      ->where('sd_sales', '=', $this->getAttribute('sd_sales'))
      ->where('sd_detailid', '=', $this->getAttribute('sd_detailid'));
    return $query;
  }
}
