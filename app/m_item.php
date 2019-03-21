<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Response;
use Datatables;
use Session;

class m_item extends Model {
    protected $table = 'm_item';
    protected $primaryKey = 'i_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getSatuan1()
    {
      return $this->belongsTo('App\m_satuan', 'i_sat1', 's_id');
    }
    public function getSatuan2()
    {
      return $this->belongsTo('App\m_satuan', 'i_sat2', 's_id');
    }
    public function getSatuan3()
    {
      return $this->belongsTo('App\m_satuan', 'i_sat3', 's_id');
    }
}
