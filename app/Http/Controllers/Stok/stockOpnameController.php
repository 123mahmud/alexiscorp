<?php

namespace App\Http\Controllers\Stok;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\d_gudangcabang;
use App\d_stock;
use App\m_item;
use DB;
use Response;
use Session;
use App\d_opname;
use App\d_opnamedt;
use App\d_stock_mutation;
use App\Lib\mutasi;
use Carbon\Carbon;
use Datatables;
use Auth;

class stockOpnameController extends Controller
{
    public function index(){
    	$cabang=Session::get('user_comp');                
        $dataGudang = DB::table('d_gudangcabang')
                    ->where('gc_comp',$cabang)
                    ->select('gc_id','gc_gudang')->get();

    	return view('stok/opnamebahanbaku/opnamebahanbaku',compact('dataGudang'));
    }

    public function tableOpname(Request $request, $comp)
    {
      $cekGudang = d_gudangcabang::where('gc_id',$comp)->first();
      if ($cekGudang->gc_gudang == 'GUDANG BAHAN BAKU') 
      {
        $term = $request->term;
        $results = array();
        $queries = m_item::
          select('i_id',
                'i_code',
                'i_name',
                's_name',
                's_qty')
          ->where('m_item.i_name', 'LIKE', '%'.$term.'%')
          ->where('i_isactive','Y')
          ->where('i_type','BB')
          ->leftJoin('d_stock',function($join)use($comp){
            $join->on('i_id','=','s_item');
            $join->on('s_comp','=',DB::raw($comp));
            $join->on('s_position','=',DB::raw($comp));
          })
          ->leftJoin('m_satuan','m_satuan.s_id','=','i_sat1')
          ->take(15)->get();
      }
      else if ($cekGudang->gc_gudang == 'GUDANG PENJUALAN') 
      {
        $term = $request->term;
        $results = array();
        $queries = m_item::
          select('i_id',
                'i_code',
                'i_name',
                's_name',
                's_qty',
               'i_sat1',
               'i_sat2',
               'i_sat3',
               'i_sat_isi1',
               'i_sat_isi2',
               'i_sat_isi3')
          ->where('m_item.i_name', 'LIKE', '%'.$term.'%')
          ->where('i_isactive','Y')
          ->where('i_type','!=','BB')
          ->leftJoin('d_stock',function($join)use($comp){
            $join->on('i_id','=','s_item');
            $join->on('s_comp','=',DB::raw($comp));
            $join->on('s_position','=',DB::raw($comp));
          })
          ->leftJoin('m_satuan','m_satuan.s_id','=','i_sat1')
          ->take(15)->get();
      }
      else if ($cekGudang->gc_gudang == 'GUDANG PRODUKSI') 
      {
        $term = $request->term;
        $results = array();
        $queries = m_itemm::
          select('i_id',
                'i_code',
                'i_name',
                's_name',
                's_qty')
          ->where('m_item.i_name', 'LIKE', '%'.$term.'%')
          ->where('i_isactive','Y')
          ->where('i_type','BP')
          ->leftJoin('d_stock',function($join)use($comp){
            $join->on('i_id','=','s_item');
            $join->on('s_comp','=',DB::raw($comp));
            $join->on('s_position','=',DB::raw($comp));
          })
          ->leftJoin('m_satuan','m_satuan.s_id','=','i_sat1')
          ->take(15)->get();
      }
      else
      {
        $term = $request->term;
        $results = array();
        $queries = m_item::
          select('i_id',
                'i_code',
                'i_name',
                's_name',
                's_qty')
          ->where('m_item.i_name', 'LIKE', '%'.$term.'%')
          ->where('i_isactive','Y')
          ->leftJoin('d_stock',function($join)use($comp){
            $join->on('i_id','=','s_item');
            $join->on('s_comp','=',DB::raw($comp));
            $join->on('s_position','=',DB::raw($comp));
          })
          ->leftJoin('m_satuan','m_satuan.s_id','=','i_sat1')
          ->take(15)->get();
      }
      
      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query)
        {
            $txtSat1 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $query->i_sat1)->first();
            $txtSat2 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $query->i_sat2)->first();
            $txtSat3 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $query->i_sat3)->first();

            $results[] = [  'id' => $query->i_id,
                          'label' => $query->i_code .' - '.$query->i_name,
                          'i_code' => $query->i_code,
                          'i_name' => $query->i_name,
                          's_qtykw' => number_format($query->s_qty,2,',','.').' '.$query->s_name,
                          's_qty' => $query->s_qty,
                          'sat' => [$query->i_sat_isi1, $query->i_sat_isi2, $query->i_sat_isi3],
                          'satTxt' => [$txtSat1->s_name, $txtSat2->s_name, $txtSat3->s_name],
                          'm_sname' => $query->s_name,
                          'm_sid' => $query->i_sat1
                      ];

        }
      }

    return Response::json($results);

    }

    public function history($tgl1, $tgl2, $jenis, $gudang){
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
        $tgl2 = $y2.'-'.$m2.'-'.$d2;
        $tgl2 = date('Y-m-d',strtotime($tgl2 . "+1 days"));

      $opname = d_opname::select(
            'o_id',
            'o_insert',
            'o_nota',
            'u1.gc_gudang as comp',
            'o_confirm',
            'o_status',
            'm_username')
        ->join('d_gudangcabang as u1', 'd_opname.o_comp', '=', 'u1.gc_id')
        ->join('d_mem','d_mem.m_id','=','d_opname.o_staff')
        ->where('o_insert','>=',$tgll)
        ->where('o_insert','<=',$tgl2)
        ->where('o_status',$jenis)
        ->where('o_comp',$gudang)
        ->get();

      return DataTables::of($opname)
      ->editColumn('date', function ($data) {
        return date('d M Y', strtotime($data->o_insert)).' : '.substr($data->o_insert, 10, 18);;

      })

      ->editColumn('status', function ($data) 
      {
         if ($data->o_status == 'LP') 
         {
            return '<span class="label label-default">Reporting</span>';
         }
         else
         {
            if ($data->o_confirm == "WT") 
            { 
               return '<span class="label label-default">Waiting</span>'; 
            }
            else if ($data->o_confirm == "AP") 
            { 
               return '<span class="label label-primary">Aprrove</span>'; 
            }
            else if ($data->o_confirm == "CL") 
            {
               return '<span class="label label-info">Final</span>'; 
            }
         }
         
      })

      ->addColumn('action', function($data)
      {
         if ($data->o_status == "LP")
         {
            return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        onclick="EditOpname('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-danger fa fa-trash-o"
                        title="Hapus"
                        type="button"
                        onclick="deleteOp('."'".$data->o_id."'".')"
                    </button>
                </div>';
         }
         else if (($data->o_status == "MS"))
         {
            if ($data->o_confirm == "WT") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        onclick="EditOpname('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-danger fa fa-trash-o"
                        title="Hapus"
                        type="button"
                        onclick="deleteOp('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "AP") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        onclick="EditOpname('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "CL") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            
         }
        
      })

      ->rawColumns(['date','action','status'])
      ->make(true);

    }

   public function getOPname(Request $request){
      $data = d_opnamedt::select( 'i_code',
                            'i_type',
                            'i_name',
                            'od_opname',
                            's_name')
        ->where('od_ido',$request->x)
        ->join('m_item','i_id','=','od_item')
        ->join('m_satuan','s_id','=','i_sat1')
        ->get();
        // dd($data);
      return view('stok.opnamebahanbaku.detail-opname',compact('data'));
   }

   public function print_stockopname($id){
      $data = d_opnamedt::select( 'i_code',
                            'i_type',
                            'i_name',
                            'od_opname',
                            's_name',
                            'o_nota',
                            'u1.gc_gudang as comp',
                            'u2.gc_gudang as position')
        ->where('od_ido',$id)
        ->join('d_opname','d_opname.o_id','=','od_ido')
        ->join('d_gudangcabang as u1', 'd_opname.o_comp', '=', 'u1.gc_id')
        ->join('d_gudangcabang as u2', 'd_opname.o_position', '=', 'u2.gc_id')
        ->join('m_item','i_id','=','od_item')
        ->join('m_satuan','s_id','=','i_sat1')
        ->get();
        // dd($data);
      return view('Inventory::stockopname.print_stockopname',compact('data'));
   }

   public function saveOpnameLaporan(Request $request)
   {
        DB::beginTransaction();
        try {
            $o_id = d_opname::max('o_id') + 1;
            //nota
            $year = carbon::now()->format('y');
            $month = carbon::now()->format('m');
            $date = carbon::now()->format('d');
            $nota = 'OD'  . $year . $month . $date . $o_id;
            //end Nota
            d_opname::insert([
                'o_id' => $o_id,
                'o_nota' => $nota,
                'o_outlet' => Session::get('user_comp'),
                'o_staff' => $request->o_staff,
                'o_comp' => $request->o_comp,
                'o_status' => 'LP',
                'o_insert' => Carbon::now()
            ]);

            for ($i=0; $i < count($request->i_id); $i++) 
            {
                d_opnamedt::insert([
                    'od_ido' => $o_id,
                    'od_idodt' => $i+1,
                    'od_item' => $request->i_id[$i],
                    'od_system' => $request->qty[$i],
                    'od_real' => $request->real[$i],
                    'od_opname' => $request->opname[$i],
                    'od_satuan' => $request->satuan_id[$i]
                ]);
            }

            DB::commit();
            return response()->json([
                    'status' => 'sukses',
                    'nota' => $nota
                ]);
            } catch (\Exception $e) {
             DB::rollback();
             return response()->json([
                  'status' => 'gagal',
                  'data' => $e
                ]);
            }
   }

   function simpanPengajuan(Request $request)
   {
      DB::beginTransaction();
      try {
      $o_id = d_opname::max('o_id') + 1;
      //nota
      $year = carbon::now()->format('y');
      $month = carbon::now()->format('m');
      $date = carbon::now()->format('d');
      $nota = 'OD'  . $year . $month . $date . $o_id;
      //end Nota
      d_opname::insert([
         'o_id' => $o_id,
         'o_nota' => $nota,
         'o_outlet' => Session::get('user_comp'),
         'o_staff' => $request->o_staff,
         'o_comp' => $request->o_comp,
         'o_status' => 'MS',
         'o_insert' => Carbon::now()
      ]);

      for ($i=0; $i < count($request->i_id); $i++) 
      {
      d_opnamedt::insert([
         'od_ido' => $o_id,
         'od_idodt' => $i+1,
         'od_item' => $request->i_id[$i],
         'od_system' => str_replace(",","",$request->qty[$i]),
         'od_real' => str_replace(",","",$request->real[$i]),
         'od_opname' => str_replace(",","",$request->opname[$i]),
         'od_satuan' => $request->satuan_id[$i]
      ]);
      }

      DB::commit();
      return response()->json([
         'status' => 'sukses',
         'nota' => $nota
      ]);
      } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
       'status' => 'gagal',
       'data' => $e
      ]);
      }
   }

   public function editLaporan($id)
   {
      $dataIsi = d_opname::select('o_nota',
                                 'o_id',
                                 'i_id',
                                 'i_code',
                                 'i_name',
                                 'i_sat1',
                                 'gc_id',
                                 'gc_gudang',
                                 'od_real',
                                 's_name',
                                 'o_confirm',
                                 'o_status'
                                 )
         ->join('d_opnamedt','d_opnamedt.od_ido','=','d_opname.o_id')
         ->join('m_item','m_item.i_id','=','d_opnamedt.od_item')
         ->join('d_gudangcabang','d_gudangcabang.gc_id','=','d_opname.o_comp')
         ->join('m_satuan','m_satuan.s_id','=','m_item.i_sat1')
         ->where('o_id',$id)
         ->get();

      foreach ($dataIsi as $val) 
      {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val['i_id'])->first();
          //get satuan utama
          $sat1[] = $val['i_sat1'];
      }
      // dd($dataIsi);

      $counter = 0;
      $gudang = $dataIsi[0]->gc_id;
      $comp = Session::get('user_comp');
      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
      $staff['nama'] = Auth::user()->m_name;
      $staff['id'] = Auth::User()->m_id;
      $dataItem = array(   'data_isi' => $dataIsi, 
                           'data_stok' => $dataStok['val_stok'], 
                           'data_satuan' => $dataStok['txt_satuan']
                  );

      return view('stok.opnamebahanbaku.edit-opname', compact('dataIsi','dataItem','staff'));
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
         elseif ($val->i_type == "SP") //bahan lain
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
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
   }

   public function tableConfirm($tgl1, $tgl2, $gudang)
   {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
        $tgl2 = $y2.'-'.$m2.'-'.$d2;
        $tgl2 = date('Y-m-d',strtotime($tgl2 . "+1 days"));

      $opname = d_opname::select(
            'o_id',
            'o_insert',
            'o_nota',
            'u1.gc_gudang as comp',
            'o_confirm',
            'o_status',
            'm_username')
        ->join('d_gudangcabang as u1', 'd_opname.o_comp', '=', 'u1.gc_id')
        ->join('d_mem','d_mem.m_id','=','d_opname.o_staff')
        ->where('o_insert','>=',$tgll)
        ->where('o_insert','<=',$tgl2)
        ->where('o_status','MS')
        ->where('o_comp',$gudang)
        ->get();


      return DataTables::of($opname)
      ->editColumn('date', function ($data) {
        return date('d M Y', strtotime($data->o_insert)).' : '.substr($data->o_insert, 10, 18);;

      })

      ->editColumn('status', function ($data) {
         if ($data->o_confirm == "WT") 
         { 
            return '<span class="label label-default">Waiting</span>'; 
         }
         else if ($data->o_confirm == "AP") 
         { 
            return '<span class="label label-primary">Aprrove</span>'; 
         }
         else if ($data->o_confirm == "CL") 
         {
            return '<span class="label label-info">Final</span>'; 
         }
      })

      ->addColumn('action', function($data){
            if ($data->o_confirm == "WT") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalConfirm"
                        onclick="ubahStatusConfirm('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "AP") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalConfirm"
                        onclick="ubahStatusConfirm('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "CL") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn-sm btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalConfirm"
                        onclick="ubahStatusConfirm('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }

      })

      ->rawColumns(['date','action','status'])
      ->make(true);
   }

   public function getConfirm(Request $request)
   {
      $data = d_opnamedt::select( 'i_code',
                                 'i_type',
                                 'i_name',
                                 'od_opname',
                                 'od_system',
                                 'od_opname',
                                 'od_real',
                                 's_name')
        ->where('od_ido',$request->x)
        ->join('m_item','i_id','=','od_item')
        ->join('m_satuan','s_id','=','od_satuan')
        ->get();

      $status = d_opname::select('o_id',
                                 'o_confirm')
         ->where('o_id',$request->x)
         ->first();

      return view('stok.opnamebahanbaku.detail-opname-confirm',compact('data','status'));
   }

   public function updateStatusConfirm(Request $request, $id)
   {
      DB::beginTransaction();
         try {
         $data = d_opname::where('o_id',$id)
            ->update([
             'o_confirm' => $request->x,
             'o_update' => Carbon::now()
         ]);
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

   function updateOpname(Request $request, $id)
   {
      DB::beginTransaction();
         try {
         $total_opname = 0;
         $akun_first = [];
         $err = true;
         d_opname::where('o_id',$id)
            ->update([
             'o_staff' => $request->o_staff,
             'o_update' => Carbon::now()
         ]);

         d_opnamedt::where('od_ido',$id)->delete();

         for ($i=0; $i < count($request->i_id); $i++) 
         {
             d_opnamedt::insert([
               'od_ido' => $id,
               'od_idodt' => $i+1,
               'od_item' => $request->i_id[$i],
               'od_system' => str_replace(",","",$request->qty[$i]),
               'od_real' => str_replace(",","",$request->real[$i]),
               'od_opname' => str_replace(",","",$request->opname[$i]),
               'od_satuan' => $request->satuan_id[$i],
             ]);
         }

      DB::commit();
      return response()->json([
             'status' => 'sukses',
             'nota' => $request->o_nota
         ]);
      } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
           'status' => 'gagal',
           'data' => $e
         ]);
      }
   }

   function updateStock(Request $request, $id)
   {
      // dd($request->all());
      DB::beginTransaction();
        try {
      d_opname::where('o_id',$id)
         ->update([
            'o_staff' => $request->o_staff,
            'o_status' => 'MS',
            'o_confirm' => 'CL',
            'o_update' => Carbon::now()
         ]);

      $nota = d_opname::select('o_nota')->where('o_id',$id)->first();
      $nota = $nota->o_nota;

      d_opnamedt::where('od_ido',$id)->delete();

      for ($i=0; $i < count($request->i_id); $i++) {

         d_opnamedt::insert([
            'od_ido' => $id,
            'od_idodt' => $i+1,
            'od_item' => $request->i_id[$i],
            'od_system' => str_replace(",","",$request->qty[$i]),
            'od_real' => str_replace(",","",$request->real[$i]),
            'od_opname' => str_replace(",","",$request->opname[$i]),
            'od_satuan' => $request->satuan_id[$i],
         ]);

         $cek = d_stock::select('s_id','s_qty')
            ->where('s_item', $request->i_id[$i])
            ->where('s_comp', $request->o_comp)
            ->where('s_position', $request->o_comp)
            ->first();

         if ($cek == null) {
            $s_id = d_stock::select('s_id')->max('s_id')+1;
               d_stock::create([
                  's_id' => $s_id,
                  's_comp' => $request->o_comp,
                  's_position' => $request->o_comp,
                  's_item' => $request->i_id[$i],
                  's_qty' => $request->opname[$i],
                  's_insert' => Carbon::now()
               ]);

               d_stock_mutation::create([
                  'sm_stock' => $s_id,
                  'sm_detailid' => 1,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => $request->o_comp,
                  'sm_position' => $request->o_comp,
                  'sm_mutcat' => 9,
                  'sm_item' => $request->i_id[$i],
                  'sm_qty' => $request->opname[$i],
                  'sm_qty_used' => 0,
                  'sm_qty_sisa' => $request->opname[$i],
                  'sm_qty_expired' => 0,
                  'sm_detail' => 'MENAMBAH OPNAME',
                  'sm_reff' => $nota,
                  'sm_insert' => Carbon::now()
               ]);

         }
         else
         {
            $hasil = $cek->s_qty + $request->opname[$i];
            $sm_detailid = d_stock_mutation::select('sm_detailid')
               ->where('sm_item', $request->i_id[$i])
               ->where('sm_comp', $request->o_comp)
               ->where('sm_position', $request->o_comp)
               ->max('sm_detailid')+1;
        // dd($sm_detailid);
          if ( $request->opname[$i] <= 0) {//+            
            if(mutasi::mutasiStok(  $request->i_id[$i],
                                    - $request->opname[$i],
                                    $comp=$request->o_comp,
                                    $position=$request->o_comp,
                                    $flag='MENGURANGI OPNAME',
                                    $nota,
                                    '',
                                    date('Y-m-d'),
                                    7
                                  )){}
          } else {
            $cek->update([
              's_qty' => $hasil
            ]);

            d_stock_mutation::create([
              'sm_stock' => $cek->s_id,
              'sm_detailid' => $sm_detailid,
              'sm_date' => Carbon::now(),
              'sm_comp' => $request->o_comp,
              'sm_position' => $request->o_comp,
              'sm_mutcat' => 9,
              'sm_item' => $request->i_id[$i],
              'sm_qty' => $request->opname[$i],
              'sm_qty_used' => 0,
              'sm_qty_sisa' => $request->opname[$i],
              'sm_qty_expired' => 0,
              'sm_detail' => 'PENAMBAHAN',
              'sm_reff' => $nota,
              'sm_insert' => Carbon::now()
            ]);
          }
        }
      }

      DB::commit();
      return response()->json([
         'status' => 'sukses',
         'nota' => $nota
         ]);
      } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
           'status' => 'gagal',
           'data' => $e
         ]);
      }
   }

   public function hapusLapOpname($id)
   {
      DB::beginTransaction();
      try {
         $nota = d_opname::select('o_nota')->where('o_id',$id)->first();
         $o_id = d_opname::where('o_id',$id)->delete();

         DB::commit();
         return response()->json([
                'status' => 'sukses',
                'nota' => $nota->o_nota
            ]);
         } catch (\Exception $e) {
         DB::rollback();
         return response()->json([
              'status' => 'gagal',
              'data' => $e
            ]);
         }
   }
}
