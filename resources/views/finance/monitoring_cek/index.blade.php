@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script> 
    $(document).ready(function() {
        //INISIASI DATERANGEPICKER
        $('#tanggal').daterangepicker({
               
        })        
    })
</script>


<script type="text/javascript">
    fetchAllDataMonitoring();
    function fetchAllDataMonitoring(){
        
    }
</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Monitoring Transaksi</title>
@endsection

@section('content')

<main class="main">
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Monitoring Transaksi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Monitoring Cheque dan Transfer
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12 mb-4">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#cek" role="tab" aria-controls="cek">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Monitoring Cek (Tanpa Token)</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#cek_verifikasi" role="tab" aria-controls="cek_verifikasi">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Monitoring Cek dengan Token Verifikasi</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#cek_token" role="tab" aria-controls="cek_token">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Monitoring Cek yang ada Token</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#token" role="tab" aria-controls="token">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Monitoring Token</b>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="cek" role="tabpanel">      
                                        <div>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="#" method="get">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                    </div>
                    
                                                    <div class="col-md-5 mb-2">
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-2">
                                                        <div class="input-group mb-2">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Entitas</th>
                                                            <th>No. Rekening</th>
                                                            <th>Fungsi Rekening</th>
                                                            <th>Nama Bank</th>
                                                            <th>Internet Banking</th>
                                                            <th>Token</th>
                                                            <th>Jml Pemegang Token Viewer</th>
                                                            <th>Jml Pemegang Token Master</th>
                                                            <th>Jml Pemegang Token Verifier</th>
                                                            <th>Jml Pemegang Token Authorizer</th>
                                                            <th>Jml Pemegang Token Total</th>
                                                            <th>Cek Sesama Perusahaan</th>
                                                            <th>Cek Untuk Vendor</th>
                                                            <th>Buku Cek Sudah Diminta ke Bank</th>
                                                            <th>Buku Cek Sudah Didaftarkan</th>
                                                            <th>Tujuan</th>
                                                            <th>Nominal</th>
                                                            <th>Sdh Dittd 1 / 2</th>
                                                            <th>Sdh Diserahkan ke Vendor / Bank</th>
                                                            <th>Upload</th>
                                                            <th>Verifikasi</th>
                                                            <th>Otorisasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="cek_verifikasi" role="tabpanel">
                                        <div>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('pengajuan_cek_giro/cari.cari') }}" method="get">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                    </div>
                    
                                                    <div class="col-md-5 mb-2">
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-2">
                                                        <!-- <div class="input-group mb-2">
                                                            <input type="text" id="tanggal_terima" name="tanggal_terima" class="form-control" value="{{ request()->tanggal_terima }}">
                                                            <div class="input-group-append">
                                                                {{-- <button class="btn btn-secondary" type="button" name="button_cari_tanggal_terima" id="button_cari_tanggal_terima" value="tgl">Cari</button> --}}
                                                                <button class="btn btn-secondary" type="submit">C a r i</button>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Entitas</th>
                                                            <th>No. Rekening</th>
                                                            <th>Fungsi Rekening</th>
                                                            <th>Nama Bank</th>
                                                            <th>Internet Banking</th>
                                                            <th>Token</th>
                                                            <th>Jml Pemegang Token Viewer</th>
                                                            <th>Jml Pemegang Token Master</th>
                                                            <th>Jml Pemegang Token Verifier</th>
                                                            <th>Jml Pemegang Token Authorizer</th>
                                                            <th>Jml Pemegang Token Total</th>
                                                            <th>Cek Sesama Perusahaan</th>
                                                            <th>Cek Untuk Vendor</th>
                                                            <th>Buku Cek Sudah Diminta ke Bank</th>
                                                            <th>Buku Cek Sudah Didaftarkan</th>
                                                            <th>Tujuan</th>
                                                            <th>Nominal</th>
                                                            <th>Sdh Dittd 1 / 2</th>
                                                            <th>Sdh Diserahkan ke Vendor / Bank</th>
                                                            <th>Upload</th>
                                                            <th>Verifikasi</th>
                                                            <th>Otorisasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="cek_token" role="tabpanel">
                                        <div>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('pengajuan_cek_giro/cari.cari') }}" method="get">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                    </div>
                    
                                                    <div class="col-md-5 mb-2">
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-2">
                                                        <!-- <div class="input-group mb-2">
                                                            <input type="text" id="tanggal_terima" name="tanggal_terima" class="form-control" value="{{ request()->tanggal_terima }}">
                                                            <div class="input-group-append">
                                                                {{-- <button class="btn btn-secondary" type="button" name="button_cari_tanggal_terima" id="button_cari_tanggal_terima" value="tgl">Cari</button> --}}
                                                                <button class="btn btn-secondary" type="submit">C a r i</button>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Entitas</th>
                                                            <th>No. Rekening</th>
                                                            <th>Fungsi Rekening</th>
                                                            <th>Nama Bank</th>
                                                            <th>Internet Banking</th>
                                                            <th>Token</th>
                                                            <th>Jml Pemegang Token Viewer</th>
                                                            <th>Jml Pemegang Token Master</th>
                                                            <th>Jml Pemegang Token Verifier</th>
                                                            <th>Jml Pemegang Token Authorizer</th>
                                                            <th>Jml Pemegang Token Total</th>
                                                            <th>Cek Sesama Perusahaan</th>
                                                            <th>Cek Untuk Vendor</th>
                                                            <th>Buku Cek Sudah Diminta ke Bank</th>
                                                            <th>Buku Cek Sudah Didaftarkan</th>
                                                            <th>Tujuan</th>
                                                            <th>Nominal</th>
                                                            <th>Sdh Dittd 1 / 2</th>
                                                            <th>Sdh Diserahkan ke Vendor / Bank</th>
                                                            <th>Upload</th>
                                                            <th>Verifikasi</th>
                                                            <th>Otorisasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="token" role="tabpanel">
                                        <div>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('pengajuan_cek_giro/cari.cari') }}" method="get">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                    </div>
                    
                                                    <div class="col-md-5 mb-2">
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-2">
                                                        <!-- <div class="input-group mb-2">
                                                            <input type="text" id="tanggal_terima" name="tanggal_terima" class="form-control" value="{{ request()->tanggal_terima }}">
                                                            <div class="input-group-append">
                                                                {{-- <button class="btn btn-secondary" type="button" name="button_cari_tanggal_terima" id="button_cari_tanggal_terima" value="tgl">Cari</button> --}}
                                                                <button class="btn btn-secondary" type="submit">C a r i</button>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Entitas</th>
                                                            <th>No. Rekening</th>
                                                            <th>Fungsi Rekening</th>
                                                            <th>Nama Bank</th>
                                                            <th>Internet Banking</th>
                                                            <th>Token</th>
                                                            <th>Jml Pemegang Token Viewer</th>
                                                            <th>Jml Pemegang Token Master</th>
                                                            <th>Jml Pemegang Token Verifier</th>
                                                            <th>Jml Pemegang Token Authorizer</th>
                                                            <th>Jml Pemegang Token Total</th>
                                                            <th>Cek Sesama Perusahaan</th>
                                                            <th>Cek Untuk Vendor</th>
                                                            <th>Buku Cek Sudah Diminta ke Bank</th>
                                                            <th>Buku Cek Sudah Didaftarkan</th>
                                                            <th>Tujuan</th>
                                                            <th>Nominal</th>
                                                            <th>Sdh Dittd 1 / 2</th>
                                                            <th>Sdh Diserahkan ke Vendor / Bank</th>
                                                            <th>Upload</th>
                                                            <th>Verifikasi</th>
                                                            <th>Otorisasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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