@extends('layout.main') @section('content')
    @if ($errors->has('name'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <style>
        .company-info h2 {
            margin-top: 10px;
            font-weight: bold;
            font-family: Tahoma;
            text-align: right;
        }

        .vendor h2,
        .ship h2 {
            font-weight: bold;
            font-family: Tahoma;
            font-size: 12px;
        }

        .custom_table th,
        .custom_table td {
            border: 1px solid #dee2e6;
            padding: .30rem;
        }

        .table td,
        .table th {
            padding: .50rem;
        }

        .logo img {
            width: 30%;
            float: left;
        }

        .company-info p,
        .vendor p,
        .ship p {
            margin: 0px;
            padding: 0px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .details th {
            text-transform: uppercase;
            font-weight: bold;
            font-family: Tahoma;
            font-size: 12px;
        }

        .details td {
            text-transform: uppercase;
            font-size: 12px;
        }

        .purchase {
            background-color: #dad7d7;
            padding: 5px;
            font-weight: bold;
            font-family: Tahoma;
            text-align: center;
            border-radius: 5px;
        }

        .description {
            padding: 0px;
            text-align: justify;
            min-height: 80px;
            border: 1px solid #dee2e6;
            padding: 5px;
            text-transform: uppercase;
            font-size: 12px;
        }

        .packing {
            padding: 0px;
            text-align: justify;
            min-height: 60px;
            border: 1px solid #dee2e6;
            padding: 5px;
            text-transform: uppercase;
            font-size: 12px;
        }

        .ptop {
            vertical-align: top;
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
                                        <img src="{{ url('public/logo', $general_setting->site_logo) }}" alt="Side Image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="company-info">
                                        <h2>PURCHASE ORDER</h2>
                                        <p style="text-align:right;">{{ date('d-M-Y', strtotime($order->order_date)) }}</p>
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
                                            <td class="ptop">
                                                <div class="vendor">
                                                    <p><b>{{ $order->vendorInfo->name }}</b></p>
                                                    <p>{{ $order->vendorInfo->address }},
                                                        {{ $order->vendorInfo->city }}-{{ $order->vendorInfo->state }}.
                                                        {{ $order->vendorInfo->country }} </p>
                                                    <p>Tel:
                                                        {{ $order->vendorInfo->phone }}
                                                        @if ($order->vendorInfo->mobile !== null)
                                                            ,
                                                        @endif
                                                        {{ $order->vendorInfo->mobile }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="ptop">
                                                <div class="vendor">
                                                    <p><b>{{ $order->shipTo->name }}</b></p>
                                                    <p>{{ $order->shipTo->address }}, {{ $order->shipTo->city }},
                                                        {{ $order->shipTo->state }}, {{ $order->shipTo->zip }},
                                                        {{ $order->shipTo->country }} </p>
                                                    <p>Tel:
                                                        {{ $order->shipTo->phone }}
                                                        @if ($order->shipTo->mobile !== null)
                                                            ,
                                                        @endif
                                                        {{ $order->shipTo->mobile }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="ptop">
                                                <div class="vendor">
                                                    <p><b>{{ $order->invoiceTo->name }}</b></p>
                                                    <p>{{ $order->invoiceTo->address }},
                                                        {{ $order->invoiceTo->city }}-{{ $order->invoiceTo->state }},
                                                        {{ $order->invoiceTo->country }} </p>
                                                    <p>Tel:
                                                        {{ $order->invoiceTo->phone }}
                                                        @if ($order->invoiceTo->mobile !== null)
                                                            ,
                                                        @endif
                                                        {{ $order->invoiceTo->mobile }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="ptop">
                                                <div class="vendor">
                                                    <p><b>{{ $order->customer->name }}</b></p>
                                                    <p>{{ $order->customer->address }}, {{ $order->customer->city }},
                                                        {{ $order->customer->state }},
                                                        {{ $order->customer->postal_code }},
                                                        {{ $order->customer->country }} </p>
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
                                                <td>{{ date('d-M-Y', strtotime($order->ship_exp_date)) }}</td>
                                                <td>{{ $order->ship_via }}</td>
                                                <td>{{ $order->ship_terms }}</td>
                                                <td>{{ $order->payment_terms }}</td>
                                                <td>{{ $order->brand }}</td>
                                                <td>{{ $order->season }}</td>
                                                <td>
                                                    @if ($order->rivision_no != null)
                                                        {{ date('d-M-Y', strtotime($order->rivision_no)) }}
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
                                    <table class="custom_table details table" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="">Color</th>
                                                <th width="">Code</th>
                                                <th width="">PRE PACK</th>
                                                @if ($lim_sizes->size1)
                                                    <th style="text-align:center;">{{ $lim_sizes->size1 }}</th>
                                                @endif
                                                @if ($lim_sizes->size2)
                                                    <th style="text-align:center;">{{ $lim_sizes->size2 }}</th>
                                                @endif
                                                @if ($lim_sizes->size3)
                                                    <th style="text-align:center;">{{ $lim_sizes->size3 }}</th>
                                                @endif
                                                @if ($lim_sizes->size4)
                                                    <th style="text-align:center;">{{ $lim_sizes->size4 }}</th>
                                                @endif
                                                @if ($lim_sizes->size5)
                                                    <th style="text-align:center;">{{ $lim_sizes->size5 }}</th>
                                                @endif
                                                @if ($lim_sizes->size6)
                                                    <th style="text-align:center;">{{ $lim_sizes->size6 }}</th>
                                                @endif
                                                @if ($lim_sizes->size7)
                                                    <th style="text-align:center;">{{ $lim_sizes->size7 }}</th>
                                                @endif
                                                @if ($lim_sizes->size8)
                                                    <th style="text-align:center;">{{ $lim_sizes->size8 }}</th>
                                                @endif
                                                @if ($lim_sizes->size9)
                                                    <th style="text-align:center;">{{ $lim_sizes->size9 }}</th>
                                                @endif
                                                @if ($lim_sizes->size10)
                                                    <th style="text-align:center;">{{ $lim_sizes->size10 }}</th>
                                                @endif
                                                @if ($lim_sizes->size11)
                                                    <th style="text-align:center;">{{ $lim_sizes->size11 }}</th>
                                                @endif
                                                @if ($lim_sizes->size12)
                                                    <th style="text-align:center;">{{ $lim_sizes->size12 }}</th>
                                                @endif
                                                @if ($lim_sizes->size13)
                                                    <th style="text-align:center;">{{ $lim_sizes->size13 }}</th>
                                                @endif
                                                <th style="text-align:center;" width="">Total Units</th>
                                                <th style="text-align:center;" width="">Unit Price</th>
                                                <th style="text-align:center;" width="">Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($count = 0)
                                            @foreach ($lim_details as $key => $detail)
                                                <tr>
                                                    <td>{{ $detail->color }}</td>
                                                    <td>{{ $detail->color_code }}</td>
                                                    <td>
                                                        @if ($detail->prepack1)
                                                            {{ $detail->prepack1 }}
                                                            @if ($detail->prepack2)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack2)
                                                            {{ $detail->prepack2 }}
                                                            @if ($detail->prepack3)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack3)
                                                            {{ $detail->prepack3 }}
                                                            @if ($detail->prepack4)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack4)
                                                            {{ $detail->prepack4 }}
                                                            @if ($detail->prepack5)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack5)
                                                            {{ $detail->prepack5 }}
                                                            @if ($detail->prepack6)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack6)
                                                            {{ $detail->prepack6 }}
                                                            @if ($detail->prepack7)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack7)
                                                            {{ $detail->prepack7 }}
                                                        @endif
                                                        @if ($detail->prepack8)
                                                            {{ $detail->prepack8 }}
                                                            @if ($detail->prepack9)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack9)
                                                            {{ $detail->prepack9 }}
                                                            @if ($detail->prepack10)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack10)
                                                            {{ $detail->prepack10 }}
                                                            @if ($detail->prepack11)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack11)
                                                            {{ $detail->prepack11 }}
                                                            @if ($detail->prepack12)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack12)
                                                            {{ $detail->prepack12 }}
                                                            @if ($detail->prepack13)
                                                                -
                                                            @endif
                                                        @endif
                                                        @if ($detail->prepack13)
                                                            {{ $detail->prepack13 }}
                                                        @endif

                                                    </td>
                                                    @if ($detail->quantity1)
                                                        <td style="text-align:center;">{{ $detail->quantity1 }}</td>
                                                    @endif
                                                    @if ($detail->quantity2)
                                                        <td style="text-align:center;">{{ $detail->quantity2 }}</td>
                                                    @endif
                                                    @if ($detail->quantity3)
                                                        <td style="text-align:center;">{{ $detail->quantity3 }}</td>
                                                    @endif
                                                    @if ($detail->quantity4)
                                                        <td style="text-align:center;">{{ $detail->quantity4 }}</td>
                                                    @endif
                                                    @if ($detail->quantity5)
                                                        <td style="text-align:center;">{{ $detail->quantity5 }}</td>
                                                    @endif
                                                    @if ($detail->quantity6)
                                                        <td style="text-align:center;">{{ $detail->quantity6 }}</td>
                                                    @endif
                                                    @if ($detail->quantity7)
                                                        <td style="text-align:center;">{{ $detail->quantity7 }}</td>
                                                    @endif
                                                    @if ($detail->quantity8)
                                                        <td style="text-align:center;">{{ $detail->quantity8 }}</td>
                                                    @endif
                                                    @if ($detail->quantity9)
                                                        <td style="text-align:center;">{{ $detail->quantity9 }}</td>
                                                    @endif
                                                    @if ($detail->quantity10)
                                                        <td style="text-align:center;">{{ $detail->quantity10 }}</td>
                                                    @endif
                                                    @if ($detail->quantity11)
                                                        <td style="text-align:center;">{{ $detail->quantity11 }}</td>
                                                    @endif
                                                    @if ($detail->quantity12)
                                                        <td style="text-align:center;">{{ $detail->quantity12 }}</td>
                                                    @endif
                                                    @if ($detail->quantity13)
                                                        <td style="text-align:center;">{{ $detail->quantity13 }}</td>
                                                    @endif
                                                    <td style="text-align:center;">{{ $detail->color_wise_quantity }}</td>
                                                    <td style="text-align:center;">$
                                                        {{ number_format((float) $detail->color_unit_price, 2, '.', '') }}
                                                    </td>
                                                    <td style="text-align:center;">$
                                                        {{ number_format((float) $detail->sub_total, 2, '.', '') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="{{ $sizeCount + 3 }}" style="text-align: right;">Total</th>
                                                <th style="text-align:center;">{{ $order->total_quantity }}</th>
                                                <th></th>
                                                <th style="text-align:center;">
                                                    ${{ number_format((float) $order->total_amount, 2, '.', '') }}</th>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('purchase_order/print', $order->id) }}" class="btn btn-success btn-md">Print Order</a>
                </div>
            </div>
        </div>

    </section>




    <script type="text/javascript">
        $("ul#order-summary").siblings('a').attr('aria-expanded', 'true');
        $("ul#order-summary").addClass("show");
        $("ul#order-summary #purchase-order-menu-list").addClass("active");

        var category_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;


        $('#category-table').DataTable({
            "order": [],
            'language': {
                'lengthMenu': '_MENU_ {{ trans('file.records per page') }}',
                "info": '<small>{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{ trans('file.Search') }}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 3, 4, 5, 6, 9, 10]
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
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
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    text: '{{ trans('file.PDF') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                },
                {
                    extend: 'csv',
                    text: '{{ trans('file.CSV') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                    },
                },
                {
                    extend: 'print',
                    text: '{{ trans('file.Print') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                },
                {
                    text: '{{ trans('file.delete') }}',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        // if(user_verified == '1') {
                        category_id.length = 0;
                        $(':checkbox:checked').each(function(i) {
                            if (i) {
                                category_id[i - 1] = $(this).closest('tr').data('id');
                            }
                        });
                        if (category_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type: 'POST',
                                url: 'categories/deletebyselection',
                                data: {
                                    categoryIdArray: category_id
                                },
                                success: function(data) {
                                    alert(data);
                                }
                            });
                            dt.rows({
                                page: 'current',
                                selected: true
                            }).remove().draw(false);
                        } else if (!category_id.length)
                            alert('No interest is selected!');
                        // }
                        // else
                        //     alert('This feature is disable for demo!');
                    }
                },
                {
                    extend: 'colvis',
                    text: '{{ trans('file.Column visibility') }}',
                    columns: ':gt(0)'
                },
            ],
        });
    </script>
@endsection
