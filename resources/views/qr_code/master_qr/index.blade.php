
@extends('layouts.admin')

@section('title')
    <title>Qr Code</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">QR Code</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                QR Code
                                <a href="{{ route('qr_code.create') }}" class="btn btn-primary btn-sm float-right"><b>Buat QR</b></a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('qr_code/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right" > 
                                    
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>kode</th>
                                                <th>Kode Perusahaan</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Jumlah QR</th>
                                                <th>Tanggal Buat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @forelse ($qr_data as $data)
                                            <tr>
                                                <td align="center">{{ $no++ }}</td>
                                                <td>{{ $data->kode }}</td>
                                                <td>{{ $data->kode_perusahaan }}</td>
                                                <td>{{ $data->nama_perusahaan }}</td>
                                                <td align="center">{{ $data->jml }}</td>
                                                <td align="center">{{ $data->tanggal }}</td>
                                                <td align="center">
                                                    <a href="{{ route('qr_code.pdf', $data->kode) }}" target="_blank" class="btn btn-success btn-sm">Cetak</a>
                                                    &nbsp
                                                    <a href="{{ route('qr_code.view', $data->kode) }}" class="btn btn-warning btn-sm"> View </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data</td>
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