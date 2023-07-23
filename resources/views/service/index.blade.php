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

<section>
    <div class="container-fluid">
    @if(in_array("services-add", $all_permission))
        <!-- Trigger the modal with a button -->
        <a href="{{route('services.create')}}" class="btn btn-info"><i class="dripicons-plus"></i> Add Service</a>
    @endif

    </div>
    <div class="table-responsive">
        <table id="service-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $key=>$service)
                    <tr data-id="{{ $service->id }}">
                        <td>{{$key}}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->code }}</td>
                        <td>{{ $service->category->name }}</td>
                        <td>{{ $service->price }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @if(in_array("services-edit", $all_permission))
                                    <li><a href="{{ route('services.edit',$service->id) }}" class="btn btn-link">  <i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></li>
                                @endif
                                    <li><button type="button" data-id="{{ $service->id }}" class="open-viewModal btn btn-link"><i class="fa fa-eye"></i> View</button></li>
                                @if(in_array("services-delete", $all_permission))
                                    <li class="divider"></li>
                                    {{ Form::open(['route' => ['services.destroy', $service->id], 'method' => 'DELETE'] ) }}
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
        </table>
    </div>

    <div id="view-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 id="modal_header" class="modal-title">Service Details</h5>&nbsp;&nbsp;
                  <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="dripicons-print"></i> {{trans('file.Print')}}</button>
                  <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Service name</td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td>Code</td>
                            <td id="code"></td>
                        </tr>
                        <tr>
                            <td>Category name</td>
                            <td id="category-name"></td>
                        </tr>
                        <tr>
                            <td>Tax rate</td>
                            <td id="tax_rate"></td>
                        </tr>
                        <tr>
                            <td>Tax method</td>
                            <td id="tax_method"></td>
                        </tr>
                        <tr>
                            <td>Base Price</td>
                            <td id="price"></td>
                        </tr>
                        <tr>
                            <td>Details</td>
                            <td id="details"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>




<script type="text/javascript">

    $("ul#service").siblings('a').attr('aria-expanded','true');
    $("ul#service").addClass("show");
    $("ul#service #service-list-menu").addClass("active");


    var service_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".open-viewModal").on("click",function(){
        var url ="services/";
        var id = $(this).data('id').toString();
        $.get(url+id, function(data) {
            console.log(data);
            $('#name').text(data[0]);
            $('#code').text(data[1]);
            $('#category-name').text(data[2]);
            $('#tax_rate').text(data[3]);
            $('#tax_method').text(data[4]);
            $('#price').text(data[5]);
            $('#details').append(data[6]);
        });
        $('#view-service').modal('show');
        //alert(url);
    });

    $( "#select_all" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("tbody input[type='checkbox']").prop('checked', true);
        }
        else {
            $("tbody input[type='checkbox']").prop('checked', false);
        }
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('view-service');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });


    $('#service-table').DataTable( {
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
                'targets': [0, 1,3]
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
                        service_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                service_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(service_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'services/deletebyselection',
                                data:{
                                    serviceIdArray: service_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!service_id.length)
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
