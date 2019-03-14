<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use App\model\purchasing\d_purchase_return;
use App\model\purchasing\d_purchase_return_dt;
use App\model\purchasing\d_purchase_order;
use App\model\purchasing\d_purchase_order_dt;
use App\model\purchasing\d_purchase_plan;
use App\model\purchasing\d_purchase_plan_dt;
use App\model\master\m_item;
use App\model\master\m_supplier;

use App\Lib\mutation;

use DB;
use Response;

class ReturnPembelianController extends Controller
{
    public function returnpembelian()
    {
      return view('purchasing/returnpembelian/returnpembelian');
    }
    
    public function tambah_returnpembelian()
    {
      return view('purchasing/returnpembelian/tambah_returnpembelian');
    }

    public function edit_returnpembelian($id)
    {
      $d_purchase_return = d_purchase_return::leftJoin('m_supplier', 'pr_supplier', '=', 's_id')->leftJoin('users', 'pr_officer', '=', 'id')->leftJoin('d_purchase_order', 'pr_purchase_order', '=', 'po_id');
      $d_purchase_return = $d_purchase_return->where('pr_id', $id)->select('pr_id','pr_status', 'pr_pricetotal', 'po_total_gross', 'po_method','po_total_net', 'po_tax_percent', 'po_disc_percent', 'po_disc_value','po_tax_percent', DB::raw("CONCAT('Rp ', FORMAT(pr_pricetotal, 0)) AS pr_pricetotal_label"), 'pr_method', 'pr_officer', 'pr_code', 'po_code', 'pr_supplier', 's_name', 'name',  DB::raw("DATE_FORMAT(pr_tanggal, '%d-%m-%Y') AS pr_tanggal_label"), DB::raw("CASE pr_status WHEN 'WT' THEN 'Waiting' WHEN 'AP' THEN 'Disetujui' WHEN 'NA' THEN 'Tidak Disetujui' END AS pr_status_label"))->first();
      // die($d_purchase_return);
      $d_purchase_return_dt = d_purchase_return_dt::leftJoin('m_item', 'prdt_item', '=', 'i_id')->leftJoin('m_satuan', 'prdt_satuan', '=', 's_id');
      $d_purchase_return_dt = $d_purchase_return_dt->where('prdt_purchase_return', $id)->select('prdt_item', 'prdt_satuan', 'prdt_qtybeli','prdt_qtyreturn', 'prdt_price', 's_id', 's_name', 'i_id', 'i_code', 'i_name', DB::raw("IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS stock"))->get();

      $res = [
        "purchase_return" => $d_purchase_return,
        "purchase_return_dt" => $d_purchase_return_dt
      ];
      return view('purchasing/returnpembelian/edit_returnpembelian', $res);
    }

