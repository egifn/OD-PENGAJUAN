@extends('layouts.admin')

@section('title')
	<title>Permission B</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
         @if(Auth::user()->kode_divisi == '14') <!-- Jika user login BOD, kode divisi 14 -->
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Approval Izin</li>
            <li class="breadcrumb-item active">Izin B</li>
        @else
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Finance</li>
            <li class="breadcrumb-item">Approval</li>
            <li class="breadcrumb-item active">Approval Permission B</li>
        @endif
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	<div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Approval Permission B
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('approval_b/cari.cari') }}" method="get">   
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <!-- <th hidden>#</th>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Permission</th>
                                            <th>Input By</th>
                                            <th>Status</th>
                                            <th>Action</th> -->

                                            <th>No</th>
                                            <th>Kode Izin</th>
                                            <th>Tgl Izin</th>
                                            <th>No Izin</th>
                                            <th>Judul Izin</th>
                                            <th>Rekening Pembayar</th>
                                            <th>Bank</th>
                                            <th>Atas Nama Rekening</th>
                                            <th hidden>No Urut</th>
                                            <th>Aksi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                       @forelse($data_approval_B as $val)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $val->kode_izin_b }}</td>
                                            <td>{{ date('d-M-Y', strtotime($val->tgl_izin_b)) }}</td>
                                            <td>{{ $val->no_izin_b }}</td>
                                            <td>{{ $val->judul_izin_b }}</td>
                                            <td>{{ $val->rekening_pembayar }}</td>
                                            <td>{{ $val->nama_bank }}</td>
                                            <td>{{ $val->atas_nama_rek }}</td>
                                            <td hidden>{{ $val->no_urut }}</td>
                                            <td align="center">
                                                @if(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                    @if($val->status_mengetahui_1 == '0')
                                                        <label class="badge badge-secondary">New</label>
                                                    @elseif($val->status_mengetahui_1 == '1')
                                                        <label class="badge badge-success">Approved</label>
                                                    @elseif($val->status_mengetahui_1 == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @elseif($val->status_mengetahui_1 == '3')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @elseif($val->status_mengetahui_1 == '4')
                                                        <label class="badge badge-success">Approved</label>
                                                    @endif
                                                @elseif(Auth::user()->kode_divisi == '14') <!-- Jika BOD-->
                                                     @if($val->status_approval == '1')
                                                        <label class="badge badge-secondary">New</label>
                                                    @elseif($val->status_approval == '2')
                                                        <label class="badge badge-danger">Denied</label>
                                                    @elseif($val->status_approval == '3')
                                                        <label class="badge badge-warning">Pending</label>
                                                    @elseif($val->status_approval == '4')
                                                        <label class="badge badge-success">Approved</label>
                                                    @endif
                                                @endif    
                                            </td>
                                            <td align="center">   
                                                <a href="{{ route('approval_b.view', $val->no_urut) }}" class="btn btn-primary btn-sm">View</a> 
                                                <!-- <a href="#" target="_blank" class="btn btn-warning btn-sm">Print</a> -->   
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No data available</td>
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