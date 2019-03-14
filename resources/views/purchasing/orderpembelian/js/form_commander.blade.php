<script>
  $(document).ready(function(){
    // Format textbox mata uang
    $('#po_disc_value').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    $('#po_disc_value, #po_tax_percent, #po_disc_percent').on('change keyup', function(){
      count_grandtotal();
    });

    

    table_purchase_order_dt = $('#table_purchase_order_dt').DataTable({
      "columnDefs" : [
        {
          'targets' : [3, 5, 6],
          'className' : 'text-right'
        },
        {
          'targets' : 7,
          'className' : 'text-center'
        }
      ],
      "createdRow": function( row, data, dataIndex ) {
          var podt_price = $(row).find('[name="podt_price[]"]'); 
          var podt_qty = $(row).find('[name="podt_qty[]"]'); 
          podt_price.maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
          podt_price.on('keyup change', function(){
            count_grandtotal();
            var tr = $(this).parents('tr');
            var podt_price = $(this).val();
            podt_price = podt_price.replace(/\D/g, '');
            podt_price = podt_qty != '' ? parseInt(podt_price) : 0;
            var qty = tr.find("[name='podt_qty[]']").val();
            qty = qty != '' ? parseInt(qty) : 0;
            var subtotal = qty * podt_price;
            subtotal = 'Rp ' + accounting.formatMoney(subtotal,"",0,'.',',');
            tr.find('td:eq(5)').text(subtotal);
          });
          
          podt_qty.on('keyup change', function(){
            count_grandtotal();
            var tr = $(this).parents('tr');
            var podt_price = tr.find("[name='podt_price[]']").val();
            podt_price = podt_price.replace(/\D/g, '');
            podt_price = podt_qty != '' ? parseInt(podt_price) : 0;
            var qty = $(this).val();
            qty = qty != '' ? parseInt(qty) : 0;
            var subtotal = qty * podt_price;
            subtotal = 'Rp ' + accounting.formatMoney(subtotal,"",0,'.',',');
            tr.find('td:eq(5)').text(subtotal);
          });

      }
    });

    table_purchase_order_dt.on('draw', function(){
        count_grandtotal();
    })

    $('#po_purchase_plan').select2({
      placeholder: "Pilih Rencana Pembelian",
      ajax: {
        url: '{{ url("/purchasing/rencanapembelian/find_d_purchase_plan") }}',
        dataType: 'json',
        data: function (params) {
          return {
              keyword: $.trim(params.term),
              pp_status : 'AP'
          }
        },
        processResults: function (res) {
            for(x in res.data) {
              res.data[x].id = res.data[x].pp_id; 
              res.data[x].text = res.data[x].pp_code; 
            }
            return {
                results: res.data
            };
        }
     }, 
    });
 
    $('#po_purchase_plan').change(function(){
      var id = $(this).val();
      table_purchase_order_dt.clear().draw();
      var data = $(this).select2('data')[0];
      console.log(data);
      $('#po_supplier').val(data.pp_supplier);
      $('#po_supplier_label').val(data.s_name);
      $.ajax({
        url: "{{ url('/purchasing/rencanapembelian/preview_rencanapembelian/') }}/" + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          var d_purchase_order_dt = response.purchase_plan_dt;
          var unit;
          console.log(d_purchase_order_dt);
          if(d_purchase_order_dt.length > 0) {
            for(x in d_purchase_order_dt) {
              unit = d_purchase_order_dt[x];
              console.log(unit);
              var podt_item = "<input name='podt_item[]' value='" + unit.i_id + "' type='hidden'>" + unit.i_code + ' | ' + unit.i_name;
              var podt_qty = "<input name='podt_qty[]' value='" + unit.ppdt_qty + "' type='number' class='form-control form-control-sm text-right'>" ;
              var podt_satuan = "<input name='podt_satuan[]' value='" + unit.ppdt_satuan + "' type='hidden' class='form-control'>" + unit.s_name;
              var podt_prev_price = "<input name='podt_prev_price[]' value='" + unit.ppdt_prev_price + "' type='hidden'>Rp " + accounting.formatMoney(unit.ppdt_prev_price,"",0,'.',',');
              var podt_price = "<input name='podt_price[]' value='Rp. " + accounting.formatMoney(unit.i_sat_hrg1,"",0,'.',',') + "' type='text' class='form-control form-control-sm text-right'>";
              var stock = unit.stock;
              var harga_total = unit.i_sat_hrg1 * unit.podt_qty;
              harga_total = 'Rp ' + accounting.formatMoney(harga_total,"",0,'.',',') + ',00';
              var aksi = '<button type="button" class="btn btn-danger btn-hapus" onclick="remove_detail(this)"><i class="fa fa-trash-o"></i></button>';

              
              table_purchase_order_dt.row.add([
                podt_item, podt_qty, podt_satuan, podt_prev_price, podt_price, harga_total, stock, aksi
              ]);
            }

            table_purchase_order_dt.draw();
          }
        }
      });
    });
  });
</script>