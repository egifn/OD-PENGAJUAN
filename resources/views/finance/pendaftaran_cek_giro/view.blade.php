@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Registration Check/Giro</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Check/Giro</li>
        <li class="breadcrumb-item ">Pendaftaran</li>
        <li class="breadcrumb-item active">View</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                View Check/Giro 
                                <button class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="row">
                                    <div class="col-md-3 mb-2">
                                        No.Pendaftaran
                                        <input type="text" name="kode" class="form-control" value="{{ $pendaftaran_head->kode_daftar }}" style="text-align: center;" required readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Kode Seri Warkat
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ $pendaftaran_head->kode_seri_buku }}" style="text-align: center;" required readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        No Seri Awal
                                        <input type="text" name="kode" class="form-control" value="{{ $pendaftaran_head->seri_awal }}" style="text-align: center;" required readonly> 
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        No Seri Akhir
                                        <input type="text" name="kode" class="form-control" value="{{ $pendaftaran_head->seri_akhir }}" style="text-align: center;" required readonly> 
                                    </div>

                                </div>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Warkat</th>
                                            <th hidden>No Check</th>
                                            <th>Perusahaan</th>
                                            <th>Bank</th>
                                            <th>No. Rek.</th>
                                            
                                            <th>Keterangan</th>
                                            <th>Jenis</th>
                                            <th>Tgl. Reg.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @forelse($pendaftaran_detail as $val)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td align="right">{{ $val->id_cek }}</td>
                                            <td align="right" hidden>{{ $val->no_cek}}</td>
                                            <td>{{ $val->nama_perusahaan}}</td>
                                            <td>{{ $val->nama_bank}}</td>
                                            <td align="right">{{ $val->no_rek_comp }}</td>
                                            
                                            <td>{{ $val->keterangan }}</td>
                                            <td>{{ $val->jenis }}</td>
                                            <td>{{ date('d-M-Y', strtotime($val->tgl_daftar)) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No data available</td>
                                        </tr>
                                       @endforelse
                                    </tbody>
                                </table>
                               
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