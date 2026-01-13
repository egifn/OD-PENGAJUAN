@extends('layouts.admin')

@section('title')
    <title>Pengajuan Masuk</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Pengajuan Masuk...</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Masuk Biaya/Jasa
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_biaya_masuk/cari.cari') }}" method="get">
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
                                                <th>Request Id</th>
                                                <th>Tgl Request</th>
                                                <th>Request By</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Company Name</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo Name</th>
                                                <th>Nama Pengeluaran</th>
												<th>Pengajuan</th>
                                                <th>Tipe</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @forelse($approval_cost as $val)
                                                @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                    @if($val->kategori == '1' || $val->kategori == '2' || $val->kategori == '5') <!-- Jika Gaji, mitra, insentif -->
                                                       
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
                                                                    @if($val->status_validasi_acc == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_validasi_acc == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_validasi_acc == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_validasi_acc == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td align="center">
                                                                    <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                       
                                                    @elseif($val->kategori == '3' || $val->kategori == '4') <!-- Jika Iuran BPJS  -->
                                                        @if($val->status_atasan == '1')
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
                                                                    @if($val->status_validasi_acc == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_validasi_acc == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_validasi_acc == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_validasi_acc == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td align="center">
                                                                    <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
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
                                                                    @if($val->status_validasi_acc == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_validasi_acc == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_validasi_acc == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_validasi_acc == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td align="center">
                                                                    <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
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
                                                        <td align="center">
                                                            <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '5')<!-- FINANCE-->
                                                @if(Auth::user()->kode_sub_divisi == '7')
                                                        @if($val->kategori == '3') <!-- Jika Iuran BPJS Kesehatan -->
                                                            @if($val->status_ka_akunting == '1')
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
                                                                        @if($val->status_validasi_fin == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_validasi_fin == '1')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status_validasi_fin == '2')
                                                                            <label class="badge badge-danger">Denied</label>
                                                                        @elseif($val->status_validasi_fin == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    </td>
                                                                    <td align="center">
                                                                        <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @elseif($val->kategori == '4') <!-- Jika Iuran BPJS Tenaga Kerja -->
                                                            @if($val->status_ka_akunting == '1')
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
                                                                        @if($val->status_validasi_fin == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_validasi_fin == '1')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status_validasi_fin == '2')
                                                                            <label class="badge badge-danger">Denied</label>
                                                                        @elseif($val->status_validasi_fin == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    </td>
                                                                    <td align="center">
                                                                        <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @elseif(($val->kategori == '1' || $val->kategori == '2' || $val->kategori == '5'))
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
                                                                    @if($val->status_validasi_fin == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_validasi_fin == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_validasi_fin == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_validasi_fin == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td align="center">
                                                                    <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
                                                        @endif    
                                                    @else
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
                                                                    @if($val->status_validasi_fin == '0')
                                                                        <label class="badge badge-secondary">New</label>
                                                                    @elseif($val->status_validasi_fin == '1')
                                                                        <label class="badge badge-success">Approved</label>
                                                                    @elseif($val->status_validasi_fin == '2')
                                                                        <label class="badge badge-danger">Denied</label>
                                                                    @elseif($val->status_validasi_fin == '3')
                                                                        <label class="badge badge-warning">Pending</label>
                                                                    @endif
                                                                </td>
                                                                <td align="center">
                                                                    <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                </td>
                                                            </tr>
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
                                                        <td align="center">
                                                            <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
                                                @elseif(Auth::user()->kode_divisi == '11')<!-- Purchasing-->
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
                                                        <td align="center">
                                                            <a href="{{ route('pengajuan_biaya_masuk/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                        </td>
                                                    </tr>
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