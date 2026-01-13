@extends('layouts.admin')

@section('title')
    <title>Otorisasi Transfer</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Otorisasi Transfer</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Otorisasi Transfer
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('bod_otorisasi/cari.cari') }}" method="get">
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
                                                <th>Nama Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Nama Depo</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Keterangan</th>
                                                <th>Tipe</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($approval_cost as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td hidden>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->nama_pengeluaran }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td>{{ $val->sifat }}</td>
                                                <td align="right">{{ number_format($val->total) }}</td>
                                                <td align="center">
                                                    @if($val->status_bod_otorisasi == '0')
                                                        <label class="badge badge-primary">New</label>
                                                    @elseif($val->status_bod_otorisasi == '1')
                                                        <label class="badge badge-success">Done</label>
													@elseif($val->status_bod_otorisasi == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <a href="{{ route('bod_otorisasi/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="12" class="text-center">Tidak ada data yang ditemukan</td>
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