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
				<a href="" class="nav-link active" data-target="#opname" aria-controls="opname" data-toggle="tab" role="tab">Edit Opname</a>
			</li>
		</ul>
		<div class="row">
			<div class="col-lg-12">
				
				<div class="tab-content">
					<div class="tab-pane fade in active show" id="opname">
	<div class="card">
		<div class="card-header bordered p-2">
			<div class="header-block">
				<h3 class="title"> Edit Opname {{ $dataIsi[0]->gc_gudang }}</h3>
			</div>
		</div>
		<div class="card-block">
			<section>
				<form id="data">
				<fieldset class="mb-3">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Pemilik Item</label>
						</div>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div class="form-group">
								<select class="form-control form-control-sm select2" id="pemilik" name="o_comp" style="width: 100%;" onclick="clearTable()">
									<option class="form-control pemilik-gudang" value="{{ $dataIsi[0]->gc_id }}">
                                 - {{ $dataIsi[0]->gc_gudang }}</option>
								</select>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Tanggal Opname</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="">
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Nama Staff</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control form-control-sm" name="" value="{{ Auth::user()->m_name }}">
                    			<input type="hidden" readonly="" class="form-control form-control-sm" name="o_staff" value="{{ Auth::user()->m_id }}">
							</div>
						</div>
					</div>
				</fieldset>
				<fieldset class="mb-3">
				</fieldset>
				<div class="table-responsive mt-3" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
					<table class="table table-striped table-bordered table-hover" id="tabelOpname" cellspacing="0">
						<thead class="bg-primary">
							<tr>
								<th width="20%">Kode | Item</th>
								<th width="25%">Qty Sistem</th>
								<th width="25%">Qty Real</th>
								<th width="25%">Opname</th>
								<th width="5%">Aksi</th>
							</tr>
						</thead>

						<tbody id="div_item">
							@for ($i = 0; $i < count($dataItem['data_isi']) ; $i++)
                                 <tr class="detail{{ $dataItem['data_isi'][$i]['i_id'] }}">
                                    <td>{{ $dataItem['data_isi'][$i]['i_code'] }} - {{ $dataItem['data_isi'][$i]['i_name'] }}
                                       <input type="hidden" name="i_id[]" id="" class="i_id" value="{{ $dataItem['data_isi'][$i]['i_id'] }}">
                                    </td>
                                    <td>
                                       <input type="text" name="qty[]" id="s-qtykw" class="form-control form-control-sm text-right" readonly value="{{ number_format($dataItem['data_stok'][$i]->qtyStok,2,'.',',') }} {{ $dataItem['data_isi'][$i]['s_name'] }}">
                                       <input type="hidden" name="satuan_id[]" id="s-qtykw" class="form-control form-control-sm text-right" readonly value="{{ $dataItem['data_isi'][$i]['i_sat1'] }}">
                                    </td>
                                    <td>
                                       <input type="text" name="real[]" id="real" class="form-control form-control-sm text-right qty-real-{{ $dataItem['data_isi'][$i]['i_id'] }} ' currency" onkeyup="hitungOpname({{ $dataItem['data_isi'][$i]['i_id'] }},{{ $dataItem['data_stok'][$i]->qtyStok }})" value="{{ $dataItem['data_isi'][$i]['od_real'] }}">
                                    </td>
                                    <td>
                                       <input type="text" name="opname[]" id="opnameKw" class="form-control form-control-sm text-right opnameKw-{{ $dataItem['data_isi'][$i]['i_id'] }} currency" readonly value="{{$dataItem['data_stok'][$i]->qtyStok + $dataItem['data_isi'][$i]['od_real']}}">
                                    </td>
                                    <td>
                                       @if ($dataIsi[0]->o_confirm == '')
                                       <div class="text-center">
                                          <button type="button" class="btn btn-danger btn_remove" id="{{ $dataItem['data_isi'][$i]['i_id'] }}"><i class="fa fa-trash-o"></i></button>
                                       </div>
                                       @elseif ($dataIsi[0]->o_confirm == 'WT')
                                       <div class="text-center">
                                          <button type="button" class="btn btn-danger btn_remove" id="{{ $dataItem['data_isi'][$i]['i_id'] }}"><i class="fa fa-trash-o"></i></button>
                                       </div>
                                       @elseif ($dataIsi[0]->o_confirm == 'AP')
                                       <div class="text-center">
                                          <button type="button" disabled="" class="btn btn-danger hapus btn-sm"><i class="fa fa-trash-o"></i>
                                          </button>
                                       </div>
                                       @endif
                                    </td>
                                 </tr>
                                 @endfor
						</tbody>
					</table>
				</div>
			</form>
			</section>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary" type="button" onclick="pilihOpname()">Simpan</button>
		</div>
	</div>
</div>
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

	    // tableOpname = $('#tabelOpname').DataTable();

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
                '<tr class="detail'+i_id+'">'
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

	function simpanOpname() {
	    $('.kirim-opname').attr('disabled', 'disabled');
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });
	    var a = $('#opname :input').serialize();
	    var b = tableOpname.$('input').serialize();
	    $.ajax({
	        url: baseUrl + '/inventory/namaitem/simpanopname',
	        type: 'POST',
	        data: a + '&' + b,
	        success: function(response, nota) {
	            if (response.status == 'sukses') {
	                window.open = baseUrl + '/inventory/stockopname/print_stockopname';
	                tableOpname.row().clear().draw(false);
	                var inputs = document.getElementsByClassName('i_id'),
	                    names = [].map.call(inputs, function(input) {
	                        return input.value;
	                    });
	                tamp = names;
	                var nota = response.nota.o_nota;
	                iziToast.success({
	                    timeout: 5000,
	                    position: "topRight",
	                    icon: 'fa fa-chrome',
	                    title: nota,
	                    message: 'Telah terkirim.'
	                });
	                $('.kirim-opname').removeAttr('disabled', 'disabled');
	            } else {
	                iziToast.error({
	                    position: "topRight",
	                    title: '',
	                    message: 'Mohon melengkapi data.'
	                });
	                $('.kirim-opname').removeAttr('disabled', 'disabled');
	            }
	        }
	    });
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

	function clearTable() {
	    tableOpname.row().clear().draw(false);
	    var inputs = document.getElementsByClassName('i_id'),
	        names = [].map.call(inputs, function(input) {
	            return input.value;
	        });
	    tamp = names;
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
		console.log($('#data').serialize());
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
	                                tableOpname.row().clear().draw(false);
	                                var inputs = document.getElementsByClassName('i_id'),
	                                    names = [].map.call(inputs, function(input) {
	                                        return input.value;
	                                    });
	                                tamp = names;
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
	                                tableOpname.row().clear().draw(false);
	                                var inputs = document.getElementsByClassName('i_id'),
	                                    names = [].map.call(inputs, function(input) {
	                                        return input.value;
	                                    });
	                                tamp = names;
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
	                                iziToast.success({
	                                    timeout: 5000,
	                                    position: "topRight",
	                                    icon: 'fa fa-chrome',
	                                    title: response.nota,
	                                    message: 'Terhapus'
	                                });
	                            } else {
	                                iziToast.error({
	                                    position: "topRight",
	                                    title: '',
	                                    message: 'Gagal hapus data'
	                                });
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
	                                iziToast.success({
	                                    timeout: 5000,
	                                    position: "topRight",
	                                    icon: 'fa fa-chrome',
	                                    message: 'Berhasil update status.'
	                                });

	                            } else {
	                                iziToast.error({
	                                    position: "topRight",
	                                    title: '',
	                                    message: 'Gagal update status.'
	                                });

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