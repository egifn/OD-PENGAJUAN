@extends('layouts.admin')

@section('title')
    <title>Import OTM</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Import OTM</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pembelian_aqua_otm/index.storeData') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Import OTM
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
                                    <div class="col-md-3 mb-2" hidden>
                                        <label for="">Kode</label>
                                        <input type="text" name="kode" id="kode" class="form-control" value="{{ $kode }}" required>
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <strong>Import File Data Pencapaian (file *.xlsx, *.xls)</strong>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="file" id="file" required>
                                            <span class="input-group-btn">
                                                
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" class="btn btn-primary btn-sm float-right">I m p o r t</button>
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