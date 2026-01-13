@extends('layouts.admin')

@section('title')
    <title>Approval Vendor</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval Vendor</li>
        <li class="breadcrumb-item active">Approval Vendor</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Approval Vendor
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('approval_vendor/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-3 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Id Pengajuan</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Nama Vendor</th>
                                                <th>Alamat</th>
                                                <th>Telepon</th>
                                                <th>Kategori Vendor</th>
                                                <th hidden>Id Pengguna</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($app_vendor as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->kode_pengajuan_v }}</td>
                                                <td>{{ $val->tgl_pengajuan_v }}</td>
                                                <td>{{ $val->nama_vendor }}</td>
                                                <td>{{ $val->alamat }}</td>
                                                <td>{{ $val->telepon }}</td>
                                                <td>{{ $val->kategori_vendor }}</td>
                                                <td hidden>{{ $val->id_user_input }}</td>
                                                <td align="center">
                                                    @if($val->status == '0')
                                                        <label class="badge badge-secondary">Baru</label>
                                                    @elseif($val->status == '1')
                                                        <label class="badge badge-success">Disetujui</label>  
                                                    @elseif($val->status == '2')
                                                        <label class="badge badge-warning">Ditunda</label>
                                                    @elseif($val->status == '3')
                                                        <label class="badge badge-danger">Ditolak</label>    
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    
                                                        <a href="{{ route('approval_vendor/view.view', $val->kode_pengajuan_v) }}" class="btn btn-primary btn-sm">View</a>
                                                    
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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

@endsection