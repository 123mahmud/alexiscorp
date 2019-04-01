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
                            <form id="data">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            <label>Tanggal Rencana Pembelian</label>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" name="pp_tanggal" id="pp_tanggal">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            <label>Suplier <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <select class="form-control form-control-sm select2" id="cari_sup" name="id_supplier" style="width: 100%;" >
                                                <option value=""> - Pilih Supplier</option>
                                                @foreach ($supplier as $data)
                                                  <option value="{{ $data->s_id }}"> {{ $data->s_code }} - {{ $data->s_company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="mt-2">
                                    <div class="row">
                                            <div class="col-md-3" style="padding: 0px">
                                                <div class="col-12">
                                                    <label>Masukan Kode / Nama</label>
                                                </div>
                                                <div class="col-12" style="padding: 3px">
                                                    <input type="text" class="form-control form-control-sm" id="searchitem" />
                                                    <input type="hidden" class="form-control input-sm " name="" id="i_id">
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="padding: 0px">
                                                <div class="col-12">
                                                    <label>Stok</label>
                                                </div>
                                                <div class="col-12" style="padding: 3px">
                                                    <input type="text" class="form-control form-control-sm text-right" readonly="" id="stock" />
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding: 0px">
                                                <div class="col-12">
                                                    <label>Harga</label>
                                                </div>
                                                <div class="col-12" style="padding: 3px">
                                                    <input type="text" class="form-control form-control-sm text-right" readonly="" id="ip_hargaPrev"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="padding: 0px">
                                                <div class="col-12">
                                                    <label>Jumlah</label>
                                                </div>
                                                <div class="col-12" style="padding: 3px">
                                                    <input type="text" class="form-control form-control-sm currency-x text-right" id="fQty" />
                                                </div>
                                            </div>
                                            <div class="col-md-1" style="padding: 0px">
                                                <div class="col-12">
                                                    <label>Satuan</label>
                                                </div>
                                                <div class="col-12" style="padding: 3px">
                                                    <select class="form-control form-control-sm" id="ip_sat"></select>
                                                </div>
                                            </div>
                                    </div>
                                </fieldset>
                            <div class="table-responsive mt-3" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
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
                                    <tbody id="div_item">

                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </section>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary simpanPlan" type="button" onclick="simpanPlan()" title="Simpan">Simpan</button>
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

        $('#fQty').keypress(function(e) 
        {   
            var charCode;
            if ((e.which && e.which == 13)) 
            {
                charCode = e.which;
            } 
            else if (window.event) 
            {
                e = window.event;
                charCode = e.keyCode;
            }
            if ((e.which && e.which == 13)) 
            {
                var item = $('#i_id').val();
                var satuan = $('#ip_sat').val();
                var qty = $("#fQty").val();
                if (item == '' || satuan == '' || qty == 0)
                {
                    toastr.warning('Data harus lengkap');
                    return false;
                }
                setFormDetail();
                $('#searchitem').val('');
                $('#i_id').val('');
                $('#stock').val('');
                $('#ip_hargaPrev').val('');
                $("#fQty").val('');
                $('#ip_sat').empty();
                $('#searchitem').focus();
                return false;
            }
        }); 

    });

    var index             = 0;
    var tamp              = [];
    function setFormDetail()
    {
        var item = $('#searchitem').val();
        var i_id = $('#i_id').val();
        var stok =  $('#stock').val();
        var harga = $('#ip_hargaPrev').val();
        var qty = $("#fQty").val();
        var satuan = $('#ip_sat').val();
        var hasil=satuan.split('|');
        var s_id = hasil[0];
        var s_name = hasil[1];
        var index = tamp.indexOf(i_id); 
        if ( index == -1 )
        {                   
            $('#div_item').append(
                '<tr class="detail'+i_id+'">'
                    //item
                    +'<td width="30%">'
                       +'<input style="width:100%" type="hidden" name="ppdt_item[]" value='+i_id+'>'
                       +'<div style="padding-top:6px">'+item+'</div>'
                    +'</td>'
                    //stock gudang
                    +'<td width="20%">'
                       +'<input type="text" class="form-control form-control-sm text-right" value="'+stok+'" readonly>'
                    +'</td>'
                    //Harga
                    +'<td width="15%">'
                       +'<input class="form-control form-control-sm text-right" name="ppdt_prevcost[]" value="'+harga+'" readonly>'
                    +'</td>'
                    //qty
                    +'<td width="20%">'
                       +'<input class="form-control form-control-sm text-right currenc" id="qty-'+i_id+'" name="ppdt_qty[]" value='+qty+'>'
                    +'</td>'
                    //satuan
                    +'<td width="10%">'
                       +'<input type="text" class="form-control form-control-sm" name="" value='+s_name+' readonly>'
                       +'<input type="hidden" class="form-control form-control-sm" name="ppdt_satuan[]" value='+s_id+' readonly>'
                    +'</td>'
                    //hapus tombol
                    +'<td width="5%">'
                       +'<button type="button" class="btn btn-danger btn_remove" id="'+i_id+'"><i class="fa fa-trash-o"></i></button>'
                    +'</td>'                            
                '</tr>'+
            );

            $('.currenc').inputmask("currency", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 0,
                autoGroup: true,
                prefix: '', //Space after $, this will not truncate the first character.
                rightAlign: false,
                oncleared: function () { self.Value(''); }
            }); 

            index++;
            tamp.push(i_id);          
        }
        else
        {                  
            var qtyLama = parseInt($('#qty-'+i_id).val().replace(/\./g, ''));
            qty = parseInt(qty.replace(/\./g, ''));
            var doubleQty = $('#qty-'+i_id).val(qtyLama + qty);        
        }
    }

    $(document).on('click', '.btn_remove', function(a)
    {
        var button_id = $(this).attr('id');
        var arrayIndex = tamp.findIndex(e => e === button_id);
        tamp.splice(arrayIndex, 1);
        $('.detail'+button_id).remove();
        $('#searchitem').focus();
    });

    function simpanPlan()
    {
    $('.simpanPlan').attr('disabled', 'disabled');
        $.ajax({
            url     :  baseUrl+'/purcahse-plan/store-plan',
            type    : 'GET', 
            data    :  $('#data').serialize(),
            dataType: 'json',
            success : function(response)
            {    
                if(response.status=='sukses')
                {
                    var nota = response.nota;                     
                    $.toast({
                        heading: nota,
                        text: 'Berhasil di Simpan',                        
                        bgColor: '#00b894',
                        textColor: 'white',
                        loaderBg: '#55efc4',
                        icon: 'success'
                    });
                    window.location = baseUrl+'/purchasing/rencanapembelian/rencanapembelian';
                }
                else
                {                      
                    $.toast({
                        heading: '',
                        text: 'Ada yang salah',
                        showHideTransition: 'plain',
                        icon: 'warning'
                    })
                    $('.simpanPlan').removeAttr('disabled', 'disabled');
                }
            }
        });
    }

</script>
@endsection
