@extends('layouts.admin')

@section('title')
    <title>Data Rekap ATK</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Data Rekap ATK</li>
        <li class="breadcrumb-item active">Rekap ATK</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn" id="page_form">
            <div class="row">
                
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                   Data Rekap ATK
                                </h4>
                            </div>
                            <div class="card-body">
								<form action="{{ route('rekap_data_atk/rekap.rekap') }}" target="_blank" method="post" enctype="multipart/form-data">
                                @csrf
									<h5>Kode    : {{ $header->kode_rekap }}</h5>
									<h5>Periode : {{ $header->periode }}</h5>
									<h5>Tanggal : {{ $header->tgl_rekap }}</h5>
									<input class="form-control" type="text" name="no_urut" id="no_urut" value="{{ $header->no_urut }}" hidden/>
									<input class="form-control" type="text" name="kode_rekap" id="kode_rekap" value="{{ $header->kode_rekap }}" hidden/>
								   
									<hr>

                                    <div class="col-md-12" >
                                        <button type="submit" class="btn btn-success btn-sm" name="btn_excel" id="btn_excel" value="excel">Excel</button>
                                        <button type="submit" class="btn btn-danger btn-sm" name="btn_pdf" id="btn_pdf" value="pdf">P D F</button>
                                    
                                        
                                    </div>
                                </form>

                                <br>

                                <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <div style="width:100%;">
                                        <table id="datatabel_rekap" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Merk</th>
                                                    <th>Keterangan</th>
                                                    <th>Qty Masuk</th>
                                                    <th>Qty Jadi</th>
                                                    {{-- <th hidden>Qty Jadi temp</th> --}}
                                                    <th>Satuan</th>
                                                    <th>Harga</th>
                                                    <th>total</th>
                                                    <th hidden>ttl_price</th>
                                                    <th>Pilih &nbsp; <input type="checkbox" id="select-all" class="float-right" checked disabled></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata">
                                                <?php $no=1 ?>
                                                @forelse ($rekap_pengajuan_v as $row)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td class="kode_product">
                                                        <input class="form-control" type="text" name="kode_product[]" id="kode_product{{ $no }}" value="{{ $row->kode_product }}" hidden/>
                                                        {{ $row->kode_product }}
                                                    </td>
                                                    <td class="nama_barang">
                                                        <input class="form-control" type="text" name="nama_barang[]" id="nama_barang{{ $no }}" value="{{ $row->nama_barang }}" hidden/>
                                                        {{ $row->nama_barang }}
                                                    </td>
                                                    <td class="merk">
                                                        <input class="form-control" type="text" name="merk[]" id="merk{{ $no }}" value="{{ $row->merk }}" hidden/>
                                                        {{ $row->merk }}
                                                    </td>
                                                    <td class="ket">
                                                        <input class="form-control" type="text" name="ket[]" id="ket{{ $no }}" value="{{ $row->ket }}" hidden/>
                                                        {{ $row->ket }}
                                                    </td>
                                                    <td align="right" class="qty_awal">
                                                        <input class="form-control" type="text" name="qty_awal[]" id="qty_awal{{ $no }}" value="{{ $row->qty_awal }}" hidden/>
                                                        {{ $row->qty_awal }}
                                                    </td>
                                                    <td align="right" class="qty_jadi">
                                                        <input class="form-control" type="text" name="qty_jadi[]" id="qty_jadi{{ $no }}" value="{{ $row->qty_jadi }}" hidden/>
                                                        {{ $row->qty_jadi }}
                                                    </td>
                                                    <td class="satuan">
                                                        <input class="form-control" type="text" name="satuan[]" id="satuan{{ $no }}" value="{{ $row->satuan }}" hidden/>
                                                        {{ $row->satuan }}
                                                    </td>
                                                    <td align="right" class="harga">
                                                        <input class="form-control" type="text" name="harga[]" id="harga{{ $no }}" value="{{ $row->harga }}" hidden/>
                                                        {{ number_format($row->harga) }}
                                                    </td>
                                                    <td align="right" class="total_harga">
                                                        <input class="form-control" type="text" name="total_harga[]" id="total_harga{{ $no }}" value="{{ $row->total_harga }}" hidden/>
                                                        {{ number_format($row->total_harga) }}
                                                    </td>
                                                    <td align="center">
                                                        @if($row->status == '0') <!-- Baru -->
                                                            <input type="checkbox" name="chk" id="chk" value="1" checked disabled/>
                                                        @elseif($row->status == '1') <!-- Approved -->
                                                            {{-- <input type="checkbox" name="chk" id="chk" value="1" checked disabled/>  --}}
                                                        @elseif($row->status == '2') <!-- denied -->
                                                            {{-- <input type="checkbox" name="chk" id="chk" value="1" disabled/> --}}
                                                        @elseif($row->status == '3') <!-- pending -->
                                                            {{-- <input type="checkbox" name="chk" id="chk" value="1" disabled/> --}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9" align="center"><b>T o t a l</b></td>
                                                    <td align="right"><b>Rp. {{  number_format($total_rekap->total_all) }}</b></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                               
                                
                                <div class="col-md-12" align="right">
                                    <button class="btn btn-primary btn-sm" onclick="goBack()">Kembali</button>
                                </div>
                                
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

    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        $("#btn_approved").click(function() {
            let no_urut = $("#no_urut").val();
            let kode_rekap = $("#kode_rekap").val();
            
            let kode_product = []
            let nama_barang = []
            let merk = []
            let ket = []
            let qty_awal = []
            let qty_jadi = []
            let satuan = []
            let harga = []
            let total_harga = [] 

            $('.kode_product').each(function() {
                kode_product.push($(this).text())
            })
            $('.nama_barang').each(function() {
                nama_barang.push($(this).text())
            })
            $('.merk').each(function() {
                merk.push($(this).text())
            })
            $('.ket').each(function() {
                ket.push($(this).text())
            })
            $('.qty_awal').each(function() {
                qty_awal.push($(this).text())
            })
            $('.qty_jadi').each(function() {
                qty_jadi.push($(this).text())
            })
            $('.satuan').each(function() {
                satuan.push($(this).text())
            })
            $('.harga').each(function() {
                harga.push($(this).text())
            })
            $('.total_harga').each(function() {
                total_harga.push($(this).text())
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('rekap_atk_app/view/approved.approved') }}",
                data: {
                    no_urut: no_urut,
                    kode_rekap: kode_rekap,

                    kode_product: kode_product,
                    nama_barang: nama_barang,
                    merk: merk,
                    ket: ket,
                    qty_awal: qty_awal,
                    qty_jadi: qty_jadi,
                    satuan: satuan,
                    harga: harga,
                    total_harga: total_harga,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('rekap_atk_app.index')}}";
                    }else{

                    }
                }
            });
        });

        $("#btn_pending").click(function() {
            let no_urut = $("#no_urut").val();
            let kode_rekap = $("#kode_rekap").val();
            
            let kode_product = []
            let nama_barang = []
            let merk = []
            let ket = []
            let qty_awal = []
            let qty_jadi = []
            let satuan = []
            let harga = []
            let total_harga = [] 

            $('.kode_product').each(function() {
                kode_product.push($(this).text())
            })
            $('.nama_barang').each(function() {
                nama_barang.push($(this).text())
            })
            $('.merk').each(function() {
                merk.push($(this).text())
            })
            $('.ket').each(function() {
                ket.push($(this).text())
            })
            $('.qty_awal').each(function() {
                qty_awal.push($(this).text())
            })
            $('.qty_jadi').each(function() {
                qty_jadi.push($(this).text())
            })
            $('.satuan').each(function() {
                satuan.push($(this).text())
            })
            $('.harga').each(function() {
                harga.push($(this).text())
            })
            $('.total_harga').each(function() {
                total_harga.push($(this).text())
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('rekap_atk_app/view/pending.pending') }}",
                data: {
                    no_urut: no_urut,
                    kode_rekap: kode_rekap,

                    kode_product: kode_product,
                    nama_barang: nama_barang,
                    merk: merk,
                    ket: ket,
                    qty_awal: qty_awal,
                    qty_jadi: qty_jadi,
                    satuan: satuan,
                    harga: harga,
                    total_harga: total_harga,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('rekap_atk_app.index')}}";
                    }else{

                    }
                }
            });
        });
    </script>

@endsection