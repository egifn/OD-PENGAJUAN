@extends('layouts.admin')

@section('title')
    <title>Virtual Account</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Rekonsiliasi</li>
        <li class="breadcrumb-item active">Virtual Account</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Virtual Account
                                <a href="{{ route('virtualaccount.create') }}" class="btn btn-primary btn-sm float-right">Tambah</a>
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
                                            <th hidden>#</th>
                                            <th>Virtual Account</th>
                                            <th hidden>kode perusahaan</th>
                                            <th>Perusahaan</th>
                                            <th hidden>Kode Depo</th>
                                            <th>Depo</th>
                                            <th>Jenis</th>
                                            <th>No Rekening</th>
                                            <th hidden>Kode User</th>
                                            <th>User</th>
                                            <th hidden>Created At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($virtualaccount as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->virtualaccount }}</td>
                                            <td hidden>{{ $val->kode_perusahaan }}</td>
                                            <td>{{ $val->nama_perusahaan }}</td>
                                            <td hidden>{{ $val->kode_depo }}</td>
                                            <td>{{ $val->nama_depo }}</td>
                                            <td>{{ $val->jenis }}</td>
                                            <td>{{ $val->norek}}</td>
                                            <td hidden></td>
                                            <td></td>
                                            <td hidden></td>
                                            <td>
                                                <form action="{{ route('virtualaccount.destroy', $val->virtualaccount) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td> 
                                        </tr>   
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection