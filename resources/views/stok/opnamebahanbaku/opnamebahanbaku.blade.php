@extends('main')
@section('content')
@include('stok.opnamebahanbaku.detail_opnamebahanbaku')
<article class="content">
	<div class="title-block text-primary">
		<h1 class="title"> Opname Stock </h1>
		<p class="title-description">
			<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
			/ <span>Stok</span>
			/ <span class="text-primary font-weight-bold">Opname Stock</span>
		</p>
	</div>
	<section class="section">
		<ul class="nav nav-pills">
			<li class="nav-item">
				<a href="" class="nav-link active" data-target="#opname" aria-controls="opname" data-toggle="tab" role="tab">Opname Stock</a>
			</li>
			<li class="nav-item">
				<a href="" class="nav-link" data-target="#list" aria-controls="list" data-toggle="tab" role="tab" onclick="getTanggal()">List Opname Stock</a>
			</li>
			<li class="nav-item">
				<a href="" class="nav-link" data-target="#label-badge-tab" aria-controls="label-badge-tab" data-toggle="tab" role="tab" onclick="getConfirm()">Konfirmasi Pengajuan Stock</a>
			</li>
		</ul>
		<div class="row">
			<div class="col-lg-12">
				
				<div class="tab-content">
					@include('stok.opnamebahanbaku.tab_opname')
					@include('stok.opnamebahanbaku.tab_list_opname')
					@include('stok.opnamebahanbaku.konfirmasi')
					<!-- Div #detail-opname -->
				</div>
			</div>
		</section>

	</article>
