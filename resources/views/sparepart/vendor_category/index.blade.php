@extends('layouts.admin')

@section('title')
	<title>Vendor Category</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Vendor Category</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Add New</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('vendor_category.store') }}" method="post">
                        		@csrf
                        		<div class="form-group">
                        			<label for="id">Id</label>
        							<input type="text" name="id_kat" class="form-control" required>
                        		</div>
                        		<div class="form-group">
                        			<label for="name">Category</label>
                                    <input type="text" name="nama_kat" class="form-control" required>
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
                            <h4 class="card-title">Vendor Category</h4>
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
                                            <th>Id</th>
                                            <th>Category</th>
                                            <th hidden>Created At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($kategori as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->kode_kategori_vendor }}</td>
                                            <td>{{ $val->nama_kategori_vendor }}</td>
                                            <td hidden>{{ $val->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <form action="{{ route('vendor_category.destroy', $val->kode_kategori_vendor) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data Not Found</td>
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