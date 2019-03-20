<header class="header">
    <div class="header-block header-block-collapse
     {{-- d-lg-none d-sm-block --}}
     ">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
{{--     <div class="header-block header-block-collapse d-lg-block d-sm-none d-none">
        <button class="collapse-btn" id="sidebar-collapse-btn-lg"  style="color:rosybrown;">
            <i class="fa fa-bars"></i>
        </button>
    </div>   --}}  
{{--     <div id="search-container" class="header-block header-block-search">
        <form role="search">
            <div class="input-container">
                <i class="fa fa-search"></i>
                <input type="search" placeholder="Search" id="filterInput">
                <button type="button" class="btn btn-secondary btn-sm d-none" id="btn-reset">
                    <i class="fa fa-times"></i>
                </button>
                <div class="underline"></div>
            </div>
        </form>
    </div> --}}
    <!-- <div class="header-block header-block-buttons">
        <a href="https://github.com/modularcode/modular-admin-html" class="btn btn-sm header-btn">
            <i class="fa fa-github-alt"></i>
            <span>View on GitHub</span>
        </a>
        <a href="https://github.com/modularcode/modular-admin-html/stargazers" class="btn btn-sm header-btn">
            <i class="fa fa-star"></i>
            <span>Star Us</span>
        </a>
        <a href="https://github.com/modularcode/modular-admin-html/releases" class="btn btn-sm header-btn">
            <i class="fa fa-cloud-download"></i>
            <span>Download .zip</span>
        </a>
    </div> -->
    <div class="header-block header-block-nav">
        <ul class="nav-profile">
            {{-- <li class="d-block d-sm-block d-md-none">
                <a id="search-mobile" href="javascript:void(0);"><i class="fa fa-search"></i></a>
            </li> --}}
            <li class="notifications new">
                <a href="" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <sup>
                        <span class="counter">8</span>
                    </sup>
                </a>
                <div class="dropdown-menu notifications-dropdown-menu">
                    <ul class="notifications-container">
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/assets/faces/3.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p>
                                        <span class="accent">Zack Alien</span> pushed new commit:
                                        <span class="accent">Fix page load performance issue</span>. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/assets/faces/5.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p>
                                        <span class="accent">Amaya Hatsumi</span> started new task:
                                        <span class="accent">Dashboard UI design.</span>. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/assets/faces/8.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p>
                                        <span class="accent">Andy Nouman</span> deployed new version of
                                        <span class="accent">NodeJS REST Api V3</span>
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <footer>
                        <ul>
                            <li>
                                <a href=""> View All </a>
                            </li>
                        </ul>
                    </footer>
                </div>
            </li>
            <li class="profile dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="img" style="background-image: url('https://avatars3.githubusercontent.com/u/3959008?v=3&s=40')"> </div>
                    <span class="name"> Administrator {{-- {{Auth::user()->name}} --}} </span>
                </a>
                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-user icon"></i> Profile </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-bell icon"></i> Notifications </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-gear icon"></i> Settings </a>
                    <div class="dropdown-divider"></div>
                    <a id="btn-logout" class="dropdown-item"
                    href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     // document.getElementById('logout-form').submit();
                                                     "
                                                     >
                        <i class="fa fa-power-off icon"></i> Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>
