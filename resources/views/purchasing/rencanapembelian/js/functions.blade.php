<script>
	// Function untuk memperbarui sales plan
	function open_form_update_status(obj) {
		var tr = $(obj).parents('tr');
		var data = tabel_purchase_plan.row(tr).data();
		var pp_id = data.pp_id;
		$('#form_update_status [name="pp_id"]').val(pp_id);
	}



  function approve_purchase_plan() {
    var data = $('#form_update_status').serialize();
    $.ajax({
      url: "{{ url('/purchasing/rencanapembelian/approve_d_purchase_plan') }}",
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

          tabel_purchase_plan.ajax.reload();
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

  function update_purchase_plan() {
    var data = $('#form_update_purchase_plan').serialize();
    $.ajax({
      url: "{{ url('/purchasing/rencanapembelian/update_d_purchase_plan') }}",
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
            $('#detail_rencana_edit').modal('hide');
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
		var data = tabel_purchase_plan.row(tr).data();
		var id = data.pp_id;
		$('#pp_id').val(id);
        var screen = $('#detail_rencana_edit');
        screen.find('.pp_tanggal_label').text( data.pp_tanggal_label ); 
		screen.find('.pp_code').text( data.pp_code ); 
		screen.find('.name').text( data.name ); 
		screen.find('.s_name').text( data.s_name ); 
		screen.find('.pp_status_label').text( data.pp_status_label ); 
		var status_class = '';
		if(data.pp_status == 'WT') {
			status_class = 'badge-primary';
		}
		else if(data.pp_status == 'AP') {
			status_class = 'badge-success';
		}
		else if(data.pp_status == 'NA') {
			status_class = 'badge-danger';
		}
		screen.find('.pp_status_label').addClass(status_class);
		tabel_detail_edit.clear().draw();
		$.ajax({
	       type: "get",
	       url: '{{ url("/purchasing/rencanapembelian/preview_rencanapembelian") }}/' + id,
	       success: function(response){
	       		var unit;
	       		if(response.purchase_plan_dt.length > 0) {
	       			for(x in response.purchase_plan_dt) {
	       				unit = response.purchase_plan_dt[x];
	       				i_code = "<input class='form-control text-right form-control-sm' type='hidden' name='ppdt_item[]' value='" + unit.ppdt_item + "'>" + unit.i_code;
	       				i_name = unit.i_name;
	       				qty = "<input class='form-control text-right form-control-sm' type='number' name='ppdt_qty[]' value='" + unit.ppdt_qty + "'>";
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
		var data = tabel_purchase_plan.row(tr).data();
		var id = data.pp_id;
		$('#pp_id').val(id);
        var screen = $('#detail_rencana');
        screen.find('.pp_tanggal_label').text( data.pp_tanggal_label ); 
		screen.find('.pp_code').text( data.pp_code ); 
		screen.find('.name').text( data.name ); 
		screen.find('.s_name').text( data.s_name ); 
		screen.find('.pp_status_label').text( data.pp_status_label ); 
		var status_class = '';
		if(data.pp_status == 'WT') {
			status_class = 'badge-primary';
		}
		else if(data.pp_status == 'AP') {
			status_class = 'badge-success';
		}
		else if(data.pp_status == 'NA') {
			status_class = 'badge-danger';
		}
		screen.find('.pp_status_label').addClass(status_class);
		tabel_detail_edit.clear().draw();
		$.ajax({
	       type: "get",
	       url: '{{ url("/purchasing/rencanapembelian/preview_rencanapembelian") }}/' + id,
	       success: function(response){
	       		var unit;
	       		if(response.purchase_plan_dt.length > 0) {
	       			for(x in response.purchase_plan_dt) {
	       				unit = response.purchase_plan_dt[x];
	       				i_code = "<input class='form-control text-right form-control-sm' type='hidden' name='ppdt_item[]' value='" + unit.ppdt_item + "'>" + unit.i_code;
	       				i_name = unit.i_name;
	       				qty = unit.ppdt_qty;
	       				s_name = unit.s_name;
	       				stock = unit.stock;
	       				tabel_detail.row.add([i_code, i_name, qty, s_name, stock])
	       			}

	       			tabel_detail.draw()
	       		}
	       }      
	    })
	}

	function hapus(obj) {
	  var tr = $(obj).parents('tr');
	  var data = tabel_purchase_plan.row(tr).data();
	  var id = data.pp_id;
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
						       url: '{{ url("/purchasing/rencanapembelian/delete_d_purchase_plan") }}/' + id,
						       success: function(response){
						       	console.log(response);
						            if (response.status =='sukses') {
						              $.toast({  
							            heading: 'Sukses',
							            text: 'Data berhasil disimpan',
							            icon: 'success'
							          });
						              tabel_purchase_plan.ajax.reload();
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

	// Mencari data
	function search_purchase_plan() {
		tabel_purchase_plan.ajax.reload();
	}

	function refresh_purchase_plan() {
		$('#tgl_awal').val(
	      moment().subtract(7, 'days').format('DD-MM-YYYY')
	    );
	    $('#tgl_akhir').val(
	      moment().format('DD-MM-YYYY')
	    );
	    $('#pp_status').find('[value=""]').attr('selected', 'selected');

	    search_purchase_plan();
	    $('#pp_status').find('[value=""]').removeAttr('selected');
	}

	// mereset data
	function resetData(){  
	  $('[name="tgl_awal"]').val( moment().subtract(7, 'days').format('DD-MM-YYYY') );
	  $('[name="tgl_akhir"]').val( moment().format('DD-MM-YYYY') );
	  var url_target = '{{ url("/purchasing/rencanapembelian/find_d_purchase_plan/?") }}tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir + '&_token={{ csrf_token() }}'; 
	  tablex.ajax.url(url_target).load();
	}
</script>