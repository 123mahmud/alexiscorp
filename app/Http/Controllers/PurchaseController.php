<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // public function orderpembelian()
    // {
    // 	return view('purchasing/orderpembelian/orderpembelian');
    // }
    // public function tambah_orderpembelian()
    // {
    // 	return view('purchasing/orderpembelian/tambah_orderpembelian');
    // }
    // public function tambah_orderpembelian_tanparencana()
    // {
    //     return view('purchasing/orderpembelian/tambah_orderpembelian_tanparencana');
    // }    
    // public function rencanapembelian()
    // {
    // 	return view('purchasing/rencanapembelian/rencanapembelian');
    // }
    // public function tambah_rencanapembelian()
    // {
    // 	return view('purchasing/rencanapembelian/tambah_rencanapembelian');
    // }
    // public function returnpembelian()
    // {
    // 	return view('purchasing/returnpembelian/returnpembelian');
    // }
    // public function tambah_returnpembelian()
    // {
    // 	return view('purchasing/returnpembelian/tambah_returnpembelian');
    // }
    public function rencanabahanbaku()
    {
        return view('purchasing/rencanabahanbakuproduksi/rencanabahanbakuproduksi');
    }    
}
