@extends('layout.main') @section('content')
@if(session()->has('create_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('create_message') !!}</div>
@endif
@if(session()->has('edit_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('edit_message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endforeach
@endif

<section>
    <div class="container-fluid">
    @if(in_array("comments-add", $all_permission))
        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#commentModal"><i class="dripicons-plus"></i> Add Comment</a>&nbsp;
    @endif
    </div>
    <div class="table-responsive">
        <table id="comment-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>Customer</th>
                    <th>Comment Topic</th>
                    <th>Comment Details</th>
                    <th>Created Date</th>
                    <th>Created By</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($comment_list as $key => $comment)
                    <tr data-id="{{$comment->id}}">
                        <td>{{ $key }}</td>
                        <td>{{ $comment->customer->name }}</td>
                        <td>{{ $comment->topic }}</td>
                        <td>{!! $comment->details !!}</td>
                        <td>{{ date("d/m/Y", strtotime($comment->created_at)) }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @if(in_array("comments-edit", $all_permission))
                                    <li>
                                        <button type="button" data-id="{{$comment->id}}" class="editComment btn btn-link"><i class="dripicons-document-edit"></i> Edit</button>
                                    </li>
                                @endif
                                    <li class="divider"></li>
                                @if(in_array("comments-delete", $all_permission))
                                    {{ Form::open(['route' => ['comment.destroy', $comment->id], 'method' => 'DELETE'] ) }}
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

    <div id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            {!! Form::open(['route' => 'comment.store', 'method' => 'post']) !!}
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title">Add Comment<h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
              <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                <div class="form-group">
                    <label>Customer *</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option selected="selected" value>Select Customer</option>
                        @foreach($customer_list as $key => $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Topic *</label>
                    <input type="text" name="topic" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Details *</label>
                    <textarea name="details" rows="4" class="form-control" required></textarea>
                </div>
                <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div>
</section>

<div id="edit-comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'commentUpdate.store', 'method' => 'post']) !!}
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Update Comment<h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>

            <div class="form-group">
                <label>Customer *</label>
                <input type="hidden" name="customer_id" id="edit_customer_id" class="form-control" required>
                <input type="text" name="customer_name" id="edit_customer_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Topic *</label>
                <input type="text" name="topic" id="edit_topic" class="form-control" required>
                <input type="hidden" name="comment_id" id="edit_comment_id">
            </div>
            <div class="form-group">
                <label>Details *</label>
                <textarea name="details" id="edit_details" rows="4" class="form-control"></textarea>
            </div>
            <input type="submit" value="{{trans('file.update')}}" class="btn btn-primary" id="submit-button">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>


<script type="text/javascript">
    $("ul#comment").siblings('a').attr('aria-expanded','true');
    $("ul#comment").addClass("show");
    $("ul#comment #comment-list-menu").addClass("active");

    $(".editComment").on("click",function(){
        var comment_id = $(this).closest('tr').attr('data-id');
        $.get('comment/' + comment_id +'/edit', function (data) {
          $('#edit-comment').modal('show');
          $('#edit_topic').val(data.topic);
          $('#edit_customer_id').val(data.customer.id);
          $('#edit_customer_name').val(data.customer.name);
          $('#edit_details').val(data.details);
          $('#edit_comment_id').val(data.id);
      });

    });

    function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
    }

    var comment_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var table = $('#comment-table').DataTable( {
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
                'targets': [0, 5]
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
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                text: '{{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    //if(user_verified == '1') {
                        comment_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                comment_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(comment_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'comment/deletebyselection',
                                data:{
                                    commentIdArray: comment_id
                                },
                                success:function(data){

                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!customer_id.length)
                            alert('No customer is selected!');
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
