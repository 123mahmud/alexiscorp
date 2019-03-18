@extends('main')

@section('content')

<article class="content">

  <div class="title-block text-primary">
      <h1 class="title"> Tambah Data Customer </h1>
      <p class="title-description">
        <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
         / <span>Master Data</span>
         / <a href="{{route('datacustomer')}}"><span>Data Customer</span></a>
         / <span class="text-primary" style="font-weight: bold;"> Tambah Data Customer</span>
       </p>
  </div>

  <section class="section">

    <div class="row">

      <div class="col-12">

        <div class="card">

                    <div class="card-header bordered p-2">
                      <div class="header-block">
                        <h3 class="title"> Tambah Data Customer </h3>
                      </div>
                      <div class="header-block pull-right">
                        <a href="{{route('datacustomer')}}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a>
                      </div>
                    </div>
                    <form id="myForm" action="{{ route('save_datacustomer') }}" method="post" autocomplete="off">
                      <div class="card-block">
                        <section>

                          <div class="row">

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Nama Customer</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="name" tabindex="1">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>E-mail</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="email" tabindex="2">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>No HP 1</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="number" class="form-control form-control-sm" name="telp1" tabindex="3">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>No HP 2</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="number" class="form-control form-control-sm" name="telp2" tabindex="4">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Type Customer</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <select class="form-control form-control-sm" id="type_cus" name="type" tabindex="5">
                                  <option value="" disabled selected>-Pilih-</option>
                                  <option value="kontrak">Kontraktor</option>
                                  <option value="harian">Harian</option>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-offset-9 col-md-3 col-sm-6 col-xs-12 d-none 120mm">
                              <label id="label_type_cus"></label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 d-none 120mm">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" min="1" id="jumlah_hari_bulan" name="jumlah_hari_bulan" tabindex="6">
                              </div>
                            </div>

                            <div class="col-md-offset-9 col-md-3 col-sm-6 col-xs-12 d-none 122mm">
                              <label>Pagu</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 d-none 122mm">
                              <div class="form-group">
                                <input type="text" style="text-align: right;"class="form-control form-control-sm  input-rupiah" id="pagu" name="pagu" tabindex="7">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12 d-none 125mm">
                              <label>Armada</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 d-none 125mm">
                              <div class="form-group">
                                <select class="form-control form-control-sm select2" id="armada" tabindex="8">
                                  <option value="">--Pilih--</option>
                                </select>
                              </div>
                            </div>

                          </div>
                          <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Alamat</label>
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <textarea class="form-control" name="address" id="" cols="30" rows="3" tabindex="9"></textarea>
                              </div>
                            </div>

                          </div>

                          <div class="table-responsive col-sm-6">
                            <table class="table table-bordered table-striped table-hover" id="tabel_nopol" cellspacing="0">

                              <thead class="bg-primary">
                                <tr>
                                  <th rowspan="2" align="center" valign="middle">No</th>
                                  <th>Plat Nomor Kendaraan</th>
                                  <th rowspan="2" align="center" valign="middle">Aksi</th>
                                </tr>
                                <tr>
                                  <th>Nomor Polisi</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td align="center">#</td>
                                  <td><input type="text" class="form-control form-control-sm" id="nomor_polisi" name="nopol[]"></td>
                                  <td align="center">
                                    <button class="btn btn-primary" id="btn-tambah" type="button"><i class="fa fa-plus-square"></i></button>
                                  </td>
                                </tr>
                              </tbody>

                            </table>

                          </div>

                        </section>
                      </div>
                      <div class="card-footer text-right">
                        <button class="btn btn-primary" id="btn_simpan" type="button">Simpan</button>
                        <a href="{{route('datacustomer')}}" class="btn btn-secondary">Kembali</a>
                      </div>
                  </form>
                </div>

      </div>

    </div>

  </section>

</article>

@endsection

