<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use carbon\Carbon;
use App\MasterBarang;
use Yajra\DataTables\DataTables;

class MasterBarangController extends Controller
{
    /**
     * Return DataTable list for view.
     *
     * @return Yajra/DataTables
     */
    public function getList()
    {
      $datas = DB::table('m_item')
        ->join('m_satuan' , 's_id' , '=' , 'i_sat1')
        ->join('m_group', 'g_id', '=', 'i_group')
        ->orderBy('i_id' , 'desc')
        ->get();
      return Datatables::of($datas)
        ->addIndexColumn()
        ->addColumn('satuan', function($datas) {
          return $datas->s_name;
        })
        ->addColumn('group', function($datas) {
          return $datas->g_name;
        })
        ->addColumn('action', function($datas) {
          if ($datas->i_isactive == 'Y') {
            return '<button class="btn btn-warning btn-edit btn-sm" onclick="window.location.href=\''. url("master/databarang/edit/".$datas->i_id) .'\'" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
            <button class="btn btn-primary btn-disable btn-sm" type="button" title="Disable" onclick="status(\'' .$datas->i_id .'\',\''. $datas->i_isactive .'\')"><i class="fa fa-check-square"></i></button>';
          } elseif ($datas->i_isactive == 'T') {
            return '<button class="btn btn-danger btn-enable btn-sm" type="button" title="Enable" onclick="status(\'' .$datas->i_id .'\',\''. $datas->i_isactive .'\')"><i class="fa fa-minus-square"></i></button>';
          }
        })
        ->rawColumns(['group', 'satuan', 'action'])
        ->make(true);
    }

    public function databarang()
    {
        $data = DB::table('m_item')
                ->join('m_satuan' , 's_id' , '=' , 'i_sat1')
                ->orderBy('i_id' , 'desc')
                ->get();

    	return view('master/databarang/databarang', compact('data'));
    }
    public function tambah_databarang()
    {
        $data['satuan'] = DB::table('m_satuan')
                          ->get();
        $data['group'] = DB::table('m_group')
          ->get();
        return view('master/databarang/tambah_databarang', compact('data'));
    }
    public function edit_databarang($id)
    {

        $data['barang'] = DB::table('m_item')
                          ->where('i_id' ,  $id)
                          ->get();
        $data['satuan'] = DB::table('m_satuan')
                         ->get();
        $data['group'] = DB::table('m_group')
        ->get();
        return view('master/databarang/edit_databarang', compact('data'));
    }

