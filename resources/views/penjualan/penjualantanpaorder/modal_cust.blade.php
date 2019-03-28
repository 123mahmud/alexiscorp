<!-- Modal -->
<div id="tambah_cust" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Tambah Customer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="newCustomerForm">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <label>Nama Customer</label>
            </div>
            <div class="col-md-9 col-sm-6 col-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm" name="c_name" id="c_name">
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <label>Tanggal Lahir</label>
            </div>
            <div class="col-md-9 col-sm-6 col-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm datepicker" name="c_birthday">
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <label>E-mail</label>
            </div>
            <div class="col-md-9 col-sm-6 col-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm email" name="c_email">
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <label>Tipe Customer</label>
            </div>
            <div class="col-md-9 col-sm-6 col-12">
              <div class="form-group">
                <select class="form-control form-control-sm" name="c_type">
                  <option value="" disabled>Pilih tipe customer</option>
                  <option value="KT">Kontraktor</option>
                  <option value="HR">Harian</option>
                </select>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <label>No HP 1</label>
            </div>
            <div class="col-md-9 col-sm-6 col-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm hp" name="c_hp1">
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <label>No HP 2</label>
            </div>
            <div class="col-md-9 col-sm-6 col-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm hp" name="c_hp2">
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
              <label>Alamat</label>
            </div>
            <div class="col-md-9 col-sm-6 col-12">
              <div class="form-group">
                <textarea class="form-control" name="c_address" id="c_address"></textarea>
              </div>
            </div>

          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btn_simpan_customer">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
</div>
