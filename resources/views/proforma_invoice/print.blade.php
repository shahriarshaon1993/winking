<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('public/logo', $general_setting->site_logo)}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Proforma Invoice</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 12px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;

        }
        .page{
            background-image:url({{url('public/logo/back.PNG')}});
            background-repeat:no-repeat;background-position: center center;
        }

        .company-info h2{
            margin-top: 10px;
            font-weight: bold;
            font-family: initial;
            text-transform: uppercase;
        }
        .company-info p{
            font-weight: bold;
        }
        .vendor h2{
            font-size: 14px;
            font-weight: bold;
            text-transform: capitalize;
        }
        .company-address{
            margin: 0px;
            padding: 0px;
            font-size: 14px;
            min-height:20px;
            text-transform: uppercase;
            background-color: #d7d8da;
            font-weight: bold;
        }
        .company-address p{
            padding-top:0px;
        }
        .revised{
            margin: 0px;
            padding: 0px;
            font-size: 14px;
            min-height:10px;
            width: 25%;
            float: right;
            text-transform: uppercase;
            background-color: #d7d8da;
            font-weight: bold;
        }
        .right{
            float:right;
            font-weight: bold !important;
            color:black !important;
            margin: 0px;
            padding: 0px;
        }
        .left{
            float:left;
            font-weight: bold !important;
            color:black !important;
        }
        .logo{
            float:right;
        }
        .logo img{
            width: 120%;
            float: right;
        }
        .vendor p{
            margin: 0px;
            text-transform: uppercase;
            font-size:12px;
        }
        .vendor h4{
            margin: 0px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .table td, .table th{
            padding: .30rem !important;
        }
        .company-info p{
            margin: 0px;
            padding: 0px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .amount_table p{
             margin: 0px;
        }
        .amount_table th,td,p{
            text-transform: uppercase;
            font-family: initial;
            font-size:12px;
        }
        .customer{
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .title{
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
            margin:0px;
        }
        .description{
            text-align: center;
        }
        .signature{
            min-height: 80px;
            margin-top: 80px;
        }
        .signature h4{
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 100px;
            background-color: #cdcad2;
            padding: 5px;
            margin-bottom: 0px;
        }
        .signature h2,p{
            text-transform: uppercase;
            font-weight: bold;
            font-size: 12px;
            margin: 0px;
            padding: 0px;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }
        .footer-left{
            background-color: #D82116;
            color: black;
        }
        .footer-right{
            background-color: #0c0c0c;
            color: white;
            text-align: right;
        }
        .footer-left h2{
            font-weight: bold;
            font-size: 12px;
            padding: 0px 20px;
            padding-top: 5px;
            margin-bottom: 0px;
        }
        .footer-left h4{
            font-size: 12px;
            padding: 0px 20px;
            padding-bottom: 5px;
        }
        .footer-right h2{
            font-size: 12px;
            padding: 0px 16px;
            padding-top: 5px;
            margin-bottom: 0px;
            color:white;
        }
        .footer-right h4{
            font-size: 12px;
            padding: 0px 16px;
            padding-bottom: 5px;
            color:white;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        small{font-size:11px;}

        .page-header {
             height: 100px;
        }
        .page-header-space {
            height: 100px;
        }

        .page-footer, .page-footer-space {
            height: 50px;
        }
        .page-footer {
            position: fixed;
            bottom: 0;
            width: 82%;
            margin-top:30px; /* for demo */
        }
        .page-header {
            position: fixed;
            width: 80%;
        }

        .page {
            page-break-after: always;
        }

    @media print {
        *{
            font-size:14px;
            line-height: 20px;
        }
        .page{
            background-image:url({{url('public/logo/back.PNG')}});
            background-repeat:no-repeat;background-position: center center;
        }
        .hidden-print {
            display: none !important;
        }
        .page-header {
            position: fixed;
            width: 90%;
            height: 100px;
        }
        .page-footer {
            position: fixed;
            bottom: 0;
            width: 90%;
            height: 50px;
        }
        thead {display: table-header-group;}
        tfoot {display: table-footer-group;}
        button {display: none;}
        body {margin: 0;}

        body { -webkit-print-color-adjust: exact !important;}
    }
    </style>
  </head>
<body>

<div class="container">
<div>
    @if(preg_match('~[0-9]~', url()->previous()))
        @php $url = '../'; @endphp
    @else
        @php $url = url()->previous(); @endphp
    @endif
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="{{$url}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> {{trans('file.Back')}}</a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> {{trans('file.Print')}}</button></td>
            </tr>
        </table>
        <br>
    </div>

    <div id="receipt-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="border:none;">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card" style="border:none;">
                                        <div class="card-body" style="padding:0px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="company-info">
                                                        <h2>PURCHASE CONTRACT</h2>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="logo">
                                                          <img src="{{url('public/logo', $general_setting->site_logo)}}" alt="Side Image">
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-12" style="height:22px;">
                                                    <div class="company-address">
                                                        <P class="left">CONTRACT NO : {{ $lim_invoice_data->invoice_no }}</P>
                                                        <P class="right">DATE : {{ date('d F, Y', strtotime($lim_invoice_data->created_at)) }}</P>
                                                    </div>
                                                </div>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="page">
                        <table width="100%">
                            <thead>
                                <tr>
                                  <td>
                                    <!--place holder for the fixed-position header-->
                                    <div class="page-header-space"></div>
                                  </td>
                                </tr>
                              </thead>

                            <tbody>
                              <tr>
                                <td>
                                    <div class="row" style="margin-top:30px;">
                                        <div class="col-md-6">
                                            <div class="vendor">
                                                <h2>TO</h2>
                                                <div class="vendor">
                                                    <h4>{{ $lim_invoice_data->invoiceTo->name }}</h4>
                                                    <p>{{ $lim_invoice_data->invoiceTo->address }}, {{ $lim_invoice_data->invoiceTo->city }}, {{ $lim_invoice_data->invoiceTo->country }}  </p>
                                                    <p>Tel: {{ $lim_invoice_data->invoiceTo->phone }}, {{ $lim_invoice_data->invoiceTo->mobile }} </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                        </div>
                                     </div>


                                     <div class="row" style="margin-top:20px;margin-bottom:20px;">
                                        <div class="col-md-12">
                                            <div class="vendor">
                                                <h2 style="font-size: 12px;text-transform: uppercase;font-weight: bold;">ATTN : {{$lim_invoice_data->customer->name}}</h2>
                                                <div class="description">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>PO</th>
                                                                <th>STYLE</th>
                                                                <th>ITEM DESCRIPTION</th>
                                                                <th>COLOR</th>
                                                                <th>QUANTITY</th>
                                                                <th>UNIT PRICE</th>
                                                                <th>TOTAL AMOUNT</th>
                                                                <TH>DELIVERY</TH>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $merchandies = unserialize($lim_invoice_data->merchandies);
                                                            @endphp
                                                        @foreach($merchandies as $key=>$item)
                                                            <tr>
                                                                <td>{{$item['po']}}</td>
                                                                <td>{{$item['style']}}</td>
                                                                <td>{{$item['item_description']}}</td>
                                                                <td>{{$item['color']}}</td>
                                                                <td>{{$item['quantity']}} pcs</td>
                                                                <td>$ {{ number_format((float)$item['unit_price'], 2, '.', '') }}</td>
                                                                <td>$ {{ number_format((float)$item['total_value'], 2, '.', '') }}</td>
                                                                <td>{{date('d-m-Y',strtotime($lim_invoice_data->delivery_date))}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>TOTAL</th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th>{{$lim_invoice_data->total_qty}} pcs</th>
                                                                <th></th>
                                                                <th>$ {{ number_format((float)$lim_invoice_data->total_amount, 2, '.', '') }}</th>
                                                                <th></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top:30px;">

                                            <div class="vendor">
                                                <h2 style="text-decoration: underline;">TERMS AND CONDITIONS</h2>
                                            </div>

                                            <table width="100%" class="amount_table">
                                                <tr>
                                                    <td width="20%"><b>Order Value</b></td>
                                                    <td width="3%"><b>:</b></td>
                                                    <th width="77%"><b>$ {{ number_format((float)$lim_invoice_data->total_amount, 2, '.', '') }}</b></th>
                                                </tr>
                                                <tr>
                                                    <td width="20%"><b>Payment Terms</b></td>
                                                    <td width="3%"><b>:</b></td>
                                                    <th width="77%">{{ $lim_invoice_data->payment_terms }}</th>
                                                </tr>
                                                <tr>
                                                    <td width="20%">LC Terms</td>
                                                    <td width="3%">:</td>
                                                    <th width="77%">{{ $lim_invoice_data->lc_terms }}</th>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Last date of shipment</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ date('d F, Y', strtotime($lim_invoice_data->shipment_date)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">last date of expiry</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ date('d F, Y', strtotime($lim_invoice_data->expire_date)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">quantity</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">as above ({{ $lim_invoice_data->acceptable_amount }}% more or less is acceptable in correct prepack ratio per color)</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">amount</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">as above ({{ $lim_invoice_data->acceptable_amount }}% more or less is acceptable)</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Port of Loading</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ $lim_invoice_data->port_of_loading }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Port of Destination</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ $lim_invoice_data->port_of_destination }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Mode of Shipment</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ $lim_invoice_data->mode_of_shipment }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Transshipment</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ $lim_invoice_data->transshipment }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Partial Shipment</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ $lim_invoice_data->partial_shipment }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Terms of Sales</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">{{ $lim_invoice_data->sale_terms }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Beneficiary Name & Address</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">
                                                        <h2 class="title">WINKING FASHION</h2>
                                                        <p>HOUSE # 128, ROAD # 01, BARIDHARA DOHS </p>
                                                        <p>DHAKA-1206, BBANGLADESH </p>
                                                        <p>TEL: +88 02 841 9355 </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Beneficiary bANK & Address</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">
                                                        {!! $lim_invoice_data->applicant_bank !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">inspection certificate</td>
                                                    <td width="3%">:</td>
                                                    <td width="77%">inspection certificate will be issued & purportedly signed by <span><b>SAMAR KANTI DHAR</b></span> of winking fashion or consignee.</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                           <div class="signature">
                                               <P style="text-align:center;">ON BEHALF OF</P>
                                               <h2 style="text-align:center;">WINKING FASHION</h2>
                                               <h4>AUTHORIZED SIGNATURE</h4>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                              </tr>
                            </tbody>

                            <tfoot>
                              <tr>
                                <td>
                                  <div class="page-footer-space"></div>
                                </td>
                              </tr>
                            </tfoot>
                        </table>
                    </div><!--end page-->
                    </div>
                </div>
            </div>
        </div>


        <div class="page-footer">
            <div class="row" style="margin-top:10px;">
                <div class="col-md-6" style="padding:0px;">
                    <div class="footer-left">
                        <h2>WINKING FASHION</h2>
                        <h4>House 128, Road 01, Baridhara DOHS, Dhaka-1206, Bangladesh</h4>
                    </div>
                </div>
                <div class="col-md-6" style="padding:0px;">
                    <div class="footer-right">
                        <h2>Tel : 88-02-84109355</h2>
                        <h4>Email : info@winkingfashion.com</h4>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
</div>
<script type="text/javascript">
    function auto_print() {
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
