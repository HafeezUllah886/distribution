@extends('layout.app')
@php
    $page_title = "Accounts";
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
                    <div class="page-title"><h3>Accounts</h3></div>
                </div>
            </div>
            <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">

                <li class="nav-item more-dropdown" style="margin-right: 10px;">
                    <select id="filter" onchange="filter()" class="form-control form-control-sm mr-2">
                        <option {{$filter == "All" ? "selected" : ""}} value="All">All</option>
                        <option {{$filter == "Business" ? "selected" : ""}} value="Business">Business</option>
                        <option {{$filter == "Customer"? "selected" : ""}} value="Customer">Customer</option>
                        <option {{$filter == "Vendor" ? "selected" : ""}} value="Vendor">Vendor</option>
                        <option {{$filter == "Others" ? "selected" : ""}} value="Others">Others</option>
                    </select>
                </li>
                <li class="nav-item more-dropdown ">
                   <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Create New</button>
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
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Business Name</th>
                    <th>Channel</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($accounts as $key => $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->category }}</td>
                    <td>{{ $account->b_name }}</td>
                    <td>{{ $account->channel }}</td>
                    <td>{{ getAccountBalance($account->id) }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center">
                        <div class="dropdown" style="position:absolute !important; z-index:1000;">
                            <a class="dropdown-toggle" href="#" role="button" id="action_{{ $key }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="action_{{ $key }}" >
                                <a class="dropdown-item" href="{{ route('accountStatement', [$account->id, firstDayOfMonth(), lastDayOfMonth()]) }}">View Statement</a>
                                @if ($account->category != "Discount")
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="edit({{ $account->id }}, '{{ $account->name }}', '{{ $account->category }}', '{{ $account->b_name }}', '{{ $account->cnic }}', '{{ $account->contact }}', '{{ $account->address }}' , '{{ $account->ntn }}', '{{ $account->strn }}', '{{ $account->channel }}')">Edit</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('accountStore') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label for="category">Category</label>
                        <select name="category" onchange="checkCategory()" id="category" class="form-control">
                            <option value="Customer">Customer</option>
                            <option value="Vendor">Vendor</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" required id="name" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="b_name">Business Name </label>
                        <input type="text" name="b_name" id="b_name" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="contact">Contact </label>
                        <input type="text" name="contact" id="contact" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="address">Address </label>
                        <input type="text" name="address" id="address" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="cnic">CNIC </label>
                        <input type="text" name="cnic" id="cnic" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="ntn">NTN No. </label>
                        <input type="text" name="ntn" id="ntn" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="strn">STRN No. </label>
                        <input type="text" name="strn" id="strn" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="channel">Channel</label>
                        <select name="channel" id="channel" class="form-control">
                            <option value="Retailer">Retailer</option>
                            <option value="Wholesaler">Wholesaler</option>
                            <option value="LMT">LMT</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="initial">Initial Amount </label>
                        <input type="number" name="initial" required value="0" id="initial" class="form-control">
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('accountUpdate') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="form-group col-md-6 mt-2">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" required id="edit_name" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="b_name">Business Name </label>
                            <input type="text" name="b_name" id="edit_b_name" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="contact">Contact </label>
                            <input type="text" name="contact" id="edit_contact" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="address">Address </label>
                            <input type="text" name="address" id="edit_address" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="cnic">CNIC </label>
                            <input type="text" name="cnic" id="edit_cnic" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="ntn">NTN No. </label>
                            <input type="text" name="ntn" id="edit_ntn" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="strn">STRN No. </label>
                            <input type="text" name="strn" id="edit_strn" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="channel">channel</label>
                            <select name="channel" id="edit_channel" class="form-control">
                                <option value="Retailer">Retailer</option>
                                <option value="Wholesaler">Wholesaler</option>
                                <option value="LMT">LMT</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  END BREADCRUMBS  -->
@endsection

@section('more-css')
<link rel="stylesheet" href="{{ asset('src/assets/css/light/components/modal.css') }}">
<link rel="stylesheet" href="{{ asset('src/assets/css/dark/components/modal.css') }}">

<link rel="stylesheet" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/light/table/datatable/custom_dt_miscellaneous.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/css/dark/table/datatable/custom_dt_miscellaneous.css') }}">

@endsection

@section('more-js')
  <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.print.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('src/plugins/src/table/datatable/custom_miscellaneous.js') }}"></script>

  <script>
    function edit(id, name, category, b_name, cnic, contact, address, ntn, strn, channel)
    {
        $("#edit_id").val(id);
        $("#edit_name").val(name);
        $("#edit_b_name").val(b_name);
        $("#edit_cnic").val(cnic);
        $("#edit_contact").val(contact);
        $("#edit_address").val(address);
        $("#edit_ntn").val(ntn);
        $("#edit_strn").val(strn);
        $("#edit_channel").val(channel);
        $("#editModal").modal("show");
        if(category == "Business")
        {
            $("#edit_b_name").prop('disabled', 'true');
            $("#edit_cnic").prop('disabled', 'true');
            $("#edit_contact").prop('disabled', 'true');
            $("#edit_address").prop('disabled', 'true');
            $("#edit_ntn").prop('disabled', 'true');
            $("#edit_strn").prop('disabled', 'true');
            $("#edit_channel").prop('disabled', 'true');
        }
        else if(category == "Vendor")
        {
            $("#edit_b_name").removeAttr('disabled');
            $("#edit_cnic").prop('disabled', 'true');
            $("#edit_contact").removeAttr('disabled');
            $("#edit_address").removeAttr('disabled');
            $("#edit_ntn").prop('disabled', 'true');
            $("#edit_strn").prop('disabled', 'true');
            $("#edit_channel").prop('disabled', 'true');
        }
        else
        {
            $("#edit_b_name").removeAttr('disabled');
            $("#edit_cnic").removeAttr('disabled');
            $("#edit_contact").removeAttr('disabled');
            $("#edit_address").removeAttr('disabled');
            $("#edit_ntn").removeAttr('disabled');
            $("#edit_strn").removeAttr('disabled');
            $("#edit_channel").removeAttr('disabled');
        }
       
    }

    function filter()
    {
        var filter = $("#filter").find(":selected").val();
        var url = "{{ route('accountsIndex', ':filter') }}".replace(':filter', encodeURIComponent(filter));
        // Open the URL in the same window
        window.open(url, '_self');
    }

    function checkCategory()
    {
        var category = $("#category").find(":selected").val();
        if(category == "Business")
        {
            $("#b_name").prop('disabled', 'true');
            $("#cnic").prop('disabled', 'true');
            $("#contact").prop('disabled', 'true');
            $("#address").prop('disabled', 'true');
            $("#ntn").prop('disabled', 'true');
            $("#strn").prop('disabled', 'true');
            $("#channel").prop('disabled', 'true');
        }
        else if(category == "Vendor")
        {
            $("#b_name").removeAttr('disabled');
            $("#cnic").prop('disabled', 'true');
            $("#contact").removeAttr('disabled');
            $("#address").removeAttr('disabled');
            $("#ntn").prop('disabled', 'true');
            $("#strn").prop('disabled', 'true');
            $("#channel").prop('disabled', 'true');
        }
        else
        {
            $("#b_name").removeAttr('disabled');
            $("#cnic").removeAttr('disabled');
            $("#contact").removeAttr('disabled');
            $("#address").removeAttr('disabled');
            $("#ntn").removeAttr('disabled');
            $("#strn").removeAttr('disabled');
            $("#channel").removeAttr('disabled');
        }
    }
  </script>
@endsection
