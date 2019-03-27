@extends('main')
@section('content')
<style type="text/css">
.ui-autocomplete { z-index:2147483647; }
</style>
<!--BEGIN PAGE WRAPPER-->
<article class="content">
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div class="title-block text-primary">
            <h1 class="title"> Konfirmasi Data Pembelian </h1>
            <p class="title-description">
                <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
                / <span>Keuangan</span>
                / <span class="text-primary font-weight-bold">Konfirmasi Pembelian</span>
            </p>
        </div>
        
        
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="" class="nav-link active" data-target="#alert-tab" aria-controls="daftar_rencana" data-toggle="tab" role="tab">Daftar Rencana Pembelian</a>
            </li>
            <li class="nav-item">
                <a href="" data-toggle="tab"  class="nav-link" data-target="#order-tab" aria-controls="order-tab" data-toggle="tab" role="tab" onclick="daftarTabelOrder()">Daftar Order Pembelian
                </a>
            </li>
            <li class="nav-item">
                <a href="#" data-toggle="tab" class="nav-link"  data-target="#return-tab" aria-controls="return-tab" data-toggle="tab" role="tab" onclick="daftarTabelReturn()">Daftar Return Pembelian</a>
            </li>
        </ul>
        <div class="card">
            <div class="card-block">
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content">
                                <!-- tab daftar pembelian plan -->
                                <div class="tab-pane fade in active show" id="alert-tab">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                                            <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refreshTabelDaftar()">
                                            <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped" width="100%" cellspacing="0" id="tbl-daftar">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th class="wd-15p">Tgl Dibuat</th>
                                                            <th class="wd-15p">Kode Rencana</th>
                                                            <th class="wd-15p">Staff</th>
                                                            <th class="wd-20p">Suplier</th>
                                                            <th class="wd-15p">Tgl Disetujui</th>
                                                            <th class="wd-15p">Status</th>
                                                            <th class="wd-15p" style="text-align: center;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tab daftar pembelian order -->
                                <div id="order-tab" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                                            <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refreshTabelOrder()">
                                            <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped" width="100%" cellspacing="0" id="tbl-order">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th class="wd-5p">No</th>
                                                            <th class="wd-15p">Tgl Dibuat</th>
                                                            <th class="wd-15p">Kode PO</th>
                                                            <th class="wd-15p">Staff</th>
                                                            <th class="wd-15p">Suplier</th>
                                                            <th class="wd-15p">Tgl Disetujui</th>
                                                            <th class="wd-15p">Harga Total</th>
                                                            <th class="wd-10p">Status</th>
                                                            <th class="wd-15p" style="text-align: center;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tab daftar return pembelian -->
                                <div id="return-tab" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                                            <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refreshTabelReturn()">
                                            <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped" width="100%" cellspacing="0" id="tbl-return">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th class="wd-5p">No</th>
                                                            <th class="wd-15p">Tgl Return</th>
                                                            <th class="wd-15p">Kode Return</th>
                                                            <th class="wd-15p">Staff</th>
                                                            <th class="wd-15p">Metode</th>
                                                            <th class="wd-15p">Supplier</th>
                                                            <th class="wd-15p">Total Return</th>
                                                            <th class="wd-10p">Status</th>
                                                            <th class="wd-10p">Tgl Confirm</th>
                                                            <th class="wd-15p" style="text-align: center;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  tab daftar belanja harian --}}
                                {{--   @include('Keuangan.konfirmasipembelian.tab-belanjaharian') --}}
                            </div>
                        </div>
                    </div>
                    <!--END TITLE & BREADCRUMB PAGE-->
                </section>
            </div>
        </div>
        <!-- modal -->
        <!--modal confirm orderplan-->
        @include('Keuangan.konfirmasipembelian.modal-confirm')
        <!--modal confirm order-->
        @include('Keuangan.konfirmasipembelian.modal-confirm-order')
        <!--modal confirm return-->
        @include('Keuangan.konfirmasipembelian.modal-confirm-belanjaharian')
        <!--modal confirm belanja harian-->
        @include('Keuangan.konfirmasipembelian.modal-confirm-return')
        <!-- /modal -->
    </div>
