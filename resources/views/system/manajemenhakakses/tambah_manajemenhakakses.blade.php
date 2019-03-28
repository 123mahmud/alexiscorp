@extends('main')
@section('content')
<article class="content">
    <div class="title-block text-primary">
        <h1 class="title"> Tambah Manajemen Hak Akses </h1>
        <p class="title-description">
            <i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
            / <span>Admin System</span>
            / <a href="{{route('manajemenhakakses')}}">Manajemen Hak Akses</a>
            / <span class="text-primary font-weight-bold">Tambah Manajemen Hak Akses</span>
        </p>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                
                <div class="card">
                    <div class="card-header bordered p-2">
                        <div class="header-block">
                            <h3 class="title"> Tambah Manajemen Hak Akses </h3>
                        </div>
                        <div class="header-block pull-right">
                            <a class="btn btn-primary" href="{{route('manajemenhakakses')}}"><i class="fa fa-arrow-left"></i></a>
                        </div>
                    </div>
                    <div class="card-block">
                        <section>
                            <form id="data">
                                {{csrf_field()}}
                                <div class="col-md-12 col-sm-12 col-xs-12 row" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Username:<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" id="username" class="form-control form-control-sm  input-sm" name="username"
                                            required>
                                            <span style="color:#ed5565;display:none;" class="help-block m-b-none"
                                            id="username-error"><small>Username harus diisi.</small></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Password:<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-2 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" id="password" class="form-control form-control-sm  input-sm"
                                            name="password">
                                        </div>
                                    </div>
                                    <i style="margin-top:5px;" toggle="#password" class="glyphicon form-control-feedback toggle-password glyphicon-eye-open"></i>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Nama Lengkap:<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" id="nama" class="form-control form-control-sm  input-sm" name="NamaLengkap">
                                            <input type="hidden" name="IdPegawai" class="form-control form-control-sm  input-sm ui-autocomplete-input">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Tanggal Lahir:<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control form-control-sm  input-sm" id="tgllahir" type="text" name="TanggalLahir" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Jabatan/Posisi:<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm  input-sm" name="pp_jabatan" id="pp_jabatan" readonly>
                                            <input type="hidden" class="form-control form-control-sm  input-sm" name="id_jabatan" id="id_jabatan" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Alamat:<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <textarea name="alamat" class="form-control form-control-sm " readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Outlet:<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <select class="js-example-basic-multiple form-control form-control-sm  input-sm" id="perusahaan" name="perusahaan[]" multiple="multiple">
                                            @foreach ($perusahaan as $key => $value)
                                            <option value="{{$value->c_id}}">{{$value->c_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div align="right" style="padding-top:10px;" class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="div_button_save" class="form-group">
                                            <button style="float: right;" class="btn btn-primary" onclick="simpan()"
                                            type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i>  &nbsp; Simpan User
                                            
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="detail">
                                    <label class="tebal">- Hak Akses User:<font color="red">*</font></label>
                                    <div class="table-responsive">
                                        <form class="row form-akses" style="padding-right: 18px; padding-left: 18px;">
                                            <table class="table tabelan table-bordered table-hover" id="table-akses">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th>Nama Fitur</th>
                                                        <th class="text-center">Read</th>
                                                        <th class="text-center">Insert</th>
                                                        <th class="text-center">Update</th>
                                                        <th class="text-center">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $nomor=1;
                                                    @endphp
                                                    @foreach($akses as $index => $data)
                                                    @if($data->a_parrent == 0)
                                                    <tr style="background: #f7e8e8">
                                                        <td>
                                                            <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                            {{$nomor}}. &nbsp; <strong>{{$data->a_name}}</strong>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <input type="hidden" value="N" class="checkbox" name="ma_read[]" id="iRead-{{$data->a_id}}">
                                                                <input type="checkbox" class="" onchange="simpanRead('{{$data->a_id}}')" id="cRead-{{$data->a_id}}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <input type="hidden" value="N" class="checkbox" name="ma_insert[]" id="iInsert-{{$data->a_id}}">
                                                                <input type="checkbox" class="" onchange="simpanInsert('{{$data->a_id}}')" id="cInsert-{{$data->a_id}}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <input type="hidden" value="N" class="checkbox" name="ma_update[]" id="iUpdate-{{$data->a_id}}">
                                                                <input type="checkbox" class="" onchange="simpanUpdate('{{$data->a_id}}')" id="cUpdate-{{$data->a_id}}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <input type="hidden" value="N" class="checkbox" name="ma_delete[]" id="iDelete-{{$data->a_id}}">
                                                                <input type="checkbox" class="" onchange="simpanDelete('{{$data->a_id}}')" id="cDelete-{{$data->a_id}}">
                                                            </div>
                                                        </td>
                                                        @php
                                                        $nomor++;
                                                        @endphp
                                                    </tr>
                                                    @else
                                                    
                                                    <td>
                                                        <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$data->a_name}}
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <input type="hidden" value="N" class="checkbox" name="ma_read[]" id="iRead-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanRead('{{$data->a_id}}')" id="cRead-{{$data->a_id}}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <input type="hidden" value="N" class="checkbox" name="ma_insert[]" id="iInsert-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanInsert('{{$data->a_id}}')" id="cInsert-{{$data->a_id}}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <input type="hidden" value="N" class="checkbox" name="ma_update[]" id="iUpdate-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanUpdate('{{$data->a_id}}')" id="cUpdate-{{$data->a_id}}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <input type="hidden" value="N" class="checkbox" name="ma_delete[]" id="iDelete-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanDelete('{{$data->a_id}}')" id="cDelete-{{$data->a_id}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                        <a style="float: right; margin-right: 10px;" type="button" class="btn btn-white"
                                        href="{{ url('system/hakuser/index') }}">Kembali</a>
                                    </form>
                                    
                                </section>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="button">Simpan</button>
                                <a href="{{route('manajemenhakakses')}}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
@endsection
@section('extra_script')
<script type="text/javascript">
    var iddinamis = 0;
    $(document).ready(function () {

        $('.js-example-basic-multiple').select2();

        $('input[name="NamaLengkap"]').focus(function() {
            var key = 1;
            $('input[name="NamaLengkap"]').autocomplete({
               source: baseUrl+'/system/hakuser/autocomplete-pegawai',
               minLength: 1,
               select: function(event, ui) {
                 $('input[name="NamaLengkap"]').val(ui.item.label);
                 $('input[name="IdPegawai"]').val(ui.item.id);
                 $('input[name="TanggalLahir"]').val(ui.item.lahir_txt);
                 $('input[name="id_jabatan"]').val(ui.item.jabatan_id);
                 $('input[name="pp_jabatan"]').val(ui.item.jabatan_txt);
                 $('textarea[name="alamat"]').text(ui.item.alamat_txt);
               }
             });
             $('input[name="NamaLengkap"]').val('');
             $('input[name="IdPegawai"]').val('');
             $('input[name="TanggalLahir"]').val('');
             $('input[name="id_jabatan"]').val('');
             $('input[name="pp_jabatan"]').val('');
             $('textarea[name="alamat"]').text('');
         });

    });

    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    function simpan() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.confirm({
            title: 'Ehem!',
            content: 'Apakah anda yakin?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Ya',
                    btnClass: 'btn-red',
                    action: function() {
                        $.ajax({
                            url: baseUrl + '/system/hakuser/simpan',
                            type: "POST",
                            dataType: "JSON",
                            data: $('#data').serialize() + '&' + $('.form-akses').serialize(),
                            success: function(response) {
                                if (response.status == "berhasil") {
                                    $.toast({
                                        heading: '',
                                        text: 'User berhasil tersimpan',
                                        bgColor: '#00b894',
                                        textColor: 'white',
                                        loaderBg: '#55efc4',
                                        icon: 'success'
                                    });
                                    window.location = baseUrl + '/system/manajemenhakakses/index';
                                    $('input[type=text]').val('');
                                    $('input[type=password]').val('');
                                    $('#alamat').val('');
                                    $('#perusahaan').val('').trigger('change');
                                    $('#gudang').val('').trigger('change');
                                } else {
                                    $.toast({
                                        heading: '',
                                        text: 'Mohon melengkapi data',
                                        showHideTransition: 'plain',
                                        icon: 'warning'
                                    })
                                }
                            }

                        })
                    }
                },
                close: function() {}
            }
        });
    }

    function simpanRead(id) {
        if ($('#cRead-' + id).prop('checked')) {
            $('#iRead-' + id).val('Y')
        } else {
            $('#iRead-' + id).val('N')
        }
    }

    function simpanInsert(id) {
        if ($('#cInsert-' + id).prop('checked')) {
            $('#iInsert-' + id).val('Y')
        } else {
            $('#iInsert-' + id).val('N')
        }
    }

    function simpanUpdate(id) {
        if ($('#cUpdate-' + id).prop('checked')) {
            $('#iUpdate-' + id).val('Y')
        } else {
            $('#iUpdate-' + id).val('N')
        }
    }

    function simpanDelete(id) {
        if ($('#cDelete-' + id).prop('checked')) {
            $('#iDelete-' + id).val('Y')
        } else {
            $('#iDelete-' + id).val('N')
        }
    }
</script>
@endsection