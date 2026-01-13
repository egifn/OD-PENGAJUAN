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
                            <form action="{{ route('daily_activity_ssd/store.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                                <div class="row mb-4">
                                    <input type="text" id="segment" name="segment" class="form-control bg-light" value="{{$data_users->id_segment}}" hidden>
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
                                            <label class="font-weight-bold">Nama Depo Tujuan</label>
                                            <select name="kode_depo" id="kode_depo" class="form-control">
                                                <option value="">Pilih</option>
                                                @foreach ($depos as $row)
                                                    <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected':'' }}>{{ $row->nama_depo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Area</label>
                                            <input type="text" id="area" name="area" class="form-control">
                                        </div>
                                    </div> -->
                                </div>

                                <hr class="my-4">

                              <div class="row mb-4">
                                <div class="col-md-12">
                                    <!-- Sales Strategy Development Header -->
                                    <div class="row mb-2">
                                        <div class="col-md-4 font-weight-bold">Sales Strategy Development (Key Challenge per Channel)</div>
                                    </div>
                                    
                                    @if(Auth::user()->id_segmen == '7' || Auth::user()->id_segmen == '10')
                                    <!-- GT-SO -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-1">GT-SO</div>
                                        <div class="col-md-11">
                                            <textarea name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>

                                    </div>
                                    @elseif(Auth::user()->id_segmen == '9')
                                    <!-- GT-WS -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-2">GT-WS</div>
                                        <div class="col-md-7">
                                            <textarea name="gt_ws1" id="gt_ws1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>

                                    </div>
                                    @elseif(Auth::user()->id_segmen == '6')
                                    <!-- GT-R -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-2">GT-R</div>
                                        <div class="col-md-7">
                                            <textarea name="gt_r1" id="gt_r1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>

                                    </div>
                                    @elseif(Auth::user()->id_segmen == '3')
                                    <!-- NON GT-AHS -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-2">NON GT-AHS</div>
                                        <div class="col-md-7">
                                            <textarea name="gt_ahs1" id="gt_ahs1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>

                                    </div>
                                    @elseif(Auth::user()->id_segmen == '4')
                                    <!-- NON GT-IOD -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-2">NON GT-IOD</div>
                                        <div class="col-md-7">
                                            <textarea name="gt_iod1" id="gt_iod1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>

                                    </div>
                                    @elseif(Auth::user()->id_segmen == '2')
                                    <!-- NON GT-AFH -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-2">NON GT-AFH</div>
                                        <div class="col-md-7">
                                            <textarea name="gt_afh1" id="gt_afh1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>

                                    </div>
                                    @elseif(Auth::user()->id_segmen == '5')
                                    <!-- NON GT-MT -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-2">NON GT-MT</div>
                                        <div class="col-md-7">
                                            <textarea name="gt_mt1" id="gt_mt1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>

                                    </div>
                                    @endif
                                </div>
                            </div>
                                <!-- Save Button (hidden until last section) -->
                                <div class="row mt-4 save-section">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-primary px-4">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>                   
</main>
@endsection