<!-- Modal -->
<div id="modal_update_status" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"  style="max-width: 12cm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Approve Rencana Pembelian</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <form id="form_update_status">
          <input type="hidden" name="pp_id">
          <fieldset>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="font-weight-bold">Status</label>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <select name="pp_status" class="form-control form-control-sm">
                  <option value="AP">Setuju</option>
                  <option value="NA">Tidak Setuju</option>
                </select>
              </div>

            </div>
          </fieldset>
        </form>
        <hr>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="approve_purchase_plan()">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>