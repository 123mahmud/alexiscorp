<div class="modal fade" id="modal_barang_rusak" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
    
    <form method="post" id="form-barang-rusak" name="formBarangRusak">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Tambah Barang Rusak</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Pilih Gudang Asal</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group" id="divSelectNota">
                <select class="form-control input-sm select2" id="head_gudang" name="headGudang" style="width: 100% !important;">
                </select>
              </div>  
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Pemakaian</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="head_tgl_pakai" class="form-control input-sm datepicker2 " name="headTglPakai" type="text" value="{{ date('d-m-Y') }}">
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
              <label class="tebal">Diterima dari</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" name="headPemberi" id="head_pemberi" class="form-control input-sm">
              </div>
            </div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-barang-rusak" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="25%;">Kode | Barang</th>
                  <th width="7%">Qty</th>
                  <th width="10%">Satuan</th>
                  <th width="13%">Stok</th>
                  <th width="13%">Keterangan</th>
                  <th width="5%">Aksi</th>
                </tr>
              </thead>
              <tbody id="div_item">
                 <tr>
                    <td width="5%;" style="text-align: center;"><strong>#</strong></td>
                    <td width="25%;">
                       <input type="hidden" id="ip_item" class="form-control" value="" name="ipItem">
                       <input type="hidden" id="ip_scomp" class="form-control" value="" name="ipScomp">
                       <input type="hidden" id="ip_spos" class="form-control" value="" name="ipSpos">
                       <input type="text" id="ip_barang" class="form-control ui-autocomplete-input input-sm" placeholder="Masukkan nama barang" autocomplete="off" name="ipBarang">
                    </td>
                    <td width="10%;">
                       <input type="text" id="ip_qtyreq" class="form-control input-sm numberinput" value="" name="ipQtyReq">
                    </td>
                    <td width="10%;">
                       <select class="form-control input-sm" id="ip_sat" name="ipSat" style="width: 100%;">
                       </select>
                    </td>
                    <td>
                       <input type="text" id="ip_qtyStok" class="form-control input-sm" value="" name="ipQtyStok" readonly>
                    </td>
                    <td width="15%;">
                       <input type="text" id="ip_keterangan" class="form-control input-sm" value="" name="ipKeterangan">
                       <input type="hidden" id="ip_harga" class="form-control input-sm" name="ipHarga">
                       <input type="hidden" id="ip_hargaTotal" class="form-control input-sm" name="ipHargaTotal">
                    </td>
                    <td>
                       <button id="add_item" onclick="addItemRow()" type="button" class="btn btn-info btn-sm" title="tambah"><i class="fa fa-plus"></i></button>
                    </td>
                 </tr>
              </tbody>
            </table>
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitPakai()" id="btn_simpan" disabled>Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->

  </div>

  </div>
</div>