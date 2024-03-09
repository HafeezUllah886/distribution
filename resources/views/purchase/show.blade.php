@extends('layout.app')
@php
    $page_title = "Purchase Details";
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
                                                    <p class="inv-list-number "><span class="inv-title">PurchaseID : </span> <span class="inv-number">{{ $purchase->id }}</span></p>
                                                    <p class="inv-created-date "><span class="inv-title">Date : </span> <span class="inv-date">{{ date('d M Y', strtotime($purchase->date)) }}</span></p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="inv--detail-section inv--customer-detail-section">
    
                                            <div class="row">

                                                <div class="col-12 align-self-center">
                                                    <p class="inv-to">Purchased From</p>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <p class="inv-customer-name">{{$purchase->vendor->name}}</p>
                                                    <p class="inv-street-addr">{{$purchase->vendor->b_name}}</p>
                                                    <p class="inv-street-addr">{{$purchase->vendor->address}}</p>
                                                    <p class="inv-email-address">{{$purchase->vendor->contact}}</p>
                                                </div>

                                            </div>
                                            
                                        </div>
                                        <div class="inv--product-table-section p-0">
                                           <table class="table">
                                            <thead>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Value</th>
                                                <th>Discount</th>
                                                <th>GST</th>
                                                <th>FST</th>
                                                <th class="text-end">Sub-Total</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase->details as $key => $product)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$product->product->desc}}</td>
                                                    <td>{{$product->qty}}</td>
                                                    <td>{{number_format($product->price, 2)}}</td>
                                                    <td>{{number_format($product->value, 2)}}</td>
                                                    <td>{{number_format($product->discount_val,2)}}({{$product->discount_per}}%)</td>
                                                    <td>{{number_format($product->gst_val,2)}}({{$product->gst_per}}%)</td>
                                                    <td>{{number_format($product->fst_val,2)}}({{$product->fst_per}}%)</td>
                                                    <td class="text-end">{{number_format($product->amount,2)}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <th colspan="4" class="text-end">Total</th>
                                                <th>{{number_format($purchase->details->sum('value'),2)}}</th>
                                                <th>{{number_format($purchase->details->sum('discount_val'),2)}}</th>
                                                <th>{{number_format($purchase->details->sum('gst_val'),2)}}</th>
                                                <th>{{number_format($purchase->details->sum('fst_val'),2)}}</th>
                                                <th class="text-end">{{number_format($purchase->details->sum('amount'),2)}}</th>
                                            </tfoot>
                                           </table>
                                        </div>
                                        <div class="inv--total-amounts">
                                                            
                                            <div class="row mt-4">
                                                <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                </div>
                                                <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                    <div class="text-sm-end">
                                                        <div class="row">
                                                            <div class="col-sm-8 col-7">
                                                                <p class="">Sub Total :</p>
                                                            </div>
                                                            <div class="col-sm-4 col-5">
                                                                <p class="">{{number_format($purchase->details->sum('amount'),2)}}</p>
                                                            </div>
                                                            <div class="col-sm-8 col-7">
                                                                <p class=" discount-rate">Shipping :</p>
                                                            </div>
                                                            <div class="col-sm-4 col-5">
                                                                <p class="">{{number_format($purchase->shippingCost,2)}}</p>
                                                            </div>
                                                            <div class="col-sm-8 col-7 grand-total-title mt-3">
                                                                <h4 class="">Grand Total : </h4>
                                                            </div>
                                                            <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                                                <h4 class="">{{number_format($purchase->details->sum('amount') + $purchase->shippingCost,2)}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="inv--note">

                                            <div class="row mt-4">
                                                <div class="col-sm-12 col-12 order-sm-0 order-1">
                                                    <p>Purchase Notes: {{ $purchase->notes }}</p>
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
                                <div class="col-xl-12 col-md-3 col-sm-6">
                                    <a href="#" class="btn btn-info btn-print action-print">Edit</a>
                                </div>
                                <div class="col-xl-12 col-md-3 col-sm-6">
                                    <a href="#" class="btn btn-danger btn-print action-print">Delete</a>
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

