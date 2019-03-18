@extends('main')

@section('content')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Data Customer </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	 / <span>Master Data</span>
	    	 / <span class="text-primary" style="font-weight: bold;">Data Customer</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">

				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
	                        <h3 class="title"> Data Customer </h3>
	                    </div>
	                    <div class="header-block pull-right">
                    			<a class="btn btn-primary" href="{{route('tambah_datacustomer')}}"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>

	                    </div>
                    </div>
                    <div class="card-block">
                        <section>


                        	<div class="table-responsive">
	                            <table class="table table-striped table-hover" cellspacing="0" id="table_customer">
	                                <thead class="bg-primary">
	                                    <tr>
							                <th width="1%">No</th>
							                <th>ID</th>
							                <th>Nama</th>
											<th>Alamat</th>
							                <th>E-mail</th>
							                <th>No HP</th>
							                <th>Tipe Customer</th>
							                <th>Aksi</th>
							            </tr>
	                                </thead>
	                                <tbody>
	                                	<!-- <tr>
	                                		<td>1</td>
	                                		<td>CUS/0001</td>
	                                		<td>Alpha</td>
											<td>Rungkut</td>
	                                		<td>alpha@alpha.com</td>
	                                		<td>0843123123123</td>
	                                		<td>Kontraktor</td>
	                                		<td>
	                                			<div class="btn-group btn-group-sm">
	                                				<button class="btn btn-warning btn-edit" onclick="window.location.href=''" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
	                                				<button class="btn btn-danger btn-disable" type="button" title="Disable"><i class="fa fa-eye-slash"></i></button>
	                                			</div>
	                                		</td>
	                                	</tr>
	                                	<tr>
	                                		<td>2</td>
	                                		<td>CUS/0001</td>
	                                		<td>Bravo</td>
											<td>Rungkut</td>
	                                		<td>Bravo@Bravo.com</td>
	                                		<td>0843123123123</td>
	                                		<td>Harian</td>
	                                		<td>
	                                			<div class="btn-group btn-group-sm">
	                                				<button class="btn btn-warning btn-edit" onclick="window.location.href=''" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
	                                				<button class="btn btn-danger btn-disable" type="button" title="Disable"><i class="fa fa-eye-slash"></i></button>
	                                			</div>
	                                		</td>
	                                	</tr>
	                                	<tr>
	                                		<td>3</td>
	                                		<td>CUS/0001</td>
	                                		<td>Charlie</td>
											<td>Rungkut</td>
	                                		<td>Charlie@Charlie.com</td>
	                                		<td>0843123123123</td>
	                                		<td>Kontraktor</td>
	                                		<td>
	                                			<div class="btn-group btn-group-sm">
	                                				<button class="btn btn-warning btn-edit" onclick="window.location.href=''" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
	                                				<button class="btn btn-danger btn-disable" type="button" title="Disable"><i class="fa fa-eye-slash"></i></button>
	                                			</div>
	                                		</td>
	                                	</tr> -->
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

	$(document).ready(function(){
		// var table = $('#table_customer').DataTable();
		TableCustomer();

		// $(document).on('click', '.btn-disable', function(){
		// 	var ini = $(this);
		// 	$.confirm({
		// 		animation: 'RotateY',
		// 		closeAnimation: 'scale',
		// 		animationBounce: 1.5,
		// 		icon: 'fa fa-exclamation-triangle',
		// 	    title: 'Disable',
		// 		content: 'Apa anda yakin mau disable data ini?',
		// 		theme: 'disable',
		// 	    buttons: {
		// 	        info: {
		// 				btnClass: 'btn-blue',
		// 	        	text:'Ya',
		// 	        	action : function(){
		// 					$.toast({
		// 						heading: 'Information',
		// 						text: 'Data Berhasil di Disable.',
		// 						bgColor: '#0984e3',
		// 						textColor: 'white',
		// 						loaderBg: '#fdcb6e',
		// 						icon: 'info'
		// 					})
		// 			        ini.parents('.btn-group').html('<button class="btn btn-danger btn-enable" type="button" title="Enable"><i class="fa fa-eye"></i></button>');
		// 		        }
		// 	        },
		// 	        cancel:{
		// 	        	text: 'Tidak',
		// 			    action: function () {
    // 			            // tutup confirm
    // 			        }
    // 			    }
		// 	    }
		// 	});
		// });

		// $(document).on('click', '.btn-enable', function(){
		// 	$.toast({
		// 		heading: 'Information',
		// 		text: 'Data Berhasil di Enable.',
		// 		bgColor: '#0984e3',
		// 		textColor: 'white',
		// 		loaderBg: '#fdcb6e',
		// 		icon: 'info'
		// 	})
		// 	$(this).parents('.btn-group').html('<button class="btn btn-warning btn-edit" type="button" title="Edit"><i class="fa fa-pencil"></i></button>'+
	  //                               		'<button class="btn btn-danger btn-disable" type="button" title="Disable"><i class="fa fa-eye-slash"></i></button>')
		// })

		// function table_hapus(a){
		// 	table.row($(a).parents('tr')).remove().draw();
		// }
	});

	// data-table -> function to retrieve DataTable server side
	var tb_customer;
	function TableCustomer()
	{
		$('#table_customer').dataTable().fnDestroy();
		tb_customer = $('#table_customer').DataTable({
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('getlist_datacustomer') }}",
				type: "get",
				data: {
					"_token": "{{ csrf_token() }}"
				}
			},
			columns: [
				{data: 'DT_RowIndex'},
				{data: 'c_id'},
				{data: 'c_name'},
				{data: 'c_address'},
				{data: 'c_email'},
				{data: 'telp'},
				{data: 'c_type'},
				{data: 'action'}
			],
			pageLength: 10,
			lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']]
		});
	}

	// edit-data -> return view edit-form
	function Edit(idx)
	{
		window.location.href = baseUrl + "/master/datacustomer/edit/" + idx;
	}

	// delete-data -> JS-confirm
	function Hapus(idx)
	{
		var url_hapus = baseUrl + "/master/datacustomer/disable/" + idx;
		$.confirm({
			animation: 'RotateY',
			closeAnimation: 'scale',
			animationBounce: 1.5,
			icon: 'fa fa-exclamation-triangle',
			title: 'Peringatan!',
			content: 'Apakah anda yakin ingin menghapus data ini ?',
			theme: 'disable',
			buttons: {
				info: {
					btnClass: 'btn-blue',
					text:'Ya',
					action : function(){
						return $.ajax({
							type : "post",
							url : url_hapus,
							success : function (response){
								if(response.status == 'berhasil'){
									messageSuccess('Berhasil', 'Data berhasil dihapus !');
									tb_customer.ajax.reload();
								}
							},
							error : function(e){
								messageWarning('Gagal', 'Error, hubungi pengembang !');
							}
						});
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
	}

</script>
@endsection
