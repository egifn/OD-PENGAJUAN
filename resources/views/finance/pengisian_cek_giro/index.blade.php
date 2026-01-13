@extends('layouts.admin')

@section('title')
    <title>Pengisian Cek/Giro</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Cek-Giro</li>
        <li class="breadcrumb-item active">Pengisian Cek/Giro</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pengisian Cek/Giro
                                <a href="{{ route('pengisian_cek_giro.create') }}" class="btn btn-primary btn-sm float-right">Isi Cek/Giro</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('pengisian_cekgiro/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-8 float-right">  
                                    <select name="type" class="form-control" hidden>
                                        <option value="">Category</option>
                                        <option value="Rutin">Rutin</option>
                                        <option value="Non Rutin">Non Rutin</option>
                                    </select>
                                    &nbsp
                                    <select name="kode_sub" class="form-control">
                                        <option value="">Tipe</option>
                                       @foreach ($tipe as $row)
                                            <option value="{{ $row->kode_sub }}" {{ old('kode_sub') == $row->kode_sub ? 'selected':'' }}>{{ $row->kode_sub }} {{ $row->sub_tipe }}</option>
                                        @endforeach 
                                    </select>
                                    &nbsp
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th hidden>ID</th>
                                            <th>ID Cek/Giro</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th hidden>Company</th>
                                            <th>Kategori</th>
                                            <th>Tipe</th>
                                            <th>Sub Kategori</th>
                                            <th>No SPP</th>
                                            <th>Total</th>
                                            <th hidden>Status</th>
                                            <th>Input Oleh</th>
                                            {{-- <th>Aksi</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pengisian as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td hidden>{{ $val->kode_pengisian }}</td>
                                            <td>{{ $val->id_cek}}</td>
                                            <td>{{ date('d-M-Y', strtotime($val->tgl_pengisian)) }}</td>
                                            <td>{{ $val->description }}</td>
                                            <td hidden>{{ $val->nama_perusahaan}}</td>
                                            <td>{{ $val->categories_name}}</td>
                                            <td>{{ $val->kode_sub }}</td>
                                            <td>{{ $val->sub_categories_name }}</td>
                                            <td>{{ $val->no_spp }}</td>
                                            <td align="right">{{ number_format($val->total_cek) }}</td>
                                            <td hidden></td>
                                            <td>{{ $val->name }}</td>
                                            {{-- <td align="center">
                                                <a href="#" class="btn btn-success btn-sm">View</a>
                                            </td> --}}
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No data available</td>
                                        </tr>
                                       @endforelse
                                    </tbody>
                                </table>
                               
                            </div>
                            <!--  PAGINATION  -->
                            {!! $pengisian->links() !!}
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