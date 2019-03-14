<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use App\model\purchasing\d_purchase_plan;
use App\model\purchasing\d_purchase_plan_dt;
use App\model\master\m_item;
use App\model\master\m_supplier;
use DB;
use Response;

class RencanaPembelianController extends Controller
{
    public function rencanapembelian()
    {
      $amount_waiting = d_purchase_plan::where('pp_status' , 'WT')->count('pp_id');
      $amount_disetujui = d_purchase_plan::where('pp_status' , 'AP')->count('pp_id');

      $res = [
        'amount_waiting' => $amount_waiting,
        'amount_disetujui' => $amount_disetujui
      ];
    	return view('purchasing/rencanapembelian/rencanapembelian', $res);
    }
    public function tambah_rencanapembelian()
    {
      return view('purchasing/rencanapembelian/tambah_rencanapembelian');
    }

    public function preview_rencanapembelian($id)
    {
      $d_purchase_plan = d_purchase_plan::leftJoin('m_supplier', 'pp_supplier', '=', 's_id')->leftJoin('users', 'pp_officer', '=', 'id');
      $d_purchase_plan = $d_purchase_plan->where('pp_id', $id)->get();
      $d_purchase_plan_dt = d_purchase_plan_dt::leftJoin('m_item', 'ppdt_item', '=', 'i_id')->leftJoin('m_satuan', 'ppdt_satuan', '=', 's_id');
      $d_purchase_plan_dt = $d_purchase_plan_dt->where('ppdt_purchase_plan', $id)->select('ppdt_item', 'ppdt_prev_price', 'ppdt_satuan', 'ppdt_qty', 's_id', 's_name', 'i_id', 'i_code','i_sat_hrg1','i_sat_hrg2','i_sat_hrg3', 'i_name', DB::raw("IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS stock"))->get();

      $res = [
        "purchase_plan" => $d_purchase_plan,
        "purchase_plan_dt" => $d_purchase_plan_dt
      ];


    	return response()->json($res);
    }



    public function find_m_item(Request $req) {
      $m_item = new m_item();
      // die('dsa');
      $res = $m_item->find_data($req);
      return response()->json($res);
    }

    public function find_m_supplier(Request $req) {
      $m_supplier = new m_supplier();
      $res = $m_supplier->find_data($req);

      return response()->json($res);
    }

    function find_d_purchase_plan_dt($id) {

      $d_purchase_plan_dt = d_purchase_plan_dt::leftJoin('m_item', 'ppdt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');  
      $d_purchase_plan_dt = $d_purchase_plan_dt->where('ppdt_purchase_plan', $id)->select('s_id', 's_name', 'ppdt_item','ppdt_qty','ppdt_price','ppdt_satuan','i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'), DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

       $res = array('d_purchase_plan_dt' => $d_purchase_plan_dt);
       return response()->json($res);
    }
   
