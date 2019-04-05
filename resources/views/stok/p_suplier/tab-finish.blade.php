<div id="finish-tab" class="tab-pane fade">
    <div class="card">
        <div class="card-header bordered p-2">
            <div class="header-block">
                <h3 class="title">Konfirmasi Opname</h3>
            </div>
        </div>
        <div class="card-block">
            <section>
            <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal pembelian (PO)</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-daterange input-group">
                        <input id="tanggal3" class="form-control input-sm form-control-sm datepicker1 " name="tanggal" type="text">
                        <span class="input-group-addon">-</span>
                        <input id="tanggal4" class="input-sm form-control-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="listReceivedByTgl()">
                <strong>
                <i class="fa fa-search" aria-hidden="true"></i>
                </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelReceived()">
                <strong>
                <i class="fa fa-undo" aria-hidden="true"></i>
                </strong>
                </button>
            </div>
            <div class="table-responsive" style="padding-top: 15px;">
                <div id="tabelPenerimaanReceived">
                    <table class="table tabelan table-hover table-bordered dt-responsive" id="tbl-received" width="100%">
                        <thead class="bg-primary">
                            <tr>
                                <th>Kode PO</th>
                                <th>Supplier</th>
                                <th>Nama Item</th>
                                <th>Satuan</th>
                                <th width="5%">Qty PO</th>
                                <th width="5%">Qty Masuk</th>
                                <th>Tgl PO</th>
                                <th width="10%">Status</th>
                                <th width="5%">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </section>
    </div>
    </div>
</div>