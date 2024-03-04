@extends('layout.app')
@php
    $page_title = "Products";
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
                    <div class="page-title"><h3>Products</h3></div>
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
                    <th>Code</th>
                    <th>Description</th>
                    <th>TP</th>
                    <th>MRP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->desc }}</td>
                    <td>{{ $product->tp }}</td>
                    <td>{{ $product->mrp }}</td>
                    <td class="text-center d-flex justify-content-center align-items-center">
                        <span onclick="edit({{$product->id}}, '{{$product->code}}', '{{$product->desc}}', {{$product->tp}}, {{$product->mrp}})" class="text-info"><i class="fa fa-edit">Edit</i></span>
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
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('productStore') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="code"> Code <span class="text-danger">*</span></label>
                        <input name="code" id="code" required class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="desc">Description <span class="text-danger">*</span></label>
                        <input type="text" name="desc" required id="desc" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="tp">TP <span class="text-danger">*</span></label>
                        <input type="number" name="tp" required id="tp" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="mrp">MRP</label>
                        <input type="number" name="mrp" id="mrp" class="form-control">
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
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('productUpdate') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label for="code"> Code <span class="text-danger">*</span></label>
                        <input name="code" id="edit_code" required class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="desc">Description <span class="text-danger">*</span></label>
                        <input type="text" name="desc" required id="edit_desc" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="tp">TP <span class="text-danger">*</span></label>
                        <input type="number" name="tp" required id="edit_tp" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="mrp">MRP</label>
                        <input type="number" name="mrp" id="edit_mrp" class="form-control">
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
    function edit(id, code, desc, tp, mrp)
    {
        $("#edit_id").val(id);
        $("#edit_desc").val(desc);
        $("#edit_code").val(code);
        $("#edit_tp").val(tp);
        $("#edit_mrp").val(mrp);
        $("#editModal").modal("show");
    }
  </script>
@endsection
