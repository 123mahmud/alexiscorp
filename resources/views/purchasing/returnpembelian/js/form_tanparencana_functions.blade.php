<script>
  

  function count_grandtotal() {
    var qty = $('[name="podt_qty[]"]');
      var price = $('[name="podt_price[]"]');
      var item_qty, item_price, total_gross = 0, total_net = 0;

      for(x = 0;x < qty.length;x++) {
        item_qty =  $( qty[x] ).val() ;
        item_qty = item_qty != '' ? parseInt(item_qty) : 0;
        item_price = $( price[x] ).val() ;
        item_price = item_price.replace(/\D/g, '') ;
        item_price = item_price != '' ? parseInt(item_price) : 0;
        total_gross += ( item_qty * item_price );
      }

      var disc_value = $('#pr_disc_value').val();
      var disc_percent = $('#pr_disc_percent').val();
      var tax_percent = $('#pr_tax_percent').val();
      disc_value = disc_value.replace(/\D/g, '');
      disc_value = disc_value != '' ? parseInt(disc_value) : 0;
      disc_percent = disc_percent != '' ? parseInt(disc_percent) : 0;
      disc_percent = disc_percent / 100;
      tax_percent = tax_percent != '' ? parseInt(tax_percent) : 0;
      tax_percent = tax_percent / 100;

      var result_disc = (total_gross - disc_value) * disc_percent;
      var result_tax = result_disc * tax_percent;
      total_net = total_gross - disc_value - result_disc + result_tax;  

      $('#pr_total_gross').val(
        'Rp. ' + accounting.formatMoney(total_gross,"",0,'.',',')
      );
      $('#pr_total_net').val(
        'Rp. ' + accounting.formatMoney(total_net,"",0,'.',',')
      );
  }

  function remove_detail(obj) {
    var tr = $(obj).parents('tr');
    table_purchase_return_dt.row(tr).remove().draw();
  }

  // Function untuk meng-insert sales plan
  function insert_purchase_return() {
    var data = $('#form_purchase_return').serialize();
    $.ajax({
      url: "{{ url('/purchasing/returnpembelian/insert_d_purchase_return') }}",
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
            location.reload();
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
    var data = $('#form_purchase_return').serialize();
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
            location.href = '{{ route('returnpembelian') }}#pr_tanpa';
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

  
  

  // Function untuk menghitung grand total ketika menambahkan atau mengurangi item
  function append_purchase_return_dt() {
      // Validasi
      var i_id = $('#i_name').val();
      var item = $('#i_name').select2('data')[0];
      var i_name = item.text;
      var prev_price = item.prev_price;
      var satuan = $('#i_satuan').val(); 
      var satuan_label = $('#i_satuan option:selected').text(); 
      var qty = $('#qty').val() 
      if(i_id == '' || i_id == null) {
        $.toast({
          heading: 'Error',
          text: 'Nama item harus diisi',
          bgColor: '#d63031',
          textColor: 'white',
          loaderBg: '#ff7675',
          icon: 'error'
        });
      }
      else if(qty == '' ||qty == null || qty == 0){
        $.toast({
          heading: 'Error',
          text: 'Jumlah item tidak boleh kosong',
          bgColor: '#d63031',
          textColor: 'white',
          loaderBg: '#ff7675',
          icon: 'error'
        })

      }
      else {
        var item_exists = $("[name='podt_item[]'][value='" + i_id + "']");
        var is_exists = item_exists.length;
        if(is_exists == 0) {

          var podt_item = "<input name='podt_item[]' value='" + i_id + "' type='hidden'>"  + i_name;
          var podt_qty = "<input name='podt_qty[]' value='" + qty + "' type='number' class='form-control form-control-sm text-right'>" ;
          var podt_satuan = "<input name='podt_satuan[]' value='" + satuan + "' type='hidden' class='form-control'>" + satuan_label;
          var podt_prev_price = "<input name='podt_prev_price[]' value='" + prev_price + "' type='hidden'>Rp " + accounting.formatMoney(prev_price,"",0,'.',',');
          var podt_price = "<input name='podt_price[]' value='Rp. " + accounting.formatMoney(item.i_sat_hrg1,"",0,'.',',') + "' type='text' class='form-control form-control-sm text-right'>";
          var stock = item.stock;
          var harga_total = item.i_sat_hrg1 * qty;
          harga_total = 'Rp ' + accounting.formatMoney(harga_total,"",0,'.',',') + ',00';
          var aksi = '<button type="button" class="btn btn-danger btn-hapus" onclick="remove_detail(this)"><i class="fa fa-trash-o"></i></button>';

          
          table_purchase_return_dt.row.add([
            podt_item, podt_qty, podt_satuan, podt_prev_price, podt_price, harga_total, stock, aksi
          ]).draw();
        }
        else {
          var tr = item_exists.parents('tr');
          var qty_exists = tr.find("[name='podt_qty[]']");
          var qty_exists_val = qty_exists.val();
          qty_exists_val = qty_exists_val != '' ? parseInt(qty_exists_val) : 0;
          var qty = $('#qty').val();
          qty = qty != '' ? parseInt(qty) : 0;
          var amount_qty = qty_exists_val + qty;
          qty_exists.val(amount_qty);
        }  
      }

      $('#qty').val('');
      $('#i_satuan').html('');
      $('#i_name').select2('open'); 
      $('#stock').val('');
  }

  function remove_purchase_return_dt(obj) {
    var tr = $(obj).parents('tr');
    table_purchase_return_dt.row(tr).remove().draw();
  }

  
</script>