    public function preview_returnpembelian($id)
    {
      $d_purchase_return = d_purchase_return::leftJoin('m_supplier', 'pr_supplier', '=', 's_id')->leftJoin('users', 'pr_officer', '=', 'id')->leftJoin('d_purchase_order', 'pr_purchase_order', '=', 'po_id');
      $d_purchase_return = $d_purchase_return->where('pr_id', $id)->select('pr_id','pr_status', 'pr_pricetotal', 'po_total_gross', 'po_method','po_total_net', 'po_tax_percent', 'po_disc_percent', 'po_disc_value','po_tax_percent', DB::raw("CONCAT('Rp ', FORMAT(pr_pricetotal, 0)) AS pr_pricetotal_label"), 'pr_method', 'pr_officer', 'pr_code', 'po_code', 'pr_supplier', 's_name', 'name',  DB::raw("DATE_FORMAT(pr_tanggal, '%d-%m-%Y') AS pr_tanggal_label"), DB::raw("CASE pr_status WHEN 'WT' THEN 'Waiting' WHEN 'AP' THEN 'Disetujui' WHEN 'NA' THEN 'Tidak Disetujui' END AS pr_status_label"))->first();
      // die($d_purchase_return);
      $d_purchase_return_dt = d_purchase_return_dt::leftJoin('m_item', 'prdt_item', '=', 'i_id')->leftJoin('m_satuan', 'prdt_satuan', '=', 's_id');
      $d_purchase_return_dt = $d_purchase_return_dt->where('prdt_purchase_return', $id)->select('prdt_item', 'prdt_satuan', 'prdt_qtybeli','prdt_qtyreturn', 'prdt_price', 's_id', 's_name', 'i_id', 'i_code', 'i_name', DB::raw("IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS stock"))->get();

      $res = [
        "purchase_return" => $d_purchase_return,
        "purchase_return_dt" => $d_purchase_return_dt
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

    function find_d_purchase_order(Request $req) {

       $data = array();
       $rows = d_purchase_order::leftJoin('m_supplier', 'po_supplier', '=', 's_id')->leftJoin('users', 'po_officer', '=', 'id')->join('d_purchase_return', 'po_id', '=', 'pr_purchase_order');

       // Filter berdasarkan tanggal dan keyword
       $po_status = $req->po_status;
       $po_status = $po_status != null ? $po_status : '';
       $keyword = $req->keyword;
       $keyword = $keyword != null ? $keyword : '';
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_akhir);
        $rows = $rows->whereBetween('po_tanggal', array($tgl_awal, $tgl_akhir));
       }

       if($keyword != '') {
        $rows = $rows->where('po_code', 'LIKE', DB::raw("'%$keyword%'"));

       }
       if($po_status != '') {
        $rows = $rows->where('po_status', $po_status);
       }

       // Filter untuk datatable
       $search = $req->search;
       $search = $search != null ? $search['value'] : '';
       $start = $req->start;
       $start = $start != null ? $start : 0;
       $length = $req->length;
       $length = $length != null ? $length : 10;
       if($search != '') {
        $rows = $rows->where('po_code', 'LIKE', DB::raw("'%$search%'"))->orWhere('s_name', 'LIKE', DB::raw("'%$search%'"))->orWhere('name', 'LIKE', DB::raw("'%$search%'"));
       }
       $rows = $rows->skip($start)->take($length);

       $rows = $rows->select('po_id','po_status', 'po_total_net', DB::raw("CONCAT('Rp ', FORMAT(po_total_net, 0)) AS po_total_net_label"), 'po_method', 'po_officer', 'po_code', 'po_supplier', 's_name', 'name', DB::raw("DATE_FORMAT(po_tanggal_kirim, '%d-%m-%Y') AS po_tanggal_kirim_label"), DB::raw("DATE_FORMAT(po_tanggal, '%d-%m-%Y') AS po_tanggal_label"), DB::raw("CASE po_status WHEN 'WT' THEN 'Waiting' WHEN 'AP' THEN 'Disetujui' WHEN 'NA' THEN 'Tidak Disetujui' END AS po_status_label"))->groupBy('po_id')->get();
       

       $draw = $req->draw;
       $draw = $draw != null ? $draw : 1;
       $recordsTotal = d_purchase_order::join('d_purchase_return', 'po_id', '=', 'pr_purchase_order')->count('po_id');
       $recordsFiltered = count($rows);
       $res = [
          'data' => $rows,
          'recordsTotal' => $recordsTotal,
          'recordsFiltered' => $recordsFiltered,
          'draw' => $draw,
       ];
       return response()->json($res);
    }

    public function preview_orderpembelian($id)
    {
      $d_purchase_order = d_purchase_order::leftJoin('m_supplier', 'po_supplier', '=', 's_id')->leftJoin('users', 'po_officer', '=', 'id');
      $d_purchase_order = $d_purchase_order->where('po_id', $id)->first();
      $d_purchase_order_dt = d_purchase_order_dt::leftJoin('m_item', 'podt_item', '=', 'i_id')->leftJoin('m_satuan', 'podt_satuan', '=', 's_id');
      $d_purchase_order_dt = $d_purchase_order_dt->leftJoin('d_purchase_order', 'po_id', '=', 'podt_purchase_order')->leftJoin('d_purchase_return', 'pr_purchase_order', '=', 'po_id')->leftJoin('d_purchase_return_dt', 'prdt_purchase_return', '=', 'pr_id');

      $d_purchase_order_dt = $d_purchase_order_dt->groupBy('podt_item');

      $d_purchase_order_dt = $d_purchase_order_dt->where('podt_purchase_order', $id)->select('podt_item', 'podt_prev_price','podt_price', 'podt_satuan', 'podt_qty', 's_id', 's_name', 'i_id', 'i_code', 'i_name', DB::raw("IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS stock"), DB::raw("SUM(prdt_qtyreturn) AS amount_qtyreturn"), DB::raw("podt_qty - SUM(prdt_qtyreturn) AS qtysisa"))->get();

      $res = [
        "purchase_order" => $d_purchase_order,
        "purchase_order_dt" => $d_purchase_order_dt
      ];


      return response()->json($res);
    }

