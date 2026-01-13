
@extends('layouts.admin')

@section('title')
    <title>Lacak Pengajuan</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Lacak Pengajuan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Lacak Pengajuan
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_lacak/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-6 float-center">  
                                    <input type="text" id="lacak" name="lacak" class="form-control" placeholder="Masukan ID/Kode Pengajuan anda disini untuk pelacakan... ">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>
                            <br>
                            <hr>
                            <br>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                @if($data_lacak != '')
                                   
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
                                                    <th>Approval IT</th>
                                                    <th>Approval OPS</th>
                                                    <th>Approval GA</th>
                                                    <th>Approval Purchasing</th>
                                                    <th>Kode Pembelian</th>
                                                    <th>Tgl Pembelian</th>
                                                    <th>Status Pembelian</th>
                                                    <th>Kode Terima Barang</th>
                                                    <th>Approved oleh</th>
                                                    <th>tgl Terima</th>
                                                    <th>No Faktur</th>
                                                    <th>Kontrabon</th>
                                                    <th>Tgl Kontrabon</th>
                                                    <th>No SPP</th>
                                                    <th>Tgl SPP</th>
                                                    <th>Mode Pembayaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data_lacak as $val)
                                                <tr>
                                                    <td hidden></td>
                                                    <td>{{ $val->kode_pengajuan }}</td>

                                                    @if($val->tgl_pengajuan == '')
                                                        <td>{{ $val->tgl_pengajuan }}</td>
                                                    @else
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan)) }}</td>
                                                    @endif
                                                    
                                                    <td hidden>{{ $val->kode_depo }}</td>
                                                    <td>{{ $val->nama_depo }}</td>
                                                    <td hidden>{{ $val->kode_divisi }}</td>
                                                    <td>{{ $val->nama_divisi }}</td>
                                                    <td align="center">
                                                        @if($val->approval_it == '0')
                                                            <label></label>
                                                        @elseif($val->approval_it == '1')
                                                            <label>Approved ({{ date('d-m-y', strtotime($val->tgl_approval_it)) }})</label>
                                                        @endif
                                                    </td>
                                                    <td align="center">
                                                        @if($val->approval_ops == '0')
                                                            <label></label>
                                                        @elseif($val->approval_ops == '1')
                                                            <label>Approved ({{ date('d-m-y', strtotime($val->tgl_approval_ops)) }})</label>
                                                        @endif
                                                    </td>
                                                    <td align="center">
                                                        @if($val->approval_ga == '0')
                                                            <label></label>
                                                        @elseif($val->approval_ga == '1')
                                                            <label>Approved ({{ date('d-m-y', strtotime($val->tgl_approval_ga)) }})</label>
                                                        @endif
                                                    </td>
                                                    <td align="center">
                                                        @if($val->approval_purchasing == '0')
                                                            <label></label>
                                                        @elseif($val->approval_purchasing == '1')
                                                            <label>Approved ({{ date('d-m-y', strtotime($val->tgl_approval_pc)) }})</label>
                                                        @endif
                                                    </td>
                                                    <td>{{ $val->kode_pembelian }}</td>

                                                    @if($val->tgl_po == '')
                                                        <td>{{ $val->tgl_po }}</td>
                                                    @else
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_po)) }}</td>
                                                    @endif
                                                    
                                                    <td align="center">
                                                        @if($val->status_po == '1')
                                                            <label>Order</label>
                                                        @elseif($val->status_po == '2')
                                                            <label>Diterima</label>
                                                        @endif
                                                    </td>
                                                    <td>{{ $val->no_btb }}</td>
                                                    <td>{{ $val->approved_by }}</td>

                                                    @if($val->tgl_terima_barang == '')
                                                        <td>{{ $val->tgl_terima_barang }}</td>
                                                    @else
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_terima_barang)) }}</td>
                                                    @endif

                                                    <td>{{ $val->no_faktur }}</td>
                                                    <td>{{ $val->no_kontrabon }}</td>

                                                    @if($val->tgl_kontrabon == '')
                                                        <td>{{ $val->tgl_kontrabon }}</td>
                                                    @else
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_kontrabon)) }}</td>
                                                    @endif

                                                    <td>{{ $val->no_spp }}</td>
                                                    
                                                    @if($val->tgl_spp == '')
                                                        <td>{{ $val->tgl_spp }}</td>
                                                    @else
                                                        <td>{{ date('d-M-Y', strtotime($val->tgl_spp)) }}</td>
                                                    @endif

                                                    <td>{{ $val->pembayaran }}</td>

                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="22" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    
                                @endif
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
    

   



@endsection