@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Create SPPD</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval SPPD</li>
        <li class="breadcrumb-item active">SPPD (view)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail SPPD</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Pelaksana Tugas
                                        <input type="text" name="kode_pengajuan_sppd" id="kode_pengajuan_sppd" class="form-control" value="{{ $view_approval_sppd->kode_pengajuan_sppd }}" required readonly hidden>
                                        <input type="text" name="pelaksana" class="form-control" value="{{ $view_approval_sppd->pelaksana }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Divisi
                                        <input type="text" name="divisi" id="divisi" class="form-control" value="{{ $view_approval_sppd->nama_divisi }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ $view_approval_sppd->nama_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Depo
                                        <input type="text" name="depo" id="depo" class="form-control" value="{{ $view_approval_sppd->nama_depo }}" required readonly>
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Tujuan/Lokasi Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $view_approval_sppd->tujuan_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-">
                                        Tujuan/Lokasi Depo
                                        <input type="text" name="kode_depo_tujuan" id="kode_depo_tujuan" class="form-control" value="{{ $view_approval_sppd->tujuan_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Keperluan Tugas
                                        <textarea name="keperluan" id="keperluan" rows="1" class="form-control" readonly>{{ $view_approval_sppd->keperluan }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Lama Tugas (dari)
                                        <input type="text" name="lama_tugas" id="lama_tugas" class="form-control" value="{{ date('d-M-Y', strtotime($view_approval_sppd->tgl_mulai)) }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        (sampai)
                                        <input type="text" name="sampai" id="sampai" class="form-control" value="{{ date('d-M-Y', strtotime($view_approval_sppd->tgl_akhir)) }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Kendaraan yg digunakan
                                        <input type="text" name="kendaraan" id="kendaraan" class="form-control" value="{{ $view_approval_sppd->kendaraan }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        sebagai
                                        <input type="text" name="sebagai" id="sebagai" class="form-control" value="{{ $view_approval_sppd->sebagai }}" readonly required>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_approval_sppd->nama_pengeluaran }}" readonly required>
                                    </div>
                                </div>

                                @if(Auth::user()->kode_divisi == '16') <!-- Jika Biaya-->
                                <hr>
                                <span><b>Rincian Biaya:</b></span>
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Uang BBM
                                        <input type="text" name="uang_bbm" id="uang_bbm" class="form-control" style="text-align: right;" value="{{ number_format($data_bbm->uang) }}" readonly required>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        x
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jumlah
                                        <input type="text" name="jumlah" id="jumlah" class="form-control" style="text-align: right;" value="1" readonly required>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        =
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        total
                                        <input type="text" name="total" id="total" class="form-control" style="text-align: right;" value="{{ number_format($data_bbm->uang * 1) }}" readonly required>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="#" readonly required>
                                    </div>
                                </div>
                                @endif
                                <br>
                                <div class="row">
                                    @if(Auth::user()->kode_divisi == '16') <!-- Jika Biaya-->
                                        @if($view_approval_sppd->status_biaya  == '1') <!-- approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($view_approval_sppd->status_biaya  == '2') <!--denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($view_approval_sppd->status_biaya  == '3') <!-- Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                            
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                               <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @elseif(Auth::user()->kode_divisi == '1') <!-- Jika HRD-->
                                        @if($view_approval_sppd->status_hrd  == '1') <!-- approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($view_approval_sppd->status_hrd  == '2') <!--denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($view_approval_sppd->status_hrd  == '3') <!-- Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                               <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        @if($view_approval_sppd->status_atasan  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($view_approval_sppd->status_atasan  == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($view_approval_sppd->status_atasan  == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @endif

                                    <!-- MODAL APPROVED -->
                                            <div class="modal fade" id="modalTambahPesan_approve" tabindex="-1" aria-labelledby="modalTambahPesan_approve" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval_sppd_update', $view_approval_sppd->kode_pengajuan_sppd) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL DENIED -->
                                            <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan ditolak </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval_sppd_denied', $view_approval_sppd->kode_pengajuan_sppd) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL Pending -->
                                            <div class="modal fade" id="modalTambahPesan_pending" tabindex="-1" aria-labelledby="modalTambahPesan_pending" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk keterangan ditunda  </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval_sppd_pending', $view_approval_sppd->kode_pengajuan_sppd) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <div class="col-md-9 mb-2" align="right">
                                        <br>
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</main>


@endsection

@section('script')



@endsection




