<script>
  $(document).ready(function(){
    // Format textbox mata uang
    $('#pr_disc_value').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    $('#pr_disc_value, #pr_tax_percent, #pr_disc_percent').on('change keyup', function(){
      count_grandtotal();
    });

    

    table_purchase_return_dt = $('#table_purchase_return_dt').DataTable({
      "columnDefs" : [
        {
          'targets' : [1, 4, 5],
          'className' : 'text-right'
        },
        {
          'targets' : 6,
          'className' : 'text-center'
        }
      ],
      "createdRow": function( row, data, dataIndex ) {
          var prdt_price = $(row).find('[name="prdt_price[]"]'); 
          var prdt_qty = $(row).find('[name="prdt_qtyreturn[]"]'); 
          prdt_price.maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
          prdt_price.on('keyup change', function(){
            count_grandtotal();
            var tr = $(this).parents('tr');
            var prdt_price = $(this).val();
            prdt_price = prdt_price.replace(/\D/g, '');
            prdt_price = prdt_price != '' ? parseInt(prdt_price) : 0;
            var qty = tr.find("[name='prdt_qtyreturn[]']").val();
            qty = qty != '' ? parseInt(qty) : 0;
            var subtotal = qty * prdt_price;
            subtotal = 'Rp ' + accounting.formatMoney(subtotal,"",0,'.',',');
            tr.find('td:eq(5)').text(subtotal);

            
          });
          
          prdt_qty.on('keyup change', function(){
            count_grandtotal();
            var tr = $(this).parents('tr');
            var prdt_price = tr.find("[name='prdt_price[]']").val();
            prdt_price = prdt_price.replace(/\D/g, '');
            prdt_price = prdt_qty != '' ? parseInt(prdt_price) : 0;
            var qty = $(this).val();
            qty = qty != '' ? parseInt(qty) : 0;
            var subtotal = qty * prdt_price;
            subtotal = 'Rp ' + accounting.formatMoney(subtotal,"",0,'.',',');
            tr.find('td:eq(5)').text(subtotal);

            // Validasi
            var qtybeli = tr.find('[name="prdt_qtybeli[]"]').val();
            qtybeli = qtybeli != '' ? parseInt(qtybeli) : 0;
            if(qty > qtybeli) {
              $(this).val(1);
              $(this).trigger('change');
              $.toast({
                heading: 'Peringatan !',
                text: 'Jumlah barang yang dikembalikan tidak boleh melebihi jumlah barang yang dibeli',
                bgColor: '#d63031',
                textColor: 'white',
                loaderBg: '#ff7675',
                icon: 'error'
              });
            }
          });

      }
    });

    table_purchase_return_dt.on('draw', function(){
        count_grandtotal();
    })

    $('#pr_supplier').select2({
      placeholder: "Pilih Supplier",
      ajax: {
        url: '{{ url("/purchasing/returnpembelian/find_m_supplier") }}',
        dataType: 'json',
        data: function (params) {
          return {
              keyword: $.trim(params.term)
          }
        },
        processResults: function (res) {
            for(x in res.data) {
              res.data[x].id = res.data[x].s_id; 
              res.data[x].text = res.data[x].s_name; 
            }
            return {
                results: res.data
            };
        }
     }, 
    });

    $('#pr_purchase_order').select2({
      placeholder: "Pilih Order Pembelian",
      ajax: {
        url: '{{ url("/purchasing/orderpembelian/find_d_purchase_order") }}',
        dataType: 'json',
        data: function (params) {
          return {
              keyword: $.trim(params.term),
              po_status : 'AP'
          }
        },
        processResults: function (res) {
            for(x in res.data) {
              res.data[x].id = res.data[x].po_id; 
              res.data[x].text = res.data[x].po_code; 
            }
            return {
                results: res.data
            };
        }
     }, 
    });
 
    $('#pr_purchase_order').change(function(){
      // Mengambil data purchase order
      var id = $(this).val();
      table_purchase_return_dt.clear().draw();
      
      $.ajax({
        url: "{{ url('/purchasing/orderpembelian/preview_orderpembelian/') }}/" + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          // Output data purchase order yang dipilih
          var purchase_order = response.purchase_order;
          $('#po_method').val( purchase_order.po_method );
          $('#po_total_gross').val( 'Rp ' + accounting.formatMoney(purchase_order.po_total_gross,"",0,'.',',') );
          $('#po_disc_percent').val( purchase_order.po_disc_percent );
          $('#po_disc_value').val( 'Rp ' + accounting.formatMoney(purchase_order.po_disc_value,"",0,'.',',') );
          $('#po_tax_percent').val( purchase_order.po_tax_percent );
          $('#po_total_net').val( 'Rp ' + accounting.formatMoney(purchase_order.po_total_net,"",0,'.',',') );

          // Menampilan daftar item berdasarkan PO yang dipilih
          var purchase_order_dt = response.purchase_order_dt;
          if(purchase_order_dt.length > 0) {
            for(x in purchase_order_dt) {
              unit = purchase_order_dt[x];
              console.log(unit);
              var podt_item = "<input name='prdt_item[]' value='" + unit.i_id + "' type='hidden'>" + unit.i_code + ' | ' + unit.i_name;
              var podt_qtybeli = "<input name='prdt_qtybeli[]' value='" + unit.podt_qty + "' type='hidden'>" + unit.podt_qty;
              var podt_qtyreturn = "<input name='prdt_qtyreturn[]' value='1' type='number' class='form-control form-control-sm text-right'>" ;
              var podt_satuan = "<input name='prdt_satuan[]' value='" + unit.podt_satuan + "' type='hidden' class='form-control'>" + unit.s_name;
              var podt_price = "<input name='prdt_price[]' value='Rp. " + accounting.formatMoney(unit.podt_price,"",0,'.',',') + "' type='text' class='form-control form-control-sm text-right'>";
              var stock = unit.stock;
              var harga_total = 1 * unit.podt_price;
              harga_total = 'Rp ' + accounting.formatMoney(harga_total,"",0,'.',',') + ',00';
              var aksi = '<button type="button" class="btn btn-danger btn-hapus" onclick="remove_detail(this)"><i class="fa fa-trash-o"></i></button>';

              
              table_purchase_return_dt.row.add([
                podt_item, podt_qtybeli, podt_qtyreturn, podt_satuan, podt_price, harga_total, stock, aksi
              ]);
            }

            table_purchase_return_dt.draw();
          }
        }
      });
    });
  });
</script>