@extends('layouts.admin')

@section('title')
    <title>Purchasing</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Accounting</li>
        <li class="breadcrumb-item active">Receivable</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Receivable
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
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Invoice</th>
                                                <th>Date</th>
                                                <th hidden>kode Vendor</th>
                                                <th>Vendor Name</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($invoice as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->no_faktur }}</td>
                                                <td>{{ $val->tgl_faktur}}</td>
                                                <td hidden>{{ $val->kode_vendor }}</td>
                                                <td>{{ $val->nama_vendor }}</td>
                                                <td align="right">{{ $val->total }}</td>
                                                <td align="center">
                                                    @if($val->status == '0')
                                                         <a href="{{ route('create.create', $val->no_faktur) }}" class="btn btn-primary btn-sm">Create</a>
                                                    @elseif($val->status == '1')
                                                        <a href="#" class="btn btn-success btn-sm">View</a>
                                                    @endif
                                                   
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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


