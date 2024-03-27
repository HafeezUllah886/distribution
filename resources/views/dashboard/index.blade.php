@extends('layout.app')
@php
    $page_title = "Dashboard";
@endphp
@section('content')
 <!--  BEGIN BREADCRUMBS  -->
 <div class="secondary-nav">
    <div class="breadcrumbs-container" data-page-heading="Sales">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </a>
            <div class="d-flex breadcrumb-content">
                <div class="page-header">

                    <div class="page-title"><h3>Dashboard</h3></div>

                </div>
            </div>
        </header>
    </div>
</div>
<div class="row layout-top-spacing g-2">
        <div class="col-md-6">
            <div class="widget widget-chart-three">
                <div class="widget-heading">
                    <div class="">
                        <h5 class="">Sales vs Expenses (Last 10 days)</h5>
                    </div>
                </div>
                <div class="widget-content">
                    <div id="uniqueVisits"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-2">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Reminders</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Due</span> {{reminder()}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Customer Dues</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Rs.</span> {{customer_dues()}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Total Stock</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Nos.</span>  {{stock('totalStock')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Stock Value</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Rs.</span> {{stock('totalValue')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Expense (This Month)</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Rs.</span> {{expenseThisMonth()}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Profit / Loss</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Rs.</span> {{profit()}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Cash Balance</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Rs.</span> {{cash_balance()}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Bank Balance</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Rs.</span> {{bank_balance()}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value" style="font-size:15px;">Cheque Balance</h6>
                                </div>
                            </div>
                            <div class="w-content mt-2">
                                <div class="w-info">
                                    <p class="value" style="font-size:15px;"> <span>Rs.</span> {{cheque_balance()}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
<!--  END BREADCRUMBS  -->
@endsection
@section('more-css')
     <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
     <link href="{{ asset('src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">

     <link href="{{ asset('src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('src/plugins/css/light/apex/custom-apexcharts.css') }}" rel="stylesheet" type="text/css">

     <link href="{{ asset('src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('src/plugins/css/dark/apex/custom-apexcharts.css') }}" rel="stylesheet" type="text/css">

     <link href="{{ asset('src/assets/css/light/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('src/assets/css/dark/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />

     <link href="{{ asset('src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />

     <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
@endsection
@section('more-js')
<script src="{{ asset('src/assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('src/plugins/src/apex/apexcharts.min.js') }}"></script>
<script>
    var Theme = 'dark';

      Apex.tooltip = {
          theme: Theme
      }
        var d_1options1 = {
      chart: {
          height: 350,
          type: 'bar',
          toolbar: {
            show: false,
          }
      },
      colors: ['#622bd7', '#ffbb44'],
      plotOptions: {
          bar: {
              horizontal: false,
              columnWidth: '55%',
              endingShape: 'rounded',
              borderRadius: 10,

          },
      },
      dataLabels: {
          enabled: false
      },
      legend: {
          position: 'bottom',
          horizontalAlign: 'center',
          fontSize: '14px',
          markers: {
              width: 10,
              height: 10,
              offsetX: -5,
              offsetY: 0
          },
          itemMargin: {
              horizontal: 10,
              vertical: 8
          }
      },
      grid: {
        /* borderColor: '#AEADAD', */
      },
      stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
      },
      series: [{
          name: 'Sales',
          data: {!! json_encode($sales) !!}
      }, {
          name: 'Expenses',
          data: {!! json_encode($expenses) !!}
      }],
      xaxis: {
          categories: {!! json_encode($dates) !!},
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: Theme,
          type: 'vertical',
          shadeIntensity: 0.3,
          inverseColors: false,
          opacityFrom: 1,
          opacityTo: 0.8,
          stops: [0, 100]
        }
      },
      tooltip: {
          marker : {
              show: false,
          },
          theme: Theme,
          y: {
              formatter: function (val) {
                  return val
              }
          }
      },
      responsive: [
          {
              breakpoint: 767,
              options: {
                  plotOptions: {
                      bar: {
                          borderRadius: 0,
                          columnWidth: "50%"
                      }
                  }
              }
          },
      ]
      }

        var d_1C_3 = new ApexCharts(
          document.querySelector("#uniqueVisits"),
          d_1options1
      );
      d_1C_3.render();
</script>
@endsection
