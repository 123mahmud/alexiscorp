<div class="modal fade" id="modal-detail" role="dialog">
  <div class="modal-dialog modal-full" style="width: 90%;margin: auto; font-size:10pt;">
      
    <form method="get" action="#">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <h4 class="modal-title" style="color: white;">Detail Order Pembelian</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_detail"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 row" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">                          
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">No Order Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblNoOrder"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Cara Pembayaran</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCaraBayar"></label>
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Order Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglOrder"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nama Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaff"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Pengiriman</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglKirim"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Suplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplier"></label>
              </div>
            </div>

            <div id="append-modal-detail"></div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-order" class="table tabelan table-bordered table-striped">
              <thead class="bg-primary">
                <tr>
                  <th width="5%">No</th>
                  <th width="20%">Nama Item</th>
                  <th width="10%">Satuan</th>
                  <th width="10%">Qty</th>
                  <th width="10%">Stok Gudang</th>
                  <th width="15%">Harga Prev</th>
                  <th width="15%">Harga</th>
                  <th width="15%">Total</th>
                </tr>
              </thead>
              <tbody id="div_item">
              </tbody>
            </table>

            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">

              <div class="col-md-10 col-sm-12 col-xs-12">
                <label class="tebal" style="float: right;">Total Harga : </label>
              </div>

              <div class="col-md-2 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" readonly="" class="input-sm form-control" name="totalHarga">
                </div>
              </div>

              <div class="col-md-10 col-sm-12 col-xs-12">
                <label class="tebal" style="float: right;">Total Diskon : </label>
              </div>

              <div class="col-md-2 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" readonly="" class="input-sm form-control" name="diskonHarga">
                </div>
              </div>

              <div class="col-md-10 col-sm-12 col-xs-12">
                <label class="tebal" style="float: right;">PPN : </label>
              </div>

              <div class="col-md-2 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" readonly="" class="input-sm form-control" name="ppnHarga">
                </div>
              </div>

              <div class="col-md-10 col-sm-12 col-xs-12">
                <label class="tebal" style="float: right;">Total : </label>
              </div>

              <div class="col-md-2 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" readonly="" class="input-sm form-control" name="totalHargaFinal">
                </div>
              </div>
            </div>

          </div>
        </div>

        <div id="append-footer-detail" class="modal-footer" style="border-top: none;">
          <!-- Button di Script di purchasing/index.blade.php -->
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>