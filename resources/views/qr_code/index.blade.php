@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Qr Code</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Qr Code</li>
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
                                <a href="{{ route('qr_code.index') }}" class="btn btn-primary btn-sm float-right"><b>K e m b a l i</b></a>
                                <!--<button class="btn btn-warning btn-sm float-right" onclick="goBack()"><b>K e m b a l i</b></button>-->
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('get_in/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-5 float-right" hidden> 
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="">Kategori</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Secondary">Secondary</option>
                                    </select> 
                                    &nbsp
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
                                                <th hidden>kode</th>
                                                <th>Id</th>
                                                <th>Perusahaan</th>
                                                <th>Depo</th>
                                                <th>Nama SPV</th>
                                                <th>Nama Toko</th>
                                                <th>Alamat</th>   
                                                <th>Titik Lokasi</th>
                                                <th>Telepon</th>
                                                <th>Biaya Sewa</th>
                                                <th>Jenis</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($qr_data_view as $data)
                                            <tr>
                                                <td align="center">{{ $no++ }}</td>
                                                <td hidden>{{ $data->kode }}</td>
                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->nama_perusahaan }}</td>
                                                <td>{{ $data->nama_depo }}</td>
                                                <td>{{ $data->kode_spv }}</td>
                                                <td>{{ $data->nama }}</td>
                                                <td>{{ $data->alamat }}</td>
                                                <td>{{ $data->koordinat_lintang }} - {{ $data->koordinat_bujur }}</td>
                                                <td>{{ $data->telepon }}</td>
                                                <td align="right">{{ number_format($data->biaya_sewa) }}</td> 
                                                <td>{{ $data->jenis }}</td>
                                                <td align="center">
                                                    <a href="{{ route('generate',$data->id) }}" target="_blank" class="btn btn-success btn-sm">Cetak</a>
                                                    <a href="{{ route('qr_code/update',$data->id) }}" class="btn btn-warning btn-sm"> Edit </a>
                                                </td>
                                            </tr>
                                        @endforeach
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