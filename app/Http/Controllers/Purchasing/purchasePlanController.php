<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;
use App\Http\Controllers\Controller;
use App\mMember;
use App\d_purchase_plan;
use App\d_purchaseplan_dt;
use Datatables;
use Session;
use Response;
use Auth;
use App\d_gudangcabang;
use App\m_supplier;
use Crypt;

class purchasePlanController extends Controller
{ 
   public function planIndex()
   {     

     return view('purchasing.rencanapembelian.rencanapembelian');
   }

   public function seachItemPurchase(Request $request)
   {
   // return json_encode($request->all());
      $term = $request->term;
      $results = array();
      $queries = DB::table('m_item')
        ->select('i_id','i_type','i_sat1','i_sat2','i_sat3','i_code','i_name')
        ->where('i_name', 'LIKE', '%'.$term.'%')
        ->where('i_type', 'BJ')
        ->take(25)->get();

      if ($queries == null) 
      {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } 
      else 
      {
         foreach ($queries as $val) 
         {
            if ($val->i_type == 'BJ') 
            {
               $namaGudang = 'GUDANG PENJUALAN'; 
            }
            else
            {
               $namaGudang = 'GUDANG BAHAN BAKU';
            }
            $gudang = DB::table('d_gudangcabang')
                    ->select('gc_id')
                    ->where('gc_comp',Session::get('user_comp'))
                    ->where('gc_gudang',$namaGudang)
                    ->first();
            //ambil stok berdasarkan type barang
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gudang->gc_id' AND s_position = '$gudang->gc_id' limit 1) ,'0') as qtyStok"));
            $stok = $query[0]->qtyStok;

             //get prev cost
            $idItem = $val->i_id;
            $prevCost = DB::table('d_stock_mutation')
                     // ->select(DB::raw('MAX(sm_hpp) as hargaPrev'))
                  ->select('sm_hpp', 'sm_qty')
                  ->where('sm_item', '=', $idItem)
                  ->where('sm_mutcat', '=', "16")
                  ->orderBy('sm_date', 'desc')
                  ->limit(1)
                  ->first();

            if ($prevCost == null) 
            {
              $default_cost = 0;
              $hargaLalu = $default_cost;
            }
            else
            {
               $hargaLalu = $prevCost->sm_hpp;
            }
             
             //get data txt satuan
            $txtSat1 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat1)->first();
            $txtSat2 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat2)->first();
            $txtSat3 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat3)->first();

