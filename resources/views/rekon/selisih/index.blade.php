@extends('layouts.admin')

@section('title')
	<title>Selisih</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Rekonsiliasi</li>
        <li class="breadcrumb-item active">Selisih</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Selisih
                                <a href="{{ route('master_selisih.create') }}" class="btn btn-primary btn-sm float-right">Tambah</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th >#</th>
                                            <th>Kode Selisih</th>
                                            <th>Nama Selisih</th>
                                            <th>Keterangan</th>
                                            <th hidden>Kode User</th>
                                            <th hidden>User</th>
                                            <th hidden>Created At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($daftar_selisih as $data) 
                                        <tr>
                                            <td >{{ $data->id }}</td>
                                            <td>{{ $data->kode_selisih }}</td>
                                            <td>{{ $data->nama_selisih }}</td>
                                            <td>{{ $data->keterangan }}</td>
                                            <td hidden>{{ $data->id_user_input }}</td>
                                            <td hidden></td>
                                            <td align="center">
                                                <form action="{{ route('master_selisih.destroy', $data->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <!-- <a href="#" class="btn btn-warning btn-sm">Edit</a> -->
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection