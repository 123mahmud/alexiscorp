<div class="modal fade" id="modal_opsi" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
    <form method="post" id="form_opsi_rusak" name="formOpsiRusak">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Opsi pada gudang barang rusak</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <input type="hidden" name="idTabelHeader" id="id_tabel_header" class="form-control">
            <input type="hidden" name="idGudangHeader" id="id_gudang_header" class="form-control">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Pilihan Opsi</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <select class="form-control input-sm" id="pilihan_opsi" name="pilihanOpsi" style="width: 100%;">
                  <option value=""> - Pilih Opsi</option>
                  <option value="musnah"> Musnahkan Barang </option>
                  <option value="ubah_jenis"> Ubah Jenis </option>
                  <option value="kembali"> Kembalikan ke gudang asal </option>
                  {{-- <option value="jual"> Dijual </option> --}}
                </select>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;" id="header_form">
              <div class="tamma-bg" style="margin-bottom: 10px; padding-top:10px;padding-bottom:20px;" id="appending-form">
              </div>
            </div>
          </div>
          
        </div>
    
        <div class="modal-footer" style="border-top: none;">
        </div>


      </div>
      <!-- /Modal content-->
    </form>
  </div>
</div>