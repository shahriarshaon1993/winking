@extends('layout.main')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.4/apexcharts.min.css" integrity="sha512-Ax++m07N1ygXmTSeRlQZnB5leVSw9eDeHQZ2ltn7oln1U3d+6d+/u1JEZ/zY/tLtmmEL741jEnDUlmWttBPLOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- this portion is for demo only -->
<!-- <style type="text/css">

  nav.navbar a.menu-btn {
    padding: 12 !important;
  }
  .color-switcher {
      background-color: #fff;
      border: 1px solid #e5e5e5;
      border-radius: 2px;
      padding: 10px;
      position: fixed;
      top: 150px;
      transition: all 0.4s ease 0s;
      width: 150px;
      z-index: 99999;
  }
  .hide-color-switcher {
      right: -150px;
  }
  .show-color-switcher {
      right: -1px;
  }
  .color-switcher a.switcher-button {
      background: #fff;
      border-top: #e5e5e5;
      border-right: #e5e5e5;
      border-bottom: #e5e5e5;
      border-left: #e5e5e5;
      border-style: solid solid solid solid;
      border-width: 1px 1px 1px 1px;
      border-radius: 2px;
      color: #161616;
      cursor: pointer;
      font-size: 22px;
      width: 45px;
      height: 45px;
      line-height: 43px;
      position: absolute;
      top: 24px;
      left: -44px;
      text-align: center;
  }
  .color-switcher a.switcher-button i {
    line-height: 40px
  }
  .color-switcher .color-switcher-title {
      color: #666;
      padding: 0px 0 8px;
  }
  .color-switcher .color-switcher-title:after {
      content: "";
      display: block;
      height: 1px;
      margin: 14px 0 0;
      position: relative;
      width: 20px;
  }
  .color-switcher .color-list a.color {
      cursor: pointer;
      display: inline-block;
      height: 30px;
      margin: 10px 0 0 1px;
      width: 28px;
  }
  .purple-theme {
      background-color: #7c5cc4;
  }
  .green-theme {
      background-color: #1abc9c;
  }
  .blue-theme {
      background-color: #3498db;
  }
  .dark-theme {
      background-color: #34495e;
  }
</style>
<div class="color-switcher hide-color-switcher">
    <a class="switcher-button"><i class="fa fa-cog fa-spin"></i></a>
    <h5>{{trans('file.Theme')}}</h5>
    <div class="color-list">
        <a class="color purple-theme" title="purple" data-color="default.css"></a>
        <a class="color green-theme" title="green" data-color="green.css"></a>
        <a class="color blue-theme" title="blue" data-color="blue.css"></a>
        <a class="color dark-theme" title="dark" data-color="dark.css"></a>
    </div>
