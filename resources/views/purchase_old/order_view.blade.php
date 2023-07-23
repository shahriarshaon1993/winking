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
        margin-top: 10px;
        font-weight: bold;
        font-family: initial;
        text-align: right;
    }
    .vendor h2, .ship h2{
        font-weight: bold;
        font-family: initial;
        font-size:12px;
    }
    .logo img{
        width: 35%;
       float: left;
       margin-bottom: 20px;
    }
    .company-info p, .vendor p, .ship p{
        margin: 0px;
        padding: 0px;
        font-size: 12px;
        text-transform: uppercase;
    }
    .details th{
        text-transform: uppercase;
        font-weight: bold;
        font-family: initial;
        font-size:12px;
    }
    .details td{
        text-transform: uppercase;
        font-size: 12px;
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
        min-height: 100px;
        border: 1px solid #dee2e6;
        padding: 10px;
        text-transform: uppercase;
    }
</style>
<section>
    <div class="container-fluid">
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
                                    <h2>PURCHASE ORDER</h2>
                                </div>
                            </div>
                         </div>

                         <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
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
                                <table class="table table-hover table-stripped table-bordered details">
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
                                <table class="table table-hover table-stripped table-bordered details">
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
                         <h2 style="margin: 20px 10px;font-size: 18px;font-weight: bold;font-family: initial;">BREAKDOOWN</h2>

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
                                        <th>Unit Price ($)</th>
                                        <th>Total Price ($)</th>
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
                                <div class="description">
                                    {!! $order->packing_instruction !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top:30px;">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('purchase_order/print',$order->id) }}" class="btn btn-success btn-md">Print Order</a>
            </div>
        </div>
    </div>

</section>




<script type="text/javascript">

    $("ul#order-summary").siblings('a').attr('aria-expanded','true');
    $("ul#order-summary").addClass("show");
    $("ul#order-summary #purchase-order-menu-list").addClass("active");

    var category_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;


    $('#category-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3, 4, 5, 6, 9, 10]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                   return data;
                },
                'checkboxes': {
                   'selectRow': true,
                   'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
            },
            {
                extend: 'csv',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                },
            },
            {
                extend: 'print',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
            },
            {
                text: '{{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                   // if(user_verified == '1') {
                        category_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                category_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(category_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'categories/deletebyselection',
                                data:{
                                    categoryIdArray: category_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!category_id.length)
                            alert('No interest is selected!');
                    // }
                    // else
                    //     alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
@endsection
