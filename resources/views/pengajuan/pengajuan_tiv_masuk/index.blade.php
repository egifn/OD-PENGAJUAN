@extends('layouts.admin')

@section('title')
    <title>Pengajuan Masuk</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan Masuk</li>
        <li class="breadcrumb-item active">Pengajuan TIV</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Masuk Pengajuan TIV
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_tiv_masuk/cari.cari') }}" method="get">
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
                                                <th hidden>Kode Depo</th>
                                                <th>Keterangan</th>
                                                <th>No Surat</th>
                                                <th>Status</th>
                                                <th>Pengajuan Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($approval_cost as $val)
                                                @if(Auth::user()->kode_perusahaan == 'ARS')
                                                    @if(Auth::user()->kode_divisi == '2')
                                                        <tr>
                                                            <td hidden>{{ $val->no_urut }}</td>
                                                            <td>{{ $val->kode_pengajuan_b }}</td>
                                                            <td>{{ $val->tgl_pengajuan_b }}</td>
                                                            <td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                            <td hidden>{{ $val->kode_perusahaan}}</td>
                                                            <td hidden>{{ $val->kode_depo }}</td>
                                                            <td>{{ $val->keterangan }}</td>
                                                            <td>{{ $val->no_surat_program }}</td>
                                                            <td align="center">
                                                                @if($val->status_validasi_clm == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_validasi_clm == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_validasi_clm == '2')
                                                                    <label class="badge badge-danger">Denied</label>
                                                                @elseif($val->status_validasi_clm == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->name }}</td>
                                                            
                                                            <td align="center">
                                                                {{-- <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> --}}
                                                                <a href="{{ route('pengajuan_tiv_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @else
                                                    @if(Auth::user()->kode_divisi == '10')<!-- CLAIM-->
                                                        <tr>
                                                            <td hidden>{{ $val->no_urut }}</td>
                                                            <td>{{ $val->kode_pengajuan_b }}</td>
                                                            <td>{{ $val->tgl_pengajuan_b }}</td>
                                                            <td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                            <td hidden>{{ $val->kode_perusahaan}}</td>
                                                            <td hidden>{{ $val->kode_depo }}</td>
                                                            <td>{{ $val->keterangan }}</td>
                                                            <td>{{ $val->no_surat_program }}</td>
                                                            <td align="center">
                                                                @if($val->status_validasi_clm == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_validasi_clm == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_validasi_clm == '2')
                                                                    <label class="badge badge-danger">Denied</label>
                                                                @elseif($val->status_validasi_clm == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->name }}</td>
                                                            
                                                            <td align="center">
                                                                {{-- <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> --}}
                                                                <a href="{{ route('pengajuan_tiv_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                    @elseif(Auth::user()->kode_divisi == '24')<!-- Piutang-->
                                                        <tr>
                                                            <td hidden>{{ $val->no_urut }}</td>
                                                            <td>{{ $val->kode_pengajuan_b }}</td>
                                                            <td>{{ $val->tgl_pengajuan_b }}</td>
                                                            <td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                            <td hidden>{{ $val->kode_perusahaan}}</td>
                                                            <td hidden>{{ $val->kode_depo }}</td>
                                                            <td>{{ $val->keterangan }}</td>
                                                            <td>{{ $val->no_surat_program }}</td>
                                                            <td align="center">
                                                                @if($val->status_validasi_piutang == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_validasi_piutang == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_validasi_piutang == '2')
                                                                    <label class="badge badge-danger">Denied</label>
                                                                @elseif($val->status_validasi_piutang == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->name }}</td>
                                                            
                                                            <td align="center">
                                                                {{-- <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> --}}
                                                                <a href="{{ route('pengajuan_tiv_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                    
                                                    @elseif(Auth::user()->kode_divisi == '30')<!-- Non Gudang-->
                                                        <tr>
                                                            <td hidden>{{ $val->no_urut }}</td>
                                                            <td>{{ $val->kode_pengajuan_b }}</td>
                                                            <td>{{ $val->tgl_pengajuan_b }}</td>
                                                            <td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                            <td hidden>{{ $val->kode_perusahaan}}</td>
                                                            <td hidden>{{ $val->kode_depo }}</td>
                                                            <td>{{ $val->keterangan }}</td>
                                                            <td>{{ $val->no_surat_program }}</td>
                                                            <td align="center">
                                                                @if($val->status_validasi_ng == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_validasi_ng == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_validasi_ng == '2')
                                                                    <label class="badge badge-danger">Denied</label>
                                                                @elseif($val->status_validasi_ng == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->name }}</td>
                                                            
                                                            <td align="center">
                                                                {{-- <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> --}}
                                                                <a href="{{ route('pengajuan_tiv_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                    @elseif(Auth::user()->kode_divisi == '6')<!-- Piutang Akunting -->
                                                        @if(Auth::user()->kode_sub_divisi == '2')
                                                        <tr>
                                                            <td hidden>{{ $val->no_urut }}</td>
                                                            <td>{{ $val->kode_pengajuan_b }}</td>
                                                            <td>{{ $val->tgl_pengajuan_b }}</td>
                                                            <td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                            <td hidden>{{ $val->kode_perusahaan}}</td>
                                                            <td hidden>{{ $val->kode_depo }}</td>
                                                            <td>{{ $val->keterangan }}</td>
                                                            <td>{{ $val->no_surat_program }}</td>
                                                            <td align="center">
                                                                @if($val->status_validasi_piutang == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_validasi_piutang == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_validasi_piutang == '2')
                                                                    <label class="badge badge-danger">Denied</label>
                                                                @elseif($val->status_validasi_piutang == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->name }}</td>
                                                            
                                                            <td align="center">
                                                                {{-- <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> --}}
                                                                <a href="{{ route('pengajuan_tiv_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                        @else
                                                        <tr>
                                                            <td hidden>{{ $val->no_urut }}</td>
                                                            <td>{{ $val->kode_pengajuan_b }}</td>
                                                            <td>{{ $val->tgl_pengajuan_b }}</td>
                                                            <td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                            <td hidden>{{ $val->kode_perusahaan}}</td>
                                                            <td hidden>{{ $val->kode_depo }}</td>
                                                            <td>{{ $val->keterangan }}</td>
                                                            <td>{{ $val->no_surat_program }}</td>
                                                            <td align="center">
                                                                @if($val->status_validasi == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_validasi == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_validasi == '2')
                                                                    <label class="badge badge-danger">Denied</label>
                                                                @elseif($val->status_validasi == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->name }}</td>
                                                            
                                                            <td align="center">
                                                                {{-- <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> --}}
                                                                <a href="{{ route('pengajuan_tiv_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        
                                                    @elseif(Auth::user()->kode_divisi == '16')<!-- Biaya-->
                                                        <tr>
                                                            <td hidden>{{ $val->no_urut }}</td>
                                                            <td>{{ $val->kode_pengajuan_b }}</td>
                                                            <td>{{ $val->tgl_pengajuan_b }}</td>
                                                            <td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                            <td hidden>{{ $val->kode_perusahaan}}</td>
                                                            <td hidden>{{ $val->kode_depo }}</td>
                                                            <td>{{ $val->keterangan }}</td>
                                                            <td>{{ $val->no_surat_program }}</td>
                                                            <td align="center">
                                                                @if($val->status_validasi == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_validasi == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_validasi == '2')
                                                                    <label class="badge badge-danger">Denied</label>
                                                                @elseif($val->status_validasi == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->name }}</td>
                                                            
                                                            <td align="center">
                                                                {{-- <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> --}}
                                                                <a href="{{ route('pengajuan_tiv_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                    
                                                    @endif
                                                @endif
                                                
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Data Not Found</td>
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