             $results[] = [ 'id' => $val->i_id,
                            'label' => $val->i_code .' - '.$val->i_name,
                            'stok' => (int)$stok,
                            'sat' => [$val->i_sat1, $val->i_sat2, $val->i_sat3],
                            'satTxt' => [$txtSat1->s_name, $txtSat2->s_name, $txtSat3->s_name],
                            'prevCost' =>number_format((int)$hargaLalu,2,",",".")
                          ];
        }
      }

      return Response::json($results);
      
   }

   public function tambah_rencanapembelian()
   {
      $supplier = m_supplier::select('s_id','s_code','s_company')->get();
      return view('purchasing.rencanapembelian.tambah_rencanapembelian',compact('supplier'));
   }

   public function storePlan(Request $request)
   {
   // dd($request->all());
   DB::beginTransaction();
   try {
      //kode plan
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(p_code,4)) as kode_max from d_purchase_plan WHERE DATE_FORMAT(p_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));

      $kd = "";

      if(count($query)>0)
      {
        foreach($query as $k)
        {
          $tmp = ((int)$k->kode_max)+1;
          $kd = sprintf("%05s", $tmp);
        }
      }
      else
      {
        $kd = "00001";
      }
      //id plan
      $p_id=d_purchase_plan::max('p_id')+1;
      $p_code = "PO-".date('ym')."-".$kd;
      d_purchase_plan::create([
              'p_id' => $p_id,
              'p_comp' => Session::get('user_comp'),
              'p_mem' => Auth::user()->m_id, 
              'p_code' => $p_code,
              'p_supplier' => $request->id_supplier,
              'p_status' => 'WT',
              'p_created' => Carbon::now()
              
                                   
        ]);
        // dd($request->all());
        for ($i=0; $i <count($request->ppdt_item); $i++) 
        {  
            $detailid=d_purchaseplan_dt::where('ppdt_pruchaseplan',$p_id)->max('ppdt_detailid')+1;
            d_purchaseplan_dt::create([
               'ppdt_pruchaseplan' => $p_id,
               'ppdt_detailid' => $detailid,
               'ppdt_item' => $request->ppdt_item[$i],
               'ppdt_qty' => str_replace('.', '', $request->ppdt_qty[$i]),
               'ppdt_satuan' => $request->ppdt_satuan[$i],
               'ppdt_prevcost' => str_replace('.', '', $request->ppdt_prevcost[$i]),
               'ppdt_isconfirm' => 'FALSE'
            ]);
         }

      DB::commit();
      return response()->json([
          'status' => 'sukses',
          'nota' => $p_code,
      ]);
    } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
      ]);
    }
   }


   public function dataPlan(Request $request)
   {
      $tanggal1 = date('Y-m-d',strtotime($request->tanggal1))." 00:00:00";
      $tanggal2 = date('Y-m-d',strtotime($request->tanggal2))." 23:59:59";

      if ($request->status == 'ALL') 
      {
         $data = d_purchase_plan::select('p_created',
                                       'p_code',
                                       'm_name',
                                       's_company',
                                       'p_status',
                                       'p_status_date',
                                       'p_id'
                                    )
               ->join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
               ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
               ->whereBetween('p_created', [$tanggal1, $tanggal2])
               ->where('p_comp','=',Session::get('user_comp'))
               ->orderBy('p_created', 'DESC')
               ->get();
      }
      else if ($request->status == 'WT') 
      {
         $data = d_purchase_plan::select('p_created',
                                       'p_code',
                                       'm_name',
                                       's_company',
                                       'p_status',
                                       'p_status_date',
                                       'p_id'
                                    )
               ->join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
               ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
               ->whereBetween('p_created', [$tanggal1, $tanggal2])
               ->where('p_comp','=',Session::get('user_comp'))
               ->where('p_status','WT')
               ->orderBy('p_created', 'DESC')
               ->get();
      }
      else
      {
         $data = d_purchase_plan::select('p_created',
                                       'p_code',
                                       'm_name',
                                       's_company',
                                       'p_status',
                                       'p_status_date',
                                       'p_id'
                                    )
               ->join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
               ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
               ->whereBetween('p_created', [$tanggal1, $tanggal2])
               ->where('p_comp','=',Session::get('user_comp'))
               ->where('p_status','AP')
               ->orderBy('p_created', 'DESC')
               ->get();
      }
      
              // dd($data);
      // return $data;
      return DataTables::of($data)
      ->addIndexColumn()

      ->editColumn('status', function ($data)
      {
         if ($data->p_status == "WT") 
         {  
            return '<span class="label label-info">Waiting</span>';
         }
         elseif ($data->p_status == "FN") 
         {
            return '<span class="label label-success">Disetujui</span>';
         }
      })
     
      ->editColumn('tglBuat', function ($data) 
      {
         return date('d M Y', strtotime($data->p_created)) . ', ' . date('H:i:s', strtotime($data->p_created));
      })
      ->addColumn('tglConfirm', function ($data) 
      {
         if ($data->p_status_date == null) 
         {
             return '-';
         }
         else 
         {
             return $data->p_status_date ? with(new Carbon($data->p_status_date))->format('d M Y') : '';
         }
      })

     ->addColumn('aksi', function($data)
      {
         if ($data->p_status == "WT" || $data->p_status == "DE") 
         {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailPlanAll("'.$data->p_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editPlanAll("'.Crypt::encrypt($data->p_id).'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Hapus"
                          onclick=deletePlan("'.$data->p_id.'")><i class="fa fa-times"></i>
                      </button>
                  </div>'; 
         }
         elseif ($data->p_status == "FN") 
         {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailPlanAll("'.$data->p_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                  </div>'; 
         }
      })
      ->rawColumns([ 'tglBuat',
                     'status', 
                     'aksi',
                     'tglConfirm'])
      ->make(true);
   }


   public function getEditPlan(Request $request)
   { 
      $id = Crypt::decrypt($request->id);
      $comp = Session::get('user_comp');
      $gudang = DB::table('d_gudangcabang')
         ->select('gc_id','gc_gudang','c_name')
         ->join('m_comp','m_comp.c_id','=','d_gudangcabang.gc_comp')
         ->where('gc_comp',$comp)
         ->where(function ($query) {
                $query->where('gc_gudang', '=', 'GUDANG PENJUALAN')
                   ->orWhere('gc_gudang', '=', 'GUDANG BAHAN BAKU');
         })->get();

      $supplier = m_supplier::select('s_id','s_company')->get();

      $data_header = d_purchase_plan::join('d_mem','m_id','=','p_mem')
               ->join('m_supplier','p_supplier','=','s_id')
               ->where('p_id', '=', $id)
               ->first();
      $dataIsi = d_purchaseplan_dt::select('i_id',
                                  'm_item.i_code',
                                  'm_item.i_name',
                                  'm_item.i_sat1',
                                  's_name',
                                  'ppdt_qty',
                                  'ppdt_satuan',
                                  'ppdt_qtyconfirm',
                                  'ppdt_pruchaseplan',
                                  'ppdt_detailid',
                                  'ppdt_prevcost',
                                  'ppdt_totalcost')
               ->join('m_item','ppdt_item','=','i_id')
               ->join('m_satuan', 'm_satuan.s_id', '=', 'ppdt_satuan')
               ->join('d_purchase_plan','p_id','=','ppdt_pruchaseplan')
               ->where('ppdt_pruchaseplan', '=', $id)
               ->get();
               // dd($dataIsi);
      foreach ($dataIsi as $val) 
      {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
      }
      //variabel untuk count array
      $counter = 0;

      //ambil value stok by item type
      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
      $dataItem = array( 'data_isi' => $dataIsi, 
                        'data_stok' => $dataStok['val_stok'], 
                        'data_satuan' => $dataStok['txt_satuan']
                  );
 
      return view('purchasing.rencanapembelian.edit_rencanapembelian',compact('data_header','gudang','supplier','dataItem'));
   }


   public function deletePlan($id)
   {     
      DB::beginTransaction();
      try {
         d_purchase_plan::where('p_id',$id)->delete();
         d_purchaseplan_dt::where('ppdt_pruchaseplan',$id)->delete();
      DB::commit();
      return response()->json([
          'status' => 'sukses'
         ]);
       } catch (\Exception $e) {
       DB::rollback();
       return response()->json([
           'status' => 'gagal',
           'data' => $e
         ]);
       }
   }
   public function updatePlan(Request $request)
   {         
      DB::beginTransaction();
      try {
         $id = Crypt::decrypt($request->id);
         d_purchase_plan::where('p_id',$id)->delete();
         d_purchaseplan_dt::where('ppdt_pruchaseplan',$id)->delete();

         d_purchase_plan::create([
                 'p_id' => $id,
                 'p_comp' => Session::get('user_comp'),
                 'p_mem' => Auth::user()->m_id, 
                 'p_code' => $request->nota,
                 'p_supplier' => $request->id_supplier,
                 'p_status' => 'WT',
                 'p_created' => Carbon::now()
         ]);
        // dd($request->all());
        for ($i=0; $i <count($request->ppdt_item); $i++) 
        {  
            $detailid=d_purchaseplan_dt::where('ppdt_pruchaseplan',$id)->max('ppdt_detailid')+1;
            d_purchaseplan_dt::create([
               'ppdt_pruchaseplan' => $id,
               'ppdt_detailid' => $detailid,
               'ppdt_item' => $request->ppdt_item[$i],
               'ppdt_qty' => str_replace('.', '', $request->ppdt_qty[$i]),
               'ppdt_satuan' => $request->ppdt_satuan[$i],
               'ppdt_prevcost' => str_replace('.', '', $request->ppdt_prevcost[$i]),
               'ppdt_isconfirm' => 'FALSE'
            ]);
         }
      DB::commit();
      return response()->json([
          'status' => 'sukses',
          'nota' => $request->nota
         ]);
       } catch (\Exception $e) {
       DB::rollback();
       return response()->json([
           'status' => 'gagal',
           'data' => $e
         ]);
       }

   }
   
   public function getDetailPlan($id,$type)
   {
      $dataHeader = d_purchase_plan::select('p_id',
                                          'p_code',
                                          's_company',
                                          'p_status',
                                          'p_created',
                                          'p_status_date', 
                                          'd_mem.m_id', 
                                          'd_mem.m_name')
         ->join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
         ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
         ->where('p_id', '=', $id)
         ->orderBy('p_created', 'DESC')
         ->get();
         // dd($dataHeader);
      $statusLabel = $dataHeader[0]->p_status;
      if ($statusLabel == "WT") 
      {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
      }
      elseif ($statusLabel == "DE")
      {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
      }
      else
      {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
      }

      if ($type == "all") 
      {
        $dataIsi = d_purchaseplan_dt::select('d_purchaseplan_dt.ppdt_item',
                                             'm_item.i_code',
                                             'm_item.i_name',
                                             'm_item.i_sat1',
                                             'm_satuan.s_name',
                                             'd_purchaseplan_dt.ppdt_qty',
                                             'd_purchaseplan_dt.ppdt_qtyconfirm'
                                             )
            ->join('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
            ->join('m_item', 'd_purchaseplan_dt.ppdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_purchaseplan_dt.ppdt_satuan', '=', 'm_satuan.s_id')
            ->where('d_purchaseplan_dt.ppdt_pruchaseplan', '=', $id)
            ->orderBy('d_purchaseplan_dt.ppdt_created', 'DESC')
            ->get();
      }
      else
      {
         $dataIsi = d_purchasingplan_dt::select('d_purchasingplan_dt.ppdt_item',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         'm_item.i_sat1',
                                         'm_satuan.s_name',
                                         'd_purchasingplan_dt.ppdt_qty',
                                         'd_purchasingplan_dt.d_pcspdt_qtyconfirm'
                                )
            ->join('d_purchase_plan','d_purchasingplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
            ->join('m_item', 'd_purchaseplan_dt.ppdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_purchaseplan_dt.ppdt_satuan', '=', 'm_satuan.s_id')
            ->where('d_purchaseplan_dt.ppdt_pruchaseplan', '=', $id)
            ->where('d_purchaseplan_dt.ppdt_isconfirm', '=', "TRUE")
            ->orderBy('d_purchaseplan_dt.ppdt_created', 'DESC')
            ->get();
      }

      foreach ($dataIsi as $val) 
      {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->ppdt_item)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
      }
      
      //variabel untuk count array
      $counter = 0;

      //ambil value stok by item type
      $comp = Session::get('user_comp');
      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
      //dd($dataStok);
      
      return Response()->json([
          'status' => 'sukses',
          'header' => $dataHeader,
          'data_isi' => $dataIsi,
          'data_stok' => $dataStok['val_stok'],
          'data_satuan' => $dataStok['txt_satuan'],
          'spanTxt' => $spanTxt,
          'spanClass' => $spanClass
      ]);
   }

   public function getStokByType($arrItemType, $arrSatuan, $counter, $comp)
   {
      foreach ($arrItemType as $val) 
      {
         if ($val->i_type == "BJ") //brg jual
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG PENJUALAN')
                  ->where('gc_comp',$comp)
                  ->first();
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
         elseif ($val->i_type == "BB") //bahan baku
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG BAHAN BAKU')
                  ->where('gc_comp',$comp)
                  ->first();
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
         elseif ($val->i_type == "BL") //bahan lain
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG BAHAN BAKU')
                  ->where('gc_comp',$comp)
                  ->first();
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
   }

   public function getDataTabelHistory($tgl1, $tgl2, $tampil)
    {
         $tanggal1 = date('Y-m-d',strtotime($tgl1))." 00:00:00";
         $tanggal2 = date('Y-m-d',strtotime($tgl2))." 23:59:59";

        if ($tampil == 'ALL') 
        { 
            $data = DB::table('d_purchaseplan_dt')
               ->select('d_purchaseplan_dt.*', 
                        'd_purchase_plan.*', 
                        'm_item.i_name', 
                        'm_supplier.s_company', 
                        'm_satuan.s_name')
               ->leftJoin('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
               ->leftJoin('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
               ->leftJoin('m_item','d_purchaseplan_dt.ppdt_item','=','m_item.i_id')
               ->leftJoin('m_satuan','d_purchaseplan_dt.ppdt_satuan','=','m_satuan.s_id')
               ->whereBetween('d_purchase_plan.p_created', [$tanggal1, $tanggal2])
               ->get();
        }
        elseif ($tampil == 'WT') 
        {
            $data = DB::table('d_purchaseplan_dt')
               ->select('d_purchaseplan_dt.*', 
                        'd_purchase_plan.*', 
                        'm_item.i_name', 
                        'm_supplier.s_company', 
                        'm_satuan.s_name')
               ->leftJoin('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
               ->leftJoin('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
               ->leftJoin('m_item','d_purchaseplan_dt.ppdt_item','=','m_item.i_id')
               ->leftJoin('m_satuan','d_purchaseplan_dt.ppdt_satuan','=','m_satuan.s_id')
               ->where('d_purchase_plan.p_status','=',$tampil)
               ->whereBetween('d_purchase_plan.p_created', [$tanggal1, $tanggal2])
               ->get();
        }
        else
        {
            $data = DB::table('d_purchaseplan_dt')
               ->select('d_purchaseplan_dt.*', 
                        'd_purchase_plan.*', 
                        'm_item.i_name', 
                        'm_supplier.s_company', 
                        'm_satuan.s_name')
               ->leftJoin('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
               ->leftJoin('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
               ->leftJoin('m_item','d_purchaseplan_dt.ppdt_item','=','m_item.i_id')
               ->leftJoin('m_satuan','d_purchaseplan_dt.ppdt_satuan','=','m_satuan.s_id')
               ->where('d_purchase_plan.p_status','=',$tampil)
               ->whereBetween('d_purchase_plan.p_created', [$tanggal1, $tanggal2])
               ->get();
        }

        

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
          {
          if ($data->p_status == "WT") 
          {
            return '<span class="label label-info">Waiting</span>';
          }
          elseif ($data->p_status == "DE") 
          {
            return '<span class="label label-warning">Dapat diedit</span>';
          }
          elseif ($data->p_status == "FN") 
          {
            return '<span class="label label-success">Disetujui</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->p_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->p_created ? with(new Carbon($data->p_created))->format('d M Y') : '';
            }
        })
        ->editColumn('tglConfirm', function ($data) 
        {
            if ($data->p_status_date == null) 
            {
                return '-';
            }
            else 
            {
                return $data->p_status_date ? with(new Carbon($data->p_status_date))->format('d M Y') : '';
            }
        })
        ->rawColumns(['status'])
        ->make(true);
    }

}