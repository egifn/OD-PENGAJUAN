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

    $(document).ready(function() {
        //INISIASI DATERANGEPICKER
        $('#tanggal_terima').daterangepicker({
               
        })        
    })
</script>

<script type="text/javascript">
    

</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Pengajuan Cek/Giro</title>
@endsection

@section('content')

<main class="main">
    <style>
        .modal-dialog {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
        }
    
        .modal-content {
            width: 100%;
            max-width: 100%;
            height: 100%;
            border: 0;
            border-radius: 0;
        }
    </style>
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Pengajuan Cek/Giro</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengajuan Cek/Giro
                                <a href="{{ route('pengajuan_cek_giro.create') }}" class="btn btn-primary btn-sm float-right">Buat Pengajuan Cek/Giro</a>
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12 mb-4">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#warkat" role="tab" aria-controls="warkat">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Daftar Pengajuan</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#rincian" role="tab" aria-controls="rincian">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Daftar Pengajuan Diterima</b>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="warkat" role="tabpanel">      
                                        <div class="card-body">
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
                                                        <div class="input-group mb-2">
                                                            <!-- <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                                            <div class="input-group-append">
                                                                {{-- <button class="btn btn-secondary" type="button" name="button_cari_tanggal" id="button_cari_tanggal" value="tgl">Cari</button> --}}
                                                                <button class="btn btn-secondary" type="submit">C a r i</button>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <!-- <table class="table table-hover table-bordered"> -->
                                                {{-- <table class="table table-bordered table-striped table-sm"> --}}
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kode Permintaan</th>
                                                            <th>Tgl Permintaan</th>
                                                            <th hidden>Tgl Terima</th>
                                                            <th>Keterangan</th>
                                                            <th>Jml Pengajuan Buku</th>
                                                            <th>Jml Sisa Buku Blm Terima</th>
                                                            <th hidden>Kode Pembawa Resi</th>
                                                            <th>Pembawa Resi</th>
                                                            <th hidden>Id User Input</th>
                                                            <th>Nama User</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        @php $no = 1; @endphp
                                                        @forelse($data_pengajuan_cek as $val)
                                                            @if($val->sisa_banyak_buku != 0)
                                                                <tr>
                                                                    <td>{{ $no }}</td>
                                                                    <td>{{ $val->kode_pengajuan_cek }}</td>
                                                                    <td>{{ date('d-M-Y', strtotime($val->tgl_pengajuan_cek)) }}</td>
                                                                    <td hidden></td>
                                                                    <td>{{ $val->keterangan }}</td>
                                                                    <td align="right">{{ $val->banyak_buku }} Buku</td>
                                                                    <td align="right">{{ $val->sisa_banyak_buku }} Buku</td>
                                                                    <td hidden>{{ $val->kode_pembawa_resi }}</td>
                                                                    <td>{{ $val->pembawa_resi }}</td>
                                                                    <td hidden>{{ $val->id_user_input }}</td>
                                                                    <td>{{ $val->name }}</td>
                                                                    <td align="center"><a href="{{ route('pengajuan_cek_giro.view', $val->kode_pengajuan_cek) }}" class="btn btn-success btn-sm">Terima</a> 
                                                                                    </td>
                                                                                    <!-- <a href="{{ route('pengajuan_cek_giro/pdf', $val->kode_pengajuan_cek) }}" class="btn btn-primary btn-sm">Cetak</a> -->
                                                                </tr> 
                                                                <?php $no++ ?>
                                                            @endif
                                                        @empty

                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="rincian" role="tabpanel">
                                    <div class="card-body">
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
                                                        <div class="input-group mb-2">
                                                            <input type="text" id="tanggal_terima" name="tanggal_terima" class="form-control" value="{{ request()->tanggal_terima }}">
                                                            <div class="input-group-append">
                                                                {{-- <button class="btn btn-secondary" type="button" name="button_cari_tanggal_terima" id="button_cari_tanggal_terima" value="tgl">Cari</button> --}}
                                                                <button class="btn btn-secondary" type="submit">C a r i</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kode Permintaan</th>
                                                            <th>Tgl Permintaan</th>
                                                            <th>Kode Terima</th>
                                                            <th>Tgl Terima</th>
                                                            <th hidden>Kode Pembawa Resi</th>
                                                            <th>Pembawa Resi</th>
                                                            <th>Yang Mengambil</th>
                                                            <th hidden>Id User Input</th>
                                                            <th>Nama User</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        @php $no = 1; @endphp
                                                        @forelse($data_pengajuan_cek_terima as $val_terima)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td>{{ $val_terima->kode_pengajuan_cek }}</td>
                                                                <td>{{ date('d-M-Y', strtotime($val_terima->tgl_pengajuan_cek)) }}</td>
                                                                <td>{{ $val_terima->kode_terima_cek }}</td>
                                                                <td>{{ date('d-M-Y', strtotime($val_terima->tgl_terima)) }}</td>
                                                                <td hidden>{{ $val_terima->kode_pembawa_resi }}</td>
                                                                <td>{{ $val_terima->pembawa_resi }}</td>
                                                                <td>{{ $val_terima->pengambil_buku }}</td>
                                                                <td hidden>{{ $val_terima->id_user_input }}</td>
                                                                <td>{{ $val_terima->name }}</td>
                                                                <td align="center"><a href="{{ route('pengajuan_cek_giro/pdf', $val_terima->kode_terima_cek) }}" target="_blank" class="btn btn-primary btn-sm">Cetak</a>
                                                                                   <a href="{{ route('pengajuan_cek_giro/excel', $val_terima->kode_terima_cek) }}" target="_blank" class="btn btn-success btn-sm">Excel</a> 
                                                                </td>
                                                            </tr> 
                                                            <?php $no++ ?>
                                                            
                                                        @empty

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