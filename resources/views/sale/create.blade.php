@extends('layout.app')
@php
    $page_title = 'Sale';
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
                            <h3>Create Sale - {{$customer->name}} | {{$customer->channel}}</h3>
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
                                @if ($product->stock > 0)
                                <option value="{{ $product->id }}">{{ $product->code }} | {{ $product->desc }} | {{$product->stock}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('saleStore')}}" method="post">
        @csrf
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <table class="table no-space">
                        <thead>
                            <th width="20%">Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">RT</th>
                            <th class="text-center">W/S</th>
                            <th class="text-center">Slb</th>
                            <th class="text-center">Deal</th>
                            <th class="text-center">Bonus</th>
                            <th class="text-center">Gross</th>
                            <th class="text-center">GST</th>
                            <th class="text-center">MRP</th>
                            <th class="text-center">FST</th>
                            <th class="text-center">Amount</th>
                            <th></th>
                        </thead>
                        <tbody id="list">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th id="totalRT" class="text-center"></th>
                                <th id="totalWS" class="text-center"></th>
                                <th id="totalSlb" class="text-center"></th>
                                <th id="totalDeal" class="text-center"></th>
                                <th class="text-center"></th>
                                <th id="totalGross" class="text-center"></th>
                                <th id="totalGst" class="text-center"></th>
                                <th id="totalMrp" class="text-center"></th>
                                <th id="totalFst" class="text-center"></th>
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
                    <div class="col-2">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="payment">Payment Status</label>
                            <select name="payment"  id="payment" class="form-control">
                                    <option value="1">Received</option>
                                    <option value="0">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="account">Account</label>
                            <select name="accountID" required id="account" class="form-control">
                                <option value="">Select Receiving Account</option>
                                @foreach ($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="salesman">Sales Man</label>
                            <select name="salesman" required id="salesman" class="form-control">
                                <option value="">Select Sales Man</option>
                                @foreach ($salemans as $man)
                                    <option value="{{$man->id}}">{{$man->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="orderbooker">Order Booker</label>
                            <select name="orderbooker" required id="orderbooker" class="form-control">
                                <option value="">Select Order Booker</option>
                                @foreach ($orderBookers as $booker)
                                    <option value="{{$booker->id}}">{{$booker->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="cell">Cell</label>
                            <input type="text" name="cell" id="cell" value="{{auth()->user()->cell}}" class="form-control">
                            <input type="hidden" name="customerID" id="customerID" value="{{$customer->id}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="sign">Sign</label>
                            <input type="text" name="sign" value="{{auth()->user()->sign}}" id="sign" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" class="form-control" id="notes" cols="30" rows="5"></textarea>
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
                if(value != "")
                {
                    getSingleProduct(value);
                }
                this.clear();
            }
        });
        var existingProducts = [];
        function getSingleProduct(id) {
            var customer = $("#customerID").val();
            var proHTML = "";
            $.ajax({
                url: "{{ url('/sale/singleProduct/') }}/" + id +"/" +customer,
                method: "GET",
                success: function(response) {
                    var product = response.product;
                    var productID = product.id;
                    console.log(product.stock);
                    var gst = 18;
                    var fst = 4;
                    if(product.mrp > 0)
                    {
                        gst = 0;
                    }
                    if(response.customer.ntn != null || response.customer.strn != null )
                    {
                        fst = 0;
                    }
                    if (!existingProducts.includes(productID)) {
                        proHTML += '<tr id="row_'+productID+'">';
                            proHTML += '<td>'+product.desc+'</td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center input-p-2" type="number" min="1" max="'+product.stock+'" value="1" required oninput="updateQty('+productID+')" name="qty[]" id="qty_'+productID+'"></td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center input-p-2" type="number" min="1" step="any" value="'+product.tp+'" required oninput="updateQty('+productID+')" name="price[]" id="price_'+productID+'"></td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" required oninput="updateQty('+productID+')" id="rt_per_'+productID+'" value="0" name="rt_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" readonly step="any" id="rt_val_'+productID+'" required value="0" name="rt_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" required oninput="updateQty('+productID+')" id="ws_per_'+productID+'" value="0" name="ws_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" readonly step="any" id="ws_val_'+productID+'" required value="0" name="ws_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" required oninput="updateQty('+productID+')" id="slb_per_'+productID+'" value="0" name="slb_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" readonly step="any" id="slb_val_'+productID+'" required value="0" name="slb_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" required oninput="updateQty('+productID+')" id="deal_per_'+productID+'" value="0" name="deal_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" readonly step="any" id="deal_val_'+productID+'" required value="0" name="deal_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" value="0" oninput="updateQty('+productID+')" required name="bonus[]" id="bonus_'+productID+'"></td>';
                            proHTML += '<td><input class="form-control form-control-sm text-center input-p-2" type="number" min="1" step="any" value="0" readonly required name="gross[]" id="gross_'+productID+'"></td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" required oninput="updateQty('+productID+')" id="gst_per_'+productID+'" value="'+gst+'" name="gst_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" readonly step="any" id="gst_val_'+productID+'" required value="0" name="gst_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" required oninput="updateQty('+productID+')" id="mrp_per_'+productID+'" value="'+product.mrp+'" name="mrp_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" readonly step="any" id="mrp_val_'+productID+'" required value="0" name="mrp_val[]">';
                            proHTML += '</td>';
                            proHTML += '<td>';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" step="any" required oninput="updateQty('+productID+')" id="fst_per_'+productID+'" value="'+fst+'" name="fst_per[]">';
                                proHTML += '<input class="form-control form-control-sm text-center input-p-2" type="number" min="0" readonly step="any" id="fst_val_'+productID+'" required value="0" name="fst_val[]">';
                            proHTML += '</td>';
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
        var bonus = $("#bonus_"+id).val();
        var nQty = existingQty - bonus;
        var price = $("#price_"+id).val();

        var g_price = nQty * price;

        var rt = $("#rt_per_"+id).val();
        var rt_val = (g_price / 100) * rt;

        var ws = $("#ws_per_"+id).val();
        var ws_val = (g_price / 100) * ws;

        var i_gross = g_price - rt_val - ws_val;
        var slb = $("#slb_per_"+id).val();
        var slb_val = (i_gross / 100) * slb;

        var deal = $("#deal_per_"+id).val();
        var deal_val = (i_gross / 100) * deal;

        var gross = g_price - rt_val - ws_val - slb_val - deal_val;

        var gst = $("#gst_per_"+id).val();
        var gst_val = (gross / 100) * gst;

        var mrp = $("#mrp_per_"+id).val();
        var t_mrp = mrp * nQty;

        var fst = $("#fst_per_"+id).val();
        var fst_val = (gross / 100) * fst;

        var amount = gross + gst_val + fst_val + t_mrp;
       
        $("#rt_val_"+id).val(rt_val.toFixed(2));
        $("#ws_val_"+id).val(ws_val.toFixed(2));
        $("#slb_val_"+id).val(slb_val.toFixed(2));
        $("#deal_val_"+id).val(deal_val.toFixed(2));
        $("#gross_"+id).val(gross.toFixed(2));
        $("#gst_val_"+id).val(gst_val.toFixed(2));
        $("#fst_val_"+id).val(fst_val.toFixed(2));
        $("#mrp_val_"+id).val(t_mrp.toFixed(2));
        $("#amount_"+id).val(amount.toFixed(2));
        updateAmounts(); 
        }

        function updateAmounts(){
        
        var totalRt = 0;
        var totalWs = 0;
        var totalSlb = 0;
        var totalDeal = 0;
        var totalGross = 0;
        var totalGst = 0;
        var totalMrp = 0;
        var totalFst = 0;
        var subTotal = 0;
        $("input[id^='amount_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            subTotal += parseFloat(inputValue);
        });
        $("input[id^='rt_val_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalRt += parseFloat(inputValue);
        });
        $("input[id^='ws_val_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalWs += parseFloat(inputValue);
        });
        $("input[id^='slb_val_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalSlb += parseFloat(inputValue);
        });
        $("input[id^='deal_val_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalDeal += parseFloat(inputValue);
        });
        $("input[id^='gst_val_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalGst += parseFloat(inputValue);
        });

        $("input[id^='mrp_val_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalMrp += parseFloat(inputValue);
        });

        $("input[id^='fst_val_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalFst += parseFloat(inputValue);
        });

        $("input[id^='gross_']").each(function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val();
            totalGross += parseFloat(inputValue);
        });

            $("#totalAmount").text(subTotal.toFixed(2));
            $("#totalRT").text(totalRt.toFixed(2));
            $("#totalWS").text(totalWs.toFixed(2));
            $("#totalSlb").text(totalSlb.toFixed(2));
            $("#totalDeal").text(totalDeal.toFixed(2));
            $("#totalGst").text(totalGst.toFixed(2));
            $("#totalMrp").text(totalMrp.toFixed(2));
            $("#totalFst").text(totalFst.toFixed(2));
            $("#totalGross").text(totalGross.toFixed(2));
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