<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <img src="{{asset('assets/img/games.ico')}}" height="45px" width="45px" class="mr-2">
                {{-- <div class="logo">
                    <span class="l l1"></span>
                    <span class="l l2"></span>
                    <span class="l l3"></span>
                    <span class="l l4"></span>
                    <span class="l l5"></span>
                </div>  --}}
                <span class="brand-title">Alexis</span>
            </div>
            <form role="search">
                <div class="input-container">
                    <div class="input-container-prepend">
                        <button class="btn btn-secondary btn-sm" type="button" id="btn-search-menu">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <input type="search" placeholder="Cari Menu" id="filterInput">
                    <button type="button" class="btn btn-secondary btn-sm d-none" id="btn-reset">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="underline"></div>
                </div>
            </form>
        </div>
        <nav class="menu" id="sidebar">
            <ul class="sidebar-menu metismenu" id="sidebar-menu">

                <li class="{{Request::is('home') ? 'active' : ''  || Request::is('/') ? 'active' : ''}}">
                    <a href="{{url('/')}}">
                        <i class="fa fa-home"></i> 
                        <span class="menu-title">Dashboard </span>
                    </a>
                </li>
                <li class="{{Request::is('master/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-th-large"></i> 
                        <span class="menu-title">Master Data</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('master/databarang/*') ? 'active' : ''}}">
                            <a href="{{route('databarang')}}">Data Barang</a>
                        </li>
                        <li class="{{Request::is('master/datasuplier/*') ? 'active' : ''}}">
                            <a href="{{route('datasuplier')}}">Data Suplier</a>
                        </li>
                        <li class="{{Request::is('master/datacustomer/*') ? 'active' : ''}}">
                            <a href="{{route('datacustomer')}}">Data Customer</a>
                        </li>
                        <li class="{{Request::is('master/datapegawai/*') ? 'active' : ''}}">
                            <a href="{{route('datapegawai')}}">Data Pegawai</a>
                        </li>
                        <li class="{{Request::is('master/dataarmada/*') ? 'active' : ''}}">
                            <a href="{{route('dataarmada')}}">Data Armada</a>
                        </li>
                        <li class="{{Request::is('master/datasatuan/*') ? 'active' : ''}}">
                            <a href="{{route('datasatuan')}}">Data Satuan</a>
                        </li>
                        <li class="{{Request::is('master/datamesin/*') ? 'active' : ''}}">
                            <a href="{{route('datamesin')}}">Data Mesin</a>
                        </li>
                        <li class="{{Request::is('master/barangsuplier/*') ? 'active' : ''}}">
                            <a href="{{route('barangsuplier')}}">Item Barang Suplier</a>
                        </li>
                        <li class="{{Request::is('master/dataharga/*') ? 'active' : ''}}">
                            <a href="{{route('dataharga')}}">Data Harga</a>
                        </li>
                        <li class="{{Request::is('master/upah/*') ? 'active' : ''}}">
                            <a href="{{route('upah')}}">Data Upah</a>
                        </li>
                        <li class="{{Request::is('master/datatunjangan/*')}}">
                            <a href="{{route('datatunjangan')}}">Data Tunjangan</a>
                        </li>
                        <li class="{{Request::is('master/datajabatan/*') ? 'active' : ''}}">
                            <a href="{{route('datajabatan')}}">Data Jabatan</a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="{{Request::is('suplier/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-user"></i> Suplier
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('suplier/barangsuplier/*') ? 'active' : ''}}">
                            <a href="{{url('suplier/barangsuplier/barangsuplier')}}">Item Barang Suplier</a>
                        </li>
                        <li class="{{Request::is('suplier/dataarmada/*') ? 'active' : ''}}">
                            <a href="{{url('suplier/dataarmada/dataarmada')}}">Data Armada</a>
                        </li>
                    </ul>
                </li> -->
                <li class="{{Request::is('purchasing/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-credit-card"></i>
                        <span class="menu-title">Purchasing</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('purchasing/rencanapembelian/*') ? 'active' : ''}}">
                            <a href="{{route('rencanapembelian')}}"> Rencana Pembelian</a>
                        </li>
                        <li class="{{Request::is('purchasing/orderpembelian/*') ? 'active' : ''}}">
                            <a href="{{route('orderpembelian')}}">Order Pembelian</a>
                        </li>
                        <li class="{{Request::is('purchasing/returnpembelian/*') ? 'active' : ''}}">
                            <a href="{{route('returnpembelian')}}">Return Pembelian</a>
                        </li>
                        <li class="{{Request::is('purchasing/rencanabahanbaku/*') ? 'active' : ''}}">
                            <a href="{{route('rencanabahanbaku')}}" title="Rencana Bahan Baku Produksi">Bahan Baku Produksi</a>
                        </li>
                    </ul>
                </li>
                <li class="{{Request::is('stok/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-desktop"></i> 
                        <span class="menu-title">Stok</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('stok/dataadonan/*') ? 'active' : ''}}">
                            <a href="{{route('dataadonan')}}">Data Adonan</a>
                        </li>
                        <li class="{{Request::is('stok/tipemenghitunghpp/*') ? 'active' : ''}}">
                            <a href="{{route('tipemenghitunghpp')}}">Tipe Menghitung HPP</a>
                        </li>
                        <li class="{{Request::is('stok/pencatatanbarangmasuk/*') ? 'active' : ''}}">
                            <a href="{{route('pencatatanbarangmasuk')}}">Pencatatan Barang Masuk</a>
                        </li>
                        <li class="{{Request::is('stok/penggunaanbahanbaku/*') ? 'active' : ''}}">
                            <a href="{{route('penggunaanbahanbaku')}}">Penggunaan Bahan Baku </a>
                        </li>
                        <li class="{{Request::is('stok/opnamebahanbaku/*') ? 'active' : ''}}">
                            <a href="{{route('opnamebahanbaku')}}">Opname Stock </a>
                        </li>
                    </ul>
                </li>
                <li class="{{Request::is('produksi/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-product-hunt"></i> 
                        <span class="menu-title">Produksi</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        {{-- <li class="{{Request::is('produksi/perencanaanproduksi/*') ? 'active' : ''}}">
                            <a href="{{url('produksi/perencanaanproduksi/perencanaanproduksi')}}"> Perencanaan Produksi </a>
                        </li> --}}
                        <li class="{{Request::is('produksi/produksitanparencana/*') ? 'active' : ''}}">
                            <a href="{{route('produksitanparencana')}}"> Pencatatan Produksi Tanpa Rencana </a>
                        </li>
                        <li  class="{{Request::is('produksi/produksirencana/*') ? 'active' : ''}}">
                            <a href="{{route('produksirencana')}}"> Pencatatan Produksi Dengan Rencana </a>
                        </li>
                        <li  class="{{Request::is('produksi/pencatatanhasil/*') ? 'active' : ''}}">
                            <a href="{{route('pencatatanhasil')}}"> Pencatatan Hasil Produksi</a>
                        </li>
                        <li  class="{{Request::is('produksi/upahboronganproduksi/*') ? 'active' : ''}}">
                            <a href="{{route('upahboronganproduksi')}}"> Upah Borongan Produksi</a>
                        </li>
                        <li class="{{Request::is('produksi/spk/*') ? 'active' : ''}}">
                            <a href="{{route('spk_produksi')}}">Manajemen SPK</a>
                        </li>
                    </ul>
                </li>
                <li class="{{Request::is('customer/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-group"></i>
                        <span class="menu-title">Customer</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li  class="{{Request::is('customer/historitransaksi/*') ? 'active' : ''}}">
                            <a href="{{route('historitransaksi')}}"> Histori Transaksi</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="{{Request::is('penjualan/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-usd"></i>
                        <span class="menu-title">Penjualan</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li  class="{{Request::is('penjualan/penjualanorder/*') ? 'active' : ''}}">
                            <a href="{{route('penjualanorder')}}"> Penjualan Dengan Order</a>
                        </li>
                        <li class="{{Request::is('penjualan/penjualantanpaorder/*') ? 'active' : ''}}">
                            <a href="{{route('penjualantanpaorder')}}"> Penjualan Tanpa Order</a>
                        </li>
                        <li class="{{Request::is('penjualan/diskonpenjualan/*') ? 'active' : ''}}">
                            <a href="{{route('diskonpenjualan')}}"> Diskon Penjualan</a>
                        </li>
                        {{-- <li class="{{Request::is('penjualan/penjualanproject/*') ? 'active' : ''}}">
                            <a href="{{route('penjualanproject')}}"> Penjualan Project</a>
                        </li> --}}
                        <li class="{{Request::is('penjualan/returnpenjualan/*') ? 'active' : ''}}">
                            <a href="{{route('returnpenjualan')}}"> Return Penjualan</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="{{Request::is('pengiriman/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-truck"></i><span class="menu-title"> Pengiriman</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('pengiriman/perencanaanpengiriman/*') ? 'active' : ''}}">
                            <a href="{{route('perencanaanpengiriman')}}"> Perencanaan Pengiriman</a>
                        </li>
                        <li class="{{Request::is('pengiriman/upahboronganpengiriman/*') ? 'active' : ''}}">
                            <a href="{{route('upahboronganpengiriman')}}"> Upah Borongan Pengiriman</a>
                        </li>

                        <li class="{{Request::is('pengiriman/suratjalan/*') ? 'active' : ''}}">
                            <a href="{{route('suratjalan')}}"> Surat Jalan</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="{{Request::is('biayadanbeban/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-balance-scale "></i><span class="menu-title"> Biaya dan Beban</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        {{-- <li class="{{Request::is('biayadanbeban/upahborongan/*') ? 'active' : ''}}">
                            <a href="{{route('upahborongan')}}"> Upah Borongan</a>
                        </li> --}}
                        <li class="{{Request::is('biayadanbeban/upahharian/*') ? 'active' : ''}}">
                            <a href="{{route('upahharian')}}"> Upah Harian</a>
                        </li>
                        <li class="{{Request::is('biayadanbeban/upahbulanan/*') ? 'active' : ''}}">
                            <a href="{{route('upahbulanan')}}"> Upah Bulanan</a>
                        </li>
                        {{-- <li class="{{Request::is('biayadanbeban/sewalahan/*') ? 'active' : ''}}">
                            <a href="{{route('sewalahan')}}"> Sewa Lahan</a>
                        </li> --}}
                       {{--  <li class="{{Request::is('biayadanbeban/biayaoperasional/*') ? 'active' : ''}}">
                            <a href="{{route('biayaoperasional')}}"> Biaya Operasional</a>
                        </li>
                        <li class="{{Request::is('biayadanbeban/biayabahanbakar/*') ? 'active' : ''}}">
                            <a href="{{route('biayabahanbakar')}}"> Biaya Bahan Bakar</a>
                        </li>
                        <li class="{{Request::is('biayadanbeban/biayakonsumsi/*') ? 'active' : ''}}">
                            <a href="{{route('biayakonsumsi')}}"> Biaya Konsumsi</a>
                        </li>
                        <li class="{{Request::is('biayadanbeban/biayakesehatan/*') ? 'active' : ''}}">
                            <a href="{{route('biayakesehatan')}}"> Biaya Kesehatan</a>
                        </li>
                        <li class="{{Request::is('biayadanbeban/alattuliskantor/*') ? 'active' : ''}}">
                            <a href="{{route('alattuliskantor')}}"> Alat Tulis Kantor</a>
                        </li> --}}
                        <li class="{{Request::is('biayadanbeban/pengeluarankecil/*') ? 'active' : ''}}">
                            <a href="{{route('pengeluarankecil')}}">Biaya Pengeluaran Kecil</a>
                        </li>
                        <li class="{{Request::is('biayadanbeban/maintenance/*') ? 'active' : ''}}">
                            <a href="{{route('maintenance')}}"> Maintenance</a>
                        </li>
                        
                    </ul>
                </li>
{{--                 <li class="{{Request::is('danasosial/*') ? 'active' : ''}}">
                    <a href="{{route('danasosial')}}">
                        <i class="fa fa-users"></i><span class="menu-title"> Dana Sosial</span>
                    </a>
                </li> --}}
                <li class="{{Request::is('aset/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-line-chart"></i><span class="menu-title"> Aset</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('aset/datagolongan/*') ? 'active' : ''}}">
                            <a href="{{route('datagolongan')}}"> Data Golongan Aset</a>
                        </li>
                        <li class="{{Request::is('aset/dataaset/*') ? 'active' : ''}}">
                            <a href="{{route('dataaset')}}"> Data Aset</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="{{Request::is('keuangan/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-money"></i><span class="menu-title"> Keuangan</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('keuangan/prosesinputtransaksi/*') ? 'active' : ''}}">
                            <a href="{{route('pilih_prosesinputtransaksi')}}"> Proses Input Transaksi</a>
                        </li>

                        <li class="{{Request::is('keuangan/laporankeuangan/*') ? 'active' : ''}}">
                            <a href="{{route('laporankeuangan')}}"> Laporan Keuangan</a>
                        </li>
                        <li class="{{Request::is('keuangan/analisa/*') ? 'active' : ''}}">
                            <a href="{{route('analisa')}}">Analisa</a>
                        </li>

                        
                    </ul>
                </li>
                <li class="{{Request::is('system/*') ? 'active open' : ''}}">
                    <a href="#">
                        <i class="fa fa-user-circle-o "></i><span class="menu-title"> Admin System</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="{{Request::is('system/manajemenuser/*') ? 'active' : ''}}">
                            <a href="{{route('manajemenuser')}}"> Manajemen User</a>
                        </li>
                        <li class="{{Request::is('system/manajemenhakakses/*') ? 'active' : ''}}">
                            <a href="{{route('manajemenhakakses')}}"> Manajemen Hak Akses</a>
                        </li>
                        <li class="{{Request::is('system/profilperusahaan/*') ? 'active' : ''}}">
                            <a href="{{route('profilperusahaan')}}"> Profil Perusahaan</a>
                        </li>
                        <li class="{{Request::is('system/tahunfinansial/*') ? 'active' : ''}}">
                            <a href="{{route('tahunfinansial')}}"> Tahun Financial</a>
                        </li>
                        
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <footer class="sidebar-footer">
        <ul class="sidebar-menu metismenu" id="customize-menu">
            <li>
                <ul>
                    <li class="customize">
                        <div class="customize-item">
                            <div class="row customize-header">
                                <div class="col-4"> </div>
                                <div class="col-4">
                                    <label class="title">fixed</label>
                                </div>
                                <div class="col-4">
                                    <label class="title">static</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="title">Sidebar:</label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="sidebarPosition" value="sidebar-fixed">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="sidebarPosition" value="">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="title">Header:</label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="headerPosition" value="header-fixed">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="headerPosition" value="">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="title">Footer:</label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="footerPosition" value="footer-fixed">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input class="radio" type="radio" name="footerPosition" value="">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="customize-item">
                            <ul class="customize-colors">
                                <li>
                                    <span class="color-item color-red" data-theme="red"></span>
                                </li>
                                <li>
                                    <span class="color-item color-orange" data-theme="orange"></span>
                                </li>
                                <li>
                                    <span class="color-item color-green active" data-theme=""></span>
                                </li>
                                <li>
                                    <span class="color-item color-seagreen" data-theme="seagreen"></span>
                                </li>
                                <li>
                                    <span class="color-item color-blue" data-theme="blue"></span>
                                </li>
                                <li>
                                    <span class="color-item color-purple" data-theme="purple"></span>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <a href="#">
                    <i class="fa fa-cog"></i> 
                    <span class="customize-menu-title">Customize </span>
                </a>
            </li>
        </ul>
    </footer>
</aside>
<div class="sidebar-overlay" id="sidebar-overlay"></div>
<div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
<div class="mobile-menu-handle"></div>
