@extends('main')

@section('content')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Return Penjualan </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	/ <span>Penjualan</span>
	    	/ <span class="text-primary font-weight-bold">Return Penjualan</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">

				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
	                        <h3 class="title"> Return Penjualan </h3>
	                    </div>
	                    <div class="header-block pull-right">

                			<a class="btn btn-primary" href="{{route('returnpenjualan.create')}}"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
	                    </div>
                    </div>
                    <div class="card-block">
                        <section>


                        	<div class="table-responsive">
														<table class="table data-table table-hover" cellspacing="0" id="table_returnpenjualan">
															<thead class="bg-primary">
																<tr>
																	<th>Tgl Return</th>
																	<th>Nota</th>
																	<th>Metode</th>
																	<th>Jenis Return</th>
																	<th>Tipe Penjualan</th>
																	<th>Status</th>
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
		TableReturnPenjualan();
	});
	// data-table -> function to retrieve DataTable server side
	var tb_returnpenjualan;
	function TableReturnPenjualan()
	{
		$('#table_returnpenjualan').dataTable().fnDestroy();
		tb_returnpenjualan = $('#table_returnpenjualan').DataTable({
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('returnpenjualan.getlist') }}",
				type: "get",
				data: {
					"_token": "{{ csrf_token() }}"
				}
			},
			columns: [
				{data: 'date'},
				{data: 'dsr_code'},
				{data: 'return_method'},
				{data: 'return_type'},
				{data: 'sales_type'},
				{data: 'status'},
				{data: 'action'}
			],
			pageLength: 10,
			lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']]
		});
	}
</script>
@endsection
