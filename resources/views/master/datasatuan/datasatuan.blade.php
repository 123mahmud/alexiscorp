@extends('main')

@section('content')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Data Satuan </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	/ <span>Master Data</span>
	    	/ <span class="text-primary font-weight-bold">Data Satuan</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">

				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
	                        <h3 class="title"> Data Satuan </h3>
	                    </div>
	                    <div class="header-block pull-right">

                    			<button class="btn btn-primary" onclick="window.location.href='{{ route('tambah_datasatuan') }}'"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
	                    </div>
                    </div>
                    <div class="card-block">
                        <section>

                        	<div class="table-responsive">
	                            <table class="table table-striped table-hover" cellspacing="0" id="table_satuan">
	                                <thead class="bg-primary">
	                                    <tr>
		                                    	<th width="1%">No</th>
													                <th>Kode Satuan</th>
													                <th>Nama Satuan</th>
													                <th width="15%">Aksi</th>
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
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
	});
	$(document).ready(function() {
		TableSatuan();
	})

	function Hapus(id, status){
		if(status == 'Y'){
			datastatus = 'Disable';
		} else {
			datastatus = 'Enable';
		}
		$.confirm({
				animation: 'RotateY',
				closeAnimation: 'scale',
				animationBounce: 1.5,
				icon: 'fa fa-exclamation-triangle',
		    title: datastatus,
				content: 'Apa anda yakin mau ' + datastatus + ' data ini?',
				theme: 'disable',
			    buttons: {
			        info: {
								btnClass: 'btn-blue',
			        	text:'Ya',
			        	action : function(){
									$.ajax({
										data : {id},
										type : "post",
										url : baseUrl + '/master/datasatuan/disabled',
										dataType : "json",
										success : function(response)
										{
											messageSuccess('Berhasil', 'Data berhasil di-'+ datastatus +' !');
											tb_satuan.ajax.reload();
						        }
									})
								}
			        },
			        cancel: {
			        	text: 'Tidak',
					    	action: function () {
									// tutup confirm
								}
    			    }
			    }
			});
	}


	// data-table -> function to retrieve DataTable server side
	var tb_satuan;
	function TableSatuan()
	{
		$('#table_satuan').dataTable().fnDestroy();
		tb_satuan = $('#table_satuan').DataTable({
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('list_datasatuan') }}",
				type: "get",
				data: {
					"_token": "{{ csrf_token() }}"
				}
			},
			columns: [
				{data: 'DT_RowIndex'},
				{data: 's_id'},
				{data: 's_name'},
				{data: 'action'}
			],
			pageLength: 10,
			lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']]
		});
	}

	/*$(document).ready(function(){
		var table = $('#table_satuan').DataTable();

		$(document).on('click', '.btn-disable', function(){
			var ini = $(this);
			$.confirm({
				animation: 'RotateY',
				closeAnimation: 'scale',
				animationBounce: 1.5,
				icon: 'fa fa-exclamation-triangle',
			    title: 'Disable',
				content: 'Apa anda yakin mau disable data ini?',
				theme: 'disable',
			    buttons: {
			        info: {
						btnClass: 'btn-blue',
			        	text:'Ya',
			        	action : function(){
							$.toast({
								heading: 'Information',
								text: 'Data Berhasil di Disable.',
								bgColor: '#0984e3',
								textColor: 'white',
								loaderBg: '#fdcb6e',
								icon: 'info'
							})
					        ini.parents('.btn-group').html('<button class="btn btn-danger btn-enable" type="button" title="Enable"><i class="fa fa-eye"></i></button>');
				        }
			        },
			        cancel:{
			        	text: 'Tidak',
					    action: function () {
    			            // tutup confirm
    			        }
    			    }
			    }
			});
		});

		$(document).on('click', '.btn-enable', function(){
			$.toast({
				heading: 'Information',
				text: 'Data Berhasil di Enable.',
				bgColor: '#0984e3',
				textColor: 'white',
				loaderBg: '#fdcb6e',
				icon: 'info'
			})
			$(this).parents('.btn-group').html('<button class="btn btn-warning btn-edit" type="button" title="Edit"><i class="fa fa-pencil"></i></button>'+
	                                		'<button class="btn btn-danger btn-disable" type="button" title="Disable"><i class="fa fa-eye-slash"></i></button>')
		})
	});*/
</script>
@endsection
