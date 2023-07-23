@extends('layout.main') @section('content')
    @if ($errors->has('name'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}
        </div>
    @endif
    @if ($errors->has('image'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('image') }}
        </div>
    @endif
    @if ($errors->has('email'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('email') }}
        </div>
    @endif
    @if ($errors->has('leave_date'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('leave_date') }}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section>
        @if (in_array('employees-add', $all_permission))
            <div class="container-fluid">
                <a href="{{ route('employees.create') }}" class="btn btn-info"><i class="dripicons-plus"></i>
                    {{ trans('file.Add Employee') }}</a>
            </div>
        @endif
        <div class="table-responsive">
            <table id="employee-table" class="table">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ trans('file.Image') }}</th>
                        <th>{{ trans('file.name') }}</th>
                        <th>{{ trans('file.Email') }}</th>
                        <th>{{ trans('file.Phone Number') }}</th>
                        <th>{{ trans('file.Department') }}</th>
                        <th>{{ trans('file.Address') }}</th>
                        <th>{{ trans('Status') }}</th>
                        <th>{{ trans('Download CV') }}</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_employee_all as $key => $employee)
                        @php $department = \App\Department::find($employee->department_id); @endphp
                        <tr data-id="{{ $employee->id }}">
                            <td>{{ $key }}</td>
                            @if ($employee->image)
                                <td> <img src="{{ url('public/images/employee', $employee->image) }}" height="80"
                                        width="80">
                                </td>
                            @else
                                <td>No Image</td>
                            @endif
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone_number }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $employee->address }}
                                @if ($employee->city)
                                    {{ ', ' . $employee->city }}
                                @endif
                                @if ($employee->state)
                                    {{ ', ' . $employee->state }}
                                @endif
                                @if ($employee->postal_code)
                                    {{ ', ' . $employee->postal_code }}
                                @endif
                                @if ($employee->country)
                                    {{ ', ' . $employee->country }}
                                @endif
                            </td>
                            <td>
                                @if ($employee->status == 0)
                                    {{-- <form action="{{ route('employees.change-status',$employee->id) }}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-danger btn-sm" value="Inactive">
                        </form> --}}
                                    <span>Inactive</span>
                                @elseif($employee->status == 1)
                                    {{-- <form action="{{ route('employees.change-status',$employee->id) }}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-primary btn-sm" value="Active">
                        </form> --}}
                                    <span>Active</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($employee->image_cv))
                                    <a href="public/images/employee/cv/{{ $employee->image_cv }}" class="btn btn-link"
                                        style="font-size:12px;"> <i class="dripicons-download"></i>
                                        {{ trans('Download CV') }}</a>
                                @endif
                            </td>
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
                                        <li>
                                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-link"><i
                                                    class="fa fa-eye"></i> {{ trans('Profile') }}</a>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-link salary-increment-btn" data-id="{{ $employee->id }}" data-present_salary="{{ $employee->present_salary }}" data-toggle="modal" data-target="#incrementModal"><i
                                                    class="fa fa-eye"></i> {{ trans('Increment') }}</button>
                                        </li>
                                        @if (in_array('employees-edit', $all_permission))
                                            <li>
                                                <button type="button" data-id="{{ $employee->id }}"
                                                    data-joining_date="{{ $employee->joining_date }}"
                                                    data-joining_salary="{{ $employee->joining_salary }}"
                                                    data-designation="{{ $employee->designation }}"
                                                    data-present_salary="{{ $employee->present_salary }}"
                                                    data-name="{{ $employee->name }}" data-email="{{ $employee->email }}"
                                                    data-phone_number="{{ $employee->phone_number }}"
                                                    data-nid_number="{{ $employee->nid_number }}"
                                                    data-address2="{{ $employee->address2 }}"
                                                    data-department_id="{{ $employee->department_id }}"
                                                    data-address="{{ $employee->address }}"
                                                    data-city="{{ $employee->city }}"
                                                    data-country="{{ $employee->country }}"
                                                    data-status="{{ $employee->status }}" class="edit-btn btn btn-link"
                                                    data-toggle="modal" data-target="#editModal"><i
                                                        class="dripicons-document-edit"></i>
                                                    {{ trans('file.edit') }}</button>
                                            </li>
                                        @endif
                                        <li class="divider"></li>
                                        @if (in_array('employees-delete', $all_permission))
                                            {{ Form::open(['route' => ['employees.destroy', $employee->id], 'method' => 'DELETE']) }}
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
            </table>
        </div>
    </section>

    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Update Employee') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small></p>
                    {!! Form::open(['route' => ['employees.update', 1], 'method' => 'put', 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="hidden" name="employee_id" />
                            <label>{{ trans('file.name') }} *</label>
                            <input type="text" name="name" required class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.Image') }}</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Designation</label>
                            <input type="text" name="designation" class="form-control"
                                placeholder="Enter Designation">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('Upload CV') }}</label>
                            <input type="file" name="image_cv" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.Department') }} *</label>
                            <select class="form-control selectpicker" name="department_id" placeholder="Enter Department"
                                required>
                                @foreach ($lims_department_list as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.Email') }} </label>
                            <input type="text" name="email" placeholder="Enter Email" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.Phone Number') }} *</label>
                            <input type="text" name="phone_number" required class="form-control"
                                placeholder="Enter Phone Number">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('Present Address') }}</label>
                            <input type="text" name="address" placeholder="Enter Address" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('NID') }}</label>
                            <input type="text" name="nid_number" class="form-control" placeholder="Enter NID Number">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('Prmanent Address') }}</label>
                            <input type="text" name="address2" placeholder="Enter Address" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('Joining Date') }}</label>
                            <input type="text" name="joining_date" class="datepicker form-control"
                                placeholder="Enter Joining Date">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{ trans('Present Salary') }}</label>
                            <input type="text" name="present_salary" class="form-control"
                                placeholder="Enter Present Salary">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('Joining Salary') }}</label>
                            <input type="text" name="joining_salary" class="form-control"
                                placeholder="Enter Joining Salary">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('Status') }}</label>
                            <select name="status" id="status" class="form-control selectpicker">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            {{-- @if ($employee->status == 0)
                        <form action="{{ route('employees.change-status',$employee->id) }}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-danger btn-sm" value="Inactive">
                        </form>
                        @elseif($employee->status == 1)
                        <form action="{{ route('employees.change-status',$employee->id) }}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-primary btn-sm" value="Active">
                        </form>
                        @endif --}}
                        </div>
                        <div class="col-md-6 form-group" id="leave_date_div">
                            <label>{{ trans('Leave Date') }}*</label>
                            <input type="date" name="leave_date" class="form-control">
                        </div>
                        <!--<div class="col-md-6 form-group">-->
                        <!--    <label>{{ trans('file.City') }}</label>-->
                        <!--    <input type="text" name="city" class="form-control">-->
                        <!--</div>-->
                        <!--<div class="col-md-6 form-group">-->
                        <!--    <label>{{ trans('file.Country') }}</label>-->
                        <!--    <input type="text" name="country" class="form-control">-->
                        <!--</div>-->
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Increment modal --}}
    <div id="incrementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Salary Increment') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small></p>
                    {!! Form::open(['route' => ['employees.salary-increment', 1], 'method' => 'post', 'files' => true]) !!}
                    <div class="row">

                        <input type="hidden" name="employee_id">
                        <div class="col-md-4 form-group">
                            <label>{{ trans('Present Salary') }}</label>
                            <input type="text" id="previous_salary" name="previous_salary" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>{{ trans('Increment Amount') }}</label>
                            <input id="increment_salary" type="text" name="increment_salary" class="form-control" >
                        </div>
                        <div class="col-md-4 form-group">
                            <label>{{ trans('Revised Salary') }}</label>
                            <input type="text" name="new_salary" id="new_salary" class="form-control"
                                placeholder="Enter new Salary" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('Effective Month') }}</label>
                            <input type="month" name="effective_month" class="form-control"
                                placeholder="Enter Effective Month">
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
        $("ul#hrm").siblings('a').attr('aria-expanded', 'true');
        $("ul#hrm").addClass("show");
        $("ul#hrm #employee-menu").addClass("active");
        $("#leave_date_div").hide();

        $("#status").on('change', function() {
            if ($("#status").val() == 0) {
                $("#leave_date_div").show();
            } else if ($("#status").val() == 1) {
                $("#leave_date_div").hide();
            }
        });

        var employee_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;

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

        $('.salary-increment-btn').on('click', function(){
            $("#incrementModal input[name='employee_id']").val($(this).data('id'));
            $("#incrementModal input[name='previous_salary']").val($(this).data('present_salary'));
        });

        $('.edit-btn').on('click', function() {
            $("#editModal input[name='employee_id']").val($(this).data('id'));
            $("#editModal input[name='name']").val($(this).data('name'));
            $("#editModal select[name='department_id']").val($(this).data('department_id'));
            $("#editModal input[name='email']").val($(this).data('email'));
            $("#editModal input[name='phone_number']").val($(this).data('phone_number'));
            $("#editModal input[name='address']").val($(this).data('address'));
            $("#editModal input[name='designation']").val($(this).data('designation'));
            $("#editModal input[name='nid_number']").val($(this).data('nid_number'));
            //$("#editModal input[name='joining_date']").val( $(this).data('joining_date') );
            let date = $(this).data('joining_date');
            $("#editModal input[name='joining_date']").val(moment(date).format('D - MMM - YYYY'));

            $("#editModal input[name='present_salary']").val($(this).data('present_salary'));
            $("#editModal input[name='joining_salary']").val($(this).data('joining_salary'));
            $("#editModal input[name='address2']").val($(this).data('address2'));
            $("#editModal input[name='city']").val($(this).data('city'));
            $("#editModal input[name='country']").val($(this).data('country'));
            $("#editModal select[name='status']").val($(this).data('status'));
            $('.selectpicker').selectpicker('refresh');
        });

        $('#employee-table').DataTable({
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
                    'targets': [0, 1, 6]
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
                    title: 'Employee List',
                    text: '{{ trans('file.PDF') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                    customize: function(doc) {
                        for (var i = 1; i < doc.content[1].table.body.length; i++) {
                            if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                                var imagehtml = doc.content[1].table.body[i][0].text;
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                var src = regex.exec(imagehtml)[1];
                                var tempImage = new Image();
                                tempImage.src = src;
                                var canvas = document.createElement("canvas");
                                canvas.width = tempImage.width;
                                canvas.height = tempImage.height;
                                var ctx = canvas.getContext("2d");
                                ctx.drawImage(tempImage, 0, 0);
                                var imagedata = canvas.toDataURL("image/png");
                                delete doc.content[1].table.body[i][0].text;
                                doc.content[1].table.body[i][0].image = imagedata;
                                doc.content[1].table.body[i][0].fit = [30, 30];
                            }
                        }
                    },
                },
                {
                    extend: 'csv',
                    text: '{{ trans('file.CSV') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0 && (data.indexOf('<img src=') != -1)) {
                                    var regex = /<img.*?src=['"](.*?)['"]/;
                                    data = regex.exec(data)[1];
                                }
                                return data;
                            }
                        }
                    },
                },
                {
                    extend: 'print',
                    title: 'Employee List',
                    text: '{{ trans('file.Print') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                    customize: function(win) {
                        $(win.document.body).find('td,th').css('text-align', 'center');
                        $(win.document.body).find('td:first-child').css('text-align', 'left');
                        $(win.document.body).find('td:last-child').css('text-align', 'right');
                        $(win.document.body).find('th:first-child').css('text-align', 'left');
                        $(win.document.body).find('th:last-child').css('text-align', 'right');
                        $(win.document.body).find('td,th').css('border', '1px solid #A8A8A8');
                        $(win.document.body).css('margin', '50px');
                    }
                },
                {
                    text: '{{ trans('file.delete') }}',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        // if(user_verified == '1') {
                        employee_id.length = 0;
                        $(':checkbox:checked').each(function(i) {
                            if (i) {
                                employee_id[i - 1] = $(this).closest('tr').data('id');
                            }
                        });
                        if (employee_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type: 'POST',
                                url: 'employees/deletebyselection',
                                data: {
                                    employeeIdArray: employee_id
                                },
                                success: function(data) {
                                    alert(data);
                                }
                            });
                            dt.rows({
                                page: 'current',
                                selected: true
                            }).remove().draw(false);
                        } else if (!employee_id.length)
                            alert('No employee is selected!');
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
    <script>
        $(document).ready(function() {
  $("#increment_salary").keyup(function(event) {
    var increment_salary = $(this).val(); // Get the current value of the input field
    var previous_salary = $('#previous_salary').val(); // Get the current value of the input field
    console.log(increment_salary); // Display the current value in the console (optional)
    var new_salary = parseFloat(increment_salary) + parseFloat(previous_salary);
    $('#new_salary').val(new_salary); 
  });
});

    </script>
@endsection
