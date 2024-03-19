@extends('layout.app')
@php
    $page_title = "Sales History";
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
                    <div class="page-title"><h3>Sales</h3></div>
                </div>
            </div>
            <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                <li class="nav-item more-dropdown ">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Create New</button>
                </li>
            </ul>
        </header>
    </div>
</div>
<div class="card mt-2">
    <div class="card-body">
        <table id="html5-extension" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($sales as $key => $sale)
                @php
                    $amount = $sale->details->sum('amount');
                    $paid = $sale->payments->sum('amount');
                    $due = ($amount - $paid);
                    $total += $amount;
                @endphp
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ date("d M Y", strtotime($sale->date)) }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $amount }}</td>
                    <td>{{ $paid }}</td>
                    <td>{{ $due }}</td>
                    <td>
                        @if ($due > 0)
                            <span class="badge badge-danger">Due</span>
                        @else
                            <span class="badge badge-success">Paid</span>
                        @endif
                    </td>
                    
                    <td class="text-center d-flex justify-content-center align-items-center">
                        <div class="dropdown" style="position:absolute !important; z-index:1000;">
                            <a class="dropdown-toggle" href="#" role="button" id="action_{{ $key }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="action_{{ $key }}">
                                <a class="dropdown-item" href="{{ route('saleView', $sale->id) }}">View</a>
                                <a class="dropdown-item" href="#" onclick="viewPayment('{{$sale->id}}')">View Payment</a>
                                @if($due > 0)
                                    <a class="dropdown-item" href="#" onclick="createPayment('{{$sale->id}}', {{$due}})">Create Payment</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('saleCreate') }}" method="get">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mt-2">
                        <label for="customer">Customer </label>
                        <select name="customer" required id="customer" class="form-control">
                            @foreach ($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}} - {{$customer->channel}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="viewPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Payments - <span id="viewPaymentTitle"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <th>Date</th>
                            <th>Account</th>
                            <th>Notes</th>
                            <th>Amount</th>
                            <th></th>
                        </thead>
                        <tbody id="viewPaymentTable">
                            
                        </tbody>
                    </table>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div> --}}
        </div>
    </div>
</div>

<div class="modal fade" id="createPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('salePaymentStore') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="salesID" id="salesID" value="">
                    <div class="form-group">
                        <label for="account">Account </label>
                        <select name="accountID" required id="account" class="form-control">
                            @foreach ($accounts as $account)
                                <option value="{{$account->id}}">{{$account->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" step="any" id="amount" required class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  END BREADCRUMBS  -->

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
    function viewPayment(id)
    {
        $.ajax({
            url : "{{url('/sale/payments/view/')}}/"+id,
            method : "GET",
            success : function (payments){
                var paymentHTML = "";
                $.each(payments, function(index, payment) {
                    paymentHTML += '<tr id="row_'+payment.refID+'">';
                    paymentHTML += '<td>'+payment.date+'</td>';
                    paymentHTML += '<td>'+payment.account.name+'</td>';
                    paymentHTML += '<td>'+payment.notes+'</td>';
                    paymentHTML += '<td>'+payment.amount+'</td>';
                    paymentHTML += '<td><a href="#" onclick="paymentDelete('+payment.refID+')">@svg("eos-delete", "text-danger")</a></td>';
                    paymentHTML += '</tr>';
                });
                $("#viewPaymentTable").html(paymentHTML);
                $("#viewPaymentTitle").text(id);
                $("#viewPayment").modal('show');
            }
        });
    }

    function paymentDelete(ref)
    {
        $.ajax({
            url : "{{url('/sale/payments/delete/')}}/"+ref,
            method : "GET",
            success : function (){
                location.reload();
            }
        });
    }

    function createPayment(id, amount)
    {
        $("#salesID").val(id);
        $("#amount").val(amount);
        $("#amount").prop("max", amount);
        $("#createPayment").modal('show');
    }
  </script>
@endsection
