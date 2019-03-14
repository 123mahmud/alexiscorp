<script>
	// Function untuk memperbarui sales plan
	function open_form_update_status(obj) {
		var tr = $(obj).parents('tr');
		var table = tr.parents('table');
		var data = tabel_purchase_return.row(tr).data();
		console.log(data);
		var pr_id = data.pr_id;
		$('#modal_update_status [name="pr_id"]').val(pr_id);
	}



  function approve_purchase_return() {
    var data = $('#form_update_status').serialize();
    $.ajax({
      url: "{{ url('/purchasing/returnpembelian/approve_d_purchase_return') }}",
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

          tabel_purchase_return.ajax.reload();
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

  function update_purchase_return() {
    var data = $('#form_update_purchase_return').serialize();
    $.ajax({
      url: "{{ url('/purchasing/returnpembelian/update_d_purchase_return') }}",
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
            $('#detail_return_edit').modal('hide');
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
		var data = tabel_purchase_return.row(tr).data();
		var id = data.pr_id;
		$('#pr_id').val(id);
        var screen = $('#detail_return_edit');
        screen.find('.pr_tanggal_label').text( data.pr_tanggal_label ); 
        screen.find('.pr_tanggal_kirim_label').text( data.pr_tanggal_kirim_label ); 
		screen.find('.pr_code').text( data.pr_code ); 
		screen.find('.name').text( data.name ); 
		screen.find('.s_name').text( data.s_name ); 
		screen.find('.pr_status_label').text( data.pr_status_label ); 
		var status_class = '';
		if(data.pr_status == 'WT') {
			status_class = 'badge-primary';
		}
		else if(data.pr_status == 'AP') {
			status_class = 'badge-success';
		}
		else if(data.pr_status == 'NAP') {
			status_class = 'badge-danger';
		}
		screen.find('.pr_status_label').addClass(status_class);
		tabel_detail_edit.clear().draw();
		$.ajax({
	       type: "get",
	       url: '{{ url("/purchasing/returnpembelian/preview_returnpembelian") }}/' + id,
	       success: function(response){
	       		var unit;
	       		if(response.purchase_return_dt.length > 0) {
	       			for(x in response.purchase_return_dt) {
	       				unit = response.purchase_return_dt[x];
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
		var data = tabel_purchase_return.row(tr).data();
		var id = data.pr_id;
		$('#pr_id').val(id);
        var screen = $('#modal_detail_return');
        screen.find('.pr_tanggal_label').text( data.pr_tanggal_label ); 
		screen.find('.pr_code').text( data.pr_code ); 
		screen.find('.name').text( data.name ); 
		screen.find('.s_name').text( data.s_name ); 
		screen.find('.pr_method_label').text( data.pr_method_label ); 
		screen.find('.pr_status_label').text( data.pr_status_label ); 

		var pricetotal = 'Rp ' + accounting.formatMoney(data.pr_pricetotal,"",0,'.',',');
		screen.find('.pr_pricetotal').val( pricetotal ); 
		var status_class = '';
		if(data.pr_status == 'WT') {
			status_class = 'badge-primary';
		}
		else if(data.pr_status == 'AP') {
			status_class = 'badge-success';
		}
		else if(data.pr_status == 'NA') {
			status_class = 'badge-danger';
		}
		screen.find('.pr_status_label').addClass(status_class);
		tabel_detail.clear().draw();
		$.ajax({
	       type: "get",
	       url: '{{ url("/purchasing/returnpembelian/preview_returnpembelian") }}/' + id,
	       success: function(response){
	       		var unit;
	       		var purchase_return = response.purchase_return;
	       		var screen = $('#modal_detail_return');

	       		if(response.purchase_return_dt.length > 0) {
	       			for(x in response.purchase_return_dt) {
	       				unit = response.purchase_return_dt[x];
	       				i_code = "<input class='form-control text-right form-control-sm' type='hidden' name='prdt_item[]' value='" + unit.prdt_item + "'>" + unit.i_code;
	       				i_name = unit.i_name;
	       				qtybeli = unit.prdt_qtybeli;
	       				qtyreturn = unit.prdt_qtyreturn;
	       				s_name = unit.s_name;
	       				stock = unit.stock;
	       				price = unit.prdt_price;
	       				subtotal = price * qtyreturn;

	       				price = 'Rp ' + accounting.formatMoney(price,"",0,'.',',') 
	       				subtotal = 'Rp ' + accounting.formatMoney(subtotal,"",0,'.',',') 
	       				tabel_detail.row.add([i_code, i_name, s_name, qtybeli, qtyreturn, stock,  price, subtotal])
	       			}

	       			tabel_detail.draw()
	       		}
	       }      
	    })
	}

	function open_form_detail_revisi_po(obj) {
		var tr = $(obj).parents('tr');
		var data = tabel_revisi_purchase_order.row(tr).data();
		var id = data.po_id;
		$('#pr_id').val(id);
        var screen = $('#modal_detail_revisi_po');
        screen.find('.po_tanggal_label').text( data.po_tanggal_label ); 
		screen.find('.po_code').text( data.po_code ); 
		screen.find('.name').text( data.name ); 
		screen.find('.s_name').text( data.s_name ); 
		screen.find('.po_method_label').text( data.po_method_label ); 
		screen.find('.po_status_label').text( data.po_status_label ); 

		var pricetotal = 'Rp ' + accounting.formatMoney(data.pr_pricetotal,"",0,'.',',');
		screen.find('.pr_pricetotal').val( pricetotal ); 
		var status_class = '';
		if(data.pr_status == 'WT') {
			status_class = 'badge-primary';
		}
		else if(data.pr_status == 'AP') {
			status_class = 'badge-success';
		}
		else if(data.pr_status == 'NA') {
			status_class = 'badge-danger';
		}
		screen.find('.pr_status_label').addClass(status_class);
		tabel_detail.clear().draw();
		$.ajax({
	       type: "get",
	       url: '{{ url("/purchasing/returnpembelian/preview_orderpembelian") }}/' + id,
	       success: function(response){
	       		var unit;
	       		var purchase_order = response.purchase_order;
	       		var screen = $('#modal_detail_return');

	       		if(response.purchase_order_dt.length > 0) {
	       			for(x in response.purchase_order_dt) {
	       				unit = response.purchase_order_dt[x];
	       				i_code = "<input class='form-control text-right form-control-sm' type='hidden' name='prdt_item[]' value='" + unit.prdt_item + "'>" + unit.i_code;
	       				i_name = unit.i_name;
	       				qtybeli = unit.podt_qty;
	       				qtyreturn = unit.amount_qtyreturn;
	       				qtysisa = unit.qtysisa;
	       				s_name = unit.s_name;
	       				stock = unit.stock;
	       				price = unit.podt_price;
	       				prev_price = unit.podt_prev_price;
	       				subtotal = price * qtysisa;

	       				price = 'Rp ' + accounting.formatMoney(price,"",0,'.',',') 
	       				prev_price = 'Rp ' + accounting.formatMoney(prev_price,"",0,'.',',') 
	       				subtotal = 'Rp ' + accounting.formatMoney(subtotal,"",0,'.',',') 
	       				tabel_detail_revisi_po.row.add([i_code, i_name, s_name, qtybeli, qtyreturn, qtysisa, stock, prev_price, price, subtotal])
	       			}

	       			tabel_detail_revisi_po.draw()
	       		}
	       }      
	    })
	}

	function hapus(obj) {
	  var tr = $(obj).parents('tr');
	  var table = tr.parents('table');
	  if( table.attr('id') == 'tabel_purchase_return' ) {
		var data = tabel_purchase_return.row(tr).data();
	  }
	  else {	
		var data = tabel_purchase_return_tanparencana.row(tr).data();
	  }
	  var id = data.pr_id;
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
						       url: '{{ url("/purchasing/returnpembelian/delete_d_purchase_return") }}/' + id,
						       success: function(response){
						       	console.log(response);
						            if (response.status =='sukses') {
						              $.toast({  
							            heading: 'Sukses',
							            text: 'Data berhasil disimpan',
							            icon: 'success'
							          });
						              tabel_purchase_return.ajax.reload();
						              tabel_purchase_return_tanparencana.ajax.reload();
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

	function search_purchase_return() {
		
		tabel_purchase_return.ajax.reload(); 
	}

	function search_revisi_purchase_order() {
		
		tabel_revisi_purchase_order.ajax.reload(); 
	}

	function refresh_purchase_return() {
		$('#tgl_awal').val(
	      moment().subtract(7, 'days').format('DD-MM-YYYY')
	    );
	    $('#tgl_akhir').val(
	      moment().format('DD-MM-YYYY')
	    );
		search_purchase_return(); 
	}

	function refresh_revisi_purchase_order() {
		$('#tgl_awal_revisi').val(
	      moment().subtract(7, 'days').format('DD-MM-YYYY')
	    );
	    $('#tgl_akhir_revisi').val(
	      moment().format('DD-MM-YYYY')
	    );
		search_revisi_purchase_order(); 
	}

	function search_purchase_return_history() {
		
		tabel_history_purchase_return.ajax.reload(); 
	}

	function refresh_purchase_return_history() {
		$('#tgl_awal_history').val(
	      moment().subtract(7, 'days').format('DD-MM-YYYY')
	    );
	    $('#tgl_akhir_history').val(
	      moment().format('DD-MM-YYYY')
	    );
		search_purchase_return_history(); 
	}


	// Mencari data
	function cari(){
	  var tgl_awal = $('[name="tgl_awal"]').val();
	  var tgl_akhir = $('[name="tgl_akhir"]').val();
	  var url_target = '{{ url("/purchasing/returnpembelian/find_d_purchase_return/?") }}tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir + '&_token={{ csrf_token() }}'; 
	  tablex.ajax.url(url_target).load();
	}


	// mereset data
	function resetData(){  
	  $('[name="tgl_awal"]').val( moment().subtract(7, 'days').format('DD-MM-YYYY') );
	  $('[name="tgl_akhir"]').val( moment().format('DD-MM-YYYY') );
	  var url_target = '{{ url("/purchasing/returnpembelian/find_d_purchase_return/?") }}tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir + '&_token={{ csrf_token() }}'; 
	  tablex.ajax.url(url_target).load();
	}
</script>