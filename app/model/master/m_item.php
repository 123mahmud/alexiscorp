<?php

namespace App\model\master;

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

    public function find_data($req) {
      $keyword = $req->keyword;
      $keyword = $keyword != null ? $keyword : '';
      $i_type = $req->i_type;
      $i_type = $i_type != null ? $i_type : '';
      $gudang = $req->gudang;
      $gudang = $gudang != null ? $gudang : 1;

      $m_item = $this::take(10);
      if($keyword != '') {
         $m_item = $m_item->where([['i_name', 'LIKE', DB::raw("'%$keyword%'")]]);
      }
      if($i_type != '') {
         $m_item = $m_item->where('i_type', $i_type);
      }


      $m_item = $m_item->select('i_id', 'i_code', 'i_name', 'i_sat1', 'i_sat2', 'i_sat3','i_sat_hrg1', 'i_sat_hrg2', 'i_sat_hrg3', DB::raw("(SELECT s_name FROM m_satuan WHERE s_id = m_item.i_sat1) AS i_sat1_label"),  DB::raw("(SELECT s_name FROM m_satuan WHERE s_id = m_item.i_sat2) AS i_sat2_label"),  DB::raw("(SELECT s_name FROM m_satuan WHERE s_id = m_item.i_sat3) AS i_sat3_label"), DB::raw("IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS stock"), DB::raw("IFNULL((SELECT podt_price FROM d_purchase_order_dt WHERE podt_item = m_item.i_id AND podt_purchase_order = (SELECT MAX(podt_purchase_order) from d_purchase_order_dt WHERE podt_item = m_item.i_id) LIMIT 1), 0) AS prev_price"));

      $res = [
        'data' => $m_item->get()
      ];
      


      return $res;
    }

    public function satuan_terkecil($id_item, $qty_item, $id_satuan) {
      // Function untuk konversi satuan ke satuan terkecil
      $qty_terkecil = 0;
      $m_item = $this::where('i_id', $id_item)->first();
      if( $id_satuan == $m_item->i_sat1 )  {
        $qty_terkecil = $qty_item * $m_item->i_sat_isi1 ;
      }
      else if( $id_satuan == $m_item->i_sat2 )  {
        $qty_terkecil = $qty_item * $m_item->i_sat_isi2 * $m_item->i_sat_isi1;
      }
      else if( $id_satuan == $m_item->i_sat3 )  {
        $qty_terkecil = $qty_item * $m_item->i_sat_isi3 * $m_item->i_sat_isi1;
      }

      return $qty_terkecil;
    }
}
