@extends('layouts.admin')

@section('title')
	<title>Area Sub</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Area Sub</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Add Area Sub</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('area_sub.store') }}" method="post" enctype="multipart/form-data">
                        		@csrf
                        		<div class="form-group">
                        			<label for="kode_sub">Area Sub Code</label>
        							<input type="text" name="kode_sub" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('kode_depo`') }}</p>
                        		</div>
                        		<div class="form-group">
                        			<label for="kode_area">Area Sub</label>
                                    
                                    <select name="kode_area" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($area as $row)
                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{{ $errors->first('kode_area') }}</p>
                        		</div>
                                <div class="form-group">
                                    <label for="nama_sub">Area Sub Name</label>
                                    <input type="text" name="nama_sub" class="form-control">
                                </div>
                        		<div class="form-group">
        							<button class="btn btn-primary btn-sm">A d d</button>
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
                            <h4 class="card-title">Area Sub</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Area Sub Code</th>
                                            <th>Area Sub Name</th>
                                            <th hidden>Area Code</th>
                                            <th>Area Name</th>
                                            <th hidden>Created At</th>
                                            <th hidden>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($area_sub as $val)
                                        <tr>
                                            <td></td>
                                            <td><strong>{{ $val->kode_sub_area }}</strong></td>
                                            <td>{{ $val->nama_sub_area }}</td>
                                            <td hidden>{{ $val->kode_area }}</td>
                                            <td>{{ $val->nama_area }}</td>
                                            <td hidden>{{ $val->created_at }}</td>
                                            <td align="center" hidden>
                                                <form action="{{ route('area_sub.destroy', $val->kode_sub_area) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data not found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            {!! $area_sub->links() !!}
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection