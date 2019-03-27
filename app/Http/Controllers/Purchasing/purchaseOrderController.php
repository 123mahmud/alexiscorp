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
use d_purchase_order;
use d_purchaseorder_dt;
use Response;
use App\m_supplier;
use Datatables;
use Session;
use App\d_gudangcabang;
use App\d_purchasing;
use d_purchasing_dt;

class purchaseOrderController extends Controller
{

   public function orderpembelian()
   {

      return view('purchasing.orderpembelian.orderpembelian');
   }

   public function konvertRp($value)
   {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
   }

   public function seachItemPurchase(Request $request){
         return   m_itemm::seachItemPurchase($request);
   }

   public function simpanOrder(Request $request){
      d_purchase_order::simpanOrder($request);

   }

   public function orderIndex()
   {
      // $tindex =view('Purchase::orderpembelian/tab-index');
      // $history =view('Purchase::orderpembelian/tab-history');
      // /*$to =view('Purchase::orderpembelian/tambah_order');   */

      // $modal =view('Purchase::orderpembelian/modal');
      // $modaledit =view('Purchase::orderpembelian/modal-edit');

      // $modaldetail=view('Purchase::orderpembelian/modal-detail-peritem');
      // $modaldetail_show=view('Purchase::orderpembelian/modal-detail-order');

      return view('purchasing.orderpembelian.orderpembelian',compact('tindex','history','to','modal','modaledit','modaldetail','modaldetail_show'));
   }
   public function dataOrder(Request $request){
      return d_purchase_order::dataOrder($request);
   }
   public function formOrder()
   {
      return view('purchasing.orderpembelian.tambah_orderpembelian');
   }

