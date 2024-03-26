@extends('layout.app')
@php
    $page_title = 'Sale Return';
@endphp
@section('content')
    <!--  BEGIN BREADCRUMBS  -->
    <div class="secondary-nav">
        <div class="breadcrumbs-container" data-page-heading="Sales">
            <header class="header navbar navbar-expand-sm">
                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-menu">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>
                <div class="d-flex breadcrumb-content">
                    <div class="page-header">
                        <div class="page-title">
                            <h3>Create Sale Return</h3>
                        </div>
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
                                <option value="{{ $product->id }}">{{ $product->code }} | {{ $product->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('saleReturnStore')}}" method="post">
        @csrf
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <table class="table no-space">
                        <thead>
                            <th width="20%">Product</th>
                            <th class="text-center">Reason</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Amount</th>
                            <th></th>
                        </thead>
                        <tbody id="list">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-end" colspan="4">Total</th>
                                <th id="subTotal" class="text-center"></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="orderbooker">Order Booker</label>
                            <select name="orderbookerID" required id="orderbooker" class="form-control">
                                <option value="">Select Order Booker</option>
                                @foreach ($orderbookers as $orderbooker)
                                    <option value="{{$orderbooker->id}}">{{$orderbooker->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-3">
                        <div class="form-group">
                            <label for="customer">Customer</label>
                            <select name="customerID" required id="customer" class="form-control">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="account">Account</label>
                            <select name="accountID" required id="account" class="form-control">
                                <option value="">Select Account</option>
                                @foreach ($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-2">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success w-100">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <!--  END BREADCRUMBS  -->
@endsection
@section('more-css')
    <link rel="stylesheet" href="{{ asset('src/plugins/src/selectize/selectize.min.css') }}">
@endsection
@section('more-js')
    <script src="{{ asset('src/plugins/src/selectize/selectize.min.js') }}"></script>
    <script>
        $('.selectize').selectize({
            onChange: function(value) {
                getSingleProduct(value);
                this.clear();
            }
        });
        var existingProducts = [];
        function getSingleProduct(id) {
            var proHTML = "";
            $.ajax({
                url: "{{ url('/sale/return/singleProduct/') }}/" + id,
                method: "GET",
                success: function(product) {
                    var productID = product.id;
                    if (!existingProducts.includes(productID)) {
                        proHTML += '<tr id="row_'+productID+'">';
                            proHTML += '<td>'+product.desc+'</td>';
                            proHTML += '<td><input class="form-control form-control-sm input-p-2" type="text" name="reason[]" id="reason_'+productID+'"></td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center input-p-2" type="number" min="1" value="1" required oninput="updateQty('+productID+')" name="qty[]" id="qty_'+productID+'"></td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center input-p-2" type="number" min="1" step="any" value="'+product.price+'" required oninput="updateQty('+productID+')" name="price[]" id="price_'+productID+'"></td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center input-p-2" readonly type="number" required value="0" id="amount_'+productID+'" name="amount[]"></td>';
                            proHTML += '<td><span onclick="deleteRow('+productID+')">@svg("eos-delete", "text-danger")</span></td>';
                            proHTML += '<input type="hidden" value="'+productID+'" name="productID[]">';
                        proHTML += '</tr>';
                        $("#list").prepend(proHTML);
                        existingProducts.push(productID);
                        updateQty(productID)
                        $('input[id^="qty_"]:first').focus().select();   
                    }
                    else
                    {
                        var existingQty = $("#qty_"+productID).val();
                        existingQty++;
                        $("#qty_"+productID).val(existingQty);
                        updateQty(productID);
                    }
                }
            });
        }

        function updateQty(id){
        $("input[id^='qty_']").each(function() {
                var input = $(this);
                var currentValue = parseInt(input.val());
                if (currentValue < 1) {
                    input.val(1);
                }
        });
        var existingQty = $("#qty_"+id).val();

        var price = $("#price_"+id).val();
        var amount = price * existingQty;
        $("#amount_"+id).val(amount.toFixed(2));
        updateAmounts(); 
        }

        function updateAmounts(){
            var subTotal = 0;
        $("input[id^='amount_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            subTotal += parseFloat(inputValue);
        });
            $("#subTotal").text(subTotal.toFixed(2));
        }

        function deleteRow(id){
        $("#row_"+id).remove();
        existingProducts = $.grep(existingProducts, function(value) {
                return value !== id;
            });
            updateAmounts();
        }
    </script>
@endsection
