@extends('layouts.admin')

@section('title')
    <title>Import Account Vendor</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Account</li>
        <li class="breadcrumb-item">Vendor Account</li>
        <li class="breadcrumb-item active">Import Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('rekening_fin_index/import.storeDataRekening') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Import Data Account Vendor
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="">File (.xls, .xlsx)</label>
                                        <input type="file" name="file" class="form-control" value="{{ old('file') }}" >
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button class="btn btn-primary btn-sm">Import Detail</button>
                                    </div>
                                </div>            
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection