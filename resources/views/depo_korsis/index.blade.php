@extends('layouts.admin')

@section('title')
	<title>List Depo</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Depo</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Depo</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('depo_korsis.store') }}" method="post" enctype="multipart/form-data">
                        		@csrf
                        		<div class="form-group">
                        			<label for="kode_depo">Kode Depo</label>
        							<input type="text" name="kode_depo" class="form-control" required>
        							<p class="text-danger">{{ $errors->first('kode_depo`') }}</p>
                        		</div>
                        		<div class="form-group">
                        			<label for="nama_depo">Nama Depo</label>
                                    <input type="text" name="nama_depo" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('nama_depo') }}</p>
                        		</div>
                                <div class="form-group">
                                    <label for="alias">Alias</label>
                                    <input type="text" name="alias" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="kode_perusahaan">Perusahaan</label>
                                    
                                    <select name="kode_perusahaan" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($perusahaan as $row)
                                            <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{{ $errors->first('kode_perusahaan') }}</p>
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
                            <h4 class="card-title">List Depo</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('depo_korsis.cari') }}" method="get">
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
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Depo</th>
                                            <th hidden>kode perusahaan</th>
                                            <th>Perusahaan</th>
                                            <th hidden>Created At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($depo as $val)
                                        <tr>
                                            <td></td>
                                            <td><strong>{{ $val->kode_depo }}</strong></td>
                                            <td>{{ $val->nama_depo }}</td>
                                            <td hidden>{{ $val->kode_perusahaan }}</td>
                                            <td>{{ $val->nama_perusahaan }}</td>
                                            <td hidden>{{ $val->created_at }}</td>
                                            <td>
                                                <form action="{{ route('depo_korsis.destroy', $val->kode_depo) }}" method="post">
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
                            {!! $depo->links() !!}
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection