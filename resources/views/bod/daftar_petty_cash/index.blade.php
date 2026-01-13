@extends('layouts.admin')

@section('title')
    <title>Status Pengajuan Biaya Tunai Petty Cash</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Biaya Tunai</li>
        <li class="breadcrumb-item">Petty Cash</li>
        <li class="breadcrumb-item active">Status Pengajuan Biaya Tunai Petty Cash</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Status Pengajuan Biaya Tunai Petty Cash
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('bod_biaya_tunai_pc/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <!-- <div style="width:100%;"> -->
                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Kode Pengajuan</th>
                                                <th>Tgl Pengajuan</th>
                                                <th hidden>Kode Depo</th>
                                                <th>Nama Depo</th>
                                                <th hidden>kode Divisi</th>
                                                <th>Divisi</th>
                                                <th>Approval Claim</th>
                                                <th>Approval Biaya/Finance</th>
                                                <th>Approval Biaya Pusat</th>
                                                <th>No SPP</th>
                                                <th>Tgl SPP</th>
                                                <th>Mode Pembayaran</th>
                                                <th>Cek/Giro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data_pengajuan as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>

                                                @if($val->tgl_pengajuan_b == '')
                                                    <td>{{ $val->tgl_pengajuan_b }}</td>
                                                @else
                                                    <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_b)) }}</td>
                                                @endif
                                                
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kode_divisi }}</td>
                                                <td>{{ $val->nama_divisi }}</td>
                                                <td align="center">
                                                    @if($val->status_claim == '0')
                                                        <label></label>
                                                    @elseif($val->status_claim == '1')
                                                        <label>Approved ({{ date('d-m-y', strtotime($val->tgl_approval_claim)) }})</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @if($val->status_biaya == '0')
                                                        <label></label>
                                                    @elseif($val->status_biaya == '1')
                                                        <label>Approved ({{ date('d-m-y', strtotime($val->tgl_approval_biaya)) }})</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @if($val->status_biaya_pusat == '0')
                                                        <label></label>
                                                    @elseif($val->status_biaya_pusat == '1')
                                                        <label>Approved ({{ date('d-m-y', strtotime($val->tgl_approval_biaya_pusat)) }})</label>
                                                    @endif
                                                </td>
                                                <td>{{ $val->no_spp }}</td>
                                                
                                                @if($val->tgl_spp == '')
                                                    <td>{{ $val->tgl_spp }}</td>
                                                @else
                                                    <td>{{ date('d-M-Y', strtotime($val->tgl_spp)) }}</td>
                                                @endif

                                                <td>{{ $val->pembayaran }}</td>
                                                <td>{{ $val->id_cek }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="22" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                <!-- </div> -->
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
                    left: 2,
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