@section('js')


<script type="text/javascript">

    function goBack() {
        window.history.back();
    }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("check_control.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });


</script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $('#tgl_kode_produksi').datepicker({
            dateFormat: 'ddmmyy',//check change
            changeMonth: true,
            changeYear: true
        });      
    });
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Check Control Sheet</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Get In</li>
        <li class="breadcrumb-item">Check Control Sheet</li>
        <li class="breadcrumb-item active">Check Control</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('check_control.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Check Control Sheet</h4>
                            </div>
                            <div class="card-body">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Id Dok
                                                <input type="text" name="doc_id" id="doc_id" class="form-control" value="{{ $head->doc_id }}" readonly>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                            <div class="col-md-3 mb-2">
                                                Zona Layak
                                                <input type="text" name="zona_primary_layak" id="zona_primary_layak" class="form-control" value="{{ $head->nama_area }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2" hidden>
                                                Kode Layak
                                                <input type="text" name="id_zona_primary_layak" id="id_zona_primary_layak" class="form-control" value="{{ $head->kode_zona }}" readonly>
                                            </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                            <div class="col-md-3 mb-2">
                                                Zona BS
                                                <input type="text" name="zona_primary_layak" id="zona_primary_layak" class="form-control" value="{{ $head->nama_area }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2" hidden>
                                                Kode Zona BS
                                                <input type="text" name="id_zona_primary_bs" id="id_zona_primary_bs" class="form-control" value="{{ $head->kode_zona_bs }}" readonly>
                                            </div>
                                            @endif

                                            <div class="col-md-2 mb-2">
                                                @if(Auth::user()->kode_depo == '034-W01')
                                                    Kode Produksi
                                                    @if(Auth::user()->kategori == 'Layak')
                                                        @if($head->status == '0')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" placeholder="--Pilih Tanggal--" class="form-control" required>
                                                        @elseif($head->status == '1')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" class="form-control" value="{{ $head->kode_produksi }}" readonly>
                                                        @endif
                                                    @elseif(Auth::user()->kategori == 'BS')
                                                        @if($head->status_bs == '0')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" placeholder="--Pilih Tanggal--" class="form-control" required>
                                                        @elseif($head->status_bs == '1')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" class="form-control" value="{{ $head->kode_produksi }}" readonly>
                                                        @endif
                                                    @endif
                                                @elseif(Auth::user()->kode_depo == '034-W02')
                                                    Kode Produksi
                                                    @if(Auth::user()->kategori == 'Layak')
                                                        @if($head->status == '0')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" placeholder="--Pilih Tanggal--" class="form-control" required>
                                                        @elseif($head->status == '1')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" class="form-control" value="{{ $head->kode_produksi }}" readonly>
                                                        @endif
                                                    @elseif(Auth::user()->kategori == 'BS')
                                                        @if($head->status_bs == '0')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" placeholder="--Pilih Tanggal--" class="form-control" required>
                                                        @elseif($head->status_bs == '1')
                                                            <input type="text" name="tgl_kode_produksi" id="tgl_kode_produksi" class="form-control" value="{{ $head->kode_produksi }}" readonly>
                                                        @endif
                                                    @endif
                                                @else
                                                    Kode Produksi
                                                    @if(Auth::user()->kategori == 'Layak')
                                                        @if($head->status == '0')
                                                            <input type="text" name="kode_produksi" id="kode_produksi" class="form-control" value="" required>
                                                        @elseif($head->status == '1')
                                                            <input type="text" name="kode_produksi" id="kode_produksi" class="form-control" value="{{ $head->kode_produksi }}" readonly>
                                                        @endif
                                                    @elseif(Auth::user()->kategori == 'BS')
                                                        @if($head->status_bs == '0')
                                                            <input type="text" name="kode_produksi" id="kode_produksi" class="form-control" value="" required>
                                                        @elseif($head->status_bs == '1')
                                                            <input type="text" name="kode_produksi" id="kode_produksi" class="form-control" value="{{ $head->kode_produksi }}" readonly>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_primary" id="no_mobil_primary" class="form-control" value="{{ $head->no_mobil }}" readonly>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                            <div class="col-md-3 mb-2">
                                                Sub Zona Layak
                                                <input type="text" name="sub_zona_primary_layak" id="sub_zona_primary_layak" class="form-control" value="{{ $head->nama_sub_area }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2" hidden>
                                                Kode Sub Zona Layak
                                                <input type="text" name="id_sub_zona_primary_layak" id="id_sub_zona_primary_layak" class="form-control" value="{{ $head->kode_zona_sub }}" readonly>
                                            </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                            <div class="col-md-3 mb-2">
                                                Sub Zona BS
                                                <input type="text" name="sub_zona_primary_layak" id="sub_zona_primary_layak" class="form-control" value="{{ $head->nama_sub_area }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2" hidden>
                                                Kode Sub Zona BS
                                                <input type="text" name="id_sub_zona_primary_bs" id="id_sub_zona_primary_bs" class="form-control" value="{{ $head->kode_zona_sub_bs }}" readonly>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_primary" id="nama_sopir_primary" class="form-control" value="{{ $head->nama_driver }}" readonly>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <input type="text" name="id_checker_primary" id="id_checker_primary" class="form-control" value="{{ $head->nama_checker }}" readonly>
                                            </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <input type="text" name="id_checker_primary" id="id_checker_primary" class="form-control" value="{{ $head->nama_checker }}" readonly>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                @if($head->kategori == 'Primary')
                                                    Pabrik
                                                    <input type="text" name="toko" id="toko" class="form-control" value="{{ $head->from }}" readonly>
                                                @elseif($head->kategori == 'Secondary')
                                                    Toko/Outlet
                                                    <input type="text" name="toko" id="toko" class="form-control" value="{{ $head->from }}" readonly>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                

                                <div class="row">
                                            <form id="savedatas">
                                                <div class="card-body">
                                                <div class="table-responsive">
                                                    <div style="border:1px white;width:100%;height:130px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                            <thead>
                                                                <tr>
                                                                    @if(Auth::user()->kategori == 'Layak')
                                                                        <th hidden>No</th>
                                                                        <th>Kode Produk</th>
                                                                        <th>Nama Produk</th>
                                                                        <th>Jml All</th>
                                                                        <th>Jml Layak</th>
                                                                        <th>Jml BS</th>
                                                                    @elseif(Auth::user()->kategori == 'BS')
                                                                        @if(Auth::user()->kode_depo == '034-W01')
                                                                            <th hidden>No</th>
                                                                            <th>Kode Produk</th>
                                                                            <th>Nama Produk</th>
                                                                            <th>Jml All</th>
                                                                            <th>Jml Layak</th>
                                                                            <th>Jml BS</th>
                                                                            <th>BS Ekspedisi</th>
                                                                        @elseif(Auth::user()->kode_depo == '034-W02')
                                                                            <th hidden>No</th>
                                                                            <th>Kode Produk</th>
                                                                            <th>Nama Produk</th>
                                                                            <th>Jml All</th>
                                                                            <th>Jml Layak</th>
                                                                            <th>Jml BS</th>
                                                                            <th>BS Ekspedisi</th>
                                                                        @else
                                                                            @if($head->kategori == 'Primary')
                                                                                <th hidden>No</th>
                                                                                <th>Kode Produk</th>
                                                                                <th>Nama Produk</th>
                                                                                <th>Jml All</th>
                                                                                <th>Jml Layak</th>
                                                                                <th>Jml Tolakan</th>
                                                                                <th>BS Ekspedisi</th>
                                                                            @elseif($head->kategori == 'Secondary')
                                                                                <th hidden>No</th>
                                                                                <th>Kode Produk</th>
                                                                                <th>Nama Produk</th>
                                                                                <th>Jml All</th>
                                                                                <th>Jml Layak</th>
                                                                                <th>Jml BS Sales</th>
                                                                                <th hidden>BS Ekspedisi</th>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                    
                                                            @php $no = 1; @endphp
                                                            @forelse ($detail as $val)
                                                                <tr>
                                                                    @if(Auth::user()->kategori == 'Layak')
                                                                    <td hidden>{{ $no++ }}</td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_<?php echo $no++ ?>" style="font-size: 13px;" value="{{ $val->kode_produk }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="width:350px; font-size: 13px;" value="{{ $val->nama_produk }}" readonly>
                                                                    </td>
                                                                    <td align="right">
                                                                        <input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right;" value="{{ $val->qty_all }}" readonly>
                                                                    </td>
                                                                    <td align="right">
                                                                        <input type="number" class="form-control" name="qty_layak[]" id="qty_layak_<?php echo $no++ ?>" style="font-size: 13px; text-align: right;" value="{{ $val->qty_layak }}">
                                                                    </td>
                                                                    <td align="right">
                                                                        <input type="number" class="form-control" name="qty_bs[]" id="qty_bs" style="font-size: 13px; text-align: right;" value="{{ $val->qty_bs }}" readonly>
                                                                    </td>
                                                                    @elseif(Auth::user()->kategori == 'BS')

                                                                        @if($head->kategori == 'Primary')

                                                                            <td hidden>{{ $no++ }}</td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_<?php echo $no++ ?>" style="font-size: 13px;" value="{{ $val->kode_produk }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="width:350px; font-size: 13px;" value="{{ $val->nama_produk }}" readonly>
                                                                            </td>
                                                                            <td align="right">
                                                                                <input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_all) }}" readonly>
                                                                            </td>
                                                                            <td align="right">
                                                                                <input type="number" class="form-control" name="qty_layak[]" id="qty_layak_<?php echo $no++ ?>" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_layak) }}" readonly>
                                                                            </td>
                                                                            <td align="right">
                                                                                <input type="number" class="form-control" name="qty_bs[]" id="qty_bs" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_bs) }}" readonly>
                                                                            </td>
                                                                            <td align="right">
                                                                                <input type="number" class="form-control" name="qty_bs_ekspedisi[]" id="qty_bs_ekspedisi" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_ekspedisi) }}">
                                                                            </td>

                                                                        @elseif($head->kategori == 'Secondary')

                                                                            <td hidden>{{ $no++ }}</td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_<?php echo $no++ ?>" style="font-size: 13px;" value="{{ $val->kode_produk }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="width:350px; font-size: 13px;" value="{{ $val->nama_produk }}" readonly>
                                                                            </td>
                                                                            <td align="right">
                                                                                <input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_all) }}" readonly>
                                                                            </td>
                                                                            <td align="right">
                                                                                <input type="number" class="form-control" name="qty_layak[]" id="qty_layak_<?php echo $no++ ?>" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_layak) }}" readonly>
                                                                            </td>
                                                                            <td align="right">
                                                                                <input type="number" class="form-control" name="qty_bs[]" id="qty_bs" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_bs) }}" >
                                                                            </td>
                                                                            <td align="right" hidden>
                                                                                <input type="number" class="form-control" name="qty_bs_ekspedisi[]" id="qty_bs_ekspedisi" style="font-size: 13px; text-align: right;" value="{{ number_format($val->qty_ekspedisi) }} readonly">
                                                                            </td>

                                                                        @endif


                                                                    
                                                                    @endif
                                                                    
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center">Data not found</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" hidden>Pilih Produk</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')" hidden>Hapus Produk</button>
                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                        @if(Auth::user()->kategori == 'Layak')
                                                            @if($head->status == '0')
                                                                <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                                            @elseif($head->status == '1')
                                                                <button type="button" class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
                                                            @endif
                                                        @elseif(Auth::user()->kategori == 'BS')
                                                            @if($head->status_bs == '0')
                                                                <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                                            @elseif($head->status_bs == '1')
                                                                <button type="button" class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
                                                            @endif
                                                        @endif
                                                        
                                                    </div> 
                                                </div>
                                                </div>
                                            </form>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_product" id="search_product" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Product Id</th>
                                <th>Product Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')



@endsection




