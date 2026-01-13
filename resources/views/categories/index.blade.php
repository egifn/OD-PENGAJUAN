@extends('layouts.admin')

@section('title')
	<title>Kategori</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Produk</li>
        <li class="breadcrumb-item active">Kategori</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- BAGIAN INI AKAN MENG-HANDLE FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Kategori</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('category.store') }}" method="post">
                        		@csrf
                        		<div class="form-group">
                        			<label for="name">Kategori</label>
        							<input type="text" name="name" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('name') }}</p>
                        		</div>
                        		<div class="form-group">
                        			<label for="parent_id">Kategori</label>
        							<select name="parent_id" class="form-control">
            							<option value="">None</option>
            							@foreach ($parent as $row)
            								<option value="{{ $row->id }}">{{ $row->name }}</option>
            							@endforeach
        							</select>
        							<p class="text-danger">{{ $errors->first('name') }}</p>
                        		</div>
                        		<div class="form-group">
        							<button class="btn btn-primary btn-sm">Tambah</button>
    							</div>

                        	</form>
                          
                        </div>
                    </div>
                </div>
                <!-- BAGIAN INI AKAN MENG-HANDLE FORM INPUT NEW CATEGORY  -->
              
                <!-- BAGIAN INI AKAN MENG-HANDLE TABLE LIST CATEGORY  -->
                <div class="col-md-8">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Daftar Kategori</h4>
                        </div>
                        <div class="card-body">
                          	<!-- KETIKA ADA SESSION SUCCESS  -->
                            @if (session('success'))
                              <!-- MAKA TAMPILKAN ALERT SUCCESS -->
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori</th>
                                            <th hidden>Parent</th>
                                            <th>Tanggal Input</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($category as $val)
                                        <tr>
                                            <td></td>
                                            <td><strong>{{ $val->name }}</strong></td>
                                            <td hidden>{{ $val->parent ? $val->parent->name:'-' }}</td>
                                            <td>{{ $val->created_at->format('d-M-Y') }}</td>
                                            
                                            <td align="center">
                                                <form action="{{ route('category.destroy', $val->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('category.edit', $val->id) }}" class="btn btn-warning btn-sm">Ubah</a>
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                    <a href="{{ route('category.view', $val->id) }}" class="btn btn-success btn-sm">View</a>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No data available</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            {!! $category->links() !!}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</main>
@endsection