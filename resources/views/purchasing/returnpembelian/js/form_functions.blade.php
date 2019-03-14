<script>
  function count_grandtotal() {
    var qty = $('[name="prdt_qtyreturn[]"]');
      var price = $('[name="prdt_price[]"]');
      var item_qty, item_price, total_gross = 0, total_net = 0;

      for(x = 0;x < qty.length;x++) {
        item_qty =  $( qty[x] ).val() ;
        item_qty = item_qty != '' ? parseInt(item_qty) : 0;
        item_price = $( price[x] ).val() ;
        item_price = item_price.replace(/\D/g, '') ;
        item_price = item_price != '' ? parseInt(item_price) : 0;
        total_gross += ( item_qty * item_price );
      }

      
      $('#pr_pricetotal').val(
        'Rp. ' + accounting.formatMoney(total_gross,"",0,'.',',')
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
            location.href = '{{ route('returnpembelian') }}';
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
  

</script>