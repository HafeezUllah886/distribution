@extends('layout.app')
@php
    $page_title = "Return Details";
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
                                                    <p class="inv-list-number "><span class="inv-title">ReturnID : </span> <span class="inv-number">{{ $return->id }}</span></p>
                                                    <p class="inv-created-date "><span class="inv-title">Date : </span> <span class="inv-date">{{ date('d M Y', strtotime($return->date)) }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--detail-section inv--customer-detail-section">
                                            <div class="row">
                                                <div class="col-12 align-self-center">
                                                    <p class="inv-to">Details</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="inv-customer-name">Order Booker: {{$return->orderbooker->name}}</p>
                                                    <p class="inv-street-addr">Customer: {{$return->customer->name}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--product-table-section p-0 table-responsive ml-1 mr-1">
                                           <table class="table">
                                            <thead>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th>Reason</th>
                                                <th>CTN</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th class="text-end">Sub-Total</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($return->details as $key => $product)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$product->product->desc}}</td>
                                                    <td>{{$product->reason}}</td>
                                                    <td>{{number_format($product->qty / $product->product->p_size,1)}}</td>
                                                    <td>{{$product->qty}}</td>
                                                    <td>{{number_format($product->price, 2)}}</td>
                                                    <td class="text-end">{{number_format($product->amount,0)}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <th colspan="6" class="text-end">Total</th>
                                                <th class="text-end">{{number_format($return->details->sum('amount'),0)}}</th>
                                            </tfoot>
                                           </table>
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
                                <div class="col-xl-12 col-md-3 col-sm-6">
                                    <a href="{{route('saleReturnDelete', $return->id)}}" class="btn btn-danger btn-print">Delete</a>
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

