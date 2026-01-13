@section('js')
<script type="text/javascript">



</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Tambah Tunjangan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Tunjangan</li>
        <li class="breadcrumb-item active">Tambah Tunjangan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Tunjangan</h4>
                        </div>
                        <div class="card-body">

                        	<form action="{{ route('tunjangan/store.store') }}" method="post" enctype="multipart/form-data">
                        		@csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Nama Tunjangan</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Nilai</label>
                                        <input type="text" name="nilai" class="form-control" required>
                                    </div>
                                    
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('tunjangan.index') }}" class="btn btn-secondary">Batal</a>
                                
                        	</form>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection