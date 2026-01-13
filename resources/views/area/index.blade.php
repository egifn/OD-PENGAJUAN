@extends('layouts.admin')

@section('title')
	<title>Area</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Area</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Add Area</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('area.store') }}" method="post">
                        		@csrf
                        		<div class="form-group" hidden>
                        			<label for="name">Area Code</label>
        							<input type="text" name="kode_area" class="form-control">
        							
                        		</div>
                        		<div class="form-group">
                        			<label for="name">Area Name</label>
                                    <input type="text" name="nama_area" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('nama_area') }}</p>
                        		</div>
                        		<div class="form-group">
        							<button class="btn btn-primary btn-sm"> A d d </button>
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
                            <h4 class="card-title">List Area</h4>
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
                                            <th>Area Code</th>
                                            <th>Area Name</th>
                                            <th hidden>Created At</th>
                                            <th hidden>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      	
                                        @forelse ($area as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td><strong>{{ $val->kode_area }}</strong></td>
                                            <td>{{ $val->nama_area }}</td>
                                            <td hidden>{{ $val->created_at->format('d-m-Y') }}</td>
                                            <td align="center" hidden>
                                                <form action="{{ route('area.destroy', $val->kode_area) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data Not found</td>
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