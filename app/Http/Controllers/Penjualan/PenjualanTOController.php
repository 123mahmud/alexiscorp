<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use Validator;
use App\d_stock;
use App\d_sales;
use App\d_sales_dt;
use App\d_sales_payment;
use App\d_gudangcabang;
use App\m_item;
use App\m_item_price;
use App\m_customer;
use carbon\Carbon;
use CodeGenerator;
use Yajra\DataTables\DataTables;

class PenjualanTOController extends Controller
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
        'ppn' => 'required',
        'listItemId' => 'required'
      ],
      [
        'idCustomer.required' => 'Silahkan pilih customer terlebih dahulu !',
        'orderDate.required' => 'Silahkan isi tanggal order terlebih dahulu !',
        'ppn.required' => 'ppn masih kosong !',
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
        ->where('s_comp', $gudangCabangId)
        ->where('s_position', $gudangCabangId)
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
      $datas = d_sales::where('s_channel', 'TO')
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
        return '<div class="btn-group btn-group-sm">
        <button class="btn btn-info" onclick="DetailPenjualan('.$datas->s_id.')" rel="tooltip" title="Detail"><i class="fa fa-folder"></i></button>
        </div>';
      })
      ->rawColumns(['customer', 'staff', 'action'])
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
      return view('penjualan/penjualantanpaorder/penjualantanpaorder', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $sales->s_channel = 'TO'; // OD: Order || TO: Tanpa Order
        $sales->s_date = Carbon::parse($request->orderDate)->format('Y-m-d');
        $sales->s_note = $salesNota;
        $sales->s_comp = Session::get('user_comp');
        $sales->s_staff = Auth::user()->m_id;
        $sales->s_customer = $request->idCustomer;
        $sales->s_gross = $request->totalPenjualan;
        $sales->s_disc_percent = $discPercent;
        $sales->s_disc_value = $request->totalDisc;
        $sales->s_tax = $request->ppn;
        // $sales->s_jatuh_tempo = null;
        // $sales->s_ongkir = null
        $sales->s_net = $request->totalAmount;
        // $sales->s_sisa = null
        $sales->s_status = 'FN'; // PR: Progress || FN: Final
        // $sales->s_resi = null
        // $sales->s_info = null;
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

            // update stock (using mutation)
            mutasi::mutasiStok($request->listItemId[$loopCount],
            $request->listQty[$loopCount],
            $gudangCabangId,
            $gudangCabangId,
            'MENGURANGI',
            $sales->s_note,
            'MENGURANGI',
            Carbon::now(),
            1){
              dd('error om')
            };
          }
          $loopCount++;
        }

        // insert sales-payment
        $salesPay = new d_sales_payment;
        $salesPay->sp_sales = $salesId;
        $salesPay->sp_paymentid = 1;
        $salesPay->sp_method = $request->paymentMethod;
        $salesPay->sp_nominal = $request->totalBayar;
        // $salesPay->sp_ref = null;
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
      return view('penjualan/penjualantanpaorder/edit_penjualantanpaorder', compact('data'));
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
