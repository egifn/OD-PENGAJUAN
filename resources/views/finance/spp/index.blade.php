@extends('layouts.admin')

@section('title')
    <title>Daftar SPP</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item active">Daftar SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar SPP
                                <a href="#" class="btn btn-primary btn-sm float-right" hidden>Buat SPP</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('spp/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div> 
                                
                                <div class="input-group mb-3 col-md-4">  
                                    <a href="#" id="btnExportExcel" class="btn btn-success">
                                            <i class="bi bi-file-earmark-excel"></i> Cetak Excel
                                    </a>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>No. Urut</th>
                                            <th>No. SPP</th>
                                            <th>Tgl SPP</th>
                                            <th>Yang Mengajukan</th>
                                            <th>Keterangan</th>
                                            <th>Nilai SPP</th>
                                            <th>Input oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($spp as $val)
                                        <tr>
                                            <td hidden>{{ $val->no_urut }}</td>
                                            <td><strong>{{ $val->no_spp }}</strong></td>
                                            <td>{{ $val->tgl_spp }}</td>
                                            <td>{{ $val->yang_mengajukan }}</td>
                                            <td>{{ $val->keterangan }}</td>
                                            <td align = "right">{{ number_format($val->jumlah) }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td align="center">   
                                                <a href="{{ route('spp/view.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a> 
                                                <a href="{{ route('spp.spp_pdf', $val->no_urut) }}" target="_blank" class="btn btn-warning btn-sm">Print</a>   
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No data available</td>
                                        </tr>
                                        @endforelse
                                       
                                    </tbody>
                                </table>
                               
                            </div>
                            <!-- PAGINATION  -->
                            
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

    <script>
        document.getElementById('btnExportExcel').addEventListener('click', function(e) {
            e.preventDefault();
            let drp = $('#tanggal').data('daterangepicker');
            let tanggal_awal  = drp.startDate.format('YYYY-MM-DD');
            let tanggal_akhir = drp.endDate.format('YYYY-MM-DD');

            let params = new URLSearchParams({
                tanggal_awal: tanggal_awal,
                tanggal_akhir: tanggal_akhir
            }).toString();

            window.open(`{{ route('spp/view_excel.view_excel') }}?${params}`, '_blank');
        });
    </script>
@endsection