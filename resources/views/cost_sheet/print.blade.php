<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('public/logo', $general_setting->site_logo)}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Cost Sheet-{{$lims_cost_data->style_no}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    @php
         $fabric_count = $lims_fabrics_all->count();
         $details_count = $lims_details_all->count();
         $total = $fabric_count + $details_count;
    @endphp
    <?php
       if($total <= 18){
           $size = '12px';
           $thpadding = '.10rem';
           $messageSize = '14px';
       }elseif($total > 18){
           $size = '10px';
           $thpadding = '.08rem';
           $messageSize = '14px';
       }
    ?>
    <style type="text/css">
        * {
            font-size: <?= $size; ?>;
            line-height: 24px;
            font-family: Tahoma;
            text-transform: capitalize;
        }
        .logo img{
           width: 40%;
           float: left;
        }
        .page{
            background-image:url({{url('public/logo/back.PNG')}});
            background-repeat:no-repeat;background-position: center center;
        }
        .custom_table th, .custom_table td{
            border: 1px solid #dee2e6;
            padding: <?= $thpadding; ?>;
        }
        /*.table td, .table th{*/
        /*    padding: .10rem !important;*/
        /*}*/
        .company-info h2{
            font-weight: bold;
            font-family: initial;
            text-transform: uppercase;
            padding-bottom: 0px;
            margin-bottom: 0px;
        }
        .company-info h4{
            font-weight: bold;
            font-size:16px;
        }
        .vendor h2, .ship h2{
            margin-top: 20px;
            font-weight: bold;
            font-family: Tahoma;
            font-size:<?= $size; ?>;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .company-info p, .vendor p, .ship p{
            margin: 0px;
            padding: 0px;
            font-size: <?= $size; ?>;
            text-transform: uppercase;
        }
        
        .amount_table p{
            margin: 0px;
        }
        .amount_table th,td{
            font-family: Tahoma;
            font-size:<?= $size; ?>;
        }
        .address_table td{
            font-weight: bold;
        }
        
        .title{
            font-weight: bold;
            font-family: Tahoma;
            font-size:<?= $size; ?>;
            text-transform: uppercase;
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
            font-family: Tahoma;
            text-align: center;
            border-radius: 5px;
    }
    .description{
        padding: 0px;
        font-size: <?= $size; ?>;
        text-align: justify;
        min-height: 100px;
        border: 1px solid #dee2e6;
        padding: 10px;
    }

        small{font-size:11px;}

        @media print {
            * {
                font-size:<?= $size; ?>;
                line-height: 20px;
            }
            .page{
                background-image:url({{url('public/logo/back.PNG')}});
                background-repeat:no-repeat;background-position: center center;
            }

            .hidden-print {
                display: none !important;
            }
            @page {
                /* margin: 100px 0px; */
                margin-top:100px;

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
                <div class="card" style="border:none;">
                    <div class="card-body">
                         <div class="row">
                            <div class="col-md-6">
                                <div class="logo">
                                    <img src="{{url('public/logo', $general_setting->site_logo)}}" alt="Side Image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="company-info">
                                    <h2 style="text-align:right;">QUOTATION BREAKDOWN</h2>
                                    <p style="text-align:right;">{{\Carbon\Carbon::now()->format('d F, Y')}}</p>
                                </div>
                            </div>
                         </div>
                         
                         <div class="page">
                         <div class="row">
                            <div class="col-md-6">
                                <table width="100%" class="address_table" style="margin-top:50px;">
                                    <tbody>
                                        <tr>
                                            <td width="30%">Season</td>
                                            <td width="3%">:</td>
                                            <th width="67%">{{$lims_cost_data->season}}</th>
                                        </tr>
                                        <tr>
                                            <td width="30%">Customer</td>
                                            <td width="3%">:</td>
                                            <td width="67%">{{$lims_cost_data->customer->name}}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Item Description</td>
                                            <td width="3%">:</td>
                                            <td width="67%">{{$lims_cost_data->item_description}}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Style No</td>
                                            <td width="3%">:</td>
                                            <td width="67%">{{$lims_cost_data->style_no}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table width="100%" class="address_table" style="margin-top:50px;">
                                    <tbody style="float:right;">
                                        <tr>
                                            <td width="20%">Size Scale</td>
                                            <td width="3%">:</td>
                                            <th width="77%">{{$lims_cost_data->size_scale}}</th>
                                        </tr>
                                        <tr>
                                            <td width="20%">Order Qty</td>
                                            <td width="3%">:</td>
                                            <td width="77%">{{$lims_cost_data->order_quantity}} pcs</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">Target Price</td>
                                            <td width="3%">:</td>
                                            <td width="77%">$ {{$lims_cost_data->target_price}}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">Brand/Label</td>
                                            <td width="3%">:</td>
                                            <td width="77%">{{$lims_cost_data->brand}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                         </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="vendor">
                                    <h2>FEBRICS DESCRIPTION</h2>
                                        <table class="custom_table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Febrics</th>
                                                    <th width="10%" style="text-align: center;">Item Code</th>
                                                    <th width="25%">Description</th>
                                                    <th width="10%" style="text-align: center;">Price(USD)</th>
                                                    <th width="15%" style="text-align: center;">Consumption</th>
                                                    <th width="10%" style="text-align: center;">Wastage(%)</th>
                                                    <th width="10%" style="text-align: center;">Total Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $price = 0; $consumption = 0; $wastage = 0;
                                                @endphp
                                                @foreach ($lims_fabrics_all as $key=>$febric)
                                                <tr>
                                                    <td style="text-align: left;">{{$febric->fabric}}</td>
                                                    <td style="text-align: center;">{{$febric->fabric_item_code}}</td>
                                                    <td style="text-align: left;">{{$febric->fabric_item_description}}</td>
                                                    <td style="text-align: center;">$ {{number_format((float)$febric->fabric_price, 2, '.', '')}}</td>
                                                    <td style="text-align: center;">{{number_format((float)$febric->fabric_consumption, 2, '.', '')}} {{$febric->fabric_consump_unit}}</td>
                                                    <td style="text-align: center;">{{number_format((float)$febric->fabric_wastage, 2, '.', '')}} %</td>
                                                    <td style="text-align: center;">$ {{number_format((float)$febric->fabric_total_price, 2, '.', '')}}</td>
                                                    @php
                                                        $price += $febric->fabric_price;
                                                        $consumption += $febric->fabric_consumption;
                                                        $wastage += $febric->fabric_wastage;
                                                    @endphp
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align: left;">Total</th>
                                                    <th style="text-align: center;"></th>
                                                    <th></th>
                                                    <th style="text-align: center;"></th>
                                                    <th style="text-align: center;"></th>
                                                    <th style="text-align: center;"></th>
                                                    <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->fabric_total_cost, 2, '.', '')}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                </div>

                                <div class="vendor">
                                    <h2>DESCRIPTION</h2>
                                    <table class="custom_table" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="20%">Trimming</th>
                                                <th width="10%" style="text-align: center;">Item Code</th>
                                                <th width="25%">Description</th>
                                                <th width="10%" style="text-align: center;">Price(USD)</th>
                                                <th width="15%" style="text-align: center;">Consumption</th>
                                                <th width="10%" style="text-align: center;">Wastage(%)</th>
                                                <th width="10%" style="text-align: center;">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $price = 0; $consumption = 0; $wastage = 0;
                                            @endphp
                                            @foreach ( $lims_details_all as $key=>$detail)
                                            <tr>
                                                <td style="text-align: left;">{{$detail->trimming}}</td>
                                                <td style="text-align: center;">{{$detail->trim_item_code}}</td>
                                                <td style="text-align: left;">{{$detail->trim_item_description}}</td>
                                                <td style="text-align: center;">$ {{number_format((float)$detail->trim_price, 2, '.', '')}}</td>
                                                <td style="text-align: center;">{{number_format((float)$detail->trim_consumption, 2, '.', '')}} {{$detail->trim_consump_unit}}</td>
                                                <td style="text-align: center;">{{number_format((float)$detail->trim_wastage, 2, '.', '')}} %</td>
                                                <td style="text-align: center;">$ {{number_format((float)$detail->trim_total_price, 2, '.', '')}}</td>
                                                @php
                                                    $price += $detail->trim_price;
                                                    $consumption += $detail->trim_consumption;
                                                    $wastage += $detail->trim_wastage;
                                                @endphp
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: left;">Total</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->trim_total_cost, 2, '.', '')}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="title"></h2>
                                <table class="custom_table" width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="20%">Making Cost</td>
                                            <td></td>
                                            <td width="10%" style="text-align: center;">$ {{number_format((float)$lims_cost_data->making_price, 2, '.', '')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Washing Cost</td>
                                            <td>{{$lims_cost_data->washing_description}}</td>
                                            <td style="text-align: center;">$ {{number_format((float)$lims_cost_data->washing_price, 2, '.', '')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Dry Process</td>
                                            <td>{{$lims_cost_data->dry_process_description}}</td>
                                            <td style="text-align: center;">$ {{ number_format((float)$lims_cost_data->dry_process_price, 2, '.', '')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Other Cost</td>
                                            <td></td>
                                            <td style="text-align: center;">$ {{ number_format((float)$lims_cost_data->other_price, 2, '.', '')}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6" style="margin-top: 20px;">
                                <h4 style="font-size: <?= $messageSize; ?>;font-weight: bold;font-family: serif;margin-top:100px;">NET COST W/O TF : ${{ number_format((float)$lims_cost_data->fob_total_price/12, 2, '.', '')}}/PC</h4>
                                <h4 style="font-size: <?= $messageSize; ?>;font-weight: bold;font-family: serif;">OFFERED FOB : ${{ number_format((float)$lims_cost_data->offered_fob, 2, '.', '')}}/PC</h4>
                            </div>
                            <div class="col-md-6" style="margin-top: 20px;">
                                <div class="vendor">
                                    <table class="" width="100%" style="width: 80%;float: right;border: 1px solid #cec7c7;">
                                        <tr>
                                            <th>CMPTW</th>
                                            <th>:</th>
                                            <th></th>
                                            <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->cmptw_total_price, 2, '.', '')}}</th>
                                        </tr>
                                        <tr>
                                            <th>NET FOB</th>
                                            <th>:</th>
                                            <th></th>
                                            <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->fob_total_price, 2, '.', '')}}</th>
                                        </tr>
                                        <tr>
                                            <th>TF</th>
                                            <th>:</th>
                                            <th>{{number_format((float)$lims_cost_data->tf_wastage, 2, '.', '')}} %</th>
                                            <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->tf_cost, 2, '.', '')}}</th>
                                        </tr>
                                        <tr>
                                            <th>CTL</th>
                                            <th>:</th>
                                            <th></th>
                                            <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->cil_price, 2, '.', '')}}</th>
                                        </tr>
                                        <tr>
                                            <th>TOTAL COST</th>
                                            <th>:</th>
                                            <th></th>
                                            <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->total_cost, 2, '.', '')}}</th>
                                        </tr>
                                        <tr>
                                            <th>COST PER PC</th>
                                            <th>:</th>
                                            <th></th>
                                            <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->cost_per_pc, 2, '.', '')}}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">

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

