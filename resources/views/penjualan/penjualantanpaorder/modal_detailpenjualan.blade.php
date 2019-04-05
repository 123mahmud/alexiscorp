<!-- Modal -->
<div id="modal_detailpenjualan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-full" style="width: 90%;margin: auto; font-size:10pt;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Detail Penjualan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <form class="detail-penjualan">
          <fieldset class="mb-3">
            <div class="row">

              <div class="col-md-12 col-sm-12">
                <div class="row">
                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>Tanggal</label>
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="dt_date" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>No Nota</label>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm" id="dt_nota" readonly>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>Nama Pelanggan</label>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm" id="dt_customer" readonly>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </fieldset>
        </form>

        <div class="table-responsive" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a; margin-top: 0px !important">
          <table class="table table-hover table-striped table-bordered" id="table_detailpenjualan" cellspacing="0">
            <thead class="bg-primary">
              <tr>
                <th width="25%">Nama</th>
                <th width="5%">Jumlah</th>
                <th width="5%">Satuan</th>
                <th>Harga</th>
                <th width="5%">Disc Persen</th>
                <th>Disc Harga /pcs</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

        <br>
        <form class="detail-penjualan">
          <fieldset class="mb-3">
            <div class="row">

              <div class="col-md-12 col-sm-12">
                <div class="row">
                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>Sub-Total</label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                      </div>
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_subtotal" readonly>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>Total Diskon</label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                      </div>
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_totaldisc" readonly>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>PPN</label>
                    <div class="input-group">
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_ppn" readonly>
                      <div class="input-group-append">
                        <span class="input-group-text">%</span>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>Grand Total</label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                      </div>
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_grandtotal" readonly>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 col-lg-4">
                    <label>Total Bayar</label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                      </div>
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_totalpayment" readonly>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </fieldset>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
