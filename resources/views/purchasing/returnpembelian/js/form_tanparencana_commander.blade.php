<script>
  $(document).ready(function(){
    // Format textbox mata uang
    $('#pr_disc_value').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    $('#pr_disc_value, #pr_tax_percent, #pr_disc_percent').on('change keyup', function(){
      count_grandtotal();
    });

    $('#i_name').select2({
                  width : '100%',
                  placeholder: "Pilih Barang",
                  ajax: {
                    url: '{{ url("/purchasing/rencanapembelian/find_m_item") }}',
                    dataType: 'json',
                    data: function (params) {
                      return {
                          keyword: $.trim(params.term)
                      }
                  },
                  processResults: function (res) {
                        for(x in res.data) {
                          res.data[x].id = res.data[x].i_id; 
                          res.data[x].text = res.data[x].i_code + ' | ' + res.data[x].i_name; 
                        }
                        return {
                            results: res.data
                        };
                  },
                  cache: true
                 } 
                });
    $('#i_name').change(function(){
      var data = $(this).select2('data')[0];
      var option = '';
      $('#i_satuan').html('');
      for(x = 1;x <= 3;x++) {
        option += '<option value="' + data["i_sat" + x] + '">' + data["i_sat" + x + "_label"] + '</option>';
      }
      $('#i_satuan').html(option);
      $('#i_satuan').focus();
      $('#stock').val( data.stock );
    });

    $('#i_satuan').change(function(){
      $('#qty').focus();
    });

    $('#qty').keypress(function(e){
      if( e.which == 13 ) {
        append_purchase_return_dt();
      }
    })

    table_purchase_return_dt = $('#table_purchase_return_dt').DataTable({
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

    
  });
</script>