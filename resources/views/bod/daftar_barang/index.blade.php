@extends('layouts.admin')

@section('title')
    <title>Daftar Pengajuan</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Daftar Pengajuan</li>
        <li class="breadcrumb-item active">Barang</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Pengajuan Barang
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('bod/cari.cari') }}" method="get">
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
                                                <th hidden>Kode Pengguna</th>
                                                <th>Nama Pengaju</th>
                                                <th>Approval</th>
                                                <th>Purchasing</th>
                                                <th>Penerimaan</th>
                                                <th>Kontrabon</th>
                                                <th>SPP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data_pengajuan as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
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
                                                <td hidden>{{ $val->id_user_input }}</td>
                                                <td>
													{{ $val->name }} <br>
													<a href="{{ route('pengajuan/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Form Pdf</a>
												</td>
                                                <td>
                                                    {{-- Jika Divisi IT --}}
                                                    @if($val->approval_it == '0' )

                                                    @elseif($val->approval_it == '2')
                                                        Denied ({{ date('d-M-y', strtotime($val->tgl_approval_it)) }} || oleh: {{ $val->nama_it }}) <a href="#" class="badge badge-danger" data-toggle="modal" data-target=""><i class="nav-icon icon-close"></i></a><br>
                                                    @elseif($val->approval_it == '3')
                                                        Pending ({{ date('d-M-y', strtotime($val->tgl_approval_it)) }} || oleh: {{ $val->nama_it }} <a href="#" class="badge badge-warning" data-toggle="modal" data-target="">&nbsp; ! &nbsp;</a><br>
                                                    @elseif($val->approval_it == '1' || $val->id_user_approval_it == '')
                                                        (Non IT)<br>
                                                    @elseif($val->approval_it == '1' || $val->id_user_approval_it != '')
                                                        Approved IT ({{ date('d-M-y', strtotime($val->tgl_approval_it)) }} || oleh: {{ $val->nama_it }}) <a href="#" class="badge badge-success" data-toggle="modal" data-target=""></a>!<br>
                                                    @endif
                                                    {{-- End Jika Divisi IT --}}
                                                    
                                                    {{-- Jika Divisi OPS --}}
                                                    @if($val->approval_ops == '0' )

                                                    @elseif($val->approval_ops == '1')
                                                        Approved Ops ({{ date('d-M-y', strtotime($val->tgl_approval_ops)) }} || oleh: {{ $val->nama_ops }}) <a href="#" class="badge badge-success" data-toggle="modal" data-target=""><i class="nav-icon icon-check"></i></a><br>
                                                    @elseif($val->approval_ops == '2')
                                                        Denied ({{ date('d-M-y', strtotime($val->tgl_approval_ops)) }} || oleh: {{ $val->nama_ops }}) <a href="#" class="badge badge-danger" data-toggle="modal" data-target=""><i class="nav-icon icon-close"></i></a><br>
                                                    @elseif($val->approval_ops == '3')
                                                        Pending ({{ date('d-M-y', strtotime($val->tgl_approval_ops)) }} || oleh: {{ $val->nama_ops }}) <a href="#" class="badge badge-warning" data-toggle="modal" data-target="">&nbsp; ! &nbsp;</a><br>
                                                    @endif
                                                    {{-- End Jika Divisi OPS --}}

                                                    {{-- Jika Divisi GA --}}
                                                    @if($val->approval_ga == '0' )

                                                    @elseif($val->approval_ga == '1')
                                                        Approved GA ({{ date('d-M-y', strtotime($val->tgl_approval_ga)) }} || oleh: {{ $val->nama_ga }}) <a href="#" class="badge badge-success" data-toggle="modal" data-target=""><i class="nav-icon icon-check"></i></a><br>
                                                    @elseif($val->approval_ga == '2')
                                                        Denied ({{ date('d-M-y', strtotime($val->tgl_approval_ga)) }} || oleh: {{ $val->nama_ga }}) <a href="#" class="badge badge-danger" data-toggle="modal" data-target=""><i class="nav-icon icon-close"></i></a><br>
                                                    @elseif($val->approval_ga == '3')
                                                        Pending ({{ date('d-M-y', strtotime($val->tgl_approval_ga)) }} || oleh: {{ $val->nama_ga }}) <a href="#" class="badge badge-warning" data-toggle="modal" data-target="">&nbsp; ! &nbsp;</a><br>
                                                    @endif
                                                    {{-- End Jika Divisi GA --}}

                                                    {{-- Jika Divisi Purchasing --}}
                                                    @if($val->approval_purchasing == '0' )

                                                    @elseif($val->approval_purchasing == '1')
                                                        Approved Purchasing ({{ date('d-M-y', strtotime($val->tgl_approval_pc)) }} || oleh: {{ $val->nama_pc }}) <a href="#" class="badge badge-success" data-toggle="modal" data-target=""><i class="nav-icon icon-check"></i></a><br>
                                                    @elseif($val->approval_purchasing == '2')
                                                        Denied ({{ date('d-M-y', strtotime($val->tgl_approval_pc)) }} || oleh: {{ $val->nama_pc }}) <a href="#" class="badge badge-danger" data-toggle="modal" data-target=""><i class="nav-icon icon-close"></i></a><br>
                                                    @elseif($val->approval_purchasing == '3')
                                                        Pending ({{ date('d-M-y', strtotime($val->tgl_approval_pc)) }} || oleh: {{ $val->nama_pc }}) <a href="#" class="badge badge-warning" data-toggle="modal" data-target="">&nbsp; ! &nbsp;</a><br>
                                                    @endif
                                                    {{-- End Jika Divisi Purchasing --}}
                                                </td>
                                                
                                                <td>
                                                    @if($val->kode_pembelian == '')

                                                    @else
                                                        Pembuat PO: {{ $val->pembuat_po }} <br>
                                                        Vendor: {{ $val->nama_vendor }} <br>
                                                        No PO: {{ $val->kode_pembelian }} <br>
                                                        Tgl PO: {{ date('d-M-Y', strtotime($val->tgl_po)) }} <br>
                                                        Harga: Rp. {{ number_format($val->total) }} <br>
                                                        Status:
                                                        @if($val->status_po == '1')
                                                            <label>Pesan</label>
                                                        @elseif($val->status_po == '2')
                                                            <label>Diterima</label>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($val->no_btb == '')

                                                    @else
                                                        Penerima: {{ $val->approved_by }} <br>
                                                        Tgl: {{ date('d-M-Y', strtotime($val->tgl_terima_barang)) }} <br>
                                                        BTB: {{ $val->no_btb }} <br>
                                                        Faktur: {{ $val->no_faktur }}
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    @if($val->no_btb == '')

                                                    @else
                                                        Dibuat Oleh: {{ $val->pembuat_kontra }} <br>
                                                        No PO: {{ $val->kode_pembelian }} <br>
                                                        BTB: {{ $val->no_btb }} <br>
                                                        No Kontra: {{ $val->no_kontrabon }} <br>
                                                        Tgl Kontra: {{ date('d-M-Y', strtotime($val->tgl_kontrabon)) }} <br>
                                                        Nilai Kontra: Rp. {{ number_format($val->total_kontra) }}                                                        
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($val->no_spp == '')

                                                    @else
                                                        Dibuat Oleh: {{ $val->pembuat_spp }}<br>
                                                        No SPP: {{ $val->no_spp }} <br>
                                                        Tgl SPP: {{ date('d-M-Y', strtotime($val->tgl_spp)) }} <br>
                                                        Cara Bayar: {{ $val->cara_pembayaran }} <br>
                                                        @if($val->cara_pembayaran == 'Cek/Giro/Slip')
                                                            No Check/Giro: <br>
                                                            Foto Check/Giro: <br>
                                                        @elseif($val->cara_pembayaran == 'Cek/Giro - Transfer')
                                                            Tgl Upload: <br>
                                                            Foto Upload: <br>
                                                            Otorisasi: <br>
                                                        @elseif($val->cara_pembayaran == 'Uang Tunai')
                                                            Petty Cash: <br>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="14" class="text-center">Tidak ada data</td>
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