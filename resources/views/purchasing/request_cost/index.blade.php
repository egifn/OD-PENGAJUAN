@extends('layouts.admin')

@section('title')
    <title>Cost Request</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purch & Payment</li>
        <li class="breadcrumb-item">Request</li>
        <li class="breadcrumb-item active">Cost Request</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Cost Request
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('request_cost/cari.cari') }}" method="get">
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
                                                <th hidden>No Urut</th>
                                                <th>Request Id</th>
                                                <th>Tgl Request</th>
                                                <th>Request By</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Company Name</th>
                                                <th hidden>Kode Depo</th>
                                                <th>Depo</th>
                                                <th hidden>kode Divisi</th>
                                                <th>Divisi</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Tipe</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($request_detail as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td><strong>{{ $val->kode_pengajuan_b }}</strong></td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kode_divisi }}</td>
                                                <td>{{ $val->nama_divisi }}</td>
                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                <td>{{ $val->sifat }}</td>
                                                <td align="right">{{ number_format($val->total) }}</td>
                                                <td align="center">
                                                    @if($val->status == '0' and $val->status_biaya_pusat == '0' and $val->status_biaya == '0' )
                                                        <label class="badge badge-warning">Menunggu</label>
                                                    @elseif($val->status == '0' and $val->status_biaya_pusat == '0' and $val->status_biaya == '1' )
                                                        <label class="badge badge-warning">Menunggu</label>
                                                    @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_biaya == '0' )
                                                        <label class="badge badge-warning">Menunggu</label>
                                                    @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_biaya == '1' )
                                                        @if($val->kategori == '33' or $val->kategori == '9' or $val->kategori == '12' or $val->kategori == '21' or $val->kategori == '17' or $val->kategori == '18') <!-- jika dibuatkan Pengajuan SPP oleh Purchasing -->
                                                            <label class="badge badge-secondary">Baru</label>
                                                        @else <!-- jika Tidak -->
                                                            <label class="badge badge-primary">SPP</label>
                                                        @endif                                                      
                                                    @elseif($val->status == '0')
                                                        <label class="badge badge-success">Baru</label>
                                                    @elseif($val->status == '1')
                                                        <label class="badge badge-success">P a i d</label>
                                                    @elseif($val->status == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @elseif($val->status == '3')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @elseif($val->status == '4')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @elseif($val->status == '5' and $val->status_spp_1 == '0' and $val->status_spp_2 == '0' )
                                                        <label class="badge badge-secondary">Approval SPP</label>
                                                    @elseif($val->status == '5' and $val->status_spp_1 == '3' )
                                                        <label class="badge badge-secondary">Approval SPP</label>
                                                    @elseif($val->status == '6' and $val->status_spp_1 == '1' and $val->status_spp_2 == '0')
                                                        <label class="badge badge-secondary">Approval SPP</label>
                                                    @elseif($val->status == '6' and $val->status_spp_1 == '1' and $val->status_spp_2 == '1')
                                                        <label class="badge badge-primary">Baru</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @if($val->status == '0' and $val->status_biaya_pusat == '0' and $val->status_biaya == '0' )
                                                        <button onClick="alert('Pengajuan masih menunggu persetujuan')" class="btn btn-primary btn-sm">View</button>
                                                    @elseif($val->status == '0' and $val->status_biaya_pusat == '0' and $val->status_biaya == '1' )   
                                                        <button onClick="alert('Pengajuan masih menunggu persetujuan')" class="btn btn-primary btn-sm">View</button>
                                                    @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_biaya == '0' ) 
                                                        <button onClick="alert('Pengajuan masih menunggu persetujuan')" class="btn btn-primary btn-sm">View</button>
                                                    @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_biaya == '1' )

                                                        @if($val->kategori == '33' or $val->kategori == '9' or $val->kategori == '12' or $val->kategori == '21' or $val->kategori == '17' or $val->kategori == '18') <!-- jika dibuatkan Pengajuan SPP oleh Purchasing -->
                                                            <a href="{{ route('request_cost_view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>     
                                                        @else <!-- jika Tidak -->
                                                            <button onClick="alert('Pengajuan sedang dibuatkan SPP')" class="btn btn-primary btn-sm">View</button> 
                                                        @endif 
                                                         
                                                    @elseif($val->status == '1')
                                                        <a href="{{ route('request_cost_view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                    @elseif($val->status == '2')
                                                        <a href="{{ route('request_cost_view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                    @elseif($val->status == '3')
                                                        <a href="{{ route('request_cost_view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                    @elseif($val->status == '5')
                                                        <button onClick="alert('SPP masih dalam Proses')" class="btn btn-primary btn-sm">View</button> 
                                                    @elseif($val->status == '6' and $val->status_spp_1 == '1' and $val->status_spp_2 == '0')
                                                        <button onClick="alert('SPP masih dalam Proses')" class="btn btn-primary btn-sm">View</button>
                                                    @elseif($val->status == '6' and $val->status_spp_1 == '1' and $val->status_spp_2 == '1')
                                                        <a href="{{ route('request_cost_view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                    @endif
                                                       
                                                        
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Data not found</td>
                                            </tr>
                                            @endforelse
                                            
                                            
                                       
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2" align="right">
                                    <b>[sum of rows : {{ $sum->sum }}]</b>
                                    &nbsp;&nbsp;&nbsp;
                                    <b>[sum of total : Rp. {{ number_format($jumlah->total) }}]</b>
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