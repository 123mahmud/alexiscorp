<!-- Modal -->
<div id="opsi_terima" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Pilih Barang yang Diterima</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <div class="table-responsive">
          <form id="isiTableOpsi">
          <table class="table table-striped table-hover table-bordered" id="table_opsi" cellspacing="0">
            <thead class="bg-primary">
              <tr>
                <th class="text-center">
                  <input type="checkbox" id="cekParent" onclick="myCheck()">
                </th>
                <th>Nama Item</th>
              </tr>
            </thead>
              <tbody id="isiTableTerima">
            
              </tbody>
          </table>
        </form>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" onclick="lanjutkan()">Lanjutkan</button>
      </div>
    </div>

  </div>
</div>