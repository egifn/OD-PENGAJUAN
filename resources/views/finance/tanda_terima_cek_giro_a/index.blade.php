@extends('layouts.admin')

@section('title')
	<title>Izin A</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item active">Izin A</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Izin A
                                <a href="{{ route('tanda_terima_a.create') }}" class="btn btn-primary btn-sm float-right">Buat Izin A</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Izin</th>
                                            <th>Tgl Izin</th>
                                            <th>No Izin</th>
                                            <th>Judul Izin</th>
                                            <th hidden>No Urut</th>
                                            <th hidden>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @forelse($data_izin_a as $val)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $val->kode_izin_a }}</td>
                                            <td>{{ $val->tgl_izin_a}}</td>
                                            <td>{{ $val->no_izin_a }}</td>
                                            <td>{{ $val->judul_izin_a }}</td>
                                            <td hidden>{{ $val->no_urut }}</td>
                                            <td hidden></td>
                                        </tr>
                                        <?php $no++ ?>
                                        
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No data available</td>
                                        </tr>
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