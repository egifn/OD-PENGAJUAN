@extends('layouts.admin')

@section('title')
    <title>Pengajuan Masuk</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Pengajuan Masuk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Masuk
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_masuk/cari.cari') }}" method="get">
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
                                                <th hidden>no urut</th>
                                                <th>id Pengajuan</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Pengajuan Oleh</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th style="width: 15%;">Nama Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Nama Depo</th>
                                                <th style="width: 15%;">Nama Pengeluaran</th>
                                                <th>Tipe</th>
												@if(Auth::user()->kode_divisi == '4')
                                                    <th>Status App</th>
                                                @endif
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pengajuan_masuk as $val)
                                                @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td>{{ $val->kode_pengajuan }}</td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if($val->status_validasi_adm_it == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_validasi_adm_it == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_validasi_adm_it == '2')
                                                                <label class="badge badge-danger">Denied</label>
                                                            @elseif($val->status_validasi_adm_it == '3')
                                                                <label class="badge badge-warning">Pending</label>
                                                            @endif
                                                        </td>
                                                        <td align="center">
                                                            <a href="{{ route('pengajuan_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '4')<!-- GA-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td>{{ $val->kode_pengajuan }}</td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
														<td align="center">
                                                            @if($val->status_atasan == '0' && $val->status_it == '0' && $val->status_ops == '0')
                                                                <label class="badge badge-secondary" style="color: rgb(253, 250, 250);">Divisi</label>
                                                                <label class="badge badge-secondary" style="color: rgb(253, 250, 250);">IT</label>
                                                                <label class="badge badge-secondary" style="color: rgb(253, 250, 250);">OPS</label>
                                                            @elseif($val->status_atasan == '1' && $val->status_it == '0' && $val->status_ops == '0')
                                                                <label class="badge badge-success">Divisi</label>
                                                                <label class="badge badge-secondary" style="color: rgb(253, 250, 250);">IT</label>
                                                                <label class="badge badge-secondary" style="color: rgb(253, 250, 250);">OPS</label>
                                                            @elseif($val->status_atasan == '1' && $val->status_it == '1' && $val->status_ops == '0')
                                                                <label class="badge badge-success">Divisi</label>
                                                                <label class="badge badge-success">IT</label>
                                                                <label class="badge badge-secondary" style="color: rgb(253, 250, 250);">OPS</label>
                                                            @elseif($val->status_atasan == '1' && $val->status_it == '1' && $val->status_ops == '1')
                                                                <label class="badge badge-success">Divisi</label>
                                                                <label class="badge badge-success">IT</label>
                                                                <label class="badge badge-success">OPS</label>
                                                            @endif
                                                        </td>
                                                        <td align="center">
                                                            @if($val->status_validasi_adm_ga == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_validasi_adm_ga == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_validasi_adm_ga == '2')
                                                                <label class="badge badge-danger">Denied</label>
                                                            @elseif($val->status_validasi_adm_ga == '3')
                                                                <label class="badge badge-warning">Pending</label>
                                                            @endif
                                                        </td>
                                                        <td align="center">
                                                            @if($val->status_atasan == '1' && $val->status_it == '1' && $val->status_ops == '1')
                                                                <a href="{{ route('pengajuan_masuk/view.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                            @else
                                                                <button class="btn btn-success btn-sm" disabled>View</button>
                                                            @endif
															<a href="{{ route('pengajuan_masuk/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>
														</td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '2')<!-- OPS-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td>{{ $val->kode_pengajuan }}</td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if($val->status_validasi_adm_ops == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_validasi_adm_ops == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_validasi_adm_ops == '2')
                                                                <label class="badge badge-danger">Denied</label>
                                                            @elseif($val->status_validasi_adm_ops == '3')
                                                                <label class="badge badge-warning">Pending</label>
                                                            @endif
                                                        </td>
                                                        <td align="center">
                                                            <a href="{{ route('pengajuan_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '11')<!-- purchasing-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td>{{ $val->kode_pengajuan }}</td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if($val->status_validasi_adm_pc == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_validasi_adm_pc == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_validasi_adm_pc == '2')
                                                                <label class="badge badge-danger">Denied</label>
                                                            @elseif($val->status_validasi_adm_pc == '3')
                                                                <label class="badge badge-warning">Pending</label>
                                                            @endif
                                                        </td>
                                                        <td align="center">
															<a href="{{ route('pengajuan_masuk/view.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                            <a href="{{ route('pengajuan_masuk/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                            <tr>
                                                <td colspan="12" class="text-center">Data Not Found</td>
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