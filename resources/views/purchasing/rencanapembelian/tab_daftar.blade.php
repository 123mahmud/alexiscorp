<div class="tab-pane fade in active show" id="daftar_rencana">
	<div class="card">
        <div class="card-header bordered p-2">
        	<div class="header-block">
                <h3 class="title"> Daftar Rencana Pembelian </h3>
            </div>
            <div class="header-block pull-right">
    			<a class="btn btn-primary" href="{{route('tambah_rencanapembelian')}}"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
    		</div>
        </div>
        <div class="card-block">
            <section>
            	
            	<div class="row">

                    <div class="col-md-3 col-sm-12">
                      <label class="font-weight-bold">Tanggal Rencana</label>
                    </div>

                    <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                        <div class="input-group input-group-sm input-daterange">
                          <input type="text" class="form-control datepicker2" id="tanggal3" name="tanggal1">
                          <span class="input-group-addon">-</span>
                          <input type="text" class="form-control datepicker2" id="tanggal4" name="tanggal4">
                          <div class="input-group-append">
                          	<button class="btn btn-primary" type="button" onclick="tablePlan()"><i class="fa fa-search"></i></button>
                          	<button class="btn btn-secondary" type="button" onclick="tablePlan()"><i class="fa fa-refresh"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <select name="pp_status" id="tampil_data" class="form-control form-control-sm" onchange="tablePlan()">
                                <option value="ALL">Tampilkan Data : Semua</option>
                                <option value="WT">Tampilkan Data : Waiting</option>
                                <option value="AP">Tampilkan Data : Disetujui</option>
                            </select>
                        </div>
                    </div>

            	</div>

            	
                	<div class="table-responsive">
                		
                		<table class="table table-hover table-striped" cellspacing="0" id="tablePlan">
                			<thead class="bg-primary">
                				<tr>
                					<th>Tgl Dibuat</th>
                					<th>Kode Rencana</th>
                					<th>Staff</th>
                					<th>Suplier</th>
                					<th>Tgl Disetujui</th>
                                    <th>Status</th>
                					<th>Aksi</th>
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