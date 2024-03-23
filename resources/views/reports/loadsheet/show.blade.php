@extends('layout.app')
@php
    $page_title = "Sale Details";
@endphp
@section('content')
<div class="row invoice layout-top-spacing layout-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="doc-container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="invoice-container">
                        <div class="invoice-inbox">
                            <div id="ct" class="">
                                <div class="invoice-00001">
                                    <div class="content-section">
                                        <div class="inv--head-section inv--detail-section mb-1">
                                            <div class="row">
                                                <div class="col-sm-6 col-12 mr-auto">
                                                    <div class="d-flex">
                                                        <h3 class="in-heading">KK TRADERS</h3>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 text-sm-end">
                                                    <p class="inv-list-number "><span class="inv-title">Load Sheet</span></p>
                                                    <p class="inv-created-date "><span class="inv-title">Date : </span> <span class="inv-date">{{ date('d M Y', strtotime($salesData['date'])) }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--detail-section inv--customer-detail-section">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                    {{-- <p class="inv-to">Details</p> --}}
                                                </div>
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 text-sm-end mt-sm-0 mt-5">
                                                    <h6 class=" inv-title"></h6>
                                                </div>
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                    <p class="inv-customer-name">Order Booker: {{$salesData['orderbooker']}}</p>
                                                    
                                                </div>
                                              
                                            </div>
                                        </div>
                                        <div class="inv--product-table-section p-0 table-responsive">
                                           <table class="table">
                                            <thead>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>CTN</th>
                                                <th class="text-end">Amount</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total_amount = 0;
                                                @endphp
                                                @foreach ($salesData['sale_details'] as $key => $productDetails)
                                                @php
                                                    $total_amount += $productDetails['total_amount'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $productDetails['code'] ?? 'N/A' }}</td>
                                                    <td>{{ $productDetails['description'] ?? 'N/A' }}</td> 
                                                    <td>{{ $productDetails['total_qty'] }}</td>
                                                    <td>{{ number_format($productDetails['total_qty'] / $productDetails['pack_size'], 2)}}</td>
                                                    <td class="text-end">{{ number_format($productDetails['total_amount'], 2) }}</td>  </tr>
                                                @endforeach
                                            </tbody>
                                           </table>
                                        </div>
                                        <div class="inv--total-amounts">          
                                            <div class="row mt-4">
                                                {{-- <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                </div> --}}
                                                <div class="col-12 order-sm-1 order-0">
                                                    <div class="text-sm-end">
                                                        <div class="row">
                                                            <div class="col-sm-10 col-7">
                                                                <p class="">Total:</p>
                                                            </div>
                                                            <div class="col-sm-2 col-5">
                                                                <p class="">{{number_format($total_amount,2)}}</p>
                                                            </div>
                                                            <div class="col-sm-10 col-7">
                                                                <p class=" discount-rate">Received :</p>
                                                            </div>
                                                            <div class="col-sm-2 col-5">
                                                                <p class="">{{number_format($salesData['total_sale_amount'],2)}}</p>
                                                            </div>
                                                           
                                                            <div class="col-sm-10 col-7">
                                                                <h5 class="">Remaining : </h5>
                                                            </div>
                                                            <div class="col-sm-2 col-5">
                                                                <h5 class="">{{number_format($total_amount - $salesData['total_sale_amount'])}}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="invoice-actions-btn">
                        <div class="invoice-action-btn">
                            <div class="row">
                                <div class="col-xl-12 col-md-3 col-sm-6">
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-print action-print">Print</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('more-css')
    <link rel="stylesheet" href="{{ asset('src/assets/css/light/apps/invoice-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/dark/apps/invoice-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <style>
        .details td{
            padding: 5px 25px !important;
        }
    </style>
@endsection
@section('more-js')
<script src="{{ asset('src/assets/js/apps/invoice-preview.js') }}"></script>
@endsection

