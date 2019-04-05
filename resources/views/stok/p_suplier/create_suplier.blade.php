@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->

<style type="text/css">
    
    .dis{
      pointer-events :none;
    }
</style>

<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Form Master Data Suplier</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Master Data Suplier</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Suplier&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <div class="page-content fadeInRight">
        <div id="tab-general">
            <div class="row mbl">
                <div class="col-lg-12">
                    
                                <div class="col-md-12">
                                    <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                                    </div>
                                </div>
                     
                  <ul id="generalTab" class="nav nav-tabs">
                    <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Suplier</a></li>
                    <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                    <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                  </ul>
                  <div id="generalTabContent" class="tab-content responsive">
                    <div id="alert-tab" class="tab-pane fade in active">
                      <div class="row">
                    
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                           <div class="col-md-5 col-sm-6 col-xs-8" >
                             <h4>Form Master Data Suplier</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                             <a href="{{ url('master/datasuplier/suplier') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                        </div>
                   
                  
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <form id="form_suplier">
                            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-top:30px;padding-bottom:20px;">
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                
                                    <label class="tebal">Kode Ref</label>
                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  
                                      <input type="text" id="code" name="code" class="form-control input-sm" readonly="" value="{{ $data_header->d_pcsp_code }}">
                                  
                                </div>
                              </div>

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                
                                    <label class="tebal">Suplier</label>
                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  <div class="input-icon right">
                                    <i class="fa fa-user"></i>
                                    <input type="text" id="sup" name="sup" class="form-control input-sm" readonly="" value="{{ $data_header->d_pcsp_sup }}">                
                                  </div>
                                </div>
                              </div>
                             
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                
                                    <label class="tebal">Delivery Order</label>
                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  
                                      <input type="text" id="do" name="do" class="form-control input-sm">
                                  
                                </div>
                              </div>

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                
                                    <label class="tebal">Date</label>
                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  <div class="input-icon right">
                                    <i class="fa fa-user"></i>
                                    <input type="text" id="date" name="date" class="form-control input-sm datepicker_today" >                
                                  </div>
                                </div>
                              </div>


                              <div class="col-md-2 col-sm-3 col-xs-12">
                                
                                    <label class="tebal">Date Confrom</label>
                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  <div class="input-icon right">
                                    <i class="glyphicon glyphicon-envelope"></i>
                                    <input type="text" id="datecreated" name="datecreated" readonly="" value="{{ $data_header->d_pcsp_dateconfirm }}" class="form-control input-sm">                
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-2 col-sm-3 col-xs-12">                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                              </div>

                               <div class="col-md-2 col-sm-3 col-xs-12">
                                
                                    <label class="tebal">Date Created</label>
                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  
                                      <input type="text" id="dateconfrim" name="dateconfrim" readonly="" value="{{ $data_header->d_pcsp_datecreated }}" class="form-control input-sm" >
                                  
                                </div>
                              </div>

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                
                                    <label class="tebal">Staff</label>
                                
                              </div>

                              <div class="col-md-4 col-sm-9 col-xs-12">
                                <div class="form-group">
                                  <div class="input-icon right">
                                      <i class="glyphicon glyphicon-user"></i>
                                      <input type="text" id="staff" name="staff" readonly="" value="{{ $data_header->d_pcsp_staff }}" class="form-control input-sm">
                                  </div>
                                </div>
                              </div>
                              
                            </div>


                            <div class="table-responsive">
                                <table class="table tabelan table-hover table-bordered" id="data">
                                  <thead>
                                    <tr>
                                      <th>Item</th>
                                      <th width="15%">Qty</th>
                                      <th width="15%">Confrim</th>
                                      <th width="15%">Remain</th>
                                      <th width="15%">comp</th>
                                      <th width="15%">Position</th>
                                      <th width="10%">Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($data_seq as $element)
                                      <tr>
                                        <td hidden="">
                                            
                                            <input type="hidden" name="hpp[]" value="{{ $element->m_pbuy }}">
                                            <input type="hidden" name="sell[]" value="{{ $element->m_pbuy }}">

                                        </td>
                                        <td><input type="hidden" name="item[]" value="{{ $element->i_id }}">{{ $element->i_name }}</td>
                                        <td><input type="text" name="qty_acc[]" class="dis form-control" readonly="" value="{{ $element->d_pcspdt_qty }}"></td>
                                        <td><input type="text" name="qty_confirm[]" class="form-control"  value="{{ $element->d_pcspdt_qtyconfirm }}"></td>
                                        <td><input type="text" name="qty_remain[]" class="dis form-control" readonly=""  value="{{ $element->d_pcspdt_qty }}"></td>
                                        <td>
                                            <select class="form-control" name="comp[]">
                                              @foreach ($comp as $comps)
                                                  <option value="{{ $comps->cg_id }}">{{ $comps->cg_id }} - {{ $comps->cg_cabang }}</option>
                                              @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="position[]">
                                              @foreach ($comp as $pos)
                                                  <option value="{{ $pos->cg_id }}">{{ $pos->cg_id }} - {{ $pos->cg_gudang }}</option>
                                              @endforeach
                                            </select>
                                        </td>
                                        <td>
                                          <button type="button" class="delete btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                      </tr>
                                    @endforeach
                                    {{-- <tr>
                                      <td>1</td>
                                      <td>06022018/PO/001</td>
                                      <td>Alpha</td>
                                      <td><span class="label label-info">Tidak Lengkap</span></td>
                                      <td>
                                        <button class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash-o"></i></button>
                                        <button class="btn-link" data-toggle="modal" data-target="#detail">Detail</button>
                                      </td>
                                    </tr> --}}
                                  </tbody>
                                </table>
                              </div>


                            <div align="right">
                              <div class="form-group" align="right">
                                <button type="button" onclick="simpan()" class="btn btn-primary">Simpan Data</button>
                              </div>
                            </div>
                            
                          </form>
                        </div>                                       
                      </div>
                    </div>
                          
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
                            
@endsection

@section("extra_scripts")
<script type="text/javascript">     
  $(document).ready(function(){
    
  var table = $('#data').DataTable({});
});

  function simpan()
  {
   
    var form = $('#form_suplier').serialize();
    $.ajax({
           type: "get",
           url: '{{ route('save_pensuplier') }}',
           data: form,
           success: function(sembarang){
            toastr["success"]("Suplier Berhasil ditambahkan", "Sukses");
            if(sembarang.status=='sukses_bos')
            {
              window.location = ('{{route("pensuplier")}}');
            }
           },
           error: function(){
            toastr["error"]("Terjadi Kesalahan", "Error");
           },
           // async: false
         });
  }

  $('#data tbody').on( 'click', '.delete', function () {
    var parents = $(this).parents('tr');    
    table
        .row(parents)
        .remove()
        .draw();

    });


</script>
@endsection                            
