<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\LaporanPenjualanODExport;
use Maatwebsite\Excel\Facades\Excel;

use App\d_gudangcabang;
use App\d_mem;
use App\d_sales;
use App\d_sales_dt;
use App\d_sales_payment;
use App\d_stock;
use App\m_customer;
use App\m_item;
use App\m_item_price;
use App\lib\mutasi;
use Auth;
use carbon\Carbon;
use CodeGenerator;
use DB;
use Session;
use Validator;
use Yajra\DataTables\DataTables;

class PenjualanOrderController extends Controller
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
        'idCustomer' => 'required',
        'orderDate' => 'required',
        'dueDate' => 'required',
        'ppn' => 'required',
        'listItemId' => 'required'
      ],
      [
        'idCustomer.required' => 'Silahkan pilih customer terlebih dahulu !',
        'orderDate.required' => 'Silahkan isi tanggal order terlebih dahulu !',
        'dueDate.required' => 'Silahkan isi tanggal jatuh tempo terlebih dahulu !',
        'ppn.required' => 'PPN masih kosong !',
        'listItemId.required' => 'Item masih kosong !'
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
    //
    // /**
    // * Return list of customers from 'd_mem' where 'pegawai manajemen'.
    // *
    // * @return \Illuminate\Http\Response
    // */
    // public function getStaff(Request $request)
    // {
    //   $term = $request->term;
    //   $staff = d_mem::where('m_name', 'like', '%'.$term.'%')
    //     ->whereHas('getPegawaiMan')
    //     ->get();
    //   if (sizeof($staff) > 0) {
    //     foreach ($staff as $staf) {
    //       $results[] = [
    //         'id' => $staf->m_id,
    //         'label' => $staf->m_name .', '. $staf->m_addr,
    //       ];
    //     }
    //   } else {
    //     $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
    //   }
    //   return response()->json($results);
    // }

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
      $userComp = Session::get('user_comp');
      $gudangCabang = d_gudangcabang::where('gc_comp', $userComp)
        ->where('gc_gudang', 'GUDANG PENJUALAN')
        ->firstOrFail();
      $gudangCabangId = $gudangCabang->gc_id;

      $stock = d_stock::where('s_item', $request->itemId)
        ->where('s_comp',  $gudangCabangId)
        ->where('s_position',  $gudangCabangId)
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
        ->first();
      if ($price == null) {
        return response()->json([
          'ip_group' => (int)$request->priceGroup,
          'ip_item' => (int)$request->itemId,
          'ip_price' => 0
        ]);
      }
      return $price;
    }

    /**
    * Return DataTable list for view.
    *
    * @return Yajra/DataTables
    */
    public function getListPenjualan(Request $request)
    {
      $from = Carbon::parse($request->date_from)->format('Y-m-d');
      $to = Carbon::parse($request->date_to)->format('Y-m-d');
      $datas = d_sales::where('s_channel', 'OD')
        ->where('s_comp', Session::get('user_comp'))
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
        if ($datas->s_status == 'PR') {
          return '<div class="btn-group btn-group-sm">
          <button class="btn btn-info" onclick="DetailPenjualan('.$datas->s_id.')" rel="tooltip" title="Detail"><i class="fa fa-folder"></i></button>
          <button class="btn btn-warning" onclick="EditPenjualan('.$datas->s_id.')" rel="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>
          </div>';
        } elseif ($datas->s_status == 'FN') {
          return '<div class="btn-group btn-group-sm">
          <button class="btn btn-info" onclick="DetailPenjualan('.$datas->s_id.')" rel="tooltip" title="Detail"><i class="fa fa-folder"></i></button>
          </div>';
        }
      })
      ->rawColumns(['customer', 'staff', 'action'])
      ->make(true);
    }

    /**
    * Return DataTable list for view.
    *
    * @return Yajra/DataTables
    */
    public function getLaporanPenjualan(Request $request)
    {
      $from = Carbon::parse($request->date_from)->format('Y-m-d');
      $to = Carbon::parse($request->date_to)->format('Y-m-d');

      if ($request->staff == 'x') {
        if ($request->status == 'AL') {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
              $query
                ->where('s_channel', 'OD')
                ->whereBetween('s_date', [$from, $to])
                ->orderBy('s_note', 'desc');
            })
            ->with('getItem.getSatuan1')
            ->get();
        } else {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
              $query
                ->where('s_channel', 'OD')
                ->whereBetween('s_date', [$from, $to])
                ->where('s_status', $request->status)
                ->orderBy('s_note', 'desc');
            })
            ->with('getItem.getSatuan1')
            ->get();
        }
      } else {
        if ($request->status == 'AL') {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
              $query
                ->where('s_channel', 'OD')
                ->whereBetween('s_date', [$from, $to])
                ->where('s_staff', $request->staff)
                ->orderBy('s_note', 'desc');
            })
            ->with('getItem.getSatuan1')
            ->get();
        } else {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
              $query
                ->where('s_channel', 'OD')
                ->whereBetween('s_date', [$from, $to])
                ->where('s_staff', $request->staff)
                ->where('s_status', $request->status)
                ->orderBy('s_note', 'desc');
            })
            ->with('getItem.getSatuan1')
            ->get();
        }
      }

      return Datatables::of($datas)
      ->addIndexColumn()
      ->addColumn('item', function($datas) {
        return $datas->getItem['i_name'];
      })
      ->addColumn('nota', function($datas) {
        return $datas->getSales['s_note'];
      })
      ->addColumn('date', function($datas) {
        return $datas->getSales['s_date'];
      })
      ->addColumn('satuan', function($datas) {
        return $datas->getItem['getSatuan1']['s_name'];
      })
      ->addColumn('qty', function($datas) {
        return '<div class="text-right">'. $datas->sd_qty .'</div>';
      })
      ->addColumn('price', function($datas) {
        return '<div class="text-right">'. $datas->sd_price .'</div>';
      })
      ->addColumn('discount', function($datas) {
        return '<div class="text-right">'. $datas->sd_disc_percent .'</div>';
      })
      ->addColumn('discount_value', function($datas) {
        return '<div class="text-right">'. (int)$datas->sd_disc_value / (int)$datas->sd_qty .'</div>';
      })
      ->addColumn('sub_total', function($datas) {
        return '<div class="text-right">'. $datas->sd_total .'</div>';
      })
      ->rawColumns(['item', 'satuan', 'qty', 'price', 'discount', 'discount_value', 'sub_total'])
      ->make(true);
    }

    /**
     * return detail of a 'penjualan'.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetailPenjualan($id)
    {
      $data = d_sales::where('s_id', $id)
        ->with('getCustomer')
        ->with('getSalesDt.getItem.getSatuan1')
        ->with('getSalesPayment')
        ->firstOrFail();
      return $data;
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
      $data['tipe_pembayaran'] = DB::table('m_paymentmethod')
        ->get();
      $data['staff'] = d_mem::whereHas('getPegawaiMan')
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
        // insert sales
        $salesId = d_sales::max('s_id') + 1;
        $discPercent = ($request->totalDisc * 100) / $request->totalPenjualan;
        $salesNota = CodeGenerator::code('d_sales', 's_note', 5, 'SLS');
        $sales = new d_sales();
        $sales->s_id = $salesId;
        $sales->s_channel = 'OD'; // OD: Order || TO: Tanpa Order
        $sales->s_date = Carbon::parse($request->orderDate)->format('Y-m-d');
        $sales->s_note = $salesNota;
        $sales->s_comp = Session::get('user_comp');
        /////------------------------------------------------ warning
        $sales->s_staff = Auth::user()->m_id;
        $sales->s_customer = $request->idCustomer;
        $sales->s_gross = $request->totalPenjualan;
        $sales->s_disc_percent = $discPercent;
        $sales->s_disc_value = $request->totalDisc;
        $sales->s_tax = $request->ppn;
        $sales->s_jatuh_tempo = Carbon::parse($request->dueDate)->format('Y-m-d');
        // $sales->s_ongkir
        $sales->s_net = $request->totalAmount;
        // $sales->s_sisa
        $sales->s_status = 'PR'; // PR: Progress || FN: Final
        // $sales->s_resi
        $sales->s_info = $request->keterangan;
        $sales->save();

        // insert sales-detail
        $listItems = $request->listItemId;
        $loopCount = 0;
        foreach ($listItems as $item) {
          if ($item != null) {
            $valDiscP = ($request->listQty[$loopCount] * $request->listPrice[$loopCount]) * $request->listDiscP[$loopCount] / 100;
            $valDiscH = $request->listQty[$loopCount] * $request->listDiscH[$loopCount];
            $salesDtId = d_sales_dt::where('sd_sales', $salesId)
              ->max('sd_detailid') + 1;
            $salesDt = new d_sales_dt;
            $salesDt->sd_sales = $salesId;
            $salesDt->sd_detailid = $salesDtId;
            $salesDt->sd_item = $request->listItemId[$loopCount];
            $salesDt->sd_qty = $request->listQty[$loopCount];
            $salesDt->sd_price = $request->listPrice[$loopCount];
            $salesDt->sd_disc_percent = $request->listDiscP[$loopCount];
            $salesDt->sd_disc_vpercent = $valDiscP;
            $salesDt->sd_disc_value = $valDiscH;
            $salesDt->sd_total = $request->listSubTotal[$loopCount];
            $salesDt->save();
          }
          $loopCount++;
        }

        // insert sales-payment
        $salesPay = new d_sales_payment;
        $salesPay->sp_sales = $salesId;
        $salesPay->sp_paymentid = 1;
        $salesPay->sp_method = $request->paymentMethod;
        $salesPay->sp_nominal = $request->totalBayar;
        // $salesPay->sp_ref =
        $salesPay->save();

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
      $data['group_harga'] = DB::table('m_price_group')
        ->get();
      $data['tipe_pembayaran'] = DB::table('m_paymentmethod')
        ->get();
      $data['id'] = $id;
      return view('penjualan/penjualanorder/edit_penjualanorder', compact('data'));
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
        // insert sales
        $discPercent = ($request->totalDisc * 100) / $request->totalPenjualan;
        $sales = d_sales::where('s_id', $id)
          ->firstOrFail();
        $sales->s_date = Carbon::parse($request->orderDate)->format('Y-m-d');
        $sales->s_staff = Auth::user()->m_id;
        $sales->s_gross = $request->totalPenjualan;
        $sales->s_disc_percent = $discPercent;
        $sales->s_disc_value = $request->totalDisc;
        $sales->s_tax = $request->ppn;
        $sales->s_jatuh_tempo = Carbon::parse($request->dueDate)->format('Y-m-d');
        $sales->s_net = $request->totalAmount;
        if ($request->status_edit == 'PR') {
          $sales->s_status = 'PR'; // PR: Progress || FN: Final
        } elseif ($request->status_edit == 'FN') {
          $sales->s_status = 'FN'; // PR: Progress || FN: Final
        }
        $sales->s_info = $request->keterangan;
        $sales->save();

        // delete sales-detail from selected salesId
        $salesDt = d_sales_dt::where('sd_sales', $id)
          ->get();
        foreach ($salesDt as $salesX) {
          $salesX->delete();
        }

        // insert sales-detail
        $listItems = $request->listItemId;
        $loopCount = 0;
        foreach ($listItems as $item) {
          if ($item != null) {
            $valDiscP = ($request->listQty[$loopCount] * $request->listPrice[$loopCount]) * $request->listDiscP[$loopCount] / 100;
            $valDiscH = $request->listQty[$loopCount] * $request->listDiscH[$loopCount];
            $salesDtId = d_sales_dt::where('sd_sales', $id)
              ->max('sd_detailid') + 1;
            $salesDt = new d_sales_dt;
            $salesDt->sd_sales = $id;
            $salesDt->sd_detailid = $salesDtId;
            $salesDt->sd_item = $request->listItemId[$loopCount];
            $salesDt->sd_qty = $request->listQty[$loopCount];
            $salesDt->sd_price = $request->listPrice[$loopCount];
            $salesDt->sd_disc_percent = $request->listDiscP[$loopCount];
            $salesDt->sd_disc_vpercent = $valDiscP;
            $salesDt->sd_disc_value = $valDiscH;
            $salesDt->sd_total = $request->listSubTotal[$loopCount];
            $salesDt->save();

            // update stock (using mutation)
            $userComp = Session::get('user_comp');
            $gudangCabang = d_gudangcabang::where('gc_comp', $userComp)
              ->where('gc_gudang', 'GUDANG PENJUALAN')
              ->firstOrFail();
            $gudangCabangId = $gudangCabang->gc_id;
            if ($request->status_edit == 'FN') {
              $mutasi = mutasi::mutasiStok($request->listItemId[$loopCount],
              $request->listQty[$loopCount],
              $gudangCabangId,
              $gudangCabangId,
              'MENGURANGI',
              $sales->s_note,
              'MENGURANGI',
              Carbon::now(),
              1);
              if ($mutasi['true'] == false) {
                return response()->json([
                  'status' => 'gagal',
                  'message' => 'Mutasi gagal, Hubungi pengembang !'
                ]);
              }
              // DB::rollback();
              // dd($mutasi);
            }
          }
          $loopCount++;
        }

        // insert sales-payment
        $salesPay = d_sales_payment::where('sp_sales', $id)
          ->firstOrFail();
        $salesPay->sp_paymentid = 1;
        $salesPay->sp_method = $request->paymentMethod;
        $salesPay->sp_nominal = $request->totalBayar;
        // $salesPay->sp_ref =
        $salesPay->save();

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
        //
    }

    /**
    * Print 'laporan'.
    *
    * @param  \Illuminate\Http\Request  $request
    */
    public function printLaporan(Request $request)
    {
      $from = Carbon::parse($request->date_from)->format('Y-m-d');
      $to = Carbon::parse($request->date_to)->format('Y-m-d');

      if ($request->staff == 'x') {
        if ($request->status == 'AL') {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
            $query
            ->where('s_channel', 'OD')
            ->whereBetween('s_date', [$from, $to]);
          })
          ->with('getItem.getSatuan1')
          ->with('getSales.getCustomer')
          ->join('d_sales', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
          ->join('m_item', 'd_sales_dt.sd_item', '=', 'm_item.i_id')
          ->orderBy('i_name', 'asc')
          ->orderBy('s_note', 'asc')
          ->get();
        } else {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
            $query
            ->where('s_channel', 'OD')
            ->whereBetween('s_date', [$from, $to])
            ->where('s_status', $request->status);
          })
          ->with('getItem.getSatuan1')
          ->with('getSales.getCustomer')
          ->join('d_sales', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
          ->join('m_item', 'd_sales_dt.sd_item', '=', 'm_item.i_id')
          ->orderBy('i_name', 'asc')
          ->orderBy('s_note', 'asc')
          ->get();
        }
      } else {
        if ($request->status == 'AL') {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
            $query
            ->where('s_channel', 'OD')
            ->whereBetween('s_date', [$from, $to])
            ->where('s_staff', $request->staff);
          })
          ->with('getItem.getSatuan1')
          ->with('getSales.getCustomer')
          ->join('d_sales', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
          ->join('m_item', 'd_sales_dt.sd_item', '=', 'm_item.i_id')
          ->orderBy('i_name', 'asc')
          ->orderBy('s_note', 'asc')
          ->get();
        } else {
          $datas = d_sales_dt::whereHas('getSales', function($query) use ($request, $from, $to) {
            $query
            ->where('s_channel', 'OD')
            ->whereBetween('s_date', [$from, $to])
            ->where('s_staff', $request->staff)
            ->where('s_status', $request->status);
          })
          ->with('getItem.getSatuan1')
          ->with('getSales.getCustomer')
          ->join('d_sales', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
          ->join('m_item', 'd_sales_dt.sd_item', '=', 'm_item.i_id')
          ->orderBy('i_name', 'asc')
          ->orderBy('s_note', 'asc')
          ->get();
        }
      }

      $from = Carbon::parse($request->date_from)->format('d M Y');
      $to = Carbon::parse($request->date_to)->format('d M Y');

      $staff = d_mem::where('m_id', $request->staff)->select('m_name')->first();

      $data['sales'] = $datas;
      $data['date_from'] = $from;
      $data['date_to'] = $to;
      ($staff != null) ? $data['staff'] = $staff->m_name : $data['staff'] = '[ Semua Staff ]';
      if ($request->status == 'AL') {
        $data['status'] = '[ Semua Status ]';
      } elseif ($request->status == 'PR') {
        $data['status'] = '[ Progress ]';
      } elseif ($request->status == 'FN') {
        $data['status'] = '[ Final ]';
      }

      $data['salesdate'] = array();
      $data['totalDiscP'] = 0;
      $data['totalDiscH'] = 0;
      $data['grandTotal'] = 0;
      foreach ($data['sales'] as $index => $sales) {
        array_push($data['salesdate'], Carbon::parse($data['sales'][$index]->getSales->s_date)->format('d M Y'));
        $data['totalDiscP'] += $sales->sd_disc_vpercent;
        $data['totalDiscH'] += ($sales->sd_disc_value / $sales->sd_qty);
        $data['grandTotal'] += $sales->sd_total;
      }

      return view('penjualan/penjualanorder/laporan', compact('data'));
    
    }

    /**
    * Export 'laporan Penjualan'.
    *
    * @param  \Illuminate\Http\Request  $request
    */
    public function exportToExcel(Request $request)
    {
      return Excel::download(new LaporanPenjualanODExport, 'LaporanPenjualanOrder.xlsx');
    }

}
