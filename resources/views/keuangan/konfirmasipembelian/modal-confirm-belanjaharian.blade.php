<div class="modal fade" id="modal-confirm-belanjaharian" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="post" id="form-confirm-belanjaharian">
      {{ csrf_field() }}
      <input type="hidden" name="idBelanja" id="id_belanja">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Konfirmasi Order Pembelian</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_belanja_confirm"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">                          
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Kode Belanja Harian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCodeBelanjaConfirm"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Belanja Harian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglBelanjaConfirm"></label>
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaffBelanjaConfirm"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Supplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplierBelanjaConfirm"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Belanja</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTotalBelanjaConfirm"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Bayar</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTotalBayarConfirm"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Status</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <select name="statusBelanjaConfirm" id="status_belanja_confirm" class="form-control input-sm">
                  <option value="WT">Waiting</option>
                  <option value="DE">Dapat diedit</option>
                  <option value="CF">Dikonfirmasi</option>
                </select>
              </div>
            </div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-belanja-confirm" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="20%;">Kode | Barang</th>
                  <th width="10%;">Qty</th>
                  <th width="10%;">Qty Confirm</th>
                  <th width="10%;">Satuan</th>
                  <th width="15%;">Harga Satuan</th>
                  <th class="15%;">Harga Total</th>
                  <th class="15%;">Stok</th>
                  <th width="5%;">Aksi</th>
                </tr> 
              </thead>
              <tbody id="div_item">

              </tbody>
            </table>
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitBelanjaConfirm()" id="button_confirm_belanja">Konfirmasi</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>