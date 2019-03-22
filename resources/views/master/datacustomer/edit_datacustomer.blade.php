@extends('main')
@section('content')
<article class="content">
   <div class="title-block text-primary">
      <h1 class="title"> Edit Data Customer </h1>
      <p class="title-description">
         <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
         / <span>Master Data</span>
         / <a href="{{route('datacustomer')}}"><span>Data Customer</span></a>
         / <span class="text-primary" style="font-weight: bold;">Edit Data Customer</span>
      </p>
   </div>
   <section class="section">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header bordered p-2">
                  <div class="header-block">
                     <h3 class="title"> Edit Data Customer </h3>
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
                              <label>Kode Customer<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" readonly="" name="c_code" value="{{ $customer->c_code }}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Nama Customer<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="c_name" value="{{ $customer->c_name }}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>E-mail</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="c_email" value="{{ $customer->c_email }}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Tanggal Lahir</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm datepicker" name="c_birthday" value="{{ date('d-m-Y', strtotime($customer->c_birthday)) }}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>No HP 1<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm hp" name="c_hp1" value="{{ $customer->c_hp1 }}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>No HP 2</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm hp" name="c_hp2" value="{{ $customer->c_hp2 }}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Type Customer</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <select class="form-control form-control-sm" id="type_cus" name="c_type">
                                    @if ($customer->c_type == 'KT')
                                    <option value="KT" selected="">Kontraktor</option>
                                    <option value="HR">Harian</option>
                                    @else
                                    <option value="HR" selected="">Harian</option>
                                    <option value="KT">Kontraktor</option>
                                    @endif
                                 </select>
                              </div>
                           </div>

                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Jatuh Tempo</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="number" class="form-control form-control-sm text-right" name="c_jatuh_tempo" value="{{ $customer->c_jatuh_tempo }}">
                              </div>
                           </div>

                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Pagu</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm text-right currency" name="c_pagu" value="{{ $customer->c_pagu }}">
                              </div>
                           </div>

                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Alamat</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <textarea class="form-control" name="c_address" cols="30" rows="3">{{ $customer->c_address }}</textarea>
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
                                    <td><input type="text" class="form-control form-control-sm" id="nomor_polisi" name="nopol[]" tabindex="10"></td>
                                    <td align="center">
                                       <button class="btn btn-primary" id="btn-tambah" type="button"><i class="fa fa-plus-square" tabindex="11"></i></button>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>

                     </section>
                  </div>
                  <div class="card-footer text-right">
                     <button class="btn btn-primary" id="btn_simpan" type="button" onclick="update('{{ Crypt::encrypt($customer->c_id) }}')">Simpan</button>
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
   });

   function update(id)
   {
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      $('.button-simpan').attr('disabled', 'disabled');
      $.ajax({
         url: baseUrl + "/master/datacustomer/update",
         type: 'GET',
         data: $('#formdata').serialize() + '&id=' + id,
         success: function (response,) {
             if (response.status == 'sukses') {
                 $.toast({
                     heading: '',
                     text: 'Berhasil di update',
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
