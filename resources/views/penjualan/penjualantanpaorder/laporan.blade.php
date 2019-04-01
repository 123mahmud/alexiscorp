<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Alexis</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('assets/img/cv-mutiaraberlian-icon.png')}}">
    <link rel="stylesheet" href="{{asset('assets/css/nota.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">
</head>
<body>
<div class="btn-print">
    <button type="button" onclick="javascript:window.print();">Print</button>
</div>
<div class="div-width page-break">

  <div class="col-6">
    <table class="border-none" width="100%">
      <tr>
        <td width="15%">Laporan</td>
        <td width="1%">:</td>
        <td>Penjualan per Barang - Detail</td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td>{{ $data['date_from'] }} - {{ $data['date_to'] }}</td>
      </tr>
      <tr>
        <td>Staff</td>
        <td>:</td>
        <td>{{ $data['staff'] }}</td>
      </tr>
    </table>
  </div>

  <div class="col-6">

    <h1 class="m-unset">Alexis</h1>
    <h3>Laporan Penjualan</h3>

  </div>

  <table width="100%" class="mt-3" cellpadding="5px">
    <thead>
      <tr>
        <th>No</th>
        <th width="20%">Barang</th>
        <th>Nota</th>
        <th>Tanggal</th>
        <th>Customer</th>
        <th>Satuan</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Diskon % (Value)</th>
        <th>Diskon Val</th>
        <th>Sub Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data['sales'] as $index=>$val)
      <tr>
        <td><div class="text-right">{{ $index+1 }}</div></td>
        <td>{{ $val->getItem->i_name }}</td>
        <td>{{ $val->getSales->s_note }}</td>
        <td>{{ $data['salesdate'][$index] }}</td>
        <td>{{ $val->getSales->getCustomer->c_name }}</td>
        <td>{{ $val->getItem->getSatuan1->s_name }}</td>
        <td><div class="digits text-right">{{ $val->sd_qty }}</div></td>
        <td><div class="digits text-right">{{ $val->sd_price }}</div></td>
        <td><div class="currency text-right">{{ $val->sd_disc_vpercent }}</div></td>
        <td><div class="currency text-right">{{ (int)$val->sd_disc_value / (int)$val->sd_qty }}</div></td>
        <td><div class="currency text-right">{{ $val->sd_total }}</div></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <!-- <tr>
        <td class="tebal" align="right" colspan="10">Total Net</td>
        <td>
          <div class="float-left">Rp. </div><div class="float-right" id="totalnet"></div>
        </td>
      </tr> -->
    </tfoot>
  </table>

  <br>
  <div class="col-5">
    <table class="border-none" width="100%">
      <tr>
        <td width="40%">Diskon % (value)</td>
        <td width="1%">:</td>
        <td class="currency text-right">{{ $data['totalDiscP'] }}</td>
      </tr>
      <tr>
        <td>Diskon value</td>
        <td>:</td>
        <td class="currency text-right">{{ $data['totalDiscH'] }}</td>
      </tr>
      <tr>
        <td>Grand total</td>
        <td>:</td>
        <td class="currency text-right">{{ $data['grandTotal'] }}</td>
      </tr>
    </table>
  </div>


</div>

</body>
</html>
<script src="{{asset('assets/jquery/jquery-3.1.0.min.js')}}"></script>
<script src="{{asset('assets/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<script type="text/javascript">
    //mask money
    $('.currency').inputmask("currency", {
      radixPoint: ".",
      groupSeparator: ".",
      digits: 2,
      autoGroup: true,
      prefix: '', //Space after $, this will not truncate the first character.
      rightAlign: false,
      autoUnmask: true,
      // unmaskAsNumber: true,
    });
    //mask money
    $('.digits').inputmask("currency", {
      radixPoint: ".",
      groupSeparator: ".",
      digits: 0,
      autoGroup: true,
      prefix: '', //Space after $, this will not truncate the first character.
      rightAlign: false,
      autoUnmask: true,
      // unmaskAsNumber: true,
    });
    $(document).ready(function () {
        // window.print();
    })
</script>
