@extends('layouts.admin')

@section('title')
	<title>Sub of Type</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Type</li>
        <li class="breadcrumb-item active">Sub of Type</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Add Sub of Type</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('sub_type.store') }}" method="post">
                        		@csrf
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="kode_tipe" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($tipe as $row)
                                            <option value="{{ $row->kode_tipe }}" {{ old('kode_tipe') == $row->kode_tipe ? 'selected':'' }}>{{ $row->kode_tipe }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{{ $errors->first('type') }}</p>
                                </div>
                                
                        		<div class="form-group">
                        			<label for="name">Code</label>
        							<input type="text" name="kode" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('kode') }}</p>
                        		</div>

                                <div class="form-group">
                                    <label for="name">Sub of Type</label>
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
                            <h4 class="card-title">Sub of Type</h4>
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
                                            <th>Sub Type</th>
                                            <th hidden>Input By</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      	@forelse ($tipe_sub as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->kode_sub }}</td>
                                            <td>{{ $val->tipe }}</td>
                                            <td>{{ $val->sub_tipe }}</td>
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