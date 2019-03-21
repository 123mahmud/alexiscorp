@extends('main')

@section('content')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Data Suplier </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> / <span>Master Data</span> / <span class="text-primary" style="font-weight: bold;">Data Suplier</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">
				
				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
	                        <h3 class="title"> Data Suplier </h3>
	                    </div>
	                    <div class="header-block pull-right">
                			<button class="btn btn-primary" data-toggle="modal" data-target="#tambah" onclick="window.location.href='{{route('tambah_datasuplier')}}'"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
	                    </div>
                    </div>
                    <div class="card-block">
                        <section>
                        	
                        	<div class="table-responsive">
	                            <table class="table table-striped table-hover" cellspacing="0" id="table_suplier">
	                                <thead class="bg-primary">
	                                    <tr align="center">
	                                    	<th width="10%">Code</th>
							                <th width="10%">Company</th>
							                <th width="17%">No Hp</th>
							                <th width="10%">Alamat</th>
											<th width="5%">Keterangan</th>
							                <th width="5%">Aksi</th>
							            </tr>
	                                </thead>
	                                <tbody>
	                                	{{-- @foreach($data['supplier'] as $index=>$supplier)
	                                	<tr>
	                                		<td> {{$supplier->c_name}} </td>
	                                		<td> {{$supplier->s_name}} </td>
	                                		<td> {{$supplier->s_address}} </td>
	                                		<td> {{$supplier->s_phone}} </td>
	                                		<td> {{$supplier->s_fax}} </td>
	                                		<td> {{$supplier->s_note}} </td>
	                                		<td> 
	                                			<div class="btn-group btn-group-sm">
	                                				@if($supplier->s_isactive == 'Y')
	                                				<a class="btn btn-warning btn-edit" href="{{url('/master/datasuplier/edit/'.$supplier->s_id.'')}}" type="button" title="Edit"><i class="fa fa-pencil"></i></a>
	                                				@endif

	                                				<button class="btn btn-danger btn-disable" type="button" title="Delete" onclick="status('{{$supplier->s_id}},{{$supplier->s_isactive}}')"><i class="fa fa-eye-slash"></i></button>
	                                			</div>
	                                		</td>
	                                	</tr>
	                                	@endforeach --}}

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

		$('#table_suplier').DataTable({
	      processing: true,
	      responsive:true,
	      serverSide: true,
	      ajax: {
	        url: '{{ url("master/datasuplier/table") }}',
	      },
	      columnDefs: [
	        {
	          targets: 0,
	          className: 'center d_id'
	        },
	      ],
	      "columns": [
	        { "data": "s_code", "width":"10%" },
	        { "data": "s_company", "width":"15%" },
	        { "data": "s_phone1", "width":"20%" },
	        { "data": "s_address", "width":"25%" },
	        { "data": "s_note", "width":"20%" },
	        { "data": "action", "width":"10%" }
	      ],
	      "responsive": true,
	      "pageLength": 10,
	      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
	      "language": {
	        "searchPlaceholder": "Cari Data",
	        "emptyTable": "Tidak ada data",
	        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
	        "sSearch": '<i class="fa fa-search"></i>',
	        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
	        "infoEmpty": "",
	        "paginate": {
	          "previous": "Sebelumnya",
	          "next": "Selanjutnya",
	        }
	      }
	   });

	});

	function edit(id)
  	{
    	$.ajax({
         type: "GET",
         url: baseUrl + '/master/datasuplier/edit',
         data: {id:id},
         success: function(response){

         },
         complete:function (argument) {
            window.location=(this.url)
         },
         error: function(){
            toastr["error"]("Terjadi Kesalahan", "Error");
         },
         // async: false
      });
  	}


	
</script>
@endsection