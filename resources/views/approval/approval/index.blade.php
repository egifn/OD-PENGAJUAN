@extends('layouts.admin')

@section('title')
    <title>Approval</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item active">Approval</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Approval
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('approval/cari.cari') }}" method="get">
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
                                                <th hidden>no_urut</th>
                                                <th>Request Id</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Yang Mengajukan</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Nama Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Nama Depo</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Tipe</th>
                                                <th>Status</th>
                                                <th>Validator</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($approval as $val)
                                                @if(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td><strong>{{ $val->kode_pengajuan }}</strong></td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                                @if($val->status_it == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_it == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_it == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_it == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                                @if($val->status_ga == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ga == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ga == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ga == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '2')<!-- Jika Operasional-->
                                                                @if($val->status_ops == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ops == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ops == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ops == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                                @if($val->status_pc == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_pc == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_pc == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_pc == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $val->nama_ga }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('approval.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td><strong>{{ $val->kode_pengajuan }}</strong></td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                                @if($val->status_it == '0' && $val->status_validasi_adm_it == '0')
                                                                    <label class="badge badge-secondary">New</label>
																@elseif($val->status_it == '0' && $val->status_validasi_adm_it == '1')
                                                                    <label class="badge badge-secondary">New</label>
																@elseif($val->status_it == '0' && $val->status_validasi_adm_it == '3')
                                                                    <label class="badge badge-warning">Pending</label>
                                                                @elseif($val->status_it == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_it == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_it == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                                @if($val->status_ga == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ga == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ga == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ga == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '2')<!-- Jika Operasional-->
                                                                @if($val->status_ops == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ops == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ops == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ops == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                                @if($val->status_pc == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_pc == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_pc == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_pc == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $val->nama_it }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('approval.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '2') <!-- Jika OPS-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td><strong>{{ $val->kode_pengajuan }}</strong></td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                                @if($val->status_it == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_it == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_it == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_it == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                                @if($val->status_ga == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ga == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ga == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ga == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '2')<!-- Jika Operasional-->
                                                                @if($val->status_ops == '0' && $val->status_validasi_adm_ops == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ops == '0' && $val->status_validasi_adm_ops == '1')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ops == '0' && $val->status_validasi_adm_ops == '2')
                                                                    <label class="badge badge-danger">Denied from Admin</label>
                                                                @elseif($val->status_ops == '0' && $val->status_validasi_adm_ops == '3')
                                                                    <label class="badge badge-warning">Pending from Admin</label>
                                                                @elseif($val->status_ops == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ops == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ops == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                                @if($val->status_pc == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_pc == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_pc == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_pc == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $val->nama_ops }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('approval.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '11') <!-- Jika PC-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td><strong>{{ $val->kode_pengajuan }}</strong></td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                            @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                                @if($val->status_it == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_it == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_it == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_it == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                                @if($val->status_ga == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ga == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ga == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ga == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '2')<!-- Jika Operasional-->
                                                                @if($val->status_ops == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_ops == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_ops == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_ops == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                                @if($val->status_pc == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_pc == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_pc == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_pc == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $val->nama_pc }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('approval.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '17') <!-- Jika tgsm-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td><strong>{{ $val->kode_pengajuan }}</strong></td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                                @if($val->status_tgsm == '0')
                                                                    <label class="badge badge-secondary">New</label>
                                                                @elseif($val->status_tgsm == '1')
                                                                    <label class="badge badge-success">Approved</label>
                                                                @elseif($val->status_tgsm == '2')
                                                                    <!-- <label class="badge badge-danger">Denied</label> -->
                                                                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                                @elseif($val->status_tgsm == '3')
                                                                    <!-- <label class="badge badge-warning">Pending</label> -->
                                                                    <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                                @endif
                                                        </td>
                                                        <td>{{ $val->nama_tgsm }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('approval.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut }}</td>
                                                        <td><strong>{{ $val->kode_pengajuan }}</strong></td>
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="center">
                                                        @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                            @if($val->status_it == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_it == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_it == '2')
                                                                <!-- <label class="badge badge-danger">Denied</label>
                                                                 -->
                                                                  <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                            @elseif($val->status_it == '3')
                                                                <!-- <label class="badge badge-warning">Pending</label> -->
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                            @if($val->status_ga == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_ga == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_ga == '2')
                                                                <!-- <label class="badge badge-danger">Denied</label> -->
                                                                 <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                            @elseif($val->status_ga == '3')
                                                                <!-- <label class="badge badge-warning">Pending</label> -->
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '2') <!-- Jika Operasional-->
                                                            @if($val->status_ops == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_ops == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_ops == '2')
                                                                <!-- <label class="badge badge-danger">Denied</label> -->
                                                                 <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                            @elseif($val->status_ops == '3')
                                                                <!-- <label class="badge badge-warning">Pending</label> -->
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                            @if($val->status_pc == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_pc == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_pc == '2')
                                                                <!-- <label class="badge badge-danger">Denied</label> -->
                                                                 <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Denied</a>
                                                            @elseif($val->status_pc == '3')
                                                                <!-- <label class="badge badge-warning">Pending</label> -->
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->kode_pengajuan }}">Pending</a>
                                                            @endif
                                                        @endif
                                                        </td>
                                                        <td>nama Validator</td>
                                                        <td align="center">
                                                    
                                                            <a href="{{ route('approval.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                    
                                                        </td>
                                                    </tr>
                                                @endif

                                                <!-- Modal Keterangan -->
                                                <div class="modal fade" id="modalKet{{ $val->kode_pengajuan }}" tabindex="-1" aria-labelledby="modalKet" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Keterangan</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!--FORM TAMBAH BARANG-->
                                                                <form action="#" method="get">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <b>{{ $val->kode_pengajuan }}</b>
                                                                        <br>
                                                                        <br>
                                                                        <label for="">keterangan</label>
                                                                        <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" value= "{{ $val->keterangan_approval }}" required>{{ $val->keterangan_approval }}</textarea>
                                                                    </div>
                                                                </form>
                                                                <!--END FORM TAMBAH BARANG-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal Keterangan -->
                                            
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