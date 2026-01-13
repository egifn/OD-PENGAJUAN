@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Detail Pengajuan Vendor</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item">Pengajuan Vendor</li>
        <li class="breadcrumb-item active">Detail Pengajuan Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Pengajuan Vendor</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Nama Vendor
                                        <input type="text" name="nama_vendor" id="nama_vendor" class="form-control" value="{{ $view_pengajuan_v->nama_vendor }}" readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Alamat
                                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $view_pengajuan_v->alamat }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Telepon
                                        <input type="text" name="telepon" id="telepon" class="form-control" value="{{ $view_pengajuan_v->telepon }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Kategori Vendor
                                        <input type="text" name="kategori" id="kategori" class="form-control" value="{{ $view_pengajuan_v->kategori_vendor }}" readonly>
                                    </div>
                                </div>
                                <div class="row" hidden>   
                                                                        
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <br>
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</main>
@endsection

@section('script')



@endsection




