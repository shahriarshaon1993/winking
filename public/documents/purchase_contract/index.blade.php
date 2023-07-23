@extends('layout.main') @section('content')

@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<style>
    td,th{
        text-transform: uppercase;
        font-size:12px;
    }
</style>

<section>
    <div class="container-fluid">
        <!-- Trigger the modal with a button -->
        <a href="{{ route('purchase_contract.create') }}" class="btn btn-info"><i class="dripicons-plus"></i>New Purchase Contract </a>&nbsp;
    </div>

    <div class="container-fluid" style="margin-top:20px;">
        <div class="card">
            {!! Form::open(['route' => 'contract.filtering', 'method' => 'post']) !!}
            <div class="row pl-3 mb-3">
                <div class="col-md-5 mt-4">
                    <div class="form-group{{ $errors->has('vendor_id') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Choose vendor</strong> &nbsp;</label>
                        <select name="vendor_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select vendor...">
                            @foreach ($lims_vendor_all as $vendor)
                                @if (!empty($vendorId))
                                     <option value="{{ $vendor->id }}" {{ ($vendorId == $vendor->id)?'selected':'' }}>{{ $vendor->name }}</option>
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
                <div class="col-md-5 mt-4">
                    <div class="form-group{{ $errors->has('invoice_to_id') ? ' has-error' : '' }} has-feedback">
                        <label class="d-tc mt-2"><strong>Choose consignee party & notify party</strong> &nbsp;</label>
                        <select name="invoice_to_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select invoice to...">
                            @foreach ($lims_invoice_to_all as $invoice)
                                @if (!empty($invoiceId))
                                     <option value="{{ $invoice->id }}" {{ ($invoiceId == $invoice->id)?'selected':'' }}>{{ $invoice->name }}</option>
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
                    <th>Master Contract No</th>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Amount (M)</th>
                    <th>Consignee & Notify Party</th>
                    <th>Vendor</th>
                    <th>Season</th>
                    <th>Contract No</th>
                    <th>Revised Date</th>
                    <th>Quantity</th>
                    <th>Amount (V)</th>
                    <th>Difference Amount</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lims_contract_all as $key=>$contract)
                    <tr data-id="{{ $contract->id }}">
                        <td>{{ $key }}</td>
                        <td>{{ $contract->master_contract_no }}</td>
                        <td>{{ date('d-m-Y', strtotime($contract->created_at)) }}</td>
                        <td>{{ $contract->total_qty }}</td>
                        <td>{{ number_format((float)$contract->total_amount_master, 2, '.', '') }} </td>
                        <td>{{ $contract->invoiceTo->name }}</td>
                        <td>{{ $contract->vendor->name }}</td>
                        <td>{{ $contract->season }}</td>
                        <td>{{ $contract->contract_no }}</td>
                        <td>{{ $contract->revised_date }}</td>
                        <td>{{ $contract->total_qty }}</td>
                        <td>{{ number_format((float)$contract->total_amount, 2, '.', '') }} </td>
                        <td>{{ number_format((float)$contract->total_amount_master -  $contract->total_amount, 2, '.', '') }} </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">

                                    <li><a href="public/documents/master_contract/{{ $contract->master_doc }}" class="btn btn-link" style="font-size:12px;">  <i class="dripicons-download"></i> {{trans('Download Master Contract')}}</a></li>
                                    {{-- <li><a href="{{ route('purchase_contract.show',$contract->id) }}" class="btn btn-link">  <i class="fa fa-eye"></i> {{trans('View')}}</a></li> --}}
                                    <li><a href="{{ route('purchase_contract.edit',$contract->id) }}" class="btn btn-link" style="font-size:12px;">  <i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></li>
                                     {{-- <li><a href="{{ route('proforma.invoice',$contract->id) }}" class="btn btn-link"><i class="fa fa-copy"></i>  {{trans('Proforma Invoice')}}</a></li> --}}
                                    <li><a href="public/documents/purchase_contract/{{ $contract->contract_doc }}" class="btn btn-link" style="font-size:12px;">  <i class="dripicons-download"></i> {{trans('Download Purchase Contract')}}</a></li>


                                    <li class="divider"></li>
                                    {{ Form::open(['route' => ['purchase_contract.destroy', $contract->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button style="text-transform:uppercase;font-size:12px;" type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
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
    $("ul#order-summary #purchase-contract-list").addClass("active");


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
    } );

</script>
@endsection
