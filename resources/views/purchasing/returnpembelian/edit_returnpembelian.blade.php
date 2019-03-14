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
                          <input type="hidden" name="pr_id" value="{{ $purchase_return->pr_id }}">
                          <section>

                            <div class="row">

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Metode Return</label>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control form-control-sm" name="pr_method" value="{{ $purchase_return->pr_method }}" id="metode_return" readonly>
                                    
                                    
                                    
                                  
                                </div>
                              </div>

                            </div>

                            <div id="div_return">
                              <fieldset>
                                <div class="row">

                                  
                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nota Pembelian</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input readonly type="text" class="form-control form-control-sm" id="pr_purchase_order" name="pr_purchase_order" value="{{ $purchase_return->po_code }}" >
                                      
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
                                      <input type="text" class="form-control form-control-sm datepicker" name="pr_tanggal" value="{{ $purchase_return->pr_tanggal_label }}" readonly="">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Staff</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      
                                      <input type="text" class="form-control form-control-sm" readonly="" value="{{ $purchase_return->name }}">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Metode Bayar</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm" readonly="" name="po_method" value="{{ $purchase_return->po_method }}" id="po_method">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Total Pembelian ( Gross )</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_total_gross" value="{{ $purchase_return->po_total_gross }}" id="po_total_gross">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Diskon(%)</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="" id="po_disc_percent" value="{{ $purchase_return->po_disc_percent }}">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Potongan Harga</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_disc_value" value="{{ $purchase_return->po_disc_value }}" id="po_disc_value">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Pajak(%) </label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_tax_percent" value="{{ $purchase_return->po_tax_percent }}" id="po_tax_percent">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <label>Nilai Total Pembelian (Nett)</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="po_total_net" value="{{ $purchase_return->po_total_net }}" id="po_total_net">
                                    </div>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12 ">
                                    <label>Nilai Total Return</label>
                                  </div>

                                  <div class="col-md-3 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                      <input type="text" class="form-control form-control-sm text-right" readonly="" name="pr_pricetotal" value="{{ $purchase_return->pr_pricetotal }}" id="pr_pricetotal">
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
                      <button class="btn btn-primary" type="button" onclick="update_purchase_return()">Simpan</button>
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
<script>  
    $(document).ready(function(){
              var po_disc_value = $('[name="po_disc_value"]').val();
      var po_disc_value = 'Rp ' + accounting.formatMoney(po_disc_value,"",0,'.',',')
      $('[name="po_disc_value"]').val( po_disc_value );
      var po_total_gross = $('[name="po_total_gross"]').val();
      var po_total_gross = 'Rp ' + accounting.formatMoney(po_total_gross,"",0,'.',',')
      $('[name="po_total_gross"]').val( po_total_gross );
      var po_total_net = $('[name="po_total_net"]').val();
      var po_total_net = 'Rp ' + accounting.formatMoney(po_total_net,"",0,'.',',')
      $('[name="po_total_net"]').val( po_total_net );

        var purchase_order_dt = {!! $purchase_return_dt !!};
          if(purchase_order_dt.length > 0) {
            for(x in purchase_order_dt) {
              unit = purchase_order_dt[x];
              console.log(unit);
              var prdt_item = "<input name='prdt_item[]' value='" + unit.i_id + "' type='hidden'>" + unit.i_code + ' | ' + unit.i_name;
              var prdt_qtybeli = "<input name='prdt_qtybeli[]' value='" + unit.prdt_qtybeli + "' type='hidden'>" + unit.prdt_qtybeli;
              var prdt_qtyreturn = "<input name='prdt_qtyreturn[]' value='" + unit.prdt_qtyreturn + "' type='number' class='form-control form-control-sm text-right'>" ;
              var prdt_satuan = "<input name='prdt_satuan[]' value='" + unit.prdt_satuan + "' type='hidden' class='form-control'>" + unit.s_name;
              var prdt_price = "<input name='prdt_price[]' value='Rp. " + accounting.formatMoney(unit.prdt_price,"",0,'.',',') + "' type='text' class='form-control form-control-sm text-right'>";
              var stock = unit.stock;
              var harga_total = unit.prdt_price * unit.prdt_qtyreturn;
              harga_total = 'Rp ' + accounting.formatMoney(harga_total,"",0,'.',',') + ',00';
              var aksi = '<button type="button" class="btn btn-danger btn-hapus" onclick="remove_detail(this)"><i class="fa fa-trash-o"></i></button>';

              
              table_purchase_return_dt.row.add([
                prdt_item, prdt_qtybeli, prdt_qtyreturn, prdt_satuan, prdt_price, harga_total, stock, aksi
              ]);
            }

            table_purchase_return_dt.draw();
          }
    });
</script>
@endsection