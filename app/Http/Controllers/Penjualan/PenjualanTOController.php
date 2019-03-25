<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use carbon\Carbon;
use App\d_sales;
use Yajra\DataTables\DataTables;

class PenjualanTOController extends Controller
{
    /**
    * Return DataTable list for view.
    *
    * @return Yajra/DataTables
    */
    public function getListPenjualan(Request $request)
    {
      $from = Carbon::parse($request->date_from)->format('Y-m-d');
      $to = Carbon::parse($request->date_to)->format('Y-m-d');
      $datas = d_sales::where('s_channel', 'TO')
        ->whereBetween('s_date', [$from, $to])
        ->with('getCustomer')
        ->with('getStaff')
        ->orderBy('s_note', 'desc')
        ->get();

      return Datatables::of($datas)
      ->addIndexColumn()
      ->addColumn('customer', function($datas) {
        return $datas->getCustomer['c_name'];
      })
      ->addColumn('staff', function($datas) {
        return $datas->getStaff['m_name'];
      })
      ->addColumn('action', function($datas) {
        return '<div class="btn-group btn-group-sm">
        <button class="btn btn-warning hint--top hint--warning" onclick="EditAgen('.$datas->a_id.')" rel="tooltip" data-placement="top" aria-label="Edit data"><i class="fa fa-pencil"></i></button>
        <button class="btn btn-danger hint--top hint--error" onclick="DisableAgen('.$datas->a_id.')" rel="tooltip" data-placement="top" aria-label="Nonaktifkan data"><i class="fa fa-times-circle"></i></button>
        </div>';
      })
      ->rawColumns(['customer', 'staff', 'action'])
      ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('penjualan/penjualantanpaorder/penjualantanpaorder');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('penjualan/penjualantanpaorder/tambah_penjualantanpaorder');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
