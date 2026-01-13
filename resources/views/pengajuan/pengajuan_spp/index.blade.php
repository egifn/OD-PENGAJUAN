@extends('layouts.admin')

@section('title')
    <title>Pengajuan SPP</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">Pengajuan SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan SPP
                                <a href="{{ route('pengajuan_spp.create') }}" class="btn btn-primary btn-sm float-right">Buat Pengajuan SPP</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_spp/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                    
                                    <table class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>No</th>
                                                <th>Kode Pengajuan</th>
                                                <th>Tgl Pengajuan</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Company Name</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo</th>
                                                <th>Pengajuan</th>
                                                <th>Nama Pengeluaran</th>
                                                <th>Sifat</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Pengajuan Oleh</th>
                                                <th>Disetujui Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($request_detail as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td><strong>{{ $val->kode_pengajuan_b }}</strong></td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                <td hidden>{{ $val->kode_perusahaan }}</td>
                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td hidden>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->keterangan }}</td>
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
                                                        <label class="badge badge-primary"> Buat SPP</label>                         
                                                    @elseif($val->status == '1')
                                                        <label class="badge badge-success">Spp sudah dibuat</label>
                                                    @elseif($val->status == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @elseif($val->status == '3')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @elseif($val->status == '4')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @endif
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    <a href="{{ route('pengajuan_spp/view_approval.view_approval', $val->no_urut) }}" target="_blank" class="btn btn-warning btn-sm">View Apprvd</a>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ route('pengajuan_spp.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                    <a href="{{ route('pengajuan_spp/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>
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
    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: false,
                bFilter: false,
                lengthChange: false,
                scrollY: "355px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

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