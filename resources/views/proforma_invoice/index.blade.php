@extends('layout.main') @section('content')

@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<style>
    td{
        vertical-align: text-top !important;
    }
    .table,th{
        vertical-align: text-top !important;
    }
</style>
<section>
    <div class="container-fluid">
        @if(in_array("proforma-invoice-add", $all_permission))
        <!-- Trigger the modal with a button -->
        <a href="{{ route('proforma_invoice.create') }}" class="btn btn-info"><i class="dripicons-plus"></i> Create New Invoice </a>&nbsp;
        @endif
    </div>

    <div class="container-fluid" style="margin-top:20px;">
        <div class="card">
            {!! Form::open(['route' => 'invoice.filtering', 'method' => 'post']) !!}
            <div class="row p-4 mb-3">

                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Choose Customer</strong> &nbsp;</label>
                        <select name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select customer name...">
                            @foreach ($lims_customer_all as $customer)
                                @if(!empty($customerId))
                                     <option value="{{ $customer->id }}" {{ ($customer->id ==  $customerId)?'selected':''}}>{{ $customer->name }}</option>
                                @else
                                     <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('customer_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('customer_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('invoice_to_id') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Choose Notify Party</strong> &nbsp;</label>
                        <select name="invoice_to_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select consignee & notify party...">
                            @foreach ($lims_invoice_to_all as $invoice)
                               @if (!empty($invoiceId))
                                   <option value="{{ $invoice->id }}" {{ ($invoice->id ==  $invoiceId)?'selected':''}}>{{ $invoice->name }}</option>
                               @else
                                   <option value="{{ $invoice->id }}">{{ $invoice->name }}</option>
                               @endif
                            @endforeach
                        </select>
                        @if ($errors->has('invoice_to_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('invoice_to_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-3">
                     <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Order Status </strong> &nbsp;</label>
                        @if(isset($status))
                        <select name="status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select status...">
                            <option value="Running" {{ ($status == 'Running') ? 'selected':'' }}>Running</option>
                            <option value="Delivered" {{ ($status == 'Delivered') ? 'selected':'' }}>Delivered</option>
                        </select>
                        @else
                        <select name="status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select status...">
                            <option value="Running">Running</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                        @endif

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" style="margin-top:40px;"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

    <div class="table-responsive">
        <table id="category-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>Account Of</th>
                    <th>Invoice No</th>
                    <th style="padding-right:60px;">Date</th>
                    <th style="padding-right:50px;">Revised Date</th>
                    <th>Invoice To</th>
                    <th>Customer</th>
                    <th>Season</th>
                    <th width="15%">Quantity</th>
                    <th>Invoice Value</th>
                    <th style="padding-right:50px;">Delivery Date</th>
                    <th>Status</th>
{{--                    <th>Document</th>--}}
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lims_invoice_all as $key=>$invoice)
                    <tr data-id="{{ $invoice->id }}" style="{{ ($invoice->status == 'Running')?'background-color: #E7E7E7;':'background-color: #F3FFEB' }}">
                        <td>{{$key}}</td>
                        <td>
                            @if($invoice->account_of == 1)
                              Winking
                            @elseif($invoice->account_of == 2)
                              Artisan
                            @endif
                        </td>
                        <td>{{ $invoice->invoice_no }}</td>
                        <td>{{ date('d-M-Y', strtotime($invoice->date)) }}</td>
                        <td>
                            @if($invoice->revised_date != null)
                               {{ date('d-M-Y', strtotime($invoice->revised_date)) }}
                            @else
                            @endif
                        </td>
                        <td>{{ $invoice->invoiceTo->name }}</td>
                        <td>{{ $invoice->customer->name }}</td>
                        <td>{{ $invoice->season }}</td>
                        <td>{{ $invoice->total_qty }} pcs</td>
                        <td>${{ number_format((float)$invoice->total_amount, 2, '.', '') }}</td>
                        <td>{{ date('d-M-Y', strtotime($invoice->delivery_date)) }}</td>
                        <td>
                            @if($invoice->status == 'Running')
                              <span class="badge badge-danger">{{ $invoice->status }}</span>
                            @else
                              <span class="badge badge-warning">{{ $invoice->status }}</span>
                            @endif

                        </td>
{{--                        <td>{{ $invoice->document }}</td>--}}
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                   @if(in_array("proforma-invoice-edit", $all_permission))
                                    <li><a href="{{ route('proforma_invoice.edit',$invoice->id) }}" class="btn btn-link">  <i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></li>
                                   @endif
                                    {{-- <li><a href="{{ route('proforma.invoice',$invoice->id) }}" class="btn btn-link"><i class="fa fa-copy"></i>  {{trans('Proforma Invoice')}}</a></li> --}}
                                    {{-- <li><a href="{{ route('proforma_invoice.show',$invoice->id) }}" class="btn btn-link">  <i class="fa fa-eye"></i> {{trans('View')}}</a></li> --}}
                                    <li><a href="public/documents/invoice/{{ $invoice->document }}" class="btn btn-link">  <i class="dripicons-download"></i> {{trans('Download Invoice')}}</a></li>
                                    @if(in_array("proforma-invoice-delete", $all_permission))
                                    <li class="divider"></li>
                                    {{ Form::open(['route' => ['proforma_invoice.destroy', $invoice->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th></th>
                <th>{{trans('file.Total')}}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>
         </table>
        </table>
    </div>
</section>




<script type="text/javascript">

    $("ul#order-summary").siblings('a').attr('aria-expanded','true');
    $("ul#order-summary").addClass("show");
    $("ul#order-summary #proforma-invoice-menu").addClass("active");


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
                'targets': [0, 3, 4, 5, 6, 7, 8]
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
                title: 'Performa Invoice List',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                title: 'Performa Invoice List',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                title: 'Performa Invoice List',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true,
                customize: function ( win ) {
                    $(win.document.body).find('td,th').css( 'text-align', 'center' );
                    $(win.document.body).find('td:first-child').css( 'text-align', 'left' );
                    $(win.document.body).find('td:last-child').css( 'text-align', 'right' );
                    $(win.document.body).find('th:first-child').css( 'text-align', 'left' );
                    $(win.document.body).find('th:last-child').css( 'text-align', 'right' );
                    $(win.document.body).find('td,th').css( 'border', '1px solid #A8A8A8' );
                    $(win.document.body).css( 'margin', '50px' );
                }
            },
            {
                text: '{{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    //if(user_verified == '1') {
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
        drawCallback: function () {
            var api = this.api();
            console.log(api);
            datatable_sum(api, false);
        }
    } );
    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum()+' pcs');
            $( dt_selector.column( 9 ).footer() ).html('$'+dt_selector.cells( rows, 9, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum()+' pcs');
            $( dt_selector.column( 9 ).footer() ).html('$'+dt_selector.cells( rows, 9, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

</script>
@endsection
