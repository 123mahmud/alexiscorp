@extends('main')

@section('content')

<article class="content">

  <div class="title-block text-primary">
      <h1 class="title"> Tambah Return Penjualan </h1>
      <p class="title-description">
        <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
        / <span>Penjualan</span>
        / <a href="{{route('returnpenjualan')}}"><span>Return Penjualan</span> </a>
        / <span class="text-primary font-weight-bold">Tambah Return Penjualan</span>
       </p>
  </div>

  <section class="section">

    <div class="row">

      <div class="col-12">

        <div class="card">
                    <div class="card-header bordered p-2">
                      <div class="header-block">
                        <h3 class="title"> Tambah Return Penjualan </h3>
                      </div>
                      <div class="header-block pull-right">
                        <a href="{{route('returnpenjualan')}}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i></a>
                      </div>
                    </div>
                    <div class="card-block">
                        <section>

                          <form id="upperForm">
                            <div class="row">
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Metode Return</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control form-control-sm select2" id="return_method" name="return_method">
                                    <option value="" disabled selected>- Pilih Metode Return -</option>
                                    <option value="PN"> Potong Nota </option>
                                    <option value="TB"> Tukar Barang </option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Jenis Return</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control form-control-sm select2" id="return_type" name="return_type">
                                    <option value="" disabled>- Pilih Jenis Return -</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </form>

                          <!--  fieldset (inside box upside) -->
                          <form id="middleForm">
                            <fieldset>
                              <div class="row">

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Nota Penjualan</label>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="hidden" name="sales_type" id="sales_type_hidden" value="">
                                    <select class="form-control form-control-sm select2" id="sales_note" name="sales_note_id">
                                      <option value="" disabled selected>- Cari Nota -</option>
                                      @foreach($data['sales'] as $sales)
                                      <option value="{{ $sales->s_id }}">{{ $sales->s_note }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Tanggal Return</label>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="return_date">
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Metode Pembayaran</label>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" readonly="" id="payment_method" name="">
                                  </div>
                                </div>

                              </div>
                            </fieldset>
                          </form>

                          <!-- below fieldset -->
                          <form id="bottomForm">
                            <div class="row mt-3">

                              <div class="col-md-3 col-sm-12">
                                <label>Detail Pelanggan</label>
                              </div>
                              <div class="col-md-9 col-sm-12">
                                <div class="form-group">
                                  <input type="hidden" id="cust_id_hidden" name="cust_id">
                                  <input type="text" class="form-control form-control-sm" readonly="" id="cust_detail" name="">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Total Return</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" min="0" class="form-control-sm form-control currency text-right" readonly="" id="sales_total_return" name="sales_total_return">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>S Gross</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control-sm form-control currency text-right" readonly="" id="sales_gross" name="sales_gross">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Total Diskon</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <!-- <input type="hidden" name="sales_discp" id="sales_discp" value="">
                                  <input type="hidden" name="sales_disch" id="sales_disch" value=""> -->
                                  <input type="text" class="form-control-sm form-control currency text-right" readonly="" id="sales_total_disc" name="">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Total Penjualan (NETT)</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control-sm form-control currency text-right" readonly="" id="sales_total_net" name="sales_total_net">
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>PPn</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <input type="text" min="0" class="form-control form-control-sm currency-x text-right" name="sales_ppn" id="sales_ppn" value="0">
                                    <div class="input-group-append">
                                      <span class="input-group-text">%</span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </form>


                          <div id="jumlah_salah" class="d-none">
                            <div class="table-responsive mt-3">
                              <table class="table table-hover table-striped" id="table_penjualan_kb" cellspacing="0">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>Nama</th>
                                    <th>Pesanan (qty)</th>
                                    <th>Return (qty)</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Disc Percent</th>
                                    <th>Disc Value</th>
                                    <th>Total Belanja</th>
                                    <th>Total Return</th>
                                    <th>Total Barang Sesuai</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>

                          <div id="barang_rusak" class="d-none">
                            <div class="table-responsive mt-3">
                              <table class="table table-hover table-striped" id="table_penjualan_br" cellspacing="0">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>Nama</th>
                                    <th>Pesanan (qty)</th>
                                    <th>Rusak (qty)</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Disc Percent</th>
                                    <th>Disc Value</th>
                                    <th>Total Belanja</th>
                                    <th>Total Rusak</th>
                                    <th>Total Barang Sesuai</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>

                          <div id="kembali_uang" class="d-none">
                            <div class="table-responsive mt-3">
                              <table class="table table-hover table-striped" cellspacing="0">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Rusak / Salah Kirim</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Disc Percent</th>
                                    <th>Disc Value</th>
                                    <th>Jumlah Kirim</th>
                                    <th>Total Barang Sesuai</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>

                        </section>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary" type="button" id="btn_simpan">Simpan</button>
                      <a href="{{route('returnpenjualan')}}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

      </div>

    </div>

  </section>

</article>

@endsection

@section('extra_script')
<script type="text/javascript">
  // jquery token
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var tb_penjualan;

  $(document).ready(function(){
    $('#sales_note').attr('disabled', true);

    $('#return_method').on('change', function(){
      if ($(this).val() === 'PN') {
        $('#return_type').find('option').remove();
        $('#return_type').append('<option value="" disabled selected>- Pilih Jenis Return -</option>');
        $('#return_type').append('<option value="BR">Barang Rusak</option>');
        $('#return_type').append('<option value="KB">Kelebihan Barang</option>');
      } else if ($(this).val() === 'TB') {
        $('#return_type').find('option').remove();
        $('#return_type').append('<option value="" disabled selected>- Pilih Jenis Return -</option>');
        $('#return_type').append('<option value="BR">Barang Rusak</option>');
      } else {
        $('#sales_note').attr('disabled', true);
        $('#return_type').find('option').remove();
        $('#return_type').append('<option value="" disabled selected> - Pilih Jenis Return</option>');
      }
      $('#return_type').focus();
      $('#return_type').select2('open');
    });

    $('#return_type').on('change', function() {
      resetAllInput(1);
      $('#sales_note').attr('disabled', false);
      if ($(this).val() === 'BR') {
        $('#barang_rusak').removeClass('d-none');
        $('#jumlah_salah').addClass('d-none');
      } else if ($(this).val() === 'KB') {
        $('#barang_rusak').addClass('d-none');
        $('#jumlah_salah').removeClass('d-none');
      }
      $('#sales_note').focus();
      $('#sales_note').select2('open');
    });

    $('#sales_note').on('change', function() {
      $.ajax({
        url: "{{ route('returnpenjualan.getsales') }}",
        type: 'get',
        data: {
          'id_sales': $('#sales_note').val()
        },
        success: function(response) {
          console.log(response);
          $('#sales_type_hidden').val(response.sales.s_channel);
          $('#payment_method').val(response.sales.get_sales_payment.get_payment_method.pm_name);
          $('#cust_id_hidden').val(response.sales.get_customer.c_id);
          $('#cust_detail').val(response.sales.get_customer.c_name+ ', ' +response.sales.get_customer.c_address);
          $('#sales_total_disc').val(response.totalDisc);
          $('#sales_gross').val(parseInt(response.sales.s_gross));
          $('#sales_total_net').val(parseInt(response.sales.s_net));
          $('#sales_ppn').val(parseInt(response.sales.s_tax));

          // insert item into DataTable
          if ($('#return_type').val() === 'KB')
          {
            $('#table_penjualan_kb').dataTable().fnDestroy();
            tb_penjualan = $('#table_penjualan_kb').DataTable();
        		tb_penjualan.clear().draw();
            $.each(response.sales.get_sales_dt, function(key, val) {
              rowId = tb_penjualan.rows().count();
              console.log(val, rowId);
              tb_penjualan.row.add([
                val.get_item.i_name +
                  '<input type="hidden" value="'+ val.sd_item +'" class="barang" name="listItemId[]">',
                '<input type="text" min="0" class="form-control form-control-plaintext digits" name="listQty[]" value="'+ val.sd_qty +'">',
                '<input type="text" min="0" class="form-control form-control-sm digits" name="listReturnQty[]" value="0" onchange="countTotalReturn('+ rowId +')">' ,
                '<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ val.get_item.get_satuan1.s_name +'">' +
                  '<input type="hidden" value="'+ val.get_item.i_sat1 +'" name="listSatId[]">',
                '<input type="text" class="form-control form-control-plaintext form-control-sm currency" name="listPrice[]" value="'+ val.sd_price +'">',
                '<input type="text" min="0" class="form-control form-control-plaintext digits" name="listDiscP[]" value="'+ val.sd_disc_percent +'">' +
                  '<input type="hidden" value="'+ val.sd_disc_vpercent +'" name="listDiscVP[]">',
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listDiscH[]" value="'+ parseInt(val.sd_disc_value) / parseInt(val.sd_qty) +'">',
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listTotalBelanja[]" value="'+ val.sd_total +'">' ,
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listTotalReturn[]" value="'+ 0 +'">' ,
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listTotalBrgSesuai[]" value="'+ 0 +'">'
              ]).node().id = rowId;
              $.each(tb_penjualan.row(rowId).nodes().to$().find('.currency'), function() {
                $(this).inputmask("currency", {
                  radixPoint: ".",
                  groupSeparator: ".",
                  digits: 2,
                  autoGroup: true,
                  prefix: '', //Space after $, this will not truncate the first character.
                  rightAlign: true,
                  autoUnmask: true,
                  nullable: false,
                });
              }); // end 'currency'
              $.each(tb_penjualan.row(rowId).nodes().to$().find('.digits'), function() {
                $(this).inputmask("currency", {
                  radixPoint: ".",
                  groupSeparator: ".",
                  digits: 0,
                  autoGroup: true,
                  prefix: '', //Space after $, this will not truncate the first character.
                  rightAlign: true,
                  autoUnmask: true,
                  nullable: false,
                });
              }); // end 'digits'
              tb_penjualan.draw(false);
              countTotalReturn(rowId);
            }); // end loop insert DataTable
          } // end if 'KB'
          else if ($('#return_type').val() === 'BR')
          {
            $('#table_penjualan_br').dataTable().fnDestroy();
            tb_penjualan = $('#table_penjualan_br').DataTable();
        		tb_penjualan.clear().draw();
            $.each(response.sales.get_sales_dt, function(key, val) {
              rowId = tb_penjualan.rows().count();
              console.log(val, rowId);
              tb_penjualan.row.add([
                val.get_item.i_name +
                  '<input type="hidden" value="'+ val.sd_item +'" class="barang" name="listItemId[]">',
                '<input type="text" min="0" class="form-control form-control-plaintext digits" name="listQty[]" value="'+ val.sd_qty +'">',
                '<input type="text" min="0" class="form-control form-control-sm digits" name="listReturnQty[]" value="0" onchange="countTotalReturn('+ rowId +')">' ,
                '<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ val.get_item.get_satuan1.s_name +'">' +
                  '<input type="hidden" value="'+ val.get_item.i_sat1 +'" name="listSatId[]">',
                '<input type="text" class="form-control form-control-plaintext form-control-sm currency" name="listPrice[]" value="'+ val.sd_price +'">',
                '<input type="text" min="0" class="form-control form-control-plaintext digits" name="listDiscP[]" value="'+ val.sd_disc_percent +'">' +
                  '<input type="hidden" value="'+ val.sd_disc_vpercent +'" name="listDiscVP[]">',
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listDiscH[]" value="'+ parseInt(val.sd_disc_value) / parseInt(val.sd_qty) +'">',
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listTotalBelanja[]" value="'+ val.sd_total +'">' ,
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listTotalReturn[]" value="'+ 0 +'">' ,
                '<input type="text" min="0" class="form-control form-control-plaintext currency" name="listTotalBrgSesuai[]" value="'+ 0 +'">'
              ]).node().id = rowId;
              $.each(tb_penjualan.row(rowId).nodes().to$().find('.currency'), function() {
                $(this).inputmask("currency", {
                  radixPoint: ".",
                  groupSeparator: ".",
                  digits: 2,
                  autoGroup: true,
                  prefix: '', //Space after $, this will not truncate the first character.
                  rightAlign: true,
                  autoUnmask: true,
                  nullable: false,
                });
              }); // end 'currency'
              $.each(tb_penjualan.row(rowId).nodes().to$().find('.digits'), function() {
                $(this).inputmask("currency", {
                  radixPoint: ".",
                  groupSeparator: ".",
                  digits: 0,
                  autoGroup: true,
                  prefix: '', //Space after $, this will not truncate the first character.
                  rightAlign: true,
                  autoUnmask: true,
                  nullable: false,
                });
              }); // end 'digits'
              tb_penjualan.draw(false);
              countTotalReturn(rowId);
            }); // end loop insert DataTable
          }
        },
        error: function() {
          messageWarning('Error', 'Hubungi pengembang !');
        }
      });
    });

    $('#sales_ppn').on('change', function() {
      if ($(this).val() > 100) {
        $(this).val(100);
      } else if ($(this).val() < 0) {
        $(this).val(0);
      }
      countTotalNet();
    });

    $('#btn_simpan').one('click', function() {
      SubmitForm();
    });
  }); // end document ready

  // count total-gross
  function sumTotalgross()
  {
    rowCount = tb_penjualan.rows().count();
    totalGross = 0;
    for (var i = 0; i < rowCount; i++) {
      itemQty = parseInt(tb_penjualan.cell(i, 1).nodes().to$().find('input').val());
      returnQty = parseInt(tb_penjualan.cell(i, 2).nodes().to$().find('input').val());
      itemPrice = parseInt(tb_penjualan.cell(i, 4).nodes().to$().find('input').val());
      newQty = itemQty - returnQty;
      totalGross += (newQty * itemPrice);
    }
    $('#sales_gross').val(totalGross);
  }

  // count total-NETT
  function countTotalNet()
  {
    totalSesuai = sumTotalSesuai();
    ppn = totalSesuai * $('#sales_ppn').val() / 100;
    net = totalSesuai + ppn;
    $('#sales_total_net').val(net);
  }

  // count total return-price based on qty-return and item-price
  function countTotalReturn(rowId)
  {
    returnQty = parseInt(tb_penjualan.cell(rowId, 2).nodes().to$().find('input').val());
    itemQty = parseInt(tb_penjualan.cell(rowId, 1).nodes().to$().find('input').val());
    totalBelanja = parseInt(tb_penjualan.cell(rowId, 7).nodes().to$().find('input').val());
    // prevent returnQty to get null or NaN value
    if (returnQty > itemQty) {
      returnQty = itemQty;
    } else if (returnQty < 0) {
      returnQty = 0;
    } else if (isNaN(returnQty)) {
      returnQty = 0;
    }

    totalReturn = (totalBelanja / itemQty) * returnQty;

    tb_penjualan.cell(rowId, 2).nodes().to$().find('input').val(returnQty);
    tb_penjualan.cell(rowId, 8).nodes().to$().find('input').val(totalReturn);
    tb_penjualan.draw(false);
    sumTotalReturn();
    countTotalSesuai(rowId);
    countTotalNet();
    sumTotalgross();
  }

  // sum total-return
  function sumTotalReturn()
  {
    rowCount = tb_penjualan.rows().count();
    finalReturn = 0;
    for (let i = 0; i < rowCount; i++) {
      finalReturn += parseInt(tb_penjualan.cell(i, 8).nodes().to$().find('input').val());
    }
    $('#sales_total_return').val(finalReturn);
  }

  // coun total-barang-sesuai based on return-qty
  function countTotalSesuai(rowId)
  {
    totalBelanja = parseInt(tb_penjualan.cell(rowId, 7).nodes().to$().find('input').val());
    totalReturn = parseInt(tb_penjualan.cell(rowId, 8).nodes().to$().find('input').val());

    totalPriceSesuai = totalBelanja - totalReturn;

    tb_penjualan.cell(rowId, 9).nodes().to$().find('input').val(totalPriceSesuai);
    tb_penjualan.draw(false);
  }

  // sum total-barang-sesuai, return totalSesuai
  function sumTotalSesuai()
  {
    rowCount = tb_penjualan.rows().count();
    totalSesuai = 0;
    for (let i = 0; i < rowCount; i++) {
      totalSesuai += parseInt(tb_penjualan.cell(i, 9).nodes().to$().find('input').val());
    }
    return totalSesuai;
  }

  // check is return-qty === 0
  function isReturn()
  {
    rowCount = tb_penjualan.rows().count();
    for (let i = 0; i < rowCount; i++) {
      if (parseInt(tb_penjualan.cell(i, 2).nodes().to$().find('input').val()) !== 0) {
        return true;
      };
    }
    return false;
  }

  // store-data -> submit form to store data in db
  function SubmitForm()
  {
    // if isReturn == false, then don't submit the form
    if (tb_penjualan) {
      if (isReturn() === false) {
        $('#btn_simpan').one('click', function() {
          SubmitForm();
        });
        messageWarning('Perhatian', 'Jumlah return masih kosong, proses tidak dilanjutkan !');
        return 0;
      }
    } else {
      $('#btn_simpan').one('click', function() {
        SubmitForm();
      });
      messageWarning('Perhatian', 'Jumlah return masih kosong, proses tidak dilanjutkan !');
      return 0;
    }

    upperForm = $('#upperForm').serialize();
    middleForm = $('#middleForm').serialize();
    bottomForm = $('#bottomForm').serialize();

    let listItems = $();
    for (let i = 0; i < tb_penjualan.rows()[0].length; i++) {
      listItems = listItems.add(tb_penjualan.row(i).node());
    }
    let dataListItems = listItems.find('input').serialize();

    data_final = upperForm +'&'+ middleForm +'&'+ bottomForm +'&'+ dataListItems;

    $.ajax({
      data : data_final,
      type : "post",
      url : baseUrl + '/penjualan/returnpenjualan/store',
      dataType : 'json',
      success : function (response){
        if(response.status == 'berhasil'){
          messageSuccess('Berhasil', 'Data return berhasil disimpan !');
          resetAllInput(0);
          $('#return_method').focus();
          $('#return_method').select2('open');
          $('#btn_simpan').one('click', function() {
            SubmitForm();
          });
        } else if (response.status == 'invalid') {
          messageFailed('Perhatian', response.message);
        } else if (response.status == 'gagal') {
          messageWarning('Error', response.message);
        }
      },
      error : function(e){
        messageWarning('Gagal', 'Data gagal disimpan, hubungi pengembang !');
        // resetAllInput(0);
        // $('#return_method').focus();
        // $('#return_method').select2('open');
      }
    })
  }

  // reset all input-field, int x
  function resetAllInput(x)
  {
    // clear upperForm if reset-All
    if (x == 0) {
      $('#upperForm')[0].reset();
      $('#return_type').find('option').remove();
    }
    $('#middleForm')[0].reset();
    $('#bottomForm')[0].reset();
    // clear tb_penjualan if exist
    if (tb_penjualan) {
      tb_penjualan.clear().draw();
    }
    $('#sales_note').val(0);
    $('#sales_note').attr('disabled', true);
  }

</script>
@endsection
