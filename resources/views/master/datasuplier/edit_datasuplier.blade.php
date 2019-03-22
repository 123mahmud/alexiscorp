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
                     @foreach($data['supplier'] as $supplier)
                     <section>
                        
                        <div id="sectionsuplier" class="row">
                           
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Kode Supplier </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control" value="{{$supplier->s_code}}" name="kodesupplier" readonly="">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Nama Suplier<font color="red">*</font></label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="s_company" value="{{$supplier->s_company}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> NPWP </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm npwp" name="s_npwp" value="{{$supplier->s_npwp}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Hp1</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm 2" name="s_phone1" value="{{$supplier->s_phone1}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Hp2</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm 2" name="s_phone2" value="{{$supplier->s_phone2}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Fax</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="number" class="form-control form-control-sm" name="fax" value="{{$supplier->s_fax}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Email</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="s_email" value="{{$supplier->s_email}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Alamat</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="s_address" value="{{$supplier->s_address}}">
                              </div>
                           </div>
                           
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Bank </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="s_bank" value="{{$supplier->s_bank}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Rekening </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm" name="s_rekening" value="{{$supplier->s_rekening}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Limit </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="text" class="form-control form-control-sm limit currency text-right" name="s_limit" value="{{$supplier->s_limit}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label> Batas Top </label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <input type="number" class="form-control form-control-sm text-right" name="top" value="{{$supplier->s_top}}">
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Keterangan</label>
                           </div>
                           <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                 <textarea class="form-control form-control-sm" name="s_note"> {{$supplier->s_note}}</textarea>
                              </div>
                           </div>
                           @endforeach
                           <div class="table-responsive mt-3">
                              <table class="table table-hover table-striped table-bordered" id="table_rencana">
                                 <thead class="bg-primary">
                                    <tr align="center">
                                       <th width="2%" rowspan="2">No</th>
                                       <th width="68%" colspan="3">Plat Nomer Kendaraan</th>
                                       <th width="10%" rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                       <th colspan="3"> Nopol </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($data['kendaraan'] as $index=>$kendaraan)
                                    <tr>
                                       <td> {{$index + 1}} </td>
                                       
                                       <td colspan="3"> <input type="text" class="form-control-sm form-control" readonly="" name="nopol[]" value="{{$kendaraan->k_nopol}}"> </td>
                                       
                                       <td align="center"><button class="btn btn-primary btn-tambah" type="button"><i class="fa fa-plus"></i></button></td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                           
                        </section>
                     </div>
                     <div class="card-footer text-right">
                        <button class="btn btn-primary button-simpan" id="btn-submit" type="button" onclick="update('{{ Crypt::encrypt($supplier->s_id) }}')">Update</button>
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

      $(this).maskFunc();

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
             '<td colspan="3"><input type="text" class="form-control form-control-sm nopol" name="nopol[]" style="text-transform: uppercase"></td>'+
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
         url: baseUrl + "/master/datasuplier/update",
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