@extends('main')

@section('content')



<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Return Pembelian </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
	    	/ <span>Purchasing</span> 
	    	/ <span class="text-primary" style="font-weight: bold;">Return Pembelian</span>
	     </p>
	</div>

	<section class="section">

		<ul class="nav nav-pills">
            <li class="nav-item">
                <a href="" class="nav-link active" data-target="#return_pembelian_tab" aria-controls="return_pembelian_tab" data-toggle="tab" role="tab">Return Pembelian</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link" data-target="#revisi_tab" aria-controls="revisi_tab" data-toggle="tab" role="tab">Revisi PO</a>
            </li>
        </ul>	

		<div class="row">

			<div class="col-12">
			
		
				<div class="tab-content">		

					@include('purchasing.returnpembelian.tab_return')
					@include('purchasing.returnpembelian.tab_revisi')


		        </div>
			</div>

		</div>

	</section>

</article>
	@section('extra_script')
		@include('purchasing/returnpembelian/modal_detail')
		@include('purchasing/returnpembelian/includes/modal_detail_revisi_po')
		@include('purchasing/returnpembelian/includes/modal_update_status')
		@include('purchasing/returnpembelian/js/functions')
		@include('purchasing/returnpembelian/js/commander')
	@endsection


@endsection