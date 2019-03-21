@extends('main')

@section('content')

@include('master.dataharga.mastergroup.create')
@include('master.dataharga.mastergroup.edit')
<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Data Harga </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a> 
	    	/ <span>Master Data</span> 
	    	/ <span class="text-primary font-weight-bold">Data Harga</span>
	     </p>
	</div>

	<section class="section">

		<ul class="nav nav-pills">
            <li class="nav-item">
                <a href="" class="nav-link active" data-target="#harga_khusus" aria-controls="harga_khusus" data-toggle="tab" role="tab">Group Harga Khusus</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link" data-target="#master_group" aria-controls="master_group" data-toggle="tab" role="tab" onclick="masterGroup()">Master Group</a>
            </li>
        </ul>

		<div class="row">


			<div class="col-12">

                <div class="tab-content">
                	@include('master.dataharga.hargakhusus.index')
                	@include('master.dataharga.mastergroup.index')
	            </div>

			</div>

		</div>

	</section>

</article>

@endsection
@section('extra_script')
<script>
    $(document).ready( function () {

    	pilihGroup();

    	$( "#bahan_baku" ).focus(function()
	    {
	        var key = 1;
	        $( "#bahan_baku" ).autocomplete({
	          source: baseUrl+'/master/grouphargakhusus/autocomplete',
	          minLength: 1,
	          select: function(event, ui) {
	            $('#i_id').val(ui.item.id);
	            $('#i_name').val(ui.item.name);
	            Object.keys(ui.item.satuan).forEach(function(){
	              $('#satuan').append($('<option>', { 
	                value: ui.item.id_satuan[key-1],
	                text : ui.item.satuan[key-1]
	                }));
	              key++;
	            });
	            $('#i_code').val(ui.item.i_code);
	            $("input[name='price']").focus();
	            }
	        });
	        $("#satuan").empty();
	        $("#bahan_baku" ).val('');
	        $("input[name='price']").val('');
	    });

	    $('#qty').keypress(function(e)
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
	          var bahan_baku  = $('#bahan_baku').val();
	          var qty         = $('#qty').val();
	          var satuan      = $('#satuan').val();
	          if(bahan_baku == '' || qty == '')
	          {
	            toastr.warning('Item dan Jumlah tidak boleh kosong!!');
	            return false;
	          }
	          else
	          {
	            tambahItemHarga();
	              $('#bahan_baku').val('');
	              $('#satuan').val('');
	              $('#qty').val('');
	              $("input[name='bahan_baku']").focus(); 
	               return false;
	          }

	        }
	    });

    } );

    function pilihGroup(){
        var x = document.getElementById("idGroup").value;
        $('#table_harga_khusus').dataTable().fnDestroy();
        $('#table_harga_khusus').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url: baseUrl + '/master/grouphargakhusus/tablegroup/'+x,
            },
            "columns": [
            { "data": "i_name", width: '60%' },
            { "data": "ip_price", width: '30%' },
            { "data": "action", width: '10%' },
            ],
            "responsive":true,

                  "pageLength": 10,
                "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
                "language": {
                    "searchPlaceholder": "Cari Data",
                    "emptyTable": "Tidak ada data",
                    "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                    "sSearch": '<i class="fa fa-search"></i>',
                    "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                    "infoEmpty": "",
                    "paginate": {
                            "previous": "Sebelumnya",
                            "next": "Selanjutnya",
                         }
                  }
        });
    }

    function tambahItemHarga(){
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
        $.ajax({
            url: baseUrl + "/master/grouphargakhusus/tambahItemHarga",
            type: 'GET',
            data: $('#ItemHarga').serialize(),
            success: function (response) {
                if (response.status == 'sukses') {
                    pilihGroup();
                    $("#satuan").empty();
                    $("#bahan_baku" ).val('');
                    $("input[name='price']").val('');
                    $.toast({
	                  heading: '',
	                  text: 'Berhasi tambah data.',
	                  bgColor: '#00b894',
	                  textColor: 'white',
	                  loaderBg: '#55efc4',
	                  icon: 'success'
	               });
                } else {
                    $.toast({
	                   heading: '',
	                   text: 'Gagal tambah data.',
	                   showHideTransition: 'plain',
	                   icon: 'warning'
	               })
                }
            }
        })
    }

    function hapus(id)
   	{
		$.confirm({
			title: 'Ehem!',
			content: 'Apakah anda yakin?',
			type: 'red',
			typeAnimated: true,
			buttons: {
			tryAgain: {
			   text: 'Ya',
			   btnClass: 'btn-red',
			   action: function(){
			   		var idGroup = $('#idGroup').val();
			      	$.ajax({
			         url: baseUrl +'/master/grouphargakhusus/itemharga/hapus/'+id,
			         type: "get",
			         dataType: "JSON",
			         data: {idGroup},
			         success: function(response)
			         {
			            if(response.status == "sukses")
			            {
			               $('#table_harga_khusus').DataTable().ajax.reload();
			               $.toast({
			                  heading: '',
			                  text: 'Berhasi hapus data.',
			                  bgColor: '#00b894',
			                  textColor: 'white',
			                  loaderBg: '#55efc4',
			                  icon: 'success'
			               });
			            }
			            else
			            {
			               $.toast({
			                   heading: '',
			                   text: 'Gagal hapus data.',
			                   showHideTransition: 'plain',
			                   icon: 'warning'
			               })
			            }
			         }
			         
			      })
			   }
			},
			close: function () {
			}
			}
		});
   	}

   	function masterGroup()
   	{
        $('#tb_group').dataTable().fnDestroy();
        tbGroup = $('#tb_group').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url: baseUrl + '/master/grouphargakhusus/mastergroup',
            },
            "columns": [
            { "data": "pg_name", width: '90%' },
            { "data": "action", width: '10%' },
            ],
            "responsive":true,

                  "pageLength": 10,
                "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
                "language": {
                    "searchPlaceholder": "Cari Data",
                    "emptyTable": "Tidak ada data",
                    "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                    "sSearch": '<i class="fa fa-search"></i>',
                    "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                    "infoEmpty": "",
                    "paginate": {
                            "previous": "Sebelumnya",
                            "next": "Selanjutnya",
                         }
                  }
        });
    }

    function ubahStatus(id)
   	{
		$.confirm({
			title: 'Ehem!',
			content: 'Apakah anda yakin?',
			type: 'red',
			typeAnimated: true,
			buttons: {
			tryAgain: {
			   text: 'Ya',
			   btnClass: 'btn-red',
			   action: function(){
			      	$.ajax({
			         url: baseUrl + "/master/grouphargakhusus/ubahstatusgrup/" + id,
			         type: "get",
			         dataType: "JSON",
			         success: function(response)
			         {
			            if(response.status == "sukses")
			            {
			            	$('#tb_group').DataTable().ajax.reload();
							$.toast({
								heading: '',
								text: 'Berhasi update data.',
								bgColor: '#00b894',
								textColor: 'white',
								loaderBg: '#55efc4',
								icon: 'success'
							});
			            }
			            else
			            {
			               $.toast({
			                   heading: '',
			                   text: 'Gagal update data.',
			                   showHideTransition: 'plain',
			                   icon: 'warning'
			               })
			            }
			         }
			         
			      })
			   }
			},
			close: function () {
			}
			}
		});
   	}

   	function tambahGroup()
   	{
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
        $('.submit-group').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + "/master/grouphargakhusus/tambahgroup/baru",
            type: 'GET',
            data: $('#groupHarga').serialize(),
            success: function (response) {
                if (response.status == 'sukses') {
                	$('#tb_group').DataTable().ajax.reload();
                	$('#pg_name').val('');
                    $.toast({
						heading: '',
						text: 'Berhasi tambah data.',
						bgColor: '#00b894',
						textColor: 'white',
						loaderBg: '#55efc4',
						icon: 'success'
					});
                    
                } else {
                    $.toast({
	                   heading: '',
	                   text: 'Gagal tambah data.',
	                   showHideTransition: 'plain',
	                   icon: 'warning'
	               	})
                    $('.submit-group').removeAttr('disabled', 'disabled');
                }
            }
        })
    }

    function edit(id){
	    $.ajax({
	      url : baseUrl + "/master/dataharga/edit",
	      type: 'GET',
	      data: {x:id},
	      success : function(response){
	      	$('#pg_code').val(response.status.pg_code);
	      	$('#pg_id').val(response.status.pg_id);
	      	$('#pg_name').val(response.status.pg_name);
	      	$('#edit').modal('show');
	      },
	      error: function (jqXHR, textStatus, errorThrown)
	      {
	          alert('Error get data from ajax');
	      }
	    });
	}

	function updateGroup(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $('#pg_id').val();
        $.ajax({
            url: baseUrl + "/master/grouphargakhusus/updategroup/" + id,
            type: 'GET',
            data: $('#group').serialize(),
            success: function (response) {
                if (response.status == 'sukses') {
                    $('#tb_group').DataTable().ajax.reload();
                    $.toast({
						heading: '',
						text: 'Berhasi update data.',
						bgColor: '#00b894',
						textColor: 'white',
						loaderBg: '#55efc4',
						icon: 'success'
					});
                } else {
                    $.toast({
	                   heading: '',
	                   text: 'Gagal tambah data.',
	                   showHideTransition: 'plain',
	                   icon: 'warning'
	               	})
                    $('.submitDivisi').removeAttr('disabled', 'disabled');
                }
            }
        })
        }

</script>
@endsection
