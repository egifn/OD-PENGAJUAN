@extends('layouts.admin')

@section('title')
	<title>Bank</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item active">Bank</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW BANK  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Add New Bank</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('bank_fin.store') }}" method="post">
                        		@csrf
                        		<div class="form-group">
                        			<label for="bank">Bank</label>
                                    <input type="text" name="nama_bank" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('nama_bank') }}</p>
                        		</div>
                        		<div class="form-group">
        							<button class="btn btn-primary btn-sm">Add</button>
    							</div>

                        	</form>
                          
                        </div>
                    </div>
                </div>
                <!-- ############################################################################################  -->
              
                <!-- TABLE LIST BANK  -->
                <div class="col-md-8">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">List Bank</h4>
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
                                            <th>Bank</th>
                                            <th hidden>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      	
                                        @forelse ($bank as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->nama_bank }}</td>
                                            <td hidden>{{ $val->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <form action="{{ route('bank.destroy', $val->kode_bank) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
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
                            
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection