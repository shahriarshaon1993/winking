@extends('layout.main')
@section('content')

<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="printTable" class="card">
                    <style>
                        .header{
                            text-align: center;
                        }
                        p{
                            letter-spacing: 2px;
                            word-spacing: 5px;
                            text-transform: uppercase;
                        }
                       @media print(){
                            .printbutton{
                                display:none !important;
                            }
                            .card-header{
                                display: none !important;
                            }
                            .printbutton{
                                opacity: 0!important;
                            }
                        }
                    </style>
                    <div class="card-header printbutton align-items-center">
                            <div class="d-flex">
                                <h4 style="margin-right:10px;margin-top: 7px;">Bill Exchange</h4> 
                                <button  class="btn btn-info printbutton">Print</button>
                            </div>
                    </div>
                    <style>
                         @media print {
                                .card-header{display:none;}
                            }
                    </style>
                    <div class="card-body">
                    <header class="header">
        <h1>Bill Exchange</h1>
        <h1 style="font-size: 52px;">1</h1>
    </header>
    <table width="100%">
        <tr>
            <td style="text-transform:uppercase;padding-bottom:20px;" colspan="2"><strong>DRAWN UNDER:</strong> {{$bill_exchange->drawn_under}}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td><strong>EXPORT L/C NO:</strong> {{$bill_exchange->export_id}}</td>
            <td style="text-align: right;"><strong>DATE: </strong> {{$bill_exchange->export->date}}</td>
        </tr>
        <tr>
            <td><strong>INVOICE NO: </strong> {{$bill_exchange->export->invoice_no}}</td>
            <td style="text-align: right;"><strong>DATE: </strong> {{$bill_exchange->export->due_date}}</td>
        </tr>
    </table>
    <P style="text-align: justify;">Exchange for <STRONG>{{$bill_exchange->export->invoice_value}}</STRONG> at 60 days after bl date of this <strong style="font-size:25px"><i>FIRST</i></strong> of exchange {{$bill_exchange->refer_bank}}. {{$bill_exchange->bank_address}}. a/c winking fashion the sum of us {{$bill_exchange->export->drawn_under}}(say us {{$inword}} dollar only) values received & charge the same to a/c of {{$bill_exchange->export->customer->name}}, {{$bill_exchange->export->customer->address}}</P>

    <p style="margin-bottom:0px;">TO</p>
    <p style="margin:0px;"><strong>{{$bill_exchange->drawn_under}}</strong></p>
                    </div>

                    {{-- ================== --}}
                    <div style="margin-top:600px" class="card-body">
                    <header class="header">
                            <h1>Bill Exchange</h1>
                            <h1 style="font-size: 52px;">2</h1>
                        </header>
                        <table width="100%">
                            <tr>
                                <td style="text-transform:uppercase;padding-bottom:20px;" colspan="2"><strong>DRAWN UNDER:</strong> {{$bill_exchange->drawn_under}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td><strong>EXPORT L/C NO:</strong> {{$bill_exchange->export->lc_number}}</td>
                                <td style="text-align: right;"><strong>DATE: </strong> {{$bill_exchange->export->date}}</td>
                            </tr>
                            <tr>
                                <td><strong>INVOICE NO: </strong> {{$bill_exchange->export->invoice_no}}</td>
                                <td style="text-align: right;"><strong>DATE: </strong> {{$bill_exchange->export->date}}</td>
                            </tr>
                        </table>
                        <P style="text-align: justify;">Exchange for <STRONG>{{$bill_exchange->export->invoice_value}}</STRONG> at 60 days after bl date of this <strong style="font-size:25px"><i>SECOND</i></strong> of exchange {{$bill_exchange->refer_bank}}. {{$bill_exchange->bank_address}}. a/c winking fashion the sum of us {{$bill_exchange->export->drawn_under}}(say us {{$inword}} dollar only) values received & charge the same to a/c of {{$bill_exchange->export->customer->name}}, {{$bill_exchange->export->customer->address}}</P>

                        <p style="margin-bottom:0px;">TO</p>
                        <p style="margin:0px;"><strong>{{$bill_exchange->drawn_under}}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('.printbutton').on('click',function(){
printData();
})
</script>

@endsection
