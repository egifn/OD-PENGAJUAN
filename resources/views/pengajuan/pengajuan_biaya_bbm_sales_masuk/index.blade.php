@extends('layouts.admin')

@section('title')
    <title>Pengajuan Masuk Biaya BBM</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Pengajuan Masuk Biaya BBM</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Masuk Biaya BBM
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_biaya_masuk_bbm/cari_index.cari_index') }}" method="get">
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
                                                <th hidden>No</th>
                                                <th>Kode Pengajuan</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Perusahaan</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Company Name</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo Name</th>
                                                <th>Depo</th>
                                                <th>Pengajuan</th>
                                                <th>Periode</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Yang Mengajukan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pengajuan_bbm as $val)
                                            @if(Auth::user()->kode_divisi == '36') <!-- jika divisi spv Fleet -->
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                <td hidden>{{ $val->kode_perusahaan}}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kategori }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td>{{ $val->no_surat_program }}</td> <!-- isi ini adalah Periode Pengisian -->
                                                <td align="right">{{ number_format($val->tharga) }}</td>
                                                <td align="center">
                                                    @if($val->status_atasan == '0')
                                                        <label class="badge badge-secondary">New</label>
                                                    @elseif($val->status_atasan == '1')
                                                        <label class="badge badge-success">Approved</label>
                                                    @elseif($val->status_atasan == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @elseif($val->status_atasan == '3')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @endif
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    <a href="{{ route('pengajuan_biaya_masuk_bbm/view.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                </td>
                                            </tr>
                                            @elseif(Auth::user()->kode_divisi == '9') <!-- jika divisi ops depo -->
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                <td hidden>{{ $val->kode_perusahaan}}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kategori }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td>{{ $val->no_surat_program }}</td> <!-- isi ini adalah Periode Pengisian -->
                                                <td align="right">{{ number_format($val->tharga) }}</td>
                                                <td align="center">
                                                    @if($val->status_som == '0')
                                                        <label class="badge badge-secondary">New</label>
                                                    @elseif($val->status_som == '1')
                                                        <label class="badge badge-success">Approved</label>
                                                    @elseif($val->status_som == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @elseif($val->status_som == '3')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @endif
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    <a href="{{ route('pengajuan_biaya_masuk_bbm/view.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                </td>
                                            </tr>
                                            @elseif(Auth::user()->kode_divisi == '6') <!-- jika divisi biaya akunting -->
                                            
                                            @endif
                                            @empty
                                            <tr>
                                                <td colspan="12" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                         
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