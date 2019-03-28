@extends('main')

@section('content')

@include('penjualan.penjualanorder.modal_cust')
@include('penjualan.penjualanorder.modal_pembayaran')
@include('penjualan.penjualanorder.modal_detailpenjualan')

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
        </ul>

		<div class="row">

			<div class="col-12">

				<div class="tab-content">

					@include('penjualan.penjualanorder.tab_formpenjualan')
					@include('penjualan.penjualanorder.tab_list')

				</div>

			</div>

		</div>

	</section>

</article>

@endsection
@section('extra_script')

<!-- script for general -->
<script type="text/javascript">
	$(document).ready(function() {
		// jquery token
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		// datepicker -> set starting date_to
		cur_date = new Date();
		first_day = new Date(cur_date.getFullYear(), cur_date.getMonth(), 1);
		last_day =   new Date(cur_date.getFullYear(), cur_date.getMonth() + 1, 0);
	});
</script>

<!-- script for tab-penjualan-order -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#tambah_cust').on('hidden.bs.modal', function() {
			$('#newCustomerForm')[0].reset();
		});

		$('#btn_simpan_customer').on('click', function() {
			let dataNewCust = $('#newCustomerForm').serialize();
			$.ajax({
				url: "{{ route('simpan_datacustomer') }}",
				data: dataNewCust,
				type: 'get',
				dataType : 'json',
				success : function (response){
					if (response.status == 'sukses') {
						$('#idCustomer').val(response.id);
						$('#customer').val($('#c_name').val());
						$('#address').val($('#c_address').val());
						$('#tambah_cust').modal('hide');
						$('#ket_project').focus();
						console.log('New customer created: '+ response.message);
					} else if (response.status == 'gagal') {
						console.log('gagal: '+ response.message);
					}
				},
				error : function(e){
					console.log('Error: '+ e);
				}
			});
		});

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
			source: baseUrl + '/penjualan/penjualanorder/getCustomers',
			minLength: 2,
			select: function(event, data){
				$('#address').val(data.item.address);
				$('#idCustomer').val(data.item.id);
				$('#ket_project').focus();
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
		$('#cal-dueDate').on('click', function() {
			$('#dueDate').trigger('focus');
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

		$('#modal_bayar').on('hidden.bs.modal', function() {
			$('#paymentForm')[0].reset();
			$('#btn_simpan').attr('disabled', true);
		});
		$('#modal_bayar').on('shown.bs.modal', function() {
			totalAmount = sumTotalAmount();
			$('.totalAmount').val(totalAmount);
		});

		$('#btn_simpan').on('click', function() {
			SubmitForm(event);
		});
	});

	function hapus_row(a){
		// console.log(tb_penjualan.row($(a).parents('tr')).index());
		// rowId = tb_penjualan.row($(a).parents('tr')).index();
		tb_penjualan.row($(a).parents('tr')).remove().draw();
		updateTotalAmount();
	}

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
				"itemId": $('#itemId').val()
			},
			type : "get",
			url : "{{ route('penjualanorder.getstock') }}",
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
		qty = $('#qty').val();
		stock = parseInt($('#stock').val());
		if (stock >= qty) {
			return 'Y';
		} else {
			return 'Y';
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
		// qty = tb_penjualan.cell(rowId, 1).nodes().to$().find('input').val();
		// if (qty > stock) {
		// 	messageWarning('Perhatian', 'Stock tidak mencukupi, permintaan disesuaikan dengan stock !');
		// 	tb_penjualan.cell(rowId, 1).nodes().to$().find('input').val(stock);
		// }
		countDiscount(price, rowId);
	}

	// count discount each item inside dataTable
	function countDiscount(price, rowId)
	{
		price = parseInt(price);
		discH = parseInt(tb_penjualan.cell(rowId, 5).nodes().to$().find('input').val());
		discP = parseInt(tb_penjualan.cell(rowId, 4).nodes().to$().find('input').val());
		// validate if the discP is more than 100 %
		if (discP > 100) {
			discP = 100;
			tb_penjualan.cell(rowId, 4).nodes().to$().find('input').val(100);
		}
		// validate if the discP is less than 0 % or is-NaN
		if (discP < 0 || isNaN(discP)) {
			discP = 0;
			tb_penjualan.cell(rowId, 4).nodes().to$().find('input').val(0);
		}
		// validate if the discH is more than price
		if (discH > price) {
			discH = price;
			tb_penjualan.cell(rowId, 5).nodes().to$().find('input').val(price);
		}
		qty = parseInt(tb_penjualan.cell(rowId, 1).nodes().to$().find('input').val());
		totalPrice = qty * price;

		totalDiscP = (totalPrice * discP) / 100;
		totalDiscH = discH * qty;

		finalPrice = totalPrice - totalDiscP - totalDiscH;

		tb_penjualan.cell(rowId, 6).nodes().to$().find('input').val(finalPrice);
		tb_penjualan.draw(false);
		updateTotalAmount();
	}

	function updateTotalAmount()
	{
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
		if (listTotalPerItem.length !== 0) {
			totalNetto = listTotalPerItem.reduce((partial_sum, a) => partial_sum + a);
		} else {
			totalNetto = 0;
		}
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
		if (listBrutoPerItem.length !== 0) {
			totalBruto = listBrutoPerItem.reduce((partial_sum, a) => partial_sum + a);
		} else {
			totalBruto = 0;
		}
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
								'<input type="text" min="0" class="form-control form-control-sm currency-x text-right" name="listQty[]" value="'+ $('#qty').val() +'" onchange="checkStock('+ parseInt($('#stock').val()) +','+ response.ip_price +','+ rowId +')">',
								'<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ $('#itemSatName').val() +'" readonly>' +
									'<input type="hidden" value="'+$('#itemSatId').val()+'" name="listSatId[]">',
								'<input type="text" class="form-control form-control-plaintext form-control-sm currency text-right" name="listPrice[]" value="'+ response.ip_price +'" readonly>',
								'<input type="text" min="0" class="form-control form-control-sm currency-x text-right" name="listDiscP[]" value="0" onchange="countDiscount('+ response.ip_price +','+ rowId +')">',
								'<input type="text" min="0" class="form-control form-control-sm currency text-right" name="listDiscH[]" value="0" onchange="countDiscount('+ response.ip_price +','+ rowId +')">',
								'<input type="text" readonly="" class="form-control form-control-plaintext form-control-sm currency text-right" name="listSubTotal[]" value="0,00">',
								'<button class="btn btn-danger btn-hapus-kenangan" type="button" title="Delete"><i class="fa fa-trash-o"></i></button>'
							]).node().id = rowId;
							// add manually inputmask to each .currency
							$.each(tb_penjualan.row(rowId).nodes().to$().find('.currency'), function() {
								$(this).inputmask("currency", {
						      radixPoint: ".",
						      groupSeparator: ".",
						      digits: 2,
						      autoGroup: true,
						      prefix: '', //Space after $, this will not truncate the first character.
						      rightAlign: false,
						      autoUnmask: true,
						      // unmaskAsNumber: true,
						    });
							});
							// add manually inputmask to each .currency-x
							$.each(tb_penjualan.row(rowId).nodes().to$().find('.currency-x'), function() {
								$(this).inputmask("currency", {
									radixPoint: ".",
									groupSeparator: ".",
									digits: 0,
									autoGroup: true,
									prefix: '', //Space after $, this will not truncate the first character.
									rightAlign: false,
									autoUnmask: true,
									// unmaskAsNumber: true,
								});
							});
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
		// validate if ppn is more than 100 % or is less than 0 or is null
		if (ppn > 100) {
			ppn = 100;
			$('#ppn').val(100);
		} else if (ppn < 0 || isNaN(ppn) || ppn === '') {
			ppn = 0;
			$('#ppn').val(0);
		}

		totalNetto = sumTotalNetto();
		ppnVal = totalNetto * ppn / 100;
		totalAmount = totalNetto + ppnVal;
		return totalAmount;
	}

	// return total kembalian (change for customer)
	function sumTotalKembalian()
	{
		totalAmount = $('#totalAmount').val();
		totalBayar = $('#totalBayar').val();

		kembalian = totalBayar - totalAmount;
		if (totalBayar > 0 && kembalian >= 0) {
			$('#btn_simpan').attr('disabled', false);
		} else {
			$('#btn_simpan').attr('disabled', true);
		}
		return kembalian;
	}

	// reset all input-field
	function resetAllInput()
	{
		$('.totalAmount').val('0,00');
		$('#newCustomerForm')[0].reset();
		$('#customerForm')[0].reset();
		$('#salesForm')[0].reset();
		$('#paymentForm')[0].reset();
		tb_penjualan.clear().draw();
	}

	// store-data -> submit form to store data in db
	function SubmitForm(event)
	{
		event.preventDefault();
		customer = $('#customerForm').serialize();
		sales = $('#salesForm').serialize();
		payment = $('#paymentForm').serialize();

		let listItems = $();
		for (let i = 0; i < tb_penjualan.rows()[0].length; i++) {
			listItems = listItems.add(tb_penjualan.row(i).node());
		}
		let dataListItems = listItems.find('input').serialize();

		data_final = customer +'&'+ sales +'&'+ payment +'&'+ dataListItems;

		$.ajax({
			data : data_final,
			type : "post",
			url : baseUrl + '/penjualan/penjualanorder/store',
			dataType : 'json',
			success : function (response){
				if(response.status == 'berhasil'){
					messageSuccess('Berhasil', 'Data berhasil ditambahkan !');
					resetAllInput();
					$('#modal_bayar').modal('hide');
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

		$('#modal_detailpenjualan').on('hidden.bs.modal', function() {
			$('.detail-penjualan')[0].reset();
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
				url: "{{ route('penjualanorder.getlistpenjualan') }}",
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
				{data: 'staff', width: "30%"},
				{data: 'customer', width: "40%"},
				{data: 'action'}
			],
			pageLength: 10,
			lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']]
		});
	}

	function DetailPenjualan(id)
	{
		console.log('DetailPenjualan: '+ id);
		// initiate tb_detailpenjualan
		var tb_detailpenjualan;
		$('#table_detailpenjualan').dataTable().fnDestroy();
		tb_detailpenjualan = $('#table_detailpenjualan').DataTable({
			responsive: true,
			paging: false,
			info: false,
			searching: false
		});
		tb_detailpenjualan.clear().draw();

		$.ajax({
			url: baseUrl + "/penjualan/penjualanorder/getDetailPenjualan/" + id,
			type: 'get',
			success : function (response){
				console.log(response);
				newDate = new Date(response.s_date);
				$('#dt_date').val(newDate.getDate() +'-'+ (newDate.getMonth() + 1) +'-'+ newDate.getFullYear());
				$('#dt_nota').val(response.s_note);
				(response.get_customer != null) ? $('#dt_customer').val(response.get_customer.c_name) : $('#dt_customer').val('(kosong)');
				$('#dt_subtotal').val(response.s_gross);
				$('#dt_totaldisc').val(response.s_disc_value);
				$('#dt_ppn').val(response.s_tax);
				$('#dt_grandtotal').val(response.s_net);
				(response.get_sales_payment != null) ? $('#dt_totalpayment').val(response.get_sales_payment.sp_nominal) : $('#dt_totalpayment').val('(kosong)');

				$.each(response.get_sales_dt, function(key, val) {
					let discH = val.sd_disc_value / val.sd_qty;
					rowId = tb_detailpenjualan.rows().count();
					tb_detailpenjualan.row.add([
						'<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ val.get_item.i_name +'">',
						'<input type="text" class="form-control form-control-plaintext form-control-sm currency text-right" value="'+ val.sd_qty +'" readonly>',
						'<input type="text" class="form-control form-control-plaintext form-control-sm" value="'+ val.get_item.get_satuan1.s_name +'" readonly>',
						'<input type="text" class="form-control form-control-plaintext form-control-sm currency text-right" value="'+ val.sd_price +'" readonly>',
						'<input type="text" class="form-control form-control-plaintext form-control-sm currency text-right" value="'+ val.sd_disc_percent +'" readonly>',
						'<input type="text" class="form-control form-control-plaintext form-control-sm currency text-right" value="'+ discH +'" readonly>',
						'<input type="text" class="form-control form-control-plaintext form-control-sm currency text-right" value="'+ val.sd_total +'" readonly>'
					]).node().id = rowId;
					// add manually inputmask to each .currency
					$.each(tb_detailpenjualan.row(rowId).nodes().to$().find('.currency'), function() {
						$(this).inputmask("currency", {
							radixPoint: ".",
							groupSeparator: ".",
							digits: 2,
							autoGroup: true,
							prefix: '', //Space after $, this will not truncate the first character.
							rightAlign: false,
							autoUnmask: true,
							// unmaskAsNumber: true,
						});
					});
				});
				tb_detailpenjualan.draw(false);
			},
			error : function(e){
				console.log('Error: '+ e);
			}
		});
		$('#modal_detailpenjualan').modal('show');
	}
	function EditPenjualan(id)
	{
		console.log('EditPenjualan: '+ id);
		window.location.href = baseUrl + '/penjualan/penjualanorder/edit/' + id;
	}

</script>

<script type="text/javascript">
	$('#input-barang input, #input-barang select').on('change focus blur keyup', function(){
		if($(this).val() !== '' || $(this).val().length !== 0){
			$(this).parents('.form-group').removeClass('has-error');
		}
	});


	$(document).ready(function(){
		$('#table_penjualan tbody').on('click', '.btn-hapus-kenangan', function(){
			hapus_row($(this));
		});
		// $('#btn-modal-customer').on('click', function() {
		// 	$('#tambah_cust').modal('show');
		// });
	});

</script>
@endsection
