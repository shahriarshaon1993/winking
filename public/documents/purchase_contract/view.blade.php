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
        font-family: 'Ubuntu', sans-serif;
        text-transform: uppercase;
    }
    .logo{
        float:right;
        margin-right:50px;
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
        text-align: center;
        margin-top: 30px;
        font-size: 12px;
        padding: 10px 0px;
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
                    <div class="card-header d-flex align-items-center">
                    </div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col-md-6">
                                <div class="company-info">
                                    <h2>PURCHASE CONTRACT</h2>
                                    <P>CONTRACT NO : {{ $lims_contract_data->contract_no }}</P>
                                    <P>DATE : {{\Carbon\Carbon::now()->format('d F, Y')}}</P>
                                    <P>REVISED DATE : {{ date('d F, Y', strtotime($lims_contract_data->revised_date)) }}</P>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="logo">
                                      <img src="{{url('public/logo', $general_setting->site_logo)}}" alt="Side Image" style="width:120%;">
                                </div>
                            </div>
                         </div>

                         <div class="row" style="margin-top:30px;">
                            <div class="col-md-6">
                                <div class="vendor">
                                    <h2 style="text-decoration:underline;">APPLICAT (1ST BENEFICIARY) NAME & ADDRESS</h2>
                                    <div class="">
                                        <h2>WINKING FASHION</h2>
                                        <p>HOUSE # 128, ROAD # 01, BARIDHARA DOHS </p>
                                        <p>DHAKA-1206, BBANGLADESH  </p>
                                        <p>TEL: +88 02 841 9355 </p>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="ship">
                                    <h2 style="text-decoration:underline;">VENDOR (2ND BENEFICIARY) NAME & ADDRESS</h2>
                                    <div class="vendor">
                                        <h2>{{ $lims_contract_data->vendor->name }}</h2>
                                        <p>{{ $lims_contract_data->vendor->address }}, {{ $lims_contract_data->vendor->city }}, {{ $lims_contract_data->vendor->country }}  </p>
                                        <p>Tel: {{ $lims_contract_data->vendor->phone }}, {{ $lims_contract_data->vendor->mobile }} </p>
                                        <p>Email: {{ $lims_contract_data->vendor->email }}</p>
                                    </div>
                                </div>
                            </div>
                         </div>

                         <div class="row" style="margin-top:30px;">
                            <div class="col-md-6">
                                <div class="vendor">
                                    <h2 style="text-decoration:underline;">APPLICAT BANK NAME & ADDRESS</h2>
                                    <div class="">
                                        <P>{!! $lims_contract_data->applicant_bank !!}</P>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="ship">
                                    <h2 style="text-decoration:underline;">VENDOR BANK NAME & ADDRESS</h2>
                                    <div class="vendor">
                                        <P>{!! $lims_contract_data->applicant_bank !!}</P>
                                    </div>
                                </div>
                            </div>
                         </div>

                         <div class="row" style="margin-top:30px;">
                            <div class="col-md-6">
                                <div class="vendor">
                                    <h2 style="text-decoration:underline;">CONSIGNEE & NOTIFY PARTY</h2>
                                    <div class="vendor">
                                        <h2>{{ $lims_contract_data->invoiceTo->name }}</h2>
                                        <p>{{ $lims_contract_data->invoiceTo->address }}, {{ $lims_contract_data->invoiceTo->city }}, {{ $lims_contract_data->invoiceTo->country }}  </p>
                                        <p>Tel: {{ $lims_contract_data->invoiceTo->phone }}, {{ $lims_contract_data->invoiceTo->mobile }} </p>
                                        <p>Email: {{ $lims_contract_data->invoiceTo->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                            </div>
                         </div>

                         <div class="row" style="margin-top:30px;">
                            <div class="col-md-12">
                                <table width="100%" class="amount_table">
                                        <tr>
                                            <th width="20%">AMOUNT</th>
                                            <td width="3%">:</td>
                                            <th width="77%">USD {{ $lims_contract_data->total_amount }}</th>
                                        </tr>
                                        <tr>
                                            <td width="20%">DRAFT AT</td>
                                            <td width="3%">:</td>
                                            <td width="77%">{{ $lims_contract_data->draft_at }}</td>
                                        </tr>
                                        <tr>
                                            <td width="20%">TRAMS OF DELIVERY</td>
                                            <td width="3%">:</td>
                                            <td width="77%">{{ $lims_contract_data->delivery_terms }}</td>
                                        </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                            </div>
                            <div class="col-md-12">
                                <h2 class="title">" THIS PURCHASE CONTRACT WILL BE REPLACED BY LC BEFORE SHIPMENT "</h2>
                            </div>
                         </div>

                         <div class="row">
                            <div class="col-md-12">
                                <div class="vendor">
                                    <h2 style="text-decoration:underline;">DESCRIPTION OF THE MERCHANDISES</h2>
                                    <div class="description">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>VPO</th>
                                                    <th>STYLE</th>
                                                    <th>ITEM DESCRIPTION</th>
                                                    <th>WASH/COLOR</th>
                                                    <th>ORDER QTY</th>
                                                    <th>UNIT PRICE</th>
                                                    <th>TOTAL VALUE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($details as $key=>$detail)
                                                <tr>
                                                    <td>{{ $detail->vpo }}</td>
                                                    <td>{{ $detail->style }}</td>
                                                    <td>{{ $detail->item_description }}</td>
                                                    <td>{{ $detail->color }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>$ {{ number_format((float)$detail->unit_price, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format((float)$detail->total_value, 2, '.', '') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>TOTAL</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ $lims_contract_data->total_qty }}</th>
                                                    <th></th>
                                                    <th>$ {{ number_format((float)$lims_contract_data->total_amount, 2, '.', '') }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="vendor">
                                    <h2 style="text-decoration:underline;">TERMS AND CONDITIONS</h2>
                                </div>

                                <table width="100%" class="amount_table">
                                    <tr>
                                        <td width="20%">Payment Terms</td>
                                        <td width="3%">:</td>
                                        <th width="77%">{{ $lims_contract_data->payment_terms }}</th>
                                    </tr>
                                    <tr>
                                        <td width="20%">Port of Loading</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ $lims_contract_data->port_of_loading }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Port of Destination</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ $lims_contract_data->port_of_destination }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Mode of Shipment</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ $lims_contract_data->mode_of_shipment }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Transshipment</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ $lims_contract_data->transshipment }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Partial Shipment</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ $lims_contract_data->partial_shipment }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Terms of Sales</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ $lims_contract_data->sale_terms }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Last date of shipment</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ date('d F, Y', strtotime($lims_contract_data->shipment_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">last date of expiry</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{{ date('d F, Y', strtotime($lims_contract_data->expire_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">quantity</td>
                                        <td width="3%">:</td>
                                        <td width="77%">as above ({{ $lims_contract_data->acceptable_amount }}% more or less is acceptable in correct prepack ratio per color)</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">amount</td>
                                        <td width="3%">:</td>
                                        <td width="77%">as above ({{ $lims_contract_data->acceptable_amount }}% more or less is acceptable)</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">documents required</td>
                                        <td width="3%">:</td>
                                        <td width="77%">{!! $lims_contract_data->document !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">inspection certificate</td>
                                        <td width="3%">:</td>
                                        <td width="77%">inspection certificate will be issued & purportedly signed by <span><b>samar kanti dhar</b></span> of winking fashion or consignee.</td>
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
                <a href="{{ url('purchase_contract/print',$lims_contract_data->id) }}" class="btn btn-success btn-md">Print Order</a>
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
