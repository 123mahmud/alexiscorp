<?php

namespace App\Http\Controllers\Stok;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use Datatables;
use Auth;
use App\d_purchasingreturn;
use App\d_purchasingreturn_dt;
use App\d_terima_return_sup;
use App\d_terima_return_supdt;
use Session;
use App\d_gudangcabang;

class PenerimaanRtrSupController extends Controller
{

    public function index()
    {
        return view('stok.p_returnsuplier/index');
    }

    public function lookupDataReturn(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $purchase = DB::table('d_purchasingreturn_dt')
                ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
                ->select('d_purchasingreturn_dt.d_pcsrdt_idpcsr', 'd_purchasingreturn.d_pcsr_code')
                ->where('d_purchasingreturn_dt.d_pcsrdt_isreceived','=','FALSE')
                ->where('d_purchasingreturn.d_pcsr_method','=','TK')
                ->where('d_purchasingreturn_dt.d_pcsrdt_isconfirm','=','TRUE')
                ->where('d_pcsr_comp',Session::get('user_comp'))
                ->orderBy('d_pcsr_code', 'DESC')->limit(5)->groupBy('d_pcsr_id')->get();
            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcsrdt_idpcsr, 'text' => $val->d_pcsr_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $purchase = DB::table('d_purchasingreturn_dt')
                ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
                ->select('d_purchasingreturn_dt.d_pcsrdt_idpcsr', 'd_purchasingreturn.d_pcsr_code')
                ->where('d_purchasingreturn_dt.d_pcsrdt_isreceived','=','FALSE')
                ->where('d_purchasingreturn.d_pcsr_method','=','TK')
                ->where('d_purchasing.d_pcs_code', 'LIKE', '%'.$term.'%')
                ->where('d_purchasingreturn_dt.d_pcsrdt_isconfirm','=','TRUE')
                ->where('d_pcsr_comp',Session::get('user_comp'))
                ->orderBy('d_pcsr_code', 'DESC')->limit(5)->groupBy('d_pcsr_id')->get();
            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcsrdt_idpcsr, 'text' => $val->d_pcsr_code];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function getDataForm($id)
    { 
        $dataHeader = DB::table('d_purchasingreturn')
                    ->join('m_supplier', 'd_purchasingreturn.d_pcsr_supid', '=', 'm_supplier.s_id')
                    ->select('d_purchasingreturn.*', 'm_supplier.s_company')->where('d_pcsr_id', '=', $id)->get();

        $dataIsi = DB::table('d_purchasingreturn_dt')
                  ->select('d_purchasingreturn_dt.*', 'm_item.i_name', 'm_item.i_code', 'm_item.i_sat1', 'm_item.i_id', 'm_satuan.s_name', 'm_satuan.s_id')
                  ->leftJoin('m_item','d_purchasingreturn_dt.d_pcsrdt_item','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasingreturn_dt.d_pcsrdt_sat','=','m_satuan.s_id')
                  ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
                  ->where('d_purchasingreturn_dt.d_pcsrdt_isreceived', '=', "FALSE")
                  ->get();

        foreach ($dataIsi as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama dt
          $sat1[] = $val->i_sat1;
          //get qty purchase return dt
          $qtyPurchaseRtrDet[] = $val->d_pcsrdt_qtyconfirm;
          //get id purchase return dt
          $idPurchaseRetDet[] = $val->d_pcsrdt_id; 
        }

        for ($z=0; $z < count($qtyPurchaseRtrDet); $z++) 
        {   
            //variabel untuk menyimpan penjumlahan array qty penerimaan
            $hasil_qty_rcv = 0;
            //get data qty received
            $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_trsdt_qty), 0) as zz FROM d_terima_return_supdt where d_trsdt_idrtdet = '".$idPurchaseRetDet[$z]."'"));
            
            foreach ($qtyRcv as $nilai) 
            {
                $hasil_qty_rcv = (int)$nilai->zz;
            }

            $qtyRemain[] = $qtyPurchaseRtrDet[$z] - $hasil_qty_rcv;
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

