<div class="tab-pane fade in active show" id="pos">
	<div class="card">

        <div class="card-block">
            <section>

            	<div class="row">

            		<div class="offset-lg-5 col-lg-7 offset-md-4 col-md-8 offset-sm-3 col-sm-9 col-12">
            			<div class="form-group top-totalprice">
	            			<label>Total Amount</label>
            				<input type="text" class="form-control form-control-lg text-right currency text-right totalAmount" value="0,00" readonly="">
            			</div>
            		</div>

            	</div>

							<form id="customerForm" action="#">
								<fieldset class="mb-3">
									<div class="row">
										<div class="col-md-9 col-sm-12">
											<div class="row">
												<div class="col-lg-12">
													<label>Nama Customer</label>
													<div class="form-group">
														<div class="input-group">
															<input type="hidden" name="idCustomer" id="idCustomer">
															<input type="text" class="form-control form-control-sm" name="customer" id="customer">
															<div class="input-group-append">
																<button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#tambah_cust"><i class="fa fa-plus-square"></i></button>
															</div>
														</div>
													</div>
												</div>

												<div class="col-lg-12">
													<label>Alamat</label>
													<div class="form-group">
														<input type="text" class="form-control form-control-sm" name="address" id="address" readonly="">
													</div>
												</div>

												<div class="col-lg-12">
													<label>Keterangan Project</label>
													<div class="form-group">
														<textarea class="form-control" name="keterangan" id="ket_project"></textarea>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-12">
											<div class="row">
												<div class="col-lg-12">
													<label>Tanggal Order</label>
													<div class="form-group">
														<div class="input-group">
															<input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="orderDate" id="orderDate">
															<div class="input-group-append">
																<button class="btn btn-primary btn-sm" type="button" id="cal-orderDate"><i class="fa fa-calendar"></i></button>
															</div>
														</div>
													</div>
												</div>

												<div class="col-lg-12">
													<label>Jatuh Tempo</label>
													<div class="form-group">
														<div class="input-group">
															<input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="dueDate" id="dueDate">
															<div class="input-group-append">
																<button class="btn btn-primary btn-sm" type="button" id="cal-dueDate"><i class="fa fa-calendar"></i></button>
															</div>
														</div>
													</div>
												</div>

												<div class="col-lg-12">
													<label>Group Harga</label>
													<div class="form-group">
														<select class="select2 form-control-sm form-control" id="group_price" name="group_price">
															<option value="" disabled>- -Pilih- -</option>
															@foreach($data['group_harga'] as $group)
															<option value="{{ $group->pg_id }}">{{ $group->pg_name }}</option>
															@endforeach
														</select>
													</div>
												</div>

											</div>
										</div>

									</div>
								</fieldset>
							</form>

							<fieldset class="mb-3" id="input-barang">
								<div class="row">

									<div class="col-md-6 col-sm-12">
										<label>Pilih Barang / Jasa</label>
										<div class="form-group">
											<input type="hidden" name="itemId" id="itemId">
											<input type="hidden" name="itemName" id="itemName">
											<input type="hidden" name="itemSatId" id="itemSatId">
											<input type="hidden" name="itemSatName" id="itemSatName">
											<input type="text" class="form-control form-control-sm" name="barang" id="barang">
										</div>
									</div>

									<div class="col-md-3 col-sm-12">
										<label>Qty</label>
										<div class="form-group">
											<div class="input-group">
												<input type="text" min="0" id="qty" class="form-control form-control-sm currency-x text-right">
											</div>
										</div>
									</div>

									<div class="col-md-3 col-sm-12">
										<label>Kuantitas Stok</label>
										<div class="form-group">
											<input type="text" readonly="" class="form-control form-control-sm currency-x text-right" name="stock" id="stock">
										</div>
									</div>
								</div>
							</fieldset>

							<div class="table-responsive" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a; margin-top: 0px !important">
								<table class="table table-hover table-striped table-bordered" id="table_penjualan" cellspacing="0">
									<thead class="bg-primary">
										<tr>
											<th>Nama</th>
											<th width="5%">Jumlah</th>
											<th width="5%">Satuan</th>
											<th>Harga</th>
											<th width="5%">Disc Persen</th>
											<th>Disc Harga</th>
											<th>Total</th>
											<th width="1%">Aksi</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>

            	<div class="row">
            		<div class="col-md-4 offset-md-8 col-sm-5 offset-sm-7 col-xs-12">
									<fieldset>
										<form id="salesForm">
											<div class="row">
												<div class="col-md-12">
													<label>Total Penjualan</label>
													<div class="form-group">
														<input type="text" class="form-control form-control-sm currency text-right" readonly="" id="totalPenjualan" name="totalPenjualan" value="0">
													</div>
												</div>
												<div class="col-md-12">
													<label>Total Diskon</label>
													<div class="form-group">
														<input type="text" class="form-control form-control-sm currency text-right" readonly="" name="totalDisc" id="totalDisc" value="0">
													</div>
												</div>
												<div class="col-md-12">
													<label>PPn</label>
													<div class="form-group">
														<div class="input-group">
															<input type="text" min="0" class="form-control form-control-sm currency-x text-right" name="ppn" id="ppn" value="0">
															<div class="input-group-append">
																<span class="input-group-text">%</span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<label>Total Amount</label>
													<div class="form-group">
														<input type="text" class="form-control form-control-sm text-right currency text-right totalAmount" readonly="" id="totalAmount" name="totalAmount" value="0">
													</div>
												</div>
											</div>
										</form>
									</fieldset>
            		</div>
            	</div>

            </section>
        </div>
        <div class="card-footer text-right">
    	<button class="btn btn-primary" data-toggle="modal" data-target="#modal_bayar" type="button">Proses</button>
        </div>
    </div>
</div>
