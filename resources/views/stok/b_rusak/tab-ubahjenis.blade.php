<div id="ubahjenis-tab" class="tab-pane fade">
  <div class="row">
    <div class="panel-body">

      <div class="col-md-3 col-sm-12 col-xs-12">
        <label class="tebal">Tanggal Barang Rusak</label>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
          <div class="input-daterange input-group">
            <input id="tanggal5" class="form-control input-sm datepicker1 " name="tanggal" type="text">
            <span class="input-group-addon">-</span>
            <input id="tanggal6" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="lihatUbahJenisByTgl()">
          <strong>
            <i class="fa fa-search" aria-hidden="true"></i>
          </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelUbahJenis()">
          <strong>
            <i class="fa fa-undo" aria-hidden="true"></i>
          </strong>
        </button>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-ubahjenis">
            <thead>
              <tr>
                <th style="text-align: center;" width="5%;">No</th>
                <th width="10%;">Tanggal</th>
                <th width="10%;">Dari</th>
                <th width="10%;">Kode</th>
                <th width="15%;">Kode | Barang</th>
                <th width="10%">Qty</th>
                <th width="10%">Satuan</th>
                <th width="10%">Keterangan</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>              
          </table> 
        </div>  
      </div>

    </div>
  </div>
</div>