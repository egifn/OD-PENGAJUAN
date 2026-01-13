@extends('layouts.admin')

@section('title')
    <title>Rincian Weekly</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Expenditure</li>
        <li class="breadcrumb-item">Petty Cash</li>
        <li class="breadcrumb-item">Bandung Raya</li>
        <li class="breadcrumb-item active">Rincian Weekly</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Rincian Weekly
                            </h4>
                        </div>

                        

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('petty_cash_ho/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-8 float-right">  
                                    <select name="type" class="form-control">
                                        <option value="">Category</option>
                                        <option value="Rutin">Rutin</option>
                                        <option value="Non Rutin">Non Rutin</option>
                                    </select>
                                    &nbsp
                                    <select name="depo" class="form-control">
                                        <option value="">Depo Name</option>
                                        @foreach ($depo as $row_depo)
                                            <option value="{{ $row_depo->kode_depo }}" {{ old('depo') == $row_depo->kode_depo ? 'selected':'' }}>{{ $row_depo->nama_depo }}</option>
                                        @endforeach 
                                    </select>
                                    &nbsp
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
                                                <th>Doc Id</th>
                                                <th>Date</th>
                                                <th>Category</th>
                                                <th>Type</th>
                                                <th hidden>kode Depo</th>
                                                <th>Depo</th>
                                                <th>Description</th>
                                                <th>Total</th>
                                                <th>User Input</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($view as $val)
                                            <tr>
                                                <td hidden></td>
                                                <td>{{ $val->kode_pengajuan_b }}</td>
                                                <td>{{ $val->tgl_pengajuan_b }}</td>
                                                <td>{{ $val->kategori }}</td>
                                                <td>{{ $val->tipe }}</td>
                                                <td hidden>{{ $val->kode_depo }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->keterangan }}</td>
                                                <td align="center">{{ number_format($val->total) }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    <a href="" class="btn btn-primary btn-sm">View</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Data Not Found</td>
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


