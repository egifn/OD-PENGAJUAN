@extends('layouts.admin')

@section('title')
	<title>Izin J</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item active">Izin J</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Izin J
                                <a href="{{ route('tanda_terima_j.create') }}" class="btn btn-primary btn-sm float-right">Buat Izin J</a>
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
                                            <th hidden>#</th>
                                            <th>Receipt ID</th>
                                            <th>Tanggal</th>
                                            <th>Penerima</th>
                                            <th>No Ijin</th>
                                            <th>Input By</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
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