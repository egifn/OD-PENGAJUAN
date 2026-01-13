@extends('layouts.admin')

@section('title')
	<title>Izin G</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item active">Izin G</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Izin G
                                <a href="{{ route('tanda_terima_g.create') }}" class="btn btn-primary btn-sm float-right">Buat Izin G</a>
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12 mb-4">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#warkat" role="tab" aria-controls="warkat">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Daftar Kirim</b>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#rincian" role="tab" aria-controls="rincian">
                                            <i class="nav-icon icon-folder"></i>
                                            &nbsp;<b>Daftar Terima</b>
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
                                                <!-- <table class="table table-bordered table-striped table-sm"> -->
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kode Kirim</th>
                                                            <th>Tgl Kirim</th>
                                                            <th>No izin E</th>
                                                            <th>Judul Izin</th>
                                                            <th>Jml Kirim</th>
                                                            <th>Penandatangan</th>
                                                            <th hidden>Id User Input</th>
                                                            <th>Yang Membuat</th>
                                                            <th hidden>no_urut</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        @php $no = 1; @endphp
                                                        @forelse($data_pengiriman_cek as $val)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td>{{ $val->kode_izin_g }}</td>
                                                                <td>{{ date('d-M-Y', strtotime($val->tgl_kirim)) }}</td>
                                                                <td>{{ $val->no_izin_g }}</td>
                                                                <td>{{ $val->judul_izin_g }}</td>
                                                                <td align="right">{{ $val->jml_lembar }} lembar</td>
                                                                <td>{{ $val->yang_ttd }}</td>
                                                                <td hidden>{{ $val->id_user_input }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td hidden>{{ $val->no_urut }}</td>
                                                                <td align="center"><a href="{{ route('tanda_terima_g.view', $val->no_urut) }}" class="btn btn-success btn-sm">Terima</a></td>
                                                            </tr> 
                                                            <?php $no++ ?>
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
                                                            <th>Kode Kirim</th>
                                                            <th>Tgl Kirim</th>
                                                            <th>No izin E</th>
                                                            <th>Judul Izin</th>
                                                            <th>Jml Kirim</th>
                                                            <th>Penandatangan</th>
                                                            <th hidden>Id User Input</th>
                                                            <th>Yang Membuat</th>
                                                            <th hidden>no_urut</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabledata">
                                                        @php $no = 1; @endphp
                                                        @forelse($data_terima_cek as $val)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td>{{ $val->kode_izin_g }}</td>
                                                                <td>{{ date('d-M-Y', strtotime($val->tgl_kirim)) }}</td>
                                                                <td>{{ $val->no_izin_g }}</td>
                                                                <td>{{ $val->judul_izin_g }}</td>
                                                                <td align="right">{{ $val->jml_lembar }} lembar</td>
                                                                <td>{{ $val->yang_ttd }}</td>
                                                                <td hidden>{{ $val->id_user_input }}</td>
                                                                <td>{{ $val->name }}</td>
                                                                <td hidden>{{ $val->no_urut }}</td>
                                                                <td align="center"><a href="{{ route('tanda_terima_g/pdf', $val->no_urut) }}" target="_blank" class="btn btn-success btn-sm">Cetak</a></td>
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