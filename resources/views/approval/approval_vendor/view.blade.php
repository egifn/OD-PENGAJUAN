@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Detail Approval Vendor</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval Vendor</li>
        <li class="breadcrumb-item">Approval Vendor</li>
        <li class="breadcrumb-item active">Detail Approval Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('approval_vendor.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Approval Vendor</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2" hidden>
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan_v" id="kode_pengajuan_v" class="form-control" value="{{ $v_app_vendor->kode_pengajuan_v }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Nama Vendor
                                        <input type="text" name="nama_vendor" id="nama_vendor" class="form-control" value="{{ $v_app_vendor->nama_vendor }}" readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Alamat
                                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $v_app_vendor->alamat }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Telepon
                                        <input type="text" name="telepon" id="telepon" class="form-control" value="{{ $v_app_vendor->telepon }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Kategori Vendor
                                        <input type="text" name="kategori" id="kategori" class="form-control" value="{{ $v_app_vendor->kategori_vendor }}" readonly>
                                    </div>
                                </div>
                                <div class="row" hidden>   
                                                                        
                                </div>
                                
                                <div class="row">
                                    @if($v_app_vendor->status  == '0') <!-- Baru -->
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            
                                            <button class="btn btn-success btn-sm">Approved</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <a href="{{ route('approval_vendor_denied', $v_app_vendor->kode_pengajuan_v) }}" class="btn btn-danger btn-sm">Denied</a>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <a href="{{ route('approval_vendor_pending', $v_app_vendor->kode_pengajuan_v) }}" class="btn btn-warning btn-sm">Pending</a>
                                        </div>
                                    @elseif($v_app_vendor->status  == '1') <!-- disetujui -->
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($v_app_vendor->status  == '2') <!-- ditunda -->
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <button class="btn btn-success btn-sm">Approved</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <a href="{{ route('approval_vendor_denied', $v_app_vendor->kode_pengajuan_v) }}" class="btn btn-danger btn-sm">Denied</a>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <a href="{{ route('approval_vendor_pending', $v_app_vendor->kode_pengajuan_v) }}" class="btn btn-warning btn-sm">Pending</a>
                                        </div>
                                    @elseif($v_app_vendor->status  == '3') <!-- Titolak -->
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @endif
                                    <div class="col-md-9 mb-2">
                                        <br>
                                        <!-- <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('script')



@endsection




