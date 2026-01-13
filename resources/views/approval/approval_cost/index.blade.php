@extends('layouts.admin')

@section('title')
    <title>Approval (Biaya)</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item active">Approval (Biaya)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Approval (Biaya)
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('approval_cost/cari.cari') }}" method="get">
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
                                                <th>Id</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Yang Mengajukan</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Company Name</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo Name</th>
                                                <th>Nama Pengeluaran</th>
												<th>Pengajuan</th>
                                                <th>Tipe</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                    <th hidden>Validator</th>
                                                @elseif(Auth::user()->kode_divisi == '5')<!-- FINANCE-->
                                                    <th hidden>Validator</th>
                                                @else
                                                    <th>Validator</th>
                                                @endif
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($approval_cost as $val)
                                                @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                    @if(Auth::user()->kode_sub_divisi == '5')
                                                        @if($val->status_validasi_acc == '1')
                                                            <tr>
                                                                <td hidden>{{ $val->no_urut}}</td>
                                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                                <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                                <td hidden>{{ $val->kode_depo }}</td>
                                                                <td hidden>{{ $val->nama_depo }}</td>
                                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                                <td>{{ $val->keterangan }}</td>
                                                                <td>{{ $val->sifat }}</td>
                                                                <td align="right">{{ number_format($val->total) }}</td>
                                                                <td align="center">
                                                                    @if(Auth::user()->kode_sub_divisi == '5') <!-- Manager Biaya Acc-->
                                                                        @if($val->status_biaya_pusat == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_biaya_pusat == '1')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status_biaya_pusat == '2')
                                                                            <label class="badge badge-danger">Denied</label>
                                                                        @elseif($val->status_biaya_pusat == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_sub_divisi == '4')<!-- manager Akunting-->
                                                                        @if($val->status_ka_akunting == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_ka_akunting == '1')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status_ka_akunting == '2')
                                                                            <label class="badge badge-danger">Denied</label>
                                                                        @elseif($val->status_ka_akunting == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td hidden>{{ $val->name_acc }}</td>
                                                                <td align="center">
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @else
                                                        <tr>
                                                                <td hidden>{{ $val->no_urut}}</td>
                                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                                <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                                <td hidden>{{ $val->kode_depo }}</td>
                                                                <td hidden>{{ $val->nama_depo }}</td>
                                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                                <td>{{ $val->keterangan }}</td>
                                                                <td>{{ $val->sifat }}</td>
                                                                <td align="right">{{ number_format($val->total) }}</td>
                                                                <td align="center">
                                                                    @if(Auth::user()->kode_sub_divisi == '5') <!-- Manager Biaya Acc-->
                                                                        @if($val->status_biaya_pusat == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_biaya_pusat == '1')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status_biaya_pusat == '2')
                                                                            <label class="badge badge-danger">Denied</label>
                                                                        @elseif($val->status_biaya_pusat == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_sub_divisi == '4')<!-- manager Akunting-->
                                                                        @if($val->status_ka_akunting == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_ka_akunting == '1')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status_ka_akunting == '2')
                                                                            <label class="badge badge-danger">Denied</label>
                                                                        @elseif($val->status_ka_akunting == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td hidden>{{ $val->name_acc }}</td>
                                                                <td align="center">
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                    @endif    
                                                @elseif(Auth::user()->kode_divisi == '16')<!-- Cost/Biaya-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut}}</td>
                                                        <td>{{ $val->kode_pengajuan_b }}</td>
                                                        <td>{{ $val->tgl_pengajuan_b }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
														<td>{{ $val->keterangan }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="right">{{ number_format($val->total) }}</td>
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
                                                        <td>{{ $val->name_2 }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '5')<!-- FINANCE-->
                                                    @if($val->kategori == '3') <!-- Jika Iuran BPJS Kesehatan -->
                                                        @if($val->status_biaya_pusat == '1')
                                                            <tr>
                                                                <td hidden>{{ $val->no_urut}}</td>
                                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                                <td hidden>{{ $val->kode_depo }}</td>
                                                                <td hidden>{{ $val->nama_depo }}</td>
                                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                                <td>{{ $val->keterangan }}</td>
                                                                <td>{{ $val->sifat }}</td>
                                                                <td align="right">{{ number_format($val->total) }}</td>
                                                                <td align="center">
                                                                    @if($val->status_fin == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_fin == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_fin == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_fin == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td hidden>{{ $val->name_fin }}</td>
                                                                <td align="center">
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @elseif($val->kategori == '4') <!-- Jika Iuran BPJS Tenaga Kerja -->
                                                        @if($val->status_biaya_pusat == '1')
                                                            <tr>
                                                                <td hidden>{{ $val->no_urut}}</td>
                                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                                <td hidden>{{ $val->kode_depo }}</td>
                                                                <td hidden>{{ $val->nama_depo }}</td>
                                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                                <td>{{ $val->keterangan }}</td>
                                                                <td>{{ $val->sifat }}</td>
                                                                <td align="right">{{ number_format($val->total) }}</td>
                                                                <td align="center">
                                                                    @if($val->status_fin == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_fin == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_fin == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_fin == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td hidden>{{ $val->name_fin }}</td>
                                                                <td align="center">
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @elseif($val->kategori == '1' || $val->kategori == '2' || $val->kategori == '5') <!-- Jika gaji, mitra, insentif -->
                                                        @if($val->status_validasi_fin == '1')
                                                            <tr>
                                                                <td hidden>{{ $val->no_urut}}</td>
                                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                                <td hidden>{{ $val->kode_depo }}</td>
                                                                <td hidden>{{ $val->nama_depo }}</td>
                                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                                <td>{{ $val->keterangan }}</td>
                                                                <td>{{ $val->sifat }}</td>
                                                                <td align="right">{{ number_format($val->total) }}</td>
                                                                <td align="center">
                                                                    @if($val->status_fin == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_fin == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_fin == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_fin == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td hidden>{{ $val->name_fin }}</td>
                                                                <td align="center">
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @else
                                                        
                                                    @endif
                                                @elseif(Auth::user()->kode_divisi == '10')<!-- CLAIM-->
                                                    <tr>
                                                        <td hidden>{{ $val->no_urut}}</td>
                                                        <td>{{ $val->kode_pengajuan_b }}</td>
                                                        <td>{{ $val->tgl_pengajuan_b }}</td>
                                                        <td>{{ $val->name }}</td>
                                                        <td hidden>{{ $val->kode_perusahaan }}</td>
                                                        <td hidden>{{ $val->nama_perusahaan }}</td>
                                                        <td hidden>{{ $val->kode_depo }}</td>
                                                        <td hidden>{{ $val->nama_depo }}</td>
                                                        <td>{{ $val->nama_pengeluaran }}</td>
														<td>{{ $val->keterangan }}</td>
                                                        <td>{{ $val->sifat }}</td>
                                                        <td align="right">{{ number_format($val->total) }}</td>
                                                        <td align="center">
                                                            @if($val->status_claim == '0')
                                                                <label class="badge badge-secondary">New</label>
                                                            @elseif($val->status_claim == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            @elseif($val->status_claim == '2')
                                                                <label class="badge badge-danger">Denied</label>
                                                            @elseif($val->status_claim == '3')
                                                                <label class="badge badge-warning">Pending</label>
                                                            @endif
                                                        </td>
                                                        <td>{{ $val->name_clm }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @endif
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