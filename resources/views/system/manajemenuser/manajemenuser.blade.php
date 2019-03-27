@extends('main')
@section('content')
@include('system.manajemenuser.tambah_manajemenuser')
<article class="content">
	<div class="title-block text-primary">
		<h1 class="title"> Manajemen User </h1>
		<p class="title-description">
			<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> / <span>Admin System</span> / <span class="text-primary" style="font-weight: bold;">Manajemen User</span>
		</p>
	</div>
	<section class="section">
		<div class="row">
			<div class="col-12">
				
				<div class="card">
					<div class="card-header bordered p-2">
						<div class="header-block">
							<h3 class="title"> Manajemen User </h3>
						</div>
						<div class="header-block pull-right">
							<button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
							
						</div>
					</div>
					<div class="card-block">
						<section>
							
							
							<div class="table-responsive">
								<table class="table data-table table-hover" cellspacing="0" id="data">
									<thead class="bg-primary">
										<tr>
											<th>Nama User</th>
											<th>Nama Pegawai</th>
											<th>Tanggal Lahir</th>
											<th>Alamat</th>
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

	    data = $('#data').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: {
	            url: baseUrl + "/system/hakuser/tableuser",
	        },
	        columns: [{
	            data: 'm_username',
	            name: 'm_username',
	            width: '20%'
	        }, {
	            data: 'c_nama',
	            name: 'm_username',
	            width: '25%'
	        }, {
	            data: 'm_birth_tgl',
	            name: 'm_birth_tgl',
	            width: '20%'
	        }, {
	            data: 'm_addr',
	            name: 'm_addr',
	            width: '25%'
	        }, {
	            data: 'action',
	            name: 'action',
	            orderable: false,
	            searchable: false,
	            width: '10%'
	        }, ],
	    });

	});

	$('.datepicker').datepicker({
	    format: "mm",
	    viewMode: "months",
	    minViewMode: "months"
	});
	$('.datepicker2').datepicker({
	    format: "dd-mm-yyyy"
	});

	function edit(id) {
	    window.location.href = baseUrl + '/system/hakuser/edit-user-akses/' + id + '/edit';
	}

	function hapusUser(id) {
	    iziToast.question({
	        close: false,
	        overlay: true,
	        displayMode: 'once',
	        //zindex: 999,
	        title: 'Hapus Data',
	        message: 'Apakah anda yakin ?',
	        position: 'center',
	        buttons: [
	            ['<button><b>Ya</b></button>', function(instance, toast) {
	                $.ajax({
	                    url: baseUrl + '/system/hakuser/hapus-user',
	                    type: "POST",
	                    dataType: "JSON",
	                    data: {
	                        id: id,
	                        "_token": "{{ csrf_token() }}"
	                    },
	                    success: function(response) {
	                        if (response.status == "sukses") {
	                            data.ajax.reload(null, false);
	                            instance.hide({
	                                transitionOut: 'fadeOut'
	                            }, toast, 'button');
	                            iziToast.success({
	                                position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
	                                title: 'Pemberitahuan',
	                                message: response.pesan,
	                                onClosing: function(instance, toast, closedBy) {

	                                }
	                            });
	                        } else {
	                            instance.hide({
	                                transitionOut: 'fadeOut'
	                            }, toast, 'button');
	                            iziToast.error({
	                                position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
	                                title: 'Pemberitahuan',
	                                message: response.pesan,
	                                onClosing: function(instance, toast, closedBy) {

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
</script>
@endsection