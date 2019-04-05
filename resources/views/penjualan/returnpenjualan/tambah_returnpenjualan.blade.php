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
                          </div>

                          <!--  fieldset (inside box upside) -->
                          <fieldset>
                            <div class="row">

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Nota Penjualan</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control form-control-sm select2" id="sales_note" name="sales_note">
                                    <option value="" disabled selected>- Cari Nota -</option>
                                    @foreach($data['sales'] as $sales)
                                    <option value="{{ $sales->s_id }}">{{ $sales->s_note }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Jenis Return</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control form-control-sm select2" id="return_type">
                                    <option value="" disabled>- Pilih Jenis Return -</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Tanggal Return</label>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="">
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

                          <!-- below fieldset -->
                          <div class="row mt-3">

                            <div class="col-md-3 col-sm-12">
                              <label>Detail Pelanggan</label>
                            </div>
                            <div class="col-md-9 col-sm-12">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" readonly="" id="cust_detail" name="">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Return</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control-sm form-control" readonly="" id="sales_return" name="">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>S Gross</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control-sm form-control" readonly="" id="sales_gross" name="">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Total Diskon</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control-sm form-control" readonly="" id="sales_totaldisc" name="">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Total Penjualan (NETT)</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control-sm form-control" readonly="" id="sales_totalnet" name="">
                              </div>
                            </div>

                          </div>


                          <div id="jumlah_salah" class="d-none">
                            <div class="table-responsive mt-3">
                              <table class="table table-hover table-striped" cellspacing="0">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Kirim</th>
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

                          <div id="barang_rusak" class="d-none">
                            <div class="table-responsive mt-3">
                              <table class="table table-hover table-striped" cellspacing="0">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Rusak</th>
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
                      <button class="btn btn-primary" type="button">Simpan</button>
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

  $(document).ready(function(){
    $('#sales_note').attr('disabled', true);

    $('#return_method').on('change', function(){
      $('#sales_note').attr('disabled', false);
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

      // if ($(this).val() === 'BR') {
      //   $('#barang_rusak').removeClass('d-none');
      //   $('#jumlah_salah').addClass('d-none');
      //   $('#kembali_uang').addClass('d-none');
      // } else if($(this).val() === 'JS'){
      //   $('#barang_rusak').addClass('d-none');
      //   $('#jumlah_salah').removeClass('d-none');
      //   $('#kembali_uang').addClass('d-none');
      // } else if($(this).val() === 'KU'){
      //   $('#barang_rusak').addClass('d-none');
      //   $('#jumlah_salah').addClass('d-none');
      //   $('#kembali_uang').removeClass('d-none');
      // } else {
      //   $('#barang_rusak').addClass('d-none');
      //   $('#jumlah_salah').addClass('d-none');
      //   $('#kembali_uang').addClass('d-none');
      // }
    });

    $('#sales_note').on('change', function() {
      $.ajax({
        url: "{{ route('returnpenjualan.getsales') }}",
        type: 'get',
        data: {
          'id_sales': $('#sales_note').val()
        },
        success: function() {

        },
        error: function() {

        }
      });
    });

    $('#return_type').on('change', function() {
      if ($(this).val() === 'BR') {
        $('#barang_rusak').removeClass('d-none');
        $('#jumlah_salah').addClass('d-none');
      } else if ($(this).val() === 'KB') {
        $('#barang_rusak').addClass('d-none');
        $('#jumlah_salah').removeClass('d-none');
      }
    });

  });
</script>
@endsection
