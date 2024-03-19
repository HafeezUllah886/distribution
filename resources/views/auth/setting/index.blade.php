@extends('layout.app')
@php
    $page_title = "Settings";
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

                    <div class="page-title"><h3>Settings</h3></div>

                </div>
            </div>
        </header>
    </div>
</div>
<div class="card mt-2">
    <div class="card-header">
        <h4>Basic Information</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('updateProfile') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" placeholder="Enter user name" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" placeholder="Enter email address" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sign">Sign</label>
                        <input type="text" name="sign" id="sign" value="{{ auth()->user()->sign }}" placeholder="Enter Bill Signing Name" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cell">Cell</label>
                        <input type="text" name="cell" id="cell" value="{{ auth()->user()->cell }}" placeholder="Enter Cell Number" class="form-control">
                    </div>
                </div>
                <div class="col-12 mt-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mt-2">
    <div class="card-header">
        <h4>Password Setting</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('updatePassword') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password" required class="form-control">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Passowrd</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required class="form-control">
                    </div>
                </div>
                <div class="col-12 mt-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Change</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
