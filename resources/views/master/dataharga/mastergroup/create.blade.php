<!-- Modal -->
<div id="create" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h4 class="modal-title">Tambah Group Harga</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="groupHarga">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <label>Nama Group</label>
                        </div>
                        <div class="col-md-7 col-sm-12">
                            <input type="text" value="" name="pg_name" id="pg_name" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="tambahGroup()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>