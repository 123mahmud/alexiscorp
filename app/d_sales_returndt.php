<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class d_sales_returndt extends Model
{
  protected $table = 'd_sales_returndt';
  const CREATED_AT = 'dsrdt_created';
  const UPDATED_AT = 'dsrdt_updated';

  protected function setKeysForSaveQuery(Builder $query)
  {
    $query
      ->where('dsrdt_idsr', '=', $this->getAttribute('dsrdt_idsr'))
      ->where('dsrdt_smdt', '=', $this->getAttribute('dsrdt_smdt'));
    return $query;
  }

}
