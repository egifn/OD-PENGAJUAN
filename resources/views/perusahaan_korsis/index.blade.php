@extends('layouts.admin')

@section('title')
	<title>List Perusahaan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
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
                          
                        	<form action="{{ route('perusahaan_korsis.store') }}" method="post">
                        		@csrf
                        		<div class="form-group">
                        			<label for="name">Kode Perusahaan</label>
        							<input type="text" name="kode_perusahaan" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('kode_perusahaan') }}</p>
                        		</div>
                        		<div class="form-group">
                        			<label for="name">Nama Perusahaan</label>
                                    <input type="text" name="nama_perusahaan" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('nama_perusahaan') }}</p>
                        		</div>
                        		<div class="form-group">
        							<button class="btn btn-primary btn-sm">Tambah</button>
    							</div>

                        	</form>
                          
                        </div>
                    </div>
                </div>
                <!-- ############################################################################################  -->
              
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-8">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">List Perusahaan</h4>
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
                                            <th>Kode</th>
                                            <th>Perusahaan</th>
                                            <th hidden>Created At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      	
                                        @forelse ($perusahaan as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td><strong>{{ $val->kode_perusahaan }}</strong></td>
                                            <td>{{ $val->nama_perusahaan }}</td>
                                            <td hidden>{{ $val->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <form action="{{ route('perusahaan_korsis.destroy', $val->kode_perusahaan) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data</td>
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