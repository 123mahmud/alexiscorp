@extends('main')

@section('content')

@include('master.dataharga.mastergroup.create')
@include('master.dataharga.mastergroup.edit')
<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Data Harga </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
	    	/ <span>Master Data</span> 
	    	/ <span class="text-primary font-weight-bold">Data Harga</span>
	     </p>
	</div>

	<section class="section">

		<ul class="nav nav-pills">
            <li class="nav-item">
                <a href="" class="nav-link active" data-target="#harga_khusus" aria-controls="harga_khusus" data-toggle="tab" role="tab">Group Harga Khusus</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link" data-target="#master_group" aria-controls="master_group" data-toggle="tab" role="tab">Master Group</a>
            </li>
        </ul>

		<div class="row">


			<div class="col-12">

                <div class="tab-content">
                	@include('master.dataharga.hargakhusus.index')
                	@include('master.dataharga.mastergroup.index')
	            </div>

			</div>

		</div>

	</section>

</article>

@endsection
@section('extra_script')
<script>
    $(document).ready( function () {
        $('#table_harga_khusus').DataTable();
        $('#table_mastergroup').DataTable();
    } );
</script>
@endsection
