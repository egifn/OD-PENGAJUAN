@extends('layouts.admin')

@section('title')
    <title>Pengajuan Biaya/Jasa</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">Pengajuan Biaya/Jasa</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Biaya/Jasa
                                <a href="{{ route('pengajuan_biaya.create') }}" class="btn btn-primary btn-sm float-right">Buat Pengajuan</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengajuan_biaya/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                    
                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>No</th>
                                                <th>Id</th>
                                                <th>Tgl Pengajuan</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Company Name</th>
                                                <th hidden>Kode Depo</th>
                                                <th>Depo</th>
                                                <th hidden>Kode Pengajuan</th>
                                                <th>Permintaan Pengajuan</th>
                                                <th>Sifat</th>
                                                <th>Status</th>
                                                <th>Pengajuan Oleh</th>
                                                <th>Disetujui Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pengajuan_biaya as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                <td hidden>{{ $val->kode_perusahaan}}</td>
                                                <td hidden>{{ $val->nama_perusahaan }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td hidden>{{ $val->kategori }}</td>
                                                <td>{{ $val->permintaan_pengajuan }}</td>
                                                <td>{{ $val->sifat }}</td>
                                                <td align="center"> 
                                                    @if($val->kategori =='1' || $val->kategori =='2' || $val->kategori =='3' || $val->kategori =='4' || $val->kategori =='5' || $val->kategori =='6') <!-- Kode Gaji,mitra,BPJS,insentif,Pajak -->
                                                        @if($val->status == '0' and $val->status_biaya_pusat == '0' and $val->status_ka_akunting == '0' and $val->status_fin == '0')
                                                            <label class="badge badge-secondary">Sent</label>
                                                        @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '0' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <label class="badge badge-secondary">Sent</label>
                                                        @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <label class="badge badge-secondary">Sent</label>
                                                        @elseif($val->status == '2' and $val->status_atasan == '2' and $val->status_biaya_pusat == '0' and $val->status_ka_akunting == '0' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">denied</a>
                                                        @elseif($val->status == '3' and $val->status_biaya_pusat == '0' and $val->status_ka_akunting == '0' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                        @elseif($val->status == '3' and $val->status_atasan == '1' and $val->status_biaya_pusat == '3' and $val->status_ka_akunting == '0' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                        @elseif($val->status == '5' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <label class="badge badge-secondary">Sent</label>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '0' and $val->status_bod == '0' )
                                                            <label class="badge badge-secondary">Sent</label>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '1' and $val->status_bod == '0')
                                                            <label class="badge badge-secondary">Sent</label>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '1' and $val->status_bod == '1')
                                                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Approved</a>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '1' and $val->status_bod == '2')
                                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Denied</a>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '1' and $val->status_bod == '3')
                                                            <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                        
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '2' and $val->status_ka_akunting == '0' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Denied</a>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '2' and $val->status_fin == '0' and $val->status_bod == '0')
                                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Denied</a>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '2' and $val->status_bod == '0')
                                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Denied</a>
                                                        @elseif($val->status == '6' and $val->status_biaya_pusat == '1' and $val->status_ka_akunting == '1' and $val->status_fin == '1' and $val->status_bod == '2')
                                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Denied</a>
														@elseif($val->status == '2')
                                                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">denied</a> 
                                                        @endif
                                                    @else
                                                        @if(Auth::user()->kode_depo == '008' && Auth::user()->kode_divisi == '13' && Auth::user()->type == 'Manager')
                                                            @if($val->status == '0' and $val->status_biaya == '0' and $val->status_atasan == '0' and $val->status_validasi_acc == '0' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '0' and $val->status_validasi_acc == '0' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '1' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '1' and $val->status_validasi_acc == '1' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '1' and $val->status_biaya_pusat == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            
                                                            @elseif($val->status == '1')
                                                                <label class="badge badge-success">P a i d</label>
                                                            @elseif($val->status == '5')
                                                                <label class="badge badge-secondary">SPP</label>
                                                            @elseif($val->status == '2')
                                                                <!-- <label class="badge badge-danger">Denied</label> -->
                                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Denied</a>
                                                            
                                                            @elseif($val->status == '3')
                                                                <!-- <label class="badge badge-warning">Pending</label> -->
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @elseif($val->status == '0' and $val->status_biaya_pusat == '0' and $val->status_biaya == '0' and $val->status_ka_akunting == '0' and $val->status_fin == '0' and $val->status_claim == '0' and $val->status_validasi == '0' and $val->status_validasi_acc == '3' and $val->status_validasi_ka_akunting == '0' and $val->status_validasi_fin == '0' and $val->status_validasi_clm == '0')
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_biaya == '3')
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @elseif($val->status == '0' and $val->status_biaya_pusat == '3' and $val->status_biaya == '1')
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @endif
                                                        @elseif(Auth::user()->kode_depo == '002' && Auth::user()->kode_divisi == '13' && Auth::user()->type == 'Admin')
                                                            
                                                        @else
                                                            @if($val->status == '0' and $val->status_biaya == '0' and $val->status_atasan == '0' and $val->status_validasi_acc == '0' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '0' and $val->status_validasi_acc == '0' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '1' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '1' and $val->status_validasi_acc == '1' and $val->status_biaya_pusat == '0')
                                                                <label class="badge badge-secondary">Sent</label>
                                                            @elseif($val->status == '0' and $val->status_biaya == '1' and $val->status_atasan == '1' and $val->status_biaya_pusat == '1')
                                                                <label class="badge badge-success">Approved</label>
                                                            
                                                            @elseif($val->status == '1')
                                                                <label class="badge badge-success">P a i d</label>
                                                            @elseif($val->status == '5')
                                                                <label class="badge badge-secondary">SPP</label>
                                                            @elseif($val->status == '2')
                                                                <!-- <label class="badge badge-danger">Denied</label> -->
                                                                <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Denied</a>
                                                            
                                                            @elseif($val->status == '3')
                                                                <!-- <label class="badge badge-warning">Pending</label> -->
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @elseif($val->status == '0' and $val->status_biaya_pusat == '0' and $val->status_biaya == '0' and $val->status_ka_akunting == '0' and $val->status_fin == '0' and $val->status_claim == '0' and $val->status_validasi == '0' and $val->status_validasi_acc == '3' and $val->status_validasi_ka_akunting == '0' and $val->status_validasi_fin == '0' and $val->status_validasi_clm == '0')
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @elseif($val->status == '0' and $val->status_biaya_pusat == '1' and $val->status_biaya == '3')
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @elseif($val->status == '0' and $val->status_biaya_pusat == '3' and $val->status_biaya == '1')
                                                                <a href="#" class="badge badge-warning" data-toggle="modal" data-target="#modalKet{{ $val->no_urut }}">Pending</a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    <a href="{{ route('pengajuan_biaya/view_approval.view_approval', $val->no_urut) }}" target="_blank" class="btn btn-warning btn-sm">View Apprvd</a>
                                                </td>
                                                <td align="center">
                                                    @if(Auth::user()->type == 'Admin')

                                                        @if(Auth::user()->id == '391' || Auth::user()->id == '698') <!-- jika finance bu berliana -->
                                                            @if($val->status_atasan == '0')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @elseif($val->status_atasan == '3')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @endif
                                                        @else

                                                            @if(Auth::user()->kode_divisi == '13' && Auth::user()->kode_sub_divisi == '12')
                                                                @if($val->status_biaya == '0')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                                @elseif($val->status_biaya == '3')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                                @endif
                                                            @else
                                                                @if($val->status == '0')
                                                                    <button class="btn btn-secondary btn-sm" disabled>Edit</button>
                                                                @elseif($val->status == '3')
                                                                    <a href="{{ route('pengajuan_biaya/update.update', $val->no_urut) }}" class="btn btn-warning btn-sm">Edit</a>
                                                                
                                                                @endif
                                                            @endif
                                                        @endif

                                                        <a href="{{ route('pengajuan_biaya.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                    @else
                                                        @if(Auth::user()->kode_depo == '002' && Auth::user()->kode_divisi == '6' && Auth::user()->kode_sub_divisi == '4' && Auth::user()->type == 'Manager')
                                                            <a href="{{ route('pengajuan_biaya.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                        @elseif(Auth::user()->kode_depo == '008' && Auth::user()->kode_divisi == '13' && Auth::user()->type == 'Manager')
                                                            @if($val->status_atasan == '0')
                                                                <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @elseif($val->status_atasan == '3')
                                                                <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @endif
                                                            <a href="{{ route('pengajuan_biaya.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                        @else
                                                            @if(Auth::user()->kode_divisi == '106' && Auth::user()->type == 'Manager')
                                                                @if($val->status_biaya == '0')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                                @elseif($val->status_biaya == '3')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                                @endif
                                                            @else
                                                                @if($val->status_atasan == '0')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                                @elseif($val->status_atasan == '3')
                                                                    <a href="{{ route('approval_cost.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                                @endif
                                                            @endif
 
                                                            <a href="{{ route('pengajuan_biaya.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a>
                                                        @endif
                                                    @endif  
                                                    
                                                    @if($val->kategori =='1' || $val->kategori =='2' || $val->kategori =='3' || $val->kategori =='4' || $val->kategori =='5' || $val->kategori =='25') <!-- Kode Gaji,mitra,BPJS,insentif,Pajak -->
                                                        <!-- <a href="{{ route('pengajuan_biaya/pdf_new.pdf_new', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a> -->
                                                        <a href="{{ route('pengajuan_biaya/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                    @else
                                                        <a href="{{ route('pengajuan_biaya/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                    @endif
                                                    
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
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="#" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <b>{{ $val->kode_pengajuan_b }}</b>
                                                                    <br>
                                                                    <br>
                                                                    <label for="">keterangan</label>
                                                                    @if(isset($pengajuan_detail[$val->no_urut]))
                                                                        @foreach($pengajuan_detail[$val->no_urut] as $det)
                                                                            @if($det->status_detail_acc =='3')
                                                                                {{ $det->description }}
                                                                                <textarea name="addKeterangan" id="addKeterangan" cols="5" rows="1" class="form-control" value= "{{ $det->keterangan_detail_acc }}" required>{{ $det->keterangan_detail_acc }}</textarea>
                                                                                <br>
                                                                            @elseif($det->status_detail =='3')
                                                                                {{ $det->description }}
                                                                                <textarea name="addKeterangan" id="addKeterangan" cols="5" rows="1" class="form-control" value= "{{ $det->keterangan_detail }}" required>{{ $det->keterangan_detail }}</textarea>
                                                                                <br>
                                                                            @elseif($det->status_detail_atasan =='3')
                                                                                {{ $det->description }}
                                                                                <textarea name="addKeterangan" id="addKeterangan" cols="5" rows="1" class="form-control" value= "{{ $det->keterangan_detail_atasan }}" required>{{ $det->keterangan_detail_atasan }}</textarea>
                                                                                <br>
                                                                            @endif
                                                                        @endforeach
                                                                    @else

                                                                    @endif
                                                                </div>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
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