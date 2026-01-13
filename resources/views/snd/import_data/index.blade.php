@extends('layouts.admin')

@section('title')
    <title>Import Data</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Import Data</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Data Import
                                <a href="#" class="btn btn-primary btn-sm float-right"><b>I m p o r t</b></a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="get">
                                <div class="input-group mb-3 col-md-3 float-right"> 
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>    
                            </form>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th hidden>Id</th>
                                                <th>Area</th>
                                                <th>Nama Toko</th>
                                                <th>Cluster</th>
                                                <th>No Rekening</th>
                                                <th>Bank</th>   
                                                <th>Pemilik Rekening</th>
                                                <th >qty</th>
                                                <th >Reward</th>
                                                <th >Total Reward</th>
                                                <th >Potongan</th>
                                                <th hidden>id User input</th>
                                                <th>Import Oleh</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                <!-- <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="">File (.xls, .xlsx)</label>
                                        <input type="file" name="file" class="form-control" value="{{ old('file') }}" required>
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-7 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm">I m p o r t</button>
                                    </div>
                                </div> -->            
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