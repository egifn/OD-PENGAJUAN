@extends('layouts.admin')

@section('title')
    <title>Approval SPPD</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item active">Approval SPPD</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Approval SPPD
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('approval_sppd/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
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
                                                <th>No</th>
                                                <th>Id</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Pengajuan Oleh</th>
                                                <th>Divisi</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Sifat</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1 ?>
                                            @forelse($approval_sppd as $val)
                                                @if(Auth::user()->kode_divisi == '16') <!-- Jika Biaya-->
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $val->kode_pengajuan_sppd }}</td>
                                                        <td>{{ $val->tgl_pengajuan_sppd }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td>{{ $val->nama_divisi }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if($val->status_biaya == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_biaya == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_biaya == '2')
                                                                <label class="badge badge-danger">Denied</label>
                                                            @elseif($val->status_biaya == '3')
                                                                <label class="badge badge-warning">Pending</label>
                                                            @endif
                                                        </td>
                                                        <td align="center">   
                                                            <a href="{{ route('approval_sppd/view.view', $val->kode_pengajuan_sppd)  }}" class="btn btn-primary btn-sm">View</a>    
                                                        </td>
                                                    </tr>
                                                    <?php $i++ ?>
                                                @elseif(Auth::user()->kode_divisi == '1')<!-- HRD-->
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $val->kode_pengajuan_sppd }}</td>
                                                        <td>{{ $val->tgl_pengajuan_sppd }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td>{{ $val->nama_divisi }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if($val->status_hrd == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_hrd == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_hrd == '2')
                                                                <label class="badge badge-danger">Denied</label>
                                                            @elseif($val->status_hrd == '3')
                                                                <label class="badge badge-warning">Pending</label>
                                                            @endif
                                                        </td>
                                                        <td align="center">   
                                                            <a href="{{ route('approval_sppd/view.view', $val->kode_pengajuan_sppd)  }}" class="btn btn-primary btn-sm">View</a>   
                                                        </td>
                                                    </tr>
                                                    <?php $i++ ?>
                                                @endif
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data untuk saat ini</td>
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