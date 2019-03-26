@extends('main')

@section('content')


<article class="content">
    <div class="title-block text-primary">
        <h1 class="title"> Tambah Rencana Pembelian </h1>
        <p class="title-description">
            <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
            / <span>Purchasing</span>
            / <a href="{{route('rencanapembelian')}}"><span>Rencana Pembelian</span> </a>
            / <span class="text-primary" style="font-weight: bold;">Tambah Rencana Pembelian</span>
        </p>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                
                <div class="card">
                    <div class="card-header bordered p-2">
                        <div class="header-block">
                            <h3 class="title"> Tambah Rencana Pembelian </h3>
                        </div>
                        <div class="header-block pull-right">
                            <a href="{{route('rencanapembelian')}}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i></a>
                        </div>
                    </div>
                    <div class="card-block">
                        <section>
                            <form id="form_purchase_plan">
                                <fieldset>
                                    <div class="row">
                                        
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label>Kode Rencana Pembelian</label>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm" readonly placeholder="( Auto )">

                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label>Tanggal Rencana Pembelian</label>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="pp_tanggal" id="pp_tanggal">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label>Suplier <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select class="form-control form-control-sm " name="pp_supplier" id="pp_supplier">
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="mt-2">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="col-12">
                                                <label>Masukan Kode / Nama</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control form-control-sm" id="searchitem" />
                                                <input type="hidden" class="form-control input-sm " name="" id="i_id">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="col-12">
                                                <label>Stok</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control form-control-sm" readonly="" id="stock" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="col-12">
                                                <label>Harga / Satuan Utama</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control form-control-sm" readonly=""id="ip_hargaPrev"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="col-12">
                                                <label>Jumlah</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control form-control-sm" id="fQty" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <div class="col-12">
                                                <label>Satuan</label>
                                            </div>
                                            <div class="col-12">
                                            <select class="form-control form-control-sm" id="ip_sat"></select>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="table-responsive mt-3">
                                <table class="table table-hover table-striped table-bordered display nowrap" id="barang_table">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th width="35%">Kode - Barang</th>
                                            <th width="20%">Stok Gudang</th>
                                            <th width="20%">Harga / Satuan Utama</th>
                                            <th width="10%">Qty</th>
                                            <th width="10%">Satuan</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>KUY001 - SEMEN</td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" readonly=""/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" readonly=""/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" readonly=""/>
                                            </td>
                                            <td align="center">
                                                <div class="btn btn-group btn-sm">
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </section>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" type="button" onclick="insert_purchase_plan()" title="Simpan">Simpan</button>
                    <a href="{{route('rencanapembelian')}}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</section>
</article>

@endsection

@section('extra_script')
<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('click', '.btn-hapus', function(){
            $(this).parents('tr').remove();
        });

        $('#searchitem').focus();

        $("#searchitem").autocomplete({
               source: baseUrl + '/seach-item-purchase',
               minLength: 1,        
               select: function(event, ui) 
               { 
                  $('#searchitem').val(ui.item.label);
                  $('#i_id').val(ui.item.id);   
                  $('#stock').val(ui.item.stok+' '+ui.item.satTxt[0]);   
                  Object.keys(ui.item.sat).forEach(function(){
                         $('#ip_sat').append($('<option>', { 
                           value: ui.item.sat[key-1] +'|'+ ui.item.satTxt[key-1],
                           text : ui.item.satTxt[key-1]
                         }));
                         key++;
                  });   
                  $('#s_price').val(ui.item.satuan); 
                  $('#ip_hargaPrev').val(ui.item.prevCost);       
                  $("#fQty").focus();
               }
         }); 

        $( "#searchitem" ).focus(function() {
            var key = 1;
            var gudang = $('#gudang').val();
            $("#searchitem").autocomplete({
                source: baseUrl + '/seach-item-purchase',
                minLength: 1,        
                select: function(event, ui) 
                { 
                    $('#searchitem').val(ui.item.label);
                    $('#i_id').val(ui.item.id);   
                    $('#stock').val(ui.item.stok+' '+ui.item.satTxt[0]);   
                    Object.keys(ui.item.sat).forEach(function(){
                        $('#ip_sat').append($('<option>', { 
                           value: ui.item.sat[key-1] +'|'+ ui.item.satTxt[key-1],
                           text : ui.item.satTxt[key-1]
                        }));
                        key++;
                    });   
                    $('#s_price').val(ui.item.satuan); 
                    $('#ip_hargaPrev').val(ui.item.prevCost);       
                    $("#fQty").focus();
                }
            }); 
            $('#searchitem').val('');
            $('#i_id').val('');
            $('#stock').val('');
            $('#ip_hargaPrev').val('');
            $("#fQty").val('');
            $('#ip_sat').empty();
        }); 

    });

</script>
@endsection
