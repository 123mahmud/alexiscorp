<div class="tab-pane fade in" id="list">
	<div class="card">
		<div class="card-header bordered p-2">
			<div class="header-block">
				<h3 class="title">List Opame Bahan Baku</h3>
			</div>
		</div>
		<div class="card-block">
			<section>
				<div class="row">
					<div class="col-md-1 col-sm-12">
						<label class="font-weight-bold">Tanggal</label>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<div class="input-group input-group-sm input-daterange">
								<input id="tanggal1" class="form-control form-control-sm input-sm datepicker1 " name="tanggal" type="text">
								<span class="input-group-addon">-</span>
								<input id="tanggal2" class="input-sm form-control form-control-sm datepicker2" name="tanggal" type="text"
								value="{{ date('d-m-Y') }}">
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" title="Cari" onclick="getTanggal()"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-1" style="padding: 3px">
						<label class="tebal">Jenis :</label>
					</div>
					<div class="col-md-3" style="padding: 3px">
						<select name="jenis-opname" id="jenis-opname" class="form-control form-control-sm" onchange="getTanggal()">
							<option value="LP" class="form-control">Laporan</option>
							<option value="MS" class="form-control">Merubah stock</option>
						</select>
					</div>
					
					<div class="col-md-1" style="padding: 3px">
						<label class="tebal">Pemilik :</label>
					</div>
					<div class="col-md-3" style="padding: 3px">
						<select name="pemilik-gudang" id="pemilik-gudang" class="form-control form-control-sm" onchange="getTanggal()">
							<option value="0">- Pilih gudang</option>
							@foreach ($dataGudang as $a)
							<option value="{{ $a->gc_id }}">- {{ $a->gc_gudang }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table data-table table-hover" cellspacing="0" id="tableHistory">
						<thead class="bg-primary">
							<tr>
								<th class="wd-15p">Tanggal - Waktu</th>
								<th class="wd-15p">Staff</th>
								<th class="wd-15p">Nota</th>
								<th class="wd-15p">Pemilik</th>
								<th class="wd-15p">Status</th>
								<th class="wd-15p">Aksi</th>
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