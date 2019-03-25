<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class d_sales_payment extends Model
{
    protected $table = 'd_sales_payment';
    public $timestamps = false;

    protected function setKeysForSaveQuery(Builder $query)
    {
      $query
      ->where('sp_sales', '=', $this->getAttribute('sp_sales'))
      ->where('sp_paymentid', '=', $this->getAttribute('sp_paymentid'));
      return $query;
    }

    public function getSales()
    {
      return $this->belongsTo('App\d_sales', 'sp_sales', 's_id');
    }
}
