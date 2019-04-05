<?php

namespace App\Http\Controllers\Keuangan;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_item;
use App\Http\Controllers\Controller;
use Session;
use App\mMember;
use App\d_purchase_plan;
use App\d_purchaseplan_dt;
use App\d_purchase_order;
use App\d_purchaseorder_dt;
use App\d_purchasing;
use Datatables;
use App\d_gudangcabang;
use App\d_purchasing_dt;
use App\d_purchasingreturn;
use App\d_purchasingreturn_dt;

class purchaseConfirmController extends Controller
{

   public function seachItemPurchase(Request $request)
   {
      return   m_item::seachItemPurchase($request);
   }

   public function storePlan(Request $request)
   {
      d_purchase_plan::simpan($request);

   }

   public function confirmIndex()
   {


      return view('Keuangan.konfirmasipembelian.index');
   }

   public function konfirmasiOrder(Request $request,$id,$type){
   // return json_encode('aa');
   // dd($request->all());
   $dataHeader = d_purchase_order::join('m_supplier','po_supplier','=','s_id')
                            ->leftjoin('d_mem','po_mem','=','m_id')
                            ->select(
                                'po_id',
                                'po_code',
                                's_company',
                                'po_date',
                                'po_status',
                                DB::raw('IFNULL(po_date_confirm, "") AS p_confirm'),
                                DB::raw('IFNULL(m_id, "") AS m_id'),
                                DB::raw('IFNULL(m_name, "") AS m_name'))
                            ->where('po_id', '=', $id)
                            ->orderBy('po_date', 'DESC')
                            ->get();
    return $statusLabel = $dataHeader[0]->p_status;
    $dataHeader[0]->p_date=date('d-m-Y',strtotime($dataHeader[0]->p_date));
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
    elseif ($statusLabel == 'CF')
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }
    if ($type == "all")
    {

      $dataIsi = d_purchaseorder_dt::join('m_item','ppdt_item','=','i_id')
                                ->join('m_satuan', 's_id', '=', 'i_satuan')
                                ->leftjoin('d_stock','s_item','=','i_id')
                                ->select('i_id',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         's_name',
                                         'podt_qty',
                                         'podt_qtyconfirm',
                                         DB::raw('IFNULL(s_qty, 0) AS s_qty'),
                                         'podt_prevcost',
                                         'podt_pruchaseplan',
                                          'o4pdt_detailid'
                                )
                                ->where('ppdt_pruchaseplan', '=', $id)
                                ->orderBy('ppdt_created', 'DESC')
                                ->get();

    }
    else
    {

       $dataIsi = d_purchaseorder_dt::join('m_item','ppdt_item','=','i_id')
                                ->join('m_satuan', 's_id', '=', 'i_satuan')
                                ->leftjoin('d_stock','s_item','=','i_id')
                                ->select('i_id',
                                         'm_item.i_code',
                                         'm_item.i_name',
                                         's_name',
                                         'podt_qty',
                                         'podt_qtyconfirm',
                                         's_qty',
                                         'podt_prevcost',
                                         'podt_pruchaseplan',
                                         'po4dt_detailid'
                                )
                                ->where('ppdt_pruchaseplan', '=', $id)
                                ->where('ppdt_isconfirm', '=', "TRUE")
                                ->orderBy('ppdt_created', 'DESC')
                                ->get();


    }

    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
    ]);
      // return d_purchase_plan::konfirmasiOrder($request);
   }

   public function formPlan()
    {
         return view('Purchase::rencanapembelian/create');
    }

    public function rencana()
    {
        return view('/purchasing/rencanapembelian/rencana');
    }

    public function belanja()
    {
        return view('/purchasing/belanjaharian/belanja');
    }

    public function tambah_belanja()
    {
        return view('/purchasing/belanjaharian/tambah_belanja');
    }

    public function pembelian()
    {
        return view('/purchasing/returnpembelian/pembelian');
    }

    public function suplier()
    {
        return view('/purchasing/belanjasuplier/suplier');
    }

    public function langsung()
    {
        return view('/purchasing/belanjalangsung/langsung');
    }

    public function produk()
    {
        return view('/purchasing/belanjaproduk/produk');
    }
    public function pasar()
    {
        return view('/purchasing/belanjapasar/pasar');
    }
    public function create()
    {
        return view('Purchase::rencanapembelian/create');
    }
    public function tambah_pembelian()
    {
        return view('/purchasing/returnpembelian/tambah_pembelian');
    }
    public function tambah_order()
    {

    }
    public function bahan()
    {
        return view('/purchasing/rencanabahanbaku/bahan');
    }

   public function confirmOrderPembelian($id,$type)
   {
   // dd('a');
      $dataHeader = d_purchasing::select('d_pcs_date_created',
                                          'd_pcs_id', 
                                          'd_pcs_duedate', 
                                          'd_pcsp_id',
                                          'd_pcs_code',
                                          's_company',
                                          'd_pcs_staff',
                                          'd_pcs_method',
                                          'd_pcs_total_net',
                                          'd_pcs_date_received',
                                          'd_pcs_status',
                                          'd_mem.m_name',
                                          'd_mem.m_id',
                                          'd_purchasing.s_id as supp_id')
               ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
               ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
               ->where('d_pcs_id', '=', $id)
               ->orderBy('d_pcs_date_created', 'DESC')
               ->get();

      $statusLabel =  $dataHeader[0]->d_pcs_status;
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
         $dataIsi = d_purchasing_dt::select('d_purchasing_dt.*', 'm_item.*', 'm_satuan.*')
            ->join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.s_id')
            ->where('d_purchasing_dt.d_pcs_id', '=', $id)
            ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
            ->get();
      }
      else
      {
         $dataIsi = d_purchasing_dt::select('d_purchasing_dt.*', 'm_item.*', 'm_satuan.*')
            ->join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.s_id')
            ->where('d_purchasing_dt.d_pcs_id', '=', $id)
            ->where('d_purchasing_dt.d_pcsdt_isconfirm', '=', "TRUE")
            ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
            ->get();
      }

      foreach ($dataIsi as $val) 
      {
      //cek item type
         $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
      //get satuan utama
         $sat1[] = $val->i_sat1;
      }
      //variabel untuk count array
      $counter = 0;
      // dd($dataIsi);
      //ambil value stok by item type
      $comp = Session::get('user_comp');
      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
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

