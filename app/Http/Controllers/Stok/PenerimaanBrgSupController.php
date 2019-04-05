<?php

namespace App\Http\Controllers\Stok;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\mMember;
use DB;
use Carbon\Carbon;
use DateTime;
use Yajra\Datatables\Datatables;
use Session;
use App\Lib\mutasi;
use App\d_delivery_orderdt;
use App\d_delivery_order;
use App\d_gudangcabang;
use App\d_stock_mutation;
use Response;
use Auth;
use App\d_terima_pembelian;
use App\d_terima_pembelian_dt;

use keuangan; // tambahan dirga

class PenerimaanBrgSupController extends Controller
{
    public function index(){
      $tabIndex = view('stok.p_suplier.tab-index');
      $tabWait = view('stok.p_suplier.tab-wait');
      $tabFinish = view('stok.p_suplier.tab-finish');
      $tabModal = view('stok.p_suplier.modal');
      $tabModDetail = view('stok.p_suplier.modal-detail');
      $tabDetItem = view('stok.p_suplier.modal-detail-peritem');
      $ssss = Session::get('user_comp');
      
      return view('stok.p_suplier.index',compact('tabIndex','tabWait','tabFinish','tabModal','tabModDetail','tabDetItem','ssss'));
    }

   public function lookupDataPembelian(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $purchase = DB::table('d_purchasing_dt')
                ->join('d_purchasing', 'd_purchasing_dt.d_pcs_id', '=', 'd_purchasing.d_pcs_id')
                ->select('d_purchasing_dt.d_pcs_id', 'd_purchasing.d_pcs_code')
                ->where('d_pcsdt_isreceived','=','FALSE')
                ->where('d_purchasing_dt.d_pcsdt_isconfirm','=','TRUE')
                ->where('p_pcs_comp',Session::get('user_comp'))
                ->orderBy('d_pcs_code', 'DESC')
                ->limit(5)
                ->groupBy('d_pcs_id')
                ->get();
            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $purchase = DB::table('d_purchasing_dt')
               ->join('d_purchasing', 'd_purchasing_dt.d_pcs_id', '=', 'd_purchasing.d_pcs_id')
               ->select('d_purchasing_dt.d_pcs_id', 'd_purchasing.d_pcs_code')
               ->where('d_purchasing_dt.d_pcsdt_isreceived','=','FALSE')
               ->where('d_purchasing.d_pcs_code', 'LIKE', '%'.$term.'%')
               ->where('d_purchasing_dt.d_pcsdt_isconfirm','=','TRUE')
               ->where('p_pcs_comp',Session::get('user_comp'))
               ->orderBy('d_purchasing.d_pcs_code', 'DESC')
               ->limit(5)
               ->groupBy('d_pcs_id')->get();

            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function getDataForm($id)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $lvl_peg = Auth::user()->m_isadmin;
        $div_peg = DB::table('m_pegawai_man')->select('c_divisi_id')->where('c_id', $id_peg)->first();
         $dataHeader = DB::table('d_purchasing')
                    ->select('d_purchasing.*', 'm_supplier.s_company', 'm_supplier.s_name', 'm_supplier.s_id')
                    ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
                    ->where('d_pcs_id', '=', $id)
                    ->get();
         // dd($lvl_peg);
         if ($lvl_peg == 'N') 
         {
            if ($div_peg->c_divisi_id == '5') {
                $item_type = ['BJ'];
            }else{
                $item_type = ['BJ', 'BB', 'BP', 'BL'];
            }

            $dataIsi = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*', 
                           'm_item.i_name', 
                           'm_item.i_code', 
                           'm_item.i_type', 
                           'm_item.i_sat1', 
                           'm_item.i_id', 
                           'm_satuan.m_sname', 
                           'm_satuan.s_id')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.s_id')
                  ->where(function ($query) use ($id, $item_type) {
                          $query->where('d_purchasing_dt.d_pcs_id', '=', $id);
                          $query->whereIn('m_item.i_type', $item_type);
                          $query->where('d_purchasing_dt.d_pcsdt_isreceived', '=', 'FALSE');
                    })->get();
         }
         else
         {
            $dataIsi = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*', 
                           'm_item.i_name', 
                           'm_item.i_code', 
                           'm_item.i_sat1', 
                           'm_item.i_id', 
                           'm_satuan.s_name', 
                           'm_satuan.s_id')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.s_id')
                  ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                  ->where('d_purchasing_dt.d_pcsdt_isreceived', '=', "FALSE")
                  ->get();
         }
        // dd($dataIsi);
        foreach ($dataIsi as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
          //get qty purchase
          $qtyPurchase[] = $val->d_pcsdt_qtyconfirm;
          //get id purchasedt
          $idPurchaseDt[] = $val->d_pcsdt_id; 
        }

        for ($z=0; $z < count($qtyPurchase); $z++) 
        {   
            //variabel untuk menyimpan penjumlahan array qty penerimaan
            $hasil_qty_rcv = 0;
            //get data qty received
            $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as zz FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$idPurchaseDt[$z]."'"));
            
            foreach ($qtyRcv as $nilai) 
            {
                $hasil_qty_rcv = (int)$nilai->zz;
            }

            $qtyRemain[] = $qtyPurchase[$z] - $hasil_qty_rcv;
        }
        
        //variabel untuk count array
        $counter = 0;
        //ambil value stok by item type
         $comp = Session::get('user_comp');
         $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);

        return response()->json([
            'status' => 'sukses',
            'data_header' => $dataHeader,
            'data_qty' => $qtyRemain,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
        ]);
    }

    public function simpan_penerimaan(Request $request)
    {
        // return json_encode($request->all());
        DB::beginTransaction();
        try 
        {
            //code penerimaan
            $kode = $this->kodePenerimaanAuto();
            //insert to table d_terimapembelian
            $dataHeader = new d_terima_pembelian;
            $dataHeader->d_tb_pid = $request->headNotaPurchase;
            $dataHeader->d_tb_sup = $request->headSupplierId;
            $dataHeader->d_tb_code = $kode;
            $dataHeader->d_tb_staff = $request->headStaffId;
            $dataHeader->d_tb_noreff = $request->headNotaTxt;
            $dataHeader->d_tb_totalnett = $this->konvertRp($request->headTotalTerima);
            $dataHeader->d_tb_date = date('Y-m-d',strtotime($request->headTglTerima));
            if ($request->headMethod != "CASH") 
            {
              $dataHeader->d_tb_duedate = date('Y-m-d',strtotime($request->apdTgl));
            }
            $dataHeader->d_tb_created = Carbon::now();
            $dataHeader->save();
                  
            //get last lastId then insert id to d_terimapembelian_dt
            $lastId = d_terima_pembelian::select('d_tb_id')->max('d_tb_id');
            if ($lastId == 0 || $lastId == '') 
            {
                $lastId  = 1;
            }  

            //variabel untuk hitung array field
            $hitung_field = count($request->fieldItemId);
            $dataJurnal = []; // Tambahan Dirga

            //update d_stock, insert d_stock_mutation & insert d_terimapembelian_dt
            for ($i=0; $i < $hitung_field; $i++) 
            {
                //variabel u/ cek primary satuan
                $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldItemId[$i])->first();
        
                //cek satuan primary, convert ke primary apabila beda satuan
                if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi1;
                  $hppConvert = (int)$request->fieldHargaRaw[$i] / (int)$primary_sat->i_sat_isi1;
                }
                elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi2;
                  $hppConvert = (int)$request->fieldHargaRaw[$i] / (int)$primary_sat->i_sat_isi2;
                }
                else
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi3;
                  $hppConvert = (int)$request->fieldHargaRaw[$i] / (int)$primary_sat->i_sat_isi3;
                }

                $grup = $this->getGroupGudang($request->fieldItemId[$i]);
                $stokAkhir = (int)$request->fieldStokVal[$i] + (int)$hasilConvert;
                //update stock akhir d_stock
                DB::table('d_stock')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->update(['s_qty' => DB::raw('s_qty + '.(int)$hasilConvert)]);
                //get id d_stock
                $dstock_id = DB::table('d_stock')
                  ->select('s_id')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->first();
               if ($dstock_id == null) 
               {
                  $idStock = DB::table('d_stock')->select('s_id')
                     ->max('s_id')+1;
                  DB::table('d_stock')
                     ->insert([
                        's_id' => $idStock,
                        's_comp' => $grup,
                        's_position' => $grup,
                        's_item' => $request->fieldItemId[$i],
                        's_qty' => $stokAkhir,
                        's_insert' =>Carbon::now()
                     ]);

                  //insert to d_stock_mutation
                  DB::table('d_stock_mutation')->insert([
                     'sm_stock' => $idStock,
                     'sm_detailid' => 1,
                     'sm_date' => Carbon::now(),
                     'sm_comp' => $grup,
                     'sm_position' => $grup,
                     'sm_mutcat' => '17',
                     'sm_item' => $request->fieldItemId[$i],
                     'sm_qty' => $hasilConvert,
                     'sm_qty_used' => '0',
                     'sm_qty_expired' => '0',
                     'sm_qty_sisa' => $hasilConvert,
                     'sm_detail' => "PENAMBAHAN",
                     'sm_hpp' => $hppConvert,
                     'sm_sell' => '0',
                     'sm_reff' => $this->kodePenerimaanAuto(),
                     'sm_insert' => Carbon::now(),
                  ]);

                  $dataIsi = new d_terima_pembelian_dt;
                   $dataIsi->d_tbdt_idtb = $lastId;
                   $dataIsi->d_tbdt_smdetail = 1;
                   $dataIsi->d_tbdt_item = $request->fieldItemId[$i];
                   $dataIsi->d_tbdt_sat = $request->fieldSatuanId[$i];
                   $dataIsi->d_tbdt_idpcsdt = $request->fieldIdPurchaseDet[$i];
                   $dataIsi->d_tbdt_qty = $request->fieldQtyterima[$i];
                   $dataIsi->d_tbdt_price = $request->fieldHargaRaw[$i];
                   $dataIsi->d_tbdt_pricetotal = $request->fieldHargaTotalRaw[$i];
                   $dataIsi->d_tbdt_date_received = date('Y-m-d',strtotime($request->headTglTerima));
                   $dataIsi->d_tbdt_created = Carbon::now();
                   $dataIsi->save();
               }
               else
               {
                  //get last id stock_mutation
                  $lastIdSm = DB::select(DB::raw("SELECT IFNULL((SELECT sm_detailid FROM d_stock_mutation where sm_stock = '$dstock_id->s_id' ORDER BY sm_detailid DESC LIMIT 1) ,'0') as zz"));
                  if ($lastIdSm[0]->zz == 0 || $lastIdSm[0]->zz == '0')
                  {
                     $hasil_id = 1;
                  }
                  else
                  {
                     $hasil_id = (int)$lastIdSm[0]->zz + 1;
                  }

                  //insert to d_stock_mutation
                  DB::table('d_stock_mutation')->insert([
                     'sm_stock' => $dstock_id->s_id,
                     'sm_detailid' => $hasil_id,
                     'sm_date' => Carbon::now(),
                     'sm_comp' => $grup,
                     'sm_position' => $grup,
                     'sm_mutcat' => '17',
                     'sm_item' => $request->fieldItemId[$i],
                     'sm_qty' => $hasilConvert,
                     'sm_qty_used' => '0',
                     'sm_qty_expired' => '0',
                     'sm_qty_sisa' => $hasilConvert,
                     'sm_detail' => "PENAMBAHAN",
                     'sm_hpp' => $hppConvert,
                     'sm_sell' => '0',
                     'sm_reff' => $this->kodePenerimaanAuto(),
                     'sm_insert' => Carbon::now(),
                  ]);

                  $dataIsi = new d_terima_pembelian_dt;
                   $dataIsi->d_tbdt_idtb = $lastId;
                   $dataIsi->d_tbdt_smdetail = $hasil_id;
                   $dataIsi->d_tbdt_item = $request->fieldItemId[$i];
                   $dataIsi->d_tbdt_sat = $request->fieldSatuanId[$i];
                   $dataIsi->d_tbdt_idpcsdt = $request->fieldIdPurchaseDet[$i];
                   $dataIsi->d_tbdt_qty = $request->fieldQtyterima[$i];
                   $dataIsi->d_tbdt_price = $request->fieldHargaRaw[$i];
                   $dataIsi->d_tbdt_pricetotal = $request->fieldHargaTotalRaw[$i];
                   $dataIsi->d_tbdt_date_received = date('Y-m-d',strtotime($request->headTglTerima));
                   $dataIsi->d_tbdt_created = Carbon::now();
                   $dataIsi->save();

               }

                //update isrecieved d_purchasingdt jika qty == terima
                $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as aa FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$request->fieldIdPurchaseDet[$i]."'"));
                $qtyPcs = DB::select(DB::raw("SELECT IFNULL(sum(d_pcsdt_qtyconfirm), 0) as bb FROM d_purchasing_dt where d_pcsdt_id = '".$request->fieldIdPurchaseDet[$i]."'"));

                if ($qtyRcv[0]->aa == $qtyPcs[0]->bb) 
                {
                   DB::table('d_purchasing_dt')
                      ->where('d_pcsdt_id', $request->fieldIdPurchaseDet[$i])
                      ->update(['d_pcsdt_isreceived' => 'TRUE']);
                }


                // Tambahan Dirga
                $dataGroup = DB::table('m_group')
                                ->select('g_akun_persediaan')
                                ->where('g_id', function($query) use ($request, $i){
                                  $query->select('i_group')->from('m_item')
                                            ->where('i_id', $request->fieldItemId[$i])
                                            ->first();
                                })->first();

                if(!$dataGroup || !$dataGroup->g_akun_persediaan){
                    return response()->json([
                        'status' => 'gagal',
                        'pesan'  => 'Beberapa Akun Persediaan Pada Group Item Yang Terkain Belum Ditentukan. Jurnal dan Data Penerimaan Tidak Bisa Disimpan.'
                    ]);
                }

                if(!array_key_exists($dataGroup->g_akun_persediaan, $dataJurnal)){
                  $dataJurnal[$dataGroup->g_akun_persediaan] = [
                    'jrdt_akun'   => $dataGroup->g_akun_persediaan,
                    'jrdt_value'  => $request->fieldHargaTotalRaw[$i],
                    'jrdt_dk' => 'D'
                  ];
                }else{
                  $dataJurnal[$dataGroup->g_akun_persediaan]['jrdt_value'] += $request->fieldHargaTotalRaw[$i];
                }

                // selesai Dirga

            }

            // Tambahan Dirga 
            if(modulSetting()['onLogin'] == modulSetting()['id_pusat']){
              $dataAkunHutang = DB::table('dk_akun_penting')
                                    ->whereNull('ap_comp')
                                    ->where('ap_nama', 'Hutang Usaha')
                                    ->select('ap_akun')
                                    ->first();
            }
            else{
              $dataAkunHutang = DB::table('dk_akun_penting')
                                    ->where('ap_comp', modulSetting()['onLogin'])
                                    ->where('ap_nama', 'Hutang Usaha')
                                    ->select('ap_akun')
                                    ->first();
            }

            if(!$dataAkunHutang || !$dataAkunHutang->ap_akun){
                return response()->json([
                      'status' => 'gagal',
                      'pesan'  => 'Akun Hutang Usaha Belum Ditentukan. Anda Bisa Memilihnya Di Menu Setting/Akun Penting'
                ]);
            }
            
            $dataJurnal[$dataAkunHutang->ap_akun] = [
              'jrdt_akun'   => $dataAkunHutang->ap_akun,
              'jrdt_value'  => array_sum($request->fieldHargaTotalRaw),
              'jrdt_dk' => 'K'
            ];

            // return json_encode($dataJurnal);

            // update data hutang
            DB::table('dk_payable')->where('py_ref_nomor', $request->headNotaTxt)->update([
              'py_total_tagihan' => DB::raw('py_total_tagihan + '.array_sum($request->fieldHargaTotalRaw))
            ]);

            $dataPo = DB::table('d_purchasing')->where('d_pcs_id', $request->headNotaPurchase)->first();

            keuangan::jurnal()->addJurnal($dataJurnal, $dataPo->d_pcs_date_created, $request->headNotaTxt, 'Penerimaan Barang Supplier Atas Nota '.$request->headNotaTxt, 'MM', modulSetting()['onLogin'], false);

            // return json_encode($dataJurnal);

            // Selesai Dirga

            //cek pada table purchasingdt, jika isreceived semua tbl header ubah status ke RC
            $this->cek_status_purchasing($request->headNotaPurchase);
            
            DB::commit();
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }          
         // return json_encode($state_jurnal);
        return response()->json([
            'status' => 'sukses',
            'pesan'  => 'Data Penerimaan Pembelian Berhasil Disimpan'
        ]);

    }
    public function list_sj(Request $request)
    {
        $id_sj = trim($request->sj_code);
            
        return response()->json([
            'idSj' => $id_sj,
        ]);
        //return view('/inventory/p_hasilproduksi/tabel_penerimaan',compact('query'));
    }

    public function get_tabel_data($id)
    {

        $query = d_delivery_orderdt::select(
                    'd_delivery_order.do_nota', 
                    'd_delivery_orderdt.dod_do',
                    'd_delivery_orderdt.dod_detailid',
                    'm_item.i_name',
                    'd_delivery_orderdt.dod_qty_send',
                    'd_delivery_orderdt.dod_qty_received',
                    'd_delivery_orderdt.dod_date_received',
                    'd_delivery_orderdt.dod_time_received',
                    'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_order.do_nota', '=', $id)
            ->where('d_delivery_orderdt.dod_status', '=', 'WT')
            ->orderBy('d_delivery_orderdt.dod_update', 'desc')
            ->get();

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            if ($data->dod_qty_received == '0' && $data->dod_date_received == null && $data->dod_time_received == null) {
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Terima"
                                onclick=terimaHasilProduksi("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="fa fa-plus"></i> 
                            </button>&nbsp;
                            
                        </div>';
            }   
        })
        ->editColumn('tanggalTerima', function ($data) 
        {
            if ($data->dod_date_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->dod_date_received ? with(new Carbon($data->dod_date_received))->format('d M Y') : '';
            }
        })
        ->editColumn('jamTerima', function ($data) 
        {
            if ($data->dod_time_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->dod_time_received;
            }
        })
        ->editColumn('status', function ($data) 
        {
            if ($data->dod_status == "WT") 
            {
                return '<span class="label label-info">Waiting</span>';
            }
            elseif ($data->dod_status == "FN") 
            {
                return '<span class="label label-success">Final</span>';
            }
        })
        //inisisai column status agar kode html digenerate ketika ditampilkan
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function terima_hasil_produksi($dod_do, $dod_detailid){
        $query = d_delivery_orderdt::select(
                                        'd_delivery_order.do_nota', 
                                        'd_delivery_orderdt.dod_do',
                                        'd_delivery_orderdt.dod_detailid',
                                        'd_delivery_orderdt.dod_item',
                                        'd_delivery_orderdt.dod_prdt_productresult',
                                        'd_delivery_orderdt.dod_prdt_detail',
                                        'm_item.i_name',
                                        'd_delivery_orderdt.dod_qty_send',
                                        'd_delivery_orderdt.dod_qty_received',
                                        'd_delivery_orderdt.dod_date_received',
                                        'd_delivery_orderdt.dod_time_received',
                                        'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_orderdt.dod_do', '=', $dod_do)
            ->where('d_delivery_orderdt.dod_detailid', '=', $dod_detailid)
            ->where('d_delivery_orderdt.dod_status', '=', 'WT')
            ->get();

         echo json_encode($query);
    }

    public function simpan_update_data(Request $request){
      // return json_encode('update');
      DB::beginTransaction();
      try {
        //ubah status
          $recentStatusDo = DB::table('d_delivery_orderdt')
                              ->where('dod_do',$request->doId)
                              ->where('dod_detailid',$request->detailId)
                              ->first();
          // dd($recentStatusDo);
          if ($recentStatusDo->dod_status == "WT") {
              //update status to FN
              DB::table('d_delivery_orderdt')
                  ->where('dod_do',$request->doId)
                  ->where('dod_detailid',$request->detailId)
                  ->update(['dod_status' => "FN"]);
          }else{
              //update status to WT
              DB::table('d_delivery_orderdt')
                  ->where('dod_do',$request->doId)
                  ->where('dod_detailid',$request->detailId)
                  ->update(['dod_status' => "WT"]);
          }

          //get recent status Product Result detail
          //end status
          $doId = d_delivery_order::where('do_id',$request->doId)->first();
          $gc_sending = d_gudangcabang::select('gc_id')
                      ->where('gc_gudang','GUDANG SENDING')
                      ->first();
          //get stock item gdg Sending

          if(mutasi::mutasiStok(  $request->idItemMasuk,
                                  $request->qtyDiterima,
                                  $comp=$doId->do_send,
                                  $position=$gc_sending->gc_id,
                                  $flag='MENGURANGI',
                                  $request->noNotaMasuk,
                                  'MENGURANGI',
                                  Carbon::now(),
                                  100)){}

          //cek ada tidaknya record pada tabel
          $id_stock = DB::table('d_stock')->select('s_id')
              ->where('s_comp',$doId->do_send)
              ->where('s_position',$doId->do_send)
              ->where('s_item',$request->idItemMasuk)
              ->first();
          // dd($id_stock);
          if($id_stock != null){ //jika terdapat record, maka lakukan update
              //get stock item gdg Grosir
              $stok_item_gs = DB::table('d_stock')
              ->where('s_comp',$doId->do_send)
              ->where('s_position',$doId->do_send)
              ->where('s_item',$request->idItemMasuk)
              ->first();
              $stok_akhir_gdgGrosir = $stok_item_gs->s_qty + $request->qtyDiterima;
              //update stok gudang grosir
              $update = DB::table('d_stock')
                  ->where('s_comp',$doId->do_send)
                  ->where('s_position',$doId->do_send)
                  ->where('s_item',$request->idItemMasuk)
                  ->update(['s_qty' => $stok_akhir_gdgGrosir]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_stock',$id_stock->s_id)
                ->max('sm_detailid')+1;
                
              d_stock_mutation::create([
                    'sm_stock' => $id_stock->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => $doId->do_send,
                    'sm_position' => $doId->do_send,
                    'sm_mutcat' => 9,
                    'sm_item' => $request->idItemMasuk,
                    'sm_qty' => $request->qtyDiterima,
                    'sm_qty_used' => 0,
                    'sm_qty_sisa' => $request->qtyDiterima,
                    'sm_qty_expired' => 0,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $request->noNotaMasuk,
                    'sm_insert' => Carbon::now()
                ]);

          }else{ //jika tidak ada record, maka lakukan insert
              //get last id
              $id_stock = DB::table('d_stock')->max('s_id') + 1;
              //insert value ke tbl d_stock
              DB::table('d_stock')->insert([
                  's_id' => $id_stock,
                  's_comp' => $doId->do_send,
                  's_position' => $doId->do_send,
                  's_item' => $request->idItemMasuk,
                  's_qty' => $request->qtyDiterima,
              ]);

              d_stock_mutation::create([
                  'sm_stock' => $id_stock,
                  'sm_detailid' =>1,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => $doId->do_send,
                  'sm_position' => $doId->do_send,
                  'sm_mutcat' => 9,
                  'sm_item' => $request->idItemMasuk,
                  'sm_qty' => $request->qtyDiterima,
                  'sm_qty_used' => 0,
                  'sm_qty_sisa' => $request->qtyDiterima,
                  'sm_qty_expired' => 0,
                  'sm_detail' => 'PENAMBAHAN',
                  'sm_reff' => $request->noNotaMasuk,
                  'sm_insert' => Carbon::now()
              ]);
          }
           
          //update d_delivery_orderdt
          $date = Carbon::parse($request->tglMasuk)->format('Y-m-d');
          $time = $request->jamMasuk.":00";
          $now = Carbon::now();
          DB::table('d_delivery_orderdt')
                  ->where('dod_detailid', $request->detailId)
                  ->where('dod_do',$request->doId)
                  ->update(['dod_qty_received' => $request->qtyDiterima, 'dod_date_received' => $date, 'dod_time_received' => $time, 'dod_update' => $now]);
                      
          DB::commit();
          return response()->json([
              'status' => 'Sukses',
              'pesan' => 'Data Telah Berhasil di Simpan'
          ]);
      }catch (\Exception $e) {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'data' => $e->getMessage()
          ]);
      }
    }

    public function getPenerimaanByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
         $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
                ->join('m_supplier','d_terima_pembelian.d_tb_sup','=','m_supplier.s_id')
                ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
                ->select('d_terima_pembelian.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_code', 'd_purchasing.d_pcs_date_created', 'd_mem.m_name')
                ->whereBetween('d_tb_date', [$tanggal1, $tanggal2])
                ->where('p_pcs_comp',Session::get('user_comp'))
                ->orderBy('d_tb_created', 'DESC')
                ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_tb_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_tb_created ? with(new Carbon($data->d_tb_created))->format('d M Y') : '';
            }
        })
        ->editColumn('hargaTotal', function ($data) 
        {
          return 'Rp. '.number_format($data->d_tb_totalnett,2,",",".");
        })
        ->addColumn('action', function($data)
        {
          
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPenerimaan("'.$data->d_tb_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <!-- <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePenerimaan("'.$data->d_tb_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button> -->
                    </div>';
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

   public function getDataDetail($id)
   {
        $dataHeader = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
            ->join('m_supplier','d_terima_pembelian.d_tb_sup','=','m_supplier.s_id')
            ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
            ->select('d_terima_pembelian.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasing.*', 'd_mem.m_name')
            ->where('d_terima_pembelian.d_tb_id', '=', $id)
            ->orderBy('d_tb_created', 'DESC')
            ->get();

        foreach ($dataHeader as $val) 
        {   $total_disc = (int)$val->d_pcs_discount + (int)$val->d_pcs_disc_value;
            $data = array(
                /*'hargaTotBeliGross' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
                'hargaTotBeliDisc' => 'Rp. '.number_format($total_disc,2,",","."),
                'hargaTotBeliTax' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
                'hargaTotBeliNett' => 'Rp. '.number_format($val->d_pcs_total_net,2,",","."),
                'hargaTotalTerimaNett' => 'Rp. '.number_format($val->d_tb_totalnett,2,",","."),*/
                'tanggalTerima' => date('d-m-Y',strtotime($val->d_tb_date))
            );
        }

        $dataIsi = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
                ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.s_id')
                ->join('d_purchasing_dt', 'd_terima_pembelian_dt.d_tbdt_idpcsdt', '=', 'd_purchasing_dt.d_pcsdt_id')
                ->select('d_terima_pembelian_dt.*', 'm_item.*', 'd_terima_pembelian.d_tb_code', 'm_satuan.s_id', 'm_satuan.s_name', 'd_purchasing_dt.d_pcsdt_qtyconfirm')
                ->where('d_terima_pembelian_dt.d_tbdt_idtb', '=', $id)
                ->orderBy('d_terima_pembelian_dt.d_tbdt_created', 'DESC')
                ->get();
        
        //cek item type untuk hitung stok
        foreach ($dataIsi as $val) 
        {
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





   

   public function getListWaitingByTgl($tgl1, $tgl2)
   {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
         $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*','d_purchasing.d_pcs_date_created','d_purchasing.d_pcs_code','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','m_supplier.s_company','m_satuan.s_name','m_satuan.s_id')
                  ->leftJoin('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.s_id')
                  ->leftJoin('m_supplier','d_purchasing_dt.d_pcsdt_sid','=','m_supplier.s_id')          
                  ->where('d_purchasing_dt.d_pcsdt_isreceived', '=', "FALSE")
                  ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
                  ->where('p_pcs_comp',Session::get('user_comp'))
                  ->orderBy('d_purchasing.d_pcs_date_created', 'DESC')
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
          $data[$z]->qty_remain = $data[$z]->d_pcsdt_qtyconfirm - $hasil_qty_rcv;
        }

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
        {
          if ($data->d_pcsdt_isreceived == "FALSE") 
          {
            return '<span class="label label-info">Belum Diterima</span>';
          }
          elseif ($data->d_pcsdt_isreceived == "TRUE") 
          {
            return '<span class="label label-success">Disetujui</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_pcsdt_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pcsdt_created ? with(new Carbon($data->d_pcsdt_created))->format('d M Y') : '';
            }
        })
        ->rawColumns(['status'])
        ->make(true);
   }

   public function getListReceivedByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
         $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*','d_purchasing.d_pcs_date_created','d_purchasing.d_pcs_code','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','m_supplier.s_company','m_satuan.s_name','m_satuan.s_id')
                  ->leftJoin('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.s_id')
                  ->leftJoin('m_supplier','d_purchasing_dt.d_pcsdt_sid','=','m_supplier.s_id')           
                  ->where('d_purchasing_dt.d_pcsdt_isreceived', '=', "TRUE")
                  ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
                  ->where('p_pcs_comp',Session::get('user_comp'))
                  ->orderBy('d_purchasing.d_pcs_date_created', 'DESC')
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
          if ($data->d_pcsdt_isreceived == "FALSE") 
          {
            return '<span class="label label-info">Belum Diterima</span>';
          }
          elseif ($data->d_pcsdt_isreceived == "TRUE") 
          {
            return '<span class="label label-success">Diterima</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
        {
          if ($data->d_pcsdt_created == null) 
          {
              return '-';
          }
          else 
          {
              return $data->d_pcsdt_created ? with(new Carbon($data->d_pcsdt_created))->format('d M Y') : '';
          }
        })
        ->addColumn('action', function($data)
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailListReceived("'.$data->d_pcsdt_id.'")><i class="fa fa-eye"></i> 
                      </button>
                  </div>';
        })
        ->rawColumns(['status','action'])
        ->make(true);
   }


   public function getGroupGudang($id_item)
   {
      $typeBrg = DB::table('m_item')->select('i_type')->where('i_id','=', $id_item)->first();
      if ($typeBrg->i_type == "BB") 
      {
         $comp = Session::get('user_comp');
         $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG BAHAN BAKU')
                  ->where('gc_comp',$comp)
                  ->first();
         $idGroupGdg = $gc_id->gc_id;
      } 
      elseif ($typeBrg->i_type == "BJ") 
      {
         $comp = Session::get('user_comp');
         $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG PENJUALAN')
                  ->where('gc_comp',$comp)
                  ->first();
         $idGroupGdg = $gc_id->gc_id;
      }
      return $idGroupGdg;
   }

   public function kodePenerimaanAuto()
   {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_tb_code,5)) as kode_max from d_terima_pembelian WHERE DATE_FORMAT(d_tb_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

        return $codeTerimaBeli = "TPS-".date('ym')."-".$kd;
    }

    public function konvertRp($value)
    {
        $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
        return (int)str_replace(',', '.', $value);
    }

   public function cek_status_purchasing($id_purchasing)
   {
      //tanggal sekarang
      $tgl = Carbon::today()->toDateString();
      //cek pada table purchasingdt, jika isreceived semua tbl header ubah status ke RC
      $data_dt = DB::table('d_purchasing_dt')->select('d_pcsdt_isreceived')->where('d_pcs_id', '=', $id_purchasing)->get();

      foreach ($data_dt as $x) { $data_status[] = $x->d_pcsdt_isreceived; }

      if (!in_array("FALSE", $data_status, TRUE)) 
      {
        DB::table('d_purchasing')->where('d_pcs_id', $id_purchasing)->update(['d_pcs_status' => 'RC', 'd_pcs_date_received' => $tgl]);
      }
   }

   public function print($id)
   {
      $dataHeader = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
         ->join('m_supplier','d_terima_pembelian.d_tb_sup','=','m_supplier.s_id')
         ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
         ->select('d_terima_pembelian.*', 'm_supplier.s_id', 'm_supplier.s_name', 'm_supplier.s_company', 'd_purchasing.*', 'd_mem.m_name')
         ->where('d_terima_pembelian.d_tb_id', '=', $id)
         ->orderBy('d_tb_created', 'DESC')
         ->get()->toArray();

      $dataIsi = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
             ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
             ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.s_id')
             ->join('d_purchasing_dt', 'd_terima_pembelian_dt.d_tbdt_idpcsdt', '=', 'd_purchasing_dt.d_pcsdt_id')
             ->select('d_terima_pembelian_dt.*', 'm_item.*', 'd_terima_pembelian.d_tb_code', 'm_satuan.s_id', 'm_satuan.s_name', 'd_purchasing_dt.d_pcsdt_qtyconfirm')
             ->where('d_terima_pembelian_dt.d_tbdt_idtb', '=', $id)
             ->orderBy('d_terima_pembelian_dt.d_tbdt_created', 'DESC')
             ->get()->toArray();

      foreach ($dataIsi as $val) 
      {
       $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val['i_id'])->first();
       //get satuan utama
       $sat1[] = $val['i_sat1'];
      }

      //variabel untuk count array
      $counter = 0;
      //ambil value stok by item type
      $comp = Session::get('user_comp');
      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);

      $val_stock = [];
      $txt_satuan = [];

      $val_stock = array_chunk($dataStok['val_stok'], 14);
      $txt_satuan = array_chunk($dataStok['txt_satuan'], 14);

      $dataIsi = array_chunk($dataIsi, 14);
        
      return view('Inventory::p_suplier.print', compact('dataHeader', 'dataIsi', 'val_stock', 'txt_satuan'));
   }

}
