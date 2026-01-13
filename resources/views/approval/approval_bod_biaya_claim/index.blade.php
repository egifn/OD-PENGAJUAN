@extends('layouts.admin')

@section('title')
    <title> Daftar Program Claim</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Claim</li>
        <li class="breadcrumb-item active">Daftar Program</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Program Claim
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('approval_bod_biaya_claim/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Surat</th>
                                                <th>Tgl Surat</th>
                                                <th hidden>kode Perusahaan</th>
                                                <th hidden>Kode Depo</th>
                                                <th>Jenis Surat</th>
                                                <th>Id Program</th>
                                                <th>Nama Program</th>
                                                <th>Jml partisipan</th>
                                                <th>Periode</th>
                                                <th>Kategori</th>
                                                <th hidden>Channel/Segmen</th>
                                                <th>Kategori Sku</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($data_claim as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td><strong>{{ $val->no_surat }}</strong></td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_upload_kirim)) }}</td>
                                                <td hidden>{{ $val->kode_perusahaan_user }}</td>
                                                <td hidden>{{ $val->kode_depo_user }}</td>
                                                <td>{{ $val->jenis_surat }}</td>
                                                <td>{{ $val->id_program }}</td>
                                                <td>{{ $val->nama_program }}</td>
                                                <td>{{ $val->jml_peserta }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->periode_awal)) }} - {{ date('d-M-Y', strtotime($val->periode_akhir)) }}</td>
                                                <td>{{ $val->kategori }}</td>
                                                <td hidden>{{ $val->segmen }}</td>
                                                <td>{{ str_replace(['[', '"', ']'], '', $val->sku) }}</td>
                                            </tr>
                                            <?php $no++ ?>
                                            @empty
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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