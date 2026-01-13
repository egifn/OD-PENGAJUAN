@extends('layouts.admin')

@section('title')
    <title>Upload dan Kirim Surat</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Surat Program</li>
        <li class="breadcrumb-item">Upload dan Kirim</li>
        <li class="breadcrumb-item active">Upload dan Kirim Surat</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">    
                @csrf
                <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Upload dan Kirim Surat
                                @if(Auth::user()->type == 'Manager')
                                    <a href="{{ route('upload_kirim_surat.create') }}" class="btn btn-primary btn-sm float-right" hidden>Upload dan Kirim</a>
                                @elseif(Auth::user()->type == 'Admin')
                                    @if(Auth::user()->kode_sub_divisi == '12' || Auth::user()->kode_sub_divisi == '13' || Auth::user()->kode_sub_divisi == '14' || Auth::user()->kode_sub_divisi == '15' || Auth::user()->kode_sub_divisi == '16' || Auth::user()->kode_sub_divisi == '21')
                                        <a href="{{ route('upload_kirim_surat.create') }}" class="btn btn-primary btn-sm float-right" hidden>Upload dan Kirim</a>
                                    @else
                                        <a href="{{ route('upload_kirim_surat.create') }}" class="btn btn-primary btn-sm float-right">Upload dan Kirim</a>
                                    @endif
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('upload_kirim_surat/cari.cari') }}" method="get" hidden>
                                <div class="input-group mb-3 col-md-4 float-right" hidden>  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>
                            
                            <form id="savedatas">
                                <div class="table-responsive">
                                    <table id="datatabel-v" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>no_urut</th>
                                                <th hidden>id</th>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo</th>
                                                <th hidden>kode Divisi</th>
                                                <th hidden>Divisi</th>
                                                <th>No Surat</th>
                                                <th>Jenis Surat</th>
                                                <th>Id Program</th>
                                                <th>Nama Program</th>
                                                <th>Periode Awal</th>
                                                <th>Periode Akhir</th>
												<th>Status Approved</th>
                                                <th>Status Surat Program</th>
                                                @if(Auth::user()->kode_sub_divisi == '12' or Auth::user()->kode_sub_divisi == '17' or Auth::user()->kode_sub_divisi == '16')
                                                    <th>Status</th>
                                                @else
                                                    <th hidden>Status</th>
                                                @endif
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1 ?>
                                            @forelse($data_claim as $val)
                                            <tr>
                                                @if($val->tgl_upload_kirim == today()->toDateString() || $val->periode_akhir >= today()->toDateString())
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
                                                    <td>{{ $val->no_surat }}</td>
                                                    <td>{{ $val->jenis_surat }}</td>
                                                    <td>{{ $val->id_program }}</td>
                                                    <td>{{ $val->nama_program }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($val->periode_awal)) }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($val->periode_akhir)) }}</td>
													<td align="center">
                                                        <a href="{{ route('upload_kirim_surat/view_app.view_approve', $val->no_urut) }}" class="btn btn-primary btn-sm">View Approve</a>
                                                    </td>
                                                    @if(Auth::user()->kode_sub_divisi == '14') <!-- jika Kpj  -->
                                                        @if($val->status_terima_kpj == '0')
                                                            <td align="center"><label class="badge badge-warning">Surat Program Baru</label> </td>
                                                        @elseif($val->status_terima_kpj == '1')
                                                            <td align="center"><label class="badge badge-success">Sudah diterima</label> </td>
                                                        @endif
                                                    @elseif(Auth::user()->kode_sub_divisi == '13') <!-- jika ASM  -->
                                                        @if($val->status_terima_asm == '0')
                                                            <td align="center"><label class="badge badge-warning">Surat Program Baru</label> </td>
                                                        @elseif($val->status_terima_asm == '1')
                                                            <td align="center"><a href="{{ route('upload_kirim_surat/penerima.view_terima_surat', $val->no_urut) }}" class="btn btn-primary btn-sm">View Status Kirim</a></td>
                                                        @endif
                                                    @else
                                                        {{-- <td><a href="#" class="badge badge-secondary" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Status Kirim</a></td> --}}
                                                        {{-- <td align="center"><button class="btn btn-sm btn-secondary btn-open-modal" data-target="#modalKet{{ $val->no_urut }}">Status Kirim</button></td> --}}
                                                        <td align="center"><a href="{{ route('upload_kirim_surat/penerima.view_terima_surat', $val->no_urut) }}" class="btn btn-primary btn-sm">View Status Kirim</a></td>
                                                    @endif
                                                    
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
                                                    <td align="center">
                                                        <a href="{{ route('upload_kirim_surat.view', $val->no_urut) }}" class="btn btn-success btn-sm">View Detail</a>
                                                        @if(Auth::user()->kode_sub_divisi == '12' or Auth::user()->kode_sub_divisi == '17' or Auth::user()->kode_sub_divisi == '16')
                                                        
                                                        @else
                                                            
                                                        @endif
                                                    </td>      
                                                @endif
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
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </form>
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
                    right: 1,
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

<script type="text/javascript">
    
</script>
    

@endsection