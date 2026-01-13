
@extends('layouts.admin')

@section('title')
    <title>Checker Layak</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Laporan</li>
        <li class="breadcrumb-item active">Checker Layak</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Checker Layak
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('l_checker_gudang/cari.cari') }}" method="get">
                                @if(Auth::user()->kode_divisi == '20')
                                <div class="input-group mb-3 col-md-10 float-right"> 
                                    <!-- <select name="kategori_checker" id="kategori_checker" class="form-control">
                                        <option value="">Kategori Checker</option>
                                        <option value="Layak">Layak</option>
                                        <option value="BS">BS</option>
                                    </select> 
                                    &nbsp -->
                                    <select name="id_checker" id="id_checker" class="form-control" required>
                                        <option value="">Nama Checker</option>
                                        @foreach ($checker as $row)
                                            <option value="{{ $row->id_checker }}" {{ old('id_checker') == $row->id_checker ? 'selected':'' }}>{{ $row->nama_checker }}</option>
                                        @endforeach 
                                    </select>
                                    &nbsp
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option value="">Kategori Armada</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Secondary">Secondary</option>
                                    </select> 
                                    &nbsp
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>   
                                @elseif (Auth::user()->kode_divisi == '22')
                                <div class="input-group mb-3 col-md-12 float-right"> 
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
                                    <!-- <select name="kategori_checker" id="kategori_checker" class="form-control">
                                        <option value="">Kategori Checker</option>
                                        <option value="Layak">Layak</option>
                                        <option value="BS">BS</option>
                                    </select> 
                                    &nbsp -->
                                    <select name="id_checker" id="id_checker" class="form-control" required>
                                        <option value="">Nama Checker</option>
                                    </select>
                                    &nbsp
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option value="">Kategori</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Secondary">Secondary</option>
                                    </select> 
                                    &nbsp
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>   
                                @endif
                                   
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:100%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th hidden>No</th>
                                                <th hidden>Id Checker</th>
                                                <th>Nama</th>
                                                <th>Tanggal</th>   
                                                <th>Perusahaan</th>
                                                <th>Depo</th>
                                                <th>Kategori</th>
                                                <th>SKU</th>
                                                <th>Qty Layak</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1; @endphp
                                        @forelse ($data as $val)
                                            <tr>
                                                <td hidden>{{ $no++ }}</td>
                                                <td hidden>{{ $val->id_checker }}</td>
                                                <td>{{ $val->nama_checker }}</td>
                                                <td>{{ $val->tanggal }}</td>
                                                <td>{{ $val->nama_perusahaan}}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->kategori }}</td>
                                                <td>{{ $val->nama_produk}}</td>
                                                <td align="right">{{ $val->qty_layak}}</td>
            
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                        <tfoot hidden>
                                            <tr>
                                                <td colspan="7">
                                                    <b style="color: blue">AQ.5GALLON ISI: ,</b> 
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    <b style="color: blue">AQ.5GALLON BTL: ,</b>
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    <b style="color: red">VT.5GALLON ISI: ,</b>
                                                    &nbsp;
                                                    &nbsp;
                                                    &nbsp;
                                                    <b style="color: red">VT.5GALLON BTL: ,</b>
                                                </td>
                                            </tr>
                                        </tfoot>
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
                        url:"/ajax_depo_laporan?perusahaan_id="+perusahaan_id,
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

        $(function(){
            $('#kode_depo').change(function(){
                var depo_id = $(this).val();
                if(depo_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_checker_laporan?depo_id="+depo_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#id_checker").empty();
                                $("#id_checker").append('<option value="">Select</option>');
                                $.each(res,function(nama,kode){
                                    $("#id_checker").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#id_checker").empty();
                            }
                        }
                    });
                }else{
                    $("#id_checker").empty();
                }
            });
        });

        // $(function(){
        //     $('#kategori_checker').change(function(){
        //         var tipe = $(this).val();
        //         if(tipe){
        //             $.ajax({
        //                 type:"GET",
        //                 url:"/ajax_checker_type_laporan?tipe="+tipe,
        //                 dataType:'JSON',
        //                 success: function(res){
        //                     if(res){
        //                         $("#id_checker").empty();
        //                         $("#id_checker").append('<option value="">Select</option>');
        //                         $.each(res,function(nama,kode){
        //                             $("#id_checker").append('<option value="'+kode+'">'+nama+'</option>');
        //                         });
        //                     }else{
        //                         $("#id_checker").empty();
        //                     }
        //                 }
        //             });
        //         }else{
        //             $("#id_checker").empty();
        //         }
        //     });
        // });
    </script>

@endsection