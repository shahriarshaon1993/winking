@extends('layout.main') @section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif
    <style>
        .table,
        th {
            vertical-align: text-top !important;
        }

        .table,
        td {
            vertical-align: text-top !important;
        }

        .daterangepicker.opened {
            display: block !important;
        }
    </style>
    <section>
        <div class="container-fluid">
            @if (in_array('expenses-add', $all_permission))
                <button class="btn btn-info" data-toggle="modal" data-target="#cost-budget-modal"><i
                        class="dripicons-plus"></i> {{ trans('file.Add Cost Budget') }}</button>
            @endif
        </div>
        <div class="table-responsive">
            <table id="expense-table" class="table">
                <thead>
                    <tr>
                        <th>SL NO</th>
                        <th>{{ trans('file.Date') }}</th>
                        <th>{{ trans('file.Total Amount') }} (BDT)</th>
                        <th>{{ trans('file.Note') }}</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_cost_budgets as $key => $costBudget)
                        <?php
                        // $warehouse = DB::table('warehouses')->find($expense->warehouse_id);
                        // $expense_category = DB::table('expense_categories')->find($expense->expense_category_id);
                        ?>
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $costBudget->month }}</td>
                            <td>{{ $costBudget->total }}</td>
                            <td>{{ $costBudget->note }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">{{ trans('file.action') }}
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                        user="menu">
                                        @if (in_array('expenses-edit', $all_permission))
                                            <li>
                                                <a  class="btn btn-link" href="{{route('cost-budget.edit', $costBudget->id)}}"><i class="fa fa-edit"></i> Edit</a>
                                            </li>
                                        @endif
                                        @if (in_array('expenses-edit', $all_permission))
                                            <li><a href="{{ route('cost-budget.show', $costBudget->id) }}" class="btn btn-link"><i class="fa fa-eye"></i> View</a></li>
                                        @endif
                                        @if (in_array('expenses-delete', $all_permission))
                                            <li class="divider"></li>
                                            {{ Form::open(['route' => ['cost-budget.destroy', $costBudget->id], 'method' => 'DELETE']) }}
                                            <li>
                                                <button type="submit" class="btn btn-link"
                                                    onclick="return confirmDelete()"><i class="dripicons-trash"></i>
                                                    {{ trans('file.delete') }}</button>
                                            </li>
                                            {{ Form::close() }}
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <!-- <tfoot class="tfoot active">
                    <th></th>
                    <th>{{ trans('file.Total') }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tfoot> -->
            </table>
        </div>
    </section>

    <div id="cost-budget-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Cost Budget') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    {!! Form::open(['route' => 'cost-budget.store', 'method' => 'post']) !!}
                    <?php
                    $lims_expense_category_list = DB::table('expense_categories')
                        ->where('is_active', true)
                        ->get();
                    $lims_account_list = \App\Account::where('is_active', true)->get();
                    ?>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>{{ trans('Month') }} *</label>
                            <input type="month" name="month" required class="form-control">
                        </div>
                    </div>
                    <div id="add_row_div">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>{{ trans('file.Purpose') }} *</label>
                                <select name="purpose[]" class="selectpicker form-control" required data-live-search="true"
                                    data-live-search-style="begins" title="Select Purpose...">
                                    @foreach ($lims_expense_category_list as $expense_category)
                                        <option value="{{ $expense_category->id }}">
                                            {{ $expense_category->name . ' (' . $expense_category->code . ')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>{{ trans('file.Amount') }} *</label>
                                <input type="number" name="amount[]" class="form-control amount" oninput="totalAmount()"
                                    required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>{{ trans('file.Payment Date') }} *</label>
                                <input type="date" name="payment_date[]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row float-right">
                        <div class="col-md-2">
                            <a id="add_row" class="btn btn-success btn-sm">+</a>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-5 form-group">
                            <label for="">Total</label>
                            <input type="text" name="total" id="total" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>{{ trans('file.Note') }}</label>
                            <textarea name="note" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#add_row').on('click', function() {
                $('#add_row_div').append(
                    '<div class="row">\n' +
                    '<div class="col-md-4 form-group">\n' +
                    // '<label>{{ trans('file.Purpose') }} *</label>\n'+
                    '<select name="purpose[]" class="form-control" required data-live-search="true" data-live-search-style="begins" title="Select Purpose...">\n' +
                    '<option>Select Purpose</option>\n' +
                    '@foreach ($lims_expense_category_list as $expense_category)\n' +
                    '<option value="{{ $expense_category->id }}">{{ $expense_category->name . ' (' . $expense_category->code . ')' }}</option>\n' +
                    '@endforeach\n' +
                    '</select>\n' +
                    '</div>\n' +
                    '<div class="col-md-3 form-group">\n' +
                    // '<label>{{ trans('file.Amount') }} *</label>\n'+
                    '<input type="number" name="amount[]" step="any" required class="form-control amount" oninput="totalAmount()">\n' +
                    '</div>\n' +
                    '<div class="col-md-3 form-group">\n'+
                    '<input type="date" name="payment_date[]" class="form-control" required>\n'+
                    '</div>\n'+
                    '<div>\n' +
                    '<a class="remove_row btn btn-danger btn-sm">-</a>\n' +
                    '</div>\n' +
                    '</div>'
                );
            });

            $('#edit_add_row').on('click', function() {
                $('#add_row_edit_div').append(
                    '<div class="row">\n' +
                    '<div class="col-md-4 form-group">\n' +
                    // '<label>{{ trans('file.Purpose') }} *</label>\n'+
                    '<select name="purpose[]" class="form-control" required data-live-search="true" data-live-search-style="begins" title="Select Purpose...">\n' +
                    '<option>Select Purpose</option>\n' +
                    '@foreach ($lims_expense_category_list as $expense_category)\n' +
                    '<option value="{{ $expense_category->id }}">{{ $expense_category->name . ' (' . $expense_category->code . ')' }}</option>\n' +
                    '@endforeach\n' +
                    '</select>\n' +
                    '</div>\n' +
                    '<div class="col-md-3 form-group">\n' +
                    // '<label>{{ trans('file.Amount') }} *</label>\n'+
                    '<input type="number" name="amount[]" step="any" required class="form-control edit-div-amount" oninput="totalAmountForEdit()">\n' +
                    '</div>\n' +
                    '<div class="col-md-3 form-group">\n'+
                    '<input type="date" name="payment_date[]" class="form-control" required>\n'+
                    '</div>\n'+
                    '<div>\n' +
                    '<a class="edit_div_remove_row btn btn-danger btn-sm">-</a>\n' +
                    '</div>\n' +
                    '</div>'
                );
            });

            // $('#remove_row').on('click', 'add_row_div', function(){
            $(document).on('click', '.remove_row', function() {
                $(this).parent().parent().remove();
                totalAmount();
            });

            $(document).on('click', '.edit_div_remove_row', function() {
                $(this).parent().parent().remove();
                totalAmountForEdit();
            });
        });

        function totalAmount() {
            var sum = 0;
            $('.amount').each(function() {
                if ($(this).val() != '') {
                    sum += parseFloat($(this).val());
                }
            });

            $('#total').val(sum);
            // alert(sum);
        }

        function totalAmountForEdit() {
            var sum = 0;
            $('.edit-div-amount').each(function() {
                if ($(this).val() != '') {
                    sum += parseFloat($(this).val());
                }
            });

            $('#edit-div-total').val(sum);
            // alert(sum);
        }

        $("ul#expense").siblings('a').attr('aria-expanded', 'true');
        $("ul#expense").addClass("show");
        $("ul#expense #exp-list-menu").addClass("active");

        var expense_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;
        var all_permission = <?php echo json_encode($all_permission); ?>;

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

        $('#expense-table').DataTable({
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
                    'targets': [0, 6]
                },
                // {
                //     'render': function(data, type, row, meta) {
                //         if (type === 'display') {
                //             data =
                //                 '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                //         }

                //         return data;
                //     },
                //     'checkboxes': {
                //         'selectRow': true,
                //         'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                //     },
                //     'targets': [0]
                // }
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
                    title: 'Expense List',
                    text: '{{ trans('file.PDF') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    title: 'Expense List',
                    text: '{{ trans('file.CSV') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    title: 'Expense List',
                    text: '{{ trans('file.Print') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    customize: function(win) {
                        $(win.document.body).find('td,th').css('text-align', 'center');
                        $(win.document.body).find('td:first-child').css('text-align', 'left');
                        $(win.document.body).find('td:last-child').css('text-align', 'right');
                        $(win.document.body).find('th:first-child').css('text-align', 'left');
                        $(win.document.body).find('th:last-child').css('text-align', 'right');
                        $(win.document.body).find('td,th').css('border', '1px solid #A8A8A8');
                        $(win.document.body).css('margin', '50px');
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    text: '{{ trans('file.delete') }}',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        // if(user_verified == '1') {
                        expense_id.length = 0;
                        $(':checkbox:checked').each(function(i) {
                            if (i) {
                                expense_id[i - 1] = $(this).closest('tr').data('id');
                            }
                        });
                        if (expense_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type: 'POST',
                                url: 'expenses/deletebyselection',
                                data: {
                                    expenseIdArray: expense_id
                                },
                                success: function(data) {
                                    //alert(data);
                                }
                            });
                            dt.rows({
                                page: 'current',
                                selected: true
                            }).remove().draw(false);
                        } else if (!expense_id.length)
                            alert('No expense is selected!');
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
            drawCallback: function() {
                var api = this.api();
                datatable_sum(api, false);
            }
        });

        function datatable_sum(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();
                $(dt_selector.column(5).footer()).html(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed(2));
            } else {
                $(dt_selector.column(5).footer()).html(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed(2));
            }
        }

        if (all_permission.indexOf("expenses-delete") == -1)
            $('.buttons-delete').addClass('d-none');

        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var start_date = startDate.format('YYYY-MM-DD');
                var end_date = endDate.format('YYYY-MM-DD');
                var title = start_date + ' To ' + end_date;
                $('input[name="date_range"]').val(title);
                $('input[name="start_date"]').val(start_date);
                $('input[name="end_date"]').val(end_date);
            }
        });



        if (all_permission.indexOf("expenses-delete") == -1)
            $('.buttons-delete').addClass('d-none');

        $(".payment_daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var start_date = startDate.format('YYYY-MM-DD');
                var end_date = endDate.format('YYYY-MM-DD');
                var title = start_date + ' To ' + end_date;
                $('input[name="payment_date_range"]').val(title);
                $('input[name="payment_start_date"]').val(start_date);
                $('input[name="payment_end_date"]').val(end_date);
            }
        });
    </script>
@endsection
