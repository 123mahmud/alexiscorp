<div class="tab-pane fade in" id="laporan_penjualan">
	<div class="card">

		<div class="card-block">
    		<section>
					<form id="laporanForm" method="post" target="_blank">
						@csrf
						<div class="row">
							<div class="col-sm-12 col-md-3">
								<label class="font-weight-bold">Tanggal</label>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="form-group">
									<div class="input-group input-group-sm input-daterange">
										<input type="text" class="form-control" id="date_from_lpj" name="date_from">
										<span class="input-group-addon">-</span>
										<input type="text" class="form-control" id="date_to_lpj" name="date_to">
										<div class="input-group-append">
											<button class="btn btn-primary" type="button" id="btn_search_date_lpj"><i class="fa fa-search"></i></button>
											<button class="btn btn-secondary" type="button" id="btn_refresh_date_lpj"><i class="fa fa-refresh"></i></button>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-12 col-md-3 col-lg-3">
								<button class="btn btn-secondary float-right" type="submit" id="btn_printlaporan"><i class="fa fa-print" title="Print"></i></button>
								<button class="btn btn-warning float-right" type="button" id="btn_exportlaporanExcel"><i class="fa fa-file-excel-o" title="Excel"></i></button>
								<button class="btn btn-info float-right" type="button" id="btn_exportlaporanPdf"><i class="fa fa-file-pdf-o" title="PDF"></i></button>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-6 col-lg-6">
								<label class="font-weight-bold">Staff</label>
								<div class="form-group">
									<select class="form-control select2" name="staff" id="staff_lpj">
										<option value="x" selected>ALL</option>
										@foreach($data['staff'] as $staff)
										<option value="{{ $staff->m_id }}">{{ $staff->m_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</form>

    			<div class="table-responsive">
    				<table class="table table-bordered  table-hover table-striped data-table" cellspacing="0" id="table_laporanpenjualan">
    					<thead class="bg-primary">
    						<tr>
    							<th>Nama item</th>
    							<th>Nota</th>
    							<th>Tanggal</th>
    							<th>Satuan</th>
    							<th>Qty</th>
    							<th>Harga</th>
    							<th>Disc (%)</th>
    							<th>Disc /@pcs</th>
    							<th>Total</th>
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
