
@extends('layouts.admin')

@section('title')
    <title>Mutasi Eksternal</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Mutasi</li>
        <li class="breadcrumb-item">Eksternal</li>
        <li class="breadcrumb-item active">Keluar</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Mutasi Eksternal (out)
                                <a href="{{ route('mutasi_eksternal_leader.create') }}" class="btn btn-primary btn-sm float-right" hidden>Mutasi</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('mutasi_eksternal_out_checker/cari.cari') }}" method="get">
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
                                                <th>Waktu</th>   
                                                <th>Zona</th>
                                                <th>Sub Zona</th>
                                                <th>Kategori</th>
                                                <th>Perusahaan Tujuan</th>
                                                <th>Depo Tujuan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @forelse ($data as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $val->kode_mutasi_eks }}</td>
                                                <td>{{ $val->tanggal }}</td>
                                                <td>{{ $val->waktu }}</td>
                                                <td>{{ $val->nama_area_asal}}</td>
                                                <td>{{ $val->nama_sub_area_asal }}</td>
                                                <td>{{ $val->kategori }}</td>
                                                <td>{{ $val->perusahaan_tujuan}}</td>
                                                <td>{{ $val->depo_tujuan }}</td>   
                                                <td>
                                                    @if($val->status_bm == '0')
                                                        <label class="badge badge-secondary">Baru</label>
                                                    @elseif($val->status_bm == '1')
                                                        <label class="badge badge-success">Muat</label>
                                                    @elseif($val->status_bm == '2')
                                                        <label class="badge badge-success">Muat</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <a href="{{ route('mutasi_eksternal_out_checker.view', $val->kode_mutasi_eks) }}" class="btn btn-success btn-sm">View</a>
                                                </td>
                                            </tr>
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