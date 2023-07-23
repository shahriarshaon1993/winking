@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<style>
    .table,th{
        vertical-align: text-top !important;
    }
</style>
<section>
    <div class="container-fluid">
        <button class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="dripicons-plus"></i> {{trans('Add Deposit')}} </button>
    </div>

    <div class="table-responsive">
        <table id="payroll-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('Deposit Purpose')}}</th>
                    <th>{{trans('file.date')}}</th>
                    {{-- <th>{{trans('file.reference')}}</th> --}}
                    <th>{{trans('Account')}}</th>
                    <th>{{trans('Deposit By')}}</th>
                    <th>{{trans('file.Amount')}} (BDT)</th>
                    <th>{{trans('file.Method')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lims_deposit_list as $key=> $deposit)
                    <tr data-id="{{$deposit->id}}">
                        <td>{{$key}}</td>
                        <td>{{$deposit->title}}</td>
                        <td>{{date('d-M-Y',strtotime($deposit->date)) }}</td>
                        <td>{{$deposit->account->name}} - [{{ $deposit->account->account_no }}]</td>
                        <td>{{ $deposit->paid_by}}</td>
                        <td>{{ number_format((float)$deposit->amount, 2, '.', '') }}</td>
                        @if($deposit->paying_method == 1)
                            <td>Cash</td>
                        @elseif($deposit->paying_method == 2)
                        @if($deposit->reference)
                                <td>Cheque - [{{ $deposit->reference }}]</td>
                        @endif
                        @else
                            @if($deposit->reference)
                                <td>Transfer - [{{ $deposit->reference }}]</td>
                            @endif
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <button type="button" data-id="{{$deposit->id}}" data-reference="{{$deposit->reference}}" data-account_id="{{$deposit->account_id}}"  data-title="{{$deposit->title}}" data-date="{{$deposit->date}}" data-amount="{{$deposit->amount}}" data-paid="{{$deposit->paid_by}}"
                                            data-note="{{$deposit->note}}" data-paying_method="{{$deposit->paying_method}}" class="edit-btn btn btn-link" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</button>
                                    </li>
                                    <li class="divider"></li>
                                    {{ Form::open(['route' => ['deposits.destroy', $deposit->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Total:</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('Add Depoosit')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
              <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                {!! Form::open(['route' => 'deposits.store', 'method' => 'post', 'files' => true]) !!}
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>{{trans('Deposit Purpose')}} *</label>
                        <input type="text" name="title" placeholder="Enter Deposit Purpose" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label> {{trans('file.Account')}} *</label>
                        <select class="form-control selectpicker" name="account_id">
                        @foreach($lims_account_list as $account)
                            @if($account->is_default)
                            <option selected value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                            @else
                            <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('Date')}} *</label>
                        <input type="text" name="date" class="datepicker form-control" placeholder="Enter Date" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('Paid By')}} *</label>
                        <input type="text" name="paid_by" placeholder="Paid By" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('file.Method')}} *</label>
                        <select class="form-control selectpicker" name="paying_method" required>
                            <option value="1">Cash</option>
                            <option value="2">Cheque</option>
                            <option value="3">Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('file.Amount')}} *</label>
                        <input type="number" step="any" name="amount" class="form-control" placeholder="Enter Amount" required>
                    </div>
                    <div class="col-md-12 form-group" id="reference_section">
                        <label>{{trans('Reference')}} *</label>
                        <input type="text" name="reference" class="form-control" placeholder="Enter reference e.g. Transaction ID, Check No">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>{{trans('file.Note')}}</label>
                        <textarea name="note" rows="3" placeholder="Enter Note" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('Update Deposit')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
              <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                {!! Form::open(['route' => ['deposits.update', 1], 'method' => 'put', 'files' => true]) !!}
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>{{trans('Deposit Purpose')}} *</label>
                        <input type="hidden" name="deposit_id">
                        <input type="text" name="title" placeholder="Enter Deposit Purpose" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label> {{trans('file.Account')}} *</label>
                        <select class="form-control selectpicker" name="account_id">
                        @foreach($lims_account_list as $account)
                            @if($account->is_default)
                            <option selected value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                            @else
                            <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('Date')}} *</label>
                        <input type="text" name="date" class="datepicker form-control" placeholder="Enter Date" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('Paid By')}} *</label>
                        <input type="text" name="paid_by" placeholder="Enter Paid By" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('file.Method')}} *</label>
                        <select class="form-control selectpicker" name="paying_method" required>
                            <option value="1">Cash</option>
                            <option value="2">Cheque</option>
                            <option value="3">Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>{{trans('file.Amount')}} *</label>
                        <input type="number" step="any" name="amount" class="form-control" placeholder="Enter Amount" required>
                    </div>
                    <div class="col-md-12 form-group" id="edit_reference_section">
                        <label>{{trans('Reference')}} *</label>
                        <input type="text" name="reference" class="form-control" placeholder="Enter reference e.g. Transaction ID, Check No">
                    </div>

                    <div class="col-md-12 form-group">
                        <label>{{trans('file.Note')}}</label>
                        <textarea name="note" rows="3" placeholder="Enter Note" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("ul#account").siblings('a').attr('aria-expanded','true');
    $("ul#account").addClass("show");
    $("ul#account #add-deposit").addClass("active");
    $("#reference_section").hide();

    var payroll_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $('.edit-btn').on('click', function() {
        if($(this).data('paying_method') >= 2){
            $("#edit_reference_section").show(500);
        }else{
            $("#edit_reference_section").hide(500);
        }
        $("#editModal input[name='deposit_id']").val( $(this).data('id') );
        $("#editModal input[name='title']").val( $(this).data('title') );
        $("#editModal select[name='account_id']").val( $(this).data('account_id'));
        $("#editModal select[name='account_id']").change();
        $("#editModal input[name='amount']").val( $(this).data('amount') );
        $("#editModal input[name='paid_by']").val( $(this).data('paid') );
        let updateDate = $(this).data('date')
        $("#editModal input[name='date']").val( moment(updateDate).format('D - MMM - YYYY')) ;
        $("#editModal input[name='reference']").val( $(this).data('reference') );
        $("#editModal select[name='paying_method']").val( $(this).data('paying_method') );
        $("#editModal textarea[name='note']").val( $(this).data('note') );
        $('.selectpicker').selectpicker('refresh');
    });

    $('select[name="paying_method"]').on('change', function() {
        if($(this).val() >= 2){
            $("#reference_section").show(500);
        }else{
            $("#reference_section").hide(500);
        }
    });

    $('select[name="paying_method"]').on('change', function() {
        if($(this).val() >= 2){
            $("#edit_reference_section").show(500);
        }else{
            $("#edit_reference_section").hide(500);
        }
    });

    $('#payroll-table').DataTable( {
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
                'targets': [0, 1, 6]
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
                extend: 'pdfHtml5',
                title: 'Bank Deposit List',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
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
                title: 'Bank Deposit List',
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
                title: 'Bank Deposit List',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                },
                customize: function ( win ) {
                    $(win.document.body).find('td,th').css( 'text-align', 'center' );
                    $(win.document.body).find('td:first-child').css( 'text-align', 'left' );
                    $(win.document.body).find('td:last-child').css( 'text-align', 'right' );
                    $(win.document.body).find('th:first-child').css( 'text-align', 'left' );
                    $(win.document.body).find('th:last-child').css( 'text-align', 'right' );
                    $(win.document.body).find('td,th').css( 'border', '1px solid #A8A8A8' );
                    $(win.document.body).css( 'margin', '50px' );
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                text: '{{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    //if(user_verified == '1') {
                        payroll_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                payroll_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(payroll_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'payroll/deletebyselection',
                                data:{
                                    payrollIdArray: payroll_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!payroll_id.length)
                            alert('No payroll is selected!');
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
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
        }
    }
</script>
@endsection
