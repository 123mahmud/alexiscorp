@extends('main')

@section('content')



<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Stok </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	 / <span>Stock Gudang</span>
	    	 / <span class="text-primary" style="font-weight: bold;">Stock Gudang</span>
	     </p>
	</div>

	<section class="section">

		<div class="row">

			<div class="col-12">
				
				<div class="card">
                    <div class="card-header bordered p-2">
                    	<div class="header-block">
                            <h3 class="title"> Stock Gudang </h3>
                        </div>
                    </div>
                    <div class="card-block">
                        <section>
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <label for="">Pemilik Item:</label>
                            </div>
                            <div class="col-md-10 col-sm-12">
                            <div class="form-group">
                                <select name="" id="" class="form-control form-control-sm">
                                    <option value="">Pilih Gudang</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        	<div class="table-responsive">
	                            <table class="table table-striped table-hover" cellspacing="0" id="table_stockgudang">
	                                <thead class="bg-primary">
	                                    <tr>
	                                    	<th>No</th>
	                                		<th>Kode - Nama Item </th>
	                                		<th>Type Item</th>
	                                		<th>Qty System</th>
	                                		<th>Satuan</th>
	                                	</tr>
	                                </thead>
	                                <tbody>
	                                	<tr>
	                                		<td></td>
	                                		<td></td>
	                                		<td></td>
	                                		<td></td>
	                                		<td></td>
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
<script>
docum
</script>
@endsection
