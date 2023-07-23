@extends('layout.main') @section('content')
@if(session()->has('message1'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message1') !!}</div>
@endif
@if(session()->has('message2'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message2') }}</div>
@endif
@if(session()->has('message3'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message3') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>

    <div class="container-fluid">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="dripicons-plus"></i> {{trans("Add Invoice To")}}</button>&nbsp;
    </div>

    <div class="table-responsive">
        <table id="user-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('Name')}}</th>
                    <th>{{trans('file.Email')}}</th>
                    <th>{{trans('file.Phone Number')}}</th>
                    <th>{{trans('file.Address')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_invoice as $key => $invoice)
                    <tr data-id="{{ $invoice->id }}">
                        <td>{{$key}}</td>
                        <td>{{ $invoice->name }}</td>
                        <td>{{ $invoice->email }}</td>
                        <td>{{ $invoice->phone }}</td>
                        <td>{{ $invoice->address }}, {{ $invoice->city }}. {{ $invoice->country }}</td>
                        @if ($invoice->is_active == 1)
                            <td><div class="badge badge-success">Active</div></td>
                        @else
                            <td><div class="badge badge-danger">Unactive</div></td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">

                                    <li><button type="button" data-id="{{ $invoice->id }}" class="open-EditCategoryDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</button></li>

                                    <li class="divider"></li>
                                    {{ Form::open(['route' => ['invoiceTo.delete', $invoice->id], 'method' => 'GET'] ) }}
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
        </table>
    </div>
</section>

<!-- Create Modal -->
<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'invoice_to.store', 'method' => 'post', 'files' => true]) !!}
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('Add Invoice To')}}</h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>{{trans('file.name')}} *</label>
                    {{Form::text('name',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type vendor or shipper name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.Address')}} *</label>
                    {{Form::text('address',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type full address...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.City')}} *</label>
                    {{Form::text('city',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type city name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.State')}}</label>
                    {{Form::text('state',null,array('class' => 'form-control', 'placeholder' => 'Type state name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.Country')}} *</label>
                    {{Form::text('country',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type country name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('Phone Number')}} *</label>
                    {{Form::text('phone',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type phone number...'))}}
                </div>
                <div class="col-md-12 form-group">
                    <label>{{trans('Email')}} *</label>
                    {{Form::email('email',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type email address...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <input class="mt-2" type="checkbox" name="is_active" value="1" checked>
                    <label class="mt-2"><strong>{{trans('file.Active')}}</strong></label>
                </div>
            </div>

            <div class="form-group">
              <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
            </div>
        </div>
        {{ Form::close() }}
      </div>
    </div>
</div>


<!-- Create Modal -->
<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {{ Form::open(['route' => ['invoice.update', 1], 'method' => 'PUT', 'files' => true] ) }}
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('Add Invoice To')}}</h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
            <div class="row">
                <div class="col-md-6 form-group">
                    <input type="hidden" name="invoice_to_id">
                    <label>{{trans('file.name')}} *</label>
                    {{Form::text('name',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type vendor or shipper name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.Address')}} *</label>
                    {{Form::text('address',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type full address...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.City')}} *</label>
                    {{Form::text('city',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type city name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.State')}}</label>
                    {{Form::text('state',null,array('class' => 'form-control', 'placeholder' => 'Type state name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('file.Country')}} *</label>
                    {{Form::text('country',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type country name...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <label>{{trans('Phone Number')}} *</label>
                    {{Form::text('phone',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type phone number...'))}}
                </div>
                <div class="col-md-12 form-group">
                    <label>{{trans('Email')}} *</label>
                    {{Form::email('email',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type email address...'))}}
                </div>
                <div class="col-md-6 form-group">
                    <input class="mt-2" type="checkbox" name="is_active" value="1" checked>
                    <label class="mt-2"><strong>{{trans('file.Active')}}</strong></label>
                </div>
            </div>

            <div class="form-group">
              <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
            </div>
        </div>
        {{ Form::close() }}
      </div>
    </div>
</div>
<script type="text/javascript">

    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $("ul#people #invoice-list-menu").addClass("active");

    var user_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $(document).on("click", ".open-EditCategoryDialog", function(){
          var url ="invoice_to/";
          var id = $(this).data('id').toString();
          url = url.concat(id);

          $.get(url, function(data){
              console.log(data);
            $("#editModal input[name='name']").val(data['name']);
            $("#editModal input[name='address']").val(data['address']);
            $("#editModal input[name='city']").val(data['city']);
            $("#editModal input[name='country']").val(data['country']);
            $("#editModal input[name='state']").val(data['state']);
            $("#editModal input[name='phone']").val(data['phone']);
            $("#editModal input[name='mobile']").val(data['mobile']);
            $("#editModal input[name='email']").val(data['email']);
            $("#editModal input[name='invoice_to_id']").val(data['id']);
          });
    });


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

    $('#user-table').DataTable( {
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
                'targets': [0, 6]
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
                title: 'Invoice List',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                title: 'Invoice List',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                title: 'Invoice List',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
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
            },
            {
                text: '{{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                   // if(user_verified == '1') {
                        user_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                user_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(user_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'user/deletebyselection',
                                data:{
                                    userIdArray: user_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!user_id.length)
                            alert('No user is selected!');
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
