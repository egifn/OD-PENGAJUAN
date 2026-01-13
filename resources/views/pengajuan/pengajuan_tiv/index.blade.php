@extends('layouts.admin')

@section('title')
    <title>Pengajuan Tanggungan TIV</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">Tanggungan TIV</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Tanggungan TIV
                                @if(Auth::user()->kode_sub_divisi == '12' or Auth::user()->kode_sub_divisi == '17' or Auth::user()->kode_sub_divisi == '16')

                                @else
                                    @if(Auth::user()->type == 'Admin')
                                        <a href="{{ route('pengajuan_tiv.create') }}" class="btn btn-primary btn-sm float-right">Buat Pengajuan</a>
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

                            <form action="{{ route('pengajuan_tiv/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                    
                                    <table id="datatabel" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>No</th>
                                                <th>Kode Pengajuan</th>
                                                <th>Tgl Pengajuan</th>
												<th>Perusahaan</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th>Keterangan</th>
                                                <th>No Surat</th>
                                                <th>Status</th>
                                                <th>Pengajuan Oleh</th>
                                                @if(Auth::user()->type == 'Admin')
                                                    <th>Disetujui Oleh</th>
                                                @endif
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pengajuan_tiv as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                <td>{{ $val->tgl_pengajuan_b }}</td>
												<td>{{ $val->kode_perusahaan_tujuan }}</td>
                                                <td hidden>{{ $val->kode_perusahaan}}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td>{{ $val->no_surat_program }}</td>
                                                @if(Auth::user()->kode_sub_divisi == '12' or Auth::user()->kode_sub_divisi == '17' or Auth::user()->kode_sub_divisi == '16')
                                                    <td align="center">
                                                        @if(Auth::user()->kode_sub_divisi == '12') <!-- SSD -->
                                                            @if($val->status_ssd == '0')
                                                                <label class="badge badge-primary">New</label> 
                                                            @elseif($val->status_ssd == '1')
                                                                <label class="badge badge-success">Approved</label> 
                                                            @elseif($val->status_ssd == '2')
                                                                <label class="badge badge-danger">Denied</label> 
                                                            @endif
                                                        @elseif(Auth::user()->kode_sub_divisi == '17') <!-- Manager SSD -->
                                                            @if($val->status_atasan == '0')
                                                                <label class="badge badge-primary">New</label> 
                                                            @elseif($val->status_atasan == '1')
                                                                <label class="badge badge-success">Approved</label> 
                                                            @elseif($val->status_atasan == '2')
                                                                <label class="badge badge-danger">Denied</label> 
                                                            @endif
                                                        @elseif(Auth::user()->kode_sub_divisi == '16') <!-- Manager SOM -->
                                                            @if($val->status_som == '0')
                                                                <label class="badge badge-primary">New</label> 
                                                            @elseif($val->status_som == '1')
                                                                <label class="badge badge-success">Approved</label> 
                                                            @elseif($val->status_som == '2')
                                                                <label class="badge badge-danger">Denied</label> 
                                                            @endif
                                                        @endif
                                                    </td>
                                                @else
                                                    <td align="center">
                                                        @if(Auth::user()->type == 'Manager')
                                                            @if(Auth::user()->kode_perusahaan == 'ARS')
                                                                @if($val->status_som == '0')
                                                                    <label class="badge badge-primary">New</label> 
                                                                @elseif($val->status_som == '1')
                                                                    <label class="badge badge-success">Approved</label> 
                                                                @elseif($val->status_som == '2')
                                                                    <label class="badge badge-danger">Denied</label> 
                                                                @endif
                                                            @else
                                                                @if($val->status_atasan == '0')
                                                                    <label class="badge badge-primary">New</label> 
                                                                @elseif($val->status_atasan == '1')
                                                                    <label class="badge badge-success">Approved</label> 
                                                                @elseif($val->status_atasan == '2')
                                                                    <label class="badge badge-danger">Denied</label> 
                                                                @endif
                                                            @endif
                                                            
                                                        @else
                                                            @if($val->status == '0' && $val->status_validasi_clm == '0' )
                                                                <label class="badge badge-primary">New</label> 
															@elseif($val->status == '0' && $val->status_validasi_clm == '1' )
                                                                <label class="badge badge-secondary">Process</label> 
															@elseif($val->status == '0' && $val->status_validasi_clm == '3')
																<a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending (revision from Claim)</a>
                                                            @elseif($val->status == '1')
                                                                <label class="badge badge-success">Approved</label> 
                                                            @elseif($val->status == '2')
                                                                <label class="badge badge-danger">Denied</label> 
                                                            @elseif($val->status == '3')
                                                                <label class="badge badge-warning">Pending</label> 
                                                            @endif
                                                        @endif  
                                                        
                                                    </td>
                                                @endif
                                                <td>{{ $val->name }}</td>
                                                
                                                @if(Auth::user()->type == 'Admin')
                                                <td align="center">
                                                    <a href="{{ route('pengajuan_tiv/view_approval.view_approval', $val->no_urut) }}" target="_blank" class="btn btn-warning btn-sm">View Apprvd</a>
                                                </td>
                                                @endif
                                                
                                                <td align="center">
                                                    @if(Auth::user()->type == 'Admin')
                                                        @if(Auth::user()->kode_depo == '002')
                                                            @if(Auth::user()->kode_divisi == '13')
                                                                @if(Auth::user()->kode_sub_divisi == null || Auth::user()->kode_sub_divisi == '')
                                                                    {{-- @if($val->status == '0' && $val->status_validasi_clm == '3' ) --}}
                                                                        <a href="{{ route('pengajuan_tiv/update_data', $val->no_urut) }}" class="btn btn-warning btn-sm">Edit</a> 
                                                                    {{-- @endif     --}}
                                                                @endif
                                                            @endif
                                                        @endif
                                                        <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                    @else
                                                        {{-- @if($val->status_atasan == '0')
                                                            <a href="{{ route('approval_tiv/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                        @elseif($val->status_atasan == '3')
                                                            <a href="{{ route('approval_tiv/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                        @endif  --}}
                                                        <a href="{{ route('pengajuan_tiv.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                    @endif    
                                                    <a href="{{ route('pengajuan_tiv/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>


                                                </td>
                                            </tr>

                                            <!-- Modal Keterangan -->
                                            <div class="modal fade" id="modalKet{{ $val->no_urut }}" tabindex="-1" aria-labelledby="modalKet" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="#" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <b>{{ $val->kode_pengajuan_b }}</b>
                                                                    <br>
                                                                    <br>
                                                                    <label for="">keterangan</label>

                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" value= "{{ $val->keterangan_detail_clm }}" required>{{ $val->keterangan_detail_clm }}</textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal Keterangan -->

                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
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