</div> -->
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
      <div class="row">
        <div class="container-fluid">
          <div class="col-md-12">
            <div class="brand-text float-left mt-4">
                <h3>{{trans('file.welcome')}} <span>{{Auth::user()->name}}</span> </h3>
            </div>
            <div class="filter-toggle btn-group">
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d')}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Today')}}</button>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d', strtotime(' -7 day'))}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Last 7 Days')}}</button>
              <button class="btn btn-secondary date-btn active" data-start_date="{{date('Y').'-'.date('m').'-'.'01'}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.This Month')}}</button>
              <button class="btn btn-secondary date-btn active" data-start_date="{{date('Y-m-d', strtotime('-3 month'))}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Last 3 Months')}}</button>
              <button class="btn btn-secondary date-btn active" data-start_date="{{date('Y-m-d', strtotime('-6 month'))}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Last 6 Months')}}</button>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y').'-01'.'-01'}}" data-end_date="{{date('Y').'-12'.'-31'}}">{{trans('file.This Year')}}</button>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d', strtotime('-1 year'))}}" data-end_date="{{date('Y').'-12'.'-31'}}">{{trans('file.Last Year')}}</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Counts Section -->
      <section class="dashboard-counts">
        <div class="container-fluid">
          <div class="row">
              <div class="col-md-12 form-group">
              <div class="row">
                <!-- Count item widget-->
                <div class="col-sm-3">
                    <div class="wrapper count-title text-center">
                      <div class="icon"><i class="dripicons-media-loop" style="color: #00c689"></i></div>
                      <div class="name"><strong style="color: #00c689">{{trans('Num of Total Order')}}</strong></div>
                      <div class="count-number total-order-data">{{$proforma_total_number}}</div>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center">
                    <div class="icon"><i class="dripicons-graph-bar" style="color: #733686"></i></div>
                    <div class="name"><strong style="color: #733686">{{ trans('Order Quantity') }}</strong></div>
                    <div class="count-number order-quantity-data">{{$proforma_total_quantity}} PCS</div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center">
                    <div class="icon"><i class="dripicons-return" style="color: #ff8952"></i></div>
                    <div class="name"><strong style="color: #ff8952">{{trans('Order Value')}}</strong></div>
                    <div class="count-number order-value-data">$ {{number_format((float)$proforma_total_value, 2, '.', '')}}</div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title text-center">
                    <div class="icon"><i class="dripicons-media-loop" style="color: #00c689"></i></div>
                    <div class="name"><strong style="color: #00c689">{{trans('Expense')}}</strong></div>
                    <div class="count-number expense-data">{{number_format((float)$expense, 2, '.', '')}} BDT</div>
                  </div>
                </div>
              </div>
            </div>

              {{--<div class="col-md-7 mt-4">--}}
              {{--<div class="card line-chart-example">--}}
                {{--<div class="card-header d-flex align-items-center">--}}
                  {{--<h4>{{trans('file.Cash Flow')}}</h4>--}}
                {{--</div>--}}
                {{--<div class="card-body">--}}
                  {{--@php--}}
                    {{--if($general_setting->theme == 'default.css'){--}}
                      {{--$color = '#733686';--}}
                      {{--$color_rgba = 'rgba(115, 54, 134, 0.8)';--}}
                    {{--}--}}
                    {{--elseif($general_setting->theme == 'green.css'){--}}
                        {{--$color = '#2ecc71';--}}
                        {{--$color_rgba = 'rgba(46, 204, 113, 0.8)';--}}
                    {{--}--}}
                    {{--elseif($general_setting->theme == 'blue.css'){--}}
                        {{--$color = '#3498db';--}}
                        {{--$color_rgba = 'rgba(52, 152, 219, 0.8)';--}}
                    {{--}--}}
                    {{--elseif($general_setting->theme == 'dark.css'){--}}
                        {{--$color = '#34495e';--}}
                        {{--$color_rgba = 'rgba(52, 73, 94, 0.8)';--}}
                    {{--}--}}
                  {{--@endphp--}}
                  {{--<canvas id="cashFlow" data-color = "{{$color}}" data-color_rgba = "{{$color_rgba}}" data-recieved = "{{json_encode($payment_recieved)}}" data-sent = "{{json_encode($payment_sent)}}" data-month = "{{json_encode($month)}}" data-label1="{{trans('file.Payment Recieved')}}" data-label2="{{trans('file.Payment Sent')}}"></canvas>--}}
                {{--</div>--}}
              {{--</div>--}}
            {{--</div>--}}

              {{--<div class="col-md-5 mt-4">--}}
              {{--<div class="card">--}}
                {{--<div class="card-header d-flex justify-content-between align-items-center">--}}
                  {{--<h4>{{date('F')}} {{date('Y')}}</h4>--}}
                {{--</div>--}}
                {{--<div class="pie-chart mb-2">--}}
                    {{--<canvas id="transactionChart" data-color = "{{$color}}" data-color_rgba = "{{$color_rgba}}" data-revenue={{$revenue}} data-purchase={{$purchase}} data-expense={{$expense}} data-label1="{{trans('file.Purchase')}}" data-label2="{{trans('file.revenue')}}" data-label3="{{trans('file.Expense')}}" width="100" height="95"> </canvas>--}}
                {{--</div>--}}
              {{--</div>--}}
            {{--</div>--}}

              <div class="col-md-6 mt-4">
                  <div class="card line-chart-example">
                      <div class="card-header d-flex align-items-center">
                          <h4>{{trans('Order-Flow')}}</h4>
                      </div>
                      <div class="card-body">
                          <div id="invoiceChart"></div>
                      </div>
                  </div>
              </div>

              <div class="col-md-6 mt-4">
                  <div class="card line-chart-example">
                      <div class="card-header d-flex align-items-center">
                          <h4>{{trans('Export')}}</h4>
                      </div>
                      <div class="card-body">
                          <div id="exportChart"></div>
                      </div>
                  </div>
              </div>

          </div>
        </div>


      </section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.4/apexcharts.min.js" integrity="sha512-oUoSexkALUPd0BQaO/0m029XijXQ7XlFbPIhDNvzD8r2XhUjidiRo/8YhJGpoevLZVRwRFBvygSc9jV2TagjfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    // Show and hide color-switcher
    $(".color-switcher .switcher-button").on('click', function() {
        $(".color-switcher").toggleClass("show-color-switcher", "hide-color-switcher", 300);
    });

    // Color Skins
    $('a.color').on('click', function() {
        /*var title = $(this).attr('title');
        $('#style-colors').attr('href', 'css/skin-' + title + '.css');
        return false;*/
        $.get('setting/general_setting/change-theme/' + $(this).data('color'), function(data) {
        });
        var style_link= $('#custom-style').attr('href').replace(/([^-]*)$/, $(this).data('color') );
        $('#custom-style').attr('href', style_link);
    });

    $(".date-btn").on("click", function() {
        $(".date-btn").removeClass("active");
        $(this).addClass("active");
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        $.get('dashboard-filter/' + start_date + '/' + end_date, function(data) {
            dashboardFilter(data);
        });
    });

    function dashboardFilter(data){


        $('.total-order-data').hide();
        $('.total-order-data').html(parseInt(data[6]));
        $('.total-order-data').show(500);

        $('.order-quantity-data').hide();
        $('.order-quantity-data').html(parseInt(data[4])+' PCS');
        $('.order-quantity-data').show(500);

        $('.order-value-data').hide();
        $('.order-value-data').html('$ '+parseFloat(data[5]).toFixed(2));
        $('.order-value-data').show(500);

        $('.expense-data').hide();
        $('.expense-data').html(parseFloat(data[7]).toFixed(2)+' BDT');
        $('.expense-data').show(500);
    }
