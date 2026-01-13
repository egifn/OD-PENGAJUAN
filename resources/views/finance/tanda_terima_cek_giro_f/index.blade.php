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
@stop

@extends('layouts.admin')

@section('title')
	<title>Izin F</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item active">Izin F</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Izin F
                                <a href="{{ route('tanda_terima_f.create') }}" class="btn btn-primary btn-sm float-right">Buat Izin F</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('tanda_terima_f/cari.cari') }}" method="get">
                                <div class="row">
                                    <div class="col-md-9 mb-2">
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group mb-2">
                                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                            <button class="btn btn-secondary" type="submit">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Izin</th>
                                            <th>Tanggal</th>
                                            <th>No Izin</th>
                                            <th>Judul Izin</th>
                                            <th hidden>No Urut</th>
                                            <th hidden>Id Pembuat</th>
                                            <th>Yang membuat</th>
                                            <th hidden>Id Pengaju</th>
                                            <th>Yang Mengajuakan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
                                        @php $no = 1; @endphp
                                        @forelse($data_izin_f as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $val->kode_izin_f }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_izin_f)) }}</td>
                                                <td>{{ $val->no_izin_f }}</td>
                                                <td>{{ $val->judul_izin_f }}</td>
                                                <td hidden>{{ $val->no_urut }}</td>
                                                <td hidden>{{ $val->id_user_input }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td hidden>{{ $val->id_user_pengaju }}</td>
                                                <td>{{ $val->pembawa_resi }}</td>
                                                <td align="center"><a href="{{ route('tanda_terima_f/pdf', $val->no_urut) }}" target="_blank" class="btn btn-success btn-sm">Cetak</a></td>
                                                <!-- <a href="{{ route('tanda_terima_f/pdf', $val->no_urut) }}" class="btn btn-primary btn-sm">Cetak</a> -->
                                            </tr> 
                                            <?php $no++ ?>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                               
                            </div>
                            <!--  PAGINATION  -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection