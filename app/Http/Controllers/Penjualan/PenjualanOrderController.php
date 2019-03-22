<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\m_item;
use App\d_stock;
use App\m_customer;
use App\m_item_price;

class PenjualanOrderController extends Controller
{
    /**
     * Return list of customers from 'm_customer'.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomers(Request $request)
    {
      $term = $request->term;
      $customers = m_customer::where('c_name', 'like', '%'.$term.'%')
        ->get();
      if (sizeof($customers) > 0) {
        foreach ($customers as $customer) {
          $results[] = [
            'id' => $customer->c_id,
            'label' => $customer->c_name .', '. $customer->c_address,
            'address' => $customer->c_address,
          ];
        }
      } else {
        $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
      }
      return response()->json($results);
    }

    /**
    * Return list of customers from 'm_customer'.
    *
    * @return \Illuminate\Http\Response
    */
    public function getItems(Request $request)
    {
      $term = $request->term;
      $items = m_item::where('i_name', 'like', '%'.$term.'%')
        ->with('getSatuan1')
        ->get();
      if (sizeof($items) > 0) {
        foreach ($items as $item) {
          $results[] = [
            'id' => $item->i_id,
            'name' => $item->i_name,
            'sat1_id' => $item->getSatuan1['s_id'],
            'sat1_name' => $item->getSatuan1['s_name'],
            'label' => $item->i_code .', '. $item->i_name
          ];
        }
      } else {
        $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
      }
      return response()->json($results);
    }

    /**
     * Return a stock from an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStock(Request $request)
    {
      $stock = d_stock::where('s_item', $request->itemId)
        ->where('s_comp',  $request->comp)
        ->where('s_position',  $request->positionId)
        ->firstOrFail();
      return $stock;
    }

    /**
     * Return a price from an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrice(Request $request)
    {
      $price = m_item_price::where('ip_group', $request->priceGroup)
        ->where('ip_item',  $request->itemId)
        ->firstOrFail();
      return $price;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data['group_harga'] = DB::table('m_price_group')
        ->get();
    	return view('penjualan/penjualanorder/penjualanorder', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
