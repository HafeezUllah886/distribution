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
        <form action="{{ route('purchaseStore') }}" method="post">
            @csrf
            <div class="card-header">
                <h5>Vehicle Details</h5>
            </div>
            <div class="row">
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="desc">Vehicle Description</label>
                        <input type="text" name="desc" id="desc" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" name="model" id="model" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" name="color" id="color" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="hp">Horse Power</label>
                        <input type="text" name="hp" id="hp" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="reg_no">Reg No.</label>
                        <input type="text" name="reg_no" id="reg_no" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="chassis_no">Chassis No.</label>
                        <input type="text" name="chassis_no" id="chassis_no" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="eng_no">Engine No</label>
                        <input type="text" name="eng_no" id="eng_no" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="card-header mt-2">
                <h5>Seller Details</h5>
            </div>
            <div class="row">
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="seller">Name</label>
                        <input type="text" name="seller" id="seller" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="seller_father">Father Name</label>
                        <input type="text" name="seller_father" id="seller_father" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="seller_cnic">CNIC No.</label>
                        <input type="text" name="seller_cnic" id="seller_cnic" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="seller_contect">Contact No.</label>
                        <input type="text" name="seller_contect" id="seller_contect" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="seller_address">Address</label>
                        <input type="text" name="seller_address" id="seller_address" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="card-header mt-2">
                <h5>Brocker Details</h5>
            </div>
            <div class="row">
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="broker">Name</label>
                        <input type="text" name="broker" id="broker" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="broker_cnic">CNIC No.</label>
                        <input type="text" name="broker_cnic" id="broker_cnic" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="broker_contect">Contact No.</label>
                        <input type="text" name="broker_contect" id="broker_contect" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="broker_address">Address</label>
                        <input type="text" name="broker_address" id="broker_address" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="card-header mt-2">
                <h5>Purchase Details</h5>
            </div>
            <div class="row">
                <div class="col-md-2 mt-1">
                    <div class="form-group">
                        <label for="price">Total Price</label>
                        <input type="number" name="price" id="price" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-2 mt-1">
                    <div class="form-group">
                        <label for="paid">Amount Paid</label>
                        <input type="number" name="paid" id="paid" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-2 mt-1">
                    <div class="form-group">
                        <label for="account">Account</label>
                        <select name="account" id="account" class="form-control form-control-sm">
                            <option value="">Cash</option>
                            <option value="">Bank</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-1">
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--  END BREADCRUMBS  -->

@endsection
@section('more-js')
<script src="{{ asset('src/plugins/src/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/input-mask/input-mask.js') }}"></script>
<script>
        $('#seller_cnic').inputmask("99999-9999999-9");
        $('#broker_cnic').inputmask("99999-9999999-9");
        $('#seller_contect').inputmask("0999-9999999");
        $('#broker_contect').inputmask("0999-9999999");
</script>
@endsection

