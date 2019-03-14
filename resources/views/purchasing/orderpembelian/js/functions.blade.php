<script>
	// Function untuk memperbarui sales plan
	function open_form_update_status(obj) {
		var tr = $(obj).parents('tr');
		var table = tr.parents('table');
		if( table.attr('id') == 'tabel_purchase_order' ) {
			var data = tabel_purchase_order.row(tr).data();
		}
		else {
			
			var data = tabel_purchase_order_tanparencana.row(tr).data();
		}
		console.log(data);
		var po_id = data.po_id;
		$('#modal_update_status [name="po_id"]').val(po_id);
	}



  function approve_purchase_order() {
    var data = $('#form_update_status').serialize();
    $.ajax({
      url: "{{ url('/purchasing/orderpembelian/approve_d_purchase_order') }}",
      type: 'GET',
      data: data,
      dataType: 'json',
      success: function (response) {
        if(response.status == 'sukses') {
          
          $.toast({  
            heading: 'Sukses',
            text: 'Data berhasil disimpan',
            icon: 'success'
          });

          tabel_purchase_order.ajax.reload();
          tabel_purchase_order_tanparencana.ajax.reload();
          setTimeout(function(){
            $('#modal_update_status').modal('hide');
          }, 3000);
        }
        else {
          $.toast({
            heading: 'Error',
            text: 'Terjadi kesalahan',
            bgColor: '#d63031',
            textColor: 'white',
            loaderBg: '#ff7675',
            icon: 'error'
          });          
        }
      }
    });
  }

  function update_purchase_order() {
    var data = $('#form_update_purchase_order').serialize();
    $.ajax({
      url: "{{ url('/purchasing/orderpembelian/update_d_purchase_order') }}",
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function (response) {
        if(response.status == 'sukses') {
          
          $.toast({  
            heading: 'Sukses',
            text: 'Data berhasil disimpan',
            icon: 'success'
          });

          setTimeout(function(){
            $('#detail_order_edit').modal('hide');
          }, 3000);
        }
        else {
          $.toast({
            heading: 'Error',
            text: 'Terjadi kesalahan',
            bgColor: '#d63031',
            textColor: 'white',
            loaderBg: '#ff7675',
            icon: 'error'
          });          
        }
      }
    });
  }


	function open_form_update(obj) {
		var tr = $(obj).parents('tr');
		var data = tabel_purchase_order.row(tr).data();
		var id = data.po_id;
		$('#po_id').val(id);
        var screen = $('#detail_order_edit');
        screen.find('.po_tanggal_label').text( data.po_tanggal_label ); 
        screen.find('.po_tanggal_kirim_label').text( data.po_tanggal_kirim_label ); 
		screen.find('.po_code').text( data.po_code ); 
		screen.find('.name').text( data.name ); 
		screen.find('.s_name').text( data.s_name ); 
		screen.find('.po_status_label').text( data.po_status_label ); 
		var status_class = '';
		if(data.po_status == 'WT') {
			status_class = 'badge-primary';
		}
		else if(data.po_status == 'AP') {
			status_class = 'badge-success';
		}
		else if(data.po_status == 'NAP') {
			status_class = 'badge-danger';
		}
		screen.find('.po_status_label').addClass(status_class);
		tabel_detail_edit.clear().draw();
		$.ajax({
	       type: "get",
	       url: '{{ url("/purchasing/orderpembelian/preview_orderpembelian") }}/' + id,
	       success: function(response){
	       		var unit;
	       		if(response.purchase_order_dt.length > 0) {
	       			for(x in response.purchase_order_dt) {
	       				unit = response.purchase_order_dt[x];
	       				i_code = "<input class='form-control text-right form-control-sm' type='hidden' name='podt_item[]' value='" + unit.podt_item + "'>" + unit.i_code;
	       				i_name = unit.i_name;
	       				qty = "<input class='form-control text-right form-control-sm' type='number' name='podt_qty[]' value='" + unit.podt_qty + "'>";
	       				s_name = unit.s_name;
	       				stock = unit.stock;
	       				tabel_detail_edit.row.add([i_code, i_name, qty, s_name, stock])
	       			}

	       			tabel_detail_edit.draw()
	       		}
	       }      
	    })
	}

	function open_form_detail(obj) {
		var tr = $(obj).parents('tr');
		var data = tabel_purchase_order.row(tr).data();
		var id = data.po_id;
		$('#po_id').val(id);
        var screen = $('#modal_detail_order');
        screen.find('.po_tanggal_label').text( data.po_tanggal_label ); 
        screen.find('.po_tanggal_kirim_label').text( data.po_tanggal_kirim_label ); 
		screen.find('.po_code').text( data.po_code ); 
		screen.find('.name').text( data.name ); 
		screen.find('.s_name').text( data.s_name ); 
		screen.find('.po_status_label').text( data.po_status_label ); 
		screen.find('.po_status_label').text( data.po_status_label ); 
		screen.find('.po_total_net').val( data.po_total_net ); 
		var status_class = '';
		if(data.po_status == 'WT') {
			status_class = 'badge-primary';
		}
		else if(data.po_status == 'AP') {
			status_class = 'badge-success';
		}
		else if(data.po_status == 'NA') {
			status_class = 'badge-danger';
		}
		screen.find('.po_status_label').addClass(status_class);
		tabel_detail.clear().draw();
		$.ajax({
	       type: "get",
	       url: '{{ url("/purchasing/orderpembelian/preview_orderpembelian") }}/' + id,
	       success: function(response){
	       		var unit;
	       		var purchase_order = response.purchase_order;
	       		var screen = $('#modal_detail_order');
	       		screen.find('.po_disc_value').val(
	       		  'Rp ' + accounting.formatMoney(purchase_order.po_disc_value,"",0,'.',',') 
	       		);
	       		screen.find('.po_total_gross').val(
	       		 	'Rp ' + accounting.formatMoney(purchase_order.po_total_gross,"",0,'.',',') 
	       		);
	       		screen.find('.po_disc_percent').val(
	       			purchase_order.po_disc_percent 
	       		);
	       		screen.find('.po_tax_percent').val( purchase_order.po_tax_percent );

	       		if(response.purchase_order_dt.length > 0) {
	       			for(x in response.purchase_order_dt) {
	       				unit = response.purchase_order_dt[x];
	       				i_code = "<input class='form-control text-right form-control-sm' type='hidden' name='podt_item[]' value='" + unit.podt_item + "'>" + unit.i_code;
	       				i_name = unit.i_name;
	       				qty = unit.podt_qty;
	       				s_name = unit.s_name;
	       				stock = unit.stock;
	       				prev_price = unit.podt_prev_price;
	       				price = unit.podt_price;
	       				subtotal = price * qty;

	       				prev_price = 'Rp ' + accounting.formatMoney(prev_price,"",0,'.',',') 
	       				price = 'Rp ' + accounting.formatMoney(price,"",0,'.',',') 
	       				subtotal = 'Rp ' + accounting.formatMoney(subtotal,"",0,'.',',') 
	       				tabel_detail.row.add([i_code, i_name, qty, s_name, stock, prev_price, price, subtotal])
	       			}

	       			tabel_detail.draw()
	       		}
	       }      
	    })
	}

	function hapus(obj) {
	  var tr = $(obj).parents('tr');
	  var table = tr.parents('table');
	  if( table.attr('id') == 'tabel_purchase_order' ) {
		var data = tabel_purchase_order.row(tr).data();
	  }
	  else {	
		var data = tabel_purchase_order_tanparencana.row(tr).data();
	  }
	  var id = data.po_id;
	  // alert(id);
	  $.confirm({
                animation: 'RotateY',
				closeAnimation: 'scale',
				icon: 'fa fa-exclamation-triangle',
			    title: 'Informasi',
				content: 'Apa anda yakin mau menghapus data ini?',
				theme: 'disable',
			    buttons: {
			        info: {
						btnClass: 'btn-blue',
			        	text:'Ya',
			        	action : function(){
							$.ajax({
						       type: "get",
						       url: '{{ url("/purchasing/orderpembelian/delete_d_purchase_order") }}/' + id,
						       success: function(response){
						       	console.log(response);
						            if (response.status =='sukses') {
						              $.toast({  
							            heading: 'Sukses',
							            text: 'Data berhasil disimpan',
							            icon: 'success'
							          });
						              tabel_purchase_order.ajax.reload();
						              tabel_purchase_order_tanparencana.ajax.reload();
						            }
						            else {

						              toastr.error('Data gagal di simpan.');
						            }
						          }
						    })
				        }
			        },
			        cancel:{
			        	text: 'Tidak',
					    action: function () {
    			            // tutup confirm
    			        }
    			    }
			    }
			});

	}

	function search_purchase_order() {
		
		tabel_purchase_order.ajax.reload(); 
	}

	function refresh_purchase_order() {
		$('#tgl_awal').val(
	      moment().subtract(7, 'days').format('DD-MM-YYYY')
	    );
	    $('#tgl_akhir').val(
	      moment().format('DD-MM-YYYY')
	    );
		search_purchase_order(); 
	}

	function search_purchase_order_tanparencana() {
		
		tabel_purchase_order_tanparencana.ajax.reload(); 
	}

	function refresh_purchase_order_tanparencana() {
		$('#tgl_awal_tanparencana').val(
	      moment().subtract(7, 'days').format('DD-MM-YYYY')
	    );
	    $('#tgl_akhir_tanparencana').val(
	      moment().format('DD-MM-YYYY')
	    );
		search_purchase_order_tanparencana(); 
	}

	function search_purchase_order_history() {
		
		tabel_history_purchase_order.ajax.reload(); 
	}

	function refresh_purchase_order_history() {
		$('#tgl_awal_history').val(
	      moment().subtract(7, 'days').format('DD-MM-YYYY')
	    );
	    $('#tgl_akhir_history').val(
	      moment().format('DD-MM-YYYY')
	    );
		search_purchase_order_history(); 
	}


	// Mencari data
	function cari(){
	  var tgl_awal = $('[name="tgl_awal"]').val();
	  var tgl_akhir = $('[name="tgl_akhir"]').val();
	  var url_target = '{{ url("/purchasing/orderpembelian/find_d_purchase_order/?") }}tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir + '&_token={{ csrf_token() }}'; 
	  tablex.ajax.url(url_target).load();
	}


	// mereset data
	function resetData(){  
	  $('[name="tgl_awal"]').val( moment().subtract(7, 'days').format('DD-MM-YYYY') );
	  $('[name="tgl_akhir"]').val( moment().format('DD-MM-YYYY') );
	  var url_target = '{{ url("/purchasing/orderpembelian/find_d_purchase_order/?") }}tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir + '&_token={{ csrf_token() }}'; 
	  tablex.ajax.url(url_target).load();
	}
</script>