    public function getDatatableIndex()
    {
        $data = d_terima_return_sup::join('d_purchasingreturn','d_terima_return_sup.d_trs_prid','=','d_purchasingreturn.d_pcsr_id')
                ->join('m_supplier','d_terima_return_sup.d_trs_sup','=','m_supplier.s_id')
                ->join('d_mem','d_terima_return_sup.d_trs_staff','=','d_mem.m_id')
                ->select('d_terima_return_sup.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasingreturn.d_pcsr_method', 'd_purchasingreturn.d_pcsr_code', 'd_purchasingreturn.d_pcsr_datecreated', 'd_mem.m_name')
                ->orderBy('d_trs_created', 'DESC')
                ->where('d_pcsr_comp',Session::get('user_comp'))
                ->get();
        //dd($data);    
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglMasuk', function ($data) 
        {
            if ($data->d_trs_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_trs_created ? with(new Carbon($data->d_trs_created))->format('d M Y') : '';
            }
        })
        ->editColumn('tglBuat', function ($data) 
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
        ->editColumn('methodReturn', function ($data) 
        {
            if ($data->d_pcsr_method == 'TK') 
            {
                return 'TUKAR BARANG';
            }
            else 
            {
                return 'POTONG NOTA';
            }
        })
        ->addColumn('action', function($data)
        {
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPenerimaan("'.$data->d_trs_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePenerimaan("'.$data->d_trs_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getTerimaRtrByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
         $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_terima_return_sup::join('d_purchasingreturn','d_terima_return_sup.d_trs_prid','=','d_purchasingreturn.d_pcsr_id')
                ->join('m_supplier','d_terima_return_sup.d_trs_sup','=','m_supplier.s_id')
                ->join('d_mem','d_terima_return_sup.d_trs_staff','=','d_mem.m_id')
                ->select('d_terima_return_sup.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasingreturn.d_pcsr_method', 'd_purchasingreturn.d_pcsr_code', 'd_purchasingreturn.d_pcsr_datecreated', 'd_mem.m_name')
                ->whereBetween('d_trs_date', [$tanggal1, $tanggal2])
                ->orderBy('d_trs_created', 'DESC')
                ->where('d_pcsr_comp',Session::get('user_comp'))
                ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglMasuk', function ($data) 
        {
            if ($data->d_trs_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_trs_created ? with(new Carbon($data->d_trs_created))->format('d M Y') : '';
            }
        })
        ->editColumn('tglBuat', function ($data) 
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
        ->editColumn('methodReturn', function ($data) 
        {
            if ($data->d_pcsr_method == 'TK') 
            {
                return 'TUKAR BARANG';
            }
            else 
            {
                return 'POTONG NOTA';
            }
        })
        ->addColumn('action', function($data)
        {
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPenerimaan("'.$data->d_trs_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePenerimaan("'.$data->d_trs_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getDataDetail($id)
    {
        $dataHeader = d_terima_return_sup::join('d_purchasingreturn','d_terima_return_sup.d_trs_prid','=','d_purchasingreturn.d_pcsr_id')
            ->join('m_supplier','d_terima_return_sup.d_trs_sup','=','m_supplier.s_id')
            ->join('d_mem','d_terima_return_sup.d_trs_staff','=','d_mem.m_id')
            ->select('d_terima_return_sup.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasingreturn.d_pcsr_code', 'd_mem.m_name')
            ->where('d_terima_return_sup.d_trs_id', '=', $id)
            ->orderBy('d_trs_created', 'DESC')
            ->get();

        foreach ($dataHeader as $val) 
        {   //$total_disc = (int)$val->d_pcs_discount + (int)$val->d_pcs_disc_value;
            $data = array(
                /*'hargaTotBeliGross' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
                'hargaTotBeliDisc' => 'Rp. '.number_format($total_disc,2,",","."),
                'hargaTotBeliTax' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
                'hargaTotBeliNett' => 'Rp. '.number_format($val->d_pcs_total_net,2,",","."),
                'hargaTotalTerimaNett' => 'Rp. '.number_format($val->d_tb_totalnett,2,",","."),*/
                'tanggalTerima' => date('d-m-Y',strtotime($val->d_trs_date))
            );
        }

        $dataIsi = d_terima_return_supdt::join('d_terima_return_sup', 'd_terima_return_supdt.d_trsdt_idrs', '=', 'd_terima_return_sup.d_trs_id')
                ->join('m_item', 'd_terima_return_supdt.d_trsdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_terima_return_supdt.d_trsdt_sat', '=', 'm_satuan.s_id')
                ->join('d_purchasingreturn_dt', 'd_terima_return_supdt.d_trsdt_idrtdet', '=', 'd_purchasingreturn_dt.d_pcsrdt_id')
                ->select('d_terima_return_supdt.*', 'm_item.*', 'd_terima_return_sup.d_trs_code', 'm_satuan.s_id', 'm_satuan.s_name', 'd_purchasingreturn_dt.d_pcsrdt_qtyconfirm')
                ->where('d_terima_return_supdt.d_trsdt_idrs', '=', $id)
                ->orderBy('d_terima_return_supdt.d_trsdt_created', 'DESC')
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

    public function simpanPenerimaan(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //code penerimaan
            $dataHeader = new d_terima_return_sup;
            $dataHeader->d_trs_prid = $request->headNotaReturn;
            $dataHeader->d_trs_sup = $request->headSupplierId;
            $dataHeader->d_trs_comp = Session::get('user_comp');
            $dataHeader->d_trs_code = $this->kodePenerimaanAuto();
            $dataHeader->d_trs_staff = $request->headStaffId;
            $dataHeader->d_trs_noreff = $request->headNotaTxt;
            $dataHeader->d_trs_totalnett = $this->konvertRp($request->headTotalRetur);
            $dataHeader->d_trs_date = date('Y-m-d',strtotime($request->headTglTerima));
            $dataHeader->d_trs_created = Carbon::now();
            $dataHeader->save();
                  
            //get last lastId then insert id to d_terimapembelian_dt
            $lastId = d_terima_return_sup::select('d_trs_id')->max('d_trs_id');
            if ($lastId == 0 || $lastId == '') 
            {
                $lastId  = 1;
            }  

            //variabel untuk hitung array field
            $hitung_field = count($request->fieldItemId);

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
                DB::table('d_stock')->where('s_item', $request->fieldItemId[$i])->where('s_comp', $grup)
                ->where('s_position', $grup)->update(['s_qty' => $stokAkhir]);

                //get id d_stock
                $dstock_id = DB::table('d_stock')->select('s_id')->where('s_item', $request->fieldItemId[$i])
                ->where('s_comp', $grup)->where('s_position', $grup)->first();

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
                  'sm_mutcat' => '15',
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

                //insert d_terima_return_supdt
                $dataIsi = new d_terima_return_supdt;
                $dataIsi->d_trsdt_idrs = $lastId;
                $dataIsi->d_trsdt_smdetail = $hasil_id;
                $dataIsi->d_trsdt_item = $request->fieldItemId[$i];
                $dataIsi->d_trsdt_sat = $request->fieldSatuanId[$i];
                $dataIsi->d_trsdt_idrtdet = $request->fieldIdReturnDet[$i];
                $dataIsi->d_trsdt_qty = $request->fieldQtyterima[$i];
                $dataIsi->d_trsdt_price = $request->fieldHargaRaw[$i];
                $dataIsi->d_trsdt_pricetotal = $request->fieldHargaTotalRaw[$i];
                $dataIsi->d_trsdt_date_received = date('Y-m-d',strtotime($request->headTglTerima));
                $dataIsi->d_trsdt_created = Carbon::now();
                $dataIsi->save();

                //update isrecieved d_purchasing_returndt jika qty == terima
                $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_trsdt_qty), 0) as aa FROM d_terima_return_supdt where d_trsdt_idrtdet = '".$request->fieldIdReturnDet[$i]."'"));
                $qtyPcs = DB::select(DB::raw("SELECT IFNULL(sum(d_pcsrdt_qtyconfirm), 0) as bb FROM d_purchasingreturn_dt where d_pcsrdt_id = '".$request->fieldIdReturnDet[$i]."'"));

                if ($qtyRcv[0]->aa == $qtyPcs[0]->bb) 
                {
                   DB::table('d_purchasingreturn_dt')
                      ->where('d_pcsrdt_id', $request->fieldIdReturnDet[$i])
                      ->update(['d_pcsrdt_isreceived' => 'TRUE']);
                }
            }

            //cek pada table purchasingreturn_dt, jika isreceived semua tbl header ubah status ke RC
            $this->cek_status_purchasingretur($request->headNotaReturn);
            
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Penerimaan Retur Berhasil Disimpan'
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

    public function deletePenerimaan(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
          //cari item & qty d_terima_return_supdt
          $query = DB::table('d_terima_return_supdt')->select('d_trsdt_item', 'd_trsdt_qty', 'd_trsdt_smdetail', 'd_trsdt_sat', 'd_trsdt_idrtdet')->where('d_trsdt_idrs', $request->id)->get();

          //cari id purchase retur & update status ke CF
          $query2 = DB::table('d_terima_return_sup')->select('d_trs_id','d_trs_prid')->where('d_trs_id', $request->id)->first(); 
          //update status purchasingreturn to CF = "CONFIRMED"
          DB::table('d_purchasingreturn')->where('d_pcsr_id', $query2->d_trs_prid)->update(['d_pcsr_status' => 'CF']);

          foreach ($query as $value) 
          {
            //array variabel item m_item
            $item[] = $value->d_trsdt_item;
            //array variabel qty return
            $qty_terima[] = $value->d_trsdt_qty;
            //array variabel sm_detailid
            $id_smdetail[] = $value->d_trsdt_smdetail;
            //array variabel satuanid
            $id_satuan[] = $value->d_trsdt_sat;
            //array variabel id_returdt
            $id_returdt[] = $value->d_trsdt_idrtdet;
          }

          $hitung_row = count($item);
          for ($i=0; $i < $hitung_row; $i++) 
          { 
            $grup = $this->getGroupGudang($item[$i]);
            //cari id & s_qty d_stock
            $q_dstock = DB::table('d_stock')
              ->select('s_id', 's_qty')
              ->where('s_item', $item[$i])
              ->where('s_comp', $grup)
              ->where('s_position', $grup)
              ->first();
            //array variabel id_stock (d_stock)
            $id_stock[] = $q_dstock->s_id;
            //array variabel qty_stock (d_stock)
            $qty_stock[] = $q_dstock->s_qty;
          }

          for ($i=0; $i < $hitung_row ; $i++) 
          {
            //variabel u/ cek primary satuan
            $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $item[$i])->first();
            //konversi qty
            if ($primary_sat->i_sat1 == $id_satuan[$i]) 
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi1;
            }
            elseif ($primary_sat->i_sat2 == $id_satuan[$i])
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi2;
            }
            else
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi3;
            }

            $grup2 = $this->getGroupGudang($item[$i]);
            //kembalikan stok sebelum penerimaan
            $stokAkhir = (int)$qty_stock[$i] - (int)$hasilConvert;
            // update d_stock
            DB::table('d_stock')
              ->where('s_id', $id_stock[$i])
              ->update(['s_qty' => $stokAkhir]);

            //delete row table d_stock_mutation
            DB::table('d_stock_mutation')
              ->where('sm_stock', '=', $id_stock[$i])
              ->where('sm_detailid', '=', $id_smdetail[$i])
              ->delete();

            //update status to false
            DB::table('d_purchasingreturn_dt')->where('d_pcsrdt_id', $id_returdt[$i])
            ->update(['d_pcsrdt_isreceived' => 'FALSE']); 
          }

          //delete row table d_terima_return_supdt
          d_terima_return_supdt::where('d_trsdt_idrs', $request->id)->delete();
          //delete row table d_terima_return_sup
          d_terima_return_sup::where('d_trs_id', $request->id)->delete();
          //cek pada table purchasingreturn_dt, jika isreceived semua tbl header ubah status ke RC
          $this->cek_status_purchasingretur($query2->d_trs_prid);
          
          DB::commit();
          return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Penerimaan Retur Supplier Berhasil Dihapus'
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

        $data = DB::table('d_purchasingreturn_dt')
                  ->select('d_purchasingreturn_dt.*','d_purchasingreturn.d_pcsr_datecreated','d_purchasingreturn.d_pcsr_code','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','m_supplier.s_company','m_satuan.s_name','m_satuan.s_id')
                  ->leftJoin('d_purchasingreturn','d_purchasingreturn_dt.d_pcsrdt_idpcsr','=','d_purchasingreturn.d_pcsr_id')
                  ->leftJoin('m_item','d_purchasingreturn_dt.d_pcsrdt_item','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasingreturn_dt.d_pcsrdt_sat','=','m_satuan.s_id')
                  ->leftJoin('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')                  
                  ->where('d_purchasingreturn_dt.d_pcsrdt_isreceived', '=', "FALSE")
                  ->where('d_purchasingreturn.d_pcsr_method', '=', "TK")
                  ->whereBetween('d_purchasingreturn.d_pcsr_datecreated', [$tanggal1, $tanggal2])
                  ->orderBy('d_purchasingreturn.d_pcsr_datecreated', 'DESC')
                  ->where('d_pcsr_comp',Session::get('user_comp'))
                  ->get();

        for ($z=0; $z < count($data); $z++) 
        {   
          //variabel untuk menyimpan penjumlahan array qty penerimaan
          $hasil_qty_rcv = 0;
          //get data qty received
          $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_trsdt_qty), 0) as zz FROM d_terima_return_supdt where d_trsdt_idrtdet = '".$data[$z]->d_pcsrdt_id."'"));
          
          foreach ($qtyRcv as $nilai) 
          {
            $hasil_qty_rcv = (int)$nilai->zz;
          }
          //create new object properties and assign value
          $data[$z]->qty_remain = $data[$z]->d_pcsrdt_qtyconfirm - $hasil_qty_rcv;
        }

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
        {
          if ($data->d_pcsrdt_isreceived == "FALSE") 
          {
            return '<span class="label label-info">Belum Diterima</span>';
          }
          elseif ($data->d_pcsrdt_isreceived == "TRUE") 
          {
            return '<span class="label label-success">Disetujui</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_pcsrdt_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pcsrdt_created ? with(new Carbon($data->d_pcsrdt_created))->format('d M Y') : '';
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

        $data = DB::table('d_purchasingreturn_dt')
                  ->select('d_purchasingreturn_dt.*','d_purchasingreturn.d_pcsr_datecreated','d_purchasingreturn.d_pcsr_code','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','m_supplier.s_company','m_satuan.s_name','m_satuan.s_id')
                  ->leftJoin('d_purchasingreturn','d_purchasingreturn_dt.d_pcsrdt_idpcsr','=','d_purchasingreturn.d_pcsr_id')
                  ->leftJoin('m_item','d_purchasingreturn_dt.d_pcsrdt_item','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasingreturn_dt.d_pcsrdt_sat','=','m_satuan.s_id')
                  ->leftJoin('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')                  
                  ->where('d_purchasingreturn_dt.d_pcsrdt_isreceived', '=', "TRUE")
                  ->where('d_purchasingreturn.d_pcsr_method', '=', "TK")
                  ->whereBetween('d_purchasingreturn.d_pcsr_datecreated', [$tanggal1, $tanggal2])
                  ->orderBy('d_purchasingreturn.d_pcsr_datecreated', 'DESC')
                  ->get();

        for ($z=0; $z < count($data); $z++) 
        {   
          //variabel untuk menyimpan penjumlahan array qty penerimaan
          $hasil_qty_rcv = 0;
          //get data qty received
          $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_trsdt_qty), 0) as zz FROM d_terima_return_supdt where d_trsdt_idrtdet = '".$data[$z]->d_pcsrdt_id."'"));
          
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
          if ($data->d_pcsrdt_isreceived == "FALSE") 
          {
            return '<span class="label label-info">Belum Diterima</span>';
          }
          elseif ($data->d_pcsrdt_isreceived == "TRUE") 
          {
            return '<span class="label label-success">Diterima</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
        {
          if ($data->d_pcsrdt_created == null) 
          {
              return '-';
          }
          else 
          {
              return $data->d_pcsrdt_created ? with(new Carbon($data->d_pcsrdt_created))->format('d M Y') : '';
          }
        })
        ->addColumn('action', function($data)
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailListReceived("'.$data->d_pcsrdt_id.'")><i class="fa fa-eye"></i> 
                      </button>
                  </div>';
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function getPenerimaanPeritem($id)
    {
        $dataHeader = d_purchasingreturn_dt::join('d_purchasingreturn','d_purchasingreturn_dt.d_pcsrdt_idpcsr','=','d_purchasingreturn.d_pcsr_id')
            ->join('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')
            ->select('d_purchasingreturn.d_pcsr_code', 'd_purchasingreturn_dt.d_pcsrdt_qty', 'd_purchasingreturn.d_pcsr_datecreated', 'm_supplier.s_company')
            ->where('d_purchasingreturn_dt.d_pcsrdt_id', '=', $id)
            ->get();

        $dataIsi = d_terima_return_supdt::join('d_terima_return_sup', 'd_terima_return_supdt.d_trsdt_idrs', '=', 'd_terima_return_sup.d_trs_id')
            ->join('m_item', 'd_terima_return_supdt.d_trsdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_terima_return_supdt.d_trsdt_sat', '=', 'm_satuan.s_id')
            ->select('m_item.i_name', 'm_item.i_code', 'm_satuan.s_name', 'd_terima_return_supdt.d_trsdt_qty', 'd_terima_return_sup.d_trs_code', 'd_terima_return_supdt.d_trsdt_date_received', 'd_terima_return_sup.d_trs_date')
            ->where('d_terima_return_supdt.d_trsdt_idrtdet', '=', $id)
            ->orderBy('d_terima_return_supdt.d_trsdt_date_received', 'ASC')
            ->get();

        foreach ($dataIsi as $val) 
        {   
          $tanggalTerima[] = date('d-m-Y',strtotime($val->d_trsdt_date_received));
        }
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'isi' => $dataIsi,
            'tanggalTerima' => $tanggalTerima
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

    public function kodePenerimaanAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_trs_code,5)) as kode_max from d_terima_return_sup WHERE DATE_FORMAT(d_trs_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

        return $codeTerimaBeli = "TRS-".date('ym')."-".$kd;
    }

    public function getGroupGudang($id_item)
    {
        $typeBrg = DB::table('m_item')->select('i_type')->where('i_id','=', $id_item)->first();
        if ($typeBrg->i_type == "BB") 
        {
          $cabang=Session::get('user_comp');                
          $dataGudang = DB::table('d_gudangcabang')
                        ->where('gc_comp',$cabang)
                        ->where('gc_gudang','GUDANG BAHAN BAKU')
                        ->select('gc_id','gc_gudang')
                        ->first();
          $idGroupGdg = $dataGudang->gc_id;
        } 
        elseif ($typeBrg->i_type == "BJ") 
        {
          $cabang=Session::get('user_comp');                
          $dataGudang = DB::table('d_gudangcabang')
                        ->where('gc_comp',$cabang)
                        ->where('gc_gudang','GUDANG PENJUALAN')
                        ->select('gc_id','gc_gudang')
                        ->first();
          $idGroupGdg = $dataGudang->gc_id;
        }
        return $idGroupGdg;
    }

    public function konvertRp($value)
    {
        $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
        return (int)str_replace(',', '.', $value);
    }

    public function cek_status_purchasingretur($id_pcsrtr)
    {
      //tanggal sekarang
      $tgl = Carbon::today()->toDateString();
      //cek pada table purchasing rtur dt, jika isreceived semua tbl header ubah status ke RC
      $data_dt = DB::table('d_purchasingreturn_dt')->select('d_pcsrdt_isreceived')->where('d_pcsrdt_idpcsr', '=', $id_pcsrtr)->get();

      foreach ($data_dt as $x) { $data_status[] = $x->d_pcsrdt_isreceived; }

      if (!in_array("FALSE", $data_status, TRUE)) 
      {
        DB::table('d_purchasingreturn')->where('d_pcsr_id', $id_pcsrtr)->update(['d_pcsr_status' => 'RC', 'd_pcsr_datereceived' => $tgl]);
      }
    }

    public function printTandaTerima($id)
    {
        $dataHeader = d_terima_return_sup::join('d_purchasingreturn','d_terima_return_sup.d_trs_prid','=','d_purchasingreturn.d_pcsr_id')
            ->join('m_supplier','d_terima_return_sup.d_trs_sup','=','m_supplier.s_id')
            ->join('d_mem','d_terima_return_sup.d_trs_staff','=','d_mem.m_id')
            ->select('d_terima_return_sup.*', 'm_supplier.s_id', 'm_supplier.s_name', 'm_supplier.s_company', 'd_purchasingreturn.*', 'd_mem.m_name')
            ->where('d_terima_return_sup.d_trs_id', '=', $id)
            ->orderBy('d_trs_created', 'DESC')
            ->get()->toArray();

        $dataIsi = d_terima_return_supdt::join('d_terima_return_sup', 'd_terima_return_supdt.d_trsdt_idrs', '=', 'd_terima_return_sup.d_trs_id')
                ->join('m_item', 'd_terima_return_supdt.d_trsdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_terima_return_supdt.d_trsdt_sat', '=', 'm_satuan.s_id')
                ->join('d_purchasingreturn_dt', 'd_terima_return_supdt.d_trsdt_idrtdet', '=', 'd_purchasingreturn_dt.d_pcsrdt_id')
                ->select('d_terima_return_supdt.*', 'm_item.*', 'd_terima_return_sup.d_trs_code', 'm_satuan.s_id', 'm_satuan.s_name', 'd_purchasingreturn_dt.d_pcsrdt_qtyconfirm')
                ->where('d_terima_return_supdt.d_trsdt_idrs', '=', $id)
                ->orderBy('d_terima_return_supdt.d_trsdt_created', 'DESC')
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
           
        return view('Inventory::p_returnsuplier.print', compact('dataHeader', 'dataIsi', 'val_stock', 'txt_satuan'));
    }
    // ============================================================================================================== //
}