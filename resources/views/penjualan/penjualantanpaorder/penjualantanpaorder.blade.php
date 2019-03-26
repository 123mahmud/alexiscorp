@extends('main')

@section('content')

@include('penjualan.penjualantanpaorder.modal_cust')
@include('penjualan.penjualantanpaorder.modal_bayar')

<article class="content">

	<div class="title-block text-primary">
	    <h1 class="title"> Pencatatan Penjualan Tanpa Order </h1>
	    <p class="title-description">
	    	<i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a>
	    	/ <span>Penjualan</span>
	    	/ <span class="text-primary font-weight-bold">Pencatatan Penjualan Tanpa Order</span>
	     </p>
	</div>

	<section class="section">

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a href="" class="nav-link active" data-target="#pos" aria-controls="pos" data-toggle="tab" role="tab">Penjualan Tanpa Order</a>
			</li>
			<li class="nav-item">
				<a href="" class="nav-link" data-target="#list_pos" aria-controls="list_pos" data-toggle="tab" role="tab">List Penjualan</a>
			</li>
		</ul>

		<div class="row">

			<div class="col-12">

				<div class="tab-content">

					@include('penjualan.penjualantanpaorder.tab_formpenjualan')
					@include('penjualan.penjualantanpaorder.tab_list')

				</div>

			</div>

		</div>

	</section>

</article>
@endsection


@section('extra_script')
<!-- script for general -->
<script type="text/javascript">
	// jquery token
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function() {
		// datepicker -> set starting date_to
		cur_date = new Date();
		first_day = new Date(cur_date.getFullYear(), cur_date.getMonth(), 1);
		last_day =   new Date(cur_date.getFullYear(), cur_date.getMonth() + 1, 0);
	});
</script>

