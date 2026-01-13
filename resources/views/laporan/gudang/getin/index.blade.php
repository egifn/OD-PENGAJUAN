
@extends('layouts.admin')

@section('title')
    <title>Get In</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Laporan</li>
        <li class="breadcrumb-item active">Get In</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Get in
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('l_get_in/cari.cari') }}" method="get">
                                    @if(Auth::user()->kode_divisi == '20')
                                        <div class="input-group mb-3 col-md-3 float-right"> 
                                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                            &nbsp
                                            <button class="btn btn-primary" type="submit">C a r i</button>
                                        </div>
                                    @elseif (Auth::user()->kode_divisi == '22')
                                        <div class="input-group mb-3 col-md-10 float-right"> 
                                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                            &nbsp
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
                                            <button class="btn btn-primary" type="submit">C a r i</button>
                                        </div>
                                    @endif    
                                </form>
                                <form action="{{ route('l_get_in/view.view') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    @if(Auth::user()->kode_divisi == '20')
                                         
                                        <input type="text" id="tanggal_ex" name="tanggal_ex" class="form-control" value="{{ request()->tanggal }}" required hidden>
                                        &nbsp
                                        <button class="btn btn-success" type="submit">E x c e l</button>
                                        
                                    @elseif (Auth::user()->kode_divisi == '22')
                                        
                                        <input type="text" id="tanggal_ex" name="tanggal_ex" class="form-control" value="{{ request()->tanggal }}" required hidden>
                                        &nbsp
                                        <input type="text" id="kode_perusahaan_ex" name="kode_perusahaan_ex" class="form-control" value="{{ request()->kode_perusahaan }}" required hidden>

                                        &nbsp
                                        <input type="text" id="kode_depo_ex" name="kode_depo_ex" class="form-control" value="{{ request()->kode_depo }}" required hidden>

                                        &nbsp
                                        <button class="btn btn-success" type="submit">E x c e l</button>
                                        
                                    @endif    
                                </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Depo</th>
                                                <th>Pabrik/Sumber</th>
                                                <th>No Polisi</th>   
                                                <th>Sopir</th>
                                                <th>SKU</th>
                                                <th>Qty BS</th>
                                                <th>Kode Produksi</th>
												<th>Sub Zona</th>
                                                <th>Nama Leader</th>
                                                <th>Nama Checker</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($data as $val)
                                            <tr>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->from }}</td>
                                                <td>{{ $val->no_mobil }}</td>
                                                <td>{{ $val->nama_driver }}</td>
                                                <td>{{ $val->nama_produk }}</td>
                                                <td>{{ $val->qty_bs }}</td>
                                                <td>{{ $val->kode_produksi }}</td>
												<td>{{ $val->nama_sub_area }}</td>
                                                <td>{{ $val->name }}</td>
                                                <td>{{ $val->nama_checker }}</td>
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
                        url:"/ajax_depo_laporan_getin?perusahaan_id="+perusahaan_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#kode_depo").empty();
                                $("#kode_depo").append('<option value="">Depo</option>');
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