    function find_d_purchase_return_dt(Request $req) {
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';

       $tgl_awal = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_awal);
      $tgl_akhir = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_akhir);

       DB::enableQueryLog();
      $d_purchase_return_dt = d_purchase_return_dt::leftJoin('m_item', 'prdt_item', '=', 'i_id')->leftJoin('m_satuan', 'prdt_satuan', '=', DB::raw('m_satuan.s_id'))->leftJoin('d_purchase_return', 'prdt_purchase_return', '=', 'pr_id')->leftJoin('m_supplier', 'pr_supplier', '=', DB::raw('m_supplier.s_id'));  
      $d_purchase_return_dt = $d_purchase_return_dt->whereBetween('pr_tanggal', [$tgl_awal, $tgl_akhir]);
      $d_purchase_return_dt = $d_purchase_return_dt->select(DB::raw("DATE_FORMAT(pr_tanggal, '%d-%m-%Y') AS pr_tanggal_label"), 'pr_code', DB::raw('m_satuan.s_name AS satuan_name'),DB::raw('m_supplier.s_name AS supplier_name'), 'prdt_item','prdt_qty','prdt_price','prdt_satuan','i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'), DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();
      // print_r(DB::getQueryLog());

       $res = array('data' => $d_purchase_return_dt);
       return response()->json($res);
    }
   
    function find_d_purchase_return(Request $req) {

       $data = array();
       $rows = d_purchase_return::leftJoin('m_supplier', 'pr_supplier', '=', 's_id')->leftJoin('users', 'pr_officer', '=', 'id')->orderBy('pr_tanggal', 'DESC');

       // Filter berdasarkan tanggal dan keyword
       $pr_status = $req->pr_status;
       $pr_status = $pr_status != null ? $pr_status : '';
       $keyword = $req->keyword;
       $keyword = $keyword != null ? $keyword : '';
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_akhir);
        $rows = $rows->whereBetween('pr_tanggal', array($tgl_awal, $tgl_akhir));
       }

       if($keyword != '') {
        $rows = $rows->where('pr_code', 'LIKE', DB::raw("'%$keyword%'"));

       }
       if($pr_status != '') {
        $rows = $rows->where('pr_status', $pr_status);
       }

        // Filter untuk datatable
       $search = $req->search;
       $search = $search != null ? $search['value'] : '';
       $start = $req->start;
       $start = $start != null ? $start : 0;
       $length = $req->length;
       $length = $length != null ? $length : 10;
       if($search != '') {
        $rows = $rows->where('pr_code', 'LIKE', DB::raw("'%$search%'"))->orWhere('s_name', 'LIKE', DB::raw("'%$search%'"))->orWhere('name', 'LIKE', DB::raw("'%$search%'"));
       }
       $rows = $rows->skip($start)->take($length);

       $rows = $rows->select('pr_id','pr_status', 'pr_pricetotal', DB::raw('CONCAT("Rp ", FORMAT(pr_pricetotal, 0)) AS pr_pricetotal_label'), 'pr_officer', 'pr_code', 'pr_supplier', 's_name', 'name', DB::raw("DATE_FORMAT(pr_tanggal, '%d-%m-%Y') AS pr_tanggal_label"), DB::raw("CASE pr_status WHEN 'WT' THEN 'Waiting' WHEN 'AP' THEN 'Disetujui' WHEN 'NA' THEN 'Tidak Disetujui' END AS pr_status_label"), DB::raw("CASE pr_method WHEN 'TB' THEN 'Tukar Barang' WHEN 'PN' THEN 'Potong Nota' END AS pr_method_label"), 'pr_method')->get();
       

       $draw = $req->draw;
       $draw = $draw != null ? $draw : 1;
       $recordsTotal = d_purchase_return::count('pr_id');
       $recordsFiltered = count($rows);
       $res = [
          'data' => $rows,
          'recordsTotal' => $recordsTotal,
          'recordsFiltered' => $recordsFiltered,
          'draw' => $draw,
       ];
       return response()->json($res);
    }

    function delete_d_purchase_return($pr_id) {
      
      if($pr_id != '') {
        
        DB::beginTransaction();
        try {
          $d_purchase_return = d_purchase_return::where('pr_id', $pr_id);
          $d_purchase_return->delete();
          $d_purchase_return_dt = d_purchase_return_dt::where('prdt_purchase_return', $pr_id)->delete();

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


   function insert_d_purchase_return(Request $request){
      $pr_tanggal = $request->pr_tanggal;
      $pr_tanggal = $pr_tanggal != null ? $pr_tanggal : '';
      $pr_tanggal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $pr_tanggal);

      $pr_purchase_order = $request->pr_purchase_order;
      $pr_purchase_order = $pr_purchase_order != null ? $pr_purchase_order : 0;
      $pr_method = $request->pr_method;
      $pr_method = $pr_method != null ? $pr_method : '';
      $pr_officer = $request->pr_officer;
      $pr_officer = $pr_officer != null ? $pr_officer : '';
      $pr_pricetotal = $request->pr_pricetotal;
      $pr_pricetotal = $pr_pricetotal != null ? $pr_pricetotal : '';
      $pr_pricetotal = preg_replace('/\D/', '', $pr_pricetotal);
      $pr_cabang = 1;
      $init = d_purchase_order::where('po_id', $pr_purchase_order)->first();
      $pr_supplier = $init->po_supplier;
      DB::beginTransaction();
      try {

        $init = d_purchase_return::select(DB::raw('IFNULL(MAX(pr_id), 0) + 1 AS pr_id'))->first();
        $pr_id = $init->pr_id;
        // membuat kode purchase return
        $firstdate = date('Y-m-01', strtotime($pr_tanggal));
        $enddate = date('Y-m-31', strtotime($pr_tanggal));
        $init2nd = d_purchase_return::select( DB::raw('IFNULL(MAX(pr_id), 0) + 1 AS return_number') )->whereBetween('pr_tanggal', [$firstdate, $enddate])->first();
        $return_number = $init2nd->return_number; 
        $pr_code = DB::raw("(SELECT CONCAT('PR/', DATE_FORMAT('$pr_tanggal', '%m%y'), '/', LPAD($return_number, 4, '0')))");
        $grand_total = 0;
        
        $d_purchase_return_dt = new d_purchase_return_dt();

        $prdt_item = $request->prdt_item;
        $prdt_item = $prdt_item != null ? $prdt_item : array();
        if( count($prdt_item) > 0 ) {
            $prdt_qtybeli = $request->prdt_qtybeli;
            $prdt_qtybeli = $prdt_qtybeli != null ? $prdt_qtybeli : array();
            $prdt_qtyreturn = $request->prdt_qtyreturn;
            $prdt_qtyreturn = $prdt_qtyreturn != null ? $prdt_qtyreturn : array();
            $prdt_price = $request->prdt_price;
            $prdt_price = $prdt_price != null ? $prdt_price : array();
            $prdt_satuan = $request->prdt_satuan;
            $prdt_satuan = $prdt_satuan != null ? $prdt_satuan : array();

            $units = [];
            for($x = 0; $x < count($prdt_item);$x++) {
                $price = $prdt_price[$x];
                $price = preg_replace('/\D/', '', $price);
                $pricetotal = $prdt_qtyreturn[$x] * $price;
                $unit = [
                  'prdt_detailid' => $x + 1,
                  'prdt_purchase_return' => $pr_id,
                  'prdt_item' => $prdt_item[$x],
                  'prdt_qtyreturn' => $prdt_qtyreturn[$x],
                  'prdt_qtybeli' => $prdt_qtybeli[$x],
                  'prdt_price' => $price,
                  'prdt_pricetotal' => $pricetotal,
                  'prdt_satuan' => $prdt_satuan[$x]
                ];
                array_push($units, $unit);
            }

            d_purchase_return_dt::insert($units);            
        }

        d_purchase_return::insert([
          'pr_code' => $pr_code,
          'pr_officer' => $pr_officer,
          'pr_id' => $pr_id,
          'pr_purchase_order' => $pr_purchase_order,
          'pr_method' => $pr_method,
          'pr_tanggal' => $pr_tanggal,
          'pr_supplier' => $pr_supplier,
          'pr_pricetotal' => $pr_pricetotal,
          'pr_status' => 'WT'
        ]);

        d_purchase_plan::where('pp_id', $pr_purchase_order)->update([
          'pp_status_po' => 'A'
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
    
    function update_d_purchase_return(Request $request){
      $pr_id = $request->pr_id;
      $pr_id = $pr_id != null ? $pr_id : '';  

      $pr_pricetotal = $request->pr_pricetotal;
      $pr_pricetotal = $pr_pricetotal != null ? $pr_pricetotal : 0;
      $pr_pricetotal = preg_replace('/\D/', '', $pr_pricetotal);

      if($pr_id != '') {
        DB::beginTransaction();
        try {

          d_purchase_return::where('pr_id', $pr_id)->update([
              'pr_pricetotal'=> $pr_pricetotal
          ]);

          d_purchase_return_dt::where('prdt_purchase_return', $pr_id)->delete();

          $prdt_item = $request->prdt_item;
          $prdt_item = $prdt_item != null ? $prdt_item : array();
          if( count($prdt_item) > 0 ) {

              $prdt_qtybeli = $request->prdt_qtybeli;
              $prdt_qtybeli = $prdt_qtybeli != null ? $prdt_qtybeli : array();
              $prdt_qtyreturn = $request->prdt_qtyreturn;
              $prdt_qtyreturn = $prdt_qtyreturn != null ? $prdt_qtyreturn : array();
              $prdt_satuan = $request->prdt_satuan;
              $prdt_satuan = $prdt_satuan != null ? $prdt_satuan : array();

              $prdt_price = $request->prdt_price;
              $prdt_price = $prdt_price != null ? $prdt_price : array();

            $units = [];
            for($x = 0; $x < count($prdt_item);$x++) {
                $price = $prdt_price[$x];
                $price = preg_replace('/\D/', '', $price);
                $pricetotal = $prdt_qtyreturn[$x] * $price;
                $unit = [
                  'prdt_detailid' => $x + 1,
                  'prdt_purchase_return' => $pr_id,
                  'prdt_item' => $prdt_item[$x],
                  'prdt_qtybeli' => $prdt_qtybeli[$x],
                  'prdt_qtyreturn' => $prdt_qtyreturn[$x],
                  'prdt_price' => $price,
                  'prdt_pricetotal' => $pricetotal,
                  'prdt_satuan' => $prdt_satuan[$x]
                ];
                array_push($units, $unit);
            }

            d_purchase_return_dt::insert($units);          }

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

    function approve_d_purchase_return(Request $request){
      $pr_id = $request->pr_id;
      $pr_id = $pr_id != null ? $pr_id : '';  

      if($pr_id != '') {
        DB::beginTransaction();
        try {

          $pr_status = $request->pr_status;
          $pr_status = $pr_status != null ? $pr_status : '';
         
          d_purchase_return::where('pr_id', $pr_id)->update([
            'pr_status' => $pr_status,
            'pr_tanggal_approve' => date('Y-m-d')
          ]);

          if($pr_status == 'AP') {
            $purchase_return_dt = d_purchase_return_dt::leftJoin('d_purchase_return', 'prdt_purchase_return', '=', 'pr_id')->where('prdt_purchase_return', $pr_id)->get();
            $pr_method = $purchase_return_dt[0]->pr_method;
            if($pr_method == 'PN') {

              foreach ($purchase_return_dt as $unit) {
                mutation::mutasiTransaksiOne(
                    $unit->pr_tanggal,
                    $unit->prdt_item,
                    $unit->prdt_qtyreturn,        
                    '',
                    '2',
                    $unit->pr_code,
                    "Pengurangan Stok Dari Return Pembelian"        
                    
                );
              }
            }
            else if($pr_method == 'TB') {
              
              foreach ($purchase_return_dt as $unit) {
                mutation::mutasiTransaksiOne(
                    $unit->pr_tanggal,
                    $unit->prdt_item,
                    $unit->prdt_qtyreturn,        
                    '',
                    '2',
                    $unit->pr_code,
                    "Pengurangan Stok Dari Return Pembelian"        
                    
                );
                mutation::mutasiMasuk(
                    $unit->pr_tanggal,
                    $unit->prdt_item,
                    $unit->prdt_qtyreturn,        
                    '',
                    '3',
                    $unit->pr_code,
                    0,
                    0                    
                );
              }
            }
          }

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
