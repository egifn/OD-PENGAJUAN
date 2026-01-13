@extends('layouts.admin')

@section('title')
    <title>Import VIT Compas</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Import VIT Compas</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pembelian_vit_import/index.storeData') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Import VIT Compas
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
                                    <div class="col-md-3 mb-2">
                                        <label for="">Jenis</label>
                                        <select name="jenis" id="jenis" class="form-control" required>
                                            <option value="">Pilih</option>
                                            <option value="CO">CO</option>
                                            <option value="Botol Kosong">Botol Kosong</option>>
                                        </select>
                                    </div>

                                    <div class="col-md-9 mb-2">
                                        <label for="">File (.xls, .xlsx)</label>
                                        <input type="file" name="file" class="form-control" value="{{ old('file') }}" required>
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm">I m p o r t</button>
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