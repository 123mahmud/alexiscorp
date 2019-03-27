@extends('main')
@section('content')
<article class="content">
   <div class="title-block text-primary">
      <h1 class="title"> Tambah Order Pembelian </h1>
      <p class="title-description">
         <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
         / <span>Purchasing</span>
         / <a href="{{route('orderpembelian')}}"><span>Order Pembelian</span></a>
         / <span class="text-primary font-weight-bold">Tambah Order Pembelian</span>
      </p>
   </div>
   <section class="section">
      <div class="row">
         <div class="col-12">
            
            <div class="card">
               <div class="card-header bordered p-2">
                  <div class="header-block">
                     <h3 class="title"> Tambah Order Pembelian </h3>
                  </div>
                  <div class="header-block pull-right">
                     <a href="{{route('orderpembelian')}}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i></a>
                  </div>
               </div>
               <form id="form_purchase_order">
                  
                  <div class="card-block">
                     <section>
                        <fieldset>
                           <div class="row">
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <label>No Order Pembelian</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" readonly="" name="" placeholder="( Auto )">
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <label>Staff</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <div class="form-group">
                                    <input type="hidden" value="{{ Auth::user()->id }}" name="po_officer">
                                    <input type="text" class="form-control form-control-sm" readonly="" value="{{ Auth::user()->name }}">
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <label>Tanggal Order Pembelian</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="po_tanggal">
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <label>Cara Bayar</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <div class="form-group">
                                    <select class="form-control form-control-sm" name="po_method">
                                       <option value="CASH">Tunai</option>
                                       <option value="DEPOSIT">Deposit</option>
                                       <option value="TEMPO">Tempo</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <label>Kode Rencana Pembelian</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <div class="form-group">
                                    <select class="form-control form-control-sm" name="po_purchase_plan" id="po_purchase_plan">
                                       <option value="">--Pilih--</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <label>Suplier</label>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                 <div class="form-group">
                                    <input type="hidden" name="po_supplier" id="po_supplier">
                                    <input type="text" id="po_supplier_label" class="form-control form-control-sm" readonly>
                                 </div>
                              </div>
                           </div>
                        </fieldset>
                        <div class="table-responsive mt-3">
                           <table class="table table-bordered table-hover table-striped" id="table_purchase_order_dt" cellspacing="0">
                              <thead class="bg-primary">
                                 <tr>
                                    <th>Kode | Barang</th>
                                    <th width="10%">Qty</th>
                                    <th width="10%">Satuan</th>
                                    <th>Harga Prev</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                    <th width="10%">Stok Gudang</th>
                                    <th width="10%">Aksi</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                        <div class="row">
                           <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6 col-xs-12">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <label>Total Harga</label>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <input type="text" readonly="" class="text-right form-control form-control-sm" name="po_total_gross" id="po_total_gross">
                                    </div>
                                 </div>
                                 
                                 <div class="col-lg-12">
                                    <label>Potongan Harga</label>
                                 </div>
                                 
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <input type="text" class="text-right form-control form-control-sm" name="po_disc_value" id="po_disc_value">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <label>Diskon(%)</label>
                                 </div>
                                 
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <input type="number" class="text-right form-control form-control-sm" name="po_disc_percent" id="po_disc_percent">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <label>PPn(%)</label>
                                 </div>
                                 
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <input type="number" class="text-right form-control form-control-sm" name="po_tax_percent" id="po_tax_percent">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <label>Total</label>
                                 </div>
                                 
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <input type="text" readonly="" class="text-right form-control form-control-sm" name="po_total_net" id="po_total_net">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  </div>
               </form>
               <div class="card-footer text-right">
                  <button class="btn btn-primary" type="button" onclick="insert_purchase_order()">Simpan</button>
                  <a href="{{route('orderpembelian')}}" class="btn btn-secondary">Kembali</a>
               </div>
            </div>
         </div>
      </div>
   </section>
</article>

