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
               <form id="formdata">
                  <div class="card-block">
                     <section>
                        <div class="row">
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Nama Customer<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="c_name" value="">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>E-mail</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="c_email" value="">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Tanggal Lahir</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm datepicker" name="c_birthday" value="">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>No HP 1<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm hp" name="c_hp1" value="">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>No HP 2</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm hp" name="c_hp2" value="">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Type Customer</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <select class="form-control form-control-sm" id="type_cus" name="c_type">
                                    <option value="KT">Kontraktor</option>
                                    <option value="HR">Harian</option>

                                 </select>
                              </div>
                           </div>

                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Jatuh Tempo</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="number" class="form-control form-control-sm text-right" name="c_jatuh_tempo" value="">
                              </div>
                           </div>

                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Pagu</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm text-right currency" name="c_pagu" value="">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Alamat</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <textarea class="form-control" name="c_address" cols="30" rows="3"></textarea>
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
<<<<<<< HEAD
                                <tr>
                                  <td align="center">#</td>
                                  <td><input type="text" class="form-control form-control-sm in-nopol" id="nomor_polisi" name="nopol[]" tabindex="10"></td>
                                  <td align="center">
                                    <button class="btn btn-primary" id="btn-tambah" type="button"><i class="fa fa-plus-square" tabindex="11"></i></button>
                                  </td>
                                </tr>
=======
                                 <tr>
                                    <td align="center">#</td>
                                    <td><input type="text" class="form-control form-control-sm" id="nomor_polisi" name="nopol[]" tabindex="10"></td>
                                    <td align="center">
                                       <button class="btn btn-primary" id="btn-tambah" type="button"><i class="fa fa-plus-square" tabindex="11"></i></button>
                                    </td>
                                 </tr>
>>>>>>> c487134e3c7f9ad1be996d4b1295d3e0abd56f6d
                              </tbody>
                           </table>
                        </div>
                     </section>
                  </div>
                  <div class="card-footer text-right">
                     <button class="btn btn-primary button-simpan" id="btn_simpan" type="button" tabindex="12" onclick="simpan()">Simpan</button>
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
      if($(this).val() === 'KONTRAK'){
        $('#label_type_cus').text('Jatuh tempo');
        $('#jumlah_hari_bulan').val('');
        $('#pagu').val('');
        $('#armada').prop('selectedIndex', 0).trigger('change');
        $('.120mm').removeClass('d-none');
        $('.125mm').addClass('d-none');
        $('.122mm').removeClass('d-none');
      } else if($(this).val() === 'HARIAN'){
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

    $('#tabel_nopol tbody').on('click', '.btn-hapus', function(){
      $(this).parents('tr').remove();
    });

    $('#btn-tambah').on('click',function(){
      $('#tabel_nopol tbody')
      .append(
        '<tr>'+
          '<td align="center">#</td>'+
          '<td><input type="text" class="form-control form-control-sm in-nopol" name="nopol[]"></td>'+
          '<td align="center"><button class="btn btn-danger btn-hapus" type="button"><i class="fa fa-trash-o"></i></button></td>'+
        '</tr>'
        );
      setNopolMask();
    });

<<<<<<< HEAD
    $('#btn_simpan').one('click', function() {
      SubmitForm(event);
    });

    $('.input-hp').inputmask('9999 9999 9999');
    setNopolMask();
  });

  function setNopolMask()
  {
    $('.in-nopol').inputmask('AA 9999 AAA');
  }

  // submit form to store data in db
  function SubmitForm(event)
  {
    event.preventDefault();
    form_data = $('#myForm').serialize();
=======
  });

>>>>>>> c487134e3c7f9ad1be996d4b1295d3e0abd56f6d


   function simpan()
   {
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      $('.button-simpan').attr('disabled', 'disabled');
      $.ajax({
         url: baseUrl + "/master/datacustomer/save",
         type: 'GET',
         data: $('#formdata').serialize(),
         success: function (response) {
             if (response.status == 'sukses') {
                 $.toast({
                     heading: response.code,
                     text: 'Berhasil di Simpan',
                     bgColor: '#00b894',
                     textColor: 'white',
                     loaderBg: '#55efc4',
                     icon: 'success'
                  });
                 window.location.href = baseUrl + "/master/datacustomer/index";
             } else {
                  $.toast({
                      heading: 'Ada yang salah',
                      text: 'Periksa data anda.',
                      showHideTransition: 'plain',
                      icon: 'warning'
                  })
                 $('.button-simpan').removeAttr('disabled', 'disabled');
             }
         }
      })
   }

</script>
@endsection
