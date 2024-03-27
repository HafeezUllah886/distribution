@extends('layout.app')
@php
    $page_title = "Products Summary";
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
                    <div class="page-title"><h3>Products Summary</h3></div>
                </div>
            </div>
           
        </header>
    </div>
</div>
<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <div id="chartBar" class="col-xl-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Top Sellers (Products)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area" id="chart">
                        <div id="s-bar" class=""></div>
                    </div>
                </div>
            </div>
        </div>
        <table id="html5-extension" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Purchase Qty</th>
                    <th>Purchase Amount</th>
                    <th>Sale Qty</th>
                    <th>Sale Amount</th>
                    <th>Return Qty</th>
                    <th>Return Amount</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($products as $key => $product)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$product->desc}}</td>
                        <td>{{$product->purchase_qty}}</td>
                        <td>{{$product->purchase_amount}}</td>
                        <td>{{$product->sale_qty}}</td>
                        <td>{{$product->sale_amount}}</td>
                        <td>{{$product->return_qty}}</td>
                        <td>{{$product->return_amount}}</td>
                        <td>{{$product->stock}}</td>
                    </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div>

<!--  END BREADCRUMBS  -->
@endsection

@section('more-css')

<link rel="stylesheet" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/light/table/datatable/custom_dt_miscellaneous.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/dark/table/datatable/custom_dt_miscellaneous.css') }}">
<link href="{{ asset('src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('src/plugins/css/dark/apex/custom-apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('src/plugins/css/light/apex/custom-apexcharts.css') }}" rel="stylesheet" type="text/css">

@endsection

@section('more-js')
    <script src="{{ asset('src/plugins/src/apex/apexcharts.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.print.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/custom_miscellaneous.js') }}"></script>

  <script>
    var sBar = {
            chart: {
                fontFamily: 'Nunito, Arial, sans-serif',
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                data: {!! json_encode($totalSold) !!}
            }],
            xaxis: {
                categories: {!! json_encode($productNames) !!}
            }
        }

        var updatedChart = new ApexCharts(
                document.querySelector("#s-bar"),
                sBar
            );

            // Call the render method to re-render the chart
            updatedChart.render();
  </script>
@endsection
