@section('js')


<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>View Approval (SPP - Manual)</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item active">View Approval (SPP - Manual)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Approval (SPP - Manual)</h4>
                            </div>
                        </div>
                    </div>

<!-- ################################### COBA #################################### -->
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <b>No SPP : &nbsp; <a href="{{ route('spp.spp_pdf',$no_urut->no_urut) }}" target="_blank">{{ $no_urut->no_spp }}</a></b> <i>(Klik untuk melihat SPP)</i>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:180px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>Id Tipe</th>
                                                    <th>No SPP</th>
                                                    <th>Tgl SPP</th>
                                                    <th>Vendor</th>
                                                    <th>Keterangan</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($approval_spp_head as $row)
                                                <tr>
                                                    <td hidden></td>
                                                    <td>{{ $row->no_spp }}</td>
                                                    <td>{{ $row->tgl_spp }}</td>
                                                    <td>{{ $row->for }}</td>
                                                    <td>{{ $row->keterangan }}</td>
                                                    <td align="right">{{ number_format($row->jumlah) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td align="center" colspan="4"><b>T o t a l</b></td>
                                                    <td align="right"><b>Rp. {{ number_format($no_urut->jumlah) }}</b></td>
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
                                                    
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    
                                </div>
                                <br>
                                <div class="row">
                                    @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                        @if(Auth::user()->kode_sub_divisi == '5') <!-- Jika Biaya Accounting-->

                                            @if($no_urut->status_spp_1  == '1') <!-- 1: approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>  
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($no_urut->status_spp_1  == '2') <!-- 2: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($no_urut->status_spp_1  == '3') <!-- 3: Pending -->
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
                                                    <!-- <a href="{{ route('approval_cost_update', $no_urut->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_denied', $no_urut->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_pending', $no_urut->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif

                                        @elseif(Auth::user()->kode_sub_divisi == '4') <!-- Jika Kepala Akunting-->
                                            
                                            @if($no_urut->status_spp_2  == '1') <!-- 1: approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($no_urut->status_spp_2  == '2') <!-- 2: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($no_urut->status_spp_2  == '3') <!-- 3: Pending -->
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
                                                    <!-- <a href="{{ route('approval_cost_update', $no_urut->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_denied', $no_urut->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval_cost_pending', $no_urut->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
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
                                                            <form action="{{ route('approval_spp_update_manual', $no_urut->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                    <input type="text" name="no_urut_spp" id="no_urut_spp" class="form-control" value="{{ $no_urut->no_urut }}" required readonly hidden>
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
                                                            <form action="{{ route('approval_spp_denied_manual', $no_urut->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                    <input type="text" name="no_urut_spp" id="no_urut_spp" class="form-control" value="{{ $no_urut->no_urut }}" required readonly hidden>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
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
                                                            <form action="{{ route('approval_spp_pending_manual', $no_urut->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                    <input type="text" name="no_urut_spp" id="no_urut_spp" class="form-control" value="{{ $no_urut->no_urut }}" required readonly hidden>
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




