<div class="tab-pane fade in" id="tab_pembayaran">
	<div class="card">

		<div class="card-block">
    		<section>
    			<div class="row">

                    <div class="col-md-3 col-sm-12">
                      <label class="font-weight-bold">Tanggal</label>
                    </div>

                    <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                        <div class="input-group input-group-sm input-daterange">
                          <input type="text" class="form-control" id="date_from_pb">
                          <span class="input-group-addon">-</span>
                          <input type="text" class="form-control" id="date_to_pb">
                          <div class="input-group-append">
                          	<button class="btn btn-primary" type="button" id="btn_search_date_pb"><i class="fa fa-search"></i></button>
                          	<button class="btn btn-secondary" type="button" id="btn_refresh_date_pb"><i class="fa fa-refresh"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>


            	</div>

    			<div class="table-responsive">
    				<table class="table table-bordered  table-hover table-striped" id="table_listpembayaran" cellspacing="0">
    					<thead class="bg-primary">
    						<tr>
    							<th width="1%">No</th>
    							<th>Nota</th>
    							<th>Customer</th>
                  <th>Total Amount</th>
                  <th>Status</th>
    							<th width="15%">Aksi</th>
    						</tr>
    					</thead>
    					<tbody>
    						<!-- <tr>
                  <td>1</td>
                  <td>POSTO/20190207/1</td>
                  <td>Charlie</td>
                  <td>
                    <div class="row">
                      <div class="col-5">Rp. </div><div class="col-7 text-right">20.000,00</div>
                    </div>
                  </td>
                  <td align="center"><label class="badge badge-pill bg-secondary text-white">Belum Bayar</label></td>
                  <td align="center">
                    <button class="btn btn-primary btn-sm" type="button" title="Bayar" data-toggle="modal" data-target="#modal_bayar"><i class="fa fa-money"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>POSTO/20181207/1</td>
                  <td>Delta</td>
                  <td>
                    <div class="row">
                      <div class="col-5">Rp. </div><div class="col-7 text-right">20.000,00</div>
                    </div>
                  </td>
                  <td align="center"><label class="badge badge-pill bg-success text-white">Lunas</label></td>
                  <td align="center">
                    <button class="btn btn-primary btn-sm" type="button" title="Bayar" data-toggle="modal" data-target="#modal_bayar"><i class="fa fa-money"></i></button>
                  </td>
                </tr> -->
    					</tbody>
    				</table>
    			</div>
    		</section>

		</div>


	</div>
</div>
