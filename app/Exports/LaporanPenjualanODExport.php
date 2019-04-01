<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\d_mem;
use App\d_sales_dt;
use carbon\Carbon;

class LaporanPenjualanODExport implements FromView
{
  public function view(): View
  {
    $request = request();
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
}
