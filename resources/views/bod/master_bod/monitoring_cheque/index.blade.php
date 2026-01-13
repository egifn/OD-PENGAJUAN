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


<script type="text/javascript">
    fetchAllDataMonitoring();
    function fetchAllDataMonitoring(){
        
    }
</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Monitoring Cheque</title>
@endsection

@section('content')

<main class="main">
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Summary</li>
        <li class="breadcrumb-item active">Monitoring Cheque</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Monitoring Cheque
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12 mb-4">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tampung" role="tampung" aria-controls="cek">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Rekening Tampung</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#master" role="tab" aria-controls="master">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Rekening Master</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#biaya" role="tab" aria-controls="biaya">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Rekening Biaya</b>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tampung" role="tabpanel">      
                                        <div>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="#" method="get">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                    </div>
                    
                                                    <div class="col-md-5 mb-2">
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-2">
                                                        <div class="input-group mb-2">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th hidden>Kode Entitas</th>
                                                            <th>Nama Entitas</th>
                                                            <th>No. Rekening</th>
                                                            <th hidden>Kode Bank</th>
                                                            <th>Nama Bank</th>
                                                            <th>Internet Banking</th>
                                                            <th>Cheque</th>
                                                            <th>Transfer</th>
                                                            <th>Token</th>
                                                            <th>Nama User</th>
                                                            <th>Hak Akses</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                    @forelse($data_tampung as $tampung)
                                                        
                                                        <tr>
                                                            <td></td>
                                                            <td hidden>{{ $tampung->kode_perusahaan }}</td>
                                                            <td>{{ $tampung->nama_perusahaan }}</td>
                                                            <td>{{ $tampung->norek }}</td>
                                                            <td hidden>{{ $tampung->kode_bank }}</td>
                                                            <td>{{ $tampung->nama_bank }}</td>
                                                            <td>{{ $tampung->internet_banking }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $tampung->token }}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center">Tidak ada data</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="master" role="tabpanel">
                                        <div>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('pengajuan_cek_giro/cari.cari') }}" method="get">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                    </div>
                    
                                                    <div class="col-md-5 mb-2">
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-2">
                                                        <!-- <div class="input-group mb-2">
                                                            <input type="text" id="tanggal_terima" name="tanggal_terima" class="form-control" value="{{ request()->tanggal_terima }}">
                                                            <div class="input-group-append">
                                                                {{-- <button class="btn btn-secondary" type="button" name="button_cari_tanggal_terima" id="button_cari_tanggal_terima" value="tgl">Cari</button> --}}
                                                                <button class="btn btn-secondary" type="submit">C a r i</button>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th hidden>Kode Entitas</th>
                                                            <th>Nama Entitas</th>
                                                            <th>No. Rekening</th>
                                                            <th hidden>Kode Bank</th>
                                                            <th>Nama Bank</th>
                                                            <th>Internet Banking</th>
                                                            <th>Cheque</th>
                                                            <th>Transfer</th>
                                                            <th>Token</th>
                                                            <th>Nama User</th>
                                                            <th>Hak Akses</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                    @forelse($data_master as $master)
                                                        <tr>
                                                            <td></td>
                                                            <td hidden>{{ $master->kode_perusahaan }}</td>
                                                            <td>{{ $master->nama_perusahaan }}</td>
                                                            <td>{{ $master->norek }}</td>
                                                            <td hidden>{{ $master->kode_bank }}</td>
                                                            <td>{{ $master->nama_bank }}</td>
                                                            <td>{{ $master->internet_banking }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $master->token }}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center">Tidak ada data</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="biaya" role="tabpanel">
                                        <div>
                                            @if (session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form action="{{ route('pengajuan_cek_giro/cari.cari') }}" method="get">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                    </div>
                    
                                                    <div class="col-md-5 mb-2">
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-2">
                                                        <!-- <div class="input-group mb-2">
                                                            <input type="text" id="tanggal_terima" name="tanggal_terima" class="form-control" value="{{ request()->tanggal_terima }}">
                                                            <div class="input-group-append">
                                                                {{-- <button class="btn btn-secondary" type="button" name="button_cari_tanggal_terima" id="button_cari_tanggal_terima" value="tgl">Cari</button> --}}
                                                                <button class="btn btn-secondary" type="submit">C a r i</button>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th hidden>Kode Entitas</th>
                                                            <th>Nama Entitas</th>
                                                            <th>No. Rekening</th>
                                                            <th hidden>Kode Bank</th>
                                                            <th>Nama Bank</th>
                                                            <th>Internet Banking</th>
                                                            <th>Cheque</th>
                                                            <th>Transfer</th>
                                                            <th>Token</th>
                                                            <th>Nama User</th>
                                                            <th>Hak Akses</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                    @forelse($data_biaya as $biaya)
                                                        <tr>
                                                            <td></td>
                                                            <td hidden>{{ $biaya->kode_perusahaan }}</td>
                                                            <td>{{ $biaya->nama_perusahaan }}</td>
                                                            <td>{{ $biaya->norek }}</td>
                                                            <td hidden>{{ $biaya->kode_bank }}</td>
                                                            <td>{{ $biaya->nama_bank }}</td>
                                                            <td>{{ $biaya->internet_banking }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $biaya->token }}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center">Tidak ada data</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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