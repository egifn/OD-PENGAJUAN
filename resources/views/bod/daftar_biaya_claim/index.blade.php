@extends('layouts.admin')

@section('title')
    <title>History Validasi Promo</title>
@endsection

@section('content')

<main class="main">
	<style>
        #datatabel-v th:nth-child(11),
        #datatabel-v td:nth-child(11) {
            width: 450px; /* Atur lebar kolom sesuai kebutuhan */
            max-width: 450px;
            overflow: hidden;
            white-space: normal;
            /*text-overflow: ellipsis;*/   /* Tampilkan titik ellipsis jika kontennya terlalu panjang */
        }
    </style>
	
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Claim</li>
        <li class="breadcrumb-item active">History Validasi Promo</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                History Validasi Promo
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('bod_biaya_claim/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>
                            
                            <form action="#" method="get">
                                @csrf
                                <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                    <table id="datatabel-v" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>no_urut</th>
                                                <th hidden>id</th>
                                                <th>No</th>
                                                <th>Tgl Buat Surat</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo</th>
                                                <th hidden>kode Divisi</th>
                                                <th hidden>Divisi</th>
                                                <th>Surat Program</th> {{--  10 --}}
                                                {{-- <th>Jenis Surat</th>
                                                <th>Id Program</th>
                                                <th>Nama Program</th>
                                                <th>Periode Awal</th>
                                                <th>Periode Akhir</th> --}}
                                                <th>Status Approved</th>
                                                <th>Status Surat Program</th>
                                                <th hidden>Approval SSD</th>
                                                <th hidden>Approval Manager</th>
                                                <th hidden>Approval SOM</th>
                                                @if(Auth::user()->kode_sub_divisi == '12' or Auth::user()->kode_sub_divisi == '17' or Auth::user()->kode_sub_divisi == '16')
                                                    <th>Status</th>
                                                @else
                                                    <th hidden>Status</th>
                                                @endif
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse($data_claim as $val)
                                                @if(Auth::user()->kode_depo == '902' && Auth::user()->kode_divisi == '13' && Auth::user()->type == 'Admin')
                                                    {{-- @if($val->status_approval_ssd == '1' and $val->status_approval_manager == '1' and $val->status_approval_som == '1')
                                                        <tr style="background-color: #c5f9cd;">
                                                    @else
                                                        <tr>
                                                    @endif --}}
                                                    <tr class="@if($val->status_approval_ssd == '1' and $val->status_approval_manager == '1' and $val->status_approval_som == '1') colored-row @endif">
                                                @else
                                                    <tr>
                                                @endif
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td hidden>{{ $val->id }}</td>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_upload_kirim)) }}</td>
                                                <td hidden>{{ $val->kode_perusahaan_user }}</td>
                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo_user }}</td>
                                                <td hidden>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kode_divisi_user }}</td>
                                                <td hidden>{{ $val->nama_divisi }}</td>
                                                <td>
                                                    No Surat : <b>{{ $val->no_surat }}</b> <br>
                                                    Jenis Surat : <b>{{ $val->jenis_surat }}</b> <br>
                                                    Id Program : <b>{{ $val->id_program }}</b> <br>
                                                    Nama Program : <b>{{ $val->nama_program }}</b> <br>
                                                    Periode : <b>{{ date('d-M-Y', strtotime($val->periode_awal)) }} s/d {{ date('d-M-Y', strtotime($val->periode_akhir)) }}</b> <br>
                                                    <a href="{{ route('upload_kirim_surat_history.view', $val->no_urut) }}" class="btn btn-success btn-sm">View Detail Surat</a>
                                                </td>
                                                {{-- <td>{{ $val->jenis_surat }}</td>
                                                <td>{{ $val->id_program }}</td>
                                                <td>{{ $val->nama_program }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->periode_awal)) }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->periode_akhir)) }}</td> --}}
                                                <td>
                                                    {{-- <a href="{{ route('upload_kirim_surat/view_app.view_approve', $val->no_urut) }}" class="btn btn-primary btn-sm">View Approve</a> --}}
                                                    Approve SSD :  
                                                    @if($val->status_approval_ssd == '0' )
                                                        <label class="badge badge-secondary">Menunggu</label> <br>
                                                    @elseif($val->status_approval_ssd == '2')
                                                        <label class="badge badge-danger">Ditolak</label> ({{ date('d-M-y', strtotime($val->tgl_approval_ssd)) }} || oleh: {{ $val->nama_ssd }}) <br>
                                                    @elseif($val->status_approval_ssd == '3')
                                                        Ditunda ({{ date('d-M-y', strtotime($val->tgl_approval_ssd)) }} || oleh: {{ $val->nama_ssd }}) <br>
                                                    @elseif($val->status_approval_ssd == '1')
                                                        <label class="badge badge-success">Disetujui</label> ({{ date('d-M-y', strtotime($val->tgl_approval_ssd)) }} || oleh: {{ $val->nama_ssd }}) <br>
                                                    @endif <br>

                                                    Approve Manager : 
                                                    @if($val->status_approval_manager == '0' )
                                                        <label class="badge badge-secondary">Menunggu</label> <br>
                                                    @elseif($val->status_approval_manager == '2')
                                                        <label class="badge badge-danger">Ditolak</label> ({{ date('d-M-y', strtotime($val->tgl_approval_manager)) }} || oleh: {{ $val->nama_manager }}) <br>
                                                    @elseif($val->status_approval_manager == '3')
                                                        Ditunda ({{ date('d-M-y', strtotime($val->tgl_approval_manager)) }} || oleh: {{ $val->nama_manager }}) <br>
                                                    @elseif($val->status_approval_manager == '1')
                                                        <label class="badge badge-success">Disetujui</label> ({{ date('d-M-y', strtotime($val->tgl_approval_manager)) }} || oleh: {{ $val->nama_manager }}) <br>
                                                    @endif <br>

                                                    Approve SOM : 
                                                    @if($val->status_approval_som == '0' )
                                                        <label class="badge badge-secondary">Menunggu</label> <br>
                                                    @elseif($val->status_approval_som == '2')
                                                        <label class="badge badge-danger">Ditolak</label> ({{ date('d-M-y', strtotime($val->tgl_approval_som)) }} || oleh: {{ $val->nama_som }}) <br>
                                                    @elseif($val->status_approval_som == '3')
                                                        Ditunda ({{ date('d-M-y', strtotime($val->tgl_approval_som)) }} || oleh: {{ $val->nama_som }}) <br>
                                                    @elseif($val->status_approval_som == '1')
                                                        <label class="badge badge-success">Disetujui</label> ({{ date('d-M-y', strtotime($val->tgl_approval_som)) }} || oleh: {{ $val->nama_som }}) <br>
                                                    @endif <br>
                                                </td>
                                                @if(Auth::user()->kode_sub_divisi == '14') <!-- jika Kpj -->
                                                    @if($val->status_terima_kpj == '0')
                                                        <td align="center"><label class="badge badge-warning">Surat Program Baru</label> </td>
                                                    @elseif($val->status_terima_kpj == '1')
                                                        <td align="center"><label class="badge badge-success">Sudah diterima</label> </td>
                                                    @endif
                                                @elseif(Auth::user()->kode_sub_divisi == '13') <!-- jika ASM -->
                                                    @if($val->status_terima_asm == '0')
                                                        <td align="center"><label class="badge badge-warning">Surat Program Baru</label> </td>
                                                    @elseif($val->status_terima_asm == '1')
                                                        <td align="center"><a href="{{ route('upload_kirim_surat/penerima.view_terima_surat', $val->no_urut) }}" class="btn btn-primary btn-sm">View Status Kirim</a></td>
                                                    @endif
                                                @else
                                                    <td align="center"><a href="{{ route('upload_kirim_surat/penerima.view_terima_surat', $val->no_urut) }}" class="btn btn-primary btn-sm">View Status Kirim</a></td>
                                                @endif
                                                <td hidden>{{ $val->status_approval_ssd }}</td>
                                                <td hidden>{{ $val->status_approval_manager }}</td>
                                                <td hidden>{{ $val->status_approval_som }}</td>    
                                                @if(Auth::user()->kode_sub_divisi == '12' or Auth::user()->kode_sub_divisi == '17' or Auth::user()->kode_sub_divisi == '16') <!-- jika SSD,CO_SSD, dan SOM -->
                                                    <td align="center">
                                                        @if(Auth::user()->kode_sub_divisi == '12') <!-- SSD -->
                                                            @if($val->status_approval_ssd == '0')
                                                                <label class="badge badge-warning">New</label> 
                                                            @elseif($val->status_approval_ssd == '1')
                                                                <label class="badge badge-success">Approved</label> 
                                                            @elseif($val->status_approval_ssd == '2')
                                                                <label class="badge badge-danger">Denied</label> 
                                                            @endif
                                                        @elseif(Auth::user()->kode_sub_divisi == '17') <!-- Manager SSD -->
                                                            @if($val->status_approval_manager == '0')
                                                                <label class="badge badge-warning">New</label> 
                                                            @elseif($val->status_approval_manager == '1')
                                                                <label class="badge badge-success">Approved</label> 
                                                            @elseif($val->status_approval_manager == '2')
                                                                <label class="badge badge-danger">Denied</label> 
                                                            @endif
                                                        @elseif(Auth::user()->kode_sub_divisi == '16') <!-- Manager SOM -->
                                                            @if($val->status_approval_som == '0')
                                                                <label class="badge badge-warning">New</label> 
                                                            @elseif($val->status_approval_som == '1')
                                                                <label class="badge badge-success">Approved</label> 
                                                            @elseif($val->status_approval_som == '2')
                                                                <label class="badge badge-danger">Denied</label> 
                                                            @endif
                                                        @endif
                                                    </td>
                                                @else
                                                    <td hidden></td>
                                                @endif
                                                {{-- <td align="center"><a href="{{ route('upload_kirim_surat_history.view', $val->no_urut) }}" class="btn btn-success btn-sm">View Detail</a></td>   --}}
                                            </tr>
                                            @empty
                                            <tr>
                                                @if(Auth::user()->kode_sub_divisi == '12' or Auth::user()->kode_sub_divisi == '17' or Auth::user()->kode_sub_divisi == '16')
                                                    <td colspan="14" class="text-center">Tidak ada data</td>
                                                @else
                                                    <td colspan="14" class="text-center">Tidak ada data</td>
                                                @endif
                                                
                                            </tr>
                                            @endforelse
                                            <style>
                                                .colored-row {
                                                    background-color: #c5f9cd;
                                                }
                                            </style>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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
                scrollY: "385px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 2,
                    right: 1,
                },
            });

            // drawCallback: function(settings) {
            //         updateRowColors();
            // }
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });

            updateRowColors();

            function updateRowColors() {
                console.log("Updating row colors...");
                table.rows().every(function() {
                    var data = this.data();
                    var status_ssd = data[18];
                    var status_manager = data[19];
                    var status_som = data[20];

                        //alert(status_ssd);
                        // console.table(data);

                    var row = this.node();

                    if (status_ssd === '1' && status_manager === '1' && status_som === '1') {
                        
                        row.style.backgroundColor = '#c5f9cd';
                    } else {
                        
                        row.style.backgroundColor = '';
                    }
                });
                console.log("Row colors updated.");
            }
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