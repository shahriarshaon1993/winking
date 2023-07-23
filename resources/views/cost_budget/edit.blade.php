@extends('layout.main') @section('content')

<div class="modal-body">
    <h4>Edit Cost Budget</h4>
    <p class="italic">
        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
    </p>
    {!! Form::open(['route' => ['cost-budget.update', $costBudget->id], 'method' => 'put']) !!}
    <?php
    $lims_expense_category_list = DB::table('expense_categories')
        ->where('is_active', true)
        ->get();
    $lims_account_list = \App\Account::where('is_active', true)->get();
    ?>
    <div class="row">
        <input type="hidden" name="cost_budget_id">
        <div class="col-md-4 form-group">
            <label>{{ trans('Date') }} *</label>
            <input type="month" name="month" value="{{$costBudget->month}}" required class="form-control">
        </div>
    </div>
    <?php
    if(isset($cBuget)){
        echo $cBuget;
    }
    
    if(isset($costBudget->purpose)){
        $purposes= json_decode($costBudget->purpose);
    }else{
        $purposes= [];
    }
    if(isset($costBudget->amount)){
        $amounts= json_decode($costBudget->amount);
    }else{
        $amounts= [];
    }
    if(isset($costBudget->payment_date)){
        $payment_dates= json_decode($costBudget->payment_date);
    }else{
        $payment_dates= [];
    }

    ?>

    <div id="add_row_edit_div">
        @foreach ($purposes as $key=>$purpose)
        <div class="row">
            <div class="col-md-4 form-group">
                <label>{{ trans('file.Purpose') }} *</label>
                <select name="purpose[]" class="selectpicker form-control" required data-live-search="true"
                    data-live-search-style="begins" title="Select Purpose...">
                    @foreach ($lims_expense_category_list as $expense_category)
                        <option value="{{ $expense_category->id }}" {{ $expense_category->id == $purpose ? 'selected' : '' }}>{{ $expense_category->name . ' (' . $expense_category->code . ')' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label>{{ trans('file.Amount') }} *</label>
                <input type="number" name="amount[]" class="form-control edit-div-amount" value="{{ $amounts[$key] }}" oninput="totalAmountForEdit()"
                    required>
            </div>
            <div class="col-md-3 form-group">
                <label>{{ trans('file.Payment Date') }} *</label>
                <input type="date" name="payment_date[]" class="form-control" value="{{ $payment_dates[$key] }}" required>
            </div>
            <div>
                <a class="edit_div_remove_row btn btn-danger btn-sm">-</a>
            </div>
        </div>
        @endforeach
    </div>


    <div class="row float-right">
        <div class="col-md-2">
            <a id="edit_add_row" class="btn btn-success btn-sm">+</a>
        </div>
    </div>
    <div class="row col-md-12">
        <div class="col-md-5 form-group">
            <label for="">Total</label>
            <input type="text" name="total" id="edit-div-total" class="form-control" value="{{ isset($costBudget->total) ? $costBudget->total : '' }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label>{{ trans('file.Note') }}</label>
            <textarea name="edit_modal_note" rows="3" class="form-control">{{$costBudget->note}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
    </div>
    {{ Form::close() }}
</div>
    <!-- <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" -->
        <!-- class="modal fade text-left"> -->
        <!-- <div role="document" class="modal-dialog"> -->
            <!-- <div class="modal-content"> -->
                <!-- <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Update Cost Budget') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div> -->
                
            <!-- </div> -->
        <!-- </div> -->
    <!-- </div> -->

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
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('.open-Editexpense_categoryDialog').on('click', function() {
            var url = "cost-budget/"
            var id = $(this).data('id').toString();
            url = url.concat(id).concat("/edit");
            $.get(url, function(data) {
                // console.log(data);
                // var purpose= JSON.parse(data.purpose);
                // $('#editModal #reference').text(data['reference_no']);
                // $("#editModal select[name='warehouse_id']").val(data['warehouse_id']);
                // $("#editModal select[name='expense_category_id']").val(data['expense_category_id']);
                // $("#editModal select[name='account_id']").val(data['account_id']);
                // $("#editModal input[name='amount']").val(data['amount']);
                $("#editModal input[name='month']").val(data['month']);
                $("#editModal input[name='cost_budget_id']").val(data['id']);
                $("#editModal textarea[name='edit_modal_note']").val(data['note']);

                <?php echo $cBuget= 1; ?>




                // $("#editModal input[name='billing_date']").val(moment(data['billing_date']).format(
                //     'D - MMM - YYYY'));

                // $("#editModal input[name='payment_date']").val(moment(data['payment_date']).format(
                //     'D - MMM - YYYY'));
                // $("#editModal textarea[name='note']").val(data['note']);
                $('.selectpicker').selectpicker('refresh');
            });
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
