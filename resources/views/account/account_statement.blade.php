@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
<style>
    td,th{
        font-size:14px;
        font-family:'Tahoma';
    }
    .account{
        background-color: #c5c3c3;
        color: black;
    }
</style>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h2 style="background-color: #2b2b6a;color: white;padding: 3px 0px;">Account Information</h2>
                <table width="100%">
                    <tbody class="account">
                        <h3></h3>
                        <tr>
                            <td width="30%">Account Name</td>
                            <td width="10%">:</td>
                            <td><b>{{$lims_account_data->name}}</b></td>
                        </tr>
                        <tr>
                            <td>Account No</td>
                            <td>:</td>
                            <td>{{$lims_account_data->account_no}}</td>
                        </tr>
                        <tr>
                            <td>Statement period</td>
                            <td>:</td>
                            <td>{{ date('d F, Y',strtotime($start_date)) }} - {{ date('d F, Y',strtotime($end_date)) }}</td>
                        </tr>
                        <tr>
                            <td>Statement Date</td>
                            <td>:</td>
                            @php
                                $date = \Carbon\Carbon::now();
                            @endphp
                            <td>{{ $date->format('d F, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Currency</td>
                            <td>:</td>
                            <td>BDT</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        @php
            $total_credit = 0; $total_debit = 0;
        @endphp
        @php
            if (count($transactions) > 0){
                foreach ($transactions as $key => $tran){
                    $total_credit += $tran->credit;
                    $total_debit += $tran->debit;
                    $balance = ($previous_balance + $total_credit) - $total_debit;
                }

            }else{
                $balance = $previous_balance;
            }

        @endphp

        <div class="row">
            <div class="col-md-6 mt-3">
                <h2 style="background-color: #2b2b6a;color: white;padding: 3px 0px;">Account Summary</h2>
                <table width="100%">
                    <tbody class="account">
                        <tr>
                            <td width="30%">Initial Balance</td>
                            <td width="10%">:</td>
                            <td>{{ number_format((float)$previous_balance, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td>Total Credit Amount</td>
                            <td>:</td>
                            <td>{{ number_format((float)$total_credit, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <td>Total Debit Amount</td>
                            <td>:</td>
                            <td>{{ number_format((float)$total_debit, 2, '.', '') }}</td>
                        </tr>


                        <tr>
                            <td>Closing Balance</td>
                            <td>:</td>
                            <td>{{ number_format((float)$balance, 2, '.', '') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-5">
                <h2 style="background-color: #2b2b6a;color: white;padding: 3px 0px;">Transactions</h2>
                <div class="table-responsive mb-5">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{trans('file.date')}}</th>
                                <th>{{trans('Description')}}</th>
                                <th>{{trans('file.reference')}}</th>
                                <th style="text-align:center;">{{trans('file.Credit')}} (BDT)</th>
                                <th style="text-align:center;">{{trans('file.Debit')}} (BDT)</th>
                                <th style="text-align:center;">{{trans('file.Balance')}} (BDT)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{ date('d F, Y',strtotime($start_date))  }}</td>
                                <td>Previous Balance</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;">{{ number_format((float)$previous_balance, 2, '.', '') }}</td>
                            </tr>
                            @php
                                $total_credit=0; $total_debit = 0;
                            @endphp
                            @foreach ($transactions as $key=>$tran)
                                <tr>
                                    <td>
                                        {{ date('d F, Y',strtotime($tran->date))  }}
                                    </td>
                                    <td>{{ $tran->description }}</td>
                                    <td>{{ $tran->reference }}</td>
                                    <td style="text-align:center;">{{ number_format((float)$tran->credit, 2, '.', '') }}</td>
                                    @php
                                        $total_credit += $tran->credit;
                                        $total_debit += $tran->debit;
                                        $balance = $previous_balance + $total_credit - $total_debit;
                                    @endphp
                                    <td style="text-align:center;">{{ number_format((float)$tran->debit, 2, '.', '') }}</td>
                                    <td style="text-align:center;">{{ number_format((float)$balance, 2, '.', '') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td>----- End of The Statement -----</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('accounts/account-statement/print') }}?start_date={{ $start_date }}&&end_date={{ $end_date }}&&type={{ $type }}&&account_id={{ $lims_account_data->id }}" class="tip btn btn-info btn-flat pull-right" title="Print" data-original-title="Label Printer"> <i class="fa fa-print"></i><span class="hidden-sm hidden-xs"> Print</span></a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#account").siblings('a').attr('aria-expanded','true');
    $("ul#account").addClass("show");
    $("ul#account #account-statement-menu").addClass("active");
</script>
@endsection
