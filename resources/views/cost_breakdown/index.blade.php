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
        <!-- Trigger the modal with a button -->
        <a href="{{ route('cost_breakdowns.create') }}" class="btn btn-info"><i class="dripicons-plus"></i> Create Cost Breakdown </a>&nbsp;
    </div>

    <div class="container-fluid" style="margin-top:20px;">
        <div class="card">
            {!! Form::open(['route' => 'breakdown.filtering', 'method' => 'post']) !!}
            <div class="row mb-3">

                <div class="col-md-3 mt-4">
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
                <div class="col-md-2 mt-4">
                    <div class="form-group{{ $errors->has('invoice_to_id') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Choose Vendor</strong> &nbsp;</label>
                        <select name="vendor_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select vendor ...">
                            @foreach ($lims_vendor_all as $vendor)
                               @if (!empty($vendorId))
                                   <option value="{{ $vendor->id }}" {{ ($vendor->id ==  $vendorId)?'selected':''}}>{{ $vendor->name }}</option>
                               @else
                                   <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                               @endif
                            @endforeach
                        </select>
                        @if ($errors->has('vendor_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('vendor_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2 mt-4">
                    <div class="form-group{{ $errors->has('invoice_to_id') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Choose Account Of</strong> &nbsp;</label>
                        <select name="account_of" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Account ...">
                            @if (!empty($accountId))
                                <option value="1" {{ ($accountId == 1)?'selected':'' }}>Winking</option>
                                <option value="2" {{ ($accountId == 2)?'selected':'' }}>Artisan</option>
                            @else
                                <option value="1">Winking</option>
                                <option value="2">Artisan</option>
                            @endif
                        </select>
                        @if ($errors->has('account_of'))
                        <span class="help-block">
                            <strong>{{ $errors->first('account_of') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 mt-4">
                     <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Order Status </strong> &nbsp;</label>
                        @if(isset($status))
                        <select name="status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select status...">
                            <option value="Running" {{ ($status == 'Running') ? 'selected':'' }}>Running</option>
                            <option value="Delivered" {{ ($status == 'Delivered') ? 'selected':'' }}>Delivered</option>
                            <option value="Dropped/Hold" {{ ($status == 'Dropped/Hold') ? 'selected':'' }}>Dropped/Hold</option>
                        </select>
                        @else
                        <select name="status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select status...">
                            <option value="Running">Running</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Dropped/Hold">Dropped/Hold</option>
                        </select>
                        @endif

                    </div>
                </div>

                <div class="col-md-2 mt-4">
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
                    <th>Season</th>
                    <th>Customer</th>
                    <th>Vendor</th>
                    <th>LC/Contract No</th>
                    <th>Order Quantity</th>
                    <th>Order Value (Customer)</th>
                    <th>Order Value (Vendor)</th>
                    <th>Difference Amount</th>
                    <th style="padding-right:50px;">Delivery Date</th>
                    <th>Order Status</th>
{{--                    <th>Document</th>--}}
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($breakdown_all as $key=>$breakdown)
                    <tr data-id={{ $breakdown->id }} style="{{ ($breakdown->status == 'Running')?'background-color: #E7E7E7;':'background-color: #F3FFEB' }}">
                        <td>{{ $key }}</td>
                        <td>
                            @if ($breakdown->account_of == 1)
                                Winking
                            @elseif($breakdown->account_of == 2)
                                Artisan
                            @endif
                        </td>
                        <td>{{ $breakdown->season }}</td>
                        <td>{{ $breakdown->customer->name }}</td>
                        <td>{{ $breakdown->vendor->name }}</td>
                        <td>{{ $breakdown->lc_number }}</td>
                        <td>{{ $breakdown->order_qty }} pcs</td>
                        <td>${{ number_format((float)$breakdown->order_value_customer, 2, '.', '') }}</td>
                        <td>${{ number_format((float)$breakdown->order_value_vendor, 2, '.', '') }}</td>
                        <td>${{ number_format((float)$breakdown->order_value_customer - $breakdown->order_value_vendor, 2, '.', '') }}</td>
                        <td>{{ date('d-M-Y', strtotime($breakdown->delivery_date)) }}</td>
                        <td>
                            @if($breakdown->status == 'Running')
                              <span class="badge badge-danger">{{ $breakdown->status }}</span>
                            @else
                              <span class="badge badge-warning">{{ $breakdown->status }}</span>
                            @endif
                        </td>
{{--                        <td>{{ $breakdown->document }}</td>--}}
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li><a href="{{route('cost_breakdowns.edit',$breakdown->id)}}" class="btn btn-link">  <i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></li>
                                    <li><a href="public/documents/master_contract/{{ $breakdown->document }}" class="btn btn-link">  <i class="dripicons-download"></i> {{trans('Download Cost Breakdown')}}</a></li>
                                    <li class="divider"></li>

                                    {{ Form::open(['route' => ['cost_breakdowns.destroy', $breakdown->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="tfoot active">
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

            </tfoot>
         </table>
    </div>
</section>




<script type="text/javascript">

    $("ul#order-summary").siblings('a').attr('aria-expanded','true');
    $("ul#order-summary").addClass("show");
    $("ul#order-summary #cost-breakdown-menu").addClass("active");


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
                title:'Cost Breakdown',
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
                title:'Cost Breakdown',
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
                title:'Cost Breakdown',
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
                },
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
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum()+' pcs');
            $( dt_selector.column( 7 ).footer() ).html('$'+dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html('$'+dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 9 ).footer() ).html('$'+dt_selector.cells( rows, 9, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum()+' pcs');
            $( dt_selector.column( 7 ).footer() ).html('$'+dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html('$'+dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 9 ).footer() ).html('$'+dt_selector.cells( rows, 9, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

</script>
@endsection
