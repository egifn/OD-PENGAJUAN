@extends('layouts.admin')

@section('title')
    {{-- <title>Import Data DMS</title> --}}
    <title>Upload File</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        {{-- <li class="breadcrumb-item">Import Data DMS</li>
        <li class="breadcrumb-item active">Import Data</li> --}}
        <li class="breadcrumb-item">Upload File</li>
        <li class="breadcrumb-item active">Upload File</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('data_center_dms/import.storeDataDms') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    {{-- Import Data DMS --}}
                                    Upload File
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                {{-- <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="">File (.xls, .xlsx)</label>
                                        <input type="file" name="file" class="form-control" value="{{ old('file') }}" >
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Upload File (*.xlsx, *.xls)</strong>
                                        <input type="file" class="form-control" name="upload_file[]" id="upload_file_1" multiple>
                                    </div>                                      
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Keterangan</strong>
                                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="">
                                    </div>                                      
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button class="btn btn-primary btn-sm">U p l o a d</button>
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