@extends('main')

@section('content')

@include('purchasing.rencanapembelian.modal_detail')
@include('purchasing.rencanapembelian.modal_edit')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Rencana Pembelian </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
	    	/ <span>Purchasing</span> 
	    	/ <span class="text-primary font-weight-bold">Rencana Pembelian</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">
			
			<div class="col-12">
				
				<div class="row">
					
					<div class="col-md-6 col-sm-6 col-12">
						
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<span class="badge badge-pill badge-light"></span> Rencana Pembelian <strong>Disetujui</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

					</div>

					<div class="col-md-6 col-sm-6 col-12">
						
						<div class="alert alert-info alert-dismissible fade show" role="alert">
							<span class="badge badge-pill badge-light"></span> Rencana Pembelian <strong>Waiting</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

					</div>					

				</div>

			</div>
			
		</div>



		<ul class="nav nav-pills">
            <li class="nav-item">
                <a href="" class="nav-link active" data-target="#daftar_rencana" aria-controls="daftar_rencana" data-toggle="tab" role="tab">Daftar Rencana Pembelian</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link" data-target="#history_rencana" aria-controls="history_rencana" data-toggle="tab" role="tab">History Rencana Pembelian</a>
            </li>
        </ul>

		<div class="row">


			<div class="col-12">

                <div class="tab-content">

                	@include('purchasing.rencanapembelian.tab_daftar')
                	@include('purchasing.rencanapembelian.tab_history')



	            </div>

			</div>

		</div>
		@include('purchasing.rencanapembelian.modal-detail')
	</section>

</article>

@endsection
@section('extra_script')


<script type="text/javascript">
	$(document).ready(function () {

		var d = new Date();
		d.setDate(d.getDate()-7);
		$('#tanggal1').datepicker({
			format:"dd-mm-yyyy",        
			autoclose: true,
		}).datepicker( "setDate", d);
		$('.datepicker1').datepicker({
			autoclose: true,
			format:"dd-mm-yyyy",
			endDate: 'today'
		}).datepicker("setDate", d);
		$('#tanggal2').datepicker({
		  	format:"dd-mm-yyyy",        
		  	autoclose: true,
		}).datepicker( "setDate", new Date());

		tablePlan();

		
	});

	function tablePlan()
   	{
		$('#tablePlan').dataTable().fnDestroy();
		tablex = $("#tablePlan").DataTable({        
		responsive: true,
		processing: true,
			serverSide: true,
			ajax: {
				"url": "{{ url("/purcahse-plan/data-plan") }}",
				"type": "get",
				data: {
			       	"_token": "{{ csrf_token() }}",                    
				    "tanggal1" :$('#tanggal1').val(),
           	        "tanggal2" :$('#tanggal2').val()
				},
			},
			columns: [
				{data: 'tglBuat', name: 'tglBuat', "width": "15%"},
				{data: 'p_code', name: 'p_code', "width": "15%"},            
				{data: 'm_name', name: 'm_name', "width": "15%"},
				{data: 's_company', name: 's_company', "width": "15%"},                        
				{data: 'status', name: 'status', "width": "10%"}, 
				{data: 'tglConfirm', name: 'tglConfirm', "width": "15%"},                         
				{data: 'aksi', name: 'aksi', "width": "15%"},
			],
			//responsive: true,
			"pageLength": 10,
			"lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],

			"rowCallback": function( row, data, index ) {
			   if (data['s_status']=='draft') {
			        $('td', row).addClass('warning');
			   } 
			}   
		  
		});
   	}

   	function detailPlanAll(id) 
	{
		$.ajax({
			url : baseUrl + "/purchasing/rencanapembelian/get-detail-plan/"+id+"/all",
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				var key = 1;
				//ambil data ke json->modal
				$('#txt_span_status').text(data.spanTxt);
				$("#txt_span_status").addClass('label'+' '+data.spanClass);
				$('#lblCodePlan').text(data.header[0].p_code);
				$('#lblTglPlan').text(data.header[0].p_created);
				$('#lblStaff').text(data.header[0].m_name);
				$('#lblSupplier').text(data.header[0].s_company);
				//loop data
				Object.keys(data.data_isi).forEach(function(){
					$('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
					+'<td>'+key+'</td>'
					+'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
					+'<td>'+data.data_isi[key-1].s_name+'</td>'
					+'<td>'+data.data_isi[key-1].ppdt_qty+'</td>'
					+'<td>'+data.data_isi[key-1].ppdt_qtyconfirm+'</td>'
					+'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
					+'</tr>');
					key++;
				});
				$('#modal-detail').modal('show');
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			}
		});
	}
</script>

@endsection