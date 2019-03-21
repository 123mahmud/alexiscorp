<div class="tab-pane fade in active show" id="harga_khusus">
   <div class="card">
      <div class="card-header bordered p-2">
         <div class="header-block">
            <h3 class="title">Group Harga Khusus</h3>
         </div>
      </div>
      <div class="card-block">
         <section>
            <form id="ItemHarga">
            <div class="row">
               <div class="col-md-2 col-sm-12">
                  <label class="font-weight-bold">Pilih Group :</label>
               </div>
               <div class="col-md-6 col-sm-12">
                  <select class="form-control input-sm select2" name="group" id="idGroup" onchange="pilihGroup()" >
                     @foreach ($group as $grup)
                     <option value="{{ $grup->pg_id }}" data-type="{{ $grup->pg_type}}" >{{ $grup->pg_name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <fieldset class="mb-3 mt-3">
               <div class="row">
                  <div class="section-1 col-md-6 col-sm-12">
                     <div class="form-group">
                        <div class="col-12">
                           <label>Masukan Kode / Nama</label>
                        </div>
                        <div class="col-12">
                           <input type="text" id="bahan_baku" name="bahan_baku" class="form-control input-sm">
                           <input type="hidden" id="i_id" name="i_id" class="form-control">        
                           <input type="hidden" id="i_name" name="i_name" class="form-control">
                           <input type="hidden" id="i_code" name="i_code" class="form-control"> 
                        </div>
                     </div>
                  </div>
                  <div class="section-2 col-md-3 col-sm-12">
                     <div class="form-group">
                        <div class="col-12">
                           <label>Harga Khusus</label>
                        </div>
                        <div class="col-12">
                           <input type="text" id="qty" name="price" class="form-control text-right currency">
                        </div>
                     </div>
                  </div>
                  <div class="section-3 col-md-2 col-sm-12">
                     <div class="form-group">
                        <div class="col-12">
                           <label>Satuan</label>
                        </div>
                        <div class="col-12">
                            <select class="form-control" id="satuan" name="satuan"></select>
                        </div>
                     </div>
                  </div>
               </div>
            </fieldset>
            <div class="table-responsive">
               
               <table class="table table-hover table-striped" cellspacing="0" id="table_harga_khusus">
                  <thead class="bg-primary">
                     <tr align="center">
                        <th width="50%">Kode - Nama Item</th>
                        <th width="40%">Harga</th>
                        <th width="10%">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>

                  </tbody>
               </table>
            </div>
            </form>
         </section>
      </div>
   </div>
</div>