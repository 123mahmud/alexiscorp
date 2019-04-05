<div class="modal fade" id="modal_detail_peritem" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #e77c38;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: white;">Detail Penerimaan 
          <label class="tebal" id="lblHeadItem"></label>
        </h4>
      </div>

      <div class="modal-body">
        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
          <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
            <div class="col-md-2 col-sm-2 col-xs-12">
              <label class="tebal">Kode PO</label>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label id="lblHeadPo"></label>
              </div>  
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12">
              <label class="tebal">Jumlah Qty</label>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label id="lblHeadQty"></label>
              </div>  
            </div>
          </div>
          
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
            <div class="col-md-2 col-sm-2 col-xs-12">
              <label class="tebal">Tgl PO</label>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label id="lblHeadTglPo"></label>
              </div>  
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12">
              <label class="tebal">Supplier</label>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label id="lblHeadSup"></label>
              </div>  
            </div>
          </div>
        </div>
        
        <div class="table-responsive">
          <table id="tabel-detail-peritem" class="table tabelan table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center;" width="5%;">No</th>
                <th width="35%;">Nama Item</th>
                <th width="10%;">Satuan</th>
                <th width="10%">Qty Terima</th>
                <th width="20%;">Kode Terima</th>
                <th width="20%;">Tgl Terima</th>
              </tr>
            </thead>
            <tbody id="div_item">

            </tbody>
          </table>
        </div>

      </div>
  
      <div class="modal-footer" style="border-top: none;">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /Modal content-->
  </div>

  </div>
</div>