    function find_d_purchase_plan(Request $req) {

       $data = array();
       $rows = d_purchase_plan::leftJoin('m_supplier', 'pp_supplier', '=', 's_id')->leftJoin('users', 'pp_officer', '=', 'id');

       // Filter berdasarkan tanggal dan keyword
       $pp_status = $req->pp_status;
       $pp_status = $pp_status != null ? $pp_status : '';
       $keyword = $req->keyword;
       $keyword = $keyword != null ? $keyword : '';
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';


       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_akhir);
        $rows = $rows->whereBetween('pp_tanggal', array($tgl_awal, $tgl_akhir));
       }

       if($keyword != '') {
        $rows = $rows->where('pp_code', 'LIKE', DB::raw("'%$keyword%'"));

       }
       if($pp_status != '') {
        $rows = $rows->where('pp_status', $pp_status);
       }

       // Filter untuk datatable
       $search = $req->search;
       $search = $search != null ? $search['value'] : '';
       $start = $req->start;
       $start = $start != null ? $start : 0;
       $length = $req->length;
       $length = $length != null ? $length : 10;
       if($search != '') {
        $rows = $rows->where('pp_code', 'LIKE', DB::raw("'%$search%'"))->orWhere('s_name', 'LIKE', DB::raw("'%$search%'"))->orWhere('name', 'LIKE', DB::raw("'%$search%'"));
       }
       $rows = $rows->skip($start)->take($length);

       $rows = $rows->select('pp_id','pp_status', 'pp_officer', 'pp_code', 'pp_supplier','pp_status_po', 's_name', 'name', DB::raw("DATE_FORMAT(pp_tanggal_approve, '%d-%m-%Y') AS pp_tanggal_approve_label"), DB::raw("DATE_FORMAT(pp_tanggal, '%d-%m-%Y') AS pp_tanggal_label"), DB::raw("CASE pp_status WHEN 'WT' THEN 'Waiting' WHEN 'AP' THEN 'Disetujui' WHEN 'NA' THEN 'Tidak Disetujui' END AS pp_status_label"), DB::raw("CASE pp_status_po WHEN 'NA' THEN 'Belum Aktif' WHEN 'A' THEN 'PO Aktif' WHEN 'NAP' THEN 'Tidak Disetujui' END AS pp_status_po_label"))->orderBy('pp_tanggal', 'DESC')->orderBy('pp_code', 'DESC')->get();
       

       $draw = $req->draw;
       $draw = $draw != null ? $draw : 1;
       $recordsTotal = d_purchase_plan::count('pp_id');
       $recordsFiltered = count($rows);
       $res = [
          'data' => $rows,
          'recordsTotal' => $recordsTotal,
          'recordsFiltered' => $recordsFiltered,
          'draw' => $draw,
       ];
       return response()->json($res);
    }

    function delete_d_purchase_plan($pp_id) {
      
      if($pp_id != '') {
        
        DB::beginTransaction();
        try {
          $d_purchase_plan = d_purchase_plan::where('pp_id', $pp_id);
          $d_purchase_plan->delete();
          $d_purchase_plan_dt = d_purchase_plan_dt::where('ppdt_purchase_plan', $pp_id)->delete();

          DB::commit();
          $res = array('status' => 'sukses' );
        }
        catch(\Exception $e) {
          DB::rollback();
          
          $res = array('status' => 'Error. ' . $e);
        }
      }
      else {
        $res = array('status' => 'ID Kosong');
      }

      return response()->json($res);
    }

   function insert_d_purchase_plan(Request $request){
      $pp_tanggal = $request->pp_tanggal;
      $pp_tanggal = $pp_tanggal != null ? $pp_tanggal : '';
      $pp_tanggal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $pp_tanggal);

      $pp_officer = $request->pp_officer;
      $pp_officer = $pp_officer != null ? $pp_officer : '';
      $pp_supplier = $request->pp_supplier;
      $pp_supplier = $pp_supplier != null ? $pp_supplier : '';
      $pp_cabang = 1;
      DB::beginTransaction();
      try {

        $init = d_purchase_plan::select(DB::raw('IFNULL(MAX(pp_id), 0) + 1 AS pp_id'))->first();
        $pp_id = $init->pp_id;
        // membuat kode purchase plan
        $firstdate = date('Y-m-01', strtotime($pp_tanggal));
        $enddate = date('Y-m-31', strtotime($pp_tanggal));
        $init2nd = d_purchase_plan::select( DB::raw('IFNULL(MAX(pp_id), 0) + 1 AS order_number') )->whereBetween('pp_tanggal', [$firstdate, $enddate])->first();
        $order_number = $init2nd->order_number; 
        $pp_code = DB::raw("(SELECT CONCAT('PP/', DATE_FORMAT('$pp_tanggal', '%m%y'), '/', LPAD($order_number, 4, '0')))");
        $grand_total = 0;
        
        $d_purchase_plan_dt = new d_purchase_plan_dt();

        $ppdt_item = $request->ppdt_item;
        $ppdt_item = $ppdt_item != null ? $ppdt_item : array();
        if( count($ppdt_item) > 0 ) {
            $ppdt_qty = $request->ppdt_qty;
            $ppdt_qty = $ppdt_qty != null ? $ppdt_qty : array();
            $ppdt_qty = $request->ppdt_qty;
            $ppdt_qty = $ppdt_qty != null ? $ppdt_qty : array();
            $ppdt_prev_price = $request->ppdt_prev_price;
            $ppdt_prev_price = $ppdt_prev_price != null ? $ppdt_prev_price : array();
            $ppdt_satuan = $request->ppdt_satuan;
            $ppdt_satuan = $ppdt_satuan != null ? $ppdt_satuan : array();

            $units = [];
            for($x = 0; $x < count($ppdt_item);$x++) {
                $prev_price = $ppdt_prev_price[$x];
                $prev_price = preg_replace('/\D/', '', $prev_price);
                $unit = [
                  'ppdt_detailid' => $x + 1,
                  'ppdt_purchase_plan' => $pp_id,
                  'ppdt_item' => $ppdt_item[$x],
                  'ppdt_qty' => $ppdt_qty[$x],
                  'ppdt_prev_price' => $prev_price,
                  'ppdt_satuan' => $ppdt_satuan[$x]
                ];
                array_push($units, $unit);
            }

            d_purchase_plan_dt::insert($units);            
        }

        d_purchase_plan::insert([
          'pp_code' => $pp_code,
          'pp_officer' => $pp_officer,
          'pp_id' => $pp_id,
          'pp_tanggal' => $pp_tanggal,
          'pp_supplier' => $pp_supplier,
          'pp_status' => 'WT'
        ]);



        DB::commit();
        $status = 'sukses';
      }
      catch(\Exception $e) {
        DB::rollback();
        $status = 'gagal. ' . $e;
      }
      $res = array( 'status' => $status);

      return response()->json($res);
    }
    
    function update_d_purchase_plan(Request $request){
      $pp_id = $request->pp_id;
      $pp_id = $pp_id != null ? $pp_id : '';  

      if($pp_id != '') {
        DB::beginTransaction();
        try {

          $ppdt_item = $request->ppdt_item;
          $ppdt_item = $ppdt_item != null ? $ppdt_item : array();
          if( count($ppdt_item) > 0 ) {

              $ppdt_qty = $request->ppdt_qty;
              $ppdt_qty = $ppdt_qty != null ? $ppdt_qty : array();
              // $ppdt_satuan = $request->ppdt_satuan;
              // $ppdt_satuan = $ppdt_satuan != null ? $ppdt_satuan : array();
              // $ppdt_prev_price = $request->ppdt_prev_price;
              // $ppdt_prev_price = $ppdt_prev_price != null ? $ppdt_prev_price : array();

              $units = array();
              for($x = 0; $x < count($ppdt_item);$x++) {
                  d_purchase_plan_dt::where([
                    ['ppdt_purchase_plan', '=', $pp_id],
                    ['ppdt_item', '=', $ppdt_item[$x]]
                  ])
                  ->update([
                      'ppdt_qty' => $ppdt_qty[$x]
                  ]);
              }
          }
          d_purchase_plan_dt::insert($units);

          DB::commit();
          return response()->json(['status' => 'sukses']);
        }
        catch(\Exception $e) {
          DB::rollback();
          return response()->json(['status' => 'Gagal. ' . $e]);
        }  
      }
      else {
        echo 'ID Kosong';
        return false;
      }
      

      return response()->json($res);
    }

    function approve_d_purchase_plan(Request $request){
      $pp_id = $request->pp_id;
      $pp_id = $pp_id != null ? $pp_id : '';  

      if($pp_id != '') {
        DB::beginTransaction();
        try {

          $pp_status = $request->pp_status;
          $pp_status = $pp_status != null ? $pp_status : '';
         
          d_purchase_plan::where('pp_id', $pp_id)->update([
            'pp_status' => $pp_status,
            'pp_tanggal_approve' => date('Y-m-d')
          ]);

          DB::commit();
          return response()->json(['status' => 'sukses']);
        }
        catch(\Exception $e) {
          DB::rollback();
          return response()->json(['status' => 'Gagal. ' . $e]);
        }  
      }
      else {
        $res= [
          'status' => 'gagal.',
          'message' => 'ID Kosong'
        ];
      }
      

      return response()->json($res);
    }
}
