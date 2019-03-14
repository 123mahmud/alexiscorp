<script>
  purchase_return = { pr_id : null};
  tabel_purchase_return = null;
  $(document).ready(function(){
    var hash = location.hash;
    if(hash != '') {
      $('[data-target="' + hash + '"]').trigger('click');
    }

  	tabel_detail = $('#tabel_detail').DataTable({
  		'columnDefs' : [
	  		{
	  			'targets' : [3, 4, 5, 6, 7],
	  			'className' : 'text-right'
	  		},
  		]
  	});

    tabel_detail_revisi_po = $('#tabel_detail_revisi_po').DataTable({
      'columnDefs' : [
          {
            targets : [3, 4, 5, 6, 7, 8, 9],
            className : 'text-right'
          }
      ]
    });

    // Set tanggal di pencarian
    $('#tgl_awal').val(
      moment().subtract(7, 'days').format('DD-MM-YYYY')
    );
    $('#tgl_akhir').val(
      moment().format('DD-MM-YYYY')
    );
    $('#tgl_awal_revisi').val(
      moment().subtract(7, 'days').format('DD-MM-YYYY')
    );
    $('#tgl_akhir_revisi').val(
      moment().format('DD-MM-YYYY')
    );
    $('#tgl_awal').datepicker({
      format : 'dd/mm/yyyy'
    });

    $('#tgl_akhir').datepicker({
      format : 'dd/mm/yyyy'
    });

    tabel_purchase_return = $("#tabel_purchase_return").DataTable({
      "processing" : true,
      "serverSide" : true,
      ajax: {
        "url": "{{ url('purchasing/returnpembelian/find_d_purchase_return') }}",
        
        data: function(data){
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
            data["_token"] = "{{ csrf_token() }}";
            data['tgl_awal'] = tgl_awal;
            data['tgl_akhir'] = tgl_akhir;

            return data;
        },
      },
      columns: [
        { data : 'pr_tanggal_label' },
    		{ data : 'pr_code' },
        { data : 'name' },
    		{ data : 'pr_method_label' },
        { data : 's_name' },
        { 
              data : null,
              render : function(res) {
                  var pr_pricetotal = res.pr_pricetotal;
                  pr_pricetotal = 'Rp ' + accounting.formatMoney(pr_pricetotal,"",0,'.',',');

                  return pr_pricetotal;
              }
        },
    		{ 
    			data : null,
    			render : function(res) {
              var classbadge;
              if(res.pr_status == 'WT') {
                classbadge = 'badge-info';
              }
              else if(res.pr_status == 'AP') {
                classbadge = 'badge-primary';
              }
              else if(res.pr_status == 'NA') {
                classbadge = 'badge-danger';
              }
      				var outp = '<span class="badge ' + classbadge + '">' + res.pr_status_label + '</span>';
      				return outp;
    			} 
    		},
    		{ 
    			data : null,
    			render : function(res) {
            is_disabled = 'disabled';
            if(res.pr_status == 'WT') {
              is_disabled = '';
            }
    				var outp = '<button ' + is_disabled + ' class="btn btn-info" title="Approve" data-toggle="modal" data-target="#modal_update_status" onclick="open_form_update_status(this)"><i class="fa fa-check"></i></button>';
    				return outp;
    			} 
		    },
        
        { 
          data : null,
          render : function(res) {
          	is_disabled = 'disabled';
            if(res.pr_status == 'WT') {	
            	is_disabled = '';
            }
            console.log(res);
            var btn = '<div class="btn-group btn-group-sm"><button onclick="open_form_detail(this) "type="button" class="btn btn-info return_detail" title="Detail" data-toggle="modal" data-target="#modal_detail_return"><i class="fa fa-list"></i></button><button type="button" ' + is_disabled + ' class="btn btn-warning return_edit" title="Edit" onclick="location.href = \'{{ url("purchasing/returnpembelian/edit_returnpembelian") }}/' + res.pr_id + '\'" data-toggle="modal" data-target="#detail_return_edit"><i class="fa fa-pencil"></i></button><button ' + is_disabled + ' type="button" class="btn btn-danger return_hapus" title="Hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button></div>';

            return btn;
          } 
        }
      ],
      columnDefs : [
        {
          targets : [6, 7, 8],
          className : 'text-center'
        },
        {
          targets : 5,
          className : 'text-right'
        }
      ]
    });

    tabel_revisi_purchase_order = $("#tabel_revisi_purchase_order").DataTable({
      "processing" : true,
      "serverSide" : true,
      ajax: {
        "url": "{{ url('purchasing/returnpembelian/find_d_purchase_order') }}",
        
        data: function(data){
            var tgl_awal = $('#tgl_awal_revisi').val();
            var tgl_akhir = $('#tgl_akhir_revisi').val();
            data["_token"] = "{{ csrf_token() }}";
            data['tgl_awal'] = tgl_awal;
            data['tgl_akhir'] = tgl_akhir;

            return data;
        },
      },
      columns: [
        { data : 'po_tanggal_label' },
        { data : 'po_code' },
        { data : 'name' },
        { data : 's_name' },
        { 
          data : null,
          render : function(res) {
            var outp = "<span class='badge badge-primary'>" + res.po_method + "</span>";

            return outp;
          } 
        },
        { data : 'po_total_net_label' },
        { data : 'po_tanggal_kirim_label' },
        { 
          data : null,
          render : function(res) {
              var outp = '<span class="badge badge-pill badge-warning">Revisi</span>';
              return outp;
          } 
        },
       
        { 
          data : null,
          render : function(res) {
            is_disabled = 'disabled';
            if(res.po_status == 'WT') { 
              is_disabled = '';
            }
            console.log(res);
            var btn = '<div class="btn-group btn-group-sm"><button onclick="open_form_detail_revisi_po(this) "type="button" class="btn btn-info order_detail" title="Detail" data-toggle="modal" data-target="#modal_detail_revisi_po"><i class="fa fa-list"></i></button></div>';

            return btn;
          } 
        }
      ],
      columnDefs : [
        {
          targets : [ 4, 7, 8],
          className : 'text-center'
        },
        {
          targets : 5,
          className : 'text-right'
        },
      ]
    });

  });
</script>