@extends('layouts.admin')

@section('title')
    <title>Remunerasi</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Remunerasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Remunerasi
                                @if(Auth::user()->type == 'Admin')
                                    <a href="{{ route('remun/create.create') }}" class="btn btn-primary btn-sm float-right">Buat Remunerasi</a>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('remun/cari.cari') }}" method="get">
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
                                                <th hidden>No</th>
                                                <th>Tgl Remun</th>
                                                <th hidden>No PTK</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jabatan</th>
                                                <th>Lokasi Kerja</th>
                                                <th>Pencairan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data_remun as $val)
                                            <tr>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td>{{ $val->tgl_remun }}</td>
                                                <td hidden>{{ $val->no_ptk }}</td>
                                                <td>{{ $val->nama }}</td>
                                                <td>{{ $val->jabatan }}</td>
                                                <td>{{ $val->depo }}</td>
                                                <td>{{ $val->pencairan }}</td>
                                                <td align="center">  
                                                    @if(Auth::user()->kode_divisi == '1') 
                                                        @if(Auth::user()->type == 'Manager')
                                                            @if($val->status_atasan == '0')
                                                                <a href="{{ route('remun/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @elseif($val->status_atasan == '3')
                                                                <a href="{{ route('remun/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @endif
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '6')
                                                        @if(Auth::user()->kode_sub_divisi == '5') 
                                                            @if($val->status_biaya_pusat == '0')
                                                                <a href="{{ route('remun/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @elseif($val->status_biaya_pusat == '3')
                                                                <a href="{{ route('remun/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @endif
                                                        @elseif(Auth::user()->kode_sub_divisi == '4') 
                                                            @if($val->status_biaya_pusat_koor == '0')
                                                                <a href="{{ route('remun/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @elseif($val->status_biaya_pusat_koor == '3')
                                                                <a href="{{ route('remun/view.view', $val->no_urut) }}" class="btn btn-warning btn-sm">App</a> &nbsp; &nbsp;
                                                            @endif
                                                        @endif
                                                    @endif 
                                                    <a href="{{ route('remun/view.view', $val->no_urut) }}" class="btn btn-success btn-sm">View</a> 
                                                    <a href="{{ route('remun/pdf.pdf', $val->no_urut) }}" target="_blank" class="btn btn-primary btn-sm">Print</a>
                                                    @if(Auth::user()->type == 'Admin')
                                                        <a href="{{ route('remun/update.update', $val->no_urut) }}" class="btn btn-warning btn-sm">Edit</a> 
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No data available</td>
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