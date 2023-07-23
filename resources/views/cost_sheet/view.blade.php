@extends('layout.main') @section('content')

@if($errors->has('name'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<style>
    *{
        font-family: Tahoma;
    }
    .company-info{
       text-align: center;
    }
    .table td, .table th{
        padding: .30rem !important;
    }
    .company-info h2{
        margin-top: 10px;
        font-weight: bold;
        font-family: Tahoma;
        text-align: right;
    }
    .logo img{
        width: 30%;
       float: left;
    }
    .company-info h4{
        font-weight: bold;
        text-transform: uppercase;
        font-size:14px;
        padding-bottom: 0px;
        margin-bottom: 0px;
    }
    .vendor h2, .ship h2{
        margin-top: 20px;
        font-weight: bold;
        font-size:14px;
        text-transform: uppercase;
    }
    .company-info p, .vendor p, .ship p{
        margin: 0px;
        padding: 0px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .amount_table p{
       margin: 0px;
    }
    .amount_table th,td{

        font-size:14px;
        padding: 4px 0px;

    }
    .address_table td{
        font-weight: bold;
    }
    .title{
        font-weight: bold;
        font-size:14px;
        text-transform: uppercase;
    }
    .description{
        text-align: center;
    }
    .signature{
            min-height: 80px;
            margin-top: 120px;
    }
    .signature h4{
        font-size: 14px;
        font-weight: bold;
        margin-top: 100px;
        padding: 5px;
        margin-bottom: 0px;
        text-decoration: overline;
    }

</style>
<section>
    <div class="container-fluid" id="print_area">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="logo">
                                    <img src="{{url('public/logo', $general_setting->site_logo)}}" alt="Side Image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="company-info">
                                    <h2>QUOTATION BREAKDOWN</h2>
                                    <p style="text-align:right;">
                                     {{ isset($lims_cost_data->created_at) ? $lims_cost_data->created_at->format('d F, Y') : '' }}
                                    </p>
                                    
                                </div>
                            </div>
                         </div>

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
                                    <tbody>
                                        <tr>
                                            <td width="30%">Size Scale</td>
                                            <td width="3%">:</td>
                                            <th width="67%">{{$lims_cost_data->size_scale}}</th>
                                        </tr>
                                        <tr>
                                            <td width="30%">Order Qty</td>
                                            <td width="3%">:</td>
                                            <td width="67%">{{$lims_cost_data->order_quantity}} pcs</td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Target Price</td>
                                            <td width="3%">:</td>
                                            <td width="67%">$ {{$lims_cost_data->target_price}}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Brand/Label</td>
                                            <td width="3%">:</td>
                                            <td width="67%">{{$lims_cost_data->brand}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                         </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="vendor">
                                    <h2>FEBRICS DESCRIPTION</h2>
                                    <div class="description">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%" style="text-align: left;">Febrics</th>
                                                    <th width="10%" style="text-align: center;">Item Code</th>
                                                    <th width="25%" style="text-align: left;">Description</th>
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
                                                    <td>{{$febric->fabric_item_code}}</td>
                                                    <td style="text-align: left;">{{$febric->fabric_item_description}}</td>
                                                    <td>$ {{number_format((float)$febric->fabric_price, 2, '.', '')}}</td>
                                                    <td>{{number_format((float)$febric->fabric_consumption, 2, '.', '')}} {{$febric->fabric_consump_unit}}</td>
                                                    <td>{{number_format((float)$febric->fabric_wastage, 2, '.', '')}} %</td>
                                                    <td>$ {{number_format((float)$febric->fabric_total_price, 2, '.', '')}}</td>
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
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->fabric_total_cost, 2, '.', '')}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="vendor">
                                    <h2>DESCRIPTION</h2>
                                    <div class="description">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20%" style="text-align: left;">Trimming</th>
                                                    <th width="10%" style="text-align: center;">Item Code</th>
                                                    <th width="25%" style="text-align: left;">Description</th>
                                                    <th width="10%" style="text-align: center;">Price(USD)</th>
                                                    <th width="15%" style="text-align: center;">Consumption in yds</th>
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
                                                    <td>{{$detail->trim_item_code}}</td>
                                                    <td style="text-align: left;">{{$detail->trim_item_description}}</td>
                                                    <td>$ {{number_format((float)$detail->trim_price, 2, '.', '')}}</td>
                                                    <td>{{number_format((float)$detail->trim_consumption, 2, '.', '')}} {{$detail->trim_consump_unit}}</td>
                                                    <td>{{number_format((float)$detail->trim_wastage, 2, '.', '')}} %</td>
                                                    <td>$ {{number_format((float)$detail->trim_total_price, 2, '.', '')}}</td>
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
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="title"></h2>
                                <table class="table table-hover table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="20%">Making Cost</td>
                                            <td></td>
                                            <td width="10%" style="text-align: center;">$ {{number_format((float)$lims_cost_data->making_price, 2, '.', '')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Washing Cost</td>
                                            <td>{{$lims_cost_data->washing_description}}</td>
                                            <td width="10%" style="text-align: center;">$ {{number_format((float)$lims_cost_data->washing_price, 2, '.', '')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Dry Process</td>
                                            <td>{{$lims_cost_data->dry_process_description}}</td>
                                            <td width="10%" style="text-align: center;">$ {{ number_format((float)$lims_cost_data->dry_process_price, 2, '.', '')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Other Cost</td>
                                            <td></td>
                                            <td width="10%" style="text-align: center;">$ {{ number_format((float)$lims_cost_data->other_price, 2, '.', '')}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <h4 style="font-size: 14px;font-weight: bold;margin-top:140px;">NET COST W/O TF : ${{ number_format((float)$lims_cost_data->fob_total_price/12, 2, '.', '')}}/PC</h4>
                                <h4 style="font-size: 14px;font-weight: bold;">OFFERED FOB : ${{ number_format((float)$lims_cost_data->offered_fob, 2, '.', '')}}/PC</h4>
                            </div>
                            <div class="col-md-6"style="margin-top: 100px 0px;" >
                                <div class="vendor">
                                    <table class="table table-hover" style="width: 80%;float: right;border: 1px solid #cec7c7;">
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
                                            <th>COMMERCIAL COST</th>
                                            <th>:</th>
                                            <th> {{number_format((float)$lims_cost_data->commercial_cost, 2, '.', '')}} %</th>
                                            <th style="text-align: center;">$ {{number_format((float)$lims_cost_data->cc_amount, 2, '.', '')}}</th>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{url('cost_sheet/print',$lims_cost_data->id)}}" class="btn btn-success btn-md">Print Order</a>
            </div>
        </div>
    </div>

</section>


<script type="text/javascript">

    $("ul#order-summary").siblings('a').attr('aria-expanded','true');
    $("ul#order-summary").addClass("show");
    $("ul#order-summary #cost-sheet-list-menu").addClass("active");

    var category_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;


</script>
@endsection
