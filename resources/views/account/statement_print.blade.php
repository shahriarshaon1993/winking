<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Statement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style type="text/css">
        * {
            font-size: 14px;
            font-family: 'Tahoma';
        }

        h2 {
            font-size: 14px;
        }

        td, th {
            font-size: 14px;
            font-family: 'Tahoma';
        }

        .table td, .table th {
            padding: .30rem !important;
        }

        .account {
            background-color: #c5c3c3;
            color: black;
        }

        .logo img {
            width: 200px;
        }

        .address p {
            margin: 0px;
            font-weight: bold;
        }

        @media print {
            * {
                font-size: 16px;
                line-height: 20px;
            }

            body {
                margin: 0;
            }

            body {
                -webkit-print-color-adjust: exact !important;
            }
        }
    </style>

</head>
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
<body onload="window.print();" style="padding: 0px; margin: 0px">
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="logo mb-3">
                <img src="{{url('public/logo', $general_setting->site_logo)}}" alt="Side Image">
            </div>
            <div class="address">
                <p>HOUSE # 128, ROAD # 01, BARIDHARA DOHS </p>
                <p>DHAKA-1206, BBANGLADESH </p>
                <p>TEL: +88 02 841 9355 </p>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-6">
            <h2 style="background-color: #2b2b6a;color: white;padding: 3px 0px;">Account Information</h2>
            <table width="100%">
                <tbody class="account">
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
        <div class="col-md-12 mt-3">
            <h2 style="text-align: center;
                font-weight: bold;margin-bottom:15px;">STATEMENT OF ACCOUNT</h2>
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
                        <td>{{ date('d F, Y',strtotime($start_date)) }}</td>
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
                            <td>{{ date('d F, Y',strtotime($tran->date)) }}</td>
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
</div>
</body>
</html>
