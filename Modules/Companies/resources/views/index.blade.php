@extends('layouts.index')

@section('title', __('companies.title') . ' | CRM Barış Tok')

@section('css')

@endsection

@section('content')
    
<div class="page-content">
    <div class="container-fluid">
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
            <h4 class="mb-sm-0">{{ __('companies.title') }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                    <li class="breadcrumb-item active">{{ __('companies.title') }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
    </div>
</div>



@endsection

@section('js')

@endsection