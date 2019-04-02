<div id="label-badge-tab" class="tab-pane fade">
	<div class="card">
		<div class="card-header bordered p-2">
			<div class="header-block">
				<h3 class="title">Konfirmasi Opname</h3>
			</div>
		</div>
		<div class="card-block">
			<section>
				<div class="row">
					<div class="col-md-1" style="padding: 3px">
						<label class="tebal">Tanggal :</label>
					</div>
					<div class="col-md-6" style="padding: 3px">
						<div class="form-group">
							<div class="input-daterange input-group">
								<input id="tanggal3" class="form-control form-control-sm input-sm datepicker1 " name="tanggal" type="text">
								<span class="input-group-addon">-</span>
								<input id="tanggal4" class="input-sm form-control form-control-sm datepicker2" name="tanggal" type="text"
								value="{{ date('d-m-Y') }}">
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" title="Cari" onclick="getConfirm()"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2" style="padding: 3px">
						<label class="tebal">Pemilik :</label>
					</div>
					<div class="col-md-3" style="padding: 3px">
						<select name="pemilik-gudang" id="pemilik-gudangc" class="form-control form-control-sm" onchange="getConfirm()">
							<option value="0">- Pilih gudang</option>
							@foreach ($dataGudang as $a)
							<option value="{{ $a->gc_id }}">- {{ $a->gc_gudang }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table tabelan table-hover  table-bordered" cellspacing="0" id="table-konfirmasi">
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