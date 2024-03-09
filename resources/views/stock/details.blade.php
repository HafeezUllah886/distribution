@extends('layout.app')
@php
    $page_title = "Stock Details";
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
                    <div class="page-title"><h3>Stock Details - {{ $product->desc }}</h3></div>
                </div>
            </div>

        </header>
    </div>
</div>
<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                Opening Balance: {{ $opening_balance }}
            </div>
            <div class="col-md-3">
                Closing Balance: {{ $closing_balance }}
            </div>
            <div class="col-md-3">
                <input type="date" id="start" onchange="update({{ $product->id }})" value="{{ $start }}" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" id="end" onchange="update({{ $product->id }})" value="{{ $end }}" class="form-control">
            </div>
        </div>
        <table id="html5-extension" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $key => $stock)
                <tr>
                    <td>{{ $stock->refID }}</td>
                    <td>{{ $stock->date }}</td>
                    <td>{{ $stock->notes }}</td>
                    <td>{{ $stock->cr }}</td>
                    <td>{{ $stock->db }}</td>
                    <td>{{ $stock->balance }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection

@section('more-css')
<link rel="stylesheet" href="{{ asset('src/assets/css/light/components/modal.css') }}">
<link rel="stylesheet" href="{{ asset('src/assets/css/dark/components/modal.css') }}">

<link rel="stylesheet" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/light/table/datatable/custom_dt_miscellaneous.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/dark/table/datatable/custom_dt_miscellaneous.css') }}">

@endsection

@section('more-js')
  <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.print.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/custom_miscellaneous.js') }}"></script>

  <script>
    function update(id)
    {
        var start = $("#start").val();
        var end = $("#end").val();
        window.open("{{ url('/stocks/details/') }}/"+id+"/"+start+"/"+end, "_self");
    }
  </script>
@endsection
