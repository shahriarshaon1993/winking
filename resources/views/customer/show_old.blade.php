@extends('layout.main') @section('content')
@if(session()->has('create_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('create_message') !!}</div>
@endif
@if(session()->has('edit_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('edit_message') }}</div>
@endif
@if(session()->has('import_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('import_message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<style>
    #sale-table_paginate,#reminder-table_paginate,#deposit-table_paginate,#comment-table_paginate{
        float:right;
    }
    #reminder-table_filter input,#comment-table_filter input{
        width:200%;
    }
</style>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Customer Details')}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <td>{{trans('file.Customer Group')}}</td>
                                <td>{{ $customer->group->name }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('file.name')}}</td>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('file.Date')}}</td>
                                <td>{{ date('d/m/Y', strtotime($customer->created_at)) }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('file.Created By')}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{trans('file.Company Name')}}</td>
                                <td>{{ $customer->company_name }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('file.Email')}}</td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('file.Phone Number')}}</td>
                                <td>{{ $customer->phone_number }}</td>
                            </tr>
                            <tr>
                                <td>{{trans('file.Address')}}</td>
                                <td>{{ $customer->address}}, {{ $customer->city}}@if($customer->country) {{','. $customer->country}}@endif</td>
                            </tr>
                            <tr>
                                <td>{{trans('file.Balance')}}</td>
                                <td>{{ number_format($customer->deposit - $customer->expense, 2) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>All Deposits</h4>
                    </div>
                    <div class="card-body">
                        <table  id="deposit-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Amount</th>
                                    <th>Note</th>
                                    <th>Cretaed By</th>
                                    <th>Cretaed Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->deposits as $deposit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $deposit->amount }}</td>
                                        <td>
                                            @if(isset($deposit->note))
                                              {{ $deposit->note }}
                                            @else
                                              N/A
                                            @endif
                                        </td>
                                        <td>{{ $deposit->user->name }}</td>
                                        <td>{{ date('d/m/Y', strtotime($deposit->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>All Product Sales</h4>
                    </div>
                    <div class="card-body">
                        <table id="sale-table" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Biller</th>
                                    <th>Sale Status</th>
                                    <th>Payment status</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPaid = 0; $totalGrand = 0;
                                @endphp
                                @foreach ($customer->sales as $sale)
                                   <tr>
                                       <td>{{ $loop->iteration }}</td>
                                       <td>{{ date('d/m/Y',strtotime($sale->created_at)) }}</td>
                                       <td>{{ $sale->reference_no }}</td>
                                       <td>{{ $sale->biller->name }}</td>
                                       <td>
                                           @if($sale->sale_status == 1)
                                             <span class="badge badge-success">Complete</span>
                                           @endif
                                       </td>
                                       <td>
                                           @if($sale->payment_status == 1)
                                             <span class="badge badge-info">Pending</span>
                                           @elseif($sale->payment_status == 2)
                                             <span class="badge badge-danger">Due</span>
                                           @elseif($sale->payment_status == 3)
                                             <span class="badge badge-warning">Partial</span>
                                           @elseif($sale->payment_status == 4)
                                             <span class="badge badge-success">Paid</span>
                                           @endif
                                       </td>
                                       <td>{{ $sale->grand_total }}</td>
                                       <td>{{ $sale->paid_amount }}</td>
                                       @php
                                           $totalPaid += $sale->paid_amount;
                                           $totalGrand += $sale->grand_total;
                                       @endphp
                                       <td>{{ $sale->grand_total - $sale->paid_amount }}</td>
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
                                <th>{{$totalGrand}}</th>
                                <th>{{$totalPaid}}</th>
                                <th>{{$totalGrand-$totalPaid}}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>All Service Sales</h4>
                    </div>
                    <div class="card-body">
                        <table id="service-table" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Biller</th>
                                    <th>Sale Status</th>
                                    <th>Payment status</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPaid = 0; $totalGrand = 0;
                                @endphp
                                @foreach ($customer->serviceSale as $sale)
                                   <tr>
                                       <td>{{ $loop->iteration }}</td>
                                       <td>{{ date('d/m/Y',strtotime($sale->created_at)) }}</td>
                                       <td>{{ $sale->reference_no }}</td>
                                       <td>{{ $sale->biller->name }}</td>
                                       <td>
                                           @if($sale->sale_status == 1)
                                             <span class="badge badge-success">Complete</span>
                                           @endif
                                       </td>
                                       <td>
                                           @if($sale->payment_status == 1)
                                             <span class="badge badge-danger">Pending</span>
                                           @elseif($sale->payment_status == 2)
                                             <span class="badge badge-danger">Due</span>
                                           @elseif($sale->payment_status == 3)
                                             <span class="badge badge-warning">Partial</span>
                                           @elseif($sale->payment_status == 4)
                                             <span class="badge badge-success">Paid</span>
                                           @endif
                                       </td>
                                       <td>{{ $sale->grand_total }}</td>
                                       <td>{{ $sale->paid_amount }}</td>
                                       @php
                                           $totalPaid += $sale->paid_amount;
                                           $totalGrand += $sale->grand_total;
                                       @endphp
                                       <td>{{ $sale->grand_total - $sale->paid_amount }}</td>
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
                                <th>{{$totalGrand}}</th>
                                <th>{{$totalPaid}}</th>
                                <th>{{$totalGrand-$totalPaid}}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Comments</h4>
                    </div>
                    <div class="card-body">
                        <table id="comment-table" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Topic</th>
                                    <th>Details</th>
                                    <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->comments as $comment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $comment->topic }}</td>
                                        <td>{{ $comment->details }}</td>
                                        <td>{{ date('d/m/Y', strtotime($comment->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Reminders</h4>
                    </div>
                    <div class="card-body">
                        <table  id="reminder-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Topic</th>
                                    <th>Note</th>
                                    <th>Date & Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->reminders as $reminder)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $reminder->topic }}</td>
                                        <td>{{ $reminder->note }}</td>
                                        <td>{{ date('d/m/Y', strtotime($reminder->date)) }} || {{ date('h:i A', strtotime($reminder->time)) }}</td>
                                   </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        var table = $('#sale-table,#deposit-table').DataTable( {
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
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
       } );

       var table = $('#service-table').DataTable( {
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
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
       } );
       var table = $('#reminder-table,#comment-table').DataTable( {
       } );
    </script>
</section>
@endsection
