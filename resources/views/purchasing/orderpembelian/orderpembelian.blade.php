@extends('main')

@section('content')

@include('purchasing.orderpembelian.modal_detail')

<article class="content">
   <div class="title-block text-primary">
      <h1 class="title"> Order Pembelian </h1>
      <p class="title-description">
         <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
         / <span>Purchasing</span>
         / <span class="text-primary font-weight-bold">Order Pembelian</span>
      </p>
   </div>
   <section class="section">
      <ul class="nav nav-pills">
         <li class="nav-item">
            <a href="" class="nav-link active" data-target="#list_barang" aria-controls="list_barang" data-toggle="tab" role="tab">Order Pembelian Dengan Rencana</a>
         </li>
         <li class="nav-item">
            <a href="" class="nav-link" data-target="#po_tanpa" aria-controls="po_tanpa" data-toggle="tab" role="tab">Order Pembelian Tanpa Rencana</a>
         </li>
         <li class="nav-item">
            <a href="" class="nav-link" data-target="#list_suplier" aria-controls="list_suplier" data-toggle="tab" role="tab">History Order Pembelian</a>
         </li>
      </ul>
      <div class="row">
         <div class="col-12">
            <div class="tab-content">
               <div class="tab-pane fade in active show" id="list_barang">
                  <div class="card">
                     <div class="card-header bordered p-2">
                        <div class="header-block">
                           <h3 class="title"> Order Pembelian Dengan Rencana</h3>
                        </div>
                        <div class="header-block pull-right">
                           
                           <a class="btn btn-primary" href="{{ url('/purcahse-order/form-order') }}"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
                        </div>
                     </div>
                     <div class="card-block">
                        <section>
                           
                           <div class="row">
                              <div class="col-md-3 col-sm-12">
                                 <label class="font-weight-bold">Tanggal Order</label>
                              </div>
                              <div class="col-md-6 col-sm-12">
                                 <div class="form-group">
                                    <div class="input-group input-group-sm input-daterange">
                                       <input type="text" class="form-control datepicker1" name="tanggal1" id="tanggal1">
                                       <span class="input-group-addon">-</span>
                                       <input type="text" class="form-control datepicker1" name="tanggal2"  id="tanggal2">
                                       <div class="input-group-append">
                                          <button class="btn btn-primary" type="button"  onclick="lihatOrderByTanggal()"><i class="fa fa-search"></i></button>
                                          <button class="btn btn-secondary" type="button"  onclick="refreshTabelIndex()"><i class="fa fa-refresh"></i></button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              
                           </div>
                           
                           <div class="table-responsive">
                              
                              <table class="table table-hover table-striped" cellspacing="0" id="tbl-index">
                                 <thead class="bg-primary">
                                    <tr>
                                       <th>Tgl Order</th>
                                       <th>No Order</th>
                                       <th>Staff</th>
                                       <th>Suplier</th>
                                       <th>Cara Bayar</th>
                                       <th>Total</th>
                                       <th>Tgl Kirim</th>
                                       <th>Status</th>
                                       <th>Ubah Status</th>
                                       <th>Aksi</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                           
                        </section>
                     </div>
                  </div>
               </div>
               @include('purchasing.orderpembelian.tab_po_tanpa_rencana')
               @include('purchasing.orderpembelian.tab_history')
            </div>
         </div>
      </div>
   </section>
</article>

