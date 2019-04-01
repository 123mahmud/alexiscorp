<div class="tab-pane fade in active show" id="opname">
	<div class="card">
		<div class="card-header bordered p-2">
			<div class="header-block">
				<h3 class="title"> Opname Bahan Baku </h3>
			</div>
		</div>
		<div class="card-block">
			<section>
				<form id="data">
				<fieldset class="mb-3">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Pemilik Item</label>
						</div>
						<div class="col-md-9 col-sm-6 col-xs-12">
							<div class="form-group">
								<select class="form-control form-control-sm select2" id="pemilik" name="o_comp" style="width: 100%;" onclick="clearTable()">
									<option class="form-control" value="">- Pilih Gudang</option>
									@foreach ($dataGudang as $gudang)
									<option class="form-control pemilik-gudang" value="{{ $gudang->gc_id }}">
									- {{ $gudang->gc_gudang }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Tanggal Opname</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="">
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Nama Staff</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control form-control-sm" name="" value="{{ Auth::user()->m_name }}">
                    			<input type="hidden" readonly="" class="form-control form-control-sm" name="o_staff" value="{{ Auth::user()->m_id }}">
							</div>
						</div>
					</div>
				</fieldset>
				<fieldset class="mb-3">
					<div class="row">
						
						<div class="col-md-4 col-sm-8 col-xs-12" style="padding: 3px">
							<label>Masukab Kode / Nama</label>
							<div class="form-group">
								<input type="text" id="namaitem" name="item" class="form-control form-control-sm">
								<input type="hidden" id="i_id" name="i_id" class="form-control form-control-sm">
								<input type="hidden" id="i_code" name="i_code" class="form-control form-control-sm">
								<input type="hidden" id="i_name" name="i_name" class="form-control form-control-sm">
								<input type="hidden" id="m_sname" name="m_sname" class="form-control form-control-sm">
							</div>
						</div>
						<div class="col-md-3 col-sm-2 col-xs-12" style="padding: 3px">
							<label>Qty Sistem</label>
							<div class="form-group">
								<input type="text" id="s_qtykw" name="s_qtykw" class="form-control form-control-sm text-right" readonly>
              					<input type="hidden" id="s_qty" name="s_qty" class="form-control form-control-sm" readonly>
							</div>
						</div>
						<div class="col-md-3 col-sm-2 col-xs-12" style="padding: 3px">
							<label>Qty Real</label>
							<div class="form-group">
								<div class="input-group">
									<input type="text" id="qtyReal" name="qtyReal" class="form-control form-control-sm text-right currency">
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12" style="padding: 3px">
				            <label>Satuan</label>
				            <div class="input-group">
				              <select class="form-control form-control-sm" id="pilih-satuan"></select>
				              <input type="hidden" id="satuan-id" name="satuan" class="form-control" readonly>
				            </div>
				        </div>
					</div>
				</fieldset>
				<div class="table-responsive mt-3" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
					<table class="table table-striped table-bordered table-hover" id="tabelOpname" cellspacing="0">
						<thead class="bg-primary">
							<tr>
								<th width="20%">Kode | Item</th>
								<th width="25%">Qty Sistem</th>
								<th width="25%">Qty Real</th>
								<th width="25%">Opname</th>
								<th width="5%">Aksi</th>
							</tr>
						</thead>
						<tbody id="div_item">

						</tbody>
					</table>
				</div>
			</form>
			</section>
		</div>
		<div class="card-footer text-right">
			<button class="btn btn-primary" type="button" onclick="pilihOpname()">Simpan</button>
		</div>
	</div>
</div>