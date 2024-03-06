@extends('layout.app')
@php
    $page_title = "Purchase";
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
                    <div class="page-title"><h3>Create Purchase</h3></div>
                </div>
            </div>
        </header>
    </div>
</div>

<div class="card mt-2">
   <div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="product">Product</label>
                <select id="product" class="selectize">
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->code}} | {{$product->desc}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
   </div>
    </div>
</div>
<!--  END BREADCRUMBS  -->

@endsection
@section('more-css')
    <link rel="stylesheet" href="{{asset('src/plugins/src/selectize/selectize.min.css')}}">
@endsection
@section('more-js')
    <script src="{{ asset('src/plugins/src/selectize/selectize.min.js') }}"></script>
    <script>
        $('.selectize').selectize({
            onChange: function(value) {
            getSingleProduct(value);
            }
        });

        function getSingleProduct(id) {
           $.ajax({
            url: "{{url('/singleProduct/')}}/"+id,
            method: "GET",
            success: function(product){
                console.log(product);
            }
           });
        }
    </script>
@endsection

