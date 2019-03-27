<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use carbon\Carbon;
use App\m_customer;
use App\m_kendaraan;
use CodeGenerator;
use Yajra\DataTables\DataTables;

class MasterCustomerController extends Controller
{
    /**
     * Validate request before execute command.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return 'error message' or '1'
     */
    public function validate_req(Request $request)
    {
      // start: validate data before execute
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'sometimes|nullable|email',
        'telp1' => 'required',
        'type' => 'required'
      ],
      [
        'name.required' => 'Nama masih kosong !',
        'email.email' => 'Format email tidak valid !',
        'telp1.required' => 'No telp 1 masih kosong !',
        'type.required' => 'Type customer masih kosong !'
      ]);
      if($validator->fails())
      {
        return $validator->errors()->first();
      }
      else
      {
        return '1';
      }
    }

    /**
    * Return DataTable list for view.
    *
    * @return Yajra/DataTables
    */
    public function getList()
    {
      $datas = DB::table('m_customer')
      ->orderBy('c_id', 'desc')
      ->get();
      return Datatables::of($datas)
      ->addIndexColumn()
      ->addColumn('telp', function($datas) {
        if ($datas->c_hp2 != null) {
          return '<td>'. $datas->c_hp1 .'/'. $datas->c_hp2 .'</td>';
        } else {
          return '<td>'. $datas->c_hp1 .'</td>';
        }
      })
      ->addColumn('action', function($datas) {
        return '<button class="btn btn-warning btn-edit btn-sm" type="button" title="Edit" onclick="Edit('. $datas->c_id .')"><i class="fa fa-pencil"></i></button>
        <button class="btn btn-primary btn-disable btn-sm" type="button" title="Hapus" onclick="Hapus('. $datas->c_id .')"><i class="fa fa-trash"></i></button>';
      })
      ->rawColumns(['telp', 'action'])
      ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('master/datacustomer/datacustomer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('master/datacustomer/tambah_datacustomer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // validate request
      $isValidRequest = $this->validate_req($request);
      if ($isValidRequest != '1') {
        $errors = $isValidRequest;
        return response()->json([
          'status' => 'invalid',
          'message' => $errors
        ]);
      }

      DB::beginTransaction();
      try {
        $id = m_customer::max('c_id') + 1;
        $c_code = CodeGenerator::code('m_customer', 'c_code', 5, 'CUS');
        $hp1 = str_replace('_', '', $request->telp1);
        $hp1 = str_replace(' ', '', $hp1);
        $hp2 = str_replace('_', '', $request->telp2);
        $hp2 = str_replace(' ', '', $hp2);

        // insert customer
        $customer = new m_customer;
        $customer->c_id = $id;
        $customer->c_code = $c_code;
        $customer->c_name = $request->name;
        $customer->c_email = $request->email;
        $customer->c_type = $request->type;
        $customer->c_hp1 = $hp1;
        $customer->c_hp2 = $hp2;
        $customer->c_address = $request->address;
        $customer->save();

        // insert Kendaraan
        $nopols = $request->nopol;

        if ($nopols != null) {
          foreach ($nopols as $nopol) {
            $nopol =  str_replace('_', '', $nopol);

            $k_id = m_kendaraan::max('k_id') + 1;
            $kendaraan = new m_kendaraan;
            $kendaraan->k_id = $k_id;
            $kendaraan->k_pemilik = $id;
            $kendaraan->k_flag = 'CUSTOMER';
            $kendaraan->k_nopol = $nopol;
            $kendaraan->save();
          }
        }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal',
          'message' => $e->getMessage()
        ]);
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data['customer'] = m_customer::find($id);
      return view('master/datacustomer/edit_datacustomer', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // validate request
      $isValidRequest = $this->validate_req($request);
      if ($isValidRequest != '1') {
        $errors = $isValidRequest;
        return response()->json([
          'status' => 'invalid',
          'message' => $errors
        ]);
      }

      DB::beginTransaction();
      try {
        $customer = m_customer::find($id);
        $customer->c_name = $request->name;
        $customer->c_email = $request->email;
        $customer->c_type = $request->type;
        $customer->c_hp1 = $request->telp1;
        $customer->c_hp2 = $request->telp2;
        $customer->c_address = $request->address;
        $customer->save();

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal',
          'message' => $e->getMessage()
        ]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      DB::beginTransaction();
      try {
        $customer = m_customer::find($id);
        $customer->delete();
        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal',
          'message' => $e->getMessage()
        ]);
      }

    }
}
