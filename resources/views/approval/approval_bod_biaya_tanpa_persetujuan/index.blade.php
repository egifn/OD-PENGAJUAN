@extends('layouts.admin')

@section('title')
    <title> Daftar Pengajuan Biaya Tunai Tanpa Persetujuan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Biaya Tunai</li>
        <li class="breadcrumb-item">Tanpa Persetujuan</li>
        <li class="breadcrumb-item active">Daftar Pengajuan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Pengajuan Biaya Tunai Tanpa Persetujuan
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('approval_bod_biaya_tp/cari.cari') }}" method="get">
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
                                                <th hidden>#</th>
                                                <th>Kode Pengajuan</th>
                                                <th>Tgl Pengajuan</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th>Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th>Depo</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Tipe</th>
                                                <th>Status</th>
                                                <th hidden>Approved By</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($approval as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td><strong>{{ $val->kode_pengajuan_b }}</strong></td>
                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                <td>{{ $val->sifat }}</td>
                                                <td align="center">
                                                    @if($val->status == '0')
                                                        <label class="badge badge-secondary">New</label>
                                                    @elseif($val->status == '1')
                                                        <label class="badge badge-success">Approved</label> 
                                                    @elseif($val->status == '2')
                                                        <label class="badge badge-success">Denied</label>  
                                                    @elseif($val->status == '3')
                                                        <label class="badge badge-danger">Pending</label>
                                                    @endif
                                                </td>
                                                <td hidden></td>
                                                <td align="center">
                                                    
                                                        <a href="{{ route('approval_bod_biaya_tp.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                    
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