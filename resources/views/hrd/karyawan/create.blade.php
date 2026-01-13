@section('js')
<script type="text/javascript">



</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Tambah Karyawan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Karyawan</li>
        <li class="breadcrumb-item active">Tambah Karyawan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Karyawan</h4>
                        </div>
                        <div class="card-body">

                        	<form action="{{ route('karyawan/store.store') }}" method="post" enctype="multipart/form-data">
                        		@csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Telp</label>
                                        <input type="text" name="tlp" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>NIK</label>
                                        <input type="text" name="nik" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>ID DMS</label>
                                        <input type="text" name="id_dms" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Perusahaan</label>
                                        <input type="text" name="perusahaan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Depo</label>
                                        <select name="depo" class="form-control">
                                            <option value="">-- Pilih Depo --</option>
                                            @foreach($depo as $depo)
                                                <option value="{{ $depo->kode_depo }}">{{ $depo->nama_depo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Area</label>
                                        <select name="area" class="form-control">
                                            <option value="">-- Pilih Area --</option>
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Tanggal Gabung</label>
                                        <input type="date" name="tgl_gabung" class="form-control">
                                    </div>
                                    
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
                                
                        	</form>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection