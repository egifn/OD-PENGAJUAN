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
	<title>Edit Checker</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Edit Checker</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-4">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Edit Checker</h4>
                        </div>
                        <div class="card-body">
                          
                        	<form action="{{ route('checker.update') }}" method="post">
                        		@csrf
                                @method('PUT')
                                <div class="form-group" hidden>
                                    Id Chacker
                                    <input type="text" name="id" class="form-control" value="{{ $checker->id_checker }}" required>
                                </div>

                        		<div class="form-group">
                        			Nama Chacker
        							<input type="text" name="nama" class="form-control" value="{{ $checker->nama_checker }}" required>
                        		</div>
                        		<div class="form-group">
                        			Perusahaan
                                    <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                        <option value="{{ $checker->kode_perusahaan }}" {{ old('kode_perusahaan') == $checker->kode_perusahaan ? 'selected':'' }}">{{ $checker->nama_perusahaan }}</option>
                                        @foreach ($perusahaan as $row)
                                            <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                        @endforeach 
                                    </select>
                        		</div>
                                <div class="form-group">
                                    Depo
                                    <select name="kode_depo" id="kode_depo" class="form-control">
                                        <option value="{{ $checker->kode_depo }}" {{ old('kode_depo') == $checker->kode_depo? 'selected':'' }}">{{ $checker->nama_depo }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Kategori
                                    <select name="kategori_produk" id="kategori_produk" class="form-control">
                                        <option value="{{ $checker->kategori }}">{{ $checker->kategori }}</option>
                                        <option value="Layak">Layak</option>
                                        <option value="BS">BS</option>
                                    </select>
                                </div>
                        		<div class="form-group" align="right">
        							<button class="btn btn-primary btn-sm">Simpan</button>
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