@endsection
@section('extra_script')
<script type="text/javascript">
   $(document).ready(function() {
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

           $('.datepicker').datepicker({
               format: "mm-yyyy",
               viewMode: "months",
               minViewMode: "months"
           });

           $('.datepicker2').datepicker({
               format: "dd-mm-yyyy",
               autoclose: true
           });

           //select2
           $("#cari_sup").select2({
               placeholder: "Pilih Supplier...",
               ajax: {
                   url: baseUrl + '/purchasing/rencanapembelian/get-supplierorder',
                   dataType: 'json',
                   data: function(params) {
                       return {
                           q: $.trim(params.term)
                       };
                   },
                   processResults: function(data) {
                       return {
                           results: data
                       };
                   },
                   cache: true
               },
           });


           $("#cari_kode_plan").select2({
               placeholder: "Pilih Kode Rencana...",
               ajax: {
                   url: baseUrl + '/purchasing/orderpembelian/get-data-rencana-beli',
                   dataType: 'json',
                   data: function(params) {
                       return {
                           q: $.trim(params.term)
                       };
                   },
                   processResults: function(data) {
                       return {
                           results: data
                       };
                   },
                   cache: true
               },
           });

           $('#cari_kode_plan').change(function() {
               //remove existing appending row
               $('tr').remove('.tbl_form_row');
               var id = $(this).val();
               $.ajax({
                   url: baseUrl + "/purchasing/orderpembelian/get-data-form/" + id,
                   type: "GET",
                   dataType: "JSON",
                   success: function(data) {
                       //object to store select2 data
                       var dataSelect = {
                           id: data.data_header[0].s_id,
                           text: data.data_header[0].s_company
                       };

                       if ($('#cari_sup').find("option[value='" + dataSelect.id + "']").length) {
                           $('#cari_sup').val(dataSelect.id).trigger('change');
                       } else {
                           // Create a DOM Option and pre-select by default
                           var newOption = new Option(dataSelect.text, dataSelect.id, true, true);
                           // Append it to the select
                           $('#cari_sup').append(newOption).trigger('change');
                       }

                       // $('#plafon').val(data.plafonRp);
                       // $('#batasPlafon').val(data.batasPlafonRp);
                       // $('#jatuhTempo').val(data.jatuhTempo);

                       var totalHarga = 0;
                       var key = 1;
                       i = randString(5);
                       //loop data
                       Object.keys(data.data_isi).forEach(function() {
                           var qtyCost = data.data_isi[key - 1].ppdt_qtyconfirm;
                           $('#tabel-form-po').append(
                               '<tr class="tbl_form_row" id="row' + i + '">' +
                               '<td style="text-align:center">' + key + '</td>' +
                               '<td>' +
                               '<input type="text" value="' + data.data_isi[key - 1].i_code + ' | ' + data.data_isi[key - 1].i_name + '" name="fieldNamaItem[]" class="form-control input-sm" readonly/>' +
                               '<input type="hidden" value="' + data.data_isi[key - 1].i_id + '" name="fieldItemId[]" class="form-control input-sm"/>' +
                               '<input type="hidden" value="' + data.data_isi[key - 1].p_id + '" name="fieldidPlanDt[]" class="form-control input-sm"/>' +
                               '</td>' +
                               '<td>' +
                               '<input type="text" value="' + separatorRibuan(qtyCost) + '" name="fieldQtyTxt[]" class="form-control input-sm" id="qtytxt_' + i + '" readonly style="text-align:right;"/>' +
                               '<input type="hidden" value="' + qtyCost + '" name="fieldQty[]" class="form-control input-sm" id="qty_' + i + '"/>' +
                               '</td>' +
                               '<td>' +
                               '<input type="text" value="' + data.data_isi[key - 1].s_name + '" name="fieldSatuan[]" class="form-control input-sm" readonly/>' +
                               '<input type="hidden" value="' + data.data_isi[key - 1].s_id + '" name="fieldIdSatuan[]" class="form-control input-sm" readonly/>' +
                               '</td>' +
                               '<td>' +
                               '<input type="text" value="' + data.data_isi[key - 1].ppdt_prevcost + '" name="fieldHargaPrev[]" class="form-control input-sm currency" readonly style="text-align:right;"/></td>' +
                               '<td>' +
                               '<input type="text" value="' + data.data_isi[key - 1].ppdt_prevcost + '" name="fieldHarga[]" id="' + i + '" class="form-control input-sm field_harga currency" style="text-align:right;"/>' +
                               '</td>' +
                               '<td>' +
                               '<input type="text" value="' + data.data_isi[key - 1].ppdt_prevcost * qtyCost + '" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem currency" id="total_' + i + '" readonly style="text-align:right;"/>' +
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
                       //set readonly to enabled
                       $('#potongan_harga').attr('readonly', false);
                       $('#diskon_harga').attr('readonly', false);
                       $('#ppn_harga').attr('readonly', false);
                       totalPembelianGross();
                       totalPembelianNett();
                       $(this).maskFunc();
                   },
                   error: function(jqXHR, textStatus, errorThrown) {
                       alert('Error get data from ajax');
                   }
               });
           });

           $(document).on('click', '.btn_remove', function() {
               var button_id = $(this).attr('id');
               $('#row' + button_id + '').remove();
               totalPembelianGross();
               totalPembelianNett();
           });

           //event focus on input harga
           $(document).on('focus', '.field_harga', function(e) {
               $('#button_save').attr('disabled', true);
           });

           $(document).on('focus', '#potongan_harga', function(e) {
               $(this).val("");
               $('#button_save').attr('disabled', true);
           });

           $(document).on('focus', '#diskon_harga', function(e) {
               $(this).val("");
               $('#button_save').attr('disabled', true);
           });

           $(document).on('focus', '#ppn_harga', function(e) {
               $(this).val("");
               $('#button_save').attr('disabled', true);
           });

           //event onblur input harga
           $(document).on('blur', '.field_harga', function(e) {
               if ($(this).val() == "") {
                   $(this).val(0)
               };
               //get data
               var getid = $(this).attr("id");
               var harga = $(this).val();
               var qtyOrder = $('#qty_' + getid + '').val();
               //hitung nilai harga total
               harga = harga.replace('.', '');
               var valueHargaTotal = parseInt(qtyOrder) * parseFloat(harga.replace(',', '.'));
               $('#total_' + getid + '').val(valueHargaTotal);
               //console.log(valueHargaTotal);
               // panggl fungsi
               totalPembelianGross();
               totalPembelianNett();
               $('#button_save').attr('disabled', false);
           });

           //event onblur potongan harga
           $(document).on('blur', '#potongan_harga', function(e) {
               if ($(this).val() == "") {
                   $(this).val(0)
               };
               //ubah format ke rupiah
               var potonganRp = convertToRupiah($(this).val());
               $(this).val(potonganRp);
               totalPembelianNett();
               $('#button_save').attr('disabled', false);
           });

           //event onblur diskon
           $(document).on('blur', '#diskon_harga', function(e) {
               if ($(this).val() == "") {
                   $(this).val(0)
               };
               //ubah format ke diskon
               var discSimbol = $(this).val();
               $(this).val(discSimbol + '%');
               totalPembelianNett();
               $('#button_save').attr('disabled', false);
           });

           //event onblur ppn
           $(document).on('blur', '#ppn_harga', function(e) {
               if ($(this).val() == "") {
                   $(this).val(0)
               };
               //ubah format ke diskon
               var ppnSimbol = $(this).val();
               $(this).val(ppnSimbol + '%');
               totalPembelianNett();
               $('#button_save').attr('disabled', false);
           });

           //force integer input in textfield
           $('.numberinput').bind('keypress', function(e) {
               return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
           });

           //validasi
           $("#form_create_po").validate({
               rules: {
                   tanggal: "required",
                   method_bayar: "required",
                   cariSup: "required",
                   cariKodePlan: "required"
               },
               errorPlacement: function() {
                   return false;
               },
               submitHandler: function(form) {
                   form.submit();
               }
           });

           $('#cari_sup').change(function(event) {
               if ($(this).val() != "") {
                   $('#divSelectSup').removeClass('has-error').addClass('has-valid');
               } else {
                   $('#divSelectSup').addClass('has-error').removeClass('has-valid');
               }
           });

           $('#cari_kode_plan').change(function(event) {
               if ($(this).val() != "") {
                   $('#divSelectPlan').removeClass('has-error').addClass('has-valid');
               } else {
                   $('#divSelectPlan').addClass('has-error').removeClass('has-valid');
               }
           });
           //end jquery
       });


       function convertDecimalToRupiah(decimal) {
           var angka = parseInt(decimal);
           var rupiah = '';
           var angkarev = angka.toString().split('').reverse().join('');
           for (var i = 0; i < angkarev.length; i++)
               if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
           var hasil = 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
           return hasil + ',00';
       }

       function randString(angka) {
           var text = "";
           var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

           for (var i = 0; i < angka; i++)
               text += possible.charAt(Math.floor(Math.random() * possible.length));

           return text;
       }

       function convertToRupiah(angka) {
           var rupiah = '';
           var angkarev = angka.toString().split('').reverse().join('');
           for (var i = 0; i < angkarev.length; i++)
               if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
           var hasil = rupiah.split('', rupiah.length - 1).reverse().join('');
           return hasil + ',00';
       }

       function convertToAngka(rupiah) {
           return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
       }

       function convertDiscToAngka(disc) {
           return parseInt(disc.replace('%', ''), 10);
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
           $('[name="totalGross"]').val(total);
       }

       function totalPembelianNett() {
           var totalGross = convertToAngka($('#total_gross').val());
           var potongan = convertToAngka($('#potongan_harga').val());
           if (isNaN(potongan)) {
               potongan = 0;
           }
           var disc = convertDiscToAngka($('#diskon_harga').val());
           if (isNaN(disc)) {
               disc = 0;
           }
           var tax = convertDiscToAngka($('#ppn_harga').val());
           var discValue = totalGross * disc / 100;
           //hitung total pembelian nett
           var hasilNett = (parseInt(totalGross) - parseInt(potongan + discValue));
           var taxValue = hasilNett * tax / 100;
           var finalValue = parseInt(hasilNett + taxValue);
           $('#total_nett').val(convertToRupiah(finalValue));
       }

       function simpanPo() {
           var IsValid = $("form[name='formCreatePo']").valid();
           if (IsValid) {
               var countRow = $('#tabel-form-po tr').length;
               (countRow > 1);
               if (countRow > 1) {
                   // alert('kl')
                   $('#divSelectSup').removeClass('has-error');
                   $('#divSelectPlan').removeClass('has-error');
                   $('#button_save').text('Menyimpan...');
                   $('#button_save').attr('disabled', 'disabled');
                   $.ajax({
                       url: baseUrl + "/purcahse-order/save-po",
                       type: "get",
                       dataType: "JSON",
                       data: $('#form_create_po').serialize(),
                       success: function(response) {
                           if (response.status == "sukses") {
                               iziToast.success({
                                   position: 'center',
                                   title: 'Pemberitahuan',
                                   message: 'Data Sukses Tersimpan !',
                                   onClosing: function(instance, toast, closedBy) {
                                       $('#button_save').text('Simpan Data');
                                       $('#button_save').removeAttr('disabled', 'disabled');
                                   }
                               });
                               window.location.href = baseUrl + "/purcahse-order/order-index";
                           } else {
                               $('#button_save').text('Simpan Data');
                               $('#button_save').removeAttr('disabled', 'disabled');
                               iziToast.error({
                                   position: 'center',
                                   title: 'Pemberitahuan',
                                   message: "Data Gagal disimpan !",
                                   onClosing: function(instance, toast, closedBy) {

                                       // window.location.href = baseUrl+"/purchasing/rencanapembelian/rencana";
                                   }

                               });
                           }
                       },
                       error: function(jqXHR, textStatus, errorThrown) {
                           $('#button_save').text('Simpan Data');
                           $('#button_save').removeAttr('disabled', 'disabled');
                           iziToast.error({
                               position: 'topRight',
                               title: 'Pemberitahuan',
                               message: "Data gagal disimpan !"
                           });
                       }
                   });
               } else {
                   iziToast.warning({
                       position: 'center',
                       message: "Mohon isi data pada tabel form !"
                   });
               }
           } else //else validation
           {
               iziToast.warning({
                   position: 'center',
                   message: "Mohon Lengkapi data form !",
                   onClosing: function(instance, toast, closedBy) {
                       $('#divSelectSup').addClass('has-error');
                       $('#divSelectPlan').addClass('has-error');
                   }
               });
           }
       }

       function separatorRibuan(num) {
           var num_parts = num.toString().split(".");
           num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
           return num_parts.join(",");
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
   });
</script>

@endsection