@endsection
@section('extra_script')
<script type="text/javascript">

	$(document).ready(function(){
	    var extensions = {
	            "sFilterInput": "form-control input-sm",
	            "sLengthSelect": "form-control input-sm"
	        }
	        // Used when bJQueryUI is false
	    $.extend($.fn.dataTableExt.oStdClasses, extensions);
	    // Used when bJQueryUI is true
	    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

	    $('#pemilik').select2();

	    var date = new Date();
	    var newdateIndex = new Date(date);
	    var newdate = new Date(date);

	    newdateIndex.setDate(newdate.getDate() - 30);
	    newdate.setDate(newdate.getDate() - 3);

	    var ndi = new Date(newdateIndex);
	    var nd = new Date(newdate);

	    $('.datepicker').datepicker({
	        autoclose: true,
	        format: "dd-mm-yyyy",
	        endDate: 'today'
	    }).datepicker("setDate", ndi);

	    $('.datepicker1').datepicker({
	        autoclose: true,
	        format: "dd-mm-yyyy",
	        endDate: 'today'
	    }).datepicker("setDate", nd);

	    $('.datepicker2').datepicker({
	        autoclose: true,
	        format: "dd-mm-yyyy",
	        endDate: 'today'
	    });

	    $("#namaitem").focus(function() {
	        var key = 1;
	        var comp = $('#pemilik').val();
	        var position = $('#pemilik').val();
	        $("#namaitem").autocomplete({
	            source: baseUrl + '/inventory/namaitem/autocomplite/' + comp + '/' + position,
	            minLength: 1,
	            select: function(event, ui) {
	                $('#namaitem').val(ui.item.item);
	                $('#i_id').val(ui.item.id);
	                $('#i_code').val(ui.item.i_code);
	                $('#i_name').val(ui.item.i_name);
	                $('#m_sname').val(ui.item.m_sname);
	                if(ui.item.s_qty == null)
                    {
                        $('#s_qty').val('0');
                    }
                    else
                    {
                        $('#s_qty').val(ui.item.s_qty);
                    }
	                $('#s_qtykw').val(ui.item.s_qtykw);
	                Object.keys(ui.item.sat).forEach(function(){
                        $('#pilih-satuan').append($('<option>', { 
                           value: ui.item.sat[key-1],
                           text : ui.item.satTxt[key-1]
                        }));
                        key++;
                  	}); 
                  	$('#satuan').val(ui.item.m_sname);
                  	$('#satuan-id').val(ui.item.m_sid);
	                $("input[name='qtyReal']").focus();
	            }
	        });
	        $("#namaitem").val('');
	        $("#i_id").val('');
	        $('#i_code').val('');
	        $("#i_name").val('');
	        $("#m_sname").val('');
	        $("#s_qty").val('');
	        $("#s_qtykw").val('');
	        $('#satuan').val('');
	        $("#qtyReal").val('');
	        $('#satuan-id').val('');
	        $('#pilih-satuan').empty();
	    });

	    $('#qtyReal').keypress(function(e) {
		    var charCode;
		    if ((e.which && e.which == 13)) {
		        charCode = e.which;
		    } else if (window.event) {
		        e = window.event;
		        charCode = e.keyCode;
		    }
		    if ((e.which && e.which == 13)) {
		        var qtyReal = $('#qtyReal').val();
		        if (qtyReal == '') {
		            $.toast({
                           heading: '',
                           text: 'Masukan jumlah real',
                           showHideTransition: 'plain',
                           icon: 'warning'
                       })
		            return false;
		        }
		        tambahOpname();
		        $("#namaitem").val('');
		        $("#i_id").val('');
		        $('#i_code').val('');
		        $("#i_name").val('');
		        $("#m_sname").val('');
		        $("#s_qty").val('');
		        $("#s_qtyKw").val('');
		        $('#qtyReal').val('');
		        $('#pilih-satuan').empty();
		        $("input[name='item']").focus();
		        return false;
		    }
		});
	});	

	

	var index = 0;
	var tamp = [];

	function tambahOpname() {
	    var i_id = $("#i_id").val();
	    var namaitem = $('#namaitem').val();
	    var s_qty = $('#s_qty').val();
	    var s_qtykw = $('#s_qtykw').val();
	    var m_sname = $('#m_sname').val();
	    var qtyReal = $('#qtyReal').val();
	    var satuan_id = $('#satuan-id').val();
	    var satuan = $('#pilih-satuan').val();
	    qtyReal = qtyReal.replace(/\,/g, '');
	    qtyReal = qtyReal * satuan;
	    var opname = parseFloat(qtyReal) - parseFloat(s_qty);
	    opname = opname.toFixed(2);
	    var opnameKw = parseFloat(qtyReal) - parseFloat(s_qty);
	    opnameKw = opnameKw;
	    var index = tamp.indexOf(i_id);

	    if (index == -1) {
	        $('#div_item').append(
                '<tr class="detail'+i_id+' saya">'
                	//item
                	+'<td width="20%">'
		            	+ namaitem + '<input type="hidden" name="i_id[]" id="" class="i_id" value="' + i_id + '">'
		            	+'<input type="hidden" name="satuan_id[]" id="s-qtykw" class="form-control form-control-sm text-right" readonly value="' + satuan_id + '">'
		            +'</td>'
		            //qty system
		            +'<td width="25%">'
		            	+'<input type="text" name="qty[]" id="s-qtykw" class="form-control form-control-sm text-right" readonly value="' + s_qtykw + '">'
		            +'</td>'
		            //qty real
		            +'<td width="25%">'
		            	+'<input type="text" name="real[]" id="real" class="form-control form-control-sm text-right qty-real-' + i_id + ' currency" onkeyup="hitungOpname(\'' + i_id + '\', \'' + s_qty + '\')" value="' + qtyReal + '">'
		            +'</td>'
		            //opname
		            +'<td width="25%">'
		            	+'<input type="text" name="opname[]" id="opnameKw" class="form-control form-control-sm text-right opnameKw-' + i_id + ' currency" readonly value="' + opnameKw + '">'
		            +'</td>'
		            //hapus tombol
                    +'<td width="5%">'
                       +'<button type="button" class="btn btn-danger btn_remove" id="'+i_id+'"><i class="fa fa-trash-o"></i></button>'
                    +'</td>'+
                '</tr>'
	        );
	        // tableOpname.draw();
	        index++;
	        tamp.push(i_id);

	        $('.currency').inputmask("currency", {
		      radixPoint: ".",
		      groupSeparator: ".",
		      digits: 2,
		      autoGroup: true,
		      prefix: '', //Space after $, this will not truncate the first character.
		      rightAlign: false,
		      autoUnmask: true,
		      // unmaskAsNumber: true,
		    });

	    } else {

	        $.toast({
               heading: '',
               text: 'Item sudah ada',
               showHideTransition: 'plain',
               icon: 'warning'
           })
	        $("#namaitem").val('');
	        $("#i_id").val('');
	        $('#i_code').val('');
	        $("#i_name").val('');
	        $("#m_sname").val('');
	        $("#s_qty").val('');
	        $("#s_qtyKw").val('');
	        $("#qtyReal").val('');
	        $('#pilih-satuan').empty();
	        $("input[name='item']").focus();
	    }
	}

	$(document).on('click', '.btn_remove', function(a)
    {
        var button_id = $(this).attr('id');
        var arrayIndex = tamp.findIndex(e => e === button_id);
        tamp.splice(arrayIndex, 1);
        $('.detail'+button_id).remove();
        $('#searchitem').focus();
    });

    function clearTable()
    {
        var button_id = $('.saya').attr('id');
        var arrayIndex = tamp.findIndex(e => e === button_id);
        tamp.splice(arrayIndex, 1);
        $('.saya').remove();
        $('#searchitem').focus();
    }

	function getTanggal() {
	    $('#tableHistory').dataTable().fnDestroy();
	    var jenis = $('#jenis-opname').val();
	    var gudang = $('#pemilik-gudang').val();
	    var tgl1 = $('#tanggal1').val();
	    var tgl2 = $('#tanggal2').val();
	    var tableFormula = $('#tableHistory').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: {
	            url: baseUrl + "/inventory/namaitem/history/" + tgl1 + '/' + tgl2 + '/' + jenis + '/' + gudang,
	        },
	        columns: [{
	            data: 'date',
	            name: 'date',
	            width: '20%'
	        }, {
	            data: 'm_username',
	            name: 'm_username',
	            width: '20%'
	        }, {
	            data: 'o_nota',
	            name: 'o_nota',
	            width: '15%'
	        }, {
	            data: 'comp',
	            name: 'comp',
	            width: '20%'
	        }, {
	            data: 'status',
	            name: 'status',
	            width: '10%'
	        }, {
	            data: 'action',
	            name: 'action',
	            orderable: false,
	            searchable: false,
	            width: '15%'
	        }, ],
	    });
	}

	function getConfirm() {
	    $('#table-konfirmasi').dataTable().fnDestroy();
	    var gudang = $('#pemilik-gudangc').val();
	    var tgl3 = $('#tanggal3').val();
	    var tgl4 = $('#tanggal4').val();
	    var tableFormula = $('#table-konfirmasi').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: {
	            url: baseUrl + "/inventory/namaitem/confirm/" + tgl3 + '/' + tgl4 + '/' + gudang,
	        },
	        columns: [{
	            data: 'date',
	            name: 'date',
	            width: '20%'
	        }, {
	            data: 'm_username',
	            name: 'm_username',
	            width: '20%'
	        }, {
	            data: 'o_nota',
	            name: 'o_nota',
	            width: '15%'
	        }, {
	            data: 'comp',
	            name: 'comp',
	            width: '20%'
	        }, {
	            data: 'status',
	            name: 'status',
	            width: '10%'
	        }, {
	            data: 'action',
	            name: 'action',
	            orderable: false,
	            searchable: false,
	            width: '15%'
	        }, ],
	    });
	}

	function hitungOpname(id, qty) {
	    var real = $('.qty-real-' + id).val();
	    real = parseFloat(real.replace(/\,/g, ''));
	    qty = parseFloat(qty).toFixed(2);
	    real = parseFloat(real).toFixed(2);
	    var opname = real - qty;
	    opname = opname.toFixed(2);
	    $('.opname-' + id).val(opname);
	    //kw
	    var opnameKw = real - qty;
	    $('.opnameKw-' + id).val(opnameKw);
	}

	function OpnameDet(id) {
	    $.ajax({
	        url: baseUrl + "/inventory/namaitem/detail",
	        type: "get",
	        data: {
	            x: id
	        },
	        success: function(response) {
	            $('#view-formula').html(response);
	            $('#btn-modal').html(
	                '<a class="btn btn-primary" target="_blank" href=' + baseUrl + '/inventory/stockopname/print_stockopname/' + id + '>' +
	                '<i class="fa fa-print"></i> Print' +
	                '</a>' +
	                '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>'
	            );
	        }
	    })
	}

	function convertToRupiah(angka) {
	    var rupiah = '';
	    var angkarev = angka.toString().split('').reverse().join('');
	    for (var i = 0; i < angkarev.length; i++)
	        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
	    var hasil = rupiah.split('', rupiah.length - 1).reverse().join('');
	    return hasil;
	}

	function convertToAngka(rupiah) {
	    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
	}

	function pilihOpname() {
	    $.confirm({
	        title: 'Hey!',
	        content: 'Silahkan pilih?',
	        type: 'red',
	        typeAnimated: true,
	        autoClose: 'Tidak|8000',
	        buttons: {
	            Ya: {
	                text: 'Pengajuan',
	                btnClass: 'btn-red',
	                keys: ['enter', 'shift'],
	                action: function() {
	                    $.ajaxSetup({
	                        headers: {
	                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                        }
	                    });
	                    $.ajax({
	                        url: baseUrl + '/inventory/namaitem/simpanopname/pengajuan',
	                        type: 'GET',
	                        data: $('#data').serialize(),
	                        success: function(response, nota) {
	                            if (response.status == 'sukses') {
	                            	clearTable();
	                                var nota = response.nota;
	                                $.toast({
							            heading: nota,
							            text: 'Pengajuan di Kirim',
							            bgColor: '#00b894',
							            textColor: 'white',
							            loaderBg: '#55efc4',
							            icon: 'success'
							        });
	                            } else {
	                                $.toast({
							            heading: 'Ada yang salah',
							            text: 'Periksa data anda.',
							            showHideTransition: 'plain',
							            icon: 'warning'
							        })
	                            }
	                        }
	                    });
	                }
	            },
	            Laporan: {
	                text: 'Laporan',
	                // btnClass: 'btn-blue',
	                keys: ['enter', 'shift'],
	                action: function() {
	                    $('.kirim-opname').attr('disabled', 'disabled');
	                    $.ajaxSetup({
	                        headers: {
	                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                        }
	                    });
	                    $.ajax({
	                        url: baseUrl + '/inventory/namaitem/simpanopname/laporan',
	                        type: 'GET',
	                        data: $('#data').serialize(),
	                        success: function(response, nota) {
	                            if (response.status == 'sukses') {
	                                clearTable();
	                                var nota = response.nota;
	                                $.toast({
							            heading: nota,
							            text: 'Laporan di simpan',
							            bgColor: '#00b894',
							            textColor: 'white',
							            loaderBg: '#55efc4',
							            icon: 'success'
							        });
	                                $('.kirim-opname').removeAttr('disabled', 'disabled');
	                            } else {
	                                $.toast({
							            heading: 'Ada yang salah',
							            text: 'Periksa data anda.',
							            showHideTransition: 'plain',
							            icon: 'warning'
							        })
	                                $('.kirim-opname').removeAttr('disabled', 'disabled');
	                            }
	                        }
	                    });
	                }
	            },
	            Tidak: function() {}
	        }
	    });
	}

	function deleteOp(id) {
	    $.confirm({
	        title: 'Hey!',
	        content: 'Apakah anda yakin?',
	        type: 'red',
	        typeAnimated: true,
	        autoClose: 'Tidak|8000',
	        buttons: {
	            tryAgain: {
	                text: 'Ya',
	                btnClass: 'btn-red',
	                action: function() {
	                    $.ajax({
	                        url: baseUrl + '/inventory/stockopname/hapusLaporan/' + id,
	                        type: "get",
	                        dataType: "JSON",
	                        data: {
	                            id: id
	                        },
	                        success: function(response) {
	                            if (response.status == "sukses") {
	                                $('#tableHistory').DataTable().ajax.reload();
	                                $.toast({
							            heading: nota,
							            text: 'Berhasil menghapus data',
							            bgColor: '#00b894',
							            textColor: 'white',
							            loaderBg: '#55efc4',
							            icon: 'success'
							        });
	                            } else {
	                                $.toast({
							            heading: 'Ada yang salah',
							            text: 'Periksa data anda.',
							            showHideTransition: 'plain',
							            icon: 'warning'
							        })
	                            }
	                        }

	                    })
	                }
	            },
	            Tidak: function() {}
	        }
	    });
	}

	function EditOpname(a) {
	    var parent = $(a).parents('tr');
	    $.ajax({
	        type: "GET",
	        url: '{{ url("inventory/stockopname/editopname") }}' + '/' + a,
	        success: function(data) {},
	        complete: function(argument) {
	            window.location = (this.url)
	        },
	        error: function() {

	        },
	        async: false
	    });
	}

	function ubahStatusConfirm(id) {
	    $.ajax({
	        url: baseUrl + "/inventory/namaitem/detail/confirm",
	        type: "get",
	        data: {
	            x: id
	        },
	        success: function(response) {
	            $('#view-formula-confirm').html(response);
	        }
	    })
	}

	function updateConfirm(id) {
	    var confirm = $('#confirm').val();
	    $.confirm({
	        title: 'Hey!',
	        content: 'Apakah anda yakin?',
	        type: 'red',
	        typeAnimated: true,
	        autoClose: 'Tidak|8000',
	        buttons: {
	            Ya: {
	                text: 'YA',
	                btnClass: 'btn-red',
	                keys: ['enter', 'shift'],
	                action: function() {
	                    $.ajaxSetup({
	                        headers: {
	                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                        }
	                    });
	                    $.ajax({
	                        url: baseUrl + '/inventory/simpanopname/update/status/' + id,
	                        type: 'GET',
	                        data: {
	                            x: confirm
	                        },
	                        success: function(response, nota) {
	                            if (response.status == 'sukses') {
	                                $('#myModalConfirm').modal('hide')
	                                $('#table-konfirmasi').DataTable().ajax.reload();
	                                $.toast({
							            heading: nota,
							            text: 'Berhasil update data',
							            bgColor: '#00b894',
							            textColor: 'white',
							            loaderBg: '#55efc4',
							            icon: 'success'
							        });

	                            } else {
	                                $.toast({
							            heading: 'Ada yang salah',
							            text: 'Periksa data anda.',
							            showHideTransition: 'plain',
							            icon: 'warning'
							        })
	                            }
	                        }
	                    });
	                }
	            },
	            Tidak: function() {}
	        }
	    });
	}
</script>
@endsection