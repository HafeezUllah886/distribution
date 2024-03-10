@extends('layout.app')
@php
    $page_title = "Units";
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
                    <div class="page-title"><h3>Units</h3></div>
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
                    <th>#</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $key => $unit)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->value }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center">
                        <span onclick="edit({{$unit->id}}, '{{$unit->name}}', '{{$unit->value}}')" class="text-info"><i class="fa fa-edit">Edit</i></span>
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
                <h5 class="modal-title" id="exampleModalLabel">Create Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('unitStore') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mt-2">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" required id="name" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="value">Value <span class="text-danger">*</span></label>
                        <input type="text" name="value" id="value" class="form-control">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('unitUpdate') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group mt-2">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" required id="edit_name" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="value">Value <span class="text-danger">*</span></label>
                        <input type="text" name="value" id="edit_value" class="form-control">
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
    function edit(id, name, value)
    {
        $("#edit_id").val(id);
        $("#edit_name").val(name);
        $("#edit_value").val(value);
        $("#editModal").modal("show");
    }
  </script>
@endsection
