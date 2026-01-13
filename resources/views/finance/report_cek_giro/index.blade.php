@extends('layouts.admin')

@section('title')
    <title>Cek/Giro Report</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active">Cek/Giro</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Cek/Giro Report
                            </h4>
                        </div>

                        

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('report_cekgiro/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-6 float-right">  
                                    <select name="status" class="form-control">
                                        <option value="">Status Cek/giro</option>
                                        <option value="0">Blank</option>
                                        <option value="1">Used</option>
                                    </select>
                                    &nbsp
                                    
                                    &nbsp
                                    <input type="text" id="date" name="date" class="form-control" value="{{ request()->date }}">
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
                                                <th hidden>Kode Daftar</th>
                                                <th>Cek/Giro Id</th>
                                                <th>Cek/Giro Number</th>
                                                <th>Created At</th>
                                                <th>Status</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($cekgiro as $val)
                                            <tr>
                                                <td hidden>{{ $val->kode_daftar }}</td>
                                                <td>{{ $val->id_cek }}</td>
                                                <td>{{ $val->no_cek}}</td>
                                                <td>{{ $val->created_at}}</td>
                                                
                                                    @if($val->status_detail == '0')
                                                    <td align="center">
                                                        <label class="badge badge-success">Blank</label>
                                                    </td>
                                                    @elseif($val->status_detail == '1')
                                                    <td align="center">
                                                        <label class="badge badge-danger">Used</label>
                                                    </td>
                                                    @endif
                                                
                                                
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No data available</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- PAGINATION  -->
                            Sum of cek/giro: <B> {{$cekgiro_sum}} </B>
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


