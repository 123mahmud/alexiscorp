<div id="wait-tab" class="tab-pane fade">
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
                                <input id="tanggal1" class="form-control input-sm form-control-sm datepicker1 " name="tanggal" type="text" {{-- value="{{ date('d-m-Y') }}" --}}>
                                <span class="input-group-addon">-</span>
                                <input id="tanggal2" class="input-sm form-control-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="listWaitingByTgl()">
                        <strong>
                        <i class="fa fa-search" aria-hidden="true"></i>
                        </strong>
                        </button>
                        <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelWaiting()">
                        <strong>
                        <i class="fa fa-undo" aria-hidden="true"></i>
                        </strong>
                        </button>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                                <table class="table tabelan table-hover table-bordered" id="tbl-waiting">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Kode PO</th>
                                            <th>Supplier</th>
                                            <th>Nama Item</th>
                                            <th>Satuan</th>
                                            <th>Qty PO</th>
                                            <th>Qty Sisa</th>
                                            <th>Tgl PO</th>
                                            <th>Status</th>
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