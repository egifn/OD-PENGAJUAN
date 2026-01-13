@section('js')


<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>View Approval (SPP)</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item active">View Approval (SPP)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Approval (SPP)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan_b" class="form-control" value="{{ $approval_cost_spp_head->kode_pengajuan_b }}" required readonly>   
                                    </div>
                        
                                    <div class="col-md-2 mb-2">
                                        Yang Mengajukan
                                        <input type="text" name="nama" class="form-control" value="{{ $approval_cost_spp_head->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $approval_cost_spp_head->nama_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="depo" class="form-control" value="{{ $approval_cost_spp_head->nama_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Divisi
                                        <input type="text" name="divisi" class="form-control" value="{{ $approval_cost_spp_head->nama_divisi }}" required readonly>
                                    </div>

                                </div>
                               
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tanggal Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime($approval_cost_spp_head->tgl_pengajuan_b)) }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="kategori" class="form-control" value="{{ $approval_cost_spp_head->nama_pengeluaran }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Tipe
                                        <input type="text" name="tipe" class="form-control" value="{{ $approval_cost_spp_head->tipe }}"  readonly>
                                       
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Keterangan
                                        <input type="text" name="request" class="form-control" value="{{ $approval_cost_spp_head->keterangan }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2" hidden>
                                        
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $approval_cost_spp_head->no_urut }}" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut SPP
                                        <input type="text" name="no_urut_spp" id="no_urut_spp" class="form-control" value="{{ $approval_cost_spp_head->no_urut_spp }}" required readonly>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>

<!-- ################################### COBA #################################### -->
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
								<b>No Pengajuan : &nbsp; <a href="{{ route('approval_spp/view_p_claim.view_p_claim', $approval_cost_spp_head->no_urut) }}" target="_blank">{{ $approval_cost_spp_head->kode_pengajuan_b }}</a></b> <i>(Klik untuk melihat detail pengajuan)</i>
                                <br>
                                <b>No SPP : &nbsp; <a href="{{ route('spp.spp_pdf',$approval_cost_spp_head->no_urut_spp) }}" target="_blank">{{ $approval_cost_spp_head->no_spp }}</a></b> <i>(Klik untuk melihat SPP)</i>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:180px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>Id Tipe</th>
                                                    <th>Uraian</th>
                                                    <th>Spesifikasi</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($approval_cost_spp_detail as $row)
                                                <tr>
                                                    <td hidden>{{ $row->no_urut}}</td>
                                                    <td>{{ $row->description}}</td>
                                                    <td>{{ $row->spesifikasi}}</td>
                                                    <td align="right">{{ $row->qty}}</td>
                                                    <td align="right">{{ number_format($row->harga) }}</td>
                                                    <td align="right">{{ number_format($row->tharga) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td align="center" colspan="4"><b>T o t a l</b></td>
                                                    <td align="right"><b>Rp. {{ number_format($approval_cost_spp_total) }}</b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-10 mb-2">
                                        <div class="input-group mb-3">
                                            
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($approval_cost_spp_upload as $row)
                                                    <tr>
                                                        <td><i>Attachment_{{ $no }}</i></td>
                                                        <td>
                                                            <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                {{ $row->filename }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    @empty
                                                    
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        <label for="total" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                    </div>  
                                    <div class="col-md-2 mb-2" hidden>
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div> --}}
                                </div>
                                <br>
                                <div class="row">
                                    @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                        @if(Auth::user()->kode_sub_divisi == '5') <!-- Jika Biaya Accounting-->

                                            @if($approval_cost_spp_head->status_spp_1  == '1') <!-- 1: approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_spp_head->status_spp_1  == '2') <!-- 2: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_spp_head->status_spp_1  == '3') <!-- 3: Pending -->
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
                                                    <!-- <a href="{{ route('approval_cost_update', $approval_cost_spp_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_denied', $approval_cost_spp_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_pending', $approval_cost_spp_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif

                                        @elseif(Auth::user()->kode_sub_divisi == '4') <!-- Jika Kepala Akunting-->
                                            
                                            @if($approval_cost_spp_head->status_spp_2  == '1') <!-- 1: approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_spp_head->status_spp_2  == '2') <!-- 2: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_spp_head->status_spp_2  == '3') <!-- 3: Pending -->
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
                                                    <!-- <a href="{{ route('approval_cost_update', $approval_cost_spp_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_denied', $approval_cost_spp_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_pending', $approval_cost_spp_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif
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
                                                            <form action="{{ route('approval_spp_update', $approval_cost_spp_head->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                    <input type="text" name="no_urut_spp" id="no_urut_spp" class="form-control" value="{{ $approval_cost_spp_head->no_urut_spp }}" required readonly hidden>
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
                                                            <form action="{{ route('approval_spp_denied', $approval_cost_spp_head->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                    <input type="text" name="no_urut_spp" id="no_urut_spp" class="form-control" value="{{ $approval_cost_spp_head->no_urut_spp }}" required readonly hidden>
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
                                                            <form action="{{ route('approval_spp_pending', $approval_cost_spp_head->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                    <input type="text" name="no_urut_spp" id="no_urut_spp" class="form-control" value="{{ $approval_cost_spp_head->no_urut_spp }}" required readonly hidden>
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
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
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