<!-- script for tab-penjualan-order -->
<script type="text/javascript">
	$(document).ready(function() {
		tb_penjualan = $('#table_penjualan').DataTable({
			"order": [],
			"searching": false,
			"lengthChange": false,
			"paging": false,
			"info": false,
		});

		$('#customer').on('click', function() {
			clearCustomer();
		});
		$('#customer').autocomplete({
			source: baseUrl + '/penjualan/penjualantanpaorder/getCustomers',
			minLength: 2,
			select: function(event, data){
				$('#address').val(data.item.address);
				$('#idCustomer').val(data.item.id);
				$('#barang').focus();
			}
		});
		function clearCustomer()
		{
			$('#customer').val('');
			$('#address').val('');
			$('#idCustomer').val('');
		}

		$('#cal-orderDate').on('click', function() {
			$('#orderDate').trigger('focus');
		});

		$('#barang').on('click', function() {
			clearSelectItem();
		});
		$('#barang').autocomplete({
			source: baseUrl + '/penjualan/penjualanorder/getItems',
			minLength: 2,
			select: function(event, data){
				$('#itemId').val(data.item.id);
				$('#itemName').val(data.item.name);
				$('#itemSatId').val(data.item.sat1_id);
				$('#itemSatName').val(data.item.sat1_name);
				getItemStock();
				$('#qty').focus();
			}
		});

		// $('#qty').inputmask('999.999.999.999', {placeholder: " "});
		$('#qty').on('click', function() {
			$(this).val('');
		});
		$('#qty').on('keypress', function(e){
			if(e.keypress === 13 || e.keyCode === 13){
				table_tambah();
			}
		});
		$('.btn-tambah').on('click', function(){
			table_tambah();
		});

		$('#ppn').on({
			keyup: function() {
				totalAmount = sumTotalAmount();
				$('.totalAmount').val(totalAmount);
			},
			change: function() {
				totalAmount = sumTotalAmount();
				$('.totalAmount').val(totalAmount);
			}
		});

		$('#totalBayar').on({
			keyup: function() {
				kembalian = sumTotalKembalian();
				$('#kembalian').val(kembalian);
			},
			change: function() {
				kembalian = sumTotalKembalian();
				$('#kembalian').val(kembalian);
			}
		});

		$('#btn_simpan').on('click', function() {
			SubmitForm(event);
		});
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
			url : "{{ route('penjualantanpaorder.getstock') }}",
			dataType : 'json',
			success : function (response){
				$('#stock').val(response.s_qty);
			},
			error : function(e){
				$('#stock').val(0);
			}
		});
	}

	// check stock before adding item to dataTable
	// because it is Order, it always return 'Y'
	function isStockSufficient()
	{
		qty = parseInt($('#qty').val());
		stock = parseInt($('#stock').val());
		console.log(stock);
		console.log(qty);
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
			messageWarning('Perhatian', 'Stock tidak mencukupi, permintaan disesuaikan dengan jumlah stock !');
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
		$('.totalAmount').val(totalAmount);
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
				// qty = getUnmaskQty();
				$.ajax({
					url: baseUrl + "/penjualan/penjualantanpaorder/getPrice",
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
							'<input type="number" min="0" class="form-control form-control-sm" name="listQty[]" value="'+ qty +'" onchange="checkStock('+ parseInt($('#stock').val()) +','+ response.ip_price +','+ rowId +')">',
							'<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ $('#itemSatName').val() +'" readonly>' +
							'<input type="hidden" value="'+$('#itemSatId').val()+'" name="listSatId[]">',
							'<input type="text" class="form-control form-control-plaintext form-control-sm" name="listPrice[]" value="'+ response.ip_price +'" readonly>',
							'<input type="number" min="0" class="form-control form-control-sm" name="listDiscP[]" value="0" onchange="countDiscount('+ response.ip_price +','+ rowId +')">',
							'<input type="number" min="0" class="form-control form-control-sm" name="listDiscH[]" value="0" onchange="countDiscount('+ response.ip_price +','+ rowId +')">',
							'<input type="text" readonly="" class="form-control form-control-plaintext form-control-sm text-right" name="listSubTotal[]" value="0">',
							'<button class="btn btn-danger btn-hapus-kenangan" type="button" title="Delete"><i class="fa fa-trash-o"></i></button>'
							]).node().id = rowId;
							checkStock(parseInt($('#stock').val()), response.ip_price, rowId);
							clearSelectItem();
						} else {
							messageWarning('Perhatian', 'Barang sudah terdaftar di list belanja !');
						}
					},
					error: function(e) {
						messageWarning('Perhatian', 'Harga barang tidak ditemukan !');
					}
				})
				$('#barang').focus();
			} else {
				messageWarning('Perhatian', 'Stock tidak mencukupi !');
			}
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
		totalAmount = totalNetto + ppnVal;
		return totalAmount;
	}

	// duplicate value of totalAmountM and normalize it, then store it to totalAmountHidden
	function normalizingTotalPenjualan()
	{
		totalPenjualan = $('#totalPenjualan').val();
		totalPenjualan = totalPenjualan.replace(/,/g, '');
		totalPenjualan = totalPenjualan.replace('.00', '');
		$('#totalPenjualanHidden').val(totalPenjualan);
	}

	// duplicate value of totalAmountM and normalize it, then store it to totalAmountHidden
	function normalizingTotalAmount()
	{
		totalAmount = $('#totalAmountM').val();
		totalAmount = totalAmount.replace(/,/g, '');
		totalAmount = totalAmount.replace('.00', '');
		$('#totalAmountHidden').val(totalAmount);
	}

	// return total kembalian (change for customer)
	function sumTotalKembalian()
	{
		normalizingTotalAmount();
		totalAmount = $('#totalAmountHidden').val();
		totalBayar = $('#totalBayar').val();
		totalBayar = totalBayar.replace(/,/g, '');
		totalBayar = totalBayar.replace('.00', '');
		$('#totalBayarHidden').val(totalBayar);

		kembalian = totalBayar - totalAmount;
		if (kembalian >= 0) {
			$('#btn_simpan').attr('disabled', false);
		} else {
			$('#btn_simpan').attr('disabled', true);
		}
		return kembalian;
	}

	// resset all input-field
	function resetAllInput()
	{
		$('.totalAmount').val('0,00');
		$('#customerForm')[0].reset();
		$('#salesForm')[0].reset();
		$('#paymentForm')[0].reset();
		tb_penjualan.clear().draw();
	}

	// store-data -> submit form to store data in db
	function SubmitForm(event)
	{
		event.preventDefault();
		// normalize totalAmount (discard comma, extra-00, etc)
		normalizingTotalAmount();
		// normalize totalPenjualan (discard comma, extra-00, etc)
		normalizingTotalPenjualan();

		customer = $('#customerForm').serialize();
		sales = $('#salesForm').serialize();
		payment = $('#paymentForm').serialize();

		let listItems = $();
		for (let i = 0; i < tb_penjualan.rows()[0].length; i++) {
			listItems = listItems.add(tb_penjualan.row(i).node());
		}
		let dataListItems = listItems.find('input').serialize();

		data_final = customer +'&'+ sales +'&'+ payment +'&'+ dataListItems;
		console.log(data_final);

		$.ajax({
			data : data_final,
			type : "post",
			url : baseUrl + '/penjualan/penjualantanpaorder/store',
			dataType : 'json',
			success : function (response){
				if(response.status == 'berhasil'){
					messageSuccess('Berhasil', 'Data berhasil ditambahkan !');
					resetAllInput();
					// location.reload();
				} else if (response.status == 'invalid') {
					messageFailed('Perhatian', response.message);
				} else if (response.status == 'gagal') {
					messageWarning('Error', response.message);
				}
			},
			error : function(e){
				messageWarning('Gagal', 'Data gagal ditambahkan, hubungi pengembang !');
			}
		})
	}

</script>

<!-- script for tab-list-penjualan -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#date_from_pj').datepicker('setDate', first_day);
		$('#date_to_pj').datepicker('setDate', last_day);

		TableListPenjualan();
		$('#date_from_pj').on('change', function() {
			TableListPenjualan();
		});
		$('#date_to_pj').on('change', function() {
			TableListPenjualan();
		});
		$('#btn_search_date_pj').on('click', function() {
			TableListPenjualan();
		});
		$('#btn_refresh_date_pj').on('click', function() {
			TableListPenjualan();
		});
	});

	// data-table -> function to retrieve DataTable server side
	var tb_listpenjualan;
	function TableListPenjualan()
	{
		$('#table_listpenjualan').dataTable().fnDestroy();
		tb_listpenjualan = $('#table_listpenjualan').DataTable({
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('penjualantanpaorder.getlistpenjualan') }}",
				type: "get",
				data: {
					"_token": "{{ csrf_token() }}",
					"date_from" : $('#date_from_pj').val(),
					"date_to" : $('#date_to_pj').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex'},
				{data: 's_note'},
				{data: 'customer', width: "70%"},
				{data: 'action'}
			],
			pageLength: 10,
			lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']]
		});
	}
</script>


@endsection
