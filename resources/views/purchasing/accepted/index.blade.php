@extends('layouts.admin')

@section('title')
    <title>Accepted</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item active">Accepted</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Accepted
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('accepted/cari.cari') }}" method="get">
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
                                                <th hidden>#</th>
                                                <th>BTB</th>
                                                <th>Tgl BTB</th>
                                                <th hidden>kode Vendor</th>
                                                <th>Vendor</th>
                                                <th>PO</th>
                                                <th>No.Receive</th>
                                                <th hidden>No.Invoice</th>
                                                <th>Penerima</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($accepted as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->no_btb }}</td>
                                                <td>{{ $val->tgl_terima }}</td>
                                                <td hidden>{{ $val->kode_vendor }}</td>
                                                <td>{{ $val->nama_vendor }}</td>
                                                <td>{{ $val->kode_pembelian }}</td>
                                                <td><strong>{{ $val->no_faktur }}</strong></td>
                                                <td hidden><strong></strong></td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    
                                                    <a href="{{ route('accepted/view.view_accepted', $val->no_faktur) }} " class="btn btn-primary btn-sm">View</a>
                                                    
                                                    @if($val->status == '0')
                                                        <a href="{{ route('accepted/create.created', $val->no_faktur) }}" class="btn btn-warning btn-sm">Kontra</a>
                                                    @elseif($val->status == '1')
                                                        <button class="btn btn-secondary btn-sm" disabled>Kontra</button>
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