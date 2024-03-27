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
                                                    <p class="inv-list-number "><span class="inv-title">Invoice # : </span> <span class="inv-number">{{ $sale->id }}</span></p>
                                                    <p class="inv-created-date "><span class="inv-title">Date : </span> <span class="inv-date">{{ date('d M Y', strtotime($sale->date)) }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--detail-section inv--customer-detail-section">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                    <p class="inv-to">Invoice To</p>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 text-sm-end mt-sm-0 mt-5">
                                                    <h6 class=" inv-title"></h6>
                                                </div>
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                    <p class="inv-customer-name">{{$sale->customer->name}}</p>
                                                    <p class="inv-street-addr">{{$sale->customer->b_name}}</p>
                                                    <p class="inv-street-addr">{{$sale->customer->address}}</p>
                                                    <p class="inv-email-address">{{$sale->customer->contact}}</p>
                                                    <p class="inv-street-addr">NTN No. {{$sale->customer->ntn ?? " - "}} | STRN No. {{$sale->customer->ntn ?? " - "}}</p>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1 text-sm-end">
                                                    <p class="inv-street-addr">Sales Man : {{$sale->salesmen->name}}</p>
                                                    <p class="inv-street-addr">Order Booker : {{$sale->orderbooker->name}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--product-table-section p-0 table-responsive ml-1 mr-1">
                                           <table class="table no-space no-space-h no-space-f">
                                            <thead>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th>CTN</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>RT</th>
                                                @if ($sale->details[0]->ws_per > 0)
                                                <th>W/S{{$sale->details[0]->ws_per > 0 ? "-".$sale->details[0]->ws_per."%" : ""}}</th>
                                                @endif
                                                @if ($sale->details[0]->slb_per > 0)
                                                 <th>SLB{{$sale->details[0]->slb_per > 0 ? "-".$sale->details[0]->slb_per."%" : ""}}</th>
                                                @endif
                                                @if ($sale->details[0]->deal_per > 0)
                                                 <th>Deal{{$sale->details[0]->deal_per > 0 ? "-".$sale->details[0]->deal_per."%" : ""}}</th>
                                                @endif
                                                <th>Bonus</th>
                                                <th>Gross</th>
                                                <th>GST-18%</th>
                                                <th>MRP</th>
                                                <th>FST-4%</th>
                                                <th class="text-end">Sub-Total</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($sale->details as $key => $product)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$product->product->desc}}</td>
                                                    <td>{{number_format($product->qty / $product->product->p_size,1)}}</td>
                                                    <td>{{$product->qty}}</td>
                                                    <td>{{number_format($product->price, 2)}}</td>
                                                    <td>{{number_format($product->rt_val,0)}}({{$product->rt_per}}%)</td>
                                                    @if ($sale->details[0]->ws_per > 0)
                                                        <td>{{number_format($product->ws_val,0)}}</td>
                                                    @endif
                                                    @if ($sale->details[0]->slb_per > 0)
                                                        <td>{{number_format($product->slb_val,0)}}</td>
                                                    @endif
                                                    @if ($sale->details[0]->deal_per > 0)
                                                        <td>{{number_format($product->deal_val,0)}}</td>
                                                    @endif
                                                    <td>{{number_format($product->bonus,0)}}</td>
                                                    <td>{{number_format($product->gross, 0)}}</td>
                                                    <td>{{number_format($product->gst_val,0)}}</td>
                                                    <td>{{number_format($product->mrp_val,0)}}({{$product->mrp_per}})</td>
                                                    <td>{{number_format($product->fst_val,0)}}</td>
                                                    <td class="text-end">{{number_format($product->amount,0)}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <th colspan="5" class="text-end">Total</th>
                                                <th>{{number_format($sale->details->sum('rt_val'),0)}}</th>
                                                @if ($sale->details[0]->ws_per > 0)
                                                <th>{{number_format($sale->details->sum('ws_val'),0)}}</th>
                                                @endif
                                                @if ($sale->details[0]->ws_per > 0)
                                                <th>{{number_format($sale->details->sum('slb_val'),0)}}</th>
                                                @endif
                                                @if ($sale->details[0]->ws_per > 0)
                                                <th>{{number_format($sale->details->sum('deal_val'),0)}}</th>
                                                @endif
                                                <th></th>
                                                <th>{{number_format($sale->details->sum('gross'),0)}}</th>
                                                <th>{{number_format($sale->details->sum('gst_val'),0)}}</th>
                                                <th>{{number_format($sale->details->sum('mrp_val'),0)}}</th>
                                                <th>{{number_format($sale->details->sum('fst_val'),0)}}</th>
                                                <th class="text-end">{{number_format($sale->details->sum('amount'),0)}}</th>
                                            </tfoot>
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
                                                                <p class="">Sub Total :</p>
                                                            </div>
                                                            <div class="col-sm-2 col-5">
                                                                <p class="">{{number_format($sale->details->sum('amount'),0)}}</p>
                                                            </div>
                                                            <div class="col-sm-10 col-7">
                                                                <p class=" discount-rate">Paid :</p>
                                                            </div>
                                                            <div class="col-sm-2 col-5">
                                                                <p class="">{{number_format($sale->payments->sum('amount'),0)}}</p>
                                                            </div>
                                                            <div class="col-sm-3 col-7 mt-3 text-start">
                                                                <p class=""> _____________________ <br/> {{$sale->sign}} </p>
                                                            </div>
                                                            <div class="col-sm-4 col-7 mt-3 text-start">
                                                                <p class=""> Cell No : {{$sale->cell}} </p>
                                                            </div>
                                                            <div class="col-sm-3 col-7 mt-3">
                                                                <h5 class="">Remaining : </h5>
                                                            </div>
                                                            <div class="col-sm-2 col-5 mt-3">
                                                                <h5 class="">{{number_format($sale->details->sum('amount') - $sale->payments->sum('amount'))}}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="inv--note">
                                            <div class="row mt-4">
                                                <div class="col-sm-12 col-12 order-sm-0 order-1">
                                                    <p>Sale Notes: {{ $sale->notes }}</p>
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
                                    <a href="{{route('saleEdit', $sale->id)}}" class="btn btn-info w-100 mb-3">Edit</a>
                                </div>
                                <div class="col-xl-12 col-md-3 col-sm-6">
                                    <a href="{{route('saleDelete', $sale->id)}}" class="btn btn-danger btn-print">Delete</a>
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

