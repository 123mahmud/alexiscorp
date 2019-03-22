@extends('main')

@section('content')

@include('penjualan.penjualanorder.modal_cust')
@include('penjualan.penjualanorder.modal_pembayaran')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Pencatatan Penjualan Dengan Order </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	/ <span>Penjualan</span>
	    	/ <span class="text-primary font-weight-bold">Pencatatan Penjualan Dengan Order</span>
	     </p>
	</div>

	<section class="section">

 	   	<ul class="nav nav-pills">
            <li class="nav-item">
                <a href="" class="nav-link active" data-target="#pos" aria-controls="pos" data-toggle="tab" role="tab">Penjualan Dengan Order</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link" data-target="#list_pos" aria-controls="list_pos" data-toggle="tab" role="tab">List Penjualan</a>
            </li>
            <li class="nav-item">
            	<a href="" class="nav-link" data-target="#tab_pembayaran" data-toggle="tab" role="tab">Pembayaran</a>
            </li>
        </ul>

		<div class="row">

			<div class="col-12">

				<div class="tab-content">

					@include('penjualan.penjualanorder.tab_formpenjualan')
					@include('penjualan.penjualanorder.tab_list')
					@include('penjualan.penjualanorder.tab_pembayaran')

				</div>

			</div>

		</div>

	</section>

</article>

