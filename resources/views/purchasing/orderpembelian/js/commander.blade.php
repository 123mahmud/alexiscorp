<script>
  purchase_order = { po_id : null};
  tabel_purchase_order = null;
  $(document).ready(function(){
    var hash = location.hash;
    if(hash != '') {
      $('[data-target="' + hash + '"]').trigger('click');
    }

  	tabel_detail = $('#tabel_detail').DataTable({
  		'columnDefs' : [
	  		{
	  			'targets' : [2, 4, 5, 6, 7],
	  			'className' : 'text-right'
	  		},
  		]
  	});

    // Set tanggal di pencarian
    $('#tgl_awal').val(
      moment().subtract(7, 'days').format('DD-MM-YYYY')
    );
    $('#tgl_akhir').val(
      moment().format('DD-MM-YYYY')
    );
    $('#tgl_awal_tanparencana').val(
      moment().subtract(7, 'days').format('DD-MM-YYYY')
    );
    $('#tgl_akhir_tanparencana').val(
      moment().format('DD-MM-YYYY')
    );
    $('#tgl_awal_history').val(
      moment().subtract(7, 'days').format('DD-MM-YYYY')
    );
    $('#tgl_akhir_history').val(
      moment().format('DD-MM-YYYY')
    );
    $('#tgl_awal').datepicker({
      format : 'dd/mm/yyyy'
    });

    $('#tgl_akhir').datepicker({
      format : 'dd/mm/yyyy'
    });

    tabel_purchase_order_tanparencana = $("#tabel_purchase_order_tanparencana").DataTable({
      "processing" : true,
      "serverSide" : true,
      ajax: {
        "url": "{{ url('purchasing/orderpembelian/find_d_purchase_order') }}",
        
        data: function(data){
            var tgl_awal = $('#tgl_awal_tanparencana').val();
            var tgl_akhir = $('#tgl_akhir_tanparencana').val();
            
            data["_token"] = "{{ csrf_token() }}";
            data['use_purchase_plan'] = 'no';
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
              var classbadge;
              if(res.po_status == 'WT') {
                classbadge = 'badge-info';
              }
              else if(res.po_status == 'AP') {
                classbadge = 'badge-primary';
              }
              else if(res.po_status == 'NA') {
                classbadge = 'badge-danger';
              }
              var outp = '<span class="badge ' + classbadge + '">' + res.po_status_label + '</span>';
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
            var outp = '<button ' + is_disabled + ' class="btn btn-info" title="Approve" data-toggle="modal" data-target="#modal_update_status" onclick="open_form_update_status(this)"><i class="fa fa-check"></i></button>';
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
            var btn = '<div class="btn-group btn-group-sm"><button onclick="open_form_detail(this) "type="button" class="btn btn-info order_detail" title="Detail" data-toggle="modal" data-target="#modal_detail_order"><i class="fa fa-list"></i></button><button type="button" ' + is_disabled + ' class="btn btn-warning order_edit" title="Edit" onclick="location.href = \'{{ url("purchasing/orderpembelian/edit_orderpembelian") }}/' + res.po_id + '\'" data-toggle="modal" data-target="#detail_order_edit"><i class="fa fa-pencil"></i></button><button ' + is_disabled + ' type="button" class="btn btn-danger order_hapus" title="Hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button></div>';

            return btn;
          } 
        }
      ],
      columnDefs : [{
        targets : [4, 7, 8, 9],
        className : 'text-center'
      }]
    });

    tabel_purchase_order = $("#tabel_purchase_order").DataTable({
      "processing" : true,
      "serverSide" : true,
      ajax: {
        "url": "{{ url('purchasing/orderpembelian/find_d_purchase_order') }}",
        
        data: function(data){
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
            data["_token"] = "{{ csrf_token() }}";
            data['use_purchase_plan'] = 'yes';
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
              var classbadge;
              if(res.po_status == 'WT') {
                classbadge = 'badge-info';
              }
              else if(res.po_status == 'AP') {
                classbadge = 'badge-primary';
              }
              else if(res.po_status == 'NA') {
                classbadge = 'badge-danger';
              }
      				var outp = '<span class="badge ' + classbadge + '">' + res.po_status_label + '</span>';
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
    				var outp = '<button ' + is_disabled + ' class="btn btn-info" title="Approve" data-toggle="modal" data-target="#modal_update_status" onclick="open_form_update_status(this)"><i class="fa fa-check"></i></button>';
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
            var btn = '<div class="btn-group btn-group-sm"><button onclick="open_form_detail(this) "type="button" class="btn btn-info order_detail" title="Detail" data-toggle="modal" data-target="#modal_detail_order"><i class="fa fa-list"></i></button><button type="button" ' + is_disabled + ' class="btn btn-warning order_edit" title="Edit" onclick="location.href = \'{{ url("purchasing/orderpembelian/edit_orderpembelian") }}/' + res.po_id + '\'" data-toggle="modal" data-target="#detail_order_edit"><i class="fa fa-pencil"></i></button><button ' + is_disabled + ' type="button" class="btn btn-danger order_hapus" title="Hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button></div>';

            return btn;
          } 
        }
      ],
      columnDefs : [{
        targets : [4, 7, 8, 9],
        className : 'text-center'
      }]
    });

    tabel_history_purchase_order = $("#tabel_history_purchase_order").DataTable({
      "processing" : true,
      "serverSide" : true,
      ajax: {
        "url": "{{ route('find_d_purchase_order_dt') }}",
        
        data: function(){
            var tgl_awal = $('#tgl_awal_history').val();
            var tgl_akhir = $('#tgl_akhir_history').val();
            var outp = {
              "_token": "{{ csrf_token() }}",
              'tgl_awal' : tgl_awal,
              'tgl_akhir' : tgl_akhir
            }

            return outp;
        },
      },
      columns: [
    		{ data : 'po_code' },
    		{ 
          data : null,
          render : function(res) {
            var outp = res.i_code + ' | ' + res.i_name;
            return outp;
          } 
        },
        { data : 'supplier_name' },
    		{ data : 'satuan_name' },
        { data : 'po_tanggal_label' },
        { data : 'podt_qty' },
        { 
          data : null,
          render : function(res) {
            outp = '';
            return outp;
          } 
        },
    		{ 
    			data : null,
    			render : function(res) {
            outp = 0;
    				return outp;
    			} 
    		},
		  {
        data : null,
        render : function() {
          var outp = '<span class="badge badge-pill badge-success">Diterima</span>';
          return outp;
        }
      }
      ]
    });
  });
</script>