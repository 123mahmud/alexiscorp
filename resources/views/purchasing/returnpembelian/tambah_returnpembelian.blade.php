@extends('main')

@section('content')



<article class="content">

  <div class="title-block text-primary">
      <h1 class="title"> Tambah Return Pembelian </h1>
      <p class="title-description">
        <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
        / <span>Purchasing</span> 
        / <a href="{{route('returnpembelian')}}"><span>Return Pembelian</span> </a>
        / <span class="text-primary" style="font-weight: bold;">Tambah Return Pembelian</span>
       </p>
  </div>

  <section class="section">

    <div class="row">

      <div class="col-12">
        
        <div class="card">
                    <div class="card-header bordered p-2">
                      <div class="header-block">
                        <h3 class="title"> Tambah Return Pembelian </h3>
                      </div>
                      <div class="header-block pull-right">
                        <a href="{{route('returnpembelian')}}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i></a>
                      </div>
                    </div>
                    <div class="card-block">
                        <form id="form_purchase_return">
                          
                          <section>

                            <div class="row">

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Metode Return</label>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control form-control-sm" name="pr_method" id="metode_return">
                                    <option value="">--Pilih--</option>
                                    <option value="TB">Tukar Barang</option>
                                    <option value="PN">Potong Nota</option>
                                  </select>
                                </div>
                              </div>

                            </div>

                            <div id="div_return" class="d-none">
                              <fieldset>
                                <div class="row">

                                  
                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nota Pembelian</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <select class="form-control form-control-sm" id="pr_purchase_order" name="pr_purchase_order" >
                                      </select>
                                    </div>
                                  </div>

                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                      <label>Kode Return</label>
                                    </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm" readonly="" placeholder="( Auto )">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Tanggal Return</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm datepicker" name="pr_tanggal" value="{{ date('d-m-Y') }}">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Staff</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="hidden" name="pr_officer" value="{{ Auth::user()->id }}">
                                      <input type="text" class="form-control form-control-sm" readonly="" value="{{ Auth::user()->name }}">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Metode Bayar</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm" readonly="" name="po_method" id="po_method">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Total Pembelian ( Gross )</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_total_gross" id="po_total_gross">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Diskon(%)</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="" id="po_disc_percent">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Potongan Harga</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_disc_value" id="po_disc_value">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Pajak(%) </label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_tax_percent" id="po_tax_percent">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Total Pembelian (Nett)</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_total_net" id="po_total_net">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12 ">
                                    <label>Nilai Total Return</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="pr_pricetotal" id="pr_pricetotal">
                                    </div>
                                  </div>

                                </div>

                              </fieldset>

                              <div class="table-responsive mt-3">
                                <table class="table table-hover table-striped table-bordered" id="table_purchase_return_dt">
                                  <thead class="bg-primary">
                                    <tr>
                                      <th>Kode | Barang</th>
                                      <th>Qty Beli</th>
                                      <th>Qty Return</th>
                                      <th>Satuan</th>
                                      <th>Harga</th>
                                      <th>Total</th>
                                      <th>Stok</th>
                                      <th>Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    
                                  </tbody>
                                </table>
                              </div>

                            </div>
                          </section>
                        </form>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary" type="button" onclick="insert_purchase_return()">Simpan</button>
                      <a href="{{route('returnpembelian')}}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

      </div>

    </div>

  </section>

</article>

@endsection

@section('extra_script')
<script type="text/javascript">
  $('#metode_return').on('change', function(){
    if($(this).val() === 'TB'){
      $('#div_return').removeClass('d-none');
      $('.120mm').addClass('d-none');
    } else if($(this).val() === 'PN'){
      $('#div_return').removeClass('d-none');
      $('.120mm').removeClass('d-none');
    } else {
      $('#div_return').addClass('d-none');
      $('.120mm').addClass('d-none');
    }
  });
</script>
@include('purchasing/returnpembelian/js/form_functions')
@include('purchasing/returnpembelian/js/form_commander')
@endsection