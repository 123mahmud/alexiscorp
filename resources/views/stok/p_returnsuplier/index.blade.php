@extends('main')
@section('content')
<style type="text/css">
.ui-autocomplete { z-index:2147483647; }
.error { border: 1px solid #f00; }
.valid { border: 1px solid #8080ff; }
.has-error .select2-selection {
border: 1px solid #f00 !important;
}
.has-valid .select2-selection {
border: 1px solid #8080ff !important;
}
</style>
<!--BEGIN PAGE WRAPPER-->
<article class="content">
    <div class="title-block text-primary">
        <h1 class="title"> Penerimaan Barang Return Supplier </h1>
        <p class="title-description">
            <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
            / <span>Stok</span>
            / <span class="text-primary font-weight-bold">Penerimaan Barang Return Supplier</span>
        </p>
    </div>
    <section class="section">
        <ul class="nav nav-pills">
            
            <ul id="generalTab" class="nav nav-tabs">
                <li class="nav-item active"><a data-target="#index-tab" href="#" class="nav-link active" aria-controls="index-tab" data-toggle="tab">Daftar Terima Return</a></li>
                <li class="nav-item"><a data-target="#wait-tab" href="#" class="nav-link" aria-controls="wait-tab" data-toggle="tab" onclick="listWaitingByTgl()">Daftar Tunggu</a></li>
                <li class="nav-item"><a data-target="#finish-tab" href="#" class="nav-link" aria-controls="finish-tab" data-toggle="tab" onclick="listReceivedByTgl()">Daftar Hasil Penerimaan</a></li>
            </ul>
            <div class="row">
                
                <div class="tab-content">
                    
                    @include('stok.p_returnsuplier.tab-index')
                    @include('stok.p_returnsuplier.tab-wait')
                    @include('stok.p_returnsuplier.tab-finish')
                </div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE-->
            <!-- modal -->
            <!--modal Tambah Terima-->
            @include('stok.p_returnsuplier.modal')
            @include('stok.p_returnsuplier.modal-detail')
            @include('stok.p_returnsuplier.modal-detail-peritem')
            <!-- /modal -->
        </section>
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

    $('.datepicker3').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true
    });

    //select2
    $("#head_nota_return").select2({
        placeholder: "Pilih Nota Return...",
        ajax: {
            url: baseUrl + '/inventory/p_returnsupplier/lookup-data-return',
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

    //event onchange select option
    $('#head_nota_return').change(function() {
        $('#appending div').remove();
        $('#btn_simpan').attr('disabled', false);
        //remove existing appending row
        $('tr').remove('.tbl_form_row');
        var idRtr = $('#head_nota_return').val();
        $.ajax({
            url: baseUrl + "/inventory/p_returnsupplier/get-data-form/" + idRtr,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                var totalRetur = data.data_header[0].d_pcsr_pricetotal;
                $('#head_nota_txt').val($('#head_nota_return').text());
                $('#head_method').val(data.data_header[0].d_pcsr_method);
                $('#head_supplier').val(data.data_header[0].s_company);
                $('#head_supplier_id').val(data.data_header[0].d_pcsr_supid);
                $('#head_total_retur').val(convertDecimalToRupiah(totalRetur));

                //persentase diskon berdasarkan total harga bruto
                var key = 1;
                i = randString(5);
                //loop data
                Object.keys(data.data_isi).forEach(function() {
                    var hargaTotalItem = data.data_isi[key - 1].d_pcsrdt_pricetotal;
                    var qtyCost = data.data_isi[key - 1].d_pcsrdt_qty;
                    var qtyTerima = data.data_qty[key - 1];
                    var hargaSatuanItemNet = hargaTotalItem / qtyCost;
                    var hargaTotalPerRow = hargaSatuanItemNet * qtyTerima;
                    //console.log(hargaSatuanItemNet);
                    $('#tabel-modal-terima').append(
                        '<tr class="tbl_form_row" id="row' + i + '">' +
                        '<td style="text-align:center">' +
                        key +
                        '</td>' +
                        '<td>' +
                        '<input type="text" value="' + data.data_isi[key - 1].i_code + ' | ' + data.data_isi[key - 1].i_name + '" name="fieldNamaItem[]" class="form-control input-sm" readonly/>' +
                        '<input type="hidden" value="' + data.data_isi[key - 1].i_id + '" name="fieldItemId[]" class="form-control input-sm"/>' +
                        '<input type="hidden" value="' + data.data_isi[key - 1].d_pcsrdt_id + '" name="fieldIdReturnDet[]" class="form-control input-sm"/>' +
                        '</td>' +
                        '<td>' +
                        '<input type="text" value="' + qtyCost + '" name="fieldQty[]" class="form-control numberinput input-sm field_qty" readonly/>' +
                        '</td>' +
                        '<td>' +
                        '<input type="text" value="' + qtyTerima + '" name="fieldQtyterima[]" class="form-control numberinput input-sm field_qty_terima" id="' + i + '"/>' +
                        '<input type="hidden" value="' + qtyTerima + '" name="fieldQtyterimaHidden[]" class="form-control numberinput input-sm" id="qtymskhidden_' + i + '"/>' +
                        '</td>' +
                        '<td>' +
                        '<input type="text" value="' + data.data_isi[key - 1].s_name + '" name="fieldSatuanTxt[]" class="form-control input-sm" readonly/>' +
                        '<input type="hidden" value="' + data.data_isi[key - 1].s_id + '" name="fieldSatuanId[]" class="form-control input-sm" readonly/>' +
                        '<input type="hidden" value="' + convertDecimalToRupiah(hargaSatuanItemNet) + '" name="fieldHarga[]" id="cost_' + i + '" class="form-control input-sm field_harga numberinput" readonly/>' +
                        '<input type="hidden" value="' + hargaSatuanItemNet + '" name="fieldHargaRaw[]" id="costRaw_' + i + '" class="form-control input-sm field_harga_raw numberinput" readonly/>' +
                        '<input type="hidden" value="' + convertDecimalToRupiah(hargaTotalPerRow) + '" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem" id="total_' + i + '" readonly/>' +
                        '<input type="hidden" value="' + hargaTotalPerRow + '" name="fieldHargaTotalRaw[]" id="totalRaw_' + i + '" class="form-control input-sm field_hargatotal_raw numberinput" readonly/>' +
                        '</td>' +
                        '<td>' +
                        '<input type="text" value="' + data.data_stok[key - 1].qtyStok + ' ' + data.data_satuan[key - 1] + '" name="fieldStokTxt[]" class="form-control input-sm" readonly/>' +
                        '<input type="hidden" value="' + data.data_stok[key - 1].qtyStok + '" name="fieldStokVal[]" class="form-control input-sm" readonly/>' +
                        '</td>' +
                        '<td>' +
                        '<button name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm">X</button>' +
                        '</td>' +
                        '</tr>'
                    );
                    i = randString(5);
                    key++;
                });
                totalNilaiPenerimaan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    });

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function(e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    //remove row in modal form
    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr('id');
        $('#row' + button_id + '').remove();
        totalNilaiPenerimaan();
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function() {
        $('#btn_simpan').attr('disabled', true);
        //remove append tr
        $('tr').remove('.tbl_form_row');
        $('tr').remove('.tbl_modal_detail_row');
        $('tr').remove('.tbl_modal_detailmsk_row');
        //reset all input txt field
        $('#form-terima-return')[0].reset();
        //empty select2 field
        $('#head_nota_return').empty();
        //set datepicker to today 
        $('.datepicker2').datepicker('setDate', 'today');
        //remove class all jquery validation error
        $('.form-group').find('.error').removeClass('error');
        $('.form-group').removeClass('has-valid has-error');
    });

    //event focus on input qty
    $(document).on('focus', '.field_qty_terima', function(e) {
        var qty = $(this).val();
        $(this).val(qty);
        $('#btn_simpan').attr('disabled', true);
    });

    $(document).on('blur', '.field_qty_terima', function(e) {
        var getid = $(this).attr("id");
        var qtyReturn = $(this).val();
        var cost = $('#costRaw_' + getid + '').val();
        var hasilTotal = parseInt(qtyReturn * cost);
        var hasilTotalRaw = parseFloat(qtyReturn * cost).toFixed(2);
        var totalCost = $('#total_' + getid + '').val(convertDecimalToRupiah(hasilTotal));
        var totalCostRaw = $('#totalRaw_' + getid + '').val(hasilTotalRaw);
        // $(this).val(potonganRp);
        totalNilaiPenerimaan();
        $('#btn_simpan').attr('disabled', false);
    });

    $(document).on('keyup', '.field_qty_terima', function(e) {
        var val = parseInt($(this).val());
        var getid = $(this).attr("id");
        var qtyRemain = $('#qtymskhidden_' + getid + '').val();
        console.log(getid);
        if (val > qtyRemain || $(this).val() == "" || val == 0) {
            $(this).val(qtyRemain);
        }
    });

    //validasi
    $("#form-terima-return").validate({
        rules: {
            headTglTerima: "required",
            headNotaReturn: "required",
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#head_nota_return').change(function(event) {
        if ($(this).val() != "") {
            $('#divSelectNota').removeClass('has-error').addClass('has-valid');
        } else {
            $('#divSelectNota').addClass('has-error').removeClass('has-valid');
        }
    });

    lihatTerimaRtrByTanggal();

    //end jquery
});

function lihatTerimaRtrByTanggal() {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-daftar').dataTable({
        "destroy": true,
        "processing": true,
        "serverside": true,
        "ajax": {
            url: baseUrl + "/inventory/p_returnsupplier/get-terimaretur-by-tgl/" + tgl1 + "/" + tgl2,
            type: 'GET'
        },
        "columns": [{
                "data": "DT_Row_Index",
                orderable: true,
                searchable: false,
                "width": "5%"
            }, //memanggil column row
            {
                "data": "tglMasuk",
                "width": "10%"
            }, {
                "data": "d_trs_code",
                "width": "10%"
            }, {
                "data": "m_name",
                "width": "10%"
            }, {
                "data": "s_company",
                "width": "20%"
            }, {
                "data": "d_pcsr_code",
                "width": "10%"
            }, {
                "data": "methodReturn",
                "width": "10%"
            }, {
                "data": "tglBuat",
                "width": "10%"
            }, {
                "data": "action",
                orderable: false,
                searchable: false,
                "width": "10%"
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

function totalNilaiPenerimaan() {
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
    $('#head_total_retur').val(total);
}

function randString(angka) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function detailPenerimaan(id) {
    $.ajax({
        url: baseUrl + "/inventory/p_returnsupplier/get-detail-penerimaan/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var key = 1;
            $('#lblNotaRetur').text(data.header[0].d_pcsr_code);
            $('#lblNotaPenerimaan').text(data.header[0].d_trs_code);
            $('#lblTglPenerimaan').text(data.header2.tanggalTerima);
            $('#lblStaff').text(data.header[0].m_name);
            $('#lblSupplier').text(data.header[0].s_company);

            //loop data
            Object.keys(data.data_isi).forEach(function() {
                $('#tabel-detail').append('<tr class="tbl_modal_detail_row">' +
                    '<td>' + key + '</td>' +
                    '<td>' + data.data_isi[key - 1].i_code + ' ' + data.data_isi[key - 1].i_name + '</td>' +
                    '<td>' + data.data_isi[key - 1].d_pcsrdt_qtyconfirm + '</td>' +
                    '<td>' + data.data_isi[key - 1].d_trsdt_qty + '</td>' +
                    '<td>' + data.data_isi[key - 1].s_name + '</td>'
                    // +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_tbdt_price)+'</td>'
                    // +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_tbdt_pricetotal)+'</td>'
                    +
                    '<td>' + data.data_stok[key - 1].qtyStok + ' ' + data.data_satuan[key - 1] + '</td>' +
                    '</tr>');
                key++;
            });
            $('#apdsfs').html('<a href="' + baseUrl + '/inventory/p_returnsupplier/print/' + id + '" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>' +
                '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
            $('#modal_detail').modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function detailListReceived(id) {
    $.ajax({
        url: baseUrl + "/inventory/p_returnsupplier/get-penerimaan-peritem/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            var key = 1;
            var dateCreated = data.header[0].d_pcsr_datecreated;
            var newDateCreated = dateCreated.split("-").reverse().join("-");
            //ambil data ke json->modal
            $('#lblHeadItem').text('( ' + data.isi[0].i_code + ' ' + data.isi[0].i_name + ' )');
            $('#lblHeadRetur').text(data.header[0].d_pcsr_code);
            $('#lblHeadQty').text(data.header[0].d_pcsrdt_qty);
            $('#lblHeadTglRetur').text(data.header[0].d_pcsr_datecreated);
            $('#lblHeadSup').text(data.header[0].s_company);
            //loop data
            Object.keys(data.isi).forEach(function() {
                $('#tabel-detail-peritem').append('<tr class="tbl_modal_detailmsk_row">' +
                    '<td>' + key + '</td>' +
                    '<td>' + data.isi[key - 1].i_code + ' ' + data.isi[key - 1].i_name + '</td>' +
                    '<td>' + data.isi[key - 1].s_name + '</td>' +
                    '<td>' + data.isi[key - 1].d_trsdt_qty + '</td>' +
                    '<td>' + data.isi[key - 1].d_trs_code + '</td>' +
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

function submitTerima() {
    iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Terima return dari supplier',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
            ['<button><b>Ya</b></button>', function(instance, toast) {
                var IsValid = $("form[name='formTerimaReturn']").valid();
                if (IsValid) {
                    var countRow = $('#div_item tr').length;
                    if (countRow > 0) {
                        $('#divSelectNota').removeClass('has-error');
                        $('#btn_simpan').text('Saving...');
                        $('#btn_simpan').attr('disabled', true);
                        $.ajax({
                            url: baseUrl + "/inventory/p_returnsupplier/simpan-penerimaan",
                            type: "GET",
                            dataType: "JSON",
                            data: $('#form-terima-return').serialize(),
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
                                            $('#btn_simpan').text('Submit'); //change button text
                                            $('#btn_simpan').attr('disabled', false); //set button enable
                                            $('#modal_terima_return').modal('hide');
                                            $('#tbl-daftar').DataTable().ajax.reload();
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
                                            $('#btn_simpan').text('Submit'); //change button text
                                            $('#btn_simpan').attr('disabled', false); //set button enable
                                            $('#modal_terima_return').modal('hide');
                                            $('#tbl-daftar').DataTable().ajax.reload();
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
                    } else {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');
                        iziToast.warning({
                            position: 'center',
                            message: "Mohon maaf, form pada tabel dilarang kosong !"
                        });
                    } //end check table form
                } else {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    iziToast.warning({
                        position: 'center',
                        message: "Mohon Lengkapi data form !",
                        onClosing: function(instance, toast, closedBy) {
                            $('#divSelectNota').addClass('has-error');
                        }
                    });
                } //end check valid
            }, true],
            ['<button>Tidak</button>', function(instance, toast) {
                instance.hide({
                    transitionOut: 'fadeOut'
                }, toast, 'button');
            }],
        ]
    });
}

function deletePenerimaan(id) {
    iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Hapus data Penerimaan Retur Supplier',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
            ['<button><b>Ya</b></button>', function(instance, toast) {
                $.ajax({
                    url: baseUrl + "/inventory/p_returnsupplier/delete-data-penerimaan",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
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
                                    $('#tbl-daftar').DataTable().ajax.reload();
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
                                    $('#tbl-daftar').DataTable().ajax.reload();
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

function listWaitingByTgl() {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-waiting').dataTable({
        "destroy": true,
        "processing": true,
        "serverside": true,
        "ajax": {
            url: baseUrl + "/inventory/p_returnsupplier/get-list-waiting-bytgl/" + tgl1 + "/" + tgl2,
            type: 'GET'
        },
        "columns": [{
                "data": "DT_Row_Index",
                orderable: true,
                searchable: false,
                "width": "5%"
            }, //memanggil column row
            {
                "data": "d_pcsr_code",
                "width": "10%"
            }, {
                "data": "s_company",
                "width": "15%"
            }, {
                "data": "i_name",
                "width": "15%"
            }, {
                "data": "s_name",
                "width": "5%"
            }, {
                "data": "d_pcsrdt_qtyconfirm",
                "width": "5%"
            }, {
                "data": "qty_remain",
                "width": "5%"
            }, {
                "data": "tglBuat",
                "width": "10%"
            }, {
                "data": "status",
                "width": "5%"
            },
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

function listReceivedByTgl() {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-received').dataTable({
        "destroy": true,
        "processing": true,
        "serverside": true,
        "ajax": {
            url: baseUrl + "/inventory/p_returnsupplier/get-list-received-bytgl/" + tgl1 + "/" + tgl2,
            type: 'GET'
        },
        "columns": [{
                "data": "DT_Row_Index",
                orderable: true,
                searchable: false,
                "width": "5%"
            }, //memanggil column row
            {
                "data": "d_pcsr_code",
                "width": "10%"
            }, {
                "data": "s_company",
                "width": "15%"
            }, {
                "data": "i_name",
                "width": "15%"
            }, {
                "data": "s_name",
                "width": "5%"
            }, {
                "data": "d_pcsrdt_qtyconfirm",
                "width": "5%"
            }, {
                "data": "qty_received",
                "width": "5%"
            }, {
                "data": "tglBuat",
                "width": "10%"
            }, {
                "data": "status",
                "width": "5%"
            }, {
                "data": "action",
                "width": "5%"
            },
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

function convertToAngka(rupiah) {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}

function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    var hasil = 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    return hasil + ',00';
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

function refreshTabelIndex() {
    $('#tbl-daftar').DataTable().ajax.reload();
}

function refreshTabelWaiting() {
    $('#tbl-waiting').DataTable().ajax.reload();
}

function refreshTabelReceived() {
    $('#tbl-received').DataTable().ajax.reload();
}

</script>
@endsection