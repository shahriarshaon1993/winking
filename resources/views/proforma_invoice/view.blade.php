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
    .company-info h2{
        margin-bottom: 20px;
        font-weight: bold;
        font-family: initial;
        text-transform: uppercase;
    }
    .company-address{
        margin: 0px;
        padding: 0px;
        font-size: 12px;
        min-height:20px;
        text-transform: uppercase;
        background-color: #d7d8da;
        font-weight: bold;
    }
    .company-address p{

    }
    .revised{
        margin: 0px;
        padding: 0px;
        font-size: 12px;
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
    .vendor h2, .ship h2{
        margin-top: 20px;
        font-weight: bold;
        font-family: initial;
        font-size:12px;
        text-transform: uppercase;
    }
    .company-info p, .vendor p, .ship p{
        margin: 0px;
        padding: 0px;
        font-size: 12px;
        text-transform: uppercase;
        color:black !important;
    }
    .logo{
        float:right;
    }
    .logo img{
        width: 100%;
        float: right;
    }
    .amount_table p{
        margin: 0px;
    }
    .amount_table th,td{
        text-transform: uppercase;
        font-family: initial;
        font-size:12px;
        padding: 4px 0px;
    }
    .title{

        margin-top: 30px;
        font-size: 13px;
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
        font-size: 12px;
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
                    <div class="card-body">
                         <div class="row">
                            <div class="col-md-6">
                                <div class="company-info">
                                    <h2>PROFORMA INVOICE</h2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="logo">
                                      <img src="{{url('public/logo', $general_setting->site_logo)}}" alt="Side Image">
                                </div>
                            </div>
                         </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="company-address">
                                    <P class="left" style="margin-bottom: 3px;">INVOICE NO : {{ $lim_invoice_data->invoice_no }}</P>
                                    <P class="right">DATE : {{ date('d F, Y', strtotime($lim_invoice_data->created_at)) }}</P>
                                </div>
                            </div>
                         </div>

                         <div class="row" style="margin-top:30px;">
                            <div class="col-md-6">
                                <div class="vendor">
                                    <h2>To</h2>
                                    <div class="vendor">
                                        <h2>{{ $lim_invoice_data->invoiceTo->name }}</h2>
                                        <p>{{ $lim_invoice_data->invoiceTo->address }}, {{ $lim_invoice_data->invoiceTo->city }}, {{ $lim_invoice_data->invoiceTo->country }}  </p>
                                        <p>Tel: {{ $lim_invoice_data->invoiceTo->phone }}, {{ $lim_invoice_data->invoiceTo->mobile }} </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                            </div>
                         </div>

                         <div class="row">
                            <div class="col-md-12">
                                <div class="vendor">
                                    <h2 style="text-decoration: underline;">DESCRIPTION OF THE MERCHANDISES :</h2>
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
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="vendor">
                                    <h2 style="text-decoration: underline;">TERMS AND CONDITIONS :</h2>
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

                         <div class="row" style="margin-top:30px;">
                            <div class="col-md-6">
                                <div class="signature">
                                    <h4>AUTHORIZED SIGNATURE</h4>
                                 </div>
                            </div>
                            <div class="col-md-6">
                               <div class="signature">
                                   <h4 style="text-align: right;">BENEFICIARY SIGNATURE</h4>
                                </div>
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
                <a href="{{ url('proforma_invoice/print',$lim_invoice_data->id) }}" class="btn btn-success btn-md">Print Invoice</a>
            </div>
        </div>
    </div>

</section>




<script type="text/javascript">

    $("ul#order-summary").siblings('a').attr('aria-expanded','true');
    $("ul#order-summary").addClass("show");
    $("ul#order-summary #purchase-contract-list").addClass("active");

    var category_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;


</script>
@endsection
