@extends('layouts.admin')

@section('title')
	<title>Type</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Type</li>
        <li class="breadcrumb-item active">Type</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Add Type</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('type.store') }}" method="post">
                        		@csrf
                        		<div class="form-group">
                        			<label for="name">Code</label>
        							<input type="text" name="kode" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('kode') }}</p>
                        		</div>
                        		<div class="form-group">
                        			<label for="name">Type</label>
                                    <input type="text" name="type" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('type') }}</p>
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
                            <h4 class="card-title">Type</h4>
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
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th hidden>Input By</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      	@forelse ($tipe as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->kode_tipe }}</td>
                                            <td>{{ $val->tipe }}</td>
                                            <td hidden>{{ $val->id_user_input }}</td>
                                            <td align="center">
                                                <form action="#" method="post">
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