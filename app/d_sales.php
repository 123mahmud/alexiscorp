<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales extends Model
{
    protected $table = 'd_sales';
    protected $primaryKey = 's_id';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';

    public function getSalesDt()
    {
      return $this->hasMany('App\d_sales_dt', 'sd_sales', 's_id');
    }
    public function getCustomer()
    {
      return $this->belongsTo('App\m_customer', 's_customer', 'c_id');
    }
    public function getStaff()
    {
      return $this->belongsTo('App\mMember', 's_staff', 'm_id');
    }
    public function getSalesPayment()
    {
      return $this->hasOne('App\d_sales_payment', 'sp_sales', 's_id');
    }

}
