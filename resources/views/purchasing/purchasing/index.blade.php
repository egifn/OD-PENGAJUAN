@extends('layouts.admin')

@section('title')
    <title>Pembelian</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchase & Payment</li>
        <li class="breadcrumb-item active">Pembelian</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Pembelian
                                <a href="{{ route('purchasing.create') }}" class="btn btn-primary btn-sm float-right">Create</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('purchasing/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-3 float-right">  
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
                                                <th hidden>#</th>
                                                <th>Kode Pembelian</th>
                                                <th>Tgl Pembelian</th>
                                                <th hidden>kode Vendor</th>
                                                <th>Vendor</th>
                                                <th>Status</th>
                                                <th>No.Receive</th>
                                                <th>Pengajuan Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pembelian as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>
                                                    {{ $val->kode_pembelian }}
                                                </td>
                                                <td>{{ $val->tgl_pembelian }}</td>
                                                <td hidden>{{ $val->kode_vendor }}</td>
                                                <td>{{ $val->nama_vendor }}</td>
                                                <td align="center">
                                                    @if($val->status == '1')
                                                        <label class="badge badge-secondary">Order</label>
                                                    @elseif($val->status == '2')
                                                        <label class="badge badge-success">Received</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ route('purchasing_accepted/pdf_penerimaan', $val->no_faktur) }}" target="_blank"><strong>{{ $val->no_faktur }}</strong></a> --}}
                                                    {{ $val->no_faktur }}
                                                </td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    
                                                        <a href="{{ route('purchasing.view', $val->no_urut_po) }}" class="btn btn-primary btn-sm">View</a>
                                                        <a href="{{ route('purchasing.order_pdf', $val->no_urut_po) }}" target="_blank" class="btn btn-danger btn-sm">PO (PDF)</a>
                                                        <a href="{{ route('purchasing.order_excel', $val->no_urut_po) }}" target="_blank" class="btn btn-success btn-sm">PO (Excel)</a>
                                                        @if($val->status == '1')
                                                            <a href="{{ route('purchasing_accept.accept', $val->no_urut_po) }}" class="btn btn-warning btn-sm">Terima</a>
                                                        @elseif($val->status == '2')
                                                            <button onClick="alert('Pesanan dengan Kode Pembelian : {{$val->kode_pembelian}} sudah diterima.... ')" class="btn btn-warning btn-sm">Terima</button>
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