    public function tipe_barang(Request $request) {
        $tipe_barang = $request->tipe_barang;
        $caritipe = DB::select("SELECT  substring(max(i_code),4) as id from m_item
                                  WHERE i_type = '$tipe_barang'");
        $index = (integer)$caritipe[0]->id + 1;
        $index = str_pad($index, 4, '0' , STR_PAD_LEFT);
        $nota = $tipe_barang . '-' . $index;
        return json_encode($nota);
    }

    public function save_barang(Request $request){
         return DB::transaction(function() use ($request){
            $urut = DB::table('m_item')
                    ->max('i_id');

            $harga_satuan_utama = str_replace(".", "", $request->harga_satuan_utama);
            $harga_satuan_utama = str_replace(",", ".", $harga_satuan_utama);

            $harga_satuan_1 = str_replace(".", "", $request->harga_satuan_1);
            $harga_satuan_1 = str_replace(",", ".", $harga_satuan_1);

            $harga_satuan_2 = str_replace(".", "", $request->harga_satuan_2);
            $harga_satuan_2 = str_replace(",", ".", $harga_satuan_2);

            $urut = $urut + 1;
            $now = Carbon::now();

            // get a new 'kode barang'
            $kode_barang = $this->tipe_barang($request);
            $kode_barang = json_decode($kode_barang);

            $masterbarang = new MasterBarang();
            $masterbarang->i_id = $urut;
            $masterbarang->i_code = $kode_barang;
            $masterbarang->i_type = $request->tipe_barang;
            $masterbarang->i_group = $request->kelompok_barang;
            $masterbarang->i_name = $request->nama_barang;

            $masterbarang->i_sat1 = $request->satuan_utama;
            if($request->satuan_1 != ''){
                $masterbarang->i_sat2 = $request->satuan_1;
                // $masterbarang->i_sat_hrg2 = $harga_satuan_1;
                $masterbarang->i_sat_isi2 = $request->isi_satuan_1;
            }
            if($request->satuan_2 != ''){
                $masterbarang->i_sat_isi3 = $request->isi_satuan_2;
                // $masterbarang->i_sat_hrg3 = $harga_satuan_2;
                $masterbarang->i_sat3 = $request->satuan_2;
            }

            $masterbarang->i_sat_isi1 = $request->isi_satuan_utama;
            // $masterbarang->i_sat_hrg1 =$harga_satuan_utama;
            $masterbarang->i_min_stock =$request->min_stock;

            $masterbarang->i_det = $request->detail;
            $masterbarang->i_persentase = $request->persentase;
            $masterbarang->i_insert_by = $request->username;
            $masterbarang->i_updated_by = $request->username;
            $masterbarang->i_isactive = 'Y';
            $masterbarang->save();

            return json_encode('sukses');
         });
    }

    public function update(Request $request){
          return DB::transaction(function() use ($request){
            $idbarang = $request->id_barang;

            $harga_satuan_utama = str_replace(".", "", $request->harga_satuan_utama);
            $harga_satuan_utama = str_replace(",", ".", $harga_satuan_utama);

            $harga_satuan_1 = str_replace(".", "", $request->harga_satuan_1);
            $harga_satuan_1 = str_replace(",", ".", $harga_satuan_1);

            $harga_satuan_2 = str_replace(".", "", $request->harga_satuan_2);
            $harga_satuan_2 = str_replace(",", ".", $harga_satuan_2);


            DB::table('m_item')
            ->where('i_id' , $idbarang)
            ->update([
                'i_code' => $request->kode_barang,
                'i_type' => $request->tipe_barang,
                'i_code_group' => $request->kelompok_barang,
                'i_name' => $request->nama_barang,
                'i_sat1' => $request->satuan_utama,
                'i_sat_isi1' => $request->isi_satuan_utama,
                // 'i_sat_hrg1' => $harga_satuan_utama,
                'i_min_stock' => $request->min_stock,
                'i_det' => $request->detail,
                'i_persentase' => $request->persentase,
                'i_insert_by' => $request->username,
                'i_updated_by' => $request->username,
            ]);


            if($request->satuan_1 != ''){
                DB::table('m_item')
                ->where('i_id' , $idbarang)
                ->update([
                    'i_sat2' => $request->satuan_1,
                    // 'i_sat_hrg2' => $harga_satuan_1,
                    'i_sat_isi2' => $request->isi_satuan_1,
                ]);
            }
            if($request->satuan_2 != ''){
                 DB::table('m_item')
                ->where('i_id' , $idbarang)
                ->update([
                    'i_sat3' => $request->satuan_2,
                    // 'i_sat_hrg3' => $harga_satuan_2,
                    'i_sat_isi3' => $request->isi_satuan_2,
                ]);
            }

            return json_encode('sukses');
          });
    }

    public function disabled(Request $request){
        $id = $request->data_id;
        $data = DB::table('m_item')
                ->where('i_id' , $id)
                ->first();
        $status = $data->i_isactive;

        if($status == 'Y'){
            DB::table('m_item')
            ->where('i_id' , $id)
            ->update([
                'i_isactive' => 'T'
            ]);
        }
        else {
            DB::table('m_item')
            ->where('i_id' , $id)
            ->update([
                'i_isactive' => 'Y'
            ]);
        }
        return json_encode('sukses');
    }

}
