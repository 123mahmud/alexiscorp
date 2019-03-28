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
               <form id="form_create_po" name="formCreatePo">
                  
                  <div class="card-block">
                     <section>
                        <fieldset>
                           <div class="row">
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <label class="tebal">No PO</label>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" readonly="" class="form-control form-control-sm" name="kodePo" placeholder="(Auto)">
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <label class="tebal">Staff</label>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" readonly="" class="form-control form-control-sm" name="namaStaff" value="{{Auth::user()->m_name}}">
                                    <input type="hidden" readonly="" class="form-control form-control-sm" name="idStaff" value="{{Auth::user()->m_id}}">
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <label class="tebal">Tanggal Order Pembelian</label>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <input id="tanggalPo" class="form-control form-control-sm datepicker2 " name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <label class="tebal">Cara Pembayaran</label>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <select class="form-control form-control-sm" name="methodBayar" id="method_bayar">
                                       <option value="CASH">Tunai</option>
                                       <option value="CREDIT">Tempo</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <label class="tebal">Kode Rencana</label>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <div class="form-group" id="divSelectPlan">
                                    <select class="form-control form-control-sm" id="cari_kode_plan" name="cariKodePlan" style="width: 100%;">
                                       <option value=""> - Pilih Kode Rencana</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <label class="tebal">Suplier</label>
                              </div>
                              <div class="col-md-3 col-sm-12 col-xs-12">
                                 <div class="form-group" id="divSelectSup">
                                    <select class="form-control form-control-sm" id="cari_sup" name="cariSup" style="width: 100%;">
                                       <option value=""> - Pilih Supplier</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </fieldset>
                        <div class="table-responsive mt-3">
                           <table class="table table-bordered table-hover table-striped" id="tabel-form-po" cellspacing="0">
                              <thead class="bg-primary">
                                 <tr>
                                    <th style="text-align: center;" width="5%">No</th>
                                    <th width="16%">Kode | Barang</th>
                                    <th width="7%">Qty</th>
                                    <th width="7%">Satuan</th>
                                    <th width="12%">Harga Satuan</th>
                                    <th width="12%">Harga Prev</th>
                                    <th width="15%">Total</th>
                                    {{-- <th width="15%">Total Net</th> --}}
                                    <th width="6%">Stok Gudang</th>
                                    <th style="text-align: center;" width="5%">Aksi</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                        <div class="row">
                           <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6 col-xs-12">
                              <div class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="tebal">Total Harga</label>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" id="total_gross" class="form-control-sm form-control" name="totalGross" readonly style="text-align:right;">
                                    </div>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="tebal">Potongan Harga</label>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" class="form-control-sm form-control currency" style="text-align:right;" id="potongan_harga" name="potonganHarga" readonly>
                                    </div>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="tebal">Diskon</label>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" class="form-control-sm form-control numberinput" id="diskon_harga" name="diskonHarga" readonly style="text-align:right;" value="0%">
                                    </div>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="tebal">PPN</label>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" class="form-control-sm form-control numberinput" id="ppn_harga" name="ppnHarga" readonly style="text-align:right;" value="0%">
                                    </div>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="tebal">Total</label>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" readonly="" class="form-control-sm form-control" id="total_nett" name="totalNett" style="text-align:right;">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  </div>
               
               <div class="card-footer text-right">
                  <button class="btn btn-primary" type="button" id="button_save" onclick="simpanPo()">Simpan</button>
                  <a href="{{route('orderpembelian')}}" class="btn btn-secondary">Kembali</a>
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
   $(document).ready(function() {
        //fix to issue select2 on modal when opening in firefox
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        var extensions = {
                "sFilterInput": "form-control form-control-sm",
                "sLengthSelect": "form-control form-control-sm"
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
                            '<input type="text" value="' + data.data_isi[key - 1].i_code + ' | ' + data.data_isi[key - 1].i_name + '" name="fieldNamaItem[]" class="form-control form-control-sm" readonly/>' +
                            '<input type="hidden" value="' + data.data_isi[key - 1].i_id + '" name="fieldItemId[]" class="form-control form-control-sm"/>' +
                            '<input type="hidden" value="' + data.data_isi[key - 1].p_id + '" name="fieldidPlanDt[]" class="form-control form-control-sm"/>' +
                            '</td>' +
                            '<td>' +
                            '<input type="text" value="' + separatorRibuan(qtyCost) + '" name="fieldQtyTxt[]" class="form-control form-control-sm" id="qtytxt_' + i + '" readonly style="text-align:right;"/>' +
                            '<input type="hidden" value="' + qtyCost + '" name="fieldQty[]" class="form-control form-control-sm" id="qty_' + i + '"/>' +
                            '</td>' +
                            '<td>' +
                            '<input type="text" value="' + data.data_isi[key - 1].s_name + '" name="fieldSatuan[]" class="form-control form-control-sm" readonly/>' +
                            '<input type="hidden" value="' + data.data_isi[key - 1].s_id + '" name="fieldIdSatuan[]" class="form-control form-control-sm" readonly/>' +
                            '</td>' +
                            '<td>' +
                            '<input type="text" value="' + data.data_isi[key - 1].ppdt_prevcost + '" name="fieldHargaPrev[]" class="form-control form-control-sm currency" readonly style="text-align:right;"/></td>' +
                            '<td>' +
                            '<input type="text" value="' + data.data_isi[key - 1].ppdt_prevcost + '" name="fieldHarga[]" id="' + i + '" class="form-control form-control-sm field_harga currency" style="text-align:right;"/>' +
                            '</td>' +
                            '<td>' +
                            '<input type="text" value="' + data.data_isi[key - 1].ppdt_prevcost * qtyCost + '" name="fieldHargaTotal[]" class="form-control form-control-sm hargaTotalItem currency" id="total_' + i + '" readonly style="text-align:right;"/>' +
                            '</td>' +
                            '<td>' +
                            '<input type="text" value="' + formatAngka(data.data_stok[key - 1].qtyStok) + ' ' + data.data_satuan[key - 1] + '" name="fieldStok[]" class="form-control form-control-sm" readonly style="text-align:right;"/>' +
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

    function simpanPo() 
    {
        $('#divSelectSup').removeClass('has-error');
        $('#divSelectPlan').removeClass('has-error');
        $('#button_save').text('Menyimpan...');
        $('#button_save').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + '/purcahse-order/save-po',
            type: 'GET',
            data: $('#form_create_po').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == 'sukses') {
                    var nota = response.nota;
                    $.toast({
                        heading: nota,
                        text: 'Berhasil di Simpan',
                        bgColor: '#00b894',
                        textColor: 'white',
                        loaderBg: '#55efc4',
                        icon: 'success'
                    });
                    $('#button_save').text('Simpan Data');
                    $('#button_save').removeAttr('disabled', 'disabled');
                    window.location.href = baseUrl + "/purcahse-order/order-index";
                } else {
                    $.toast({
                        heading: '',
                        text: 'Ada yang salah',
                        showHideTransition: 'plain',
                        icon: 'warning'
                    })
                    $('#button_save').text('Simpan Data');
                    $('#button_save').removeAttr('disabled', 'disabled');
                }
            }
        });
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
</script>

@endsection