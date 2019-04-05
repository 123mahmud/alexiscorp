<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\d_sales;

class PenjualanReturnController extends Controller
{
    /**
     * return sales based on id sales
     *
     * @return json
     */
    public function getSales(Request $request)
    {
      $data['sales'] = d_sales::where('s_id', $request->id_sales)
        ->with('getSalesDt')
        ->with('getCustomer')
        ->with('getSalesPayment')
        ->firstOrFail();

      return view('penjualan/returnpenjualan/returnpenjualan', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data['sales'] = d_sales::get();
      return view('penjualan/returnpenjualan/returnpenjualan', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['sales'] = d_sales::orderBy('s_note', 'asc')
        ->get();
      return view('penjualan/returnpenjualan/tambah_returnpenjualan', compact('data'));
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
