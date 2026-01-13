@extends('layouts.admin')

@section('title')
    <title>Mutasi Rekening</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Rekening</li>
        <li class="breadcrumb-item active">Mutasi Rekening</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Mutasi Rekening
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('mutasirekening_fin.index') }}" method="get">
                                    <div class="input-group mb-3 col-md-8 float-right">
                                        <select name="kode_bank" class="form-control">
                                            <option value="">Bank</option>
                                            @foreach ($bank as $rowbank)
                                                <option value="{{ $rowbank->kode_bank }}" {{ old('norek') == $rowbank->kode_bank ? 'selected':'' }}>{{ $rowbank->nama_bank }}</option>
                                            @endforeach 
                                        </select>
                                        &nbsp
                                        <select name="norek" class="form-control">
                                            <option value="">No. Rekening</option>
                                            @foreach ($rekening as $rowrek)
                                                <option value="{{ $rowrek->norek }}" {{ old('norek') == $rowrek->norek ? 'selected':'' }}>{{ $rowrek->norek }}</option>
                                            @endforeach 
                                        </select>
                                        &nbsp
                                        <input type="text" id="created_at" name="date" class="form-control" value="{{ request()->date }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="submit">Filter</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Tanggal</th>
                                                <th>No Rekening</th>
                                                <th>Bank</th>
                                                <th hidden>No Cheque</th>
                                                <th>Deskripsi</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($mutasi as $val)
                                            <tr>
                                                <td hidden>#</td>
                                                <td>{{ $val->tanggal_rek }}</td>
                                                <td>{{ $val->norek }}</td>
                                                <td>{{ $val->nama_bank }}</td>
                                                <td hidden>{{ $val->kode }}</td>
                                                <td>{{ $val->description }}</td>
                                                <td align="right">{{ number_format($val->nilai) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>    
                                   
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>

    <!--
    <script type="text/javascript">
        $('.date').datepicker({  
            format: 'mm-dd-yyyy'
        });  
    </script>
    -->

</main>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        
        $(document).ready(function() {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            //INISIASI DATERANGEPICKER
            $('#created_at').daterangepicker({
                
            })
        })
    </script>
@endsection()