</script>

    {{-- Invoice --}}
    <script>
        var options = {
            series: [{
                name: 'Quantity (PCS)',
                data: {!!json_encode($monthproformaInvoicQuantity)!!}
            }, {
                name: 'Value ($)',
                data: {!!json_encode($monthproformaInvoictotalAmount)!!}
            }],
            chart: {
                type: 'bar',
                height: 350,

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!!json_encode($proformaInvoicMonths)!!},
            },
            yaxis: {
                "labels": {
                    "formatter": function (val) {
                        return val.toFixed(0)
                    }
                },

            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toFixed(2)
                    }
                }
            },
            colors : ['#7C5CC6', '#f74d2e'],
        };

        var chart = new ApexCharts(document.querySelector("#invoiceChart"), options);
        chart.render();













    </script>

    {{--export--}}
    <script>
        var options = {
            series: [{
                name: 'Quantity (PCS)',
                data: {!!json_encode($exportQuantityPcs)!!}
            }, {
                name: 'Value ($)',
                data: {!!json_encode($exportInvoiceValue)!!}
            }],
            chart: {
                type: 'bar',
                height: 350,

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!!json_encode($exportMonth)!!},
            },
            yaxis: {
                "labels": {
                    "formatter": function (val) {
                        return val.toFixed(0)
                    }
                },

            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toFixed(2)
                    }
                }
            },
            colors : ['#7C5CC6', '#f74d2e'],
        };

        var chart = new ApexCharts(document.querySelector("#exportChart"), options);
        chart.render();

    </script>




@endsection

