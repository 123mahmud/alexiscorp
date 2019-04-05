<div class="modal fade" id="modal-proses-ubahjenis" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="post" id="form-proses-ubahjenis" name="formProsesUbahJenis">
      {{ csrf_field() }}
      <input type="hidden" name="idStaffJenis" id="id_staff_jenis" class="form-control" value="{{Auth::user()->m_id}}">
      <input type="hidden" name="idHeaderJenis" id="id_header_jenis" class="form-control">
      <input type="hidden" name="idBrgRusak" id="id_brg_rusak" class="form-control">
      <input type="hidden" name="qtyBrgRusak" id="qty_brg_rusak" class="form-control">
      <input type="hidden" name="codeBrgRusak" id="code_brg_rusak" class="form-control">
      <input type="hidden" name="satBrgRusak" id="sat_brg_rusak" class="form-control">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Proses Ubah Jenis</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">


            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Kode Barang Rusak</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblKodeRusakJenis"></label>
              </div>  
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Nama Barang</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblNamaBarangJenis"></label>
              </div>  
            </div>
            
            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Qty</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblQtyJenis"></label>
              </div>  
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Staff</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaffJenis">{{Auth::user()->m_name}}</label>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Dari</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblPemberiJenis"></label>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Ubah Jenis</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="head_tgl_ujenis" class="form-control input-sm datepicker2 " name="headTglUjenis" type="text" value="{{ date('d-m-Y') }}">
              </div>  
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Keterangan</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblKeteranganEdit"></label>
              </div>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Pilih Gudang Tujuan</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group" id="divSelectNotaJenis">
                <select class="form-control input-sm select2" id="head_gudang_jenis" name="headGudangJenis" style="width: 100% !important;">
                </select>
              </div>  
            </div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-ubahjenis" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="30%;">Kode | Barang</th>
                  <th width="15%">Qty</th>
                  <th width="10%">Satuan</th>
                  <th width="15%">Stok</th>
                  <th width="20%">Keterangan</th>
                  <th width="5%">Aksi</th>
                </tr>
              </thead>
              <tbody id="div_item_jenis">
                <tr>
                  <td width="5%;" style="text-align: center;"><strong>#</strong></td>
                  <td width="25%;">
                    <input type="hidden" id="ip_item_jenis" class="form-control" value="" name="ipItemJenis">
                    <input type="hidden" id="ip_scomp_jenis" class="form-control" value="" name="ipScompJenis">
                    <input type="hidden" id="ip_spos_jenis" class="form-control" value="" name="ipSposJenis">
                    <input type="text" id="ip_barang_jenis" class="form-control ui-autocomplete-input input-sm" placeholder="Masukkan nama barang" autocomplete="off" name="ipBarangJenis">
                  </td>
                  <td width="10%;">
                    <input type="text" id="ip_qtyreq_jenis" class="form-control input-sm numberinput" value="" name="ipQtyReqJenis">
                  </td>
                  <td width="10%;">
                    <select class="form-control input-sm" id="ip_sat_jenis" name="ipSatJenis" style="width: 100%;">
                    </select>
                  </td>
                  <td>
                    <input type="text" id="ip_qtyStok_jenis" class="form-control input-sm" value="" name="ipQtyStokJenis" readonly>
                  </td>
                  <td width="15%;">
                    <input type="text" id="ip_keterangan_jenis" class="form-control input-sm" value="" name="ipKeteranganJenis">
                    <input type="hidden" id="ip_harga_jenis" class="form-control input-sm" name="ipHargaJenis">
                    <input type="hidden" id="ip_hargatotal_jenis" class="form-control input-sm" name="ipHargaJenis">
                  </td>
                  <td>
                    <button id="add_item" onclick="addItemRow2()" type="button" class="btn btn-info btn-sm" title="tambah"><i class="fa fa-plus"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitUbahJenis()" id="btn_submit_jenis">Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>