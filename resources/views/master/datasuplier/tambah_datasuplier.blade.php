@extends('main')

@section('content')

<article class="content">
   <div class="title-block text-primary">
      <h1 class="title"> Tambah Data Suplier </h1>
      <p class="title-description">
         <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
         / <span>Master Data</span>
         / <a href="{{route('datacustomer')}}"><span>Data Suplier</span></a>
         / <span class="text-primary" style="font-weight: bold;"> Tambah Data Suplier</span>
      </p>
   </div>
   <form id="formdata">
      <section class="section">
         <div class="row">
            <div class="col-12">
               
               <div class="card">
                  <div class="card-header bordered p-2">
                     <div class="header-block">
                        <h3 class="title"> Tambah Data Suplier </h3>
                     </div>
                     <div class="header-block pull-right">
                        <a href="{{route('datasuplier')}}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a>
                     </div>
                  </div>
                  <div class="card-block">
                     <section>
                        
                        <div id="sectionsuplier" class="row">
                           
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Company<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="namasupplier">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> NPWP </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm npwp" name="npwp">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Hp1<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm hp" name="nmr_hp1">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Hp2</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm hp" name="nmr_hp2">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Fax</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="fax">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Email</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="email">
                                 <input type="hidden" class="form-control form-control-sm" name="username" value="Ana">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Alamat</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="alamat">
                              </div>
                           </div>
                           
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Bank </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="namabank">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Rekening </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="rekening">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Limit </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm currency text-right" name="limit">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Batas Top </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="number" class="form-control form-control-sm text-right" name="top">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Keterangan</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <textarea class="form-control form-control-sm" name="keterangan"></textarea>
                              </div>
                           </div>
                           <div class="table-responsive mt-3 col-sm-6 text-center" >
                              <table class="table table-hover table-striped table-bordered" id="table_rencana">
                                 <thead class="bg-primary">
                                    <tr align="center">
                                       <th width="2%" rowspan="2">No</th>
                                       <th width="68%" colspan="3">Plat Nomer Kendaraan</th>
                                       <th width="10%" rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                       <th colspan="3" class="text-center">Nopol</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td align="center">#</td>
                                       <td colspan="3"> <input type="text" class="form-control form-control-sm nopol" name="wilayah[]" value="L" style="text-transform: uppercase"></td>
                                       <td align="center"><button class="btn btn-primary btn-tambah" type="button"><i class="fa fa-plus"></i></button></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           
                        </section>
                     </div>
                     <div class="card-footer text-right">
                        <button class="btn btn-primary button-simpan" id="btn-submit" type="button" onclick="simpan()">Simpan</button>
                        <a href="{{route('datasuplier')}}" class="btn btn-secondary">Kembali</a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </form>
   </article>
   @endsection

@section('extra_script')
<script type="text/javascript">
   $(document).ready(function(){

      $(".npwp").inputmask("99-999-999-9-999-999");

      $('.hp').inputmask("9999 9999 9999");

      $('#type_cus').change(function(){
         if($(this).val() === 'kontrak'){
           $('#label_type_cus').text('Jumlah Bulan');
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

    $(document).on('click', '.btn-hapus', function(){
      $(this).parents('tr').remove();
    });

    $('.btn-tambah').on('click',function(){
      $('#table_rencana tbody')
      .append(
        '<tr>'+
          '<td align="center">#</td>'+
          '<td colspan="3"><input type="text" class="form-control form-control-sm nopol" name="wilayah[]" style="text-transform: uppercase"></td>'+
          '<td align="center"><button class="btn btn-danger btn-hapus" type="button"><i class="fa fa-trash-o"></i></button></td>'+
        '</tr>'
        );
    });

   //mask money
    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
        radixPoint: ".",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }

    $(this).maskFunc();

   });


   function simpan()
   {
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      $('.button-simpan').attr('disabled', 'disabled');
      $.ajax({
         url: baseUrl + "/master/datasuplier/save",
         type: 'GET',
         data: $('#formdata').serialize(),
         success: function (response,) {
             if (response.status == 'sukses') {
                 $.toast({
                     heading: response.code,
                     text: 'Berhasil di Simpan',
                     bgColor: '#00b894',
                     textColor: 'white',
                     loaderBg: '#55efc4',
                     icon: 'success'
                  });
                 window.location.href = baseUrl + "/master/datasuplier/index";
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