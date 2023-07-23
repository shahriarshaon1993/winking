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
    <title>Purchase Order-{{$order->po_number}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 10px;
            line-height: 18px;
            font-family: Tahoma;
            text-transform: uppercase;
        }
        .page{
            background-image:url({{url('public/logo/back.PNG')}});
            background-repeat:no-repeat;background-position: center center;
        }
        .custom_table th, .custom_table td{
            border: 1px solid #dee2e6;
            padding: .30rem;
        }
        .company-info h2{
            font-weight: bold;
            font-family: Tahoma;
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
            font-family: Tahoma;
            font-size:10px;
            text-transform: uppercase;
            padding-bottom:0px;
            margin-bottom: 0px;
        }
        .company-info p, .vendor p, .ship p{
            margin: 0px;
            padding: 0px;
            font-size: 10px;
            text-transform: uppercase;
        }
        .logo img{
            width: 20%;
            float: left;
        }
        .amount_table p{
             margin: 0px;
        }
        .amount_table th,td{
            text-transform: uppercase;
            font-family: initial;
            font-size:10px;
        }
        .title{
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            padding: 10px 0px;
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
            font-family: Tahoma;
            text-align: center;
            border-radius: 5px;
        }
        .description{
            padding: 0px;
            font-size: 10px !important;
            text-align: justify;
            min-height: 80px;
            border: 1px solid #dee2e6;
            padding: 5px;
        }
        .description ul li {
            font-size: 8px !important;
        }
        .packing{
            padding: 0px;
            text-align: justify;
            min-height: 60px;
            border: 1px solid #dee2e6;
            padding: 5px;
        }
        .description p{
                font-size:8px;
         }
        .packing ul li{
                font-size:8px;
        }
        .packing p{
                font-size:8px;
        }

        small{font-size:10px;}

        @media print {
            * {
                font-size:10px;
                line-height: 18px;
                font-family: Tahoma;
             }
             .description p{
                font-size:8px;
             }
             .packing p{
                font-size:8px;
             }
             .packing ul li{
                font-size:8px;
            }
            .description ul li{
                font-size:8px;
            }
            .logo img{
                width: 15%;
                margin-bottom: -30px;
            }

            .hidden-print {
                display: none !important;
            }
            @page {
                /* margin: 100px 0px; */
                size: landscape;


            } body { -webkit-print-color-adjust: exact !important; }
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
                <div class="card page" style="border:none;">
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
                                    <p style="text-align:right;">{{date('d-m-Y',strtotime($order->order_date))}}</p>
                                </div>
                            </div>
                         </div>

                         <div class="row">
                            <div class="col-md-12">
                                <table class="custom_table" width="100%" style="margin-bottom: 2px;">
                                    <thead>
                                        <th width="20%">
                                            <div class="vendor">
                                                <h2>VENDOR / SHIPPER</h2>
                                            </div>
                                        </th>
                                        <th width="20%">
                                            <div class="vendor">
                                                <h2>SHIP TO</h2>
                                            </div>
                                        </th>
                                        <th width="20%">
                                            <div class="vendor">
                                                <h2>INVOICE TO</h2>
                                            </div>
                                        </th>
                                        <th width="20%">
                                            <div class="vendor">
                                                <h2>CUSTOMER</h2>
                                            </div>
                                        </th>
                                    </thead>
                                    <tbody>
                                        <td>
                                            <div class="vendor">
                                                <p><b>{{ $order->vendorInfo->name }}</b></p>
                                                <p>{{ $order->vendorInfo->address }}, {{ $order->vendorInfo->city }}-{{ $order->vendorInfo->state }}. {{ $order->vendorInfo->country }}  </p>
                                                <p>Tel:
                                                {{ $order->vendorInfo->phone }}
                                                    @if($order->vendorInfo->mobile !== null)
                                                          ,
                                                    @endif
                                                {{ $order->vendorInfo->mobile }} </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="vendor">
                                                <p><b>{{ $order->shipTo->name }}</b></p>
                                                <p>{{ $order->shipTo->address }}, {{ $order->shipTo->city }}, {{ $order->shipTo->state }}, {{ $order->shipTo->zip }}, {{ $order->shipTo->country }}  </p>
                                                <p>Tel:
                                                {{ $order->shipTo->phone }}
                                                    @if($order->shipTo->mobile !== null)
                                                          ,
                                                    @endif
                                                {{ $order->shipTo->mobile }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="vendor">
                                                <p><b>{{ $order->invoiceTo->name }}</b></p>
                                                <p>{{ $order->invoiceTo->address }}, {{ $order->invoiceTo->city }}-{{$order->invoiceTo->state}}, {{ $order->invoiceTo->country }}  </p>
                                                <p>Tel:
                                                    {{ $order->invoiceTo->phone }}
                                                        @if($order->invoiceTo->mobile !== null)
                                                          ,
                                                        @endif
                                                    {{ $order->invoiceTo->mobile }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="vendor">
                                                <p><b>{{ $order->customer->name }}</b></p>
                                                <p>{{ $order->customer->address }}, {{ $order->customer->city }}, {{ $order->customer->state }}, {{ $order->customer->postal_code }}, {{ $order->customer->country }}  </p>
                                                <p>Tel:

                                                      {{ $order->customer->phone_number }}
                                                </p>
                                            </div>
                                        </td>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <table class="custom_table details" width="100%" style="margin-bottom: 2px;">
                                    <thead>
                                        <tr>
                                            <th width="10%">PO Number</th>
                                            <th width="10%">X-country date</th>
                                            <th width="10%">ship via</th>
                                            <th width="10%">Terms</th>
                                            <th width="25%">Payment/Draft At</th>
                                            <th width="10%">Brand</th>
                                            <th width="12%">Season</th>
                                            <th width="13%">Last Revised</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                         <tr>
                                             <td>{{ $order->po_number }}</td>
                                             <td>{{ date('d-m-Y',strtotime($order->ship_exp_date)) }}</td>
                                             <td>{{ $order->ship_via }}</td>
                                             <td>{{ $order->ship_terms }}</td>
                                             <td>{{ $order->payment_terms }}</td>
                                             <td>{{ $order->brand }}</td>
                                             <td>{{ $order->season }}</td>
                                             <td>
                                                 @if($order->rivision_no != null)
                                                     {{ date('d-m-Y',strtotime($order->rivision_no)) }}
                                                 @endif
                                             </td>
                                         </tr>
                                     </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <table class="custom_table details" width="100%" style="margin-bottom: 2px;">
                                    <thead>
                                        <tr>
                                            <th width="10%">Style</th>
                                            <th width="10%">CA/RN</th>
                                            <th width="45%">ITEM Description</th>
                                            <th width="10%">Fabric Ref</th>
                                            <th width="25%">Fabrication</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                         <tr>
                                             <td>{{ $order->style_no }}</td>
                                             <td>{{ $order->ca }}</td>
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
                                <table class="custom_table details table mt-1"  style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th width="">Color</th>
                                        <th width="">Code</th>
                                        <th width="">PRE PACK</th>
                                        @if($lim_sizes->size1)
                                            <th style="text-align:center;">{{$lim_sizes->size1 }}</th>
                                        @endif
                                        @if($lim_sizes->size2)
                                            <th style="text-align:center;">{{$lim_sizes->size2 }}</th>
                                        @endif
                                        @if($lim_sizes->size3)
                                            <th style="text-align:center;">{{$lim_sizes->size3 }}</th>
                                        @endif
                                        @if($lim_sizes->size4)
                                            <th style="text-align:center;">{{$lim_sizes->size4 }}</th>
                                        @endif
                                        @if($lim_sizes->size5)
                                            <th style="text-align:center;">{{$lim_sizes->size5 }}</th>
                                        @endif
                                        @if($lim_sizes->size6)
                                            <th style="text-align:center;">{{$lim_sizes->size6 }}</th>
                                        @endif
                                        @if($lim_sizes->size7)
                                            <th style="text-align:center;">{{$lim_sizes->size7 }}</th>
                                        @endif
                                        @if($lim_sizes->size8)
                                            <th style="text-align:center;">{{$lim_sizes->size8 }}</th>
                                        @endif
                                        @if($lim_sizes->size9)
                                            <th style="text-align:center;">{{$lim_sizes->size9 }}</th>
                                        @endif
                                        @if($lim_sizes->size10)
                                            <th style="text-align:center;">{{$lim_sizes->size10 }}</th>
                                        @endif
                                        @if($lim_sizes->size11)
                                            <th style="text-align:center;">{{$lim_sizes->size11 }}</th>
                                        @endif
                                        @if($lim_sizes->size12)
                                            <th style="text-align:center;">{{$lim_sizes->size12 }}</th>
                                        @endif
                                        @if($lim_sizes->size13)
                                            <th style="text-align:center;">{{$lim_sizes->size13 }}</th>
                                        @endif
                                        <th style="text-align:center;" width="">Total Units</th>
                                        <th style="text-align:center;" width="">Unit Price</th>
                                        <th style="text-align:center;" width="">Total Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count=0)
                                    @foreach ($lim_details as $key=>$detail)
                                        {{-- {{ dd($detail) }} --}}
                                        {{-- {{ dd(sizeOf($detail->toArray())) }} --}}
                                        <tr>
                                            <td>{{ $detail->color }}</td>
                                            <td>{{ $detail->color_code }}</td>
                                            <td>
                                                @if($detail->prepack1)
                                                    {{ $detail->prepack1 }}
                                                    @if($detail->prepack2),@endif
                                                @endif
                                                @if($detail->prepack2)
                                                    {{ $detail->prepack2 }}
                                                    @if($detail->prepack3)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack3)
                                                    {{ $detail->prepack3 }}
                                                    @if($detail->prepack4)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack4)
                                                    {{ $detail->prepack4 }}
                                                    @if($detail->prepack5)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack5)
                                                    {{ $detail->prepack5 }}
                                                    @if($detail->prepack6)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack6)
                                                    {{ $detail->prepack6 }}
                                                    @if($detail->prepack7)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack7)
                                                    {{ $detail->prepack7 }}
                                                @endif
                                                @if($detail->prepack8)
                                                    {{ $detail->prepack8 }}
                                                    @if($detail->prepack9)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack9)
                                                    {{ $detail->prepack9 }}
                                                    @if($detail->prepack10)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack10)
                                                    {{ $detail->prepack10 }}
                                                    @if($detail->prepack11)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack11)
                                                    {{ $detail->prepack11 }}
                                                    @if($detail->prepack12)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack12)
                                                    {{ $detail->prepack12}}
                                                    @if($detail->prepack13)
                                                        ,
                                                    @endif
                                                @endif
                                                @if($detail->prepack13)
                                                    {{ $detail->prepack13 }}
                                                @endif

                                            </td>
                                            @if($detail->quantity1)
                                                <td style="text-align:center;">{{ $detail->quantity1 }}</td>
                                            @endif
                                            @if($detail->quantity2)
                                                <td style="text-align:center;">{{ $detail->quantity2 }}</td>
                                            @endif
                                            @if($detail->quantity3)
                                                <td style="text-align:center;">{{ $detail->quantity3 }}</td>
                                            @endif
                                            @if($detail->quantity4)
                                                <td style="text-align:center;">{{ $detail->quantity4 }}</td>
                                            @endif
                                            @if($detail->quantity5)
                                                <td style="text-align:center;">{{ $detail->quantity5 }}</td>
                                            @endif
                                            @if($detail->quantity6)
                                                <td style="text-align:center;">{{ $detail->quantity6 }}</td>
                                            @endif
                                            @if($detail->quantity7)
                                                <td style="text-align:center;">{{ $detail->quantity7 }}</td>
                                            @endif
                                            @if($detail->quantity8)
                                                <td style="text-align:center;">{{ $detail->quantity8 }}</td>
                                            @endif
                                            @if($detail->quantity9)
                                                <td style="text-align:center;">{{ $detail->quantity9 }}</td>
                                            @endif
                                            @if($detail->quantity10)
                                                <td style="text-align:center;">{{ $detail->quantity10 }}</td>
                                            @endif
                                            @if($detail->quantity11)
                                                <td style="text-align:center;">{{ $detail->quantity11 }}</td>
                                            @endif
                                            @if($detail->quantity12)
                                                <td style="text-align:center;">{{ $detail->quantity12 }}</td>
                                            @endif
                                            @if($detail->quantity13)
                                                <td style="text-align:center;">{{ $detail->quantity13 }}</td>
                                            @endif
                                            <td style="text-align:center;">{{ $detail->color_wise_quantity }}</td>
                                            <td style="text-align:center;">$ {{ number_format((float)$detail->color_unit_price, 2, '.', '') }}</td>
                                            <td style="text-align:center;">$ {{ number_format((float)$detail->sub_total, 2, '.', '') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="{{ $sizeCount+3 }}" style="text-align: right;">Total</th>
                                        <th style="text-align:center;">{{$order->total_quantity}}</th>
                                        <th></th>
                                        <th style="text-align:center;">${{ number_format((float)$order->total_amount, 2, '.', '') }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <div class="vendor">
                                    <h2 style="margin-top:10px;">PACKING INSTRUCTION</h2>
                                    <div class="packing">
                                        {!! $order->packing_instruction !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="vendor">
                                    <h2>SPECIAL INSTRUCTION</h2>
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

