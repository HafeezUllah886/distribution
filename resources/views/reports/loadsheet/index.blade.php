@extends('layout.app')
@php
    $page_title = "Generate Load Sheet";
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
                    {{-- <div class="page-title"><h3>Generate Load Sheet</h3></div> --}}
                </div>
            </div>
        </header>
    </div>
</div>
<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
    <div class="card mt-3 mb-3">
        <div class="card-body">
            <form method="get" action="{{route('loadSheetPrint')}}">
                @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h2>Generate Load Sheet</h2>

                </div>
                <div class="col-12">
                    <div class="mb-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-4">
                        <label class="form-label">Order Booker</label>
                        <select name="orderbooker" id="orderbooker" class="form-control">
                            @foreach ($orderbookers as $orderbooker)
                                <option value="{{ $orderbooker->id }}">{{ $orderbooker->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-4">
                        <button type="submit" class="btn btn-secondary w-100">Continue</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>


@endsection

