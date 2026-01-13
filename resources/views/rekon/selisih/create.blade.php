@extends('layouts.admin')

@section('title')
    <title>Tambah Rekening</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Rekonsiliasi</li>
        <li class="breadcrumb-item">Selisih</li>
        <li class="breadcrumb-item active">Tambah Master Selisih</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('master_selisih.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
            
                    <div class="col-md-10">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Selisih Baru</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="name">Kode Selisih</label>
                                        <input type="text" name="kode_selisih" id="kode_selisih" style="text-align: center;" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('kode_selisih') }}</p>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="name">Nama Selisih</label>
                                        <input type="text" name="nama_selisih" id="nama_selisih" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('nama_selisih') }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 mb-">
                                        <label for="name">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        <label for="user">kode_user</label>
                                        <input type="text" name="kode_user" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- ############################################################################################  -->
              
                </div>
            </form>
        </div>
    </div>
</main>
@endsection