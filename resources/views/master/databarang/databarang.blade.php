@extends('main')

@section('content')



<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Data Barang </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	 / <span>Master Data</span>
	    	 / <span class="text-primary" style="font-weight: bold;">Data Barang</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">

				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
                            <h3 class="title"> Data Barang </h3>
                        </div>
                        <div class="header-block pull-right">

                			<a class="btn btn-primary" href="{{route('tambah_databarang')}}"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
                        </div>
                    </div>
                    <div class="card-block">
                        <section>

                        	<div class="table-responsive">
	                            <table class="table table-striped table-hover" cellspacing="0" id="table_barang">
	                                <thead class="bg-primary">
	                                    <tr>
	                                    	<th>No</th>
	                                		<th>Kode Barang</th>
	                                		<th>Nama Barang</th>
	                                		<th>Satuan</th>
	                                		<th>Kelompok Barang</th>
	                                		<th>Harga Beli</th>
	                                		<th>Aksi</th>
	                                	</tr>
	                                </thead>
	                                <tbody>

	                                	@foreach($data as $index=>$barang)
	                                	<tr>
	                                		<td> {{$index + 1}} </td>
	                                		<td> {{$barang->i_code}} </td>
	                                		<td> {{$barang->i_name}} </td>
	                                		<td> {{$barang->s_name}} </td>
	                                		<td> {{$barang->i_code_group}} </td>
	                                		<td> {{number_format($barang->i_sat_hrg1 ,2 ,  '.' , ',')}} </td>
	                                		<td> <div class="btn-group btn-group-sm">
	                                			@if($barang->i_isactive == 'Y')
	                                				<button class="btn btn-warning btn-edit" onclick="window.location.href='{{url('master/databarang/edit/'.$barang->i_id.'')}}'" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
																					<button class="btn btn-danger btn-disable" type="button" title="Disable" onclick="status('{{$barang->i_id}},{{$barang->i_isactive}}')"><i class="fa fa-times-circle"></i></button>
																				@else
																					<button class="btn btn-primary btn-disable" type="button" title="Enable" onclick="status('{{$barang->i_id}},{{$barang->i_isactive}}')"><i class="fa fa-check-square"></i></button>
	                                			@endif
	                                			</div> </td>
	                                	</tr>
	                                	@endforeach

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
	var table1 = $('#table_barang').DataTable();

	function status(id){
		split = id.split(",");
		data_id = split[0];
		active = split[1];
		if(active == 'Y'){
			$status = 'Disable';
		}
		else {
			$status = 'Enable';
		}
		$.confirm({
                animation: 'RotateY',
				closeAnimation: 'scale',
				icon: 'fa fa-exclamation-triangle',
			    title: $status,
				content: 'Apa anda yakin mau '+$status+' data ini?',
				theme: 'disable',
			    buttons: {
			        info: {
						btnClass: 'btn-blue',
			        	text:'Ya',
			        	action : function(){
							$.ajax({
								data : {data_id},
								type : "get",
								url : baseUrl + '/master/databarang/disabled',
								dataType : "json",
								success : function(response){
									$.toast({
										heading: 'Information',
										text: 'Data Berhasil di Enable.',
										bgColor: '#0984e3',
										textColor: 'white',
										loaderBg: '#fdcb6e',
										icon: 'info'
									});

									setTimeout(function(){
			                         location.reload();
			                            },200);
								}
							})
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
