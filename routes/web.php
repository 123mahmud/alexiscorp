<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){

	Route::get('/home', 'HomeController@index')->name('home');

	// Master
	Route::get('/master/databarang/index', 'MasterBarangController@databarang')->name('databarang');
	Route::get('/master/databarang/list', 'MasterBarangController@getList')->name('list_databarang');
	Route::get('/master/databarang/create', 'MasterBarangController@tambah_databarang')->name('tambah_databarang');
	Route::get('/master/databarang/edit/{id}', 'MasterBarangController@edit_databarang')->name('edit_databarang');
	Route::get('/master/databarang/tipe_barang', 'MasterBarangController@tipe_barang');
	Route::post('/master/databarang/save', 'MasterBarangController@save_barang');
	Route::post('/master/databarang/update', 'MasterBarangController@update');
	Route::get('/master/databarang/disabled', 'MasterBarangController@disabled');


	Route::get('/master/datasuplier/index', 'MasterSupplierController@datasuplier')->name('datasuplier');
	Route::get('/master/datasuplier/create', 'MasterSupplierController@tambah_datasuplier')->name('tambah_datasuplier');
	Route::get('/master/datasuplier/edit/{id}', 'MasterSupplierController@edit_datasuplier')->name('edit_datasuplier');
	Route::post('/master/datasuplier/save', 'MasterSupplierController@save_datasupplier')->name('edit_datasuplier');
	Route::get('/master/datasuplier/disabled', 'MasterSupplierController@disabled');
	Route::post('/master/datasuplier/update', 'MasterSupplierController@update');


	Route::get('/master/dataarmada/index', 'MasterArmadaController@dataarmada')->name('dataarmada');
	Route::get('/master/dataarmada/create', 'MasterArmadaController@tambah_dataarmada_own')->name('tambah_dataarmada_own');
	Route::post('/master/dataarmada/save', 'MasterArmadaController@save_dataarmada_own');



	Route::get('/master/dataarmada/suplier/create', 'MasterArmadaController@tambah_dataarmada')->name('tambah_dataarmada');
	Route::get('/master/dataarmada/suplier/edit', 'MasterArmadaController@edit_dataarmada')->name('edit_dataarmada');
	Route::get('/master/dataarmada/customer/create', 'MasterArmadaController@tambah_dataarmada_customer')->name('tambah_dataarmada_customer');
	Route::get('/master/dataarmada/modal_dataarmada', 'MasterArmadaController@modal_dataarmada')->name('modal_dataarmada');


	// Route::get('/master/datacustomer/datacustomer', 'MasterCustomerController@index')->name('datacustomer');
	// Route::get('/master/datacustomer/tambah_datacustomer', 'MasterCustomerController@create')->name('tambah_datacustomer');
	// Route::get('/master/datacustomer/save_datacustomer', 'MasterCustomerController@store')->name('save_datacustomer');
	// Route::get('/master/datacustomer/edit_datacustomer', 'MasterCustomerController@edit')->name('edit_datacustomer');
	// Route::get('/master/datacustomer/update_datacustomer', 'MasterCustomerController@update')->name('update_datacustomer');

	Route::get('/master/datapegawai/datapegawai', 'MasterController@datapegawai')->name('datapegawai');
	Route::get('/master/datapegawai/tambah_datapegawai', 'MasterController@tambah_datapegawai')->name('tambah_datapegawai');
	Route::get('/master/datapegawai/edit_datapegawai', 'MasterController@edit_datapegawai')->name('edit_datapegawai');


	Route::get('/master/datasatuan/datasatuan', 'MasterController@datasatuan')->name('datasatuan');
	Route::get('/master/datasatuan/getlist', 'MasterController@list_datasatuan')->name('list_datasatuan');
	Route::get('/master/datasatuan/tambah_datasatuan', 'MasterController@tambah_datasatuan')->name('tambah_datasatuan');
	Route::get('/master/datasatuan/edit_datasatuan/{id}', 'MasterController@edit_datasatuan');
	Route::post('/master/datasatuan/save', 'MasterController@save_datasatuan');
	Route::post('/master/datasatuan/update', 'MasterController@update_satuan');
	Route::post('/master/datasatuan/disabled', 'MasterController@disabeld_satuan');
//mahmud data mesin
	Route::get('/master/datamesin/datamesin', 'Master\dataMesinController@index')->name('datamesin');
	Route::get('/master/datamesin/tambah_datamesin', 'Master\dataMesinController@tambah_datamesin')->name('tambah_datamesin');
	Route::get('/master/datamesin/edit_datamesin', 'Master\dataMesinController@edit_datamesin')->name('edit_datamesin');
	Route::get('/master/datamesin/table', 'Master\dataMesinController@table');
	Route::get('/master/datamesin/simpan', 'Master\dataMesinController@simpanMesin');
	Route::get('/master/datamesin/edit/{id}', 'Master\dataMesinController@editDataMesin');
	Route::get('/master/datamesin/update/{id}', 'Master\dataMesinController@updateDataMesin');
	Route::get('/master/datamesin/status', 'Master\dataMesinController@ubahStatus');
//end data mesin

	Route::get('/master/datacustomer/index', 'MasterCustomerController@index')->name('datacustomer');
	Route::get('/master/datacustomer/getlist', 'MasterCustomerController@getlist')->name('getlist_datacustomer');
	Route::get('/master/datacustomer/create', 'MasterCustomerController@create')->name('tambah_datacustomer');
	Route::post('/master/datacustomer/save', 'MasterCustomerController@store')->name('save_datacustomer');
	Route::get('/master/datacustomer/edit/{id}', 'MasterCustomerController@edit')->name('edit_datacustomer');
	Route::post('/master/datacustomer/update/{id}', 'MasterCustomerController@update')->name('update_datacustomer');
	Route::post('/master/datacustomer/disable/{id}', 'MasterCustomerController@destroy')->name('disable_datacustomer');

//mahmud pegawai
	Route::get('/master/datapegawai/index', 'Master\PegawaiController@pegawai')->name('datapegawai');
	Route::get('/master/datapegawai/tambah-pegawai', 'Master\PegawaiController@tambahPegawai');
	Route::get('/master/datapegawai/simpan-pegawai', 'Master\PegawaiController@simpanPegawai');
	Route::get('/master/datapegawai/datatable-pegawai', 'Master\PegawaiController@pegawaiData');
	Route::get('/master/datapegawai/edit-pegawai/{id}', 'Master\PegawaiController@editPegawai');
	Route::get('/master/datapegawai/update-pegawai/{id}', 'Master\PegawaiController@updatePegawai');
	Route::get('/master/datapegawai/ubahstatus', 'Master\PegawaiController@ubahStatusMan');
//end pegawai

	Route::get('/master/datasatuan/index', 'MasterController@datasatuan')->name('datasatuan');
	Route::get('/master/datasatuan/create', 'MasterController@tambah_datasatuan')->name('tambah_datasatuan');
	Route::get('/master/datasatuan/edit', 'MasterController@edit_datasatuan')->name('edit_datasatuan');
	Route::get('/master/barangsuplier/barangsuplier', 'MasterController@barangsuplier')->name('barangsuplier');
	Route::get('/master/barangsuplier/tambah_barang', 'MasterController@tambah_barang')->name('tambah_barang');
	Route::get('/master/barangsuplier/edit_barang', 'MasterController@edit_barang')->name('edit_barang');
	Route::get('/master/barangsuplier/tambah_suplier', 'MasterController@tambah_suplier')->name('tambah_suplier');
    Route::get('/master/barangsuplier/edit_suplier', 'MasterController@edit_suplier')->name('edit_suplier');
    Route::get('/master/dataharga/index', 'MasterController@harga')->name('dataharga');
	Route::get('/master/upah/index', 'MasterController@upah')->name('upah');
	Route::get('/master/upah/create', 'MasterController@tambah_upah')->name('tambah_upah');

//mahmud jabatan
	Route::get('/master/datajabatan/index', 'Master\JabatanController@index')->name('datajabatan');
	Route::get('/master/datajabatan/create', 'Master\JabatanController@tambahJabatan')->name('tambah_datajabatan');
	Route::get('/master/datajabatan/simpan-jabatan', 'Master\JabatanController@simpanJabatan');
	Route::get('/master/datajabatan/edit-jabatan/{id}', 'Master\JabatanController@editJabatan');
	Route::get('/master/datajabatan/update-jabatan/{id}', 'Master\JabatanController@updateJabatan');
	Route::get('/master/datajabatan/data-jabatan', 'Master\JabatanController@jabatanData');
	Route::get('/master/datajabatanman/ubahstatus', 'Master\JabatanController@ubahStatusMan');
//end jabatan

	Route::get('/master/datatunjangan/index', 'MasterTunjanganController@index')->name('datatunjangan');
  Route::get('/master/datatunjangan/getlist', 'MasterTunjanganController@getlist')->name('getlist_datatunjangan');
  Route::get('/master/datatunjangan/create', 'MasterTunjanganController@create')->name('tambah_datatunjangan');
  Route::post('/master/datatunjangan/save', 'MasterTunjanganController@store')->name('save_datatunjangan');
	Route::get('/master/datatunjangan/edit/{id}', 'MasterTunjanganController@edit')->name('edit_datatunjangan');
	Route::post('/master/datatunjangan/update/{id}', 'MasterTunjanganController@update')->name('update_datatunjangan');
	Route::post('/master/datatunjangan/disable/{id}', 'MasterTunjanganController@delete')->name('disable_datatunjangan');


	// Purchasing

	// Rencana pembelian
	Route::get('/purchasing/rencanapembelian/rencanapembelian', 'Purchasing\RencanaPembelianController@rencanapembelian')->name('rencanapembelian');
	Route::get('/purchasing/rencanapembelian/tambah_rencanapembelian', 'Purchasing\RencanaPembelianController@tambah_rencanapembelian')->name('tambah_rencanapembelian');
	Route::get('/purchasing/rencanapembelian/preview_rencanapembelian/{id}', 'Purchasing\RencanaPembelianController@preview_rencanapembelian')->name('preview_rencanapembelian');
	Route::get('/purchasing/rencanapembelian/edit_rencanapembelian/{id}', 'Purchasing\RencanaPembelianController@edit_rencanapembelian')->name('edit_rencanapembelian');
	Route::get('/purchasing/rencanapembelian/find_d_purchase_plan', 'Purchasing\RencanaPembelianController@find_d_purchase_plan')->middleware('auth');
	Route::get('/purchasing/rencanapembelian/delete_d_purchase_plan/{id}', 'Purchasing\RencanaPembelianController@delete_d_purchase_plan')->middleware('auth');
	Route::get('/purchasing/rencanapembelian/find_m_item', 'Purchasing\RencanaPembelianController@find_m_item')->middleware('auth');
	Route::post('/purchasing/rencanapembelian/insert_d_purchase_plan', 'Purchasing\RencanaPembelianController@insert_d_purchase_plan')->middleware('auth')->name('insert_d_purchase_plan');
	Route::post('/purchasing/rencanapembelian/update_d_purchase_plan', 'Purchasing\RencanaPembelianController@update_d_purchase_plan')->middleware('auth')->name('update_d_purchase_plan');
	Route::get('/purchasing/rencanapembelian/approve_d_purchase_plan', 'Purchasing\RencanaPembelianController@approve_d_purchase_plan')->middleware('auth')->name('approve_d_purchase_plan');
	Route::get('/purchasing/rencanapembelian/find_m_supplier', 'Purchasing\RencanaPembelianController@find_m_supplier')->middleware('auth');

	// Order pembelian
	Route::get('/purchasing/orderpembelian/orderpembelian', 'Purchasing\OrderPembelianController@orderpembelian')->name('orderpembelian');
	Route::get('/purchasing/orderpembelian/tambah_orderpembelian', 'Purchasing\OrderPembelianController@tambah_orderpembelian')->name('tambah_orderpembelian');
	Route::get('/purchasing/orderpembelian/edit_orderpembelian/{id}', 'Purchasing\OrderPembelianController@edit_orderpembelian')->name('edit_orderpembelian');
	Route::get('/purchasing/orderpembelian/preview_orderpembelian/{id}', 'Purchasing\OrderPembelianController@preview_orderpembelian')->name('preview_orderpembelian');
	Route::get('/purchasing/orderpembelian/edit_orderpembelian/{id}', 'Purchasing\OrderPembelianController@edit_orderpembelian')->name('edit_orderpembelian');
	Route::get('/purchasing/orderpembelian/find_d_purchase_order', 'Purchasing\OrderPembelianController@find_d_purchase_order')->middleware('auth');
	Route::get('/purchasing/orderpembelian/find_d_purchase_order_dt', 'Purchasing\OrderPembelianController@find_d_purchase_order_dt')->middleware('auth')->name('find_d_purchase_order_dt');
	Route::get('/purchasing/orderpembelian/delete_d_purchase_order/{id}', 'Purchasing\OrderPembelianController@delete_d_purchase_order')->middleware('auth');
	Route::get('/purchasing/orderpembelian/find_m_item', 'Purchasing\OrderPembelianController@find_m_item')->middleware('auth');
	Route::post('/purchasing/orderpembelian/insert_d_purchase_order', 'Purchasing\OrderPembelianController@insert_d_purchase_order')->middleware('auth')->name('insert_d_purchase_order');
	Route::post('/purchasing/orderpembelian/update_d_purchase_order', 'Purchasing\OrderPembelianController@update_d_purchase_order')->middleware('auth')->name('update_d_purchase_order');
	Route::get('/purchasing/orderpembelian/approve_d_purchase_order', 'Purchasing\OrderPembelianController@approve_d_purchase_order')->middleware('auth')->name('approve_d_purchase_order');
	Route::get('/purchasing/orderpembelian/find_m_supplier', 'Purchasing\OrderPembelianController@find_m_supplier')->middleware('auth');

	Route::get('/purchasing/orderpembelian/tambah_orderpembelian_tanparencana', 'Purchasing\OrderPembelianController@tambah_orderpembelian_tanparencana')->name('tambah_orderpembelian_tanparencana');

	// Return pembelian
	Route::get('/purchasing/returnpembelian/returnpembelian', 'Purchasing\ReturnPembelianController@returnpembelian')->name('returnpembelian');
		Route::get('/purchasing/returnpembelian/tambah_returnpembelian', 'Purchasing\ReturnPembelianController@tambah_returnpembelian')->name('tambah_returnpembelian');
	Route::get('/purchasing/returnpembelian/preview_returnpembelian/{id}', 'Purchasing\ReturnPembelianController@preview_returnpembelian')->name('preview_returnpembelian');
	Route::get('/purchasing/returnpembelian/edit_returnpembelian/{id}', 'Purchasing\ReturnPembelianController@edit_returnpembelian')->name('edit_returnpembelian');
	Route::get('/purchasing/returnpembelian/find_d_purchase_return', 'Purchasing\ReturnPembelianController@find_d_purchase_return')->middleware('auth');
	Route::get('/purchasing/returnpembelian/delete_d_purchase_return/{id}', 'Purchasing\ReturnPembelianController@delete_d_purchase_return')->middleware('auth');
	Route::get('/purchasing/returnpembelian/find_m_item', 'Purchasing\ReturnPembelianController@find_m_item')->middleware('auth');
	Route::post('/purchasing/returnpembelian/insert_d_purchase_return', 'Purchasing\ReturnPembelianController@insert_d_purchase_return')->middleware('auth')->name('insert_d_purchase_return');
	Route::post('/purchasing/returnpembelian/update_d_purchase_return', 'Purchasing\ReturnPembelianController@update_d_purchase_return')->middleware('auth')->name('update_d_purchase_return');
	Route::get('/purchasing/returnpembelian/approve_d_purchase_return', 'Purchasing\ReturnPembelianController@approve_d_purchase_return')->middleware('auth')->name('approve_d_purchase_return');
	Route::get('/purchasing/returnpembelian/find_m_supplier', 'Purchasing\ReturnPembelianController@find_m_supplier')->middleware('auth');
	Route::get('/purchasing/returnpembelian/find_d_purchase_order', 'Purchasing\ReturnPembelianController@find_d_purchase_order')->middleware('auth');
	Route::get('/purchasing/returnpembelian/preview_orderpembelian/{id}', 'Purchasing\ReturnPembelianController@preview_orderpembelian')->middleware('auth');

	// Rencana bahan baku
	Route::get('/purchasing/rencanabahanbaku/rencanabahanbaku', 'PurchaseController@rencanabahanbaku')->name('rencanabahanbaku');


	// Stok
	Route::get('/stok/dataadonan/index', 'StokController@dataadonan')->name('dataadonan');
	Route::get('/stok/dataadonan/create', 'StokController@tambah_dataadonan')->name('tambah_dataadonan');
	Route::get('/stok/dataadonan/edit', 'StokController@edit_dataadonan')->name('edit_dataadonan');

	Route::get('/stok/opnamebahanbaku/index', 'StokController@opnamebahanbaku')->name('opnamebahanbaku');

	Route::get('/stok/pencatatanbarangmasuk/index', 'StokController@pencatatanbarangmasuk')->name('pencatatanbarangmasuk');
	Route::match(['get', 'post'],'/stok/pencatatanbarangmasuk/create', 'StokController@tambah_pencatatanbarangmasuk')->name('tambah_pencatatanbarangmasuk');
	Route::get('/stok/pencatatanbarangmasuk/getinfopo', 'StokController@getinfopo')->name('getinfopo');
	Route::get('/stok/pencatatanbarangmasuk/getpbdt', 'StokController@getpbdt')->name('getpbdt');

	Route::get('/stok/penggunaanbahanbaku/index', 'StokController@penggunaanbahanbaku')->name('penggunaanbahanbaku');
	Route::get('/stok/penggunaanbahanbaku/create', 'StokController@tambah_penggunaanbahanbaku')->name('tambah_penggunaanbahanbaku');

	Route::get('/stok/tipemenghitunghpp/index', 'StokController@tipemenghitunghpp')->name('tipemenghitunghpp');


	// Produksi
	Route::get('/produksi/pencatatanhasil/index', 'ProduksiController@pencatatanhasil')->name('pencatatanhasil');
	Route::get('/produksi/pencatatanhasil/denganrencana/process', 'ProduksiController@proses_pencatatanhasil')->name('proses_pencatatanhasil');
	Route::get('/produksi/pencatatanhasil/tanparencana/process', 'ProduksiController@proses_pencatatanhasiltanparencana')->name('proses_pencatatanhasiltanparencana');
	Route::get('/produksi/perencanaanproduksi/perencanaanproduksi', 'ProduksiController@perencanaanproduksi')->name('perencanaanproduksi');
	Route::get('/produksi/produksirencana/index', 'ProduksiController@produksirencana')->name('produksirencana');
	Route::get('/produksi/produksirencana/create', 'ProduksiController@tambah_produksirencana')->name('tambah_produksirencana');
	Route::get('/produksi/produksitanparencana/index', 'ProduksiController@produksitanparencana')->name('produksitanparencana');
	Route::get('/produksi/produksitanparencana/create', 'ProduksiController@tambah_produksitanparencana')->name('tambah_produksitanparencana');
	Route::get('/produksi/upahboronganproduksi/upahboronganproduksi', 'ProduksiController@upahboronganproduksi')->name('upahboronganproduksi');
	Route::get('/produksi/upahboronganproduksi/tambah_upahboronganproduksi', 'ProduksiController@tambah_upahboronganproduksi')->name('tambah_upahboronganproduksi');
	Route::get('/produksi/spk/spk', 'ProduksiController@spk')->name('spk_produksi');

	// Customer
	Route::get('/customer/historitransaksi/index', 'CustomerController@historitransaksi')->name('historitransaksi');

	// Penjualan
	Route::get('/penjualan/diskonpenjualan/index', 'PenjualanController@diskonpenjualan')->name('diskonpenjualan');
	Route::get('/penjualan/diskonpenjualan/create', 'PenjualanController@tambah_diskonpenjualan')->name('tambah_diskonpenjualan');
	Route::get('/penjualan/penjualanorder/index', 'PenjualanController@penjualanorder')->name('penjualanorder');
	Route::get('/penjualan/penjualanproject/index', 'PenjualanController@penjualanproject')->name('penjualanproject');
	Route::get('/penjualan/penjualantanpaorder/index', 'PenjualanController@penjualantanpaorder')->name('penjualantanpaorder');
	Route::get('/penjualan/penjualantanpaorder/create', 'PenjualanController@tambah_penjualantanpaorder')->name('tambah_penjualantanpaorder');
	Route::get('/penjualan/returnpenjualan/index', 'PenjualanController@returnpenjualan')->name('returnpenjualan');
	Route::get('/penjualan/returnpenjualan/create', 'PenjualanController@tambah_returnpenjualan')->name('tambah_returnpenjualan');


	// Pengiriman
	Route::get('/pengiriman/perencanaanpengiriman/index', 'PengirimanController@perencanaanpengiriman')->name('perencanaanpengiriman');
	Route::get('/pengiriman/perencanaanpengiriman/create', 'PengirimanController@tambah_perencanaanpengiriman')->name('tambah_perencanaanpengiriman');
	Route::get('/pengiriman/suratjalan/index', 'PengirimanController@suratjalan')->name('suratjalan');
	Route::get('/pengiriman/suratjalan/create', 'PengirimanController@tambah_suratjalan')->name('tambah_suratjalan');
	Route::get('/pengiriman/suratjalan/print', 'PengirimanController@print_suratjalan')->name('print_suratjalan');
	Route::get('/pengiriman/upahboronganpengiriman/index', 'PengirimanController@upahboronganpengiriman')->name('upahboronganpengiriman');
	Route::get('/pengiriman/upahboronganpengiriman/upah/process', 'PengirimanController@proses_upahboronganpengiriman')->name('proses_upahboronganpengiriman');
	Route::get('/pengiriman/upahboronganpengiriman/operasional/process', 'PengirimanController@proses_operasionaljalan')->name('proses_operasionaljalan');

	// Biaya dan Beban
	Route::get('/biayadanbeban/alattuliskantor/alattuliskantor', 'BiayaController@alattuliskantor')->name('alattuliskantor');
	Route::get('/biayadanbeban/biayabahanbakar/biayabahanbakar', 'BiayaController@biayabahanbakar')->name('biayabahanbakar');
	Route::get('/biayadanbeban/biayakesehatan/biayakesehatan', 'BiayaController@biayakesehatan')->name('biayakesehatan');
	Route::get('/biayadanbeban/biayakonsumsi/biayakonsumsi', 'BiayaController@biayakonsumsi')->name('biayakonsumsi');
	Route::get('/biayadanbeban/biayaoperasional/biayaoperasional', 'BiayaController@biayaoperasional')->name('biayaoperasional');
	Route::get('/biayadanbeban/maintenance/maintenance', 'BiayaController@maintenance')->name('maintenance');
	Route::get('/biayadanbeban/sewalahan/sewalahan', 'BiayaController@sewalahan')->name('sewalahan');
	Route::get('/biayadanbeban/upahborongan/upahborongan', 'BiayaController@upahborongan')->name('upahborongan');
	Route::get('/biayadanbeban/upahborongan/tambah_upahborongan', 'BiayaController@tambah_upahborongan')->name('tambah_upahborongan');
	Route::get('/biayadanbeban/upahbulanan/index', 'BiayaController@upahbulanan')->name('upahbulanan');
	Route::get('/biayadanbeban/upahbulanan/create', 'BiayaController@tambah_upahbulanan')->name('tambah_upahbulanan');
	Route::get('/biayadanbeban/upahharian/index', 'BiayaController@upahharian')->name('upahharian');
	Route::get('/biayadanbeban/upahharian/create', 'BiayaController@tambah_upahharian')->name('tambah_upahharian');
	Route::get('/biayadanbeban/pengeluarankecil/index', 'BiayaController@pengeluarankecil')->name('pengeluarankecil');
	Route::get('/biayadanbeban/pengeluarankecil/create', 'BiayaController@tambah_pengeluarankecil')->name('tambah_pengeluarankecil');


	// Dana Sosial

	Route::get('/danasosial/index', 'DanaController@danasosial')->name('danasosial');

	// Route::get('/danasosial/kampung/kampung', 'DanaController@kampung');
	// Route::get('/danasosial/koramil/koramil', 'DanaController@koramil');
	// Route::get('/danasosial/masjid/masjid', 'DanaController@masjid');
	// Route::get('/danasosial/polsek/polsek', 'DanaController@polsek');
	// Route::get('/danasosial/sumbangan/sumbangan', 'DanaController@sumbangan');

	// Aset
	Route::get('/aset/datagolongan/index', 'AsetController@datagolongan')->name('datagolongan');
	Route::get('/aset/datagolongan/create', 'AsetController@tambah_datagolongan')->name('tambah_datagolongan');
	Route::get('/aset/dataaset/index', 'AsetController@dataaset')->name('dataaset');
	Route::get('/aset/dataaset/create', 'AsetController@tambah_dataaset')->name('tambah_dataaset');

	// Keuangan
	// Route::get('/keuangan/a_3bottomline/a_3bottomline', 'KeuanganController@a_3bottomline');
	// Route::get('/keuangan/a_cashflow/a_cashflow', 'KeuanganController@a_cashflow');
	// Route::get('/keuangan/a_commonsize/a_commonsize', 'KeuanganController@a_commonsize');
	// Route::get('/keuangan/a_net/a_net', 'KeuanganController@a_net');
	// Route::get('/keuangan/a_pertumbuhanaset/a_pertumbuhanaset', 'KeuanganController@a_pertumbuhanaset');
	// Route::get('/keuangan/a_progress/a_progress', 'KeuanganController@a_progress');
	// Route::get('/keuangan/a_rasiokeuangan/a_rasiokeuangan', 'KeuanganController@a_rasiokeuangan');
	// Route::get('/keuangan/a_roe/a_roe', 'KeuanganController@a_roe');
	Route::get('/keuangan/laporaninputtransaksi/laporaninputtransaksi', 'KeuanganController@laporaninputtransaksi');
	Route::get('/keuangan/laporankeuangan/select', 'KeuanganController@laporankeuangan')->name('laporankeuangan');
	Route::get('/keuangan/laporankeuangan/jurnal', 'KeuanganController@jurnal')->name('jurnal');
	Route::get('/keuangan/laporankeuangan/buku_besar', 'KeuanganController@buku_besar')->name('buku_besar');
	Route::get('/keuangan/laporankeuangan/neraca_saldo', 'KeuanganController@neraca_saldo')->name('neraca_saldo');
	Route::get('/keuangan/laporankeuangan/neraca', 'KeuanganController@neraca')->name('neraca');
	Route::get('/keuangan/laporankeuangan/laba_rugi', 'KeuanganController@laba_rugi')->name('laba_rugi');
	Route::get('/keuangan/laporankeuangan/arus_kas', 'KeuanganController@arus_kas')->name('arus_kas');
	Route::get('/keuangan/prosesinputtransaksi/select', 'KeuanganController@pilih_prosesinputtransaksi')->name('pilih_prosesinputtransaksi');
	Route::get('/keuangan/prosesinputtransaksi/inputransaksikas/create', 'KeuanganController@inputtransaksikas')->name('inputtransaksikas');
	Route::get('/keuangan/prosesinputtransaksi/inputransaksibank/create', 'KeuanganController@inputtransaksibank')->name('inputtransaksibank');
	Route::get('/keuangan/prosesinputtransaksi/inputransaksimemorial/create', 'KeuanganController@inputtransaksimemorial')->name('inputtransaksimemorial');
	Route::get('/keuangan/analisa/select', 'KeuanganController@analisa')->name('analisa');
	Route::get('/keuangan/analisa/net_profit_ocf', 'KeuanganController@net_profit_ocf')->name('net_profit_ocf');
	Route::get('/keuangan/analisa/hutang_piutang', 'KeuanganController@hutang_piutang')->name('hutang_piutang');
	Route::get('/keuangan/analisa/pertumbuhan_aset', 'KeuanganController@pertumbuhan_aset')->name('pertumbuhan_aset');
	Route::get('/keuangan/analisa/aset_ekuitas', 'KeuanganController@aset_ekuitas')->name('aset_ekuitas');


	// Suplier
	// Route::get('/suplier/barangsuplier/barangsuplier', 'SuplierController@barangsuplier')->name('barangsuplier');
	// Route::get('/suplier/barangsuplier/tambah_barang', 'SuplierController@tambah_barang')->name('tambah_barang');
	// Route::get('/suplier/barangsuplier/edit_barang', 'SuplierController@edit_barang')->name('edit_barang');
	// Route::get('/suplier/barangsuplier/tambah_suplier', 'SuplierController@tambah_suplier')->name('tambah_suplier');
	// Route::get('/suplier/barangsuplier/edit_suplier', 'SuplierController@edit_suplier')->name('edit_suplier');
	// Route::get('/suplier/dataarmada/dataarmada', 'SuplierController@dataarmada');

	// Admin System
	Route::get('/system/manajemenhakakses/index', 'SystemController@manajemenhakakses')->name('manajemenhakakses');
	Route::get('/system/manajemenhakakses/create', 'SystemController@tambah_manajemenhakakses')->name('tambah_manajemenhakakses');
	Route::get('/system/manajemenuser/index', 'SystemController@manajemenuser')->name('manajemenuser');
	Route::get('/system/profilperusahaan/index', 'SystemController@profilperusahaan')->name('profilperusahaan');
	Route::get('/system/tahunfinansial/index', 'SystemController@tahunfinansial')->name('tahunfinansial');

}); // End Route Group




























































































































































































// 1 + 1 = 322
