<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use carbon\Carbon;
use App\m_customer;
use App\m_kendaraan;
use CodeGenerator;
use Yajra\DataTables\DataTables;
use Crypt;

class MasterCustomerController extends Controller
{

    public function getList()
    {
      $customer = DB::table('m_customer')
      ->orderBy('c_id', 'desc')
      ->get();
      return Datatables::of($customer)

      ->addColumn('c_name', function($data) {
         return $data->c_code.' - '.$data->c_name;
      })

      ->addColumn('c_type', function($data) {
         if ($data->c_type == 'KT') 
         {
            return 'Kontraktor';
         } 
         else 
         {
            return 'Harian';
         }
      })

      ->addColumn('telp', function($data) {
         if ($data->c_hp2 != null) 
         {
            return '<td>'. $data->c_hp1 .'|'. $data->c_hp2 .'</td>';
         } 
         else 
         {
            return '<td>'. $data->c_hp1 .'</td>';
         }
      })

      ->addColumn('action', function($data) {
         if ($data->c_isactive == 'Y') 
         {
            return  '<div class="text-center">'.
                        '<button id="edit" 
                            onclick=edit("'.Crypt::encrypt($data->c_id).'")
                            class="btn btn-warning btn-sm" 
                            title="Edit">
                            <i class="fa fa-pencil"></i>
                        </button>'.'
                        <button id="status'.$data->c_id.'" 
                            onclick="ubahStatus('.$data->c_id.')" 
                            class="btn btn-primary btn-sm" 
                            title="Aktif">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                        </button>'.'
                    </div>';
         }
         else
         {
            return  '<div class="text-center">'.
                        '<button id="status'.$data->c_id.'" 
                            onclick="ubahStatus('.$data->c_id.')" 
                            class="btn btn-danger btn-sm" 
                            title="Tidak Aktif">
                            <i class="fa fa-minus-square" aria-hidden="true"></i>
                        </button>'.
                    '</div>';
         }
        
      })
      ->rawColumns(['telp', 'action'])
      ->make(true);
    }

    public function index()
    {
      return view('master/datacustomer/datacustomer');
    }

    public function create()
    {
      return view('master/datacustomer/tambah_datacustomer');
    }

    public function store(Request $request)
    {

      DB::beginTransaction();
      try {
            $year = carbon::now()->format('y');
            $month = carbon::now()->format('m');
            $date = carbon::now()->format('d');

            $id_cust = DB::Table('m_customer')->max('c_id')+1;
            $kode = 'CUS' . $month . $year . '/' . 'C001' . '/' . $id_cust;
            if ($request->tgl_lahir == '') {
                DB::table('m_customer')
                    ->insert([
                        'c_id' => $id_cust,
                        'c_code' => $kode,
                        'c_name' => $request->c_name,
                        'c_type' => $request->c_type,
                        'c_email' => $request->c_email,
                        'c_hp1' => $request->c_hp1,
                        'c_hp2' => $request->no_hp2,
                        'c_address' => $request->c_address,
                        'c_pagu' => str_replace(',', '',  $request->c_pagu),
                        'c_jatuh_tempo' => $request->c_jatuh_tempo,
                        'c_insert' => Carbon::now()
                    ]);
            } else {
                DB::table('m_customer')
                    ->insert([
                        'c_id' => $id_cust,
                        'c_code' => $kode,
                        'c_name' => $request->c_name,
                        'c_type' => $request->c_type,
                        'c_birthday' => date('Y-m-d', strtotime($request->c_birthday)),
                        'c_email' => $request->c_email,
                        'c_hp1' => $request->c_hp1,
                        'c_hp2' => $request->c_hp2,
                        'c_address' => $request->c_address,
                        'c_pagu' => str_replace(',', '',  $request->c_pagu),
                        'c_jatuh_tempo' => $request->c_jatuh_tempo,
                        'c_insert' => Carbon::now()
                    ]);
            }

        // insert Kendaraan
        $nopols = $request->nopol;
        foreach ($nopols as $nopol) {
          if ($nopol != null) {
            $k_id = m_kendaraan::max('k_id') + 1;
            $kendaraan            = new m_kendaraan;
            $kendaraan->k_id      = $k_id;
            $kendaraan->k_pemilik = $id_cust;
            $kendaraan->k_flag    = 'CUSTOMER';
            $kendaraan->k_nopol   = $nopol;
            $kendaraan->save();
          }
        }

        DB::commit();
        return response()->json([
          'status' => 'sukses'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal',
          'message' => $e->getMessage()
        ]);
      }
    }


   public function editCustomer(Request $request)
   {
      $customer = DB::table('m_customer')
                         ->where('c_id' , Crypt::decrypt($request->id))
                         ->first();

      $kendaraan = DB::table('m_kendaraan')
                            ->where('k_pemilik' , Crypt::decrypt($request->id))
                            ->where('k_flag' , 'CUSTOMER')
                            ->get();

      return view('master.datacustomer.edit_datacustomer' , compact('customer','kendaraan'));
   }

    public function update(Request $request)
    {
      DB::beginTransaction();
         try {
            DB::table('m_customer')
            ->where('c_id' , Crypt::decrypt($request->id))
            ->update([
                'c_name' => $request->c_name,
                'c_birthday' => date('Y-m-d', strtotime($request->c_birthday)),
                'c_email' => $request->c_email,
                'c_hp1' => $request->c_hp1,
                'c_hp2' => $request->c_hp2,
                'c_address' => $request->c_address,
                'c_pagu' => str_replace(',', '', $request->c_pagu),
                'c_jatuh_tempo' => $request->c_jatuh_tempo,
                'c_type' => $request->c_type,
                'c_update' => Carbon::now()
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

   public function ubahStatus(Request $request)
   {
        DB::beginTransaction();
        try {
        $cek = DB::table('m_customer')->select('c_isactive')
            ->where('c_id',$request->id)
            ->first();
        if ($cek->c_isactive == 'Y') 
        {
            DB::table('m_customer')
            ->where('c_id',$request->id)
            ->update([
                'c_isactive' => 'N'
            ]);
        }
        else
        {
            DB::table('m_customer')
            ->where('c_id',$request->id)
            ->update([
                'c_isactive' => 'Y'
            ]);
        }
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

}
