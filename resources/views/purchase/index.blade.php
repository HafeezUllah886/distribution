@extends('layout.app')
@php
    $page_title = "Purchase History";
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
                    <div class="page-title"><h3>Purchases</h3></div>
                </div>
            </div>
            <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                <li class="nav-item more-dropdown ">
                   <a href="{{route('purchaseCreate')}}" class="btn btn-primary">Create New</a>
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
                    <th>Vendor</th>
                    <th>Amount</th>
                    <th>Shipping Cost</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($purchases as $key => $purchase)
                @php
                    $amount = $purchase->details->sum('amount');
                    $total += $amount
                @endphp
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td>{{ date("d M Y", strtotime($purchase->date)) }}</td>
                    <td>{{ $purchase->vendor->name }}</td>
                    <td>{{ $amount }}</td>
                    <td>{{ $purchase->shippingCost }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center">
                        <a href="{{route('purchaseView', $purchase->id)}}" class="text-info">View</a>
                        {{-- <div class="dropdown" style="position:absolute !important; z-index:1000;">
                            <a class="dropdown-toggle" href="#" role="button" id="action_{{ $key }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="action_{{ $key }}">
                                <a class="dropdown-item" href="{{ route('purchaseView', $purchase->id) }}">View</a>
                               
                            </div>
                        </div> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--  END BREADCRUMBS  -->

@endsection
