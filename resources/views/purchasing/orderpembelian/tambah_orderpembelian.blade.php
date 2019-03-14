@extends('main')

@section('content')

<article class="content">

  <div class="title-block text-primary">
      <h1 class="title"> Tambah Order Pembelian </h1>
      <p class="title-description">
        <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
        / <span>Purchasing</span> 
        / <a href="{{route('orderpembelian')}}"><span>Order Pembelian</span></a>
        / <span class="text-primary font-weight-bold">Tambah Order Pembelian</span>
       </p>
  </div>

  <section class="section">

    <div class="row">

      <div class="col-12">
        
        <div class="card">
                    <div class="card-header bordered p-2">
                      <div class="header-block">
                        <h3 class="title"> Tambah Order Pembelian </h3>
                      </div>
                      <div class="header-block pull-right">
                        <a href="{{route('orderpembelian')}}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i></a>
                      </div>
                    </div>
                    <form id="form_purchase_order">
                      
                      <div class="card-block">
                          <section>
                            <fieldset>
                              <div class="row">

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>No Order Pembelian</label>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" readonly="" name="" placeholder="( Auto )">
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Staff</label>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="hidden" value="{{ Auth::user()->id }}" name="po_officer">
                                    <input type="text" class="form-control form-control-sm" readonly="" value="{{ Auth::user()->name }}">
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Tanggal Order Pembelian</label>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="po_tanggal">
                                  </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Tanggal Kirim</label>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm datepicker" value="" name="po_tanggal_kirim">
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Cara Bayar</label>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <select class="form-control form-control-sm" name="po_method">
                                      <option value="CASH">Tunai</option>
                                      <option value="DEPOSIT">Deposit</option>
                                      <option value="TEMPO">Tempo</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Kode Rencana Pembelian</label>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <select class="form-control form-control-sm" name="po_purchase_plan" id="po_purchase_plan">
                                      <option value="">--Pilih--</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Suplier</label>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="hidden" name="po_supplier" id="po_supplier">
                                    <input type="text" id="po_supplier_label" class="form-control form-control-sm" readonly>
                                  </div>
                                </div>

                              </div>
                            </fieldset>

                            <div class="table-responsive mt-3">
                              <table class="table table-bordered table-hover table-striped" id="table_purchase_order_dt" cellspacing="0">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>Kode | Barang</th>
                                    <th width="10%">Qty</th>
                                    <th width="10%">Satuan</th>
                                    <th>Harga Prev</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                    <th width="10%">Stok Gudang</th>
                                    <th width="10%">Aksi</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>

                            <div class="row">
                              <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6 col-xs-12">
                                <div class="row">

                                  <div class="col-lg-12">
                                    <label>Total Harga</label>
                                  </div>

                                  <div class="col-lg-12">
                                    <div class="form-group">
                                      <input type="text" readonly="" class="text-right form-control form-control-sm" name="po_total_gross" id="po_total_gross">
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-12">
                                    <label>Potongan Harga</label>
                                  </div>
                                  
                                  <div class="col-lg-12">
                                    <div class="form-group">
                                      <input type="text" class="text-right form-control form-control-sm" name="po_disc_value" id="po_disc_value">
                                    </div>
                                  </div>

                                  <div class="col-lg-12">
                                    <label>Diskon(%)</label>
                                  </div>
                                  
                                  <div class="col-lg-12">
                                    <div class="form-group">
                                      <input type="number" class="text-right form-control form-control-sm" name="po_disc_percent" id="po_disc_percent">
                                    </div>
                                  </div>

                                  <div class="col-lg-12">
                                    <label>PPn(%)</label>
                                  </div>
                                  
                                  <div class="col-lg-12">
                                    <div class="form-group">
                                      <input type="number" class="text-right form-control form-control-sm" name="po_tax_percent" id="po_tax_percent">
                                    </div>
                                  </div>

                                  <div class="col-lg-12">
                                    <label>Total</label>
                                  </div>
                                  
                                  <div class="col-lg-12">
                                    <div class="form-group">
                                      <input type="text" readonly="" class="text-right form-control form-control-sm" name="po_total_net" id="po_total_net">
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>
                          </section>
                      </div>
                    </form>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary" type="button" onclick="insert_purchase_order()">Simpan</button>
                      <a href="{{route('orderpembelian')}}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

      </div>

    </div>

  </section>

</article>

@endsection
@section('extra_script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#table_order').dataTable();
  });
</script>
  @include('purchasing/orderpembelian/js/form_functions')
  @include('purchasing/orderpembelian/js/form_commander')

@endsection