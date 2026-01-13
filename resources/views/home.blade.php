@extends('layouts.admin')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Selamat Datang {{Auth::user()->name}}</h4> <!-- {{Auth::user()->name}} ID: {{Auth::user()->id}} Kode Divisi: {{Auth::user()->kode_divisi}} -->
                        </div>

                        @if(Auth::user()->kode_divisi == '14') <!-- Jika user login BOD, kode divisi 14 -->
                            <div class="card-body">
                                <div class="col-md-12 mb-4">
                                    <div class="nav-tabs-boxed">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#barang" role="tab" aria-controls="barang">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Persetujuan Pengajuan Barang</b>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#biaya" role="tab" aria-controls="biaya">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Persetujuan Biaya/Jasa</b>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#vendor" role="tab" aria-controls="vendor">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Persetujuan Pengajuan Vendor</b>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#izin" role="tab" aria-controls="izin">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Persetujuan Pengajuan Izin</b>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="barang" role="tabpanel">
                                                <br>
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
                                                                    <td><strong>{{ $val->kode_pengajuan }}</strong></td>
                                                                    <td>{{ $val->tgl_pengajuan }}</td>
                                                                    <td hidden>{{ $val->kode_perusahaan }}</td>
                                                                    <td>{{ $val->nama_perusahaan }}</td>
                                                                    <td hidden>{{ $val->kode_depo }}</td>
                                                                    <td>{{ $val->nama_depo }}</td>
                                                                    <td>{{ $val->nama_pengeluaran }}</td>
                                                                    <td>{{ $val->sifat }}</td>
                                                                    <td align="center">
                                                                        @if($val->status_pengajuan == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_pengajuan == '1')
                                                                            <label class="badge badge-success">Approved</label> 
                                                                        @elseif($val->status_pengajuan == '2')
                                                                            <label class="badge badge-danger">Denied</label>  
                                                                        @elseif($val->status_pengajuan == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    </td>
                                                                    <td hidden></td>
                                                                    <td align="center">
                                                                        
                                                                            <a href="{{ route('approval_bod.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                        
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
                                            </div>
                                            <div class="tab-pane" id="biaya" role="tabpanel">
                                                <br>
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
                                                                @forelse($approval_biaya as $val)
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
                                                                        @if($val->status_bod == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status_bod == '1')
                                                                            <label class="badge badge-success">Approved</label>  
                                                                        @elseif($val->status_bod == '2')
                                                                            <label class="badge badge-danger">Denied</label>
                                                                        @elseif($val->status_bod == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @endif
                                                                    </td>
                                                                    <td hidden></td>
                                                                    <td align="center">
                                                                        
                                                                            <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                                        
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
                                            </div>
                                            <div class="tab-pane" id="vendor" role="tabpanel">
                                                <br>
                                                <div class="table-responsive">
                                                    <!-- <table class="table table-hover table-bordered"> -->
                                                    <div style="width:100%;">
                                                        <table class="table table-bordered table-striped table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th hidden>#</th>
                                                                    <th>Kode Pengajuan</th>
                                                                    <th>Tgl Pengajuan</th>
                                                                    <th>Nama Vendor</th>
                                                                    <th>Alamat</th>
                                                                    <th>Telepon</th>
                                                                    <th>Kategori Vendor</th>
                                                                    <th hidden>Id Pengguna</th>
                                                                    <th>Status</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($app_vendor as $val)
                                                                <tr>
                                                                    <td hidden></td>
                                                                    <td>{{ $val->kode_pengajuan_v }}</td>
                                                                    <td>{{ $val->tgl_pengajuan_v }}</td>
                                                                    <td>{{ $val->nama_vendor }}</td>
                                                                    <td>{{ $val->alamat }}</td>
                                                                    <td>{{ $val->telepon }}</td>
                                                                    <td>{{ $val->kategori_vendor }}</td>
                                                                    <td hidden>{{ $val->id_user_input }}</td>
                                                                    <td align="center">
                                                                        @if($val->status == '0')
                                                                            <label class="badge badge-secondary">Baru</label>
                                                                        @elseif($val->status == '1')
                                                                            <label class="badge badge-success">Disetujui</label>  
                                                                        @elseif($val->status == '2')
                                                                            <label class="badge badge-warning">Ditunda</label>
                                                                        @elseif($val->status == '3')
                                                                            <label class="badge badge-danger">Ditolak</label>    
                                                                        @endif
                                                                    </td>
                                                                    <td align="center">
                                                                        
                                                                            <a href="{{ route('approval_vendor/view.view', $val->kode_pengajuan_v) }}" class="btn btn-primary btn-sm">View</a>
                                                                        
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
                                            </div>
                                            <div class="tab-pane" id="izin" role="tabpanel">
                                                <br>
                                                <div class="table-responsive">
                                                    <!-- <table class="table table-hover table-bordered"> -->
                                                    <table class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th hidden>#</th>
                                                                <th>ID</th>
                                                                <th>Date</th>
                                                                <th>Permission</th>
                                                                <th>Input By</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($receipt as $val)
                                                            <tr>
                                                                <td hidden></td>
                                                                <td>{{ $val->receipt_id }}</td>
                                                                <td>{{ $val->date_receipt}}</td>
                                                                <td>{{ $val->keterangan_id }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td align="center">
                                                                    @if(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                        @if($val->status == '0')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status == '1')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status == '2')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @elseif($val->status == '4')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '14') <!-- Jika BOD-->
                                                                         @if($val->status == '1')
                                                                            <label class="badge badge-secondary">New</label>
                                                                        @elseif($val->status == '2')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @elseif($val->status == '3')
                                                                            <label class="badge badge-warning">Pending</label>
                                                                        @elseif($val->status == '4')
                                                                            <label class="badge badge-success">Approved</label>
                                                                        @endif
                                                                    @endif

                                                                    
                                                                </td>
                                                                <td align="center">   
                                                                    <a href="{{ route('approval_a.view', $val->receipt_id) }}" class="btn btn-primary btn-sm">View</a> 
                                                                    <!-- <a href="#" target="_blank" class="btn btn-warning btn-sm">Print</a> -->   
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">No data available</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        @elseif(Auth::user()->kode_divisi == '8') <!-- Jika user login Rekonsiliasi -->

                        @elseif(Auth::user()->kode_divisi == '22') <!-- Jika user login Gudang Pusat -->

                        @elseif(Auth::user()->kode_divisi == '20') <!-- Jika user login Checker -->

                        @elseif(Auth::user()->kode_divisi == '6') <!-- Jika user login Accounting -->
                            @if(Auth::user()->kode_sub_divisi == '2' || Auth::user()->kode_sub_divisi == '3') <!-- Jatuh Tempo -->

                            @else
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                          <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <a href="#" class="btn btn-primary btn-sm float-right">
                                                    <i class="nav-icon icon-plus"></i>
                                                </a>
                                                <div>Jumlah Pengajuan Hari ini</div>
                                                <div class="text-value-lg" align="center">0</div>
                                                <br>
                                                <br>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <div class="col-sm-6 col-lg-6">
                                          <div class="card text-white bg-success">
                                            <div class="card-body pb-0">
                                              <div>Jumlah Pengajuan Masuk hari ini</div>
                                              <div class="text-value-lg" align="center">0</div>
                                              <br>
                                              <br>
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    
                                </div>
                            @endif
                        @else

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-6">
                                      <div class="card text-white bg-primary">
                                        <div class="card-body pb-0">
                                            <a href="#" class="btn btn-primary btn-sm float-right">
                                                <i class="nav-icon icon-plus"></i>
                                            </a>
                                            <div>Jumlah Pengajuan Hari ini</div>
                                            <div class="text-value-lg" align="center">0</div>
                                            <br>
                                            <br>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <div class="col-sm-6 col-lg-6">
                                      <div class="card text-white bg-success">
                                        <div class="card-body pb-0">
                                          <div>Jumlah Pengajuan Masuk hari ini</div>
                                          <div class="text-value-lg" align="center">0</div>
                                          <br>
                                          <br>
                                        </div>
                                      </div>
                                    </div>
                                </div>

                                
                            </div>

                        @endif

                        <div class="row" hidden>
                            <div class="card-body" hidden>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-white bg-primary ng-scope" ng-controller="cardChartCtrl1">
                                        <div class="card-body pb-0">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" hidden>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-white bg-primary ng-scope" ng-controller="cardChartCtrl1">
                                        <div class="card-body pb-0">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" hidden>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-white bg-primary ng-scope" ng-controller="cardChartCtrl1">
                                        <div class="card-body pb-0">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" hidden>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card text-white bg-primary ng-scope" ng-controller="cardChartCtrl1">
                                        <div class="card-body pb-0">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
