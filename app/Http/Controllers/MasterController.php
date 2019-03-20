<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\DataTables;

class MasterController extends Controller
{
    public function databarang()
    {
    	return view('master/databarang/databarang');
    }
    public function tambah_databarang()
    {
        $data['satuan'] = DB::table('m_satuan')
                          ->get();

        return view('master/databarang/tambah_databarang', compact('data'));
    }
    public function edit_databarang()
    {
        return view('master/databarang/edit_databarang');
    }



    public function datasuplier()
    {
    	return view('master/datasuplier/datasuplier');
    }
    public function tambah_datasuplier()
    {
        return view('master/datasuplier/tambah_datasuplier');
    }
    public function edit_datasuplier()
    {
        return view('master/datasuplier/edit_datasuplier');
    }


    public function datacustomer()
    {
    	return view('master/datacustomer/datacustomer');
    }
    public function tambah_datacustomer()
    {
        return view('master/datacustomer/tambah_datacustomer');
    }
    public function edit_datacustomer()
    {
        return view('master/datacustomer/edit_datacustomer');
    }
    public function datacustomerkontraktor()
    {
    	return view('master/datacustomerkontraktor/datacustomerkontraktor');
    }
    public function datapegawai()
    {
    	return view('master/datapegawai/datapegawai');
    }
    public function tambah_datapegawai()
    {
        return view('master/datapegawai/tambah_datapegawai');
    }
    public function edit_datapegawai()
    {
        return view('master/datapegawai/edit_datapegawai');
    }



    /**
    * Return DataTable list for view.
    *
    * @return Yajra/DataTables
    */
    public function list_datasatuan()
    {
      $datas = DB::table('m_satuan')
      ->orderBy('s_id', 'desc')
      ->get();
      return Datatables::of($datas)
      ->addIndexColumn()
      ->addColumn('action', function($datas) {
        if ($datas->s_status == 'Y') {
          return '<button class="btn btn-warning btn-edit btn-sm" onclick="window.location.href=\''. url("master/datasatuan/edit_datasatuan/".$datas->s_id) .'\'" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
          <button class="btn btn-primary btn-disable btn-sm" type="button" title="Disable" onclick="Hapus(\'' .$datas->s_id .'\',\''. $datas->s_status .'\')"><i class="fa fa-check-square"></i></button>';
        } else {
          return '<button class="btn btn-danger btn-enable btn-sm" type="button" title="Enable" onclick="Hapus(\'' .$datas->s_id .'\',\''. $datas->s_status .'\')"><i class="fa fa-minus-square"></i></button>';
        }
      })
      ->rawColumns(['action'])
      ->make(true);
    }

    public function datasatuan()
    {
        $data['satuan']= DB::table('m_satuan')
          ->orderBy('s_code', 'desc')
          ->get();
        return view('master/datasatuan/datasatuan', compact('data'));
    }

    public function tambah_datasatuan()
    {
        $datasatuan = DB::select("select max(s_id) as s_id from m_satuan");

        $index = (integer)$datasatuan[0]->s_id + 1;
        $index = str_pad($index, 4, '0' , STR_PAD_LEFT);

        $data['kode'] = 'S - ' . $index;
        return view('master/datasatuan/tambah_datasatuan', compact('data'));
    }

    public function save_datasatuan(Request $request)
    {
        return DB::transaction(function() use ($request){
            $data = DB::table('m_satuan')
                ->max('s_id');
            $urut = $data + 1;

            DB::table('m_satuan')
            ->insert([
                's_id' => $urut,
                's_code' => $request->kode_satuan,
                's_name' => $request->nama_satuan,
                's_status' => 'Y',
            ]);
            return json_encode('sukses');
        });
    }

    public function update_satuan(Request $request){
        return DB::transaction(function() use ($request){
            $idtransaksi = $request->idtransaksi;
            DB::table('m_satuan')
            ->where('s_id' , $idtransaksi)
            ->update([
                's_name' => $request->nama_satuan,
            ]);

            return json_encode('sukses');
        });
    }


    public function edit_datasatuan($id)
    {
        $data['satuan'] = DB::table('m_satuan')
                        ->where('s_id' , $id)
                        ->first();
        return view('master/datasatuan/edit_datasatuan' , compact('data'));
    }

    public function disabeld_satuan(Request $request){
        $id = $request->id;
        $data['satuan'] = DB::table('m_satuan')
                          ->where('s_id' , $id)
                          ->first();
        $status = $data['satuan']->s_status;
        if($status == 'Y'){
             DB::table('m_satuan')
            ->where('s_id' , $id)
            ->update([
                's_status' => 'T'
            ]);
        }
        else {
            DB::table('m_satuan')
            ->where('s_id' , $id)
            ->update([
                's_status' => 'Y'
            ]);
        }


        return json_encode('suskes');
    }


    public function datamesin()
    {
        return view('master/datamesin/datamesin');
    }
    public function tambah_datamesin()
    {
        return view('master/datamesin/tambah_datamesin');
    }
    public function edit_datamesin()
    {
        return view('master/datamesin/edit_datamesin');
    }
    public function barangsuplier()
    {
    	return view('master/barangsuplier/barangsuplier');
    }
    public function tambah_barang()
    {
    	return view('master/barangsuplier/tambah_barang');
    }
    public function tambah_suplier()
    {
    	return view('master/barangsuplier/tambah_suplier');
    }
    public function edit_barang()
    {
        return view('master/barangsuplier/edit_barang');
    }
    public function edit_suplier()
    {
        return view('master/barangsuplier/edit_suplier');
    }
    public function harga()
    {
        return view('master/dataharga/index');
    }
    public function upah()
    {
        return view('master.upah.upah');
    }
    public function tambah_upah()
    {
        return view('master.upah.tambah_upah');
    }

    public function datatunjangan()
    {
        return view('master.datatunjangan.datatunjangan');
    }

    public function tambah_datatunjangan()
    {
        return view('master.datatunjangan.tambah_datatunjangan');
    }

    public function datajabatan()
    {
        return view('master.datajabatan.datajabatan');
    }

    public function tambah_datajabatan()
    {
        return view('master.datajabatan.tambah_datajabatan');
    }

    public function edit_datajabatan()
    {
        return view('master.datajabatan.edit_datajabatan');
    }

}
