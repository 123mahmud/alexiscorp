@extends('main')

@section('content')

@include('stok.pencatatanbarangmasuk.modal_muatan')
@include('stok.pencatatanbarangmasuk.modal_barangmasuk')

<article class="content">

  <div class="title-block text-primary">
      <h1 class="title"> Tambah Pencatatan Barang Masuk </h1>
      <p class="title-description">
        <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
        / <span>Stok</span> 
        / <a class="{{route('pencatatanbarangmasuk')}}"><span>Pencatatan Barang Masuk</span> </a>
        / <span class="text-primary font-weight-bold">Tambah Pencatatan Barang Masuk</span>
       </p>
  </div>

  <section class="section">

    <div class="row">

      <div class="col-12">
        
        <div class="card">
            <div class="card-header bordered p-2">
              <div class="header-block">
                <h3 class="title"> Tambah Pencatatan Barang Masuk </h3>
              </div>
              <div class="header-block pull-right">
                <a href="{{route('pencatatanbarangmasuk')}}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i></a>
              </div>
            </div>
            <div class="card-block">
                <section>

                  <fieldset>
                    <div class="row">

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Kode Penerimaan</label>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm" readonly>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Nota Order Pembelian</label>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="hidden" id="nota">
                          <select class="form-control form-control-sm select2" id="nota_order" name="nota_order" onchange="showInfoPO()">
                            <option value="">--Pilih--</option>
                            @foreach ($getNota as $nota)
                              <option value="{{ $nota->po_id }}">{{ $nota->po_code }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Tanggal Order Pembelian</label>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm" readonly="" id="tgl_order">
                        </div>
                      </div>
                      
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Staff</label>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm" readonly="">
                        </div>
                      </div>
                      
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Suplier</label>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm" readonly="" id="supplier">
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Cara Bayar</label>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm" readonly="" id="method">
                        </div>
                      </div>

                      <div class="col-12">
                        <button class="btn btn-primary btn-block btn-proses" type="button">Tampilkan</button>
                      </div>
                    </div>
                  </fieldset>

                  <form id="tables">
                      <div class="d-none" id="front-end-show">                          
                      
                      </div>
                  </form>

                </section>
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary" type="button" onclick="submit()">Simpan</button>
              <a href="{{route('pencatatanbarangmasuk')}}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
      </div>

    </div>

  </section>

</article>

@endsection
@section('extra_script')
<script src="{{asset('modul_keuangan/js/vendor/axios_0_18_0/axios.js')}}"></script>
<script type="text/javascript">
  
  $(document).ready(function(){

    $('.btn-proses').click(function(){
      if($('#nota_order').val() === ''){
        $.toast({
          text:'Pilih Nota Terlebih Dahulu!',
          icon:'error'
        });
        $('#front-end-show').addClass('d-none');
      } else {

        var id = $('#nota_order').val();
        axios.get('{{ url("/stok/pencatatanbarangmasuk/getpbdt") }}'+'?id='+id+'&opsi=yes').then((response) => {

          var isiOpsi = '';
          for(var io = 0; io < response.data.opsi.length; io++){
            isiOpsi += 
              '<tr>'+
                '<td class="text-center"><input type="checkbox" class="checkB" name="idItem[]" value="'+response.data.opsi[io].podt_item+'"></td>'+
                '<td>'+response.data.opsi[io].i_name+'</td>'+
              '</tr>'
          }
          $('#cekParent').prop('checked', false);
          $('#isiTableTerima').html('');
          $('#isiTableTerima').append(isiOpsi);
          $('#opsi_terima').modal('show');
        })

        $('.data-table').DataTable({
          searching:false,
          paging:false
        });

        $('#front-end-show').removeClass('d-none');
      }

    });

  });

  function lanjutkan(){

    $('#front-end-show').html('');

    var id = $('#nota_order').val();
    axios.get('{{ url("/stok/pencatatanbarangmasuk/getpbdt") }}'+'?id='+id+'&'+$('#isiTableOpsi').serialize()).then((response) => {
      var countTable = 1;
      for(var i = 0; i < response.data.data.length; i++){

        var optionNopol = '';
        for(var o = 0; o < response.data.nopol.length; o++){
          optionNopol += '<option value="'+response.data.nopol[o].k_id+'">'+response.data.nopol[o].k_nopol+'</option>';
        }

        var headerJumlah = '';
        var tableData = '';
        if(response.data.data[i].podt_satuan == 3){
          for(var j = 0; j < parseInt(response.data.data[i].podt_qty); j++){
            tableData += '<tr>'+
              '<input type="hidden" name="detailid[]" value="'+response.data.data[i].podt_detailid+'">'+
              '<input type="hidden" name="idItem[]" value="'+response.data.data[i].podt_item+'">'+
              '<input type="hidden" name="satuan[]" value="'+response.data.data[i].podt_satuan+'">'+
              '<td>BRG/'+(j+1)+'</td>'+
              '<td><input type="text" class="form-control-sm form-control datepicker" name="tgl[]" id="tgl'+j+'"></td>'+
              '<td><input type="text" class="form-control-sm form-control input-jam" name="jam[]" id="jam'+j+'""></td>'+
              '<td><input type="text" class="form-control-sm form-control" name="surat[]" id="surat'+j+'"></td>'+
              '<td>'+
                '<select class="select2 form-control form-control-sm plat_no" name="nopol[]" id="nopol'+j+'">'+
                  '<option value="" selected="" disabled="">--Pilih--</option>'+
                  optionNopol+
                '</select>'+
              '</td>'+
              '<td align="center">'+
                '<button type="button" class="btn btn-info btn-xs btn-detail-muatan" disabled="" data-toggle="modal" data-target="#detail_muatan" id="detail'+j+'">Detail</button>'+
              '</td>'+
              '<td><input type="text" class="form-control-sm form-control muatan_bak" readonly="" name="muatan[]" id="muatan'+j+'"></td>'+
            '</tr>';
          }
          headerJumlah = '<th>Kubikasi Muatan Bak (m<sup>3</sup>)</th>';
        }else{
          tableData += '<tr>'+
            '<input type="hidden" name="detailid[]" value="'+response.data.data[i].podt_detailid+'">'+
            '<input type="hidden" name="idItem[]" value="'+response.data.data[i].podt_item+'">'+
            '<input type="hidden" name="satuan[]" value="'+response.data.data[i].podt_satuan+'">'+
            '<td>BRG/1</td>'+
            '<td><input type="text" class="form-control-sm form-control datepicker" name="tgl[]" id="tgl'+j+'"></td>'+
            '<td><input type="text" class="form-control-sm form-control input-jam" name="jam[]" id="jam'+j+'"></td>'+
            '<td><input type="text" class="form-control-sm form-control" name="surat[]" id="surat'+j+'"></td>'+
            '<td>'+
              '<select class="select2 form-control form-control-sm plat_no" name="nopol[]" id="nopol'+j+'">'+
                '<option value="" selected="" disabled="">--Pilih--</option>'+
                optionNopol+
              '</select>'+
            '</td>'+
            '<td align="center">'+
              '<button type="button" class="btn btn-info btn-xs btn-detail-muatan" disabled="" data-toggle="modal" data-target="#detail_muatan" id="detail'+j+'">Detail</button>'+
            '</td>'+
            '<td><input type="text" class="form-control-sm form-control muatan_bak" readonly="" name="muatan[]" id="muatan'+j+'"></td>'+
          '</tr>';
          headerJumlah = '<th>Jumlah Barang (per Satuan)</th>';
        }

        var sisa = 0;
        if(response.data.qty.length == 0){
          sisa = response.data.data[i].podt_qty;
        }else{
          for (var s = 0; s < response.data.qty.length; s++) {
            if (response.data.data[i].podt_item == response.data.qty[s].pbdt_item) {
              sisa = response.data.data[i].podt_qty - response.data.qty[s].qty_received;
              s = response.data.qty.length + 1;
            } else {
              sisa = response.data.data[i].podt_qty;
            }
          }
        }

        if(sisa == 0){
          continue;
        }
        
        $('#front-end-show').append(
          '<fieldset class="mt-3">'+
            '<h4><b>'+response.data.data[i].i_name+'</b></h4>'+
            '<span class="badge badge-pill badge-secondary">'+response.data.data[i].podt_qty+' '+response.data.data[i].s_name+'</span> dengan sisa <span class="badge badge-pill badge-secondary">'+sisa+' '+response.data.data[i].s_name+'</span>'+
            '<hr>'+
            '<div class="table-responsive mt-3">'+
              '<table class="table table-bordered table-striped table-hover data-table" id="table_barang'+i+'" cellspacing="0">'+
                '<thead class="bg-primary">'+
                  '<tr>'+
                    '<th>Kode | Barang</th>'+
                    '<th>Tanggal Datang</th>'+
                    '<th>Jam Datang</th>'+
                    '<th>Surat Jalan</th>'+
                    '<th>Plat Nomor</th>'+
                    '<th>Detail Kendaraan</th>'+
                    headerJumlah+
                  '</tr>'+
                '</thead>'+
                '<tbody>'+
                tableData+
                '</tbody>'+
              '</table>'+
            '</div>'+
          '</fieldset>'
        );

        $( ".datepicker" ).datepicker({
          language: "id",
          format: 'dd/mm/yyyy',
          prevText: '<i class="fa fa-chevron-left"></i>',
          nextText: '<i class="fa fa-chevron-right"></i>',
          autoclose: true,
          todayHighlight: true
        });

        $('.input-jam').inputmask({"regex":"^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$"});

        countTable++;
      }

      $('.data-table tbody').on('change', '.plat_no', function(){

        var plat_no = $(this).val();
        var btn_modal = $(this).parents('tr').find('.btn-detail-muatan');

        if(plat_no != ''){
          btn_modal.attr('disabled', false);
          $(this).parents('tr').find('.muatan_bak').attr('readonly', false);
        } else {
          btn_modal.attr('disabled', true);
          $(this).parents('tr').find('.muatan_bak').val('').attr('readonly', true);
        }

      });

    });
    $('#opsi_terima').modal('hide');
  }

  function myCheck(){
    var checkBox = document.getElementById("cekParent");
    if(checkBox.checked == true){
        $('.checkB').prop('checked', true);
    }else{
        $('.checkB').prop('checked', false);
    }
  }

  function showInfoPO(){
    var id = $('#nota_order').val();
    axios.get('{{ url("/stok/pencatatanbarangmasuk/getinfopo") }}'+'?id='+id).then((response) => {

      $('#tgl_order').val(response.data.info.date);
      $('#supplier').val(response.data.info.supplier);
      $('#method').val(response.data.info.method);
      $('#nota').val(response.data.info.nota)

    })
  }

  function submit(){
    var nota = $('#nota').val();
    var data = 'nota='+ nota + '&' + $('#tables').serialize();
    axios.post('{{ url("/stok/pencatatanbarangmasuk/create") }}', data).then((response) => {

      if(response.data.status == 'sukses'){
        $.toast({
          text:'Penerimaan Barang Berhasil',
          icon:'success'
        });
        location.reload();
      }else{
        $.toast({
          text:'Penerimaan Barang Gagal',
          icon:'error'
        });
      }

    })
  }

</script>
@endsection