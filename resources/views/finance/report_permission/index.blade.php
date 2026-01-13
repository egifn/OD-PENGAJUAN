@extends('layouts.admin')

@section('title')
    <title>Permission</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active">Permission</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Permission Report
                            </h4>
                        </div>

                        

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('report_permission/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-3 float-right">  
                                    <select name="status" class="form-control" hidden>
                                        <option value="">Status</option>
                                        <option value="0">Blank</option>
                                        <option value="1">Used</option>
                                    </select>
                                    &nbsp
                                    
                                    &nbsp
                                    <input type="text" id="date" name="date" class="form-control" value="{{ request()->date }}">
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
                                                <th hidden>receipt_id</th>
                                                <th>Kode Ijin</th>
                                                <th>Keterangan</th>
                                                <th>Total</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th hidden>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($permission as $val)
                                            <tr>
                                                <td hidden>{{ $val->receipt_id }}</td>
                                                <td>{{ $val->keterangan_id }}</td>
                                                <td>{{ $val->keterangan}}</td>
                                                <td align="right">{{ number_format($val->total) }}</td>
                                                <td>{{ $val->date_receipt}}</td>
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
                                                <td hidden><a href="{{ route('tanda_terima.view', $val->receipt_id) }}" class="btn btn-primary btn-sm">View</a> </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data tersedia</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- PAGINATION  -->
                            Sum of cek/giro: <B> {{ $permission_sum }} </B>
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
            let start_dms = moment().startOf('month')
            let end_dms = moment().endOf('month')

            //INISIASI DATERANGEPICKER
            $('#date').daterangepicker({
               
            })


            let start_bank = moment().startOf('month')
            let end_bank = moment().endOf('month')

            
        })
    </script>

@endsection


