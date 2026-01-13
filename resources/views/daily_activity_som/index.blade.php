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
    
@stop

@extends('layouts.admin')
@section('style')
    <style>
         .check-box {
            display: flex;
            left: 10px;
            align-items: center;
            justify-content: center;
        }
        .slider-section {
            display: none;
            animation: fadeIn 0.5s;
        }
        .slider-section.active {
            display: block;
        }
        .slider-nav {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        /* Add button styling to prevent default form submission */
        .slider-nav button {
            cursor: pointer;
        }
    </style>
@stop

@section('title')
    <title>Daily Activity</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Daily Activity</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Daily Activity Report</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('daily_activity_som/store.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama</label>
                                            <input type="text" id="nama" name="nama" class="form-control bg-light" value="{{Auth::user()->name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jabatan</label>
                                            <input type="text" id="jabatan" name="jabatan" class="form-control bg-light" value="{{ $data_users->nama_divisi_sub }}" readonly>
                                        </div>
                                    </div>
                              
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal</label>
                                            <input type="date" id="tgl" name="tgl" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Area Tujuan</label>
                                            <select name="kode_area" id="kode_area" class="form-control">
                                                <option value="">Pilih</option>
                                                @foreach ($area as $row)
                                                    <option value="{{ $row->id }}" {{ old('kode_area') == $row->id ? 'selected':'' }}>{{ $row->area_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3 font-weight-bold">Sales Operation</div>
                                            <div class="col-md-9 font-weight-bold mb-2">
                                                <textarea name="key_challenge" id="key_challenge" rows="1" class="form-control form-control-sm" style="height: 110px"></textarea>
                                            </div>
                                        </div>
                                        <div class="row save-section">
                                            <div class="col-md-12 text-right">
                                                <button class="btn btn-primary px-4">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                   
</main>
@endsection