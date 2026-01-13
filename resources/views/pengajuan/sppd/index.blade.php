@extends('layouts.admin')

@section('title')
    <title>SPPD</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">SPPD</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                SPPD
                                <a href="{{ route('sppd.create') }}" class="btn btn-primary btn-sm float-right">Buat SPPD</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('sppd/cari.cari') }}" method="get">
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
                                                <th>Pelaksana</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Tipe</th>
                                                <th>Status</th>
                                                <th>Disetujui Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @forelse($pengajuan_sppd as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $val->kode_pengajuan_sppd }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_sppd)) }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td>{{ $val->nama_divisi }}</td>
                                                <td>{{ $val->pelaksana }}</td>
                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td hidden>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                <td>{{ $val->sifat }}</td>
                                                <td align="center">
                                                    @if($val->status_biaya == '0' and $val->status_hrd == '0')
                                                        <label class="badge badge-secondary">Kirim</label>
                                                    @elseif($val->status_biaya == '0' and $val->status_hrd == '1')
                                                        <label class="badge badge-primary">Process</label>
                                                    @elseif($val->status_biaya == '0' and $val->status_hrd == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @elseif($val->status_biaya == '0' and $val->status_hrd == '3')
                                                        <label class="badge badge-warning">Pending</label>

                                                    @elseif($val->status_biaya == '0' and $val->status_hrd == '1')
                                                        <label class="badge badge-secondary">Kirim</label>
                                                    @elseif($val->status_biaya == '1' and $val->status_hrd == '1')
                                                        <label class="badge badge-primary">Process</label>
                                                    @elseif($val->status_biaya == '2' and $val->status_hrd == '1')
                                                        <label class="badge badge-primary">Denied</label>
                                                    @elseif($val->status_biaya == '3' and $val->status_hrd == '1')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                   

                                                    <a href="{{ route('sppd/view_approval.view_approval', $val->kode_pengajuan_sppd) }}" target="_blank" class="btn btn-primary btn-sm">View Apprvd</a>


                                                </td>
                                                <td align="center">
                                                    @if(Auth::user()->type == 'Admin')
                                                        <a href="{{ route('sppd/view.view', $val->kode_pengajuan_sppd) }}" class="btn btn-success btn-sm">View</a>
                                                        <a href="{{ route('sppd/pdf.pdf', $val->kode_pengajuan_sppd) }}" class="btn btn-primary btn-sm" target="_blank">Cetak</a>
                                                    @else
                                                        @if($val->status_atasan == '0')
                                                            <a href="{{ route('approval_sppd/view.view', $val->kode_pengajuan_sppd) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                        @elseif($val->status_atasan == '3')
                                                            <a href="{{ route('approval_sppd/view.view', $val->kode_pengajuan_sppd) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                        @endif
                                                        <a href="{{ route('sppd/view.view', $val->kode_pengajuan_sppd) }}" class="btn btn-primary btn-sm">View</a>
                                                        <a href="{{ route('sppd/pdf.pdf', $val->kode_pengajuan_sppd) }}" class="btn btn-primary btn-sm" target="_blank">Cetak</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
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