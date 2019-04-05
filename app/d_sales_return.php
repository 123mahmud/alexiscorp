<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_return extends Model
{
    protected $table = 'd_sales_return';
    protected $primaryKey = 'dsr_id';
    const CREATED_AT = 'dsr_created';
    const UPDATED_AT = 'dsr_updated';

    public function getSalesRetDt()
    {
      return $this->hasMany('App\d_sales_returndt', 'dsrdt_idsr', 'dsr_id');
    }
    public function getCustomer()
    {
      return $this->belongsTo('App\m_customer', 'dsr_cus', 'c_id');
    }


}
