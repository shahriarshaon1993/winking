@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<style>
    .table,th{
        vertical-align: text-top !important;
    }
    .table,td{
        vertical-align: text-top !important;
    }
    .daterangepicker.opened{
        display: block !important;
    }
</style>
<section>
    <div class="container-fluid">
        <a href="{{route('bill-exchange.create')}}" class="btn btn-info"><i class="dripicons-plus"></i> Bill Exchange</a>
    </div>
    <div class="table-responsive proTable">
        <table id="bill-exchange-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported">Sl</th>
                    <th style="min-width: 65px !important;"> Drwan Under</th>
                    <th style="min-width: 65px !important;">Export L/C</th>
                    <th style="min-width: 65px !important;">Export Date</th>
                    <th >Invoice No</th>
                    <th>Amount</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bill_exchanges as $bill_exchange)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$bill_exchange->drawn_under}}</td>
                    <td>{{$bill_exchange->export->lc_number}}</td>
                    <td>{{$bill_exchange->export->date}}</td>
                    <td>{{$bill_exchange->export->invoice_no}}</td>
                    <td>{{$bill_exchange->export->invoice_value}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <a href="{{route('bill-exchange.edit', $bill_exchange->id )}}" class="btn btn-link"><i class="fa fa-edit"></i> Edit</a>

                                <li>
                                    <a href="{{route('bill-exchange.show', $bill_exchange->id )}}" class="btn btn-link"><i class="fa fa-eye"></i> View</a>
                                </li>

                                                                <li class="divider"></li>

                                <li>
                                    <form action="{{ route('bill-exchange.destroy', $bill_exchange->id )}}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('delete')
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> Delete</button>
                                </li>
                                </form>
                             </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="tfoot active">
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
<!-- Button trigger modal -->


<!-- Modal -->

<!-- ====================== -->
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<script>
    $(document).ready(function(){
// =================update ================
  $(document).on('click','.editBill',function(){
       let id = $(this).data('id')
       let drawn_under = $(this).data('drawn_under')
       let exportLc = $(this).data('export')
       let export_date = $(this).data('export_date')
       let invoice_no = $(this).data('invoice_no')
       let invoice_date = $(this).data('invoice_date')
       let amount = $(this).data('amount')
      var text = $(this).find('option:selected').text();
       $('#up_id').val(id)
       $('#drawn_under').val(drawn_under)
       $('#export').val(exportLc)
       $('#export_date').val(export_date)
       $('#invoice_no').val(invoice_no)
       $('#invoice_date').val(invoice_date)
       $('#amount').val(amount)
   });
    $(document).on('click','.updatechange',function(){
        let id = $('#up_id').val()
        let drawn_under = $('#drawn_under').val()
        let exportLc = $('#export').val()
        let export_date = $('#export_date').val()
        let invoice_no = $('#invoice_no').val()
        let invoice_date = $('#invoice_date').val()
        let amount = $('#amount').val()
    $.ajax({

        url:"bill-exchange/"+id,
        method:'put',
        data:{id:id,drawn_under:drawn_under,export:exportLc,export_date:export_date,invoice_no:invoice_no,invoice_date:invoice_date,amount:amount},
        success:function (res) {
           if(res.success = 200){
            $(".modal").modal('hide')
            $(".billEditForm")[0].reset()
            $(".proTable").load(location.href+' .proTable')
           }
        },error:function(err){
            let error = err.responseJSON
            console.log(error)
            $.each(error.errors,function(index, value){
                $('#upmsgcontainer').append("<p style='color:red'>"+value+"</p>");
            })
        }
    })
  });
  $('#bill-exchange-table').DataTable( {
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
                extend: 'pdf',
                title:'Employee List',
                text: '{{trans("file.PDF")}}',
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
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    format: {
                        body: function ( data, row, column, node ) {
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
                title:'Employee List',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
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
                   // if(user_verified == '1') {
                        employee_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                employee_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(employee_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'employees/deletebyselection',
                                data:{
                                    employeeIdArray: employee_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!employee_id.length)
                            alert('No employee is selected!');
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
});
</script>
@endsection
