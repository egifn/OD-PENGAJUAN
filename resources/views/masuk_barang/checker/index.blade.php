
@extends('layouts.admin')

@section('title')
    <title>Check and Verify</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Get In</li>
        <li class="breadcrumb-item active">Check and Verify</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Check and Verify
                                <a href="{{ route('get_in.create') }}" class="btn btn-primary btn-sm float-right">Check and Verify</a>
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
                                <div class="input-group mb-3 col-md-5 float-right"> 
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
                                                <th>Id Dok</th>
                                                <th>Tanggal</th>
                                                <th>Waktu Masuk</th>   
                                                <th>Perusahaan</th>
                                                <th>Depo</th>
                                                <th>Kategori</th>
                                                <th>Pabrik/Toko</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @forelse ($in as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $val->doc_id }}</td>
                                                <td>{{ $val->tanggal }}</td>
                                                <td>{{ $val->waktu }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->kategori }}</td>
                                                <td>{{ $val->from }}</td>
                                                <td align="center">
                                                    @if($val->status == '0' and $val->status_bs == '0')
                                                        <label class="badge badge-warning">Masuk</label>
                                                    @elseif($val->status == '1' and $val->status_bs == '0')
                                                        <label class="badge badge-warning">Masuk</label>
                                                    @elseif($val->status == '0' and $val->status_bs == '1')
                                                        <label class="badge badge-warning">Masuk</label>
                                                    @elseif($val->status == '1' and $val->status_bs == '1')
                                                        <label class="badge badge-success">Selesai Bongkar</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <a href="{{ route('get_in.view', $val->doc_id) }}" class="btn btn-primary btn-sm">View</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
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