@section('extra_script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#type_cus').on('change', function(){
      if($(this).val() === 'kontrak'){
        $('#label_type_cus').text('Jatuh tempo');
        $('#jumlah_hari_bulan').val('');
        $('#pagu').val('');
        $('#armada').prop('selectedIndex', 0).trigger('change');
        $('.120mm').removeClass('d-none');
        $('.125mm').addClass('d-none');
        $('.122mm').removeClass('d-none');
      } else if($(this).val() === 'harian'){
        $('#label_type_cus').text('Jumlah Hari');
        $('#armada').prop('selectedIndex', 0).trigger('change');
        $('#pagu').val('');
        $('#jumlah_hari_bulan').val('');
        $('.122mm').addClass('d-none');
        $('.120mm').removeClass('d-none');
        $('.125mm').removeClass('d-none');
      } else {
        $('#jumlah_hari_bulan').val('');
        $('#armada').prop('selectedIndex', 0).trigger('change');
        $('#pagu').val('');
        $('.122mm').addClass('d-none');
        $('.120mm').addClass('d-none');
        $('.125mm').addClass('d-none');
      }
    });

    $( '#xxx_simpan' ).on('click', function(){
			$.toast({
				heading: 'Success',
				text: 'Data Berhasil di Simpan',
				bgColor: '#00b894',
				textColor: 'white',
				loaderBg: '#55efc4',
				icon: 'success'
			});

      $.confirm({
        animation: 'RotateY',
        closeAnimation: 'scale',
        animationBounce: 1.5,
        icon: 'fa fa-question-circle',
        title: 'Pilih',
        content: 'Pilih Pindah Halaman',
        theme: 'dark',
        columnClass:'col-md-6 col-sm-12 col-12',
          buttons: {
              cutomer: {
                btnClass: 'btn-blue',
                text:'Data Customer',
                action : function(){
                  window.location.href = '{{route('datacustomer')}}';
                }
              },
              armada:{
                text: 'Data Armada',
                btnClass: 'btn-info',
                action: function(){
                  window.location.href = '{{route('dataarmada')}}';
                }
              },
              tetap: {
                text:'Tetap dihalaman',
                btnClass:'btn-default',
                action: function(){
                  location.reload();
                }
              }
        },
        backgroundDismiss: function(){
            location.reload();
        }
      });

		});

    $('#tabel_nopol tbody').on('click', '.btn-hapus', function(){
      $(this).parents('tr').remove();
    });

    $('#btn-tambah').on('click',function(){
      $('#tabel_nopol tbody')
      .append(
        '<tr>'+
          '<td align="center">#</td>'+
          '<td><input type="text" class="form-control form-control-sm" name="nopol[]"></td>'+
          '<td align="center"><button class="btn btn-danger btn-hapus" type="button"><i class="fa fa-trash-o"></i></button></td>'+
        '</tr>'
        );
    });

    $('#btn_simpan').on('click', function() {
      SubmitForm(event);
    });
  });

  // submit form to store data in db
  function SubmitForm(event)
  {
    event.preventDefault();
    form_data = $('#myForm').serialize();

    $.ajax({
      data: form_data,
      type: "post",
      url: $("#myForm").attr('action'),
      dataType: 'json',
      success: function(response) {
        if (response.status == 'berhasil') {
          messageSuccess('Berhasil', 'Data berhasil ditambahkan !');
          // changePage();
        } else if (response.status == 'invalid') {
          messageFailed('Perhatian', response.message);
        } else if (response.status == 'gagal') {
          messageWarning('Error', response.message);
        }
      },
      error: function(e) {
        messageWarning('Gagal', 'Data gagal ditambahkan, hubungi pengembang !');
      }
    });
  }

  function changePage()
  {
    $.confirm({
      animation: 'RotateY',
      closeAnimation: 'scale',
      animationBounce: 1.5,
      icon: 'fa fa-question-circle',
      title: 'Pilih',
      content: 'Pilih Pindah Halaman',
      theme: 'dark',
      columnClass:'col-md-6 col-sm-12 col-12',
        buttons: {
            cutomer: {
              btnClass: 'btn-blue',
              text:'Data Customer',
              action : function(){
                window.location.href = "{{route('datacustomer')}}";
              }
            },
            armada:{
              text: 'Data Armada',
              btnClass: 'btn-info',
              action: function(){
                window.location.href = "{{route('dataarmada')}}";
              }
            },
            tetap: {
              text:'Tetap dihalaman',
              btnClass:'btn-default',
              action: function(){
                location.reload();
              }
            }
      },
      backgroundDismiss: function(){
          location.reload();
      }
    });
  }
</script>
@endsection
