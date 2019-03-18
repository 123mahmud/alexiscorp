@extends('main')

@section('content')


<article class="content">

  <div class="title-block text-primary">
      <h1 class="title"> Edit Data Barang </h1>
      <p class="title-description">
        <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
         / <span>Master Data</span>
         / <a href="{{route('databarang')}}"><span>Data Barang</span></a>
         / <span class="text-primary" style="font-weight: bold;">Edit Data Barang</span>
       </p>
  </div>
<form id="formsukses">
  <section class="section">

    <div class="row">

      <div class="col-12">

        <div class="card">
                    <div class="card-header bordered p-2">
                      <div class="header-block">
                        <h3 class="title">Edit Data Barang </h3>
                      </div>
                      <div class="header-block pull-right">
                        <a href="{{route('databarang')}}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a>
                      </div>
                    </div>
                    <div class="card-block">
                        <section>
                          @foreach($data['barang'] as $barang)
                          <div class="row">

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Nama Barang</label>
                            </div>

                            <div class="col-md-9 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" name="nama_barang" value="{{$barang->i_name}}" required="">
                                 <input type="hidden" class="form-control form-control-sm" name="id_barang" value="{{$barang->i_id}}">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Type Barang</label>
                            </div>

                            <div class="col-md-9 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <select class="form-control form-control-sm tipe_barang" name="tipe_barang" required="">
                                  <option value="" disabled="">--Pilih Type Barang--</option>
                                  @if($barang->i_type = 'BB')
                                    <option value="BB" selected="">Bahan Baku</option>
                                      <!-- <option value="BP">Bahan Produksi</option>
                                    <option value="SP">Spare Part</option>
                                    <option value="BJ">Barang Jual</option>
                                    <option value="LL">Lain-lain</option> -->
                                  @elseif($barang->i_type = 'SP')
                                    <!-- <option value="BB">Bahan Baku</option>
                                      <option value="BP">Bahan Produksi</option> -->
                                    <option value="SP" selected="">Spare Part</option>
                                    <!-- <option value="BJ">Barang Jual</option>
                                     <option value="LL">Lain-lain</option> -->
                                  @elseif($barang->i_type = 'BJ')
                                    <!-- <option value="BB">Bahan Baku</option>
                                      <option value="BP">Bahan Produksi</option>
                                    <option value="SP">Spare Part</option> -->
                                    <option value="BJ" selected="">Barang Jual</option>
                                     <!-- <option value="LL">Lain-lain</option> -->
                                  @elseif($barang->i_type = 'LL')
                                       <!-- <option value="BB">Bahan Baku</option>
                                         <option value="BP">Bahan Produksi</option>
                                    <option value="SP">Spare Part</option>
                                    <option value="BJ">Barang Jual</option> -->
                                     <option value="LL" selected="">Lain-lain</option>
                                  @elseif($barang->i_type = 'BP')
                                     <!-- <option value="BB">Bahan Baku</option> -->
                                      <option value="BP" selected="">Bahan Produksi</option>
                                    <!-- <option value="SP">Spare Part</option>
                                    <option value="BJ">Barang Jual</option>
                                     <option value="LL">Lain-lain</option> -->


                                  @endif


                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Kelompok Barang</label>
                            </div>

                            <div class="col-md-9 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="hidden" id="group_hidden" value="{{ $barang->i_code_group }}">
                                <select class="form-control form-control-sm" name="kelompok_barang" id="group" required="">
                                  @foreach($data['group'] as $group)
                                    <option value="{{ $group->m_gcode }}">{{ $group->m_gname }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Kode Barang</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm kode_barang" readonly="" name="kode_barang" value="{{$barang->i_code}}" required="">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Min Stock</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="number" class="form-control form-control-sm" name="min_stock" value="{{$barang->i_min_stock}}" required="">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Satuan Utama</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <select class="form-control form-control-sm satuan_utama" name="satuan_utama" required="">
                                  <option value="">--Pilih--</option>
                                   @foreach($data['satuan'] as $satuan)
                                    <option value="{{$satuan->s_id}}" @if($barang->i_sat1 == $satuan->s_id) selected="" @endif> {{$satuan->s_name}} </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Isi Satuan Utama</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                               <input type="number" class="form-control-sm form-control isi_satuan_utama"  step="0.1" name="isi_satuan_utama" value="{{$barang->i_sat_isi1}}" required="" readonly="" value="1">
                                <input type="hidden" class="form-control-sm form-control"  value="1" name="username">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Satuan Alternatif 1</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <select class="form-control form-control-sm satuan_1" name="satuan_1">
                                  <option value="">--Pilih--</option>
                                   @foreach($data['satuan'] as $satuan)
                                    <option value="{{$satuan->s_id}}" @if($barang->i_sat2 == $satuan->s_id) selected="" @endif> {{$satuan->s_name}} </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Isi Satuan Alternatif 1</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                               <input type="number" class="form-control-sm form-control isi_satuan_1" min="0" name="isi_satuan_1" value="{{$barang->i_sat_isi2}}">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Satuan Alternatif 2</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <select class="form-control form-control-sm satuan_2" name="satuan_2">
                                  <option value="">--Pilih--</option>
                                  @foreach($data['satuan'] as $satuan)
                                    <option value="{{$satuan->s_id}}" @if($barang->i_sat3 == $satuan->s_id) selected="" @endif> {{$satuan->s_name}} </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Isi Satuan Alternatif 2</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                               <input type="number" class="form-control-sm form-control isi_satuan_2" min="0" name="isi_satuan_2" value="{{$barang->i_sat_isi3}}">
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Detail</label>
                            </div>

                            <div class="col-md-9 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <textarea class="form-control" name="detail" required=""> {{$barang->i_det}}</textarea>
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <label>Persentase Produksi Rusak</label>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <div class="input-group">
                                  <input type="number" class="form-control-sm form-control persentase" max="100" min="0" name="persentase" value="{{$barang->i_persentase}}" required="">
                                  <span class="input-group-addon">
                                    %
                                  </span>
                                </div>
                              </div>
                            </div>



                          </div>
                          @endforeach
                        </section>
                    </div>

                    <div class="card-footer text-right">
                      <button class="btn btn-primary btn-submit" type="button">Simpan</button>
                      <a href="{{route('databarang')}}" class="btn btn-secondary">Kembali</a>
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

   function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? ',' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
    }

  $('.isi_satuan_1').change(function(){
    isi_satuan_1 = $(this).val();
    satuan_1 = $('.satuan_1').val();
    harga = $('.harga_satuan_utama').val();
    if(satuan_1 == ''){
       $.toast({
              heading: 'Warning',
              text: 'Satuan Alternatif 1 Tidak di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
         $(this).val('');
    }
    else {
      if(harga != ''){
        if(isi_satuan_1 != ''){
                 harga = harga.replace(/\./g,'');
                 harga = harga.replace(/,/g,'.');

                 hasilharga2 = parseFloat(parseFloat(isi_satuan_1) * parseFloat(harga)).toFixed(2);

                $('.harga_satuan_1').val(addCommas(hasilharga2));
          }
          else {
            $('.harga_satuan_1').val('');
          }
      }
    }
  });


   $('.isi_satuan_2').change(function(){
    isi_satuan_1 = $(this).val();
    satuan_1 = $('.satuan_2').val();
    harga = $('.harga_satuan_utama').val();
    if(satuan_1 == ''){
       $.toast({
              heading: 'Warning',
              text: 'Satuan Alternatif 2 Tidak di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
         $(this).val('');
    }
    else {
      if(harga != ''){
         if(isi_satuan_1 != ''){
              harga = harga.replace(/\./g,'');
             harga = harga.replace(/,/g,'.');

             hasilharga2 = parseFloat(parseFloat(isi_satuan_1) * parseFloat(harga)).toFixed(2);

            $('.harga_satuan_2').val(addCommas(hasilharga2));
         }
         else {
          $('.harga_satuan_2').val('');
         }
      }
    }
  });
   $('.harga_satuan_utama').change(function(){
    satuan_1 = $('.satuan_1').val();
    harga = $(this).val();
    harga = harga.replace(/\./g,'');
    harga = harga.replace(/,/g,'.');
    if(satuan_1 != ''){
      isi_satuan_1 = $('.isi_satuan_1').val();


       hasilharga = parseFloat(parseFloat(isi_satuan_1) * parseFloat(harga));
       $('.harga_satuan_1').val(hasilharga);
    }

      satuan_2 = $('.satuan_2').val();
    if(satuan_2 != ''){
      isi_satuan_2 = $('.isi_satuan_2').val();
      if(isi_satuan_2 != ''){
          hasilharga2 = parseFloat(parseFloat(isi_satuan_2) * parseFloat(harga)).toFixed(2);

        $('.harga_satuan_2').val(addCommas(hasilharga2));
      }
    }
   });

   $('.harga_satuan_1').change(function(){
      isi_satuan_1 = $(this).val();
      satuan_1 = $('.satuan_1').val();
      if(satuan_1 == ''){
         $.toast({
                heading: 'Warning',
                text: 'Satuan Alternatif 1 Tidak di isi :)',
                showHideTransition: 'plain',
                icon: 'warning'
            });
           $(this).val('');
      }
   });

   $('.harga_satuan_2').change(function(){
      isi_satuan_1 = $(this).val();
      satuan_1 = $('.satuan_2').val();
      if(satuan_1 == ''){
         $.toast({
                heading: 'Warning',
                text: 'Satuan Alternatif 2 Tidak di isi :)',
                showHideTransition: 'plain',
                icon: 'warning'
            });
           $(this).val('');
      }
   });

  $('.tipe_barang').change(function(){
    tipe_barang = $(this).val();

    $.ajax({
      data : {tipe_barang},
      type : "get",
      url : baseUrl + '/master/databarang/tipe_barang',
      dataType : "json",
      success : function(response){
        console.log(response);
        console.log('response');
          $('.kode_barang').val(response);
      }
    })
  })

  $('.harga').maskMoney({thousands:'.', decimal:',', precision:2});


  $(document).ready(function(){
    // set selected 'group-list'
    group_hidden = $('#group_hidden').val();
    $("#group option[value='" + group_hidden + "']").prop("selected", true);

    $(document).on('click', '.btn-submit', function(){
      form_data = $('#formsukses').serialize();
      satuan_utama = $('.satuan_utama').val();
      satuan_1 = $('.satuan_1').val();
      satuan_2 = $('.satuan_2').val();

      if(satuan_utama != ''){
        isi_satuan_utama = $('.isi_satuan_utama').val();
        harga_satuan_utama = $('.harga_satuan_utama').val();

        if(isi_satuan_utama == ''){
          $.toast({
              heading: 'Warning',
              text: 'Satuan Utama Belum di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
          return false;
        }
        if(harga_satuan_utama == ''){
           $.toast({
              heading: 'Warning',
              text: 'Harga Utama Belum di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
            return false;
        }

      } // satuan utama

      if(satuan_1 != ''){
        isi_satuan_1 = $('.isi_satuan_1').val();
       harga_satuan_1 = $('.harga_satuan_1').val();

        if(isi_satuan_1 == ''){
           $.toast({
              heading: 'Warning',
              text: 'Satuan Alternatif 1 Belum di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
            return false;
        }
        if(harga_satuan_1== ''){
           $.toast({
              heading: 'Warning',
              text: 'Harga Satuan 1 Belum di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
            return false;
        }
      } // satuan 1

      if(satuan_2 != ''){
        isi_satuan_2 = $('.isi_satuan_2').val();
        harga_satuan_2 = $('.harga_satuan_2').val();

        if(isi_satuan_2 == ''){
           $.toast({
              heading: 'Warning',
              text: 'Satuan Alternatif 2 Belum di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
            return false;
        }

        if(harga_satuan_2 == ''){
           $.toast({
              heading: 'Warning',
              text: 'Harga Alternatif 2 Belum di isi :)',
              showHideTransition: 'plain',
              icon: 'warning'
          });
            return false;
        }
      } // end satuan 2


       $.confirm({
        animation: 'RotateY',
        closeAnimation: 'scale',
        icon: 'fa fa-disc',
          title: 'Update',
        content: 'Apa anda yakin mau update data ini?',
        theme: 'disable',
          buttons: {
              info: {
            btnClass: 'btn-blue',
                text:'Ya',
                action : function(){

                    $.ajax({
                      data : form_data,
                      url : baseUrl + '/master/databarang/update',
                      dataType : "json",
                      type : "post",
                      success : function(response){

                        $.toast({
                            heading: 'Success',
                            text: 'Data Berhasil di Simpan',
                            bgColor: '#00b894',
                            textColor: 'white',
                            loaderBg: '#55efc4',
                            icon: 'success'
                          })

                          setTimeout(function(){
                          window.location.href = baseUrl + '/master/databarang/index';

                            },500);
                      }
                    });

                }
              },
              cancel:{
                text: 'Tidak',
              action: function () {
                      // tutup confirm
                  }
              }
          }
      });

    });




    $('.persentase').on('keyup blur focus', function(){
      // console.log('persentase');
      var min, max, ini;

      ini = $(this);

      min = 0;

      max = 100;

      if(parseFloat(ini.val()) > max){
        ini.val(max);
      }

    });
  });
</script>
@endsection
