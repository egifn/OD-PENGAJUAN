@extends('layouts.admin')

@section('title')
	<title>Izin C</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item active">Izin C</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Izin C
                                <a href="{{ route('tanda_terima.create') }}" class="btn btn-primary btn-sm float-right">Buat Izin C</a>
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
                                        @forelse($receipt as $val)
                                        <tr>
                                            <td hidden></td>
                                            <td>{{ $val->receipt_id }}</td>
                                            <td>{{ $val->date_receipt}}</td>
                                            <td>{{ $val->penerima }}</td>
                                            <td>{{ $val->keterangan_id }}</td>
                                            <td>{{ $val->name }}</td>
                                            <td align="center">
                                                @if($val->status == '0')
                                                    <label class="badge badge-secondary">Waiting Approved</label>
                                                @elseif($val->status == '1')
                                                    <label class="badge badge-secondary">Waiting Approved</label>
                                                @elseif($val->status == '2')
                                                    <label class="badge badge-success">Approved</label>
                                                @elseif($val->status == '3')
                                                    <label class="badge badge-warning">Pending</label>
                                                @elseif($val->status == '4')
                                                    <label class="badge badge-success">Send</label>
                                                @endif
                                            </td>
                                            <td align="center">   
                                                <a href="{{ route('tanda_terima.view', $val->receipt_id) }}" class="btn btn-primary btn-sm">View</a> 
                                                <!-- <a href="#" target="_blank" class="btn btn-warning btn-sm">Print</a> -->   
                                                @if($val->status == '0')
                                                    <button class="btn btn-secondary btn-sm" disabled hidden>Kirim</button>
                                                @elseif($val->status == '1')
                                                    <button class="btn btn-secondary btn-sm" disabled hidden>Kirim</button>
                                                @elseif($val->status == '2')
                                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalKirim{{ $val->receipt_id }}" hidden>Kirim</button>
                                                @elseif($val->status == '3')
                                                    <button class="btn btn-secondary btn-sm" disabled hidden>Kirim</button>
                                                 @elseif($val->status == '4')
                                                    <button class="btn btn-secondary btn-sm" disabled hidden>Kirim</button>
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- MODAL Verif Hapus -->
                                        <div class="modal fade" id="modalKirim{{ $val->receipt_id }}" tabindex="-1" aria-labelledby="modalKirim" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h4 class="text-center">Apakah anda yakin akan mengirim dokumen ini ? "<span>{{ $val->receipt_id}}</span>"</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="#" method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End MODAL Hapus -->
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