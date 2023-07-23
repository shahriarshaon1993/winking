@extends('layout.main')
@section('content')
<style>
    .no-margin{
        margin:0px;
    }
    .leter-head p{
        margin:0px;
    }
    #printButton{
        position: absolute;
    text-align: right;
    right: 21px;
    top: 7px;
    background: #673ab7;
    }
    @media print{
        #printButton{
            display: none !important;
        }
    }
</style>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div id="printThisDiv" class="card">
                    <style>
                            @media print{
        #printButton{
            display: none !important;
        }
    }
                    </style>
                    <div class="card-body">
                        <header class="header">
                            <span>
                                <p class="float-left"><strong> Ref : {{ $forwardLetter->reference }} </strong></p>
                            </span>
                            <a class="btn print btn-sm btn-secondary float-right mr-1 d-print-noneb" href="#"  data-abc="true" id="printButton">
                                <i class="fa fa-print"></i> Print</a>
                            <p class="float-right"> Date: {{ date('d-F-Y', strtotime($forwardLetter->date))}}</p>
                            <div class="leter-head">
                                <p>To,</p>
                                <p>The Manager</p>
                                <p>{{$forwardLetter->bank->name}}</p>
                                <p>{{$forwardLetter->branch->name}}</p>
                                <p>{{$forwardLetter->branch->address}}</p>
                            </div>
                            <br>
                            <div class="letter-subject">
                                <p><strong>Subject : Request to forward the LC documents to issuing bank against export LC no. {{$forwardLetter->export->lc_number}} date - {{$forwardLetter->export->date}} value ${{$forwardLetter->export->invoice_value}} as per Commercial Invoice No {{$forwardLetter->export->invoice_no}}  Dated: {{$forwardLetter->export->due_date}} ({{ $forwardLetter->shipper_bank}} Ref No: {{$forwardLetter->shipper_ref }}).</strong></p>
                            </div>
                            <div class="letter-body">
                                <p>Dear Sir</p>
                                <p>We would like to request you to forward the LC document to issuing bank aganist export LC no.  {{$forwardLetter->export->lc_number}} dated {{$forwardLetter->export->date}} value ${{$forwardLetter->export->invoice_value}} as per Commercial Invoice no {{$forwardLetter->export->invoice_no}} Dated:  {{$forwardLetter->export->due_date}} </p>
                                <p>Applicant: WINKING FASHION</p>
                                <p>Please replace Invoice, whice i have sent you</p>
                                <p style="padding-top:10px ;">Your nice corporation will be highly appreciated in this regard</p>
                            </div>
                            <div class="letter-footer">
                                <p style="padding: 30px 0px ;">Thank you</p>

                                <div class="endorse">
                                    <p><strong>Enclose:</strong></p>
                                    <ol style="margin-bottom:50px;">
                                        <li>Commercial Invoice in 4 folds</li>
                                        <li>Bill of Exchange</li>
                                    </ol>

                                    <div class="sil-area">
                                        <p class="no-margin">for on behlf of ....</p>
                                        <p class="no-margin"><strong>WINKING FASHION</strong></p>
                                        <p style="margin-top:100px;">Authorized Signature</p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function printData()
{
   var divToPrint=document.getElementById("printThisDiv");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('#printButton').on('click',function(){
printData();
})
</script>
@endsection