   public function savePo(Request $request)
   {
      // dd($request->all());
      $totalGross = $this->konvertRp($request->totalGross);
      $replaceCharDisc = (int)str_replace("%","",$request->diskonHarga);
      $replaceCharPPN = (int)str_replace("%","",$request->ppnHarga);
      $diskonPotHarga = $this->konvertRp($request->potonganHarga);
      $discValue = $totalGross * $replaceCharDisc / 100;
      //code
      $p_id=d_purchasing::max('d_pcs_id')+1;
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcs_code,4)) as kode_max from d_purchasing WHERE DATE_FORMAT(d_pcs_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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
      $p_code = "PO-".date('ym')."-".$kd;
      //end code
      $comp = Session::get('user_comp');

      DB::beginTransaction();
      try {
          //insert to table d_purchasing
          $dataHeader = new d_purchasing;
          $dataHeader->d_pcs_id = $p_id;
          $dataHeader->d_pcsp_id = $request->cariKodePlan;
          $dataHeader->s_id = $request->cariSup;
          $dataHeader->p_pcs_comp = $comp;
          $dataHeader->d_pcs_code = $p_code;
          $dataHeader->d_pcs_staff = $request->idStaff;
          $dataHeader->d_pcs_method = $request->methodBayar;
          $dataHeader->d_pcs_total_gross = $totalGross;
          $dataHeader->d_pcs_discount = $diskonPotHarga;
          $dataHeader->d_pcs_disc_percent = $replaceCharDisc;
          $dataHeader->d_pcs_disc_value = $discValue;
          $dataHeader->d_pcs_tax_percent = $replaceCharPPN;
          $dataHeader->d_pcs_duedate = date('Y-m-d',strtotime($request->jatuhTempo));
          $dataHeader->d_pcs_tax_value = ($totalGross - $diskonPotHarga - $discValue) * $replaceCharPPN / 100;
          $dataHeader->d_pcs_total_net = $this->konvertRp($request->totalNett);
          // $dataHeader->d_pcs_sisapayment = $this->konvertRp($request->totalNett);
          $dataHeader->d_pcs_date_created = date('Y-m-d',strtotime($request->tanggal));
          $dataHeader->save(); 
         
        //get last lastId then insert id to d_purchasing_dt
        //variabel untuk hitung array field
        $hitung_field = count($request->fieldItemId);

        //update pada tabel d_purchasingplan_dt column
        for ($i=0; $i < $hitung_field; $i++) 
        { 
          DB::table('d_purchaseplan_dt')
          ->where('ppdt_pruchaseplan', $request->fieldidPlanDt[$i])
          ->update([
               'ppdt_ispo' => 'TRUE'
            ]);
        }

        //insert data isi
        for ($i=0; $i < $hitung_field; $i++) 
        {
          $old_str = [".", ","];
          $new_str = ["", "."];
          $dataIsi = new d_purchasing_dt;
          $dataIsi->d_pcs_id = $p_id;
          $dataIsi->i_id = $request->fieldItemId[$i];
          $dataIsi->d_pcsdt_sid = $request->cariSup;
          $dataIsi->d_pcsdt_sat = $request->fieldIdSatuan[$i];
          $dataIsi->d_pcsdt_idpdt = $request->fieldidPlanDt[$i];
          $dataIsi->d_pcsdt_qty = $request->fieldQty[$i];
          $dataIsi->d_pcsdt_price = str_replace($old_str, $new_str, $request->fieldHarga[$i]);
          $dataIsi->d_pcsdt_prevcost = str_replace($old_str, $new_str, $request->fieldHargaPrev[$i]);
          $dataIsi->d_pcsdt_total = str_replace($old_str, $new_str, $request->fieldHargaTotal[$i]);
          $dataIsi->d_pcsdt_created = Carbon::now();
          $dataIsi->save();
        }
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Order Pembelian Berhasil Disimpan'
        ]);
      } 
      catch (\Exception $e) 
      {
        //dd($e);
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
      }

   }

   public function getDataDetail($id)
    {
        $dataHeader = d_purchasing::select('d_purchasing.*', 
                                          'm_supplier.s_company', 
                                          'm_supplier.s_name',
                                          'd_mem.m_id',
                                          'd_mem.m_name')
               ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
               ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
               ->where('d_pcs_id', '=', $id)
               ->orderBy('d_pcs_date_created', 'DESC')
               ->get();

        $statusLabel = $dataHeader[0]->d_pcs_status;
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
        else
        {
          $spanTxt = 'Barang telah diterima';
          $spanClass = 'label-success';
        }

        foreach ($dataHeader as $val) 
        {
          $data = array(
              'hargaBruto' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
              'nilaiDiskon' => 'Rp. '.number_format($val->d_pcs_discount + $val->d_pcs_disc_value,2,",","."),
              'nilaiPajak' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
              'hargaNet' => 'Rp. '.number_format($val->d_pcs_total_net,2,",",".")
          );
        }

        $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.s_id')
                ->select('d_purchasing_dt.d_pcsdt_id',
                         'd_purchasing_dt.d_pcs_id',
                         'd_purchasing_dt.i_id',
                         'm_item.i_name',
                         'm_item.i_code',
                         'm_item.i_sat1',
                         'm_satuan.s_name',
                         'm_satuan.s_id',
                         'd_purchasing_dt.d_pcsdt_prevcost',
                         'd_purchasing_dt.d_pcsdt_qty',
                         'd_purchasing_dt.d_pcsdt_price',
                         'd_purchasing_dt.d_pcsdt_total'
                )
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get();

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
         $comp = Session::get('user_comp');
         $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'header2' => $data,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
            'spanTxt' => $spanTxt,
            'spanClass' => $spanClass,
        ]);
    }

   public function getDataEdit($id)
   {    
      $dataHeader = d_purchase_order::join('m_supplier','s_id','po_supplier')->where('po_id',$id)->where('po_status','=','WT')->get();

      $dataIsi = d_purchaseorder_dt::join('m_item','i_id','podt_item')
                         ->join('m_satuan','s_id','podt_satuan')
                         ->leftjoin('d_stock','s_item','=','i_id')
                         ->where('podt_purchaseorder',$id)
                         ->orderBy('i_id','ASC')
                         ->get();


      $tamp=[];
      foreach ($dataIsi as $key => $value) {
       $tamp[$key]=$value->podt_item;
      }     
      $urut_index = count($tamp);
      $tamp=array_map("strval",$tamp); 


      return view('Purchase::orderpembelian/edit_order',compact('data','tamp','urut_index','dataIsi','dataHeader'));
   }

   public function updatePo(Request $request)
   {
       // dd($request->all());
      for ($i=0; $i <count($request->id_header_remove) ; $i++) { 
        $delete = DB::table('d_purchaseorder_dt')
                            ->where('podt_detailid',$request->id_detail_remove[$i])
                            ->where('podt_purchaseorder',$request->id_header_remove[$i])
                            ->delete();
      }
      for ($i=0; $i <count($request->podt_purchaseorder) ; $i++) { 
        $update = DB::table('d_purchaseorder_dt')
                            ->where('podt_detailid',$request->podt_detailid[$i])
                            ->where('podt_purchaseorder',$request->podt_purchaseorder[$i])
                            ->update([
                                'podt_qtysend'=>$request->fieldQtyconfirm[$i],
                                'podt_qty'=>$request->fieldQtyconfirm[$i],
                                'podt_price'=>$request->podt_price[$i],
                                'podt_total'=>$request->podt_total[$i],
                            ]);
      }

      return response()->json(['status'=>'sukses']);

   }

   public function getDataRencanaBeli(Request $request)
   {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) {
            $sup = DB::table('d_purchaseplan_dt')
                     ->select('d_purchase_plan.p_code', 'd_purchaseplan_dt.ppdt_pruchaseplan')
                     ->join('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
                     ->where('d_purchaseplan_dt.ppdt_isconfirm', '=', "TRUE")
                     ->where('d_purchaseplan_dt.ppdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchaseplan_dt.ppdt_pruchaseplan')
                     ->get();
                     // dd($sup);
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->ppdt_pruchaseplan, 'text' => $val->p_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $sup = DB::table('d_purchaseplan_dt')
                     ->select('d_purchase_plan.p_code', 'd_purchaseplan_dt.ppdt_pruchaseplan')
                     ->join('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
                     ->where('d_purchase_plan.p_code', 'LIKE', '%'.$term.'%')
                     ->where('d_purchaseplan_dt.ppdt_isconfirm', '=', "TRUE")
                     ->where('d_purchaseplan_dt.ppdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchaseplan_dt.ppdt_pruchaseplan')
                     ->get();
            // dd($sup);
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->ppdt_pruchaseplan, 'text' => $val->p_code];
            }

            return Response::json($formatted_tags);  
        }
    }

   public function getDataSupplier(Request $request)
   {
      $formatted_tags = array();
      $term = trim($request->q);
      if (empty($term)) {
          $sup = DB::table('m_supplier')
            ->where('s_active','Y')
            ->take(10)->get();
          foreach ($sup as $val) {
              $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
          }
          return Response::json($formatted_tags);
      }
      else
      {
          $sup = DB::table('m_supplier')
            ->where('s_active','Y')
            ->where('s_company', 'LIKE', '%'.$term.'%')->take(10)->get();
          foreach ($sup as $val) {
              $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
          }

          return Response::json($formatted_tags);  
      }
   }

   public function getDataForm($id)
   {
      $dataHeader = DB::table('d_purchase_plan')
                    ->select('m_supplier.s_id', 
                              'm_supplier.s_company',
                              'p_supplier')
                    ->join('m_supplier', 'd_purchase_plan.p_supplier', '=', 'm_supplier.s_id')
                    ->where('d_purchase_plan.p_id', '=', $id)
                    ->get();

      // //Hitung Hutang
      // $hitHutang = d_purchasing::select('d_pcs_sisapayment')
      // ->where('d_pcs_sisapayment','!=','0')
      // ->where('s_id',$dataHeader[0]->d_pcsp_sup)
      // ->get();
      
      // $totHutang = 0;
      // for ($i=0; $i < count($hitHutang) ; $i++) { 
      //   $totHutang += $hitHutang[$i]->d_pcs_sisapayment;
      // }
      // //end Hitung Hutang
      // //Hitung Plafon
      // $plafon = DB::table('d_supplier')
      //   ->select('s_limit','s_top')
      //   ->where('s_id',$dataHeader[0]->d_pcsp_sup)
      //   ->first();

      // $batasPlafon = $plafon->s_limit - $totHutang;
      // if ($plafon->s_limit == '0') {
      //   $batasPlafon = '0';
      // }
      // $cariSisa = d_purchasing::select('d_pcs_sisapayment')
      // ->where('s_id',$dataHeader[0]->d_pcsp_sup)
      // ->where('d_pcs_sisapayment','!=','0.00')
      // ->get();
      // $totalSisa = 0;
      // for ($i=0; $i <count($cariSisa) ; $i++) 
      // { 
        
      //   $totalSisa += $cariSisa[$i]->d_pcs_sisapayment;
      // }
      // $batasPlafon = $plafon->s_limit - $totalSisa;
      // //End Plafon
      // //cari jatuh tempo
      // $oke = $plafon->s_top.' '. 'days';
      // $date = Carbon::now()->toDateString();
      // $date=date_create($date);
      // date_add($date,date_interval_create_from_date_string($oke));
      // $jatuhTempo = date_format($date,"d-m-Y");
      // //end
      $dataIsi = DB::table('d_purchaseplan_dt')
            ->select('d_purchaseplan_dt.*', 
                     'm_item.i_name', 
                     'm_item.i_code', 
                     'm_item.i_sat1', 
                     'm_item.i_id', 
                     'm_satuan.s_name', 
                     'm_satuan.s_id')
            ->leftJoin('m_item','d_purchaseplan_dt.ppdt_item','=','m_item.i_id')
            ->leftJoin('m_satuan','d_purchaseplan_dt.ppdt_satuan','=','m_satuan.s_id')
            ->where('d_purchaseplan_dt.ppdt_pruchaseplan', '=', $id)
            ->where('d_purchaseplan_dt.ppdt_ispo', '=', "FALSE")
            ->where('d_purchaseplan_dt.ppdt_isconfirm', '=', "TRUE")
            ->get();

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
        $comp = Session::get('user_comp');
         $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
      
         return response()->json([
            'status' => 'sukses',
            'data_header' => $dataHeader,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
            // 'plafon' => $plafon->s_limit,
            // 'batasPlafon' => $batasPlafon,
            // 'plafonRp' => number_format($plafon->s_limit,2,",","."),
            // 'batasPlafonRp' => number_format( $batasPlafon,2,",","."),
            // 'jatuhTempo' =>  $jatuhTempo,
         ]);
    }

   public function getStokByType($arrItemType, $arrSatuan, $counter, $comp)
   {
      // return "klk";
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
            // return 'okee';
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

   public function getOrderByTgl($tgl1, $tgl2)
   {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      $data = d_purchasing::select('d_pcs_date_created',
                                    'd_pcs_id', 
                                    'd_pcsp_id',
                                    'd_pcs_code',
                                    's_company',
                                    'd_pcs_method',
                                    'd_pcs_total_net',
                                    'd_pcs_date_received',
                                    'd_pcs_status',
                                    'd_mem.m_id',
                                    'd_mem.m_name')
            ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
            ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
            ->where('p_pcs_comp',Session::get('user_comp'))
            ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
            ->orderBy('d_pcs_created', 'DESC')
            ->get();

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
            return '<span class="label label-info">Disetujui</span>';
         }
         else
         {
            return '<span class="label label-success">Diterima</span>';
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

      ->editColumn('hargaTotalNet', function ($data) 
      {
         return number_format($data->d_pcs_total_net,0,",",".");
      })

      ->editColumn('tglMasuk', function ($data) 
      {
        if ($data->d_pcs_date_received == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcs_date_received ? with(new Carbon($data->d_pcs_date_received))->format('d M Y') : '';
        }
      })
      
      ->addColumn('action', function($data)
      {
        if ($data->d_pcs_status == "WT") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'")><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "DE") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }
        else
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }  
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
   }

   public function getDataTabelHistory($tgl1, $tgl2, $tampil)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        if ($tampil == 'wait') {
          $isConfirm = "FALSE";
          $indexStatus = "WT";
        }elseif ($tampil == 'edit') {
          $isConfirm = "TRUE";
          $indexStatus = "DE";
        }elseif ($tampil == 'confirm') {
          $isConfirm = "TRUE";
          $indexStatus = "CF";
        }else if ($tampil == 'received') {
          $isConfirm = "TRUE";
          $indexStatus = "RC";
        }else {
          $isConfirm = "TRUE";
          $indexStatus = "RV";
        }

        $data = DB::table('d_purchasing_dt')
            ->select('d_purchasing_dt.*', 
                     'd_purchasing.*', 
                     'm_item.i_name', 
                     'm_supplier.s_company', 
                     'm_satuan.s_name', 
                     'd_terima_pembelian_dt.d_tbdt_qty')
            ->leftJoin('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
            ->leftJoin('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
            ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
            ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.s_id')
            ->leftJoin('d_terima_pembelian_dt','d_purchasing_dt.d_pcsdt_idpdt','=','d_terima_pembelian_dt.d_tbdt_idpcsdt')
            ->where('d_purchasing_dt.d_pcsdt_isconfirm','=',$isConfirm)
            ->where('d_purchasing.d_pcs_status','=',$indexStatus)
            ->where('p_pcs_comp',Session::get('user_comp'))
            ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
            ->get();

        for ($z=0; $z < count($data); $z++) 
        {   
          //variabel untuk menyimpan penjumlahan array qty penerimaan
          $hasil_qty_rcv = 0;
          //get data qty received
          $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as zz FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$data[$z]->d_pcsdt_id."'"));
          
          foreach ($qtyRcv as $nilai) 
          {
            $hasil_qty_rcv = (int)$nilai->zz;
          }
          //create new object properties and assign value
          $data[$z]->qty_received = $hasil_qty_rcv;
        }

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
            return '<span class="label label-info">Disetujui</span>';
          }
          elseif ($data->d_pcs_status == "RC") 
          {
            return '<span class="label label-success">Diterima</span>';
          }
          else
          {
            return '<span class="label label-warning">Revisi</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
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
        ->editColumn('tglTerima', function ($data) 
        {
            if ($data->d_pcs_date_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pcs_date_received ? with(new Carbon($data->d_pcs_date_received))->format('d M Y') : '';
            }
        })
        ->editColumn('qtyTerima', function ($data) 
        {
            $qty = ($data->qty_received == null) ? '-' : $data->qty_received;
            return $qty;
        })
        ->addColumn('action', function($data)
        {
          if ($data->d_pcs_status == "WT" || $data->d_pcs_status == "DE" || $data->d_pcs_status == "CF" || $data->d_pcs_status == "RV") 
          {
            return '<div class="text-center"> - </div>'; 
          }
          elseif ($data->d_pcs_status == "RC") 
          {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailMasukPeritem("'.$data->d_pcsdt_id.'")><i class="fa fa-eye"></i> 
                      </button>
                    </div>'; 
          }
          
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
   }

   public function getEditOrder($id)
    {
      $dataHeader = d_purchasing::join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
                ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasing.*', 'm_supplier.s_company', 'm_supplier.s_name', 'd_mem.m_name', 'd_mem.m_id')
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();

      // $hitHutang = d_purchasing::select('d_pcs_sisapayment')
      // ->where('d_pcs_sisapayment','!=','0')
      // ->where('s_id',$dataHeader[0]->s_id)
      // ->get();
      
      // $totHutang = 0;
      // for ($i=0; $i < count($hitHutang) ; $i++) { 
      //   $totHutang += $hitHutang[$i]->d_pcs_sisapayment;
      // }
      // //end Hitung Hutang
      // //Hitung Plafon
      // $plafon = DB::table('d_supplier')
      //   ->select('s_limit','s_top')
      //   ->where('s_id',$dataHeader[0]->s_id)
      //   ->first();

      // $batasPlafon = $plafon->s_limit - $totHutang;
      // if ($plafon->s_limit == '0') {
      //   $batasPlafon = '0';
      // }
      // $cariSisa = d_purchasing::select('d_pcs_sisapayment')
      // ->where('s_id',$dataHeader[0]->s_id)
      // ->where('d_pcs_sisapayment','!=','0.00')
      // ->get();
      // $totalSisa = 0;
      // for ($i=0; $i <count($cariSisa) ; $i++) 
      // { 
        
      //   $totalSisa += $cariSisa[$i]->d_pcs_sisapayment;
      // }
      // $batasPlafon = $plafon->s_limit - $totalSisa;

      $statusLabel = $dataHeader[0]->d_pcs_status;
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
      else
      {
        $spanTxt = 'Barang telah diterima';
        $spanClass = 'label-success';
      }

      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.s_id')
                ->select('d_purchasing_dt.*', 'm_item.*', 'm_satuan.s_name', 'm_satuan.s_id')
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get();

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
      $comp = Session::get('user_comp');
      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
      
      return response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass
        // 'plafon' => $plafon->s_limit,
        // 'batasPlafon' => $batasPlafon,
        // 'plafonRp' => number_format($plafon->s_limit,2,",","."),
        // 'batasPlafonRp' => number_format( $batasPlafon,2,",",".")
      ]);
   }

   public function deleteDataOrder(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //update d_purchasingplan_dt ispo
        DB::table('d_purchaseplan_dt')
            ->where('ppdt_pruchaseplan', $request->idPo)
            ->where('ppdt_ispo', "TRUE")
            ->update(['ppdt_ispo' => "FALSE", 
                     'ppdt_pruchaseplan' => "0"
                  ]);

        //delete row table d_purchasing_dt
        $deleteOrderDt = d_purchasing_dt::where('d_pcs_id', $request->idPo)->delete();
        //delete row table d_purchasing
        $deleteOrder = d_purchasing::where('d_pcs_id', $request->idPo)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Order Pembelian Berhasil Dihapus'
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

   public function print($id)
   {

      $dataHeader = d_purchasing::join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
                ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasing.*', 'm_supplier.s_company', 'm_supplier.s_name','d_mem.m_id','d_mem.m_name', DB::raw('SUM(d_purchasing.d_pcs_disc_percent) * SUM(d_purchasing.d_pcs_total_gross) as disc_total'))
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get()->toArray();

      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.s_id')
                ->select('d_purchasing_dt.d_pcsdt_id',
                         'd_purchasing_dt.d_pcs_id',
                         'd_purchasing_dt.i_id',
                         'm_item.i_id',
                         'm_item.i_name',
                         'm_item.i_code',
                         'm_item.i_sat1',
                         'm_satuan.s_name',
                         'm_satuan.s_id',
                         'd_purchasing_dt.d_pcsdt_prevcost',
                         'd_purchasing_dt.d_pcsdt_qty',
                         'd_purchasing_dt.d_pcsdt_price',
                         'd_purchasing_dt.d_pcsdt_total'
                )
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get()->toArray();
      
      foreach ($dataIsi as $val) 
      {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val['i_id'])->first();
          //get satuan utama
          $sat1[] = $val['i_sat1'];
      }

      //variabel untuk count array
      $counter = 0;
      //ambil value stok by item type
      $comp = Session::get('user_comp');
      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
      $dataStokQty = array_chunk($dataStok['val_stok'], 10);
      $dataStokTxt = array_chunk($dataStok['txt_satuan'], 10);
      $dataIsi = array_chunk($dataIsi, 10);

      // return $dataStok;

      return view('Purchase::orderpembelian.print', compact('dataHeader', 'dataIsi', 'dataStokQty', 'dataStokTxt'));
   }

}
