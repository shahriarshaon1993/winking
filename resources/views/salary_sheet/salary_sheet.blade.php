<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/favicon.png" rel="icon"/>
    <title>Salary Sheet</title>
    <meta name="author" content="harnishdesign.net">

    <!-- Web Fonts
    ======================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900'
          type='text/css'>

    <!-- Stylesheet
    ======================= -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(() => {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
            @endif

        });
    </script>
    <style>
        body {
            /* background: #FFFFF2; */
            color: #535b61;
            /* font-family: "Poppins", sans-serif; */
            font-size: 13px;
            line-height: 22px;
        }

        .bg-imge {
            /* background-image: url("{{ asset('img/invoice_img/main.PNG') }}"); */
            background-repeat: no-repeat;
            background-position: center;
            z-index: 1;
            background-size: 100% 100%;
        }

        .footer {
            height: 120px;
            /* background-image: url("img/footer.PNG"); */
            background-repeat: no-repeat;
            background-position: center;
        }

        form {
            padding: 0;
            margin: 0;
            display: inline;
        }

        img {
            vertical-align: inherit;
        }

        a,
        a:focus {
            color: #0071cc;
            text-decoration: none;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        a:hover,
        a:active {
            color: #005da8;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        a:focus,
        a:active,
        .btn.active.focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn:active:focus,
        .btn:focus,
        button:focus,
        button:active {
            outline: none;
        }

        p {
            line-height: 1.9;
        }

        blockquote {
            border-left: 5px solid #eee;
            padding: 10px 20px;
        }

        iframe {
            border: 0 !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #0c2f54;
        }

        .table {
            color: #535b61;
        }

        .table-hover tbody tr:hover {
            background-color: #f6f7f8;
        }

        .text-center{
            text-align: center;
        }

        /* =================================== */
        /*  Helpers Classes
    /* =================================== */
        /* Border Radius */

        .top-header {
            height: 90px;
            /* background-image: url("{{ asset('img/invoice_img/header.png') }}"); */
            background-repeat: no-repeat;
            background-position: center;
            object-fit: cover;
            background-size: 100%;
        }

        .rounded-top-0 {
            border-top-left-radius: 0px !important;
            border-top-right-radius: 0px !important;
        }

        .rounded-bottom-0 {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .rounded-left-0 {
            border-top-left-radius: 0px !important;
            border-bottom-left-radius: 0px !important;
        }

        .rounded-right-0 {
            border-top-right-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        /* Text Size */
        .text-0 {
            font-size: 11px !important;
            font-size: 0.6875rem !important;
        }

        .text-1 {
            font-size: 12px !important;
            font-size: 0.75rem !important;
        }

        .text-2 {
            font-size: 14px !important;
            font-size: 0.875rem !important;
        }

        .text-3 {
            font-size: 16px !important;
            font-size: 1rem !important;
        }

        .text-4 {
            font-size: 18px !important;
            font-size: 1.125rem !important;
        }

        .text-5 {
            font-size: 21px !important;
            font-size: 1.3125rem !important;
        }

        .text-6 {
            font-size: 24px !important;
            font-size: 1.50rem !important;
        }

        .text-7 {
            font-size: 28px !important;
            font-size: 1.75rem !important;
        }

        .text-8 {
            font-size: 32px !important;
            font-size: 2rem !important;
        }

        .text-9 {
            font-size: 36px !important;
            font-size: 2.25rem !important;
        }

        .text-10 {
            font-size: 40px !important;
            font-size: 2.50rem !important;
        }

        .text-11 {
            font-size: calc(1.4rem + 1.8vw) !important;
        }

        @media (min-width: 1200px) {
            .text-11 {
                font-size: 2.75rem !important;
            }
        }

        .text-12 {
            font-size: calc(1.425rem + 2.1vw) !important;
        }

        @media (min-width: 1200px) {
            .text-12 {
                font-size: 3rem !important;
            }
        }

        .text-13 {
            font-size: calc(1.45rem + 2.4vw) !important;
        }

        @media (min-width: 1200px) {
            .text-13 {
                font-size: 3.25rem !important;
            }
        }

        .text-14 {
            font-size: calc(1.475rem + 2.7vw) !important;
        }

        @media (min-width: 1200px) {
            .text-14 {
                font-size: 3.5rem !important;
            }
        }

        .text-15 {
            font-size: calc(1.5rem + 3vw) !important;
        }

        @media (min-width: 1200px) {
            .text-15 {
                font-size: 3.75rem !important;
            }
        }

        .text-16 {
            font-size: calc(1.525rem + 3.3vw) !important;
        }

        @media (min-width: 1200px) {
            .text-16 {
                font-size: 4rem !important;
            }
        }

        .text-17 {
            font-size: calc(1.575rem + 3.9vw) !important;
        }

        @media (min-width: 1200px) {
            .text-17 {
                font-size: 4.5rem !important;
            }
        }

        .text-18 {
            font-size: calc(1.625rem + 4.5vw) !important;
        }

        @media (min-width: 1200px) {
            .text-18 {
                font-size: 5rem !important;
            }
        }

        .text-19 {
            font-size: calc(1.65rem + 4.8vw) !important;
        }

        @media (min-width: 1200px) {
            .text-19 {
                font-size: 5.25rem !important;
            }
        }

        .text-20 {
            font-size: calc(1.7rem + 5.4vw) !important;
        }

        @media (min-width: 1200px) {
            .text-20 {
                font-size: 5.75rem !important;
            }
        }

        .text-21 {
            font-size: calc(1.775rem + 6.3vw) !important;
        }

        @media (min-width: 1200px) {
            .text-21 {
                font-size: 6.5rem !important;
            }
        }

        .text-22 {
            font-size: calc(1.825rem + 6.9vw) !important;
        }

        @media (min-width: 1200px) {
            .text-22 {
                font-size: 7rem !important;
            }
        }

        .text-23 {
            font-size: calc(1.9rem + 7.8vw) !important;
        }

        @media (min-width: 1200px) {
            .text-23 {
                font-size: 7.75rem !important;
            }
        }

        .text-24 {
            font-size: calc(1.95rem + 8.4vw) !important;
        }

        @media (min-width: 1200px) {
            .text-24 {
                font-size: 8.25rem !important;
            }
        }

        .text-25 {
            font-size: calc(2.025rem + 9.3vw) !important;
        }

        @media (min-width: 1200px) {
            .text-25 {
                font-size: 9rem !important;
            }
        }

        /* Line height */
        .line-height-07 {
            line-height: 0.7 !important;
        }

        .line-height-1 {
            line-height: 1 !important;
        }

        .line-height-2 {
            line-height: 1.2 !important;
        }

        .line-height-3 {
            line-height: 1.4 !important;
        }

        .line-height-4 {
            line-height: 1.6 !important;
        }

        .line-height-5 {
            line-height: 1.8 !important;
        }

        /* Font Weight */
        .fw-100 {
            font-weight: 100 !important;
        }

        .fw-200 {
            font-weight: 200 !important;
        }

        .fw-300 {
            font-weight: 300 !important;
        }

        .fw-400 {
            font-weight: 400 !important;
        }

        .fw-500 {
            font-weight: 500 !important;
        }

        .fw-600 {
            font-weight: 600 !important;
        }

        .fw-700 {
            font-weight: 700 !important;
        }

        .fw-800 {
            font-weight: 800 !important;
        }

        .fw-900 {
            font-weight: 900 !important;
        }

        /* Opacity */
        .opacity-0 {
            opacity: 0;
        }

        .opacity-1 {
            opacity: 0.1;
        }

        .opacity-2 {
            opacity: 0.2;
        }

        .opacity-3 {
            opacity: 0.3;
        }

        .opacity-4 {
            opacity: 0.4;
        }

        .opacity-5 {
            opacity: 0.5;
        }

        .opacity-6 {
            opacity: 0.6;
        }

        .opacity-7 {
            opacity: 0.7;
        }

        .opacity-8 {
            opacity: 0.8;
        }

        .opacity-9 {
            opacity: 0.9;
        }

        .opacity-10 {
            opacity: 1;
        }

        /* Background light */
        .bg-light {
            background-color: #FFF !important;
        }

        .bg-light-1 {
            background-color: #f9f9fb !important;
        }

        .bg-light-2 {
            background-color: #f8f8fa !important;
        }

        .bg-light-3 {
            background-color: #f5f5f5 !important;
        }

        .bg-light-4 {
            background-color: #eff0f2 !important;
        }

        .bg-light-5 {
            background-color: #ececec !important;
        }

        hr {
            opacity: 0.15;
        }

        .card-header {
            padding-top: .75rem;
            padding-bottom: .75rem;
        }

        /* Table */
        .table > :not(:last-child) > :last-child > * {
            border-bottom-color: inherit;
        }

        .table:not(.table-sm) > :not(caption) > * > * {
            padding: 0.75rem;
        }

        .table-sm > :not(caption) > * > * {
            padding: 0.3rem;
        }

        @media print {

            .table td,
            .table th {
                background-color: transparent !important;
            }

            .table td.bg-light,
            .table th.bg-light {
                background-color: #FFF !important;
            }

            .table td.bg-light-1,
            .table th.bg-light-1 {
                background-color: #f9f9fb !important;
            }

            .table td.bg-light-2,
            .table th.bg-light-2 {
                background-color: #f8f8fa !important;
            }

            .table td.bg-light-3,
            .table th.bg-light-3 {
                background-color: #f5f5f5 !important;
            }

            .table td.bg-light-4,
            .table th.bg-light-4 {
                background-color: #eff0f2 !important;
            }

            .table td.bg-light-5,
            .table th.bg-light-5 {
                background-color: #ececec !important;
            }
        }

        /* =================================== */
        /*  Layouts
    /* =================================== */
        .invoice-container {
            padding: 0 70px 0 70px;
            max-width: 100%;
            background-color: #fff;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            -o-border-radius: 6px;
        }

        @media (max-width: 767px) {
            .invoice-container {
                padding: 35px 20px 70px 20px;
                margin-top: 0px;
                border: none;
                border-radius: 0px;
            }
        }

        /* =================================== */
        /*  Extras
    /* =================================== */
        .bg-primary,
        .badge-primary {
            background-color: #0071cc !important;
        }

        .bg-secondary {
            background-color: #0c2f55 !important;
        }

        .text-secondary {
            color: #0c2f55 !important;
        }

        .text-primary {
            color: #0071cc !important;
        }

        .btn-link {
            color: #0071cc;
        }

        .btn-link:hover {
            color: #005da8 !important;
        }

        .border-primary {
            border-color: #0071cc !important;
        }

        .border-secondary {
            border-color: #0c2f55 !important;
        }

        .btn-primary {
            background-color: #0071cc;
            border-color: #0071cc;
        }

        .btn-primary:hover {
            background-color: #005da8;
            border-color: #005da8;
        }

        .btn-secondary {
            background-color: #0c2f55;
            border-color: #0c2f55;
        }

        .btn-outline-primary {
            color: #0071cc;
            border-color: #0071cc;
        }

        .btn-outline-primary:hover {
            background-color: #0071cc;
            border-color: #0071cc;
            color: #fff;
        }

        .btn-outline-secondary {
            color: #0c2f55;
            border-color: #0c2f55;
        }

        .btn-outline-secondary:hover {
            background-color: #0c2f55;
            border-color: #0c2f55;
            color: #fff;
        }

        .progress-bar,
        .nav-pills .nav-link.active,
        .nav-pills .show > .nav-link {
            background-color: #0071cc;
        }

        .page-item.active .page-link,
        .custom-radio .custom-control-input:checked ~ .custom-control-label:before,
        .custom-control-input:checked ~ .custom-control-label::before,
        .custom-checkbox .custom-control-input:checked ~ .custom-control-label:before,
        .custom-control-input:checked ~ .custom-control-label:before {
            background-color: #0071cc;
            border-color: #0071cc;
        }

        .list-group-item.active {
            background-color: #0071cc;
            border-color: #0071cc;
        }

        .page-link {
            color: #0071cc;
        }

        .page-link:hover {
            color: #005da8;
        }

        /* Pagination */
        .page-link {
            border-color: #f4f4f4;
            border-radius: 0.25rem;
            margin: 0 0.3rem;
        }

        .page-item.disabled .page-link {
            border-color: #f4f4f4;
        }

        .text-sm-end {
            text-align: end;
        }

        .address-bar {
            display: flex;
            justify-content: space-between;
        }

        @media screen and (max-width: 480px){
            .address-bar {
                flex-direction: column;
            }
        }

        .table td, .table th {
            padding: 0;
        }
        .table th{
            text-align: center;
        }
    </style>

</head>
<body>
<!-- Container -->
    <div class="container-fluid invoice-container">
        <!-- Header -->
        <header class="top-header"></header>

        <!-- Main Content -->
        @if(Session::get('success'))
        <div class="alert alert-success">
            <strong>Success!</strong> {{ session::get('success') }}
        </div>
        @endif
        <main class="bg-imge">
            <!-- <div class="text-center">
                <h2>WINKING FASHION</h2>
                <h5> HOUSE#128, ROAD#01, BARIDHARA DOHS, DHAKA-1206, BANGLADESH</h5>
            </div><br> -->
            <form action="{{ route('salary-sheet.confirm') }}" method="POST">
                @csrf
            <div class="col">
                <div class="float-right text-right">
                  
                    <h5 class="mt-4">Salary Sheet</h5>
                    <h6 class="d-flex"><span style="margin-right:20px;">Date:</span> <input type="date" name="date" value="" class="form-control" id="date" required></h6>
                </div>
            </div>
            <div>
                <table style="width: 1600px; overflow-x:scroll" class="table table-bordered table-responsive">
                    <tr>
                        <th rowspan="2">SL</th>
                        <th rowspan="2" style="width:200px">Name</th>
                        <th rowspan="2" style="width:120px">Designation</th>
                        <td  rowspan="2" style="width:120px">Basic</td>
                        <th colspan="3">Allowances</th>
                        <th rowspan="2" style="width:120px">Gross Salary</th>
                        <th rowspan="2" style="width:100px">Absent</th>
                        <th rowspan="2" style="width:120px">Deduction</th>
                        <th rowspan="2" style="width:150px">Net Pay</th>
                        <th rowspan="2" style="width:150px">Status</th>
                        <th rowspan="2" style="width:150px">Payment Received Date</th>
                    </tr>
                    <tr>
                        <td style="width:120px">H.rent</td>
                        <td style="width:120px">Medical</td>
                        <td style="width:120px">Conveyance</td>
                    </tr>
                    @foreach ($employees as $key=>$employee)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            {{ $employee->name }}
                            <input type="hidden" name="employee_id[]" value="{{ $employee->id }}">
                            <input type="hidden" name="salary_sheet_setting" value="{{ $salarySetting->id }}">
                        </td>
                        <td>{{ $employee->designation != NULL ? $employee->designation : '' }}</td>

                        <?php
                            $hRent= ($employee->present_salary*$salarySetting->h_rent)/100;
                            $medical= ($employee->present_salary*$salarySetting->medical)/100;
                            $tPort= ($employee->present_salary*$salarySetting->t_port)/100;
                            $basicSalary= $employee->present_salary - ($hRent + $medical + $tPort);
                        ?>
                        <td>
                            <input type="number" name="basic[]" value="{{ $basicSalary }}" class="form-control" readonly>
                        </td>
                        
                        <td>
                            <input type="number" name="h_rent[]" value="{{ $hRent }}" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="number" name="medical[]" value="{{ $medical }}" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="number" name="t_port[]" value="{{ $tPort }}" class="form-control" readonly>
                        </td>
                        <td><input type="number" name="gross_salary[]" value="{{ $employee->present_salary }}" class="form-control" id="gross_salary_{{ $key }}" readonly></td>
                        <td>
                            <input type="number" name="absent[]" id="absent_{{ $key }}" value="0" class="form-control" oninput="getNetPay({{ $key }})">
                        </td>
                        <td>
                            <input type="number" name="deduction[]" value="0" step="any" class="form-control" id="deduction_{{ $key }}">
                        </td>
                        <td><input type="number" name="net_pay[]" value="{{ $employee->present_salary }}" step="any" class="form-control" id="net_pay_{{ $key }}"></td>
                        <td>
                            <input type="text" name="status[]" class="form-control">
                        </td>
                        <td>
                            <input type="date" name="payment_received_date[]" class="form-control">
                        </td>
                    </tr>
                    @endforeach
                    <img style="width:200px;padding:20px 0px;" src="{{asset('public/logo/'.$general_setting->site_logo)}}" alt=""> <br>
                    <input type="submit" value="Confirm Salary Sheet" class="btn btn-primary">
                </form>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

<script>
function getDaysInMonth(year, month) {
  return new Date(year, month, 0).getDate();
}

function getNetPay(i) {
    var inputDate = document.getElementById("date")
    const absent = document.getElementById("absent_"+i);
    // alert(i);
    var date= new Date(inputDate.value);
    var year= date.getFullYear();
    var month= date.getMonth()+1;
    var gross_salary= document.getElementById("gross_salary_"+i).value;
    var net_pay= document.getElementById("net_pay_"+i).value;
    var days= getDaysInMonth(year, month);

    var deduction= (gross_salary/days)*absent.value;

    document.getElementById("deduction_"+i).value=deduction.toFixed(2);
    document.getElementById("net_pay_"+i).value= gross_salary - deduction.toFixed(2);

};


</script>

{{-- @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script> --}}
    <!--server side users table script-->

{{-- @endpush --}}

