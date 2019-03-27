<div class="tab-pane fade in" id="history_rencana">
   <div class="card">
      <div class="card-header bordered p-3">
         <div class="header-block">
            <h3 class="title">History Rencana Pembelian</h3>
         </div>
      </div>
      <div class="card-block">
         <section>
            <div class="row">
               
               <div class="col-md-3 col-sm-12">
                  <label class="font-weight-bold">Tanggal Rencana</label>
               </div>
               <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                     <div class="input-group input-group-sm input-daterange">
                        <input type="text" class="form-control datepicker1" id="tanggal1" name="tanggal1">
                        <span class="input-group-addon">-</span>
                        <input type="text" class="form-control datepicker2" id="tanggal2" name="tanggal2">
                        <div class="input-group-append">
                           <button class="btn btn-primary" type="button" onclick="lihatHistorybyTgl()"><i class="fa fa-search"></i></button>
                           <button class="btn btn-secondary" type="button" onclick="lihatHistorybyTgl()"><i class="fa fa-refresh"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-3 col-sm-12">
                  <div class="form-group">
                     <select name="pp_status" id="tampil_data1" class="form-control form-control-sm" onchange="lihatHistorybyTgl()">
                        <option value="ALL">Tampilkan Data : Semua</option>
                        <option value="WT">Tampilkan Data : Waiting</option>
                        <option value="AP">Tampilkan Data : Disetujui</option>
                     </select>
                  </div>
               </div>
            </div>
            
            <div class="table-responsive">
               
               <table class="table table-hover table-striped" cellspacing="0" id="tbl-history">
                  <thead class="bg-primary">
                     <tr>
                        <th class="wd-15p">Kode Rencana</th>
                        <th class="wd-15p">Nama Barang</th>
                        <th class="wd-10p">Satuan</th>
                        <th class="wd-15p">Supplier</th>
                        <th class="wd-10p">Tgl Pemintaan</th>
                        <th class="wd-5p">Qty</th>
                        <th class="wd-10p">Tgl Confirm</th>
                        <th class="wd-5p">Qty Confirm</th>
                        <th class="wd-10p">Status</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                     
                  </tbody>
               </table>
            </div>
         </section>
      </div>
   </div>
</div>