//mahmud
  public function getDataRencanaPembelian()
  {
    $data = d_purchase_plan::select('p_id',
                                    'p_code',
                                    's_company',
                                    'p_status',
                                    'p_created',
                                    'p_status_date', 
                                    'd_mem.m_id', 
                                    'd_mem.m_name')
            ->join('m_supplier','m_supplier.s_id','=','d_purchase_plan.p_supplier')
            ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
            ->orderBy('p_created', 'DESC')
            ->get();
    // dd($data);    
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
        return '<span class="label label-success">Finish</span>';
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
            return date('d M Y', strtotime($data->p_created)) . ', ' . date('H:i:s', strtotime($data->p_created));
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
    ->addColumn('action', function($data)
      {
        if ($data->p_status == "WT") 
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiPlanAll("'.$data->p_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>'; 
        }
        else 
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiPlan("'.$data->p_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>'; 
        }
      })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

   public function getDataOrderPembelian()
   {
      $data = d_purchasing::select('d_pcs_date_created',
                                 'd_pcs_id', 
                                 'd_pcsp_id',
                                 'd_pcs_code',
                                 's_company',
                                 'd_pcs_staff',
                                 'd_pcs_method',
                                 'd_pcs_total_net',
                                 'd_pcs_date_received', 
                                 'd_pcs_date_confirm',
                                 'd_pcs_status',
                                 'd_mem.m_id',
                                 'd_mem.m_name')
               ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
               ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
               ->orderBy('d_pcs_date_created', 'DESC')
               ->get();
    //dd($data);    
      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('status', function ($data)
      {
         if ($data->d_pcs_status == "WT") 
         {
            return '<span class="label label-default">Waiting</span>';
         }
         elseif ($data->d_pcs_status == "DE") 
         {
            return '<span class="label label-warning">Dapat diedit</span>';
         }
         elseif ($data->d_pcs_status == "CF") 
         {
            return '<span class="label label-success">Dikonfirmasi</span>';
         }
         elseif ($data->d_pcs_status == "RC") 
         {
            return '<span class="label label-info">Received</span>';
         }
         else
         {
            return '<span class="label label-primary">Revisi</span>';
         }
      })

      ->editColumn('tglOrder', function ($data) 
      {
         if ($data->d_pcs_date_created == null) 
         {
            return '-';
         }
         else 
         {
            return $data->d_pcs_date_created ? with(new Carbon($data->d_pcs_date_created))->format('d M Y') : '';
         }
      })
      ->editColumn('tglConfirm', function ($data) 
      {
         if ($data->d_pcs_date_confirm == null) 
         {
            return '-';
         }
         else 
         {
            return $data->d_pcs_date_confirm ? with(new Carbon($data->d_pcs_date_confirm))->format('d M Y') : '';
         }
      })

      ->editColumn('hargaTotalNet', function ($data) 
      {
         return '<div>Rp.
                   <span class="pull-right">
                     '.number_format($data->d_pcs_total_net,2,",",".").'
                   </span>
                 </div>';
      })

      ->addColumn('action', function($data)
      {
         if ($data->d_pcs_status == "WT") 
         {
           return '<div class="text-center">
                     <button class="btn btn-sm btn-primary" title="Ubah Status"
                         onclick=konfirmasiOrder("'.$data->d_pcs_id.'","all")><i class="fa fa-check"></i>
                     </button>
                 </div>'; 
         }
         else 
         {
           return '<div class="text-center">
                     <button class="btn btn-sm btn-primary" title="Ubah Status"
                         onclick=konfirmasiOrder("'.$data->d_pcs_id.'","confirmed")><i class="fa fa-check"></i>
                     </button>
                 </div>'; 
         }
      })
      ->rawColumns(['status', 'action', 'hargaTotalNet'])
      ->make(true);
   }

   public function confirmRencanaPembelian($id,$type)
   {
      $dataHeader = d_purchase_plan::select('p_id',
                                             'p_code',
                                             's_company',
                                             'p_created', 
                                             'p_status',
                                             'p_status_date', 
                                             'd_mem.m_id', 
                                             'd_mem.m_name')
                        ->join('m_supplier','d_purchase_plan.p_supplier','=','m_supplier.s_id')
                        ->join('d_mem','d_purchase_plan.p_mem','=','d_mem.m_id')
                        ->where('p_id', '=', $id)
                        ->orderBy('p_created', 'DESC')
                        ->get();

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
         $dataIsi = d_purchaseplan_dt::select('ppdt_pruchaseplan',
                                             'ppdt_item',
                                             'm_item.i_code',
                                             'm_item.i_sat1',
                                             'm_item.i_name',
                                             'm_satuan.s_name',
                                             'm_satuan.s_id',
                                             'd_purchaseplan_dt.ppdt_qty',
                                             'd_purchaseplan_dt.ppdt_prevcost',
                                             'd_purchaseplan_dt.ppdt_qtyconfirm')
                                 ->join('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
                                 ->join('m_item', 'd_purchaseplan_dt.ppdt_item', '=', 'm_item.i_id')
                                 ->join('m_satuan', 'd_purchaseplan_dt.ppdt_satuan', '=', 'm_satuan.s_id')
                                 ->where('d_purchaseplan_dt.ppdt_pruchaseplan', '=', $id)
                                 ->orderBy('d_purchaseplan_dt.ppdt_created', 'DESC')
                                 ->get();
      }
      else
      {
         $dataIsi = d_purchaseplan_dt::select('d_purchaseplan_dt.ppdt_pruchaseplan',
                                             'd_purchaseplan_dt.ppdt_item',
                                             'm_item.i_code',
                                             'm_item.i_sat1',
                                             'm_item.i_name',
                                             'm_satuan.s_name',
                                             'm_satuan.s_id',
                                             'd_purchaseplan_dt.ppdt_qty',
                                             'd_purchaseplan_dt.ppdt_prevcost',
                                             'd_purchaseplan_dt.ppdt_qtyconfirm')
                              ->join('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
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

      return Response()->json([
         'status' => 'sukses',
         'header' => $dataHeader,
         'data_isi' => $dataIsi,
         'data_stok' => $dataStok['val_stok'],
         'data_satuan' => $dataStok['txt_satuan'],
         'spanTxt' => $spanTxt,
         'spanClass' => $spanClass,
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
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id' AND s_position = '$gc_id' limit 1) ,'0') as qtyStok"));
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
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id' AND s_position = '$gc_id' limit 1) ,'0') as qtyStok"));
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
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id' AND s_position = '$gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
   }

   public function submitRencanaPembelian(Request $request)
   {
    DB::beginTransaction();
    try {
      //update table d_purchasingplan
      $plan = d_purchase_plan::find($request->idPlan);
      if ($request->statusConfirm != "WT") 
      {
         $plan->p_status_date = date('Y-m-d',strtotime(Carbon::now()));
         $plan->p_status = $request->statusConfirm;
         $plan->p_updated = Carbon::now();
         $plan->save();

         //update table d_purchasingplan_dt
         $hitung_field = count($request->fieldIdDt);
         for ($i=0; $i < $hitung_field; $i++) 
         {
             $plandt = d_purchaseplan_dt::find($request->fieldIdDt[$i]);
             $plandt->ppdt_qtyconfirm = str_replace('.', '', $request->fieldConfirm[$i]);
             $plandt->ppdt_updated = Carbon::now();
             $plandt->ppdt_isconfirm = "TRUE";
             $plandt->save();
         }
      }
      else
      {
         $plan->p_status_date = null;
         $plan->p_status = $request->statusConfirm;
         $plan->p_updated = Carbon::now();
         $plan->save();

         //update table d_purchasingplan_dt
         $hitung_field = count($request->fieldIdDt);
         for ($i=0; $i < $hitung_field; $i++) 
         {
             $plandt = d_purchaseplan_dt::find($request->fieldIdDt[$i]);
             $plandt->ppdt_qtyconfirm = str_replace('.', '', $request->fieldConfirm[$i]);
             $plandt->ppdt_updated = Carbon::now();
             $plandt->ppdt_isconfirm = "FALSE";
             $plandt->save();
         }
      }

      DB::commit();
      return response()->json([
         'status' => 'sukses',
         'pesan' => 'Data Rencana Order Berhasil Diupdate'
      ]);
      } 
      catch (\Exception $e) 
      {
      DB::rollback();
      return response()->json([
         'status' => 'gagal',
         'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
      ]);
      }
   }

   public function submitOrderPembelian(Request $request)
   { 
      DB::beginTransaction();
      try {
        //update table d_purchasing
        $purchase = d_purchasing::find($request->idOrder);
        if ($request->statusOrderConfirm != "WT") 
        {
            $purchase->d_pcs_date_confirm = date('Y-m-d',strtotime(Carbon::now()));
            $purchase->d_pcs_status = $request->statusOrderConfirm;
            // $purchase->d_pcs_sisapayment = $purchase->d_pcs_total_net;
            $purchase->d_pcs_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasing_dt
            $hitung_field = count($request->fieldConfirmOrder);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasing_dt::find($request->fieldIdDtOrder[$i]);
                $purchasedt->d_pcsdt_qtyconfirm = str_replace('.', '', $request->fieldConfirmOrder[$i]);
                $purchasedt->d_pcsdt_updated = Carbon::now();
                $purchasedt->d_pcsdt_isconfirm = "TRUE";
                $purchasedt->save();
            }
        }
        else
        {   
            $purchase->d_pcs_date_confirm = null;
            $purchase->d_pcs_status = $request->statusOrderConfirm;
            $purchase->d_pcs_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasing_dt
            $hitung_field = count($request->fieldConfirmOrder);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasing_dt::find($request->fieldIdDtOrder[$i]);
                $purchasedt->d_pcsdt_qtyconfirm = str_replace('.', '', $request->fieldConfirmOrder[$i]);
                $purchasedt->d_pcsdt_updated = Carbon::now();
                $purchasedt->d_pcsdt_isconfirm = "FALSE";
                $purchasedt->save();
            }
        }

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Konfirmasi Order Berhasil Diupdate'
        ]);
    } 
    catch (\Exception $e) 
    {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
    }
  }

  public function getDataReturnPembelian()
  {
    $data = d_purchasingreturn::join('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')
                ->join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
                ->join('d_mem','d_purchasingreturn.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasingreturn.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasing.d_pcs_code', 'd_mem.m_name', 'd_mem.m_id')
                ->orderBy('d_pcsr_created', 'DESC')
                ->get();
    //dd($data);    
    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('tglReturn', function ($data) 
    {
      if ($data->d_pcsr_datecreated == null) 
      {
          return '-';
      }
      else 
      {
          return $data->d_pcsr_datecreated ? with(new Carbon($data->d_pcsr_datecreated))->format('d M Y') : '';
      }
    })
    ->editColumn('metode', function ($data) 
    {
      if ($data->d_pcsr_method == 'TK') { return 'Tukar Barang'; } else { return 'Potong Nota'; }
    })
    ->editColumn('hargaTotal', function ($data) 
    {
      return '<div>Rp.
                <span class="pull-right">
                  '.number_format($data->d_pcsr_pricetotal,2,",",".").'
                </span>
              </div>';
    })
    ->editColumn('status', function ($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<span class="label label-default">Waiting</span>';
      }
      elseif ($data->d_pcsr_status == "DE") 
      {
        return '<span class="label label-warning">Dapat diedit</span>';
      }
      elseif ($data->d_pcsr_status == "CF") 
      {
        return '<span class="label label-info">Dikonfirmasi</span>';
      }
      elseif ($data->d_pcsr_status == "RC") 
      {
        return '<span class="label label-success">Diterima</span>';
      }
    })
    ->editColumn('tglConfirm', function ($data) 
    {
      if ($data->d_pcsr_dateconfirm == null) 
      {
          return '-';
      }
      else 
      {
          return $data->d_pcsr_dateconfirm ? with(new Carbon($data->d_pcsr_dateconfirm))->format('d M Y') : '';
      }
    })
    ->addColumn('action', function($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiReturn("'.$data->d_pcsr_id.'","all")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
      else 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiReturn("'.$data->d_pcsr_id.'","confirmed")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
    })
    ->rawColumns(['status', 'action', 'hargaTotal'])
    ->make(true);
  }

  public function confirmReturnPembelian($id,$type)
  {
    $dataHeader = d_purchasingreturn::join('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')
                ->join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
                ->join('d_mem','d_purchasingreturn.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasingreturn.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasing.d_pcs_code', 'd_mem.m_name', 'd_mem.m_id')
                ->where('d_pcsr_id', '=', $id)
                ->orderBy('d_pcsr_created', 'DESC')
                ->get();

    foreach ($dataHeader as $val) 
    {   
      $data = array(
          'hargaTotalReturn' => 'Rp. '.number_format($val->d_pcsr_pricetotal,2,",","."),
          'tanggalReturn' => date('d-m-Y',strtotime($val->d_pcsr_datecreated))
      );
    }

    $statusLabel = $dataHeader[0]->d_pcsr_status;
    if ($statusLabel == "WT") 
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-default';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    elseif ($statusLabel == "CF")
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "RC")
    {
        $spanTxt = 'Di Terima';
        $spanClass = 'label-success';
    }

    if ($type == "all") 
    {
      $dataIsi = d_purchasingreturn_dt::join('m_item', 'd_purchasingreturn_dt.d_pcsrdt_item', '=', 'm_item.i_id')
                ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
                ->join('m_satuan', 'd_purchasingreturn_dt.d_pcsrdt_sat', '=', 'm_satuan.s_id')
                ->select('d_purchasingreturn_dt.*', 'm_item.*', 'd_purchasingreturn.d_pcsr_code', 'd_purchasingreturn.d_pcsr_pcsid', 'm_satuan.*')
                ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
                ->orderBy('d_purchasingreturn_dt.d_pcsrdt_created', 'DESC')
                ->get();
    }
    else
    {
      $dataIsi = d_purchasingreturn_dt::join('m_item', 'd_purchasingreturn_dt.d_pcsrdt_item', '=', 'm_item.i_id')
                ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
                ->join('m_satuan', 'd_purchasingreturn_dt.d_pcsrdt_sat', '=', 'm_satuan.s_id')
                ->select('d_purchasingreturn_dt.*', 'm_item.*', 'd_purchasingreturn.d_pcsr_code', 'd_purchasingreturn.d_pcsr_pcsid', 'm_satuan.*')
                ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
                ->where('d_purchasingreturn_dt.d_pcsrdt_isconfirm', '=', "TRUE")
                ->orderBy('d_purchasingreturn_dt.d_pcsrdt_created', 'DESC')
                ->get();
    }

    foreach ($dataIsi as $val) 
    {
      //get PO qty
      $pcs_id = $val->d_pcsr_pcsid;
      $item_id = $val->d_pcsrdt_item;
      $poQty[] = DB::table('d_purchasing_dt')
                    ->select('d_pcsdt_qty')
                    ->where(function ($query) use ($pcs_id , $item_id) {
                      $query->where('d_pcs_id', '=', $pcs_id);
                      $query->where('i_id', '=', $item_id);
                    })->first();
      //cek item type
      $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
      //get satuan utama
      $sat1[] = $val->i_sat1;
    }

    //variabel untuk count array
    $counter = 0;
    //ambil value stok by item type
    $comp = Session::get('user_comp');
   $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
    
    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'header2' => $data,
        'data_isi' => $dataIsi,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
        'poQty' => $poQty
    ]);
  }

  public function submitReturnPembelian(Request $request)
  {
    //dd($request->all());
    DB::beginTransaction();
    try {
        //update table d_purchasingreturn
        $purchase = d_purchasingreturn::find($request->idReturn);
        if ($request->statusReturnConfirm != "WT") 
        {
            $purchase->d_pcsr_dateconfirm = date('Y-m-d',strtotime(Carbon::now()));
            $purchase->d_pcsr_status = $request->statusReturnConfirm;
            $purchase->d_pcsr_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasingreturn_dt
            $hitung_field = count($request->fieldConfirmReturn);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasingreturn_dt::find($request->fieldIdDtReturn[$i]);
                $purchasedt->d_pcsrdt_qtyconfirm = str_replace('.', '', $request->fieldConfirmReturn[$i]);
                $purchasedt->d_pcsrdt_updated = Carbon::now();
                $purchasedt->d_pcsrdt_isconfirm = "TRUE";
                $purchasedt->save();
            }
        }
        else
        {
            $purchase->d_pcsr_dateconfirm = null;
            $purchase->d_pcsr_status = $request->statusReturnConfirm;
            $purchase->d_pcsr_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasing_dt
            $hitung_field = count($request->fieldConfirmReturn);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasingreturn_dt::find($request->fieldIdDtReturn[$i]);
                $purchasedt->d_pcsrdt_qtyconfirm = str_replace('.', '', $request->fieldConfirmReturn[$i]);
                $purchasedt->d_pcsrdt_updated = Carbon::now();
                $purchasedt->d_pcsrdt_isconfirm = "FALSE";
                $purchasedt->save();
            }
        }

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Konfirmasi Return Berhasil Diupdate'
        ]);
    } 
    catch (\Exception $e) 
    {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
    }
  }

}
