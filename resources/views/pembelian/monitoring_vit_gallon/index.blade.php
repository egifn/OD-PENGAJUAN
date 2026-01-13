
@extends('layouts.admin')

@section('title')
    <title>Monitoring VIT Gallon</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Monitoring</li>
        <li class="breadcrumb-item active">VIT Gallon</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Monitoring VIT Gallon
                                <a href="#" class="btn btn-primary btn-sm float-right" hidden>List CO</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('monitoring_vit_gallon/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-3 float-right"> 
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-primary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <div style="width:200%;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No SJ</th>
                                                <th>No CO</th>
                                                <th>Pabrik</th>
                                                <th>No Polisi</th>
                                                <th>Sopir</th>   
                                                <th>Tgl Pabrik</th>
                                                <th>No DN</th>
                                                <th>No Pengiriman</th>
                                                <th>Q a/b</th>
                                                <th>No Penerimaan</th>
                                                <th>Q Air</th>
                                                <th>Q Btl</th>
                                                <th>No Tolakan</th>
                                                <th>Q Air</th>
                                                <th>Q Btl</th>
                                                <th>Qty Air</th>
                                                <th>Qty Btl</th>
                                                <th>Asal SJ</th>
                                                <th>Tujuan SJ</th>
                                                <th>Firm</th>
                                                <th>BKB</th>
                                                <th>BTB Isi</th>
                                                <th>BTB Tolakan</th>
                                                <th>Expedisi</th>
                                                <th>Periode</th>
                                                <th>Tgl Tagihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($list as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td></td><!--NO SJ-->
                                                <td>{{ $val->co }}</td>
                                                <td>{{ $val->plant }}</td>
                                                <td>{{ $val->no_polisi }}</td>
                                                <td>{{ $val->sopir }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_real)) }}</td>
                                                <td>{{ $val->sj }}</td>
                                                <td></td> <!--NO Pengiriman-->
                                                <td align="right">{{ $val->qty_real }}</td>
                                                <td></td> <!--NO Penerimaan-->
                                                <td align="right">{{ $val->terima_retur }}</td>
                                                <td align="right">{{ $val->ttl_btl_kosong }}</td>
                                                <td></td> <!--NO Tolakan-->
                                                <td align="right">{{ $val->ttl_tolakan_retur }}</td>
                                                <td align="right">{{ $val->ttl_tolakan_btl_kosong }}</td>
                                                <td align="right">{{ $val->qty_real + $val->ttl_tolakan_retur - $val->terima_retur }} </td> <!--Qty Air DMS-->
                                                <td align="right">{{ $val->qty_real + $val->ttl_tolakan_btl_kosong - $val->ttl_btl_kosong }}</td> <!--Qty Botol DMS-->
                                                <td></td> <!--Asal SJ-->
                                                <td></td> <!--Tujuan SJ-->
                                                <td>{{ $val->distributor }}</td>
                                                <td></td> <!--BKB-->
                                                <td></td> <!--BTB Isi-->
                                                <td></td> <!--BKB Tolakan-->
                                                <td>{{ $val->remark }}</td>
                                                <td></td> <!--Periode-->
                                                <td></td> <!--Tgl Tagihan-->
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="19" class="text-center">Tidak ada data</td>
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
    </script>

@endsection