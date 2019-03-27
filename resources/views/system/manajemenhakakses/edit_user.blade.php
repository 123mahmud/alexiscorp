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
                                        <label class="tebal">Username
                                            <font color="red">*</font>
                                        </label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input id="m_id" type="hidden" class="form-control form-control-sm  input-sm" name="m_id"
                                            value="{{$mem->m_id}}">
                                            <input type="text" class="form-control form-control-sm  input-sm" name="Username"
                                            value="{{$mem->m_username}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Password Baru</label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm  input-sm" name="PassBaru"
                                            placeholder="Abaikan bila tidak Merubah">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Nama Lengkap
                                            <font color="red">*</font>
                                        </label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            @if ($mem->m_isadmin == 'N' && $mem->m_pegawai_id == null)
                                            <input type="text" class="form-control form-control-sm  input-sm" name="NamaLengkap"
                                            value="{{$mem->m_name}}" readonly>
                                            @elseif ($mem->m_isadmin == 'N' && $mem->m_pegawai_id != null)
                                            <input type="text" class="form-control form-control-sm  input-sm autocomplete" name="NamaLengkap"
                                            value="{{$mem->m_name}}">
                                            @elseif ($mem->m_isadmin == 'Y')
                                            <input type="text" class="form-control form-control-sm  input-sm" name="NamaLengkap"
                                            value="{{$mem->m_name}}" readonly>
                                            @endif
                                            <input type="hidden" name="IdPegawai" class="form-control form-control-sm  input-sm"
                                            value="{{$mem->m_pegawai_id}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Password Lama</label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm  input-sm" name="PassLama"
                                            disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Tanggal Lahir
                                            <font color="red">*</font>
                                        </label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control form-control-sm  input-sm" type="text" name="TanggalLahir"
                                            value="{{$mem->c_lahir}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Jabatan/Posisi
                                            <font color="red">*</font>
                                        </label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control form-control-sm  input-sm" type="text" name="pp_jabatan"
                                            id="pp_jabatan" value="{{$posisi->c_posisi}}" readonly>
                                            <input type="hidden" class="form-control form-control-sm  input-sm" name="id_jabatan"
                                            id="id_jabatan" value="{{$posisi->c_jabatan_id}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Alamat
                                            <font color="red">*</font>
                                        </label>
                                    </div>
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <textarea name="alamat" class="form-control form-control-sm " readonly>{{$mem->m_addr}}</textarea>
                                        </div>
                                    </div>
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <label class="tebal">Outlet:<font color="red">*</font></label>
                                        </div>
                                        <div class="col-md-3 col-sm-8 col-xs-12">
                                            <select class="js-example-basic-multiple form-control input-sm" id="perus" name="perusahaan[]" multiple="multiple">
                                                @foreach ($compGudang as $key => $value)
                                                <option value="{{$value->c_id}}">{{$value->c_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    <div align="right" style="padding-top:10px;" class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="div_button_save" class="form-group">
                                            <button type="button" id="button_save" class="btn btn-primary"
                                            onclick="perbaruiDataUser()">Update User
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
                                                    @foreach($mem_access as $index => $data)
                                                    @if($data->a_parrent == 0)
                                                    <tr style="background: #f7e8e8">
                                                        <td>
                                                            <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                            {{$nomor}}. &nbsp;
                                                            <strong>{{$data->a_name}}</strong>
                                                        </td>
                                                        <td>
                                                            @if($data->ma_read=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_read[]"
                                                            id="iRead-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanRead('{{$data->a_id}}')"
                                                            id="cRead-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_read[]"
                                                            id="iRead-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanRead('{{$data->a_id}}')"
                                                            id="cRead-{{$data->a_id}}">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->ma_insert=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_insert[]"
                                                            id="iInsert-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanInsert('{{$data->a_id}}')"
                                                            id="cInsert-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_insert[]"
                                                            id="iInsert-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanInsert('{{$data->a_id}}')"
                                                            id="cInsert-{{$data->a_id}}">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->ma_update=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_update[]"
                                                            id="iUpdate-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanUpdate('{{$data->a_id}}')"
                                                            id="cUpdate-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_update[]"
                                                            id="iUpdate-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanUpdate('{{$data->a_id}}')"
                                                            id="cUpdate-{{$data->a_id}}">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->ma_delete=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_delete[]"
                                                            id="iDelete-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanDelete('{{$data->a_id}}')"
                                                            id="cDelete-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_delete[]"
                                                            id="iDelete-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanDelete('{{$data->a_id}}')"
                                                            id="cDelete-{{$data->a_id}}">
                                                            @endif
                                                        </td>
                                                        @php
                                                        $nomor++;
                                                        @endphp
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$data->a_name}}
                                                        </td>
                                                        <td>
                                                            @if($data->ma_read=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_read[]"
                                                            id="iRead-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanRead('{{$data->a_id}}')"
                                                            id="cRead-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_read[]"
                                                            id="iRead-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanRead('{{$data->a_id}}')"
                                                            id="cRead-{{$data->a_id}}">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->ma_insert=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_insert[]"
                                                            id="iInsert-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanInsert('{{$data->a_id}}')"
                                                            id="cInsert-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_insert[]"
                                                            id="iInsert-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanInsert('{{$data->a_id}}')"
                                                            id="cInsert-{{$data->a_id}}">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->ma_update=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_update[]"
                                                            id="iUpdate-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanUpdate('{{$data->a_id}}')"
                                                            id="cUpdate-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_update[]"
                                                            id="iUpdate-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanUpdate('{{$data->a_id}}')"
                                                            id="cUpdate-{{$data->a_id}}">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->ma_delete=='Y')
                                                            <input type="hidden" value="Y" class="" name="ma_delete[]"
                                                            id="iDelete-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanDelete('{{$data->a_id}}')"
                                                            id="cDelete-{{$data->a_id}}" checked>
                                                            @else
                                                            <input type="hidden" value="N" class="" name="ma_delete[]"
                                                            id="iDelete-{{$data->a_id}}">
                                                            <input type="checkbox" class="" onchange="simpanDelete('{{$data->a_id}}')"
                                                            id="cDelete-{{$data->a_id}}">
                                                            @endif
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
    // function perbaruiDataUser() {
    //     var m_id = $('#m_id').val();
    //     $('#button_save').attr('disabled', true);
    //     $.ajax({
    //         url: baseUrl + '/system/hakuser/perbarui-user/' + m_id,
    //         type: 'GET',
    //         timeout: 10000,
    //         data: $('#data-user').serialize(),
    //         dataType: 'json',
    //         success: function (response) {
    //             if (response.status == "sukses") {
    //                 iziToast.success({
    //                     position: 'center',
    //                     title: 'Pemberitahuan',
    //                     message: response.pesan,
    //                     onClosing: function (instance, toast, closedBy) {
    //                         window.location = baseUrl + '/system/hakuser/index';
    //                         $('#button_save').attr('disabled', false);
    //                     }
    //                 });
    //             } else {
    //                 iziToast.error({
    //                     position: 'center',
    //                     title: 'Pemberitahuan',
    //                     message: response.pesan,
    //                     onClosing: function (instance, toast, closedBy) {
    //                         window.location = baseUrl + '/system/hakuser/index';
    //                         $('#button_save').attr('disabled', false);
    //                     }
    //                 });
    //             }
    //         },
    //         error: function () {
    //             iziToast.error({
    //                 position: 'topRight',
    //                 title: 'Pemberitahuan',
    //                 message: "Data gagal disimpan !"
    //             });
    //         }
    //     });
    // }

    function perbaruiDataUser() {
        var m_id = $('#m_id').val();
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
                            url: baseUrl + '/system/hakuser/perbarui-user/' + m_id,
                            type: "GET",
                            dataType: "JSON",
                            data: $('#data').serialize(),
                            success: function(response) {
                                if (response.status == "sukses") {
                                    $.toast({
                                        heading: '',
                                        text: 'User berhasil di update',
                                        bgColor: '#00b894',
                                        textColor: 'white',
                                        loaderBg: '#55efc4',
                                        icon: 'success'
                                    });
                                    window.location = baseUrl + '/system/manajemenhakakses/index';
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

    $(document).ready(function () {
        var extensions = {
            "sFilterInput": "form-control input-sm",
            "sLengthSelect": "form-control input-sm"
        }
        // Used when bJQueryUI is false
        $.extend($.fn.dataTableExt.oStdClasses, extensions);
        // Used when bJQueryUI is true
        $.extend($.fn.dataTableExt.oJUIClasses, extensions);

        $('.js-example-basic-multiple').select2();

        //autocomplete
        $('.autocomplete').focus(function () {
            var key = 1;
            $('.autocomplete').autocomplete({
                source: baseUrl + '/system/hakuser/autocomplete-pegawai',
                minLength: 1,
                select: function (event, ui) {
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

    $("#perusahaan").load("/master/datasuplier/tambah_suplier", function () {
        $("#perusahaan").focus();
    });

    $('input[name="PassBaru"]').keyup(function (event) {
        var str = $(this).val();
        if (str.trim() != '') {
            $('input[name="PassLama"]').attr('disabled', false);
        } else {
            $('input[name="PassLama"]').val('').attr('disabled', true);
        }
    });
</script>
@endsection