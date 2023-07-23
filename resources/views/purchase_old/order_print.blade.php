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
    <title>Purchase Order</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 12px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: uppercase;
        }
        .company-info h2{
            margin-top: 10px;
            font-weight: bold;
            font-family: initial;
            text-align: right;
        }
        .table td, .table th{
            padding: .30rem;
        }
        .company-info p{
            font-weight: bold;
        }
        .vendor h2, .ship h2{
            font-weight: bold;
            font-family: initial;
            font-size:14px;
            text-transform: uppercase;
            padding-bottom:0px;
            margin-bottom: 0px;
        }
        .company-info p, .vendor p, .ship p{
            margin: 0px;
            padding: 0px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .logo img{
            width: 20%;
            float: left;
            margin-top: 20px;
        }
        .amount_table p{
             margin: 0px;
        }
        .amount_table th,td{
            text-transform: uppercase;
            font-family: initial;
            font-size:12px;
        }
        .title{
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            padding: 10px 0px;
        }
        .description{
             text-align: center;
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

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        .purchase{
            background-color: #dad7d7;
            padding: 5px;
            font-weight: bold;
            font-family: initial;
            text-align: center;
            border-radius: 5px;
        }
        .description{
            padding: 0px;
            font-size: 12px;
            text-align: justify;
            min-height: 80px;
            border: 1px solid #dee2e6;
            padding: 5px;
            text-transform: uppercase;
        }
        .packing{
            padding: 0px;
            font-size: 12px;
            text-align: justify;
            min-height: 60px;
            border: 1px solid #dee2e6;
            padding: 5px;
        }

        small{font-size:11px;}

        @media print {
            * {
                font-size:12px;
                line-height: 20px;
            }

            .hidden-print {
                display: none !important;
            }
            @page {
                /* margin: 100px 0px; */
                size: landscape;


            } body { margin-top: 0cm ; margin-bottom:1.6cm; }
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
                    <div class="card-body" style="padding:0px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="logo">
                                    <img src="{{url('public/logo', $general_setting->site_logo)}}" alt="Side Image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="company-info">
                                    <h2>PURCHASE ORDER</h2>
                                </div>
                            </div>
                         </div>

                         <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="margin-bottom: 0px;">
                                    <thead>
                                        <th>
                                            <div class="vendor">
                                                <h2>VENDOR / SHIPPER</h2>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="vendor">
                                                <h2>SHIP TO</h2>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="vendor">
                                                <h2>INVOICE TO</h2>
                                            </div>
                                        </th>
                                    </thead>
                                    <tbody>
                                        <td>
                                            <div class="vendor">
                                                <p>{{ $order->vendorInfo->name }}</p>
                                                <p>{{ $order->vendorInfo->address }}, {{ $order->vendorInfo->city }}, {{ $order->vendorInfo->country }}  </p>
                                                <p>Tel: {{ $order->vendorInfo->phone }}, {{ $order->vendorInfo->mobile }} </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="vendor">
                                                <p>HOUSE 128, ROAD 01, BARIDHARA DOHS, </p>
                                                <p>DHAKA-1206, BBANGLADESH  </p>
                                                <p>TEL: +88 02 841 9355 </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="vendor">
                                                <p>{{ $order->invoiceTo->name }}</p>
                                                <p>{{ $order->invoiceTo->address }}, {{ $order->invoiceTo->city }}, {{ $order->invoiceTo->country }}  </p>
                                                <p>Tel: {{ $order->invoiceTo->phone }}, {{ $order->invoiceTo->mobile }} </p>
                                            </div>
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-hover table-stripped table-bordered details" style="margin-bottom: 0px;">
                                    <thead>
                                        <tr>
                                            <th>P.O. Number</th>
                                            <th>X-country date</th>
                                            <th>ship via</th>
                                            <th>Terms</th>
                                            <th>Brand</th>
                                            <th>Season</th>
                                            <th>Last Revised</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                         <tr>
                                             <td>{{ $order->po_number }}</td>
                                             <td></td>
                                             <td>{{ $order->ship_via }}</td>
                                             <td>{{ $order->payment_terms }}</td>
                                             <td>{{ $order->brand }}</td>
                                             <td>{{ $order->season }}</td>
                                             <td>{{ date('d-m-Y',strtotime($order->rivision_no)) }}</td>
                                         </tr>
                                     </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-hover table-stripped table-bordered details" style="margin-bottom: 0px;">
                                    <thead>
                                        <tr>
                                            <th>Style</th>
                                            <th>Description</th>
                                            <th>Fabric Ref</th>
                                            <th>Fabrication</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                         <tr>
                                             <td>{{ $order->style_no }}</td>
                                             <td>{{ $order->description }}</td>
                                             <td>{{ $order->febric_ref }}</td>
                                             <td>{{ $order->fabrication }}</td>
                                         </tr>
                                     </tbody>
                                </table>
                            </div>
                         </div>

                    <div class="row">
                         <div class="col-md-12">
                            <table class="table table-hover table-stripped table-bordered details">
                                <thead>
                                    <tr>
                                        <th>Color</th>
                                        <th>Code</th>
                                        <th>PPK</th>
                                        <th>{{$lim_sizes->size1 }}</th>
                                        <th>{{$lim_sizes->size2 }}</th>
                                        <th>{{$lim_sizes->size3 }}</th>
                                        <th>{{$lim_sizes->size4 }}</th>
                                        <th>{{$lim_sizes->size5 }}</th>
                                        <th>{{$lim_sizes->size6 }}</th>
                                        <th>{{$lim_sizes->size7 }}</th>
                                        <th>{{$lim_sizes->size8 }}</th>
                                        <th>{{$lim_sizes->size9 }}</th>
                                        <th>Quantity (pcs)</th>
                                        <th>Unit Price($)</th>
                                        <th>Total Price($)</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($lim_details as $key=>$detail)
                                            <tr>
                                                <td>{{ $detail->color }}</td>
                                                <td>{{ $detail->color_code }}</td>
                                                <td>
                                                    {{ $detail->prepack1 }},{{ $detail->prepack2 }},{{ $detail->prepack3 }},{{ $detail->prepack4 }},{{ $detail->prepack5 }},{{ $detail->prepack6 }},{{ $detail->prepack7 }},{{ $detail->prepack8 }},{{ $detail->prepack9 }}
                                                </td>
                                                <td>{{ $detail->quantity1 }}</td>
                                                <td>{{ $detail->quantity2 }}</td>
                                                <td>{{ $detail->quantity3 }}</td>
                                                <td>{{ $detail->quantity4 }}</td>
                                                <td>{{ $detail->quantity5 }}</td>
                                                <td>{{ $detail->quantity6 }}</td>
                                                <td>{{ $detail->quantity7 }}</td>
                                                <td>{{ $detail->quantity8 }}</td>
                                                <td>{{ $detail->quantity9 }}</td>
                                                <td>{{ $detail->color_wise_quantity }}</td>
                                                <td>{{ $detail->color_unit_price }}</td>
                                                <td>{{ $detail->sub_total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="12">Total</th>
                                            <th>{{$order->total_quantity}} pcs</th>
                                            <th></th>
                                            <th>$ {{$order->total_amount}}</th>
                                        </tr>
                                    </tfoot>
                            </table>
                         </div>

                        <div class="col-md-12">
                            <div class="vendor">
                                <h2>PACKING INSTRUCTION</h2>
                                <div class="packing">
                                    {!! $order->packing_instruction !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top:10px;">
                            <div class="vendor">
                                <h2>DETAILED INSTRUCTION NOTES</h2>
                                <div class="description">
                                        {!! $order->instruction_notes !!}
                                </div>
                            </div>
                        </div>
                        </div>
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

