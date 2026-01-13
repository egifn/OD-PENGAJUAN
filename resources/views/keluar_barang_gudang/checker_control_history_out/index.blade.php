
@extends('layouts.admin')

@section('title')
    <title>Check Control History</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Gudang Out</li>
        <li class="breadcrumb-item active">Check Control History</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Check Control History
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('gudang_out_check_control_history/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-10 float-right"> 
                                    <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                        <option value="">Perusahaan</option>
                                        @foreach ($perusahaan as $row)
                                            <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                        @endforeach 
                                    </select>
                                    &nbsp
                                    <select name="kode_depo" id="kode_depo" class="form-control" required>
                                        <option value="">Depo</option>
                                    </select>
                                    &nbsp
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="">Kategori</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Secondary">Secondary</option>
                                    </select> 
                                    &nbsp
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
                                                <th>Id Dok</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>   
                                                <th>Perusahaan</th>
                                                <th>Depo</th>
                                                <th>Kategori</th>
                                                <th>Pabrik/Toko</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @forelse ($out_history as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $val->doc_id }}</td>
                                                <td>{{ $val->tanggal }}</td>
                                                <td>{{ $val->waktu }}</td>
                                                <td>{{ $val->nama_perusahaan }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->kategori }}</td>
                                                <td>{{ $val->from }}</td>
                                                <td align="center">
                                                    @if($val->status == '0' and $val->status_bs == '0')
                                                        <label class="badge badge-primary">Masuk</label>
                                                    @elseif($val->status == '1' and $val->status_bs == '0')
                                                        <label class="badge badge-primary">Masuk</label>
                                                    @elseif($val->status == '0' and $val->status_bs == '1')
                                                        <label class="badge badge-primary">Masuk</label>
                                                    @elseif($val->status == '1' and $val->status_bs == '1')
                                                        <label class="badge badge-success">Selesai Muat</label>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <a href="{{ route('gudang_out_check_control_history.view', $val->doc_id) }}" class="btn btn-primary btn-sm">View</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            
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

        $(function(){
            $('#kode_perusahaan').change(function(){
                var perusahaan_id = $(this).val();
                if(perusahaan_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo_history_out?perusahaan_id="+perusahaan_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#kode_depo").empty();
                                $("#kode_depo").append('<option value="">Select</option>');
                                $.each(res,function(nama,kode){
                                    $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#kode_depo").empty();
                            }
                        }
                    });
                }else{
                    $("#kode_depo").empty();
                }
            });
        });
    </script>

@endsection