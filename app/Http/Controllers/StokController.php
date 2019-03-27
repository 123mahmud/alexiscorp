<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    // Data Adonan
    public function dataadonan()
    {
    	return view('stok/dataadonan/dataadonan');
    }
    public function tambah_dataadonan()
    {
        return view('stok/dataadonan/tambah_dataadonan');
    }
    public function edit_dataadonan()
    {
        return view('stok/dataadonan/edit_dataadonan');
    }

    // Opname Bahan Baku
    public function opnamebahanbaku()
    {
    	return view('stok/opnamebahanbaku/opnamebahanbaku');
    }

    // Pencatatan Barang Masuk
    public function pencatatanbarangmasuk()
    {
    	return view('stok/pencatatanbarangmasuk/pencatatanbarangmasuk');
    }
    public function getinfopo(Request $request){
        $getInfo = DB::table('d_purchase_order')
            ->join('m_supplier', 's_id', '=', 'po_supplier')
            ->where('po_id', $request->id)
            ->select(DB::raw('date_format(po_tanggal, "%d-%m-%Y") as date'), 's_name as supplier', 'po_method as method', 'po_code as nota')
            ->first();

        return json_encode([
            'info' => $getInfo
        ]);
    }
    public function getpbdt(Request $request){

        if(isset($request->opsi)){
            $getOpsi = DB::table('d_purchase_order_dt')
                ->join('m_item', 'i_id', '=', 'podt_item')
                ->where('podt_purchase_order', $request->id)
                ->select('podt_item', 'i_name')->get();
            
            return json_encode([
                'opsi' => $getOpsi
            ]);
        }

        // dd($request);
        $getDT = DB::table('d_purchase_order')
            ->join('d_purchase_order_dt', 'podt_purchase_order', '=', 'po_id')
            ->join('m_satuan', 's_id', '=', 'podt_satuan')
            ->join('m_item', 'i_id', '=', 'podt_item')
            ->where('po_id', $request->id)
            ->whereIn('podt_item', $request->idItem)
            ->get();

        $getNopol = DB::table('m_kendaraan')
            ->select('k_id', 'k_nopol')->get();
        
        $getSisa = DB::table('d_penerimaan_barang')
            ->join('d_penerimaan_barang_dt', 'pbdt_penerimaan_barang', '=', 'pb_id')
            ->where('pb_ref', $getDT[0]->po_code)
            ->select('pbdt_item', DB::raw('SUM(pbdt_qty_received) as qty_received'))
            ->groupBy('pbdt_item')
            ->get();

        return json_encode([
            'data' => $getDT,
            'nopol' => $getNopol,
            'qty' => $getSisa
        ]);
    }
    public function genNota($date)
    {
        $cekNota = $date;
        $cek = DB::table('d_penerimaan_barang')
            ->whereRaw('pb_code like "%'.$cekNota.'%"')
            ->select(DB::raw('CAST(RIGHT(pb_code, 4) AS UNSIGNED) as pb_code'))
            ->orderBy('pb_id', 'desc')->first();
        if ($cek == null) {
            $temp = 1;
        } else {
            $temp = ($cek->pb_code + 1);
        }
        $kode = sprintf("%04s", $temp);
        $tempKode = 'PB/' . $cekNota . '/' . $kode;
        return $tempKode;
    }
    public function tambah_pencatatanbarangmasuk(Request $request)
    {
        if($request->isMethod('post')){
            // dd($request);
            DB::beginTransaction();
            try {
                $countId = DB::table('d_penerimaan_barang')->count();
                $maxId = 1;
                if($countId > 0){
                    $getMaxId = DB::table('d_penerimaan_barang')->max('pb_id');
                    $maxId = $getMaxId + 1;
                }
                $getSupp = DB::table('d_purchase_order')->where('po_code', $request->nota)->select('po_supplier')->first();
                $pecahTgl = explode('/', $request->tgl[0]);
                $dateNota = $pecahTgl[1].substr($pecahTgl[2], 2, 4);
                $tanggal = $pecahTgl[2].'-'.$pecahTgl[1].'-'.$pecahTgl[0];
                $waktu = $request->jam[0];
                $insertTime = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
                // dd($dateNota);

                DB::table('d_penerimaan_barang')->insert([
                    'pb_id' => $maxId,
                    'pb_code' => $this->genNota($dateNota),
                    'pb_supplier' => $getSupp->po_supplier,
                    'pb_ref' => $request->nota,
                    'pb_surat_jalan' => $request->surat[0],
                    'pb_date' => $tanggal,
                    'pb_insert' => $insertTime,
                    'pb_update' => $insertTime,
                    'pb_insert_by' => Auth::user()->id,
                    'pb_update_by' => Auth::user()->id
                ]);
                
                // Insert Penerimaan Data DT
                $arayPBDT = array();
                $countDT = 1;
                for($i = 0; $i < count($request->tgl); $i++){
                    $ceksisapbdt = DB::table('d_penerimaan_barang_dt')->where('pbdt_item', $request->idItem[$i])->count();
                    $sisa = 0;
                    if($ceksisapbdt == 0){
                        $getQty = DB::table('d_purchase_order')
                            ->join('d_purchase_order_dt', 'podt_purchase_order', '=', 'po_id')
                            ->where('po_code', $request->nota)
                            ->where('podt_item', $request->idItem[$i])
                            ->select('podt_qty')
                            ->first();                    
                        $sisa = $getQty->podt_qty - $request->muatan[$i];
                    }else{
                        $realSisa = DB::table('d_penerimaan_barang')
                            ->join('d_penerimaan_barang_dt', 'pbdt_penerimaan_barang', '=', 'pb_id')
                            ->where('pb_ref', $request->nota)
                            ->where('pbdt_item', $request->idItem[$i])  
                            ->select('pbdt_qty_remains')
                            ->orderBy('pbdt_penerimaan_barang', 'desc')->first();
                        $sisa = $realSisa->pbdt_qty_remains - $request->muatan[$i];
                    }

                    if($request->muatan[$i] != null && $request->tgl[$i] != null && $request->jam[$i] != null && $request->surat[$i] != null){
                        $aray = ([
                            'pbdt_penerimaan_barang' => $maxId,
                            'pbdt_detailid' => $countDT,
                            'pbdt_item' => $request->idItem[$i],
                            'pbdt_qty_received' => $request->muatan[$i],
                            'pbdt_qty_remains' => $sisa,
                            'pbdt_time' => $request->jam[$i]
                        ]);
                        array_push($arayPBDT, $aray);
                        $countDT++;
                    }
                }
                DB::table('d_penerimaan_barang_dt')->insert($arayPBDT);

                DB::commit();
                return json_encode([
                    'status' => 'sukses'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'gagal',
                    'msg' => $e
                ]);
            }
            
        }

        $getPlat = DB::table('m_kendaraan')->where('k_flag', 'SUPPLIER')->select('k_id', 'k_nopol')->get();
        $getNota = DB::table('d_purchase_order')->where('po_status', 'AP')->select('po_id','po_code')->get();
        
        return view('stok/pencatatanbarangmasuk/tambah_pencatatanbarangmasuk')->with(compact('getNota', 'getPlat'));
    }

    // Penggunaan Bahan Baku
    public function penggunaanbahanbaku()
    {
    	return view('stok/penggunaanbahanbaku/penggunaanbahanbaku');
    }
    public function tambah_penggunaanbahanbaku()
    {
        return view('stok/penggunaanbahanbaku/tambah_penggunaanbahanbaku');
    }

    // Tipe Menghitung HPP
    public function tipemenghitunghpp()
    {
    	return view('stok/tipemenghitunghpp/tipemenghitunghpp');
    }

    // Stokc Gudang
    public function stockgudang()
    {
        return view('stok/stockgudang/index');
    }
}
