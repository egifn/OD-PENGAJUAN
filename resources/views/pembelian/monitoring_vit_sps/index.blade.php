
@extends('layouts.admin')

@section('title')
    <title>List CO</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">List CO</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                List CO
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

                            <form action="{{ route('list_pembelian_vit/cari.cari') }}" method="get">
                                <div class="input-group mb-3 col-md-4 float-right"> 
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
                                                <th>No. CO</th>
                                                <th>Plant</th>
                                                <th>No Polisi</th>
                                                <th>Sopir</th>   
                                                <th>Tgl Real</th>
                                                <th>No. SJ</th>
                                                <th>SKU</th>
                                                <th>Qty Real</th>
                                                <th>Qty Retur</th>
                                                <th>Qty Btl Kosong</th>
                                                <th>Qty Tlk Retur</th>
                                                <th>Qty Tlk Btl Kosong</th>
                                                <th>No. DN</th>
                                                <th>No. GR</th>
                                                <th>No. TL</th>
                                                <th>Distributor</th>
                                                <th>Tujuan</th>
                                                <th>Remark/SJ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($list as $val)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $val->co }}</td>
                                                <td>{{ $val->plant }}</td>
                                                <td>{{ $val->no_polisi }}</td>
                                                <td>{{ $val->sopir }}</td>
                                                <td>{{ date('d-M-Y', strtotime($val->tgl_real)) }}</td>
                                                <td>{{ $val->sj }}</td>
                                                <td>{{ $val->sku }}</td>
                                                <td align="right">{{ $val->qty_real }}</td>
                                                <td align="right">{{ $val->terima_retur }}</td>
                                                <td align="right">{{ $val->ttl_btl_kosong }}</td>
                                                <td align="right">{{ $val->ttl_tolakan_retur }}</td>
                                                <td align="right">{{ $val->ttl_tolakan_btl_kosong }}</td>
                                                <td>{{ $val->dn }}</td>
                                                <td>{{ $val->gr }}</td>
                                                <td>{{ $val->tl }}</td>
                                                <td>{{ $val->distributor }}</td>
                                                <td>{{ $val->depo_tujuan }}</td>
                                                <td>{{ $val->remark }}</td>
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