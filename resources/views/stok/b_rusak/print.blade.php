<!DOCTYPE html>
<html>
<head>
	<title>FORM PEMAKAIAN BARANG GUDANG</title>
	<style type="text/css">
		*{
			font-size: 12px;
		}
		.s16{
			font-size: 14px !important;
		}
		.div-width{
			margin: auto;
			width: 95vw;
		}
		.underline{
			text-decoration: underline;
		}
		.italic{
			font-style: italic;
		}
		.bold{
			font-weight: bold;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-top{
			border-top: hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-all{
			border: hidden;
		}
		.float-left{
			float: left;
		}
		.float-right{
			float: right;
		}
		.top{
			vertical-align: text-top;
		}
		.vertical-baseline{
			vertical-align: baseline;
		}
		.bottom{
			vertical-align: text-bottom;
		}
		.ttd{
			top: 0;
			position: absolute;
		}
		.relative{
			position: relative;
		}
		.absolute{
			position: absolute;
		}
		.empty{
			height: 15px;
		}
		table,td{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td, .border-none tr{
			border:none !important;
		}
		@media print{
			.btn-print{
				display: none;
			}
		}
		@page{
			size: landscape;
			margin: 0;
		}
		.div-page-break{
			page-break-after: always;
		}
		.border-hidden tr, .border-hidden td{
			border: hidden;
		}
		.btn-print{
			right: 10px;
			position: absolute;
		}
</style>
</head>
<body>
	<div class="btn-print">
		<button onclick="javascript:window.print();">Print</button>
	</div>
	<div class="div-width">

		@for($i=0;$i<count($dataIsi);$i++)
		
			<div class="div-page-break">
					<h1 class="s16">Nabilla </h1>
					<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="s16 underline bold text-center" colspan="3">FORM TANDA TERIMA BARANG RUSAK</td>
						</tr>
						<tr>
							<td width="80%">
								Kode Terima : <label class="bold">{{$dataHeader[0]['d_br_code']}}</label><br>
								Tanggal Terima : <label class="bold">{{date('d M Y',strtotime($dataHeader[0]['d_br_date']))}}</label><br>
								Staff : <label class="bold">{{Auth::user()->m_name}}</label>
							</td>
							<td>
								Gudang Asal : <label class="bold">{{$dataHeader[0]['gc_gudang']}}</label><br>
								Dari : <label class="bold">{{$dataHeader[0]['d_br_pemberi']}}</label><br>
							</td>
						</tr>
					</table>
					<table width="100%" cellpadding="3px" class="tabel" border="1px">
						<tr class="text-center">
							<td width="5%">No</td>
							<td width="45%">Kode | Barang</td>
							<td width="10%">Qty</td>
							<td width="10%">Satuan</td>
							<td width="10%">Stok</td>
							<td width="20%">Keterangan</td>
						</tr>

						@for($j=0;$j<count($dataIsi[$i]);$j++)
							<tr>
								<td class="text-center">{{$j+1}}</td>
								<td>{{$dataIsi[$i][$j]['i_code']}} {{$dataIsi[$i][$j]['i_name']}}</td>
								<td class="text-center">{{$dataIsi[$i][$j]['qty_pakai']}}</td>
								<td>{{$dataIsi[$i][$j]['s_name']}}</td>
								<td>{{ $val_stock[$i][$j] }} {{ $txt_satuan[$i][$j]->s_name }}</td>
								<td>{{$dataIsi[$i][$j]['d_brdt_keterangan']}}</td>
							</tr>
						@endfor


						<?php
							$kosong = [];
							$hitung = 14 - count($dataIsi[$i]);

							for ($a=0; $a < $hitung; $a++) { 
								array_push($kosong, 'a');
							}
						?>
						@foreach($kosong as $index => $we)
						<tr>
							<td class="text-center empty"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endforeach
						
						
						<tr>
							<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
						</tr>
						
					</table>
							<div class="float-left" style="margin-left: 3vw;">
								<div class="top">
									Kepala Finance,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-left" style="margin-left: 25px;">
								<div class="top">
									Finance,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-right" style="margin-right: 25px;">
								<div class="top">
									Pemberi Barang,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									({{$dataHeader[0]['d_br_pemberi']}})
								</div>
							</div>
							<div class="float-right" style="margin-right: 3vw;">
								<div class="top">
									Adm Gudang,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									({{Auth::user()->m_name}})
								</div>
							</div>
			</div>
			
		@endfor
	</div>

	<div style="padding-top: 100px;">
		<hr>
	</div>
	
	
	
</body>
</html>