</article>
@endsection
@section('extra_script')
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_detail_row');
      //remove span class in modal detail
      $("#txt_span_status_confirm").removeClass();
      $("#txt_span_status_order_confirm").removeClass();
      $("#txt_span_status_return_confirm").removeClass();
    });

    $(document).on('click', '.btn_remove_row', function(event){
        event.preventDefault();
        var button_id = $(this).attr('id');
        $('#row'+button_id+'').remove();
    });

    $(document).on('click', '.btn_remove_row_order', function(event){
        event.preventDefault();
        var button_id = $(this).attr('id');
        $('#row'+button_id+'').remove();
    });

    //event change, apabila status !fn = maka btn_remove disabled
    $('#status_confirm').change(function(event) {
      //alert($(this).val());
      if($(this).val() == "FN")
      {
        $('.btn_remove_row').attr('disabled', false);
        $('.crfmField').attr('readonly', false);
      }
      else if ($(this).val() == "WT")
      {
        $('.btn_remove_row').attr('disabled', true);
        $('.crfmField').val('0').attr('readonly', true);
      }
      else
      {
        $('.btn_remove_row').attr('disabled', true);
        $('.crfmField').attr('readonly', true);
      }
    });

    //event change, apabila status !fn = maka btn_remove disabled
    $('#status_order_confirm').change(function(event) {
      //alert($(this).val());
      if($(this).val() != "CF")
      {
        $('.btn_remove_row_order').attr('disabled', true);
      }
      else
      {
        $('.btn_remove_row_order').attr('disabled', false); 
      }
    });

    //event change, apabila status !fn = maka btn_remove disabled
    $('#status_belanja_confirm').change(function(event) {
      //alert($(this).val());
      if($(this).val() != "CF")
      {
        $('.btn_remove_row_order').attr('disabled', true);
      }
      else
      {
        $('.btn_remove_row_order').attr('disabled', false); 
      }
    });

    //event onblur input harga
   $(document).on('blur', '.field_qty_confirm',  function(e){
      var getid = $(this).attr("id");
      var qtyConfirm = $(this).val();
      var harga = convertToAngka($('#price_'+getid+'').text());
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qtyConfirm * harga);
      $('#total_'+getid+'').text(valueHargaTotal);
      $('#button_confirm_order').attr('disabled', false);
   });

   $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 0,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }

  //end jquery
  });

   $('#tbl-daftar').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-daftar",
          type: 'GET'
        },
        "columns" : [
          {"data" : "tglBuat", "width" : "15%"},
          {"data" : "p_code", "width" : "15%"},
          {"data" : "m_name", "width" : "20%"},
          {"data" : "s_company", "width" : "20%"},
          {"data" : "tglConfirm", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "5%"}
        ],
        "language": {
          "searchPlaceholder": "Cari Data",
          "emptyTable": "Tidak ada data",
          "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
          "sSearch": '<i class="fa fa-search"></i>',
          "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
          "infoEmpty": "",
          "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
             }
        }
    });

   function konfirmasiPlanAll(id) 
   {
      $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-plan/"+id+"/all",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        //ambil data ke json->modal
        $('#txt_span_status_confirm').text(data.spanTxt);
        $("#txt_span_status_confirm").addClass('label'+' '+data.spanClass);
        $("#id_plan").val(data.header[0].p_id);
        $("#status_confirm").val(data.header[0].p_status);
        $('#lblCodeConfirm').text(data.header[0].p_code);
        $('#lblTglConfirm').text(data.header[0].p_created);
        $('#lblStaffConfirm').text(data.header[0].m_name);
        $('#lblSupplierConfirm').text(data.header[0].s_company);
        
        if ($("#status_confirm").val() != "FN") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].ppdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].ppdt_qty+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].ppdt_pruchaseplan+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].ppdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
            $(this).maskFunc();
          });
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].ppdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].ppdt_qtyconfirm+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].ppdt_pruchaseplan+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].ppdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
      });
  }

  function konfirmasiPlan(id) 
  {
      $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-plan/"+id+"/confirmed",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        //ambil data ke json->modal
        $('#txt_span_status_confirm').text(data.spanTxt);
        $("#txt_span_status_confirm").addClass('label'+' '+data.spanClass);
        $("#id_plan").val(data.header[0].p_id);
        $("#status_confirm").val(data.header[0].p_status);
        $('#lblCodeConfirm').text(data.header[0].p_code);
        $('#lblTglConfirm').text(data.header[0].p_created);
        $('#lblStaffConfirm').text(data.header[0].m_name);
        $('#lblSupplierConfirm').text(data.header[0].s_company);
        
        if ($("#status_confirm").val() != "FN") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].ppdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].ppdt_qtyconfirm+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].ppdt_pruchaseplan+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].ppdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
            $(this).maskFunc();
          });
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].ppdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].ppdt_qtyconfirm+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].ppdt_pruchaseplan+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].ppdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
      });
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  } 
  daftarTabelOrder() ;
  function daftarTabelOrder() 
  {
    $('#tbl-order').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-order",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglOrder", "width" : "15%"},
          {"data" : "d_pcs_code", "width" : "15%"},
          {"data" : "m_name", "width" : "10%"},
          {"data" : "s_company", "width" : "10%"},
          {"data" : "tglConfirm", "width" : "15%"},
          {"data" : "hargaTotalNet", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "5%"}
        ],
        "language": {
          "searchPlaceholder": "Cari Data",
          "emptyTable": "Tidak ada data",
          "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
          "sSearch": '<i class="fa fa-search"></i>',
          "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
          "infoEmpty": "",
          "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
             }
        }
    });
  }

  function daftarTabelReturn() 
  {
    $('#tbl-return').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-return",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglReturn", "width" : "10%"},
          {"data" : "d_pcsr_code", "width" : "10%"},
          {"data" : "m_name", "width" : "10%"},
          {"data" : "metode", "width" : "15%"},
          {"data" : "s_company", "width" : "15%"},
          {"data" : "hargaTotal", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "tglConfirm", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "10%"}
        ],
        "language": {
          "searchPlaceholder": "Cari Data",
          "emptyTable": "Tidak ada data",
          "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
          "sSearch": '<i class="fa fa-search"></i>',
          "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
          "infoEmpty": "",
          "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
             }
        }
    });
  }

  function daftarTabelBelanja() 
  {
    $('#tbl-belanjaharian').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-belanjaharian",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBelanja", "width" : "10%"},
          {"data" : "d_pcsh_code", "width" : "10%"},
          {"data" : "m_name", "width" : "10%"},
          {"data" : "s_company", "width" : "15%"},
          {"data" : "tglConfirm", "width" : "10%"},
          {"data" : "hargaTotal", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "10%"}
        ],
        "language": {
          "searchPlaceholder": "Cari Data",
          "emptyTable": "Tidak ada data",
          "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
          "sSearch": '<i class="fa fa-search"></i>',
          "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
          "infoEmpty": "",
          "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
             }
        }
    });
  }

   function konfirmasiOrder(id,type) 
   {
    $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-order/"+id+"/"+type,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        //ambil data ke json->modal
        $('#txt_span_status_order_confirm').text(data.spanTxt);
        $("#txt_span_status_order_confirm").addClass('label'+' '+data.spanClass);
        $("#id_order").val(data.header[0].d_pcs_id);
        $("#status_order_confirm").val(data.header[0].d_pcs_status);
        var orserStatus = data.header[0].d_pcs_status;
        if (orserStatus == 'WT') 
        { 
          $("#status_order_confirm option[value=WT]").show();
          $("#status_order_confirm option[value=CF]").show();
          $("#button_confirm_order").show();
        }
        else if (orserStatus == 'CF') 
        {
          $("#status_order_confirm option[value=WT]").hide();
          $("#button_confirm_order").hide();
        }
        else if (orserStatus == 'RC') 
        {
          $("#status_order_confirm option[value=WT]").hide();
          $("#status_order_confirm option[value=CF]").hide();
          $("#button_confirm_order").hide();
        }
        else if (orserStatus == 'RV')
        {
          $("#status_order_confirm option[value=WT]").hide();
          $("#status_order_confirm option[value=CF]").hide();
          $("#button_confirm_order").hide();
        }
        $('#lblCodeOrderConfirm').text(data.header[0].d_pcs_code);
        $('#lblTglOrderConfirm').text(data.header[0].d_pcs_date_created);
        $('#lblStaffOrderConfirm').text(data.header[0].m_name);
        $('#lblSupplierOrderConfirm').text(data.header[0].s_company);
        var d_pcs_total_net = convertDecimalToRupiah(data.header[0].d_pcs_total_net);
        $('#total-harga').val(d_pcs_total_net);
        if (data.header[0].d_pcs_method != "CASH") 
        {
          $('#append-modal-order div').remove();
          var metode = data.header[0].d_pcs_method;
          if (metode == "DEPOSIT") 
          {
            $('#append-modal-order div').remove();
            $('#append-modal-order').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">Batas Terakhir Pengiriman</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
          else if(metode == "CREDIT")
          {
            $('#append-modal-order div').remove();
            $('#append-modal-order').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">TOP (Termin Of Payment)</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
        }

        if ($("#statusOrderConfirm").val() != "CF") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-order-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].d_pcsdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcsdt_qty+'" name="fieldConfirmOrder[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency" readonly style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_id+'" name="fieldIdDtOrder[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_prevcost)+'</td>'
                            +'<td align="right" id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_price)+'</td>'
                            +'<td align="right" id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_total)+'<input type="hidden" value="'+formatAngka(data.data_isi[key-1].d_pcsdt_total)+'" name="" class="form-control input-sm hasil"/></td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
           
          });
          $(this).maskFunc();
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-order-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+formatAngka(data.data_isi[key-1].d_pcsdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcsdt_qty+'" name="fieldConfirmOrder[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency" readonly style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_id+'" name="fieldIdDtOrder[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_prevcost)+'</td>'
                            +'<td align="right" id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_price)+'</td>'
                            +'<td align="right" id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_total)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm-order').modal('show');
         hitungJumlah();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
   }

   function hitungJumlah()
   {
      var inputs = document.getElementsByClassName('hasil'),
        hasil = [].map.call(inputs, function (input) {
            return input.value;
        });
      var total = 0;

      for (var i = hasil.length - 1; i >= 0; i--) {
        hasil[i] = convertToAngka(hasil[i]);
        hasil[i] = parseInt(hasil[i]);
        total = total + hasil[i];
      }

      // $('#total-harga').val(total);
      $('#total-hargaKw').val(total);
      total = convertToRupiah(total);
      $('#total-harga').val(total);
      konfirmasiStatus();
   }

   function konfirmasiStatus()
   {
      var totalHarga = parseInt($('#total-hargaKw').val());
      var batasPlafon = parseInt($('#batas-plafon').val());
      if (batasPlafon == '0') 
      {
        iziToast.success({
            timeout: 5000,
            position: "topLeft",
            icon: 'fa fa-chrome',
            title: '',
            message: 'Tidak ada batas plafon.'
        });
      }
      else if (totalHarga > batasPlafon) 
      {
        iziToast.success({
            timeout: 5000,
            position: "topLeft",
            icon: 'fa fa-chrome',
            title: '',
            message: 'Pembelian melebihi batas plafon.'
        });
        $('#button_confirm_order').attr('disabled', true);
      }
      else 
      {
        $('#button_confirm_order').attr('disabled', false);
      }
   }

   $('#status_order_confirm').change(function(event) {
      //alert($(this).val());
      if($(this).val() != "CF")
      {
        $('.btn_remove_row_order').attr('disabled', true);
        $('#button_confirm_order').attr('disabled', false);
        
      }
      else
      {
        $('.btn_remove_row_order').attr('disabled', true); 
        hitungJumlah();
      }
   });

   $(document).on('click', '.btn_remove_row_order', function(event){
     event.preventDefault();
     var button_id = $(this).attr('id');
     $('#row'+button_id+'').remove();
     hitungJumlah();
   });


  function change(argument) {
    var ck = $('.qty_confirm_'+argument).val();
    var awal = $('.qty_awal_'+argument).text();
    if (parseInt(ck) > parseInt(awal)) {
       iziToast.warning({
            icon: 'fa fa-info',
            message: 'Qty lebih besar dari yg disetujui!'
      });
      $('.qty_confirm_'+argument).val(0);
    }
    console.log(argument);

    var hit =$('.price_'+argument).val();
    // console.log(parseInt(res));
    console.log(parseInt(hit));
    // console.log(parseInt(ck));
    var hitung = parseInt(ck)*parseInt(hit);
    // console.log(hitung);
    var hit =$('.total_tot_'+argument).text('Rp. '+accounting.formatMoney(hitung,"",2,'.',','));
    var hitu =$('.total_'+argument).val(hitung);
  }

  function konfirmasiReturn(id,type) 
  {
    $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-return/"+id+"/"+type,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        $('#txt_span_status_return_confirm').text(data.spanTxt);
        $("#txt_span_status_return_confirm").addClass('label'+' '+data.spanClass);
        $("#id_return").val(data.header[0].d_pcsr_id);
        $("#status_return_confirm").val(data.header[0].d_pcsr_status);
        $('#lblCodeReturnConfirm').text(data.header[0].d_pcsr_code);
        $('#lblTglReturnConfirm').text(data.header2.tanggalReturn);
        $('#lblStaffReturnConfirm').text(data.header[0].m_name);
        $('#lblSupplierReturnConfirm').text(data.header[0].s_company);
        $('#lblTotalReturnConfirm').text(data.header2.hargaTotalReturn);
        
        if ($("#status_return_confirm").val() != "CF") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-return-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcsrdt_qty+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcsrdt_qty
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_qty+'" name="fieldConfirmReturn[]" id="'+i+'" class="form-control numberinput input-sm field_qty_confirm">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_id+'" name="fieldIdDtReturn[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_price)+'</td>'
                            +'<td id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_pricetotal)+'</td>'
                            +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-return-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcsrdt_qty+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcsrdt_qty
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_qty+'" name="fieldConfirmReturn[]" id="'+i+'" class="form-control numberinput input-sm field_qty_confirm">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_id+'" name="fieldIdDtReturn[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_price)+'</td>'
                            +'<td id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_pricetotal)+'</td>'
                            +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
        }
        
        $('#modal-confirm-return').modal('show');
      },
          error: function(jqXHR, exception) {          
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            }if (jqXHR.status === 401) {
                alert("Ma'af, anda telah logout silahkan login kembali.");
                window.location.reload();
            }else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText.error);
            }
        }
    });
  }

  function konfirmasiBelanjaHarian(id,type) 
  {
    $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-belanjaharian/"+id+"/"+type,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        $('#txt_span_status_belanja_confirm').text(data.spanTxt);
        $("#txt_span_status_belanja_confirm").addClass('label'+' '+data.spanClass);
        $("#id_belanja").val(data.header[0].d_pcsh_id);
        $("#status_belanja_confirm").val(data.header[0].d_pcsh_status);
        $('#lblCodeBelanjaConfirm').text(data.header[0].d_pcsh_code);
        $('#lblTglBelanjaConfirm').text(data.header[0].d_pcsh_date);
        $('#lblStaffBelanjaConfirm').text(data.header[0].m_name);
        $('#lblSupplierBelanjaConfirm').text(data.header[0].s_company);
        $('#lblTotalBelanjaConfirm').text(convertDecimalToRupiah(data.header[0].d_pcsh_totalprice));
        $('#lblTotalBayarConfirm').text(convertDecimalToRupiah(data.header[0].d_pcsh_totalpaid));
        
        if ($("#status_belanja_confirm").val() != "CF") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-belanja-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_qty+'" name="fieldConfirmBelanja[]" id="'+i+'" class="form-control numberinput input-sm field_qty_confirm">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_id+'" name="fieldIdDtBelanja[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_price)+'</td>'
                            +'<td id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_pricetotal)+'</td>'
                            +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-belanja-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_qty+'" name="fieldConfirmBelanja[]" id="'+i+'" class="form-control numberinput input-sm field_qty_confirm">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_id+'" name="fieldIdDtBelanja[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].s_name+'</td>'
                            +'<td id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_price)+'</td>'
                            +'<td id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_pricetotal)+'</td>'
                            +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
        }
        
        $('#modal-confirm-belanjaharian').modal('show');
      },
          error: function(jqXHR, exception) {          
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            }if (jqXHR.status === 401) {
                alert("Ma'af, anda telah logout silahkan login kembali.");
                window.location.reload();
            }else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText.error);
            }
        }
    });
  }

 
  function submitConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi rencana pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm').text('Proses...');
          $('#button_confirm').attr('disabled',true);
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-plan-submit",
            type: "GET",
            dataType: "JSON",
            data: $('#form-confirm-plan').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#modal-confirm').modal('hide');
                    $('#button_confirm').text('Konfirmasi'); 
                    $('#button_confirm').attr('disabled',false); 
                    $('#tbl-daftar').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    alert('dd');
                    $('#modal-confirm').modal('hide');
                    $('#button_confirm').text('Konfirmasi'); //change button text
                    $('#button_confirm').attr('disabled',false); //set button enable 
                    $('#tbl-daftar').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function submitOrderConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi PO',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm_order').text('Proses...');
          $('#button_confirm_order').attr('disabled',true);
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-order-submit",
            type: "GET",
            dataType: "JSON",
            data: $('#form-confirm-order').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.status,
                  onClosing: function(instance, toast, closedBy){
                    $('#modal-confirm-order').modal('hide');
                    $('#button_confirm_order').text('Konfirmasi');
                    $('#button_confirm_order').attr('disabled',false); 
                    $('#tbl-order').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.status,
                  onClosing: function(instance, toast, closedBy){
                    $('#modal-confirm-order').modal('hide');
                    $('#button_confirm_order').text('Konfirmasi');
                    $('#button_confirm_order').attr('disabled',false); 
                    $('#tbl-order').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function submitReturnConfirm(id)
  {
    if(confirm('Anda yakin konfirmasi return pembelian ?'))
    {
      $('#button_confirm_return').text('Proses...'); //change button text
      $('#button_confirm_return').attr('disabled',true); //set button disable 
      $.ajax({
          url : baseUrl + "/keuangan/konfirmasipembelian/confirm-return-submit",
          type: "post",
          dataType: "JSON",
          data: $('#form-confirm-return').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
                $('#modal-confirm-return').modal('hide');
                $('#button_confirm_return').text('Konfirmasi'); //change button text
                $('#button_confirm_return').attr('disabled',false); //set button enable 
                $('#tbl-return').DataTable().ajax.reload();
            }
            else
            {
                $('#modal-confirm-return').modal('hide');
                $('#button_confirm_return').text('Konfirmasi'); //change button text
                $('#button_confirm_return').attr('disabled',false); //set button enable 
                $('#tbl-return').DataTable().ajax.reload();
            }
          },
         error: function(jqXHR, exception) {          
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            }if (jqXHR.status === 401) {
                alert("Ma'af, anda telah logout silahkan login kembali.");
                window.location.reload();
            }else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText.error);
            }
        }
      });
    }
  }

  function submitReturnConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi Retur Pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm_return').text('Proses...'); //change button text
          $('#button_confirm_return').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-return-submit",
            type: "post",
            dataType: "JSON",
            data: $('#form-confirm-return').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#modal-confirm-return').modal('hide');
                    $('#button_confirm_return').text('Konfirmasi'); //change button text
                    $('#button_confirm_return').attr('disabled',false); //set button enable 
                    $('#tbl-return').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#modal-confirm-return').modal('hide');
                    $('#button_confirm_return').text('Konfirmasi'); //change button text
                    $('#button_confirm_return').attr('disabled',false); //set button enable 
                    $('#tbl-return').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function submitBelanjaConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi Belanja Harian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm_belanja').text('Proses...'); 
          $('#button_confirm_belanja').attr('disabled',true); 
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-belanjaharian-submit",
            type: "post",
            dataType: "JSON",
            data: $('#form-confirm-belanjaharian').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#modal-confirm-belanjaharian').modal('hide');
                    $('#button_confirm_belanja').text('Konfirmasi'); //change button text
                    $('#button_confirm_belanja').attr('disabled',false); //set button enable 
                    $('#tbl-belanjaharian').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#modal-confirm-belanjaharian').modal('hide');
                    $('#button_confirm_belanja').text('Konfirmasi'); //change button text
                    $('#button_confirm_belanja').attr('disabled',false); //set button enable 
                    $('#tbl-belanjaharian').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function convertDecimalToRupiah(decimal) 
  {
      var angka = parseInt(decimal);
      var rupiah = '';        
      var angkarev = angka.toString().split('').reverse().join('');
      for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      return hasil+',00';
  }

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

   function formatAngka(decimal) 
   {
      var angka = parseInt(decimal);
      var fAngka = '';        
      var angkarev = angka.toString().split('').reverse().join('');
      for(var i = 0; i < angkarev.length; i++){
      if(i%3 == 0) fAngka += angkarev.substr(i,3)+'.';
      } 
      var hasil = fAngka.split('',fAngka.length-1).reverse().join('');
      return hasil;
   }

  function refreshTabelDaftar() 
  {
    $('#tbl-daftar').DataTable().ajax.reload();
  }

  function refreshTabelOrder() 
  {
    $('#tbl-order').DataTable().ajax.reload();
  }

  function refreshTabelBharian() 
  {
    $('#tbl-belanjaharian').DataTable().ajax.reload();
  }

  function refreshTabelReturn() 
  {
    $('#tbl-return').DataTable().ajax.reload();
  }

</script>
@endsection