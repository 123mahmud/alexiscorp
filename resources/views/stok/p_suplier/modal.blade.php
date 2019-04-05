<div class="modal fade" id="modal_terima_beli" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
    
    <form method="post" id="form-terima-beli" name="formTerimaBeli">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Tambah Penerimaan Pembelian</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Nota Pembelian (PO)</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group" id="divSelectNota">
                <select class="form-control input-sm select2" id="head_nota_purchase" name="headNotaPurchase" style="width: 100% !important;">
                </select>
                <input type="hidden" name="headNotaTxt" id="head_nota_txt" class="form-control input-sm">
                <input type="hidden" name="headMethod" id="head_method" class="form-control input-sm">
              </div>  
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Penerimaan</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="head_tgl_terima" class="form-control input-sm datepicker2 " name="headTglTerima" type="text" value="{{ date('d-m-Y') }}">
              </div>  
            </div>
            
            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Staff</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" name="headStaff" id="head_staff" readonly="" class="form-control input-sm" value="{{Auth::user()->m_name}}">
                <input type="hidden" name="headStaffId" id="head_staff_id" class="form-control input-sm" value="{{Auth::User()->m_id}}">
              </div>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Supplier</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" name="headSupplier" id="head_supplier" readonly="" class="form-control input-sm">
                <input type="hidden" name="headSupplierId" id="head_supplier_id" readonly="" class="form-control input-sm">
              </div>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" name="headTotalGross" id="head_total_gross" readonly="" class="form-control input-sm hidden">
                <input type="text" name="headTotalDisc" id="head_total_disc" readonly="" class="form-control input-sm hidden">
                <input type="text" name="headTotalTax" id="head_total_tax" readonly="" class="form-control input-sm hidden">
                <input type="text" name="headTotalNett" id="head_total_nett" readonly="" class="form-control input-sm hidden">
                <input type="text" name="headTotalTerima" id="head_total_terima" readonly="" class="form-control input-sm hidden">
              </div>
            </div>

            <div id="appending"></div>
            
          </div>
          
          <div class="table-responsive">
            <table id="tabel-modal-terima" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="25%;">Kode | Barang</th>
                  <th width="7%">Qty</th>
                  <th width="7%">Qty Terima</th>
                  <th width="10%">Satuan</th>
                  <!-- <th width="13%">Harga</th>
                  <th width="15%">Total</th> -->
                  <th width="13%">Stok</th>
                  <th width="5%">Aksi</th>
                </tr>
              </thead>
              <tbody id="div_item">

              </tbody>
            </table>
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitTerima()" id="btn_simpan" disabled>Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->

  </div>

  </div>
</div>