@extends('main')

@section('content')


<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Pencatatan Penjualan Tanpa Order </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	/ <span>Penjualan</span>
	    	/ <span class="text-primary font-weight-bold">Pencatatan Penjualan Tanpa Order</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">

				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
	                        <h3 class="title"> Pencatatan Penjualan Tanpa Order </h3>
	                    </div>
	                    <div class="header-block pull-right">
                			<button class="btn btn-primary" id="btn-tambah-mantan"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>

	                    </div>
                    </div>
                    <div class="card-block">
                        <section>


                        	<div class="table-responsive">
	                            <table class="table data-table table-hover" cellspacing="0" id="table_listpenjualan">
	                                <thead class="bg-primary">
	                                    <tr>
		                                    	<th width="1%">No</th>
													                <th>Nota</th>
													                <th>Customer</th>
													                <th>Staff</th>
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
	// jquery token
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function(){
		TableListPenjualan();
		$('#btn-tambah-mantan').click(function(){
			window.location.href = '{{route('tambah_penjualantanpaorder')}}';
		})
	});

	// data-table -> function to retrieve DataTable server side
	var tb_listpenjualan;
	function TableListPenjualan()
	{
		$('#table_listpenjualan').dataTable().fnDestroy();
		tb_listpenjualan = $('#table_listpenjualan').DataTable({
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('penjualantanpaorder.getlistpenjualan') }}",
				type: "get",
				data: {
					"_token": "{{ csrf_token() }}",
				}
			},
			columns: [
				{data: 'DT_RowIndex'},
				{data: 's_note'},
				{data: 'customer', width: "30%"},
				{data: 'staff', width: "30%"},
				{data: 'action'}
			],
			pageLength: 10,
			lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']]
		});
	}


</script>

@endsection
