<!-- Modal -->
<div id="modal_bayar" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Pembayaran</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="paymentForm">
          <div class="row">

            <div class="col-md-3 col-sm-4 col-12">
              <label>Total Amount</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <input type="text" readonly="" class="form-control form-control-sm text-right currency text-right totalAmount" id="totalAmountM" value="0">
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-12">
              <label>Tanggal Bayar</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="paymentDate">
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-12">
              <label>Tipe Pembayaran</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <select class="form-control form-control-sm" name="paymentMethod">
                  <option value="" selected="" disabled="">--Pilih--</option>
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
                <input type="hidden" name="totalBayar" id="totalBayarHidden">
                <input type="text" class="form-control form-control-sm currency text-right" id="totalBayar">
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


            <div class="col-md-3 col-sm-4 col-12">
              <label>Keterangan</label>
            </div>
            <div class="col-md-9 col-sm-8 col-12">
              <div class="form-group">
                <textarea class="form-control" name="info"></textarea>
              </div>
            </div>

          </div>
        </form>

      </div>
      <div class="modal-footer">
        {{-- <button class="btn btn-secondary d-none" id="btn-rencanabahanbaku">Buat Rencana Bahan Baku</button> --}}
        <button class="btn btn-primary" id="btn_simpan" type="button">Simpan Pembayaran</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
