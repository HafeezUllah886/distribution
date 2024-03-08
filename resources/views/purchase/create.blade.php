@extends('layout.app')
@php
    $page_title = 'Purchase';
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
                            <h3>Create Purchase</h3>
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
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                   <table class="table">
                    <thead>
                        <th width="20%">Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">GST</th>
                        <th class="text-center">Amount</th>
                        <th></th>
                    </thead>
                    <tbody id="list">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Total Amount</th>
                            <th id="totalAmount" class="text-center"></th>
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
                        <label for="vendor">Vendor</label>
                        <select name="vendor" required id="vendor" class="form-control">
                            <option value="">Select Vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="account">Account</label>
                        <select name="account" required id="account" class="form-control">
                            <option value="">Select Payment Account</option>
                            @foreach ($accounts as $account)
                                <option value="{{$account->id}}">{{$account->name}}</option>
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
                url: "{{ url('/singleProduct/') }}/" + id,
                method: "GET",
                success: function(product) {
                    var productID = product.id;
                    if (!existingProducts.includes(productID)) {
                        proHTML += '<tr id="row_'+productID+'">';
                            proHTML += '<td>'+product.desc+'</td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center" type="number" min="1" value="1" required oninput="updateQty('+productID+')" name="qty[]" id="qty_'+productID+'"></td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center" type="number" min="1" step="any" value="0" required oninput="updateQty('+productID+')" name="price[]" id="price_'+productID+'"></td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center" type="number" min="0" step="any" required id="discount_per_'+productID+'" value="8" name="discount_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center" type="number" min="0" readonly step="any" id="discount_val_'+productID+'" required value="0" name="discount_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center" type="number" min="0" step="any" required id="gst_per_'+productID+'" value="18" name="gst_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center" type="number" min="0" readonly step="any" id="gst_val_'+productID+'" required value="0" name="gst_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center" readonly type="number" required value="0" id="amount_'+productID+'" name="amount[]"></td>';
                            proHTML += '<td><span onclick="deleteRow('+productID+')">@svg("eos-delete", "text-danger")</span></td>';
                        proHTML += '</tr>';
                        $("#list").prepend(proHTML);
                        existingProducts.push(productID);
                        updateAmounts();
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
        var discount = $("#discount_per_"+id).val();
        var discount_val = (price / 100) * discount;
        var gst = $("#gst_per_"+id).val();
        var gst_val = (price / 100) * gst;
        var netPrice = (price - discount_val) + gst_val;
        var amount = existingQty * netPrice;
        $("#discount_val_"+id).val(discount_val.toFixed(2));
        $("#gst_val_"+id).val(gst_val.toFixed(2));
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

            $("#totalAmount").text(subTotal.toFixed(2));

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
