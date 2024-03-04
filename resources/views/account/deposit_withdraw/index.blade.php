@extends('layout.app')
@php
    $page_title = "Deposits & Withdraws";
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
                    <div class="page-title"><h3>Deposit & Withdraws</h3></div>
                </div>
            </div>
            <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">
                <li class="nav-item more-dropdown">
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
                    <th>Ref #</th>
                    <th>Date</th>
                    <th>Account</th>
                    <th>Type</th>
                    <th>Notes</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->refID }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->account->name }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->notes }}</td>
                    <td>{{ $item->amount }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center">
                        <a href="{{ route('depositWithdrawDelete', $item->refID) }}" class="text-danger"><i class="fa fa-trash">Delete</i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Deposit / Withdraw</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('depositWithdrawStore') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="accountID"> Account </label>
                        <select name="accountID" id="accountID" required class="form-control">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="type"> Type </label>
                        <select name="type" id="type" required class="form-control">
                            <option value="Deposit">Deposit</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="amount">Amount <span class="text-danger">*</span></label>
                        <input type="number" name="amount" required id="amount" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="date">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required id="date" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="name">Notes</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
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
    function edit(id, name, type, notes)
    {
        $("#edit_id").val(id);
        $("#edit_name").val(name);
        $("#edit_type").val(type);
        $("#edit_notes").val(notes);
        $("#editModal").modal("show");
    }
  </script>
@endsection
