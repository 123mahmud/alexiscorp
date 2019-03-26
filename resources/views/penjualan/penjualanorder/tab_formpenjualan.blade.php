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

							<form id="customerForm">
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
																<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah_cust"><i class="fa fa-plus-square"></i></button>
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
														<textarea class="form-control" name="keterangan" id="ket-project"></textarea>
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
															<input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="orderDate">
															<div class="input-group-append">
																<button class="btn btn-primary btn-sm" type="button"><i class="fa fa-calendar"></i></button>
															</div>
														</div>
													</div>
												</div>

												<div class="col-lg-12">
													<label>Jatuh Tempo</label>
													<div class="form-group">
														<input type="text" class="form-control form-control-sm datepicker" name="dueDate">
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
                    				<input type="text" min="0" id="qty" class="form-control form-control-sm" name="">
                    				<div class="input-group-append">
                    					<button class="btn btn-primary btn-sm btn-tambah" type="button" title="Tambah"><i class="fa fa-plus"></i></button>
                    				</div>
                    			</div>
                			</div>
                		</div>

                		<div class="col-md-3 col-sm-12">
                			<label>Kuantitas Stok</label>
                			<div class="form-group">
                				<input type="text" readonly="" class="form-control form-control-sm" name="stock" id="stock">
                			</div>
                		</div>

                	</div>
                </fieldset>

                <div class="table-responsive mb-3">
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
                				<th width="1%"></th>
                			</tr>
                		</thead>
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
														<input type="hidden" id="totalPenjualanHidden" name="totalPenjualan">
														<input type="text" class="form-control form-control-sm currency text-right" readonly="" id="totalPenjualan" value="0">
													</div>
												</div>
												<div class="col-md-12">
													<label>Total Diskon</label>
													<div class="form-group">
														<input type="text" class="form-control form-control-sm text-right" readonly="" name="totalDisc" id="totalDisc" value="0">
													</div>
												</div>
												<div class="col-md-12">
													<label>PPn</label>
													<div class="form-group">
														<input type="number" class="form-control form-control-sm text-right" name="ppn" id="ppn" value="0">
													</div>
												</div>
												<div class="col-md-12">
													<label>Total Amount</label>
													<div class="form-group">
														<input type="hidden" id="totalAmountHidden" name="totalAmount">
														<input type="text" class="form-control form-control-sm text-right currency text-right totalAmount" readonly="" value="0">
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
