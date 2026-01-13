@extends('layouts.admin')

@section('title')
	<title>Divisi</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Division</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Add New Division</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('divisi.store') }}" method="post">
                        		@csrf
                        		<div class="form-group">
                        			<label for="name">Division Name</label>
                                    <input type="text" name="nama_divisi" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('nama_divisi') }}</p>
                        		</div>
                                <div class="form">
                                    <label for="head">Head of Division</label>
                                    <input type="text" name="kepala_divisi" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('kepala_divisi') }}</p>
                                </div>
                        		<div class="form-group">
        							<button class="btn btn-primary btn-sm">Add</button>
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
                            <h4 class="card-title">List Division</h4>
                        </div>
                        <div class="card-body">
                            

                            <!-- BUAT FORM UNTUK PENCARIAN, METHODNYA ADALAH GET -->
                            <form action="{{ route('divisi.cari') }}" method="get">
                                <div class="input-group mb-2 col-md-6 float-right">
                                    <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ request()->q }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th hidden>Kode</th>
                                            <th>Division Name</th>
                                            <th>head of Division</th>
                                            <th hidden>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      	
                                        @forelse ($divisi as $val)
                                        <tr>
                                            <td hidden>#</td>
                                            <td hidden>{{ $val->kode_divisi }}</td>
                                            <td>{{ $val->nama_divisi }}</td>
                                            <td>{{ $val->kepala_divisi }}</td>
                                            <td hidden>{{ $val->created_at->format('d-m-Y') }}</td>
                                            <td align="center">
                                                <form action="{{ route('divisi.destroy', $val->kode_divisi) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
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
                            {!! $divisi->links() !!}
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection