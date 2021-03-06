@extends('main')

@section('content')

@include('produksi.perencanaanproduksi.tambah_perencanaanproduksi')
@include('produksi.perencanaanproduksi.modal_spk')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Perencanaan Produksi </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> / <span>Produksi</span> / <span class="text-primary" style="font-weight: bold;">Perencanaan Produksi</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">
				
				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
	                        <h3 class="title"> Perencanaan Produksi </h3>
	                    </div>
	                    <div class="header-block pull-right">	                    	
                			<button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
	                    </div>
                    </div>
                    <div class="card-block">
                        <section>
                        	
                        	<div class="table-responsive">
	                            <table class="table table-hover table-striped table-bordered" cellspacing="0" id="tabel_rencana">
	                                <thead class="bg-primary">
	                                    <tr>
	                                    	<th>Kode Produksi</th>
							                <th>Tanggal</th>
							                <th>Kode Barang</th>
							                <th>Nama Barang</th>
							                <th>Rencana Produksi</th>
							                <th>Aksi</th>
							            </tr>
	                                </thead>
	                                <tbody>
	                                	<tr>
	                                		<td>PTR/20190124/1</td>
	                                		<td>24 Jan 2019</td>
	                                		<td>BRG/1</td>
	                                		<td>Paving</td>
	                                		<td align="right">200</td>
	                                		<td>
	                                			<div class="btn-group btn-group-sm">
		                                			<button class="btn btn-warning btn-tambah-modal" type="button" title="Edit"><i class="fa fa-pencil"></i></button>
		                                			<button class="btn btn-primary btn-buat-spk" type="button" title="Buat SPK"><i class="fa fa-plus-square"></i></button>
		                                			<button class="btn btn-danger" type="button" title="Hapus"><i class="fa fa-trash-o"></i></button>
		                                		</div>
	                                		</td>
	                                	</tr>
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

		var table = $('#tabel_rencana').DataTable();

		var table_modal = $('#tabel_modal_spk').DataTable({

			searching:false,
			paging:false
		});

		$('.btn-tambah-modal').click(function(){

			$('#tambah').modal('show');

			setTimeout("$('#tambah_barang').select2('open');",500);
				
		});

		$('.btn-buat-spk').click(function(){

			$('#buat_spk').modal('show');

			$('#btn-final').attr('disabled', true);

		});

		$('#hitung-stok').click(function(){

			$('#tabel_modal_spk tbody > tr').each(function(){

				var stok =parseInt( $(this).find('.stok').val());
				var kebutuhan = parseInt($(this).find('.kebutuhan').val());
				
				var sisa = stok - kebutuhan;

				$(this).find('.sisa').val(sisa);

				// console.log(stok);






			});

			$('#tabel_modal_spk tbody > tr').each(function(){

				var sisa = $(this).find('.sisa').val();

				if(sisa < 0){
					$('#btn-final').attr('disabled', true);
					$('#btn-rencanabahanbaku').attr('disabled', false);
					// $('#btn-rencanabahanbaku').removeClass('d-none');
					return false;
				} else {
					$('#btn-final').attr('disabled', false);
					$('#btn-rencanabahanbaku').attr('disabled', true);
					// $('#btn-rencanabahanbaku').addClass('d-none');

				}

			});


		});


	});

</script>
@endsection