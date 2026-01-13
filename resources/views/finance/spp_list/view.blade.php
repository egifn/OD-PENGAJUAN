@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Pembayaran</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item active">Pembayaran</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="get">
                                <div class="row">
                                    <div class="input-group mb-3 col-md-4">  
                                        
                                    </div> 
                                    
                                    <div class="input-group mb-3 col-md-4">

                                    </div>

                                    <div class="input-group mb-3 col-md-4 float-right">  
                                        
                                    </div>    
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th hidden>No Urut SPP</th>
                                            <th>No SPP</th>
                                            <th>Tgl SPP</th>
                                            <th hidden>Tgl Jatuh Tempo</th>
                                            <th>Keterangan SPP</th>
                                            <th>Perusahaan</th>
                                            <th>Jumlah</th>
                                            <th>Vendor/Supplier</th>
											<th hidden>Cara Bayar</th>
                                            <th>Kode Pengajuan</th>
                                            <th hidden>Attachment</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
                                    @php $no = 1; @endphp
                                        @forelse($data_spp_terima as $val)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td hidden>{{ $val->no_urut_spp }}</td>
                                            <td><a href="{{ route('list_spp/pdf_spp.pdf_spp', $val->no_urut_spp) }}" target="_blank">{{ $val->no_spp }}</a></td>
                                            <td>{{ date('d-M-Y', strtotime($val->tgl_spp)) }}</td>
                                            <td hidden>{{ date('d-M-Y', strtotime($val->tgl_jatuh_tempo)) }}</td>        
                                            <td>{{ $val->keterangan_spp }}</td>
                                            <td>{{ $val->kode_perusahaan }}</td>
                                            <td align="right">Rp. {{ number_format($val->jumlah) }}</td>
                                            <td>{{ $val->nama_vendor }}</td>
                                            <td hidden>{{ $val->cara_bayar }}</td>
                                            <td><a href="{{ route('list_spp/pdf_pengajuan.pdf_pengajuan', $val->no_urut_pengajuan) }}" target="_blank">{{ $val->kode_pengajuan_b }}</a></td>
                                            <td align="center" hidden><a href="#" class="badge badge-success" data-toggle="modal" data-target="#modalFiles">view files</a></td>
                                        </tr>

                                        <!-- Modal Keterangan -->
                                        <div class="modal fade" id="modalFiles{{ $val->kode_pengajuan_b }}" tabindex="-1" aria-labelledby="modalFiles" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Keterangan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $no++ ?>

                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                               
                            </div>
                            <!-- PAGINATION  -->
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                </div> 
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

