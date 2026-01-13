@section('js')


<script type="text/javascript">
        function goBack() {
            window.history.back();
        }
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Check Control History (View)</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Gudang In</li>
        <li class="breadcrumb-item">Check Control History</li>
        <li class="breadcrumb-item active">Check Control History (View)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Check Control History (View)</h4>
                            </div>
                            <div class="card-body">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Id Dok
                                                <input type="text" name="surat_jalan" id="surat_jalan" class="form-control" value="{{ $head->doc_id }}" readonly>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Zona Layak
                                                <input type="text" name="zona_primary_layak" id="zona_primary_layak" class="form-control" value="{{ $head->nama_area }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Zona BS
                                                <input type="text" name="zona_primary_bs" id="zona_primary_bs" class="form-control" value="{{ $head->nama_area_bs }}" readonly>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_primary" id="no_mobil_primary" class="form-control" value="{{ $head->no_mobil }}" readonly>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Sub Zona Layak
                                                <input type="text" name="sub_zona_primary_layak" id="sub_zona_primary_layak" class="form-control" value="{{ $head->nama_sub_area }}" readonly>

                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Sub Zona BS
                                                <input type="text" name="sub_zona_primary_bs" id="sub_zona_primary_bs" class="form-control" value="{{ $head->nama_sub_area_bs }}" readonly>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_primary" id="nama_sopir_primary" class="form-control" value="{{ $head->nama_driver }}" readonly>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <input type="text" name="id_checker_primary" id="id_checker_primary" class="form-control" value="{{ $head->nama_checker }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <input type="text" name="id_checker_primary_bs" id="id_checker_primary_bs" class="form-control" value="{{ $head->nama_checker_bs }}" readonly>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Pabrik/Toko/Outlet
                                                <input type="text" name="toko" id="toko" class="form-control" value="{{ $head->from }}" readonly>
                                            </div>
                                        </div>


                                        
                                    </div>
                                

                                <div class="row">
                                            
                                                <div class="card-body">
                                                <div class="table-responsive">
                                                    <div style="border:1px white;width:100%;height:130px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                            <thead>
                                                                <tr>
                                                                    @if($head->kategori == 'Primary')
                                                                        <th>No</th>
                                                                        <th>Kode Produk</th>
                                                                        <th>Nama Produk</th>
                                                                        <th>Jml All</th>
                                                                        <th>Jml Layak</th>
                                                                        <th>Jml BS</th>
                                                                        <th>Jml Ekspedisi</th>
                                                                    @elseif($head->kategori == 'Secondary')
                                                                        <th>No</th>
                                                                        <th>Kode Produk</th>
                                                                        <th>Nama Produk</th>
                                                                        <th>Jml All</th>
                                                                        <th>Jml Layak</th>
                                                                        <th>Jml BS Sales</th>
                                                                        <th hidden>Qty Ekspedisi</th>
                                                                    @endif
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $no = 1; @endphp
                                                            @forelse ($detail as $val)
                                                                <tr>
                                                                    @if($head->kategori == 'Primary')
                                                                        <td>{{ $no++ }}</td>
                                                                        <td>{{ $val->kode_produk }}</td>
                                                                        <td>{{ $val->nama_produk }}</td>
                                                                        <td align="right">{{ number_format($val->qty_all) }}</td>
                                                                        <td align="right">{{ number_format($val->qty_layak) }}</td>
                                                                        <td align="right">{{ number_format($val->qty_bs) }}</td>
                                                                        <td align="right">{{ number_format($val->qty_ekspedisi) }}</td>
                                                                    @elseif($head->kategori == 'Secondary')
                                                                        <td>{{ $no++ }}</td>
                                                                        <td>{{ $val->kode_produk }}</td>
                                                                        <td>{{ $val->nama_produk }}</td>
                                                                        <td align="right">{{ number_format($val->qty_all) }}</td>
                                                                        <td align="right">{{ number_format($val->qty_layak) }}</td>
                                                                        <td align="right">{{ number_format($val->qty_bs) }}</td>
                                                                        <td align="right" hidden>{{ number_format($val->qty_ekspedisi) }}</td>
                                                                    @endif
                                                                    
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center">Tidak ada data</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" hidden>Choose Product</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')" hidden>Delete Product</button>
                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
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

@section('script')



@endsection




