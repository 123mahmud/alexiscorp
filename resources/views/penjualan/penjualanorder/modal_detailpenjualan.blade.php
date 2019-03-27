<!-- Modal -->
<div id="modal_detailpenjualan" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

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
                  <div class="col-md-6 col-lg-6">
                    <label>Tanggal</label>
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="dt_date" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-6">
                    <label>No Nota</label>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm" id="dt_nota" readonly>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-6">
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
                <th>Disc Harga</th>
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
                  <div class="col-md-6 col-lg-6">
                    <label>Sub-Total</label>
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control form-control-sm currency text-right" id="dt_subtotal" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-6">
                    <label>Total Diskon</label>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_totaldisc" readonly>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-6">
                    <label>Grand Total</label>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_grandtotal" readonly>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-6">
                    <label>Total Bayar</label>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm currency text-right" id="dt_totalpayment" readonly>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </fieldset>
        </form>

          <!-- <div class="row">
            <div class="col-md-3 col-sm-4 col-12">
              <label>Total Amount</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <input type="text" readonly="" class="form-control form-control-sm text-right currency text-right totalAmount" id="totalAmountM" value="0">
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-12">
              <label>Tipe Pembayaran</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <select class="form-control form-control-sm" name="paymentMethod">
                  <option value="" disabled="">--Pilih--</option>
                  @foreach($data['tipe_pembayaran'] as $method)
                  <option value="{{ $method->pm_id }}">{{ $method->pm_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-12">
              <label>Jumlah Bayar</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm currency text-right" id="totalBayar" name="totalBayar">
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-12">
              <label>Kembalian</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <input type="text" readonly="" class="form-control form-control-sm currency text-right" name="kembalian" id="kembalian">
              </div>
            </div>

          </div>
           -->

      </div>
      <div class="modal-footer">
        {{-- <button class="btn btn-secondary d-none" id="btn-rencanabahanbaku">Buat Rencana Bahan Baku</button> --}}
        <button class="btn btn-primary" id="btn_simpan" type="button" disabled>Simpan Pembayaran</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
