<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Crypt;
use carbon\Carbon;
use App\MasterBarang;
use DataTables;

class MasterSupplierController extends Controller
{
    public function datasuplier()
    {
        $data['supplier'] = DB::table('m_supplier')
                            ->join('m_comp' , 'c_code' , '=' , 's_company')
                            ->get();
    	return view('master/datasuplier/datasuplier' , compact('data'));
    }
    public function tambah_datasuplier()
    {   
        $data['cabang'] = DB::table('m_comp')
                        ->get();
                
          return view('master/datasuplier/tambah_datasuplier');
    }

   public function edit_datasuplier(Request $request)
   {
     	$data['supplier'] = DB::table('m_supplier')
                         ->where('s_id' , Crypt::decrypt($request->id))
                         ->get();

     	$data['kendaraan'] = DB::table('m_kendaraan')
                            ->where('k_pemilik' , Crypt::decrypt($request->id))
                            ->where('k_flag' , 'SUPPLIER')
                            ->get();

      return view('master/datasuplier/edit_datasuplier' , compact('data'));
   }

   public function update(Request $request){
   	// dd($request->all());
      DB::beginTransaction();
        	try {
            DB::table('m_supplier')
            ->where('s_id' , Crypt::decrypt($request->id))
            ->update([
                's_company' => $request->s_company,
                's_npwp' => $request->s_npwp,
                's_email' => $request->s_email,
                's_address' => $request->s_address,
                's_phone1' => $request->s_phone1,
                's_phone2' => $request->s_phone2,
                's_rekening' => $request->s_rekening,
                's_bank' => $request->s_bank,
                's_fax' => $request->s_fax,
                's_note' => $request->s_note,
                's_top' => $request->s_top,
                's_limit' => str_replace(',', '', $request->s_limit),
                's_update' => Carbon::now()
            ]);

            DB::DELETE("DELETE FROM m_kendaraan where k_flag = 'SUPPLIER' and k_pemilik = 'Crypt::decrypt($request->id)'");

            for($j = 0; $j < count($request->nopol); $j++){
                $urut_kendaraan = DB::table('m_kendaraan')
                        ->max('k_id');
                $urut_kendaraan = $urut_kendaraan +1;
                DB::table('m_kendaraan')
                ->insert([
                    'k_id' => $urut_kendaraan,
                    'k_pemilik' => Crypt::decrypt($request->id),
                    'k_flag' => 'SUPPLIER',
                    'k_nopol' => strtoupper($request->nopol[$j]),
                    'updated_at' => Carbon::now()

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

    public function save_datasupplier(Request $request){
         DB::beginTransaction();
        	try {
          	//nota
            $s_id = DB::table('m_supplier')->max('s_id')+1;
		      $index = str_pad($s_id, 6, '0' , STR_PAD_LEFT);
		      $nota = 'SP' . '-' . $index;
            //end nota
            DB::table('m_supplier')
            ->insert([
                's_id' => $s_id,
                's_code' => $nota,
                's_company' => $request->namasupplier,
                's_npwp' => $request->npwp,
                's_email' => $request->email,
                's_address' => $request->alamat,
                's_phone1' => $request->nmr_hp1,
                's_phone2' => $request->nmr_hp2,
                's_rekening' => $request->rekening,
                's_bank' => $request->namabank,
                's_fax' => $request->fax,
                's_note' => $request->keterangan,
                's_top' => $request->top,
                's_limit' => str_replace(',', '', $request->limit),
                's_insert' => Carbon::now()
            ]);


            for($j = 0; $j < count($request->wilayah); $j++){
                $urut_kendaraan = DB::table('m_kendaraan')
                        ->max('k_id');
                $urut_kendaraan = $urut_kendaraan +1;
                DB::table('m_kendaraan')
                ->insert([
                    'k_id' => $urut_kendaraan,
                    'k_pemilik' => $s_id,
                    'k_flag' => 'SUPPLIER',
                    'k_nopol' => strtoupper($request->wilayah[$j]),
                    'created_at' => Carbon::now()
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

    public function disabled(Request $request){
        $aktif = $request->active;
        $id = $request->id;

        if($aktif == 'Y'){
            DB::table('m_supplier')
            ->where('s_id' , $id)
            ->update([
                's_isactive' => 'N',
            ]);
        }
        else {
            DB::table('m_supplier')
            ->where('s_id' , $id)
            ->update([
                's_isactive' => 'Y',
            ]);
        }

        return json_encode('sukses');
    }
 
   public function table()
   {
   	$data = DB::table('m_supplier');

        	return Datatables::of($data)           

			->editColumn('s_phone1', function ($xyzab) {
				if ($xyzab->s_phone2 != null) 
				{
				 	return $xyzab->s_phone1.' | '.$xyzab->s_phone2;
				}
				else 
				{
				 	return $xyzab->s_phone1;
				}
			})

			->addColumn('action', function ($data) {
                    if ($data->s_isactive == 'Y') {
                        return  '<div class="text-center">'.
                                    '<button id="edit" 
                                        onclick=edit("'.Crypt::encrypt($data->s_id).'")
                                        class="btn btn-warning btn-sm" 
                                        title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </button>'.'
                                    <button id="status'.$data->s_id.'" 
                                        onclick="ubahStatusMan('.$data->s_id.')" 
                                        class="btn btn-primary btn-sm" 
                                        title="Aktif">
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                    </button>'.'
                                </div>';
                    }
                    else
                    {
                        return  '<div class="text-center">'.
                                    '<button id="status'.$data->s_id.'" 
                                        onclick="ubahStatusMan('.$data->s_id.')" 
                                        class="btn btn-danger btn-sm" 
                                        title="Tidak Aktif">
                                        <i class="fa fa-minus-square" aria-hidden="true"></i>
                                    </button>'.
                                '</div>';
                    }
                    
                })
			->rawColumns(['action','s_phone1'])
			->make(true);
			}
}

