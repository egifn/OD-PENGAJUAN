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

 <!-- UNTUK TABLE -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                scrollY: "356px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    leftColumns: 3,
                    rightColumns: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script> --}}

@stop


@extends('layouts.admin')

@section('title')
    <title>Pendaftaran Cek/Giro</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Check/Giro</li>
        <li class="breadcrumb-item active">Pendaftaran</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pendaftaran Check/Giro
                                <a href="{{ route('pendaftaran_cek_giro.create') }}" class="btn btn-primary btn-sm float-right">Tambah Pendaftaran</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-md-7 mb-2">
                                    <form action="{{ route('pendaftaran_cek_giro/cari.cari') }}" method="get">
                                        <div class="input-group mb-2">
                                            <input type="text" name="q" id="q" class="form-control" placeholder="Search by Reg No / Company / Series Code / Early Series / Final Series / Input By" value="{{ request()->q }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-2 mb-2">
                                </div>
                                
                                <div class="col-md-3 mb-2">
                                    <form action="{{ route('pendaftaran_cek_giro/cari_tanggal.cari_tanggal') }}" method="get">
                                        <div class="input-group mb-2">
                                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                {{-- <table class="table table-bordered table-striped table-sm"> --}}
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Reg</th>
                                            <th>Tgl.Reg</th>
                                            <th>Perusahaan</th>
                                            <th>No. Warkat</th>
                                            <th>Kode Seri Warkat</th>
                                            <th>No Seri Awal</th>
                                            <th>No Seri Akhir</th>
                                            <th>Jenis Buku</th>
                                            <th>Input By</th>
                                            <th hidden>No Urut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @forelse($pendaftaran as $val)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $val->kode_daftar }}</td>
                                            <td>{{ date('d-M-Y', strtotime($val->tgl_daftar)) }}</td>
                                            <td>{{ $val->nama_perusahaan }}</td>
                                            <td>{{ $val->kode_seri_buku }} {{ $val->seri_awal }} - {{ $val->seri_akhir }}</td>
                                            <td>{{ $val->kode_seri_buku }}</td>
                                            <td>{{ $val->seri_awal }}</td>
                                            <td>{{ $val->seri_akhir }}</td>
                                            <td>{{ $val->jenis }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td hidden>{{ $val->no_urut }}</td>
                                            <td align="center">
                                                <a href="{{ route('pendaftaran.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">No data available</td>
                                        </tr>
                                       @endforelse
                                    </tbody>
                                </table>
                               
                            </div>
                            <!-- PAGINATION  -->
                            {!! $pendaftaran->links() !!}
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection