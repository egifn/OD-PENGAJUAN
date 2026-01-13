@extends('layouts.admin')

@section('title')
	<title>List Rekening</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item active">Account</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                List Rekening
                                <a href="{{ route('rekening_fin.create') }}" class="btn btn-primary btn-sm float-right">Tambah Data Baru</a>

                                <a href="{{ route('rekening_fin_index.index') }}" class="btn btn-warning btn-sm float-right" hidden>Import Data</a>
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
                                            <th>No. Rekening</th>
                                            <th hidden>Kode Bank</th>
                                            <th>Bank</th>
                                            <th hidden>kode Vendor</th>
                                            <th>Vendor</th>
                                            <th hidden>Kode User</th>
                                            <th>User Input</th>
                                            <th hidden>Created At</th>
                                            <th hidden>User Updated</th>
                                            <th hidden>Updated At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rekening as $val)
                                        <tr>
                                            <th hidden>#</th>
                                            <td>{{ $val->norek }}</td>
                                            <td hidden>{{ $val->kode_bank }}</td>
                                            <td>{{ $val->nama_bank }}</td>
                                            <td hidden>{{ $val->kode_vendor }}</td>
                                            <td>{{ $val->nama_vendor }}</td>
                                            <td hidden>{{ $val->id_user_input }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td hidden>{{ $val->created_at }}</td>
                                            <td hidden>{{ $val->id_user_update }}</td>
                                            <td hidden>{{ $val->updated_at }}</td>
                                            <td align="center">
                                                <form action="{{ route('rekening_fin.destroy', $val->norek) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('rekening_fin.edit', $val->kode_vendor)}}" class="btn btn-warning btn-sm">Ubah</a>
                                                    <button class="btn btn-danger btn-sm" hidden>Hapus</button>
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