@endsection
@section('extra_script')
<!-- script for penjualan-order -->
<script type="text/javascript">
  // jquery token
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

	$(document).ready(function() {
		tb_penjualan = $('#table_penjualan').DataTable({
			"order": []
		});

		$('#customer').on('click', function() {
			clearCustomer();
		});
		$('#customer').autocomplete({
			source: baseUrl + '/penjualan/penjualanorder/getCustomers',
			minLength: 2,
			select: function(event, data){
				$('#address').val(data.item.address);
				$('#idCustomer').val(data.item.id);
				$('#ket-project').focus();
			}
		});
		function clearCustomer()
		{
			$('#customer').val('');
			$('#address').val('');
			$('#idCustomer').val('');
		}

		$('#barang').on('click', function() {
			clearSelectItem();
		})
		$('#barang').autocomplete({
			source: baseUrl + '/penjualan/penjualanorder/getItems',
			minLength: 2,
			select: function(event, data){
				$('#itemId').val(data.item.id);
				$('#itemName').val(data.item.name);
				$('#itemSatId').val(data.item.sat1_id);
				$('#itemSatName').val(data.item.sat1_name);
				getItemStock();
			}
		});

		$('#qty').inputmask('999.999.999.999', {placeholder: " "});
		$('#qty').on('click', function() {
			$(this).val('');
		})

		// maybe it should switch .on with .one to prevent duplicate entry
		$('#qty').on('keypress', function(e){
			if(e.keypress === 13 || e.keyCode === 13){
				table_tambah();
			}
		});
		$('.btn-tambah').on('click', function(){
			table_tambah();
		});

		$('#ppn').on('change', function() {
			totalAmount = sumTotalAmount();
			$('#totalAmount').val(totalAmount);
		})
	});

	function clearSelectItem()
	{
		$('#itemId').val('');
		$('#itemName').val('');
		$('#itemSatId').val('');
		$('#itemSatName').val('');
		$('#barang').val('');
		$('#qty').val('');
		$('#stock').val('');
	}

	function getItemStock()
	{
		$.ajax({
			data : {
				"itemId": $('#itemId').val(),
				"comp": "{{ Auth::user()->m_id }}",
				"positionId": "{{ Session::get('user_comp') }}"
			},
			type : "get",
			url : "{{ route('penjualanorder.getstock') }}",
			dataType : 'json',
			success : function (response){
				$('#stock').val(response.s_qty);
			},
			error : function(e){
				$('#stock').val('Error, check response !');
			}
		});
	}

	function getUnmaskQty()
	{
		qty = Inputmask.unmask($('#qty').val(), {alias: "999.999.999.999"});
		return qty;
	}

	// check stock before adding item to dataTable
	function isStockSufficient()
	{
		qty = getUnmaskQty();
		stock = parseInt($('#stock').val());
		if (stock >= qty) {
			return 'Y';
		} else {
			return 'N';
		}
	}

	// check list item is there any duplicate data with current added data
	function isAlreadyExists()
	{
		var filteredData = tb_penjualan
				.column(0)
				.data()
				.filter( function ( value, index ) {
					return value.indexOf($('#itemName').val()) >= 0 ? true : false;
				} );
		return filteredData;
	}

	// check stock after item already inside dataTable
	function checkStock(stock, price, rowId)
	{
		qty = tb_penjualan.cell(rowId, 1).nodes().to$().find('input').val();
		if (qty > stock) {
			messageWarning('Perhatian', 'Stock tidak mencukupi, permintaan disesuaikan dengan stock !');
			tb_penjualan.cell(rowId, 1).nodes().to$().find('input').val(stock);
		}
		countDiscount(price, rowId);
	}

	// count discount each item inside dataTable
	function countDiscount(price, rowId)
	{
		price = parseInt(price);
		discH = tb_penjualan.cell(rowId, 5).nodes().to$().find('input').val();
		discP = tb_penjualan.cell(rowId, 4).nodes().to$().find('input').val();
		qty = tb_penjualan.cell(rowId, 1).nodes().to$().find('input').val();
		totalPrice = qty * price;

		totalDiscP = (totalPrice * discP) / 100;
		totalDiscH = discH * qty;

		finalPrice = totalPrice - totalDiscP - totalDiscH;

		tb_penjualan.cell(rowId, 6).nodes().to$().find('input').val(finalPrice);
		tb_penjualan.draw(false);
		totalPenjualan = sumTotalBruto();
		$('#totalPenjualan').val(totalPenjualan);
		discountTotal = discTotal();
		$('#totalDisc').val(discountTotal);
		totalAmount = sumTotalAmount();
		$('#totalAmount').val(totalAmount);
	}

	// return total netto (total price after discount)
	function sumTotalNetto()
	{
		let listTotalPerItem = [];
		for (let i = 0; i < tb_penjualan.rows()[0].length; i++) {
			listTotalPerItem.push(parseInt(tb_penjualan.cell(i, 6).nodes().to$().find('input').val()));
		}
		let totalNetto = listTotalPerItem.reduce((partial_sum, a) => partial_sum + a);
		return totalNetto;
	}

	// return total bruto (total price before discount)
	function sumTotalBruto()
	{
		let listBrutoPerItem = []
		let price = 0;
		let qty = 0;
		for (let i = 0; i < tb_penjualan.rows()[0].length; i++) {
			qty = parseInt(tb_penjualan.cell(i, 1).nodes().to$().find('input').val());
			price = parseInt(tb_penjualan.cell(i, 3).nodes().to$().find('input').val());
			Bruto = qty * price;
			listBrutoPerItem.push(Bruto);
		}
		totalBruto = listBrutoPerItem.reduce((partial_sum, a) => partial_sum + a);
		return totalBruto;
	}

	// return total discount used for all items
	function discTotal()
	{
		totalBruto = sumTotalBruto();
		totalNetto = sumTotalNetto();
		let disc = totalBruto - totalNetto;
		return disc;
	}

	// insert item to dataTable
	function table_tambah()
	{
		if ( $('#qty').val() === '' || $('#barang').val() === '' || $('#qty').val().length === 0 || $('#barang').val().length === 0 ) {
			if ( $('#qty').val() === '' || $('#qty').val().length === 0 ) {
				messageWarning('Perhatian', 'Qty tidak boleh kosong !');
				$('#qty').parents('.form-group').addClass('has-error');
			}
			if ( $('#barang').val() === '' || $('#barang').val().length === 0 ) {
				messageWarning('Perhatian', 'Barang tidak boleh kosong !');
				$('#barang').parents('.form-group').addClass('has-error');
			}
			return false;

		} else if($('#qty').val() !== '' || $('#barang').val() !== ''){
			if (isStockSufficient() == 'Y') {
				qty = getUnmaskQty();
				$.ajax({
					url: baseUrl + "/penjualan/penjualanorder/getPrice",
					data: {
						"priceGroup": $('#group_price').val(),
						"itemId": $('#itemId').val()
					},
					type: "get",
					dataType: "json",
					success: function(response) {
						alreadyExists = isAlreadyExists();
						rowId = tb_penjualan.rows().count();
						if (alreadyExists.length == 0) {
							tb_penjualan.row.add([
								$('#itemName').val() +
									'<input type="hidden" value="'+$('#itemId').val()+'" class="barang" name="listItemId[]">',
								'<input type="text" min="0" class="form-control form-control-sm" name="listQty[]" value="'+ qty +'" onchange="checkStock('+ parseInt($('#stock').val()) +','+ response.ip_price +','+ rowId +')">',
								'<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ $('#itemSatName').val() +'" readonly>' +
									'<input type="hidden" value="'+$('#itemSatId').val()+'" name="listSatId[]">',
								'<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ response.ip_price +'" readonly>',
								'<input type="number" class="form-control form-control-sm" name="listDiscP[]" value="0" onchange="countDiscount('+ response.ip_price +','+ rowId +')">',
								'<input type="number" class="form-control form-control-sm" name="listDiscH[]" value="0" onchange="countDiscount('+ response.ip_price +','+ rowId +')">',
								'<input type="text" readonly="" class="form-control form-control-plaintext form-control-sm text-right" value="0">',
								'<button class="btn btn-danger btn-hapus-kenangan" type="button" title="Delete"><i class="fa fa-trash-o"></i></button>'
							]).node().id = rowId;
							checkStock(parseInt($('#stock').val()), response.ip_price, rowId);
							// countDiscount(response.ip_price, rowId);
							counter++;
							clearSelectItem();
						} else {
							messageWarning('Perhatian', 'Barang sudah terdaftar di list belanja !');
						}
					},
					error: function(e) {
						messageWarning('Perhatian', 'Harga barang tidak ditemukan !');
					}
				})
			} else {
				messageWarning('Perhatian', 'Stock tidak mencukupi !');
			}
			// $('#barang').prop('selectedIndex', 0).trigger('change');
			// $('#barang').select2('open');
		}
	}

	// return total amount (final price that has to be pay)
	function sumTotalAmount()
	{
		totalPenjualan = $('#totalPenjualan').val();
		totalDisc = $('#totalDisc').val();
		ppn = $('#ppn').val();

		totalNetto = sumTotalNetto();
		ppnVal = totalNetto * ppn / 100;
		// console.log('netto: ' + totalNetto);
		// console.log('ppn: ' + ppnVal);
		totalAmount = totalNetto + ppnVal;
		return totalAmount;
	}

</script>

<script type="text/javascript">
	var table2 	= $('#table_pembayaran').DataTable();
	var counter = 0;


	// $('#barang').on('select2:select', function(){
	// 	$('#qty').focus();
	// })

	$('#input-barang input, #input-barang select').on('change focus blur keyup', function(){
		if($(this).val() !== '' || $(this).val().length !== 0){
			$(this).parents('.form-group').removeClass('has-error');
		}
	});

	function hapus_row(a){
		tb_penjualan.row($(a).parents('tr')).remove().draw();
	}

	$(document).ready(function(){

		$('#table_penjualan tbody').on('click', '.btn-hapus-kenangan', function(){
			hapus_row($(this));
		});
	});

	$('#btn-modal-customer').click(function(){

		$('#tambah_cust').modal('show');

	});
</script>
@endsection
