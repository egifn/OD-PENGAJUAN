@extends('layouts.admin')

@section('title')
	<title>Coa</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Chart Of Account</li>
        <li class="breadcrumb-item active">COA Layer 1</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- BAGIAN INI AKAN MENG-HANDLE FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah layer</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('coa_1.store') }}" method="post">
                        		@csrf
                        		<div class="form-group">
                        			<label for="kode">Kode</label>
        							<input type="text" name="kode" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('kode') }}</p>
                        		</div>
                        		<div class="form-group">
                        			<label for="acc">Account</label>
                                    <input type="text" name="acc" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('acc') }}</p>
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
                            <h4 class="card-title">Account Layer 1</h4>
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
                                            <th hidden>#</th>
                                            <th>kode</th>
                                            <th>Account</th>
                                            <th hidden>Tanggal Input</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($coa_1 as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->kode_lv1 }}</td>
                                            <td>{{ $val->account_name }}</td>
                                            <td hidden>{{ $val->created_at->format('d-M-Y') }}</td>
                                            
                                            <td>
                                                <form action="{{ route('coa_1.destroy', $val->kode_lv1) }}" method="post">
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
                            
                            {!! $coa_1->links() !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4" hidden>
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Import layer</h4>
                        </div>
                        <div class="card-body">
                          
                            <form action="{{ route('coa_1.storeData') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    
                                        <label for="">File (.xls, .xlsx)</label>
                                        <input type="file" name="file" class="form-control" value="{{ old('file') }}" required>
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                    
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">Import</button>
                                </div>

                            </form>
                          
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</main>
@endsection