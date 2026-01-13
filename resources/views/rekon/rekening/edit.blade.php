@extends('layouts.admin')

@section('title')
    <title>List Perusahaan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item active">Perusahaan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Perusahaan Baru</h4>
                        </div>
                        <div class="card-body">
                          
                            <form action="{{ route('perusahaan.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Kode Perusahaan</label>
                                    <input type="text" name="kode_perusahaan" class="form-control" required>
                                    <p class="text-danger">#</p>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Perusahaan</label>
                                    <input type="text" name="nama_perusahaan" class="form-control" required>
                                    <p class="text-danger">#</p>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">Tambah</button>
                                </div>

                            </form>
                          
                        </div>
                    </div>
                </div>
                <!-- ############################################################################################  -->
              
            </div>
        </div>
    </div>
</main>
@endsection