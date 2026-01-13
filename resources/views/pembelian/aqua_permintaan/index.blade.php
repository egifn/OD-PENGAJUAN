@extends('layouts.admin')

@section('title')
    <title>Purchasing</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Aqua</li>
        <li class="breadcrumb-item active">PO</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                PO
                                <a href="{{ route('permintaan_aqua.create') }}" class="btn btn-primary btn-sm float-right">Create</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('permintaan_aqua/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-3 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">Search</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>PO Number</th>
                                                <th>PO Date</th>
                                                <th hidden>kode Vendor</th>
                                                <th>Vendor</th>
                                                <th>No Invoice</th>
                                                <th>Status</th>
                                                <th>Applicant's Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pembelian as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>
                                                    <a href="#" target="_blank"><strong>{{ $val->kode_pembelian }}</strong></a>
                                                </td>
                                                <td>{{ $val->tgl_pembelian }}</td>
                                                <td hidden>{{ $val->kode_vendor }}</td>
                                                <td>{{ $val->nama_vendor }}</td>
                                                <td>{{ $val->no_faktur }}</td>
                                                <td align="center">
                                                    @if($val->status == '1')
                                                        <label class="badge badge-secondary">Order</label>
                                                    @elseif($val->status == '2')
                                                        <label class="badge badge-success">Received</label>
                                                    @endif
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    
                                                        <a href="#" class="btn btn-primary btn-sm">View</a>
                                                        @if($val->status == '1')
                                                            <a href="{{ route('permintaan_aqua/accept.accept', $val->kode_pembelian) }}" class="btn btn-success btn-sm">Accept</a>
                                                        @elseif($val->status == '2')
                                                            <button onClick="alert('Order has been received')" class="btn btn-success btn-sm">Accept</button>
                                                        @endif
                                                    
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data</td>
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


