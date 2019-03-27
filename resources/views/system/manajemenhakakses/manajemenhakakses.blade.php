@extends('main')

@section('content')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Manajemen Hak Akses </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
	    	/ <span>Admin System</span> 
	    	/ <span class="text-primary font-weight-bold">Manajemen Hak Akses</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">
				
				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
	                        <h3 class="title"> Manajemen Hak Akses </h3>
	                    </div>

                		<div class="header-block pull-right">
                			<a class="btn btn-primary" href="{{route('tambah_manajemenhakakses')}}"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
                		</div>
                    </div>
                    <div class="card-block">
                        <section>
                        	
                        	
                        	<div class="table-responsive">
	                            <table class="table table-bordered table-striped table-hover" id="data" cellspacing="0">
	                                <thead class="bg-primary">
	                                    <tr>
	                                       <tr>
												<th>Nama User</th>
												<th>Nama Pegawai</th>
												<th>Tanggal Lahir</th>
												<th>Alamat</th>
												<th>Aksi</th>
	                                    </tr>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.confirm({
            title: 'Ehem!',
            content: 'Apakah anda yakin?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Ya',
                    btnClass: 'btn-red',
                    action: function() {
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
                                    $.toast({
                                        heading: '',
                                        text: 'User berhasil di hapus',
                                        bgColor: '#00b894',
                                        textColor: 'white',
                                        loaderBg: '#55efc4',
                                        icon: 'success'
                                    });;
                                } else {
                                    $.toast({
                                        heading: '',
                                        text: 'User gagal di hapus',
                                        showHideTransition: 'plain',
                                        icon: 'warning'
                                    })
                                }
                            }

                        })
                    }
                },
                close: function() {}
            }
        });
    }
</script>
@endsection