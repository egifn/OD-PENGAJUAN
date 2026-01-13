@section('js')
<script type="text/javascript">
    
$(function(){
    $('#kode_perusahaan').change(function(){
        var perusahaan_id = $(this).val();
        if(perusahaan_id){
            $.ajax({
                type:"GET",
                url:"/ajax?perusahaan_id="+perusahaan_id,
                dataType:'JSON',
                success: function(res){
                    if(res){
                        $("#kode_depo").empty();
                        $("#kode_depo").append('<option>Select</option>');
                        $.each(res,function(nama,kode){
                            $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                        });
                    }else{
                        $("#kode_depo").empty();
                    }
                }
            });
        }else{
            $("#kode_depo").empty();
        }
    });
});

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Checker</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Checker</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Checker</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('checker.store') }}" method="post" enctype="multipart/form-data">
                        		@csrf
                        		<div class="form-group">
                        			Nama Chacker
        							<input type="text" name="nama" class="form-control" required>
                        		</div>
                        		<div class="form-group">
                        			Perusahaan
                                    <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                        <option value="">Pilih</option>
                                        @foreach ($perusahaan as $row)
                                            <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                        @endforeach 
                                    </select>
                        		</div>
                                <div class="form-group">
                                    Depo
                                    <select name="kode_depo" id="kode_depo" class="form-control">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Kategori
                                    <select name="kategori_produk" id="kategori_produk" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="Layak">Layak</option>
                                        <option value="BS">BS</option>
                                    </select>
                                </div>
                        		<div class="form-group" align="right">
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
                            <h4 class="card-title">Checker</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th>Nama Chacker</th>
                                            <th>Perusahaan</th>
                                            <th>Depo</th>
                                            <th>Kategori</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($checker as $val)
                                        <tr>
                                            <td hidden>{{ $val->id_checker }}</td>
                                            <td>{{ $val->nama_checker }}</td>
                                            <td>{{ $val->nama_perusahaan }}</td>
                                            <td>{{ $val->nama_depo }}</td>
                                            <td>{{ $val->kategori }}</td>
                                            <td align="center">
                                                <form action="{{ route('checker.destroy', $val->id_checker) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    
                                                    <a href="{{ route('checker.view', $val->id_checker) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    &nbsp;
                                                    
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
                           
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection