@extends('layouts.admin')

@section('title')
    <title>Data Rekap ATK</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Data Rekap ATK</li>
        <li class="breadcrumb-item active">Ubah Data Rekap ATK</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn" id="page_form">
            <div class="row">
                
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                   Ubah Data Rekap ATK
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
    
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif  
                                <h5>Kode    : {{ $header->kode_rekap }}</h5>
                                <h5>Periode : {{ $header->periode }}</h5>
                                <h5>Tanggal : {{ $header->tgl_rekap }}</h5>
                                <input class="form-control" type="text" name="no_urut" id="no_urut" value="{{ $header->no_urut }}" hidden/>
                                <input class="form-control" type="text" name="kode_rekap" id="kode_rekap" value="{{ $header->kode_rekap }}" hidden/>
                               
                                <hr>
                                <div class="col-md-12 mb-2" style="text-align: right;">
                                    <h3 class="f_budget" id="f_budget">Total: Rp. {{  number_format($total_rekap->total_all) }}</h3>
                                </div>

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
                                                    <th>Pilih &nbsp; <input type="checkbox" id="select-all" class="float-right" checked disabled hidden></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata">
                                                <?php $no=1 ?>
                                                @forelse ($rekap_pengajuan_v as $row)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td class="kode_product">
                                                        <input class="form-control" type="text" name="kode_product[]{{ $no }}" id="kode_product[]{{ $no }}" value="{{ $row->kode_product }}" hidden/>
                                                        {{ $row->kode_product }}
                                                    </td>
                                                    <td class="nama_barang">
                                                        <input class="form-control" type="text" name="nama_barang[]{{ $no }}" id="nama_barang[]{{ $no }}" value="{{ $row->nama_barang }}" hidden/>
                                                        {{ $row->nama_barang }}
                                                    </td>
                                                    <td class="merk">
                                                        <input class="form-control" type="text" name="merk[]{{ $no }}" id="merk[]{{ $no }}" value="{{ $row->merk }}" hidden/>
                                                        {{ $row->merk }}
                                                    </td>
                                                    <td class="ket">
                                                        <input class="form-control" type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" value="{{ $row->ket }}" hidden/>
                                                        {{ $row->ket }}
                                                    </td>
                                                    <td align="right" class="qty_awal">
                                                        <input class="form-control" type="text" name="qty_awal[]{{ $no }}" id="qty_awal[]{{ $no }}" value="{{ $row->qty_awal }}" hidden/>
                                                        {{ $row->qty_awal }}
                                                    </td>
                                                    <td align="right" class="qty_jadi">
                                                        <input class="form-control" type="text" name="qty_jadi[]{{ $no }}" id="qty_jadi[]{{ $no }}" style="width: 50px;" onkeyup="jumlah( {{ $no }} );" value="{{ $row->qty_jadi }} "/>
                                                        {{-- {{ $row->qty_jadi }} --}}
                                                        <td class="qty_jadi_temp" id="qty_jadi_temp{{ $no }}" contenteditable="true" hidden>{{ $row->qty_jadi }}
                                                    </td>
                                                    <td class="satuan">
                                                        <input class="form-control" type="text" name="satuan[]{{ $no }}" id="satuan[]{{ $no }}" value="{{ $row->satuan }}" hidden/>
                                                        {{ $row->satuan }}
                                                    </td>
                                                    <td align="right" class="harga">
                                                        <input class="form-control" type="text" name="harga[]{{ $no }}" id="harga[]{{ $no }}" value="{{ $row->harga }}" hidden/>
                                                        {{ number_format($row->harga) }}
                                                    </td>
                                                    <td align="right" class="total_harga{{ $no }}">
                                                        <input class="form-control" type="text" name="total_harga[]{{ $no }}" id="total_harga[]{{ $no }}" value="{{ $row->total_harga }}" hidden/>
                                                        {{ number_format($row->total_harga) }}
                                                    </td>
                                                    <td align="center">
                                                        @if($row->status == '0') <!-- Baru -->
                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_cek( {{ $no }} );" onclick="input_cek( {{ $no }} );" value="0"/>
                                                        @elseif($row->status == '1') <!-- Approved -->
                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_cek( {{ $no }} );" onclick="input_cek( {{ $no }} );" value="1" checked/>
                                                        @elseif($row->status == '2') <!-- denied -->
                                                            {{-- <input type="checkbox" name="chk" id="chk" value="1" disabled/> --}}
                                                        @elseif($row->status == '3') <!-- pending -->
                                                            {{-- <input type="checkbox" name="chk" id="chk" value="1" disabled/> --}}
                                                        @endif
                                                    </td>
                                                    @if($row->status == '0') <!-- Baru -->
                                                        <td class="ceklist_temp" id="ceklist_temp{{ $no }}" hidden>0</td>
                                                    @elseif($row->status == '1') <!-- Approved -->
                                                        <td class="ceklist_temp" id="ceklist_temp{{ $no }}" hidden>1</td>
                                                    @endif
                                                    
                                                </tr>
                                                @empty
                                                <tr>
                                                    
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12" align="right">
                                    <button class="btn btn-primary btn-sm" onclick="goBack()">Kembali</button>
                                    <button type="submit" class="btn btn-success btn-sm" id="btn_update">Update</button>
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

        var x = 1;

        function input_cek(x) {
            if ($("input[name='chk[]" +x+ "']:checked").val()){
                var ceklist = '1';
            }else{
                var ceklist = '0';
            }

            $('#ceklist_temp' +x+ '').text(ceklist);
        }

        function jumlah(x) {
            //alert('Test');
            var temp_price = parseInt($("input[name='harga[]" + x + "']").val());
            var temp_qty_jadi = parseInt($("input[name='qty_jadi[]" + x + "']").val());
            $('#qty_jadi_temp' + x + '').text(temp_qty_jadi);
            
            var temp_total = temp_price*temp_qty_jadi;
            //membuat format rupiah//
            var reverse = temp_total.toString().split('').reverse().join(''),
                ribuan  = reverse.match(/\d{1,3}/g);
                hasil_total_price = ribuan.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            $('.total_harga' + x + '').text(hasil_total_price);
            $('#total_harga' + x + '').text(hasil_total_price);
            // $("input[name='ttl_price[]" +x+ "']").val(temp_total);
            // $('#ttl_price_temp' + x + '').text(temp_total);
        } 


        $("#btn_update").click(function() {
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
            let ceklist = []

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
            $('.qty_jadi_temp').each(function() {
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
            $('.ceklist_temp').each(function() {
                ceklist.push($(this).text())
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
                    ceklist: ceklist,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('rekap_data_atk.index')}}";
                    }else{

                    }
                }
            });
        });

    </script>

@endsection