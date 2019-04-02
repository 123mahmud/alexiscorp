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
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;margin-bottom: 5px;">
                        @if ($dataIsi[0]->o_status == 'LP' )
                           <button class="btn btn-success kirim-opname" style="float: right" type="button" onclick="updateStock({{ $dataIsi[0]->o_id }})">Update Laporan</button>
                        @elseif ($dataIsi[0]->o_confirm == 'WT')
                           <button class="btn btn-success kirim-opname" style="float: right" type="button" onclick="updateStock({{ $dataIsi[0]->o_id }})">Update Pengajuan</button>
                        @elseif ($dataIsi[0]->o_confirm == 'AP')
                           <button class="btn btn-success kirim-opname" style="float: right" type="button" onclick="opnameStock({{ $dataIsi[0]->o_id }})">Opname Stock</button>
                        @endif
                     </div>
			</section>
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
	$(document).ready(function() {
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
	        });

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

	            function updateStock(id) {
	                $('.kirim-opname').attr('disabled', 'disabled');
	                $.ajaxSetup({
	                    headers: {
	                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                    }
	                });
	                $.ajax({
	                    url: baseUrl + '/inventory/namaitem/updateLap/' + id,
	                    type: 'GET',
	                    data: $('#data').serialize(),
	                    success: function(response, nota) {
	                        if (response.status == 'sukses') {
	                            window.open = baseUrl + '/inventory/stockopname/print_stockopname';
	                            $.toast({
									heading: '',
									text: 'Berhasil di update',
									bgColor: '#00b894',
									textColor: 'white',
									loaderBg: '#55efc4',
									icon: 'success'
	                           	});
	                            window.location.href = baseUrl + "/inventory/stockopname/opname";
	                            $('.kirim-opname').removeAttr('disabled', 'disabled');
	                        } else {
	                            $.toast({
	                               heading: '',
	                               text: 'Gagal di update',
	                               showHideTransition: 'plain',
	                               icon: 'warning'
	                           	})
	                            $('.kirim-opname').removeAttr('disabled', 'disabled');
	                        }
	                    }
	                });
	            }

	            function hapus(a) {
	                var par = a.parentNode.parentNode;
	                tableOpname.row(par).remove().draw(false);

	                var inputs = document.getElementsByClassName('i_id'),
	                    names = [].map.call(inputs, function(input) {
	                        return input.value;
	                    });
	                tamp = names;
	            }

	            function opnameStock(id) {
	                $('.kirim-opname').attr('disabled', 'disabled');
	                $.ajaxSetup({
	                    headers: {
	                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                    }
	                });
	                $.ajax({
	                    url: baseUrl + '/inventory/namaitem/ubahstok/' + id,
	                    type: 'GET',
	                    data: $('#data').serialize(),
	                    success: function(response, nota) {
	                        if (response.status == 'sukses') {
	                            window.open = baseUrl + '/inventory/stockopname/print_stockopname';
	                            $.toast({
							            heading: nota,
							            text: 'Berhasil Update Stok',
							            bgColor: '#00b894',
							            textColor: 'white',
							            loaderBg: '#55efc4',
							            icon: 'success'
							        });
	                            window.location.href = baseUrl + "/inventory/stockopname/opname";
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
</script>
@endsection