@endsection
@section('extra_script')
<script type="text/javascript">
  var save_method;
  $(document).ready(function() {
      //fix to issue select2 on modal when opening in firefox
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
      //add bootstrap class to datatable
      var extensions = {
              "sFilterInput": "form-control input-sm",
              "sLengthSelect": "form-control input-sm"
          }
          // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      $.fn.maskFunc = function() {
          $('.currency').inputmask("currency", {
              radixPoint: ",",
              groupSeparator: ".",
              digits: 2,
              autoGroup: true,
              prefix: '', //Space after $, this will not truncate the first character.
              rightAlign: false,
              oncleared: function() {
                  self.Value('');
              }
          });
      }

      var date = new Date();
      var newdate = new Date(date);

      newdate.setDate(newdate.getDate() - 30);
      var nd = new Date(newdate);

      $('.datepicker1').datepicker({
          autoclose: true,
          format: "dd-mm-yyyy",
          endDate: 'today'
      }).datepicker("setDate", nd);

      $('.datepicker2').datepicker({
          autoclose: true,
          format: "dd-mm-yyyy",
          endDate: 'today'
      }); //datepicker("setDate", "0");

      // fungsi jika modal hidden
      $(".modal").on("hidden.bs.modal", function() {
          $('tr').remove('.tbl_modal_row');
          $('tr').remove('.tbl_modal_edit_row');
          $('tr').remove('.tbl_modal_detailmsk_row');
          //remove span class in modal detail
          $("#txt_span_status_detail").removeClass();
          $('#txt_span_status_edit').removeClass();
      });

      //event focus on input harga
      $(document).on('focus', '.field_harga', function(e) {
          var harga = convertToAngka($(this).val());
          $(this).val(harga);
      });

      $(document).on('focus', '#potongan_harga', function(e) {
          var potHarga = convertToAngka($(this).val());
          $(this).val(potHarga);
          $('#button_save').attr('disabled', true);
      });

      $(document).on('focus', '#diskon_harga', function(e) {
          var discChar = convertToAngka($(this).val());
          $(this).val(discChar);
          $('#button_save').attr('disabled', true);
      });

      $(document).on('focus', '#ppn_harga', function(e) {
          var ppnChar = convertToAngka($(this).val());
          $(this).val(ppnChar);
          $('#button_save').attr('disabled', true);
      });

      //event onblur input harga
      $(document).on('blur', '.field_harga', function(e) {
          var getid = $(this).attr("id");
          var harga = $(this).val();
          var qtyOrder = $('#qty_' + getid + '').val();
          //hitung nilai harga total
          var valueHargaTotal = convertToRupiah(qtyOrder * harga);
          //ubah format ke rupiah
          var hargaRp = convertToRupiah($(this).val());
          $(this).val(hargaRp);
          $('#total_' + getid + '').val(valueHargaTotal);
          totalPembelianGross();
          totalPembelianNett();
          $('#button_save').attr('disabled', false);
      });

      //event onblur potongan harga
      $(document).on('blur', '#potongan_harga', function(e) {
          //ubah format ke rupiah
          var potonganRp = convertToRupiah($(this).val());
          $(this).val(potonganRp);
          totalPembelianNett();
          $('#button_save').attr('disabled', false);
      });

      //event onblur diskon
      $(document).on('blur', '#diskon_harga', function(e) {
          //ubah format ke diskon
          var discSimbol = $(this).val();
          $(this).val(discSimbol + '%');
          totalPembelianNett();
          $('#button_save').attr('disabled', false);
      });

      //event onblur ppn
      $(document).on('blur', '#ppn_harga', function(e) {
          //ubah format ke diskon
          var ppnSimbol = $(this).val();
          $(this).val(ppnSimbol + '%');
          totalPembelianNett();
          $('#button_save').attr('disabled', false);
      });

      $('#tampil_data').on('change', function() {
          lihatHistorybyTgl();
      })

      lihatOrderByTanggal();

  });

  function lihatOrderByTanggal() {
      var tgl1 = $('#tanggal1').val();
      var tgl2 = $('#tanggal2').val();
      $('#tbl-index').dataTable({
          "destroy": true,
          "processing": true,
          "serverside": true,
          "ajax": {
              url: baseUrl + "/purchasing/orderpembelian/get-order-by-tgl/" + tgl1 + "/" + tgl2,
              type: 'GET'
          },
          columnDefs: [{
              targets: 6,
              className: 'right format_money'
          }, ],
          "columns": [{
                  "data": "DT_Row_Index",
                  orderable: true,
                  searchable: false,
                  "width": "5%"
              }, //memanggil column row
              {
                  "data": "tglOrder",
                  "width": "10%"
              }, {
                  "data": "d_pcs_code",
                  "width": "10%"
              }, {
                  "data": "m_name",
                  "width": "7%"
              }, {
                  "data": "s_company",
                  "width": "13%"
              }, {
                  "data": "d_pcs_method",
                  "width": "5%"
              }, {
                  "data": "hargaTotalNet",
                  "width": "12%"
              }, {
                  "data": "tglMasuk",
                  "width": "10%"
              }, {
                  "data": "status",
                  "width": "7%"
              }, {
                  "data": "action",
                  orderable: false,
                  searchable: false,
                  "width": "17%"
              }
          ],
          "responsive": true,
          "pageLength": 10,
          "lengthMenu": [
              [10, 20, 50, -1],
              [10, 20, 50, "All"]
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

  function detailOrder(id) {
      $('#append-modal-detail div').remove();
      $.ajax({
          url: baseUrl + "/purchasing/orderpembelian/get-data-detail/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
              var i = randString(5);
              var key = 1;
              $('#txt_span_status_detail').text(data.spanTxt);
              $("#txt_span_status_detail").addClass('label' + ' ' + data.spanClass);
              $('#lblNoOrder').text(data.header[0].d_pcs_code);
              $('#lblCaraBayar').text(data.header[0].d_pcs_method);
              $('#lblTglOrder').text(data.header[0].d_pcs_date_created);
              var tglPenerimaan = data.header[0].d_pcs_date_received;
              if (tglPenerimaan == null) {
                  $('#lblTglKirim').text('Belum di terima');
              } else {
                  $('#lblTglKirim').text(data.header[0].d_pcs_date_received);
              }

              $('#lblStaff').text(data.header[0].m_name);
              $('#lblSupplier').text(data.header[0].s_company);
              $('[name="totalHarga"]').val(data.header2.hargaBruto);
              $('[name="diskonHarga"]').val(data.header2.nilaiDiskon);
              $('[name="ppnHarga"]').val(data.header2.nilaiPajak);
              $('[name="totalHargaFinal"]').val(data.header2.hargaNet);
              if (data.header[0].d_pcs_method != "CASH") {
                  $('#append-modal-detail div').remove();
                  var metode = data.header[0].d_pcs_method;
                  if (metode == "DEPOSIT") {
                      $('#append-modal-detail div').remove();
                      $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<label class="tebal">Batas Terakhir Pengiriman</label>' +
                          '</div>' +
                          '<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<div class="form-group">' +
                          '<label id="dueDate">' + data.header[0].d_pcs_duedate + '</label>' +
                          '</div>' +
                          '</div>');
                  } else if (metode == "CREDIT") {
                      $('#append-modal-detail div').remove();
                      $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<label class="tebal">TOP (Termin Of Payment)</label>' +
                          '</div>' +
                          '<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<div class="form-group">' +
                          '<label id="dueDate">' + data.header[0].d_pcs_duedate + '</label>' +
                          '</div>' +
                          '</div>');
                  }
              }
              //loop data
              Object.keys(data.data_isi).forEach(function() {
                  $('#tabel-order').append('<tr class="tbl_modal_row" id="row' + i + '">' +
                      '<td>' + key + '</td>' +
                      '<td>' + data.data_isi[key - 1].i_code + ' | ' + data.data_isi[key - 1].i_name + '</td>' +
                      '<td>' + data.data_isi[key - 1].s_name + '</td>' +
                      '<td>' + data.data_isi[key - 1].d_pcsdt_qty + '</td>' +
                      '<td>' + data.data_stok[key - 1].qtyStok + ' ' + data.data_satuan[key - 1] + '</td>' +
                      '<td>' + convertDecimalToRupiah(data.data_isi[key - 1].d_pcsdt_prevcost) + '</td>' +
                      '<td>' + convertDecimalToRupiah(data.data_isi[key - 1].d_pcsdt_price) + '</td>' +
                      '<td>' + convertDecimalToRupiah(data.data_isi[key - 1].d_pcsdt_total) + '</td>' +
                      '</tr>');
                  key++;
                  i = randString(5);
              });
              $('#append-footer-detail').html('<a href="' + baseUrl + '/purchasing/orderpembelian/print/' + id + '" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>' +
                  '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
              $('#modal-detail').modal('show');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error get data from ajax');
          }
      });
  }

  function lihatHistorybyTgl() {
      var tgl1 = $('#tanggal1').val();
      var tgl2 = $('#tanggal2').val();
      var tampil = $('#tampil_data').val();
      $('#tbl-history').dataTable({
          "destroy": true,
          "processing": true,
          "serverside": true,
          "ajax": {
              url: baseUrl + "/purchasing/orderpembelian/get-data-tabel-history/" + tgl1 + "/" + tgl2 + "/" + tampil,
              type: 'GET'
          },
          "columns": [{
                  "data": "DT_Row_Index",
                  orderable: true,
                  searchable: false,
                  "width": "5%"
              }, //memanggil column row
              {
                  "data": "d_pcs_code",
                  "width": "10%"
              }, {
                  "data": "i_name",
                  "width": "15%"
              }, {
                  "data": "s_name",
                  "width": "10%"
              }, {
                  "data": "s_company",
                  "width": "15%"
              }, {
                  "data": "tglBuat",
                  "width": "10%"
              }, {
                  "data": "d_pcsdt_qtyconfirm",
                  "width": "5%"
              }, {
                  "data": "tglTerima",
                  "width": "10%"
              }, {
                  "data": "qtyTerima",
                  "width": "5%"
              }, {
                  "data": "status",
                  "width": "10%"
              }, {
                  "data": "action",
                  "width": "5%"
              }
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

  function detailMasukPeritem(id) {
      $.ajax({
          url: baseUrl + "/purchasing/orderpembelian/get-penerimaan-peritem/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
              var key = 1;
              var dateCreated = data.header[0].d_pcs_date_created;
              var newDateCreated = dateCreated.split("-").reverse().join("-");
              //ambil data ke json->modal
              $('#lblHeadItem').text('( ' + data.isi[0].i_code + ' ' + data.isi[0].i_name + ' )');
              $('#lblHeadPo').text(data.header[0].d_pcs_code);
              $('#lblHeadQty').text(data.header[0].d_pcsdt_qty);
              $('#lblHeadTglPo').text(data.header[0].d_pcs_date_created);
              $('#lblHeadSup').text(data.header[0].s_company);
              //loop data
              Object.keys(data.isi).forEach(function() {
                  $('#tabel-detail-peritem').append('<tr class="tbl_modal_detailmsk_row">' +
                      '<td>' + key + '</td>' +
                      '<td>' + data.isi[key - 1].i_code + ' ' + data.isi[key - 1].i_name + '</td>' +
                      '<td>' + data.isi[key - 1].m_sname + '</td>' +
                      '<td>' + data.isi[key - 1].d_tbdt_qty + '</td>' +
                      '<td>' + data.isi[key - 1].d_tb_code + '</td>' +
                      '<td>' + data.tanggalTerima[key - 1] + '</td>' +
                      '</tr>');
                  key++;
              });
              $('#modal_detail_peritem').modal('show');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error get data from ajax');
          }
      });
  }

  function editOrder(id) {
      $('#append-modal-edit div').remove();
      $.ajax({
          url: baseUrl + "/purchasing/orderpembelian/get-edit-order/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
              var totalHarga = 0;
              var key = 1;
              i = randString(5);
              $('#txt_span_status_edit').text(data.spanTxt);
              $("#txt_span_status_edit").addClass('label' + ' ' + data.spanClass);
              $('#id_purchase_edit').val(data.header[0].d_pcs_id);
              $('#lblNoOrderEdit').text(data.header[0].d_pcs_code);
              $('#lblCaraBayarEdit').text(data.header[0].d_pcs_method);
              $('#lblTglOrderEdit').text(data.header[0].d_pcs_date_created);
              $('#lblStaffEdit').text(data.header[0].m_name);
              var tglPenerimaan = data.header[0].d_pcs_date_received;
              if (tglPenerimaan == null) {
                  $('#lblTglKirimEdit').text('Belum di terima');
              } else {
                  $('#lblTglKirimEdit').text(data.header[0].d_pcs_date_received);
              }
              $('#lblSupplierEdit').text(data.header[0].s_company);
              $('#total_gross').val(convertDecimalToRupiah(data.header[0].d_pcs_total_gross))
              $('#potongan_harga').val(convertDecimalToRupiah(data.header[0].d_pcs_discount))
              $('#diskon_harga').val(data.header[0].d_pcs_disc_percent + '%')
              $('#ppn_harga').val(data.header[0].d_pcs_tax_percent + '%')
              $('#total_nett').val(convertDecimalToRupiah(data.header[0].d_pcs_total_net))
              $('#batasPlafon').val(data.batasPlafonRp)
              if (data.header[0].d_pcs_method != "CASH") {
                  $('#append-modal-edit div').remove();
                  var metode = data.header[0].d_pcs_method;
                  if (metode == "DEPOSIT") {
                      $('#append-modal-edit div').remove();
                      $('#append-modal-edit').append('<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<label class="tebal">Batas Terakhir Pengiriman</label>' +
                          '</div>' +
                          '<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<div class="form-group">' +
                          '<label id="dueDate">' + data.header[0].d_pcs_duedate + '</label>' +
                          '</div>' +
                          '</div>');
                  } else if (metode == "CREDIT") {
                      $('#append-modal-edit div').remove();
                      $('#append-modal-edit').append('<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<label class="tebal">TOP (Termin Of Payment)</label>' +
                          '</div>' +
                          '<div class="col-md-3 col-sm-12 col-xs-12">' +
                          '<div class="form-group">' +
                          '<label id="dueDate">' + data.header[0].d_pcs_duedate + '</label>' +
                          '</div>' +
                          '</div>');
                  }
              }
              //loop data
              Object.keys(data.data_isi).forEach(function() {
                  var qtyCost = data.data_isi[key - 1].d_pcsdt_qty;
                  $('#tabel-edit').append(
                      '<tr class="tbl_modal_edit_row">' +
                      '<td style="text-align:center">' + key + '</td>' +
                      '<td>' +
                      '<input type="text" value="' + data.data_isi[key - 1].i_code + ' | ' + data.data_isi[key - 1].i_name + '" name="fieldNamaItem[]" class="form-control input-sm" readonly/>' +
                      '<input type="hidden" value="' + data.data_isi[key - 1].i_id + '" name="fieldItemId[]" class="form-control input-sm"/>' +
                      '<input type="hidden" value="' + data.data_isi[key - 1].d_pcsdt_id + '" name="fieldIdPurchaseDt[]" class="form-control input-sm"/>' +
                      '<input type="hidden" value="' + data.data_isi[key - 1].d_pcsdt_idpdt + '" name="fieldIdPlanDt[]" class="form-control input-sm"/>' +
                      '</td>' +
                      '<td>' +
                      '<input type="text" value="' + separatorRibuan(qtyCost) + '" name="fieldQtyTxt[]" class="form-control input-sm" id="qtytxt_' + i + '" readonly style="text-align:right;"/>' +
                      '<input type="hidden" value="' + qtyCost + '" name="fieldQty[]" class="form-control input-sm" id="qty_' + i + '"/>' +
                      '</td>' +
                      '<td>' +
                      '<input type="text" value="' + data.data_isi[key - 1].s_name + '" name="fieldSatuan[]" class="form-control input-sm" readonly/>' +
                      '</td>' +
                      '<td>' +
                      '<input type="text" value="' + data.data_isi[key - 1].d_pcsdt_prevcost + '" name="fieldHargaPrev[]" class="form-control input-sm currency" readonly style="text-align:right;"/>' +
                      '</td>' +
                      '<td>' +
                      '<input type="text" value="' + data.data_isi[key - 1].d_pcsdt_price + '" name="fieldHarga[]" id="' + i + '" class="form-control input-sm field_harga currency" style="text-align:right;"/>' +
                      '</td>' +
                      '<td>' +
                      '<input type="text" value="' + data.data_isi[key - 1].d_pcsdt_total + '" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem currency" id="total_' + i + '" readonly style="text-align:right;"/>' +
                      '</td>' +
                      '<td>' +
                      '<input type="text" value="' + formatAngka(data.data_stok[key - 1].qtyStok) + ' ' + data.data_satuan[key - 1] + '" name="fieldStok[]" class="form-control input-sm" readonly style="text-align:right;"/>' +
                      '</td>' +
                      '<td>' +
                      '<button name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm">X</button>' +
                      '</td>' +
                      '</tr>');
                  i = randString(5);
                  key++;
              });
              $(this).maskFunc();
              $('#modal-edit').modal('show');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error get data from ajax');
          }
      });
  }

  function submitEdit() {
      iziToast.question({
          timeout: 20000,
          close: false,
          overlay: true,
          displayMode: 'once',
          title: 'Ubah Status',
          message: 'Apakah anda yakin ?',
          position: 'center',
          buttons: [
              ['<button><b>Ya</b></button>', function(instance, toast) {
                  $.ajax({
                      url: baseUrl + "/purchasing/orderpembelian/update-data-order",
                      type: "post",
                      dataType: "JSON",
                      data: $('#form-edit-order').serialize(),
                      success: function(response) {
                          if (response.status == "sukses") {
                              instance.hide({
                                  transitionOut: 'fadeOut'
                              }, toast, 'button');
                              iziToast.success({
                                  position: 'center',
                                  title: 'Pemberitahuan',
                                  message: response.pesan,
                                  onClosing: function(instance, toast, closedBy) {
                                      $('#btn_update').text('Update');
                                      $('#btn_update').attr('disabled', false);
                                      $('#modal-edit').modal('hide');
                                      $('#tbl-index').DataTable().ajax.reload();
                                  }
                              });
                          } else {
                              instance.hide({
                                  transitionOut: 'fadeOut'
                              }, toast, 'button');
                              iziToast.error({
                                  position: 'center',
                                  title: 'Pemberitahuan',
                                  message: response.pesan,
                                  onClosing: function(instance, toast, closedBy) {
                                      $('#btn_update').text('Update');
                                      $('#btn_update').attr('disabled', false);
                                      $('#modal-edit').modal('hide');
                                      $('#tbl-index').DataTable().ajax.reload();
                                  }
                              });
                          }
                      },
                      error: function() {
                          iziToast.warning({
                              icon: 'fa fa-times',
                              message: 'Terjadi Kesalahan!'
                          });
                      },
                      async: false
                  });
              }, true],
              ['<button>Tidak</button>', function(instance, toast) {
                  instance.hide({
                      transitionOut: 'fadeOut'
                  }, toast, 'button');
              }],
          ]
      });
  }

  function deleteOrder(idPo, idPlan) {
      iziToast.question({
          close: false,
          overlay: true,
          displayMode: 'once',
          //zindex: 999,
          title: 'Hapus data PO',
          message: 'Apakah anda yakin ?',
          position: 'center',
          buttons: [
              ['<button><b>Ya</b></button>', function(instance, toast) {
                  $.ajax({
                      url: baseUrl + "/purchasing/orderpembelian/delete-data-order",
                      type: "POST",
                      dataType: "JSON",
                      data: {
                          idPo: idPo,
                          idPlan: idPlan,
                          "_token": "{{ csrf_token() }}"
                      },
                      success: function(response) {
                          if (response.status == "sukses") {
                              instance.hide({
                                  transitionOut: 'fadeOut'
                              }, toast, 'button');
                              iziToast.success({
                                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                  title: 'Pemberitahuan',
                                  message: response.pesan,
                                  onClosing: function(instance, toast, closedBy) {
                                      $('#tbl-index').DataTable().ajax.reload();
                                  }
                              });
                          } else {
                              instance.hide({
                                  transitionOut: 'fadeOut'
                              }, toast, 'button');
                              iziToast.error({
                                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                  title: 'Pemberitahuan',
                                  message: response.pesan,
                                  onClosing: function(instance, toast, closedBy) {
                                      $('#tbl-index').DataTable().ajax.reload();
                                  }
                              });
                          }
                      },
                      error: function() {
                          instance.hide({
                              transitionOut: 'fadeOut'
                          }, toast, 'button');
                          iziToast.warning({
                              icon: 'fa fa-times',
                              message: 'Terjadi Kesalahan!'
                          });
                      },
                      async: false
                  });
              }, true],
              ['<button>Tidak</button>', function(instance, toast) {
                  instance.hide({
                      transitionOut: 'fadeOut'
                  }, toast, 'button');
              }],
          ]
      });
  }

  function randString(angka) {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (var i = 0; i < angka; i++)
          text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
  }

  function convertDecimalToRupiah(decimal) {
      var angka = parseInt(decimal);
      var rupiah = '';
      var angkarev = angka.toString().split('').reverse().join('');
      for (var i = 0; i < angkarev.length; i++)
          if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
      var hasil = 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
      return hasil + ',00';
  }

  function convertIntToRupiah(angka) {
      var rupiah = '';
      var angkarev = angka.toString().split('').reverse().join('');
      for (var i = 0; i < angkarev.length; i++)
          if (i % 3 == 0)
              rupiah += angkarev.substr(i, 3) + '.';
      var hasil = 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
      return hasil + ',00';
  }

  function totalPembelianGross() {
      var inputs = document.getElementsByClassName('hargaTotalItem'),
          hasil = [].map.call(inputs, function(input) {
              if (input.value == '') input.value = 0;
              return input.value;
          });
      console.log(hasil);
      var total = 0;
      for (var i = hasil.length - 1; i >= 0; i--) {

          hasil[i] = convertToAngka(hasil[i]);
          hasil[i] = parseInt(hasil[i]);
          total = total + hasil[i];
      }
      if (isNaN(total)) {
          total = 0;
      }
      total = convertToRupiah(total);
      // console.log(total);
      $('[name="totalGrossEdit"]').val(total);
  }

  function totalPembelianNett() {
      var totalGross = convertToAngka($('#total_gross').val());
      var potongan = convertToAngka($('#potongan_harga').val());
      var disc = convertDiscToAngka($('#diskon_harga').val());
      var tax = convertDiscToAngka($('#ppn_harga').val());
      var discValue = totalGross * disc / 100;
      //var taxValue = totalGross * tax / 100;
      //hitung total pembelian nett
      var hasilNett = (parseInt(totalGross) - parseInt(potongan + discValue));
      var taxValue = hasilNett * tax / 100;
      var finalValue = parseInt(hasilNett + taxValue);
      // $('#total_nett').val(convertToRupiah(finalValue));
      // var hasilNett = (parseInt(totalGross) - (parseInt(potongan + discValue)) + taxValue);
      $('[name="totalNettEdit"]').val(convertToRupiah(finalValue));
  }

  function convertToRupiah(angka) {
      var rupiah = '';
      var angkarev = angka.toString().split('').reverse().join('');
      for (var i = 0; i < angkarev.length; i++)
          if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
      var hasil = 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
      return hasil + ',00';
  }

  function convertToAngka(rupiah) {
      return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertDiscToAngka(disc) {
      return parseInt(disc.replace('%', ''), 10);
  }

  function refreshTabelIndex() {
      $('#tbl-index').DataTable().ajax.reload();
  }

  function separatorRibuan(num) {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      return num_parts.join(".");
  }

  function separatorRibuanRp(num) {
      var num_parts = num.toString().split(".");
      num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      return 'Rp. ' + num_parts.join(",");
  }

  function formatAngka(decimal) {
      var angka = parseInt(decimal);
      var fAngka = '';
      var angkarev = angka.toString().split('').reverse().join('');
      for (var i = 0; i < angkarev.length; i++) {
          if (i % 3 == 0) fAngka += angkarev.substr(i, 3) + '.';
      }
      var hasil = fAngka.split('', fAngka.length - 1).reverse().join('');
      return hasil;
  }
</script>
@endsection