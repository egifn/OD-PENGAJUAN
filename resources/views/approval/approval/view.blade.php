@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
		
		$(document).ready(function(){
            var table = document.getElementById("tabelinput"), sumHsl = 0;
            var id_login = $("#id_login").val(); 
            
            if(id_login == '11'){
                for(var t = 1; t < table.rows.length; t++)
                {   
                    var sub_total = table.rows[t].cells[10].children[0].value;
                        
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    
                    //membuat format rupiah total//
                    var total_all = sumHsl.toString().split('').reverse().join(''),
                    ribuan_total_all  = total_all.match(/\d{1,3}/g);
                    hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                    //End membuat format rupiah total//
                    $('#total_all').val(hasil_total_all);
                }
            }else{
                for(var t = 1; t < table.rows.length; t++)
                {   
                    var sub_total = table.rows[t].cells[10].children[0].value;
                    
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    
                    //membuat format rupiah total//
                    var total_all = sumHsl.toString().split('').reverse().join(''),
                    ribuan_total_all  = total_all.match(/\d{1,3}/g);
                    hasil_total_all = ribuan_total_all.join(',').split('').reverse().join('');
                    //End membuat format rupiah total//
                    $('#total_all').val(hasil_total_all);
                }
            }
        });

        var x = 1;
        function input_ket(x) {
            if(x==1){
                var keterangan_detail = $("input[name='ket[]1']").val();
                        
                if ($("input[name='chk[]1']:checked").val()){
                    var ceklist = '1';
                }else{
                    var ceklist = '0';
                }
                
                $('#ceklist_temp1').text(ceklist);
                $('#keterangan_temp1').text(keterangan_detail);
            }else{
                var keterangan_detail = $("input[name='ket[]" +x+ "']").val();
                        
                if ($("input[name='chk[]" +x+ "']:checked").val()){
                    var ceklist = '1';
                }else{
                    var ceklist = '0';
                }

                $('#ceklist_temp' +x+ '').text(ceklist);
                $('#keterangan_temp' +x+ '').text(keterangan_detail);
            }    
        }

        $("#button_form_approved").click(function() {
            let kode_pengajuan = $("#kode").val();
            let no_urut = $("#no_urut").val();
            let jenis = $("#jenis").val();
			let kode_divisi_temp = $("#kode_divisi_temp").val();
            let status_atasan = $("#status_atasan").val();
            
            let type = []
            let products = []
            let ceklist = []
            let keterangan_detail = []

            $('.type').each(function() {
                type.push($(this).text())
            })
            $('.kode_produk').each(function() {
                products.push($(this).text())
            })
            $('.ceklist_temp').each(function() {
                ceklist.push($(this).text())
            })
            $('.keterangan_temp').each(function() {
                keterangan_detail.push($(this).text())
            })
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('approval/approved.approved') }}",
                data: {
                    kode_pengajuan: kode_pengajuan,
                    no_urut: no_urut,
                    jenis: jenis,
					kode_divisi_temp: kode_divisi_temp,
                    status_atasan: status_atasan,

                    type: type,
                    products: products,
                    ceklist: ceklist,
                    keterangan_detail:keterangan_detail,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('pengajuan.index')}}";
                    }else{

                    }
                }
            });
        });

        $("#button_form_denied").click(function() {
            let kode_pengajuan = $("#kode").val();
            let no_urut = $("#no_urut").val();
            let jenis = $("#jenis").val();
			let kode_divisi_temp = $("#kode_divisi_temp").val();
            let status_atasan = $("#status_atasan").val();
            
            let type = []
            let products = []
            let ceklist = []
            let keterangan_detail = []

            $('.type').each(function() {
                type.push($(this).text())
            })
            $('.kode_produk').each(function() {
                products.push($(this).text())
            })
            $('.ceklist_temp').each(function() {
                ceklist.push($(this).text())
            })
            $('.keterangan_temp').each(function() {
                keterangan_detail.push($(this).text())
            })
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('approval/denied.denied') }}",
                data: {
                    kode_pengajuan: kode_pengajuan,
                    no_urut: no_urut,
                    jenis: jenis,
					kode_divisi_temp: kode_divisi_temp,
                    status_atasan: status_atasan,

                    type: type,
                    products: products,
                    ceklist: ceklist,
                    keterangan_detail:keterangan_detail,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('pengajuan.index')}}";
                    }else{
                        window.location.href = "{{ route('pengajuan.index')}}";
                    }
                }
            });
        });

        $("#button_form_pending").click(function() {
            let kode_pengajuan = $("#kode").val();
            let no_urut = $("#no_urut").val();
            let jenis = $("#jenis").val();
			let kode_divisi_temp = $("#kode_divisi_temp").val();
            let status_atasan = $("#status_atasan").val();
            
            let type = []
            let products = []
            let ceklist = []
            let keterangan_detail = []
            
            $('.type').each(function() {
                type.push($(this).text())
            })
            $('.kode_produk').each(function() {
                products.push($(this).text())
            })
            $('.ceklist_temp').each(function() {
                ceklist.push($(this).text())
            })
            $('.keterangan_temp').each(function() {
                keterangan_detail.push($(this).text())
            })
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('approval/pending.pending') }}",
                data: {
                    kode_pengajuan: kode_pengajuan,
                    no_urut: no_urut,
                    jenis: jenis,
					kode_divisi_temp: kode_divisi_temp,
                    status_atasan: status_atasan,

                    type: type,
                    products: products,
                    ceklist: ceklist,
                    keterangan_detail:keterangan_detail,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('pengajuan.index')}}";
                    }else{

                    }
                }
            });
        });
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Approval Detail</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item active">Approval Detail</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Approval</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Request Id
                                        <input type="text" name="kode" id="kode" class="form-control" value="{{ $pengajuan_v->kode_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Request By
                                        <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" value="{{ $pengajuan_v->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Perusahaan
                                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" value="{{ $pengajuan_v->nama_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2"> 
                                        Depo
                                        <input type="text" name="nama_depo" id="nama_depo" class="form-control" value="{{ $pengajuan_v->nama_depo }}" readonly>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden> 
                                        Kode Divisi
                                        <input type="text" name="kode_divisi_temp" id="kode_divisi_temp" class="form-control" value="{{ $pengajuan_v->kode_divisi }}" readonly>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Request
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ $pengajuan_v->tgl_pengajuan }}" readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="ket" id="ket" class="form-control" value="{{ $pengajuan_v->nama_pengeluaran }}" readonly>
                                        <input type="hidden" name="jenis" id="jenis" class="form-control" value="{{ $pengajuan_v->kode_jenis }}" readonly>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2">
                                        Tipe
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $pengajuan_v->sifat }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden> 
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $pengajuan_v->no_urut }}" required readonly>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden> 
                                        status atasan
                                        <input type="text" name="status_atasan" id="status_atasan" class="form-control" value="{{ $pengajuan_v->status_atasan }}" required readonly>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden> 
                                        id login
                                        <input type="text" name="id_login" id="id_login" class="form-control" value="{{ Auth::user()->kode_divisi }}" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>Tipe Id</th>
                                                    <th>Kategori</th>
                                                    <th>Id Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Desc/Spek</th>
                                                    <th hidden>Qty Pengaju</th>
                                                    <th>Qty</th>
                                                    <th>Satuan</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                    <th>Divisi</th>
                                                    <th hidden>File/attch</th>
                                                    <th>Persetujuan</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1 ?>
                                                @forelse($details as $val)
                                                    @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
														@if($pengajuan_v->kode_divisi == '3')
															@if($pengajuan_v->kode_divisi == '3')
																<tr>
															@else
																<tr style="background-color: #FF4A4A;">
															@endif
														@else
															@if($val->status_cek_it == '0')
																<tr style="background-color: #FF4A4A;">
															@elseif($val->status_cek_it == '1')
																<tr>
															@endif
														@endif
                                                        
                                                    @elseif(Auth::user()->kode_divisi == '2') <!-- Jika OPS-->
                                                        @if(Auth::user()->kode_perusahaan == 'DTS')
                                                            <tr>
                                                        @elseif(Auth::user()->kode_perusahaan == 'DTS_A')
                                                            <tr>
                                                        @elseif(Auth::user()->kode_perusahaan == 'DTS_C')
                                                            <tr>
                                                        @else
                                                            @if($pengajuan_v->kode_divisi == '2')
                                                                @if($pengajuan_v->kode_divisi == '2')
                                                                    <tr>
                                                                @else
                                                                    <tr style="background-color: #FF4A4A;">
                                                                @endif
                                                            @else
                                                                @if($val->status_cek_ops == '0')
                                                                    <tr style="background-color: #FF4A4A;">
                                                                @elseif($val->status_cek_it == '1')
                                                                    <tr>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                        @if($val->status_cek_ga == '0')
                                                            <tr style="background-color: #FF4A4A;">
                                                        @elseif($val->status_cek_it == '1')
                                                            <tr>
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '11') <!-- Jika PC-->
                                                        @if($pengajuan_v->status_atasan == '1')
                                                            @if($val->status_cek_pc == '0')
                                                                <tr style="background-color: #FF4A4A;">
                                                            @elseif($val->status_cek_pc == '1')
                                                                <tr>
                                                            @endif
                                                        @else
                                                            <tr>
                                                        @endif
                                                        
                                                    @else

                                                    @endif
                                                
                                                    <td>{{ $i }}</td>
                                                    <td class="typeid" hidden>
                                                        <input class="form-control" type="text" name="typeid[]" id="typeid" value="{{ $val->kode_pengajuan }}" hidden/>{{ $val->kode_pengajuan }}
                                                    </td>
                                                    <td class="type">
                                                        <input class="form-control" type="text" name="type[]" id="type" value="{{ $val->name }}" hidden/>{{ $val->name }}
                                                    </td>
                                                    <td class="kode_produk">
                                                        <input class="form-control" type="text" name="kode_produk[]" id="kode_produk" value="{{ $val->kode_product }}" hidden/>{{ $val->kode_product }}
                                                    </td>
                                                    @if(Auth::user()->kode_divisi == '27')
                                                        @if($pengajuan_v->kode_jenis == '26')
                                                            <td>
                                                                <input class="form-control" type="text" name="nama_produk[]" id="nama_produk" value="{{ $val->nama_produk  }}" hidden/>{{ $val->nama_produk }}
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="merk[]" id="merk" value="-" hidden/>-
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="ket[]" id="ket" value="-" hidden/>-
                                                            </td>
                                                        @else
                                                            <td>
                                                                <input class="form-control" type="text" name="nama_produk[]" id="nama_produk" value="{{ $val->nama_barang  }}" hidden/>{{ $val->nama_barang }}
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="merk[]" id="merk" value="{{ $val->merk }}" hidden/>{{ $val->merk }}
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="ket[]" id="ket" value="{{ $val->ket }}" hidden/>{{ $val->ket }}
                                                            </td>
                                                        @endif
                                                    @else
                                                        {{-- <td>
                                                            <input class="form-control" type="text" name="nama_produk[]" id="nama_produk" value="{{ $val->nama_barang  }}" hidden/>{{ $val->nama_barang }}
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" name="merk[]" id="merk" value="{{ $val->merk }}" hidden/>{{ $val->merk }}
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" name="ket[]" id="ket" value="{{ $val->ket }}" hidden/>{{ $val->ket }}
                                                        </td> --}}
                                                        @if($pengajuan_v->kode_jenis == '26')
                                                            <td>
                                                                <input class="form-control" type="text" name="nama_produk[]" id="nama_produk" value="{{ $val->nama_produk  }}" hidden/>{{ $val->nama_produk }}
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="merk[]" id="merk" value="-" hidden/>-
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="ket[]" id="ket" value="-" hidden/>-
                                                            </td>
                                                        @else
                                                            <td>
                                                                <input class="form-control" type="text" name="nama_produk[]" id="nama_produk" value="{{ $val->nama_barang  }}" hidden/>{{ $val->nama_barang }}
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="merk[]" id="merk" value="{{ $val->merk }}" hidden/>{{ $val->merk }}
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="ket[]" id="ket" value="{{ $val->ket }}" hidden/>{{ $val->ket }}
                                                            </td>
                                                        @endif
                                                    @endif
                                                    
                                                    @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                        <td class="qty" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty_it }}" hidden/>{{ $val->qty_it }}
                                                        </td>
                                                        <td class="qty_acc" align="right" hidden>
                                                            <input type="text" name="qty_acc[]{{ $i }}" id="qty_acc[]{{ $i }}" class="form-control" style="height: 20px; width: 70px; text-align: right;" value="0">
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '2') <!-- Jika ops-->
                                                        @if($pengajuan_v->kode_divisi == '2')
                                                            <td class="qty" align="right">
                                                                <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty}}" hidden/>{{ $val->qty }}
                                                            </td>
                                                        @else
                                                            <td class="qty" align="right">
                                                                <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty_ops }}" hidden/>{{ $val->qty_ops }}
                                                            </td>
                                                            <td class="qty_acc" align="right" hidden>
                                                                <input type="text" name="qty_acc[]{{ $i }}" id="qty_acc[]{{ $i }}" class="form-control" style="height: 20px; width: 70px; text-align: right;" value="0">
                                                            </td>
                                                        @endif
                                                        
                                                    @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                        <td class="qty" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty_ga }}" hidden/>{{ $val->qty_ga }}
                                                        </td>
                                                        <td class="qty_acc" align="right" hidden>
                                                            <input type="text" name="qty_acc[]{{ $i }}" id="qty_acc[]{{ $i }}" class="form-control" style="height: 20px; width: 70px; text-align: right;" value="0">
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                                        {{-- <td class="qty" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty_pc }}" hidden/>{{ $val->qty_pc }}
                                                        </td>
                                                        <td class="qty_acc" align="right" hidden>
                                                            <input type="text" name="qty_acc[]{{ $i }}" id="qty_acc[]{{ $i }}" class="form-control" style="height: 20px; width: 70px; text-align: right;" value="0">
                                                        </td> --}}
														
														@if($pengajuan_v->status_atasan == '0')
                                                            <td class="qty" align="right">
																<input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty}}" hidden/>{{ $val->qty }}
															</td>
                                                        @elseif($pengajuan_v->status_atasan == '1')
                                                            <td class="qty" align="right">
																<input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty_pc}}" hidden/>{{ $val->qty_pc }}
															</td>  
                                                        @endif                    
                                                    @else
                                                        <td class="qty" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty" value="{{ $val->qty }}" hidden/>{{ $val->qty }}
                                                        </td>
                                                    @endif

                                                    <td class="satuan">
                                                        <input style="text-align: right" class="form-control" type="text" name="satuan[]" id="satuan" value="{{ $val->satuan }}" hidden/>{{ $val->satuan }}
                                                    </td>
													<td class="harga_satuan" align="right">
                                                        <input style="text-align: right" class="form-control" type="text" name="harga_satuan[]" id="harga_satuan" value="{{ $val->harga_satuan }}" hidden/>{{ number_format($val->harga_satuan) }}
                                                    </td>
                                                    
                                                    @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                        <td class="total_harga" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="total_harga[]" id="total_harga" value="{{ $val->qty_it*$val->harga_satuan }}" hidden/>{{ number_format($val->qty_it*$val->harga_satuan) }}
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '2') <!-- Jika ops-->
                                                        @if($pengajuan_v->kode_divisi == '2')
                                                        <td class="total_harga" align="right">
																<input style="text-align: right" class="form-control" type="text" name="total_harga[]" id="total_harga" value="{{ $val->qty*$val->harga_satuan }}" hidden/>{{ number_format($val->qty*$val->harga_satuan) }}
														</td>
                                                        @else
                                                        <td class="total_harga" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="total_harga[]" id="total_harga" value="{{ $val->qty_ops*$val->harga_satuan }}" hidden/>{{ number_format($val->qty_ops*$val->harga_satuan) }}
                                                        </td>
                                                        @endif
                                                        
                                                    @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                        <td class="total_harga" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="total_harga[]" id="total_harga" value="{{ $val->qty_ga*$val->harga_satuan }}" hidden/>{{ number_format($val->qty_ga*$val->harga_satuan) }}
                                                        </td>
                                                    @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
														@if($pengajuan_v->status_atasan == '0')
															<td class="total_harga" align="right">
																<input style="text-align: right" class="form-control" type="text" name="total_harga[]" id="total_harga" value="{{ $val->qty*$val->harga_satuan }}" hidden/>{{ number_format($val->qty*$val->harga_satuan) }}
															</td>
                                                        @elseif($pengajuan_v->status_atasan == '1')
                                                            <td class="total_harga" align="right">
																<input style="text-align: right" class="form-control" type="text" name="total_harga[]" id="total_harga" value="{{ $val->qty_pc*$val->harga_satuan }}" hidden/>{{ number_format($val->qty_pc*$val->harga_satuan) }}
															</td>  
                                                        @endif
                                                    @else
                                                        <td class="total_harga" align="right">
                                                            <input style="text-align: right" class="form-control" type="text" name="total_harga[]" id="total_harga" value="{{ $val->qty*$val->harga_satuan }}" hidden/>{{ number_format($val->qty*$val->harga_satuan) }}
                                                        </td>
                                                    @endif
													
                                                    <td class="divisi">
                                                        <input style="text-align: right" class="form-control" type="text" name="divisi[]" id="divisi" value="{{ $val->nama_divisi }}" hidden/>{{ $val->nama_divisi }}
                                                    </td>
                                                    <td hidden>
                                                        <a href="#" data-toggle="modal" data-target="#modal_image{{ $val->kode_product }}">
                                                            {{ $val->image }}
                                                        </a>

                                                        <div class="modal fade" id="modal_image{{ $val->kode_product }}" tabindex="-1" role="dialog" aria-labelledby="modal_image" aria-hidden="true">
                                                          <div class="modal-dialog" style="max-width: 55%; max-height: 55%;" role="document">                               
                                                            <div class="modal-content">                                       
                                                             <div class="modal-body">
                                                                                                 
                                                               <button type="button" class="close" data-dismiss="modal"><span 
                                                               aria-hidden="true">&times;</span><span class="sr- 
                                                               only">Close</span></button>                              
                                                               <img src="{{url('images/pengajuan/'. $val->image)}}" class="imagepreview" style="width: 100%;">
                                                                                              
                                                             </div>                             
                                                           </div>                                  
                                                          </div>
                                                        </div>
                                                    </td>
                                                    <td align="center" class="ceklist">
                                                        @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                            @if($pengajuan_v->status_validasi_adm_it == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '1') <!-- Approved -->
                                                                @if($val->status_cek_it == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_it == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_it == '3') <!-- pending -->
                                                                @if($val->status_cek_it == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_it == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '2') <!-- Jika OPS-->
                                                            @if(Auth::user()->kode_perusahaan == 'DTS')
                                                                @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($pengajuan_v->status_atasan == '1') <!-- Approved -->
                                                                    @if($val->status_cek_it == '0')
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                    @elseif($val->status_cek_it == '1')
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" /> 
                                                                @endif
                                                            @elseif(Auth::user()->kode_perusahaan == 'DTS_A')    
                                                                @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($pengajuan_v->status_atasan == '1') <!-- Approved -->
                                                                    @if($val->status_cek_it == '0')
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                    @elseif($val->status_cek_it == '1')
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" /> 
                                                                @endif
                                                            @elseif(Auth::user()->kode_perusahaan == 'DTS_C')
                                                                @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($pengajuan_v->status_atasan == '1') <!-- Approved -->
                                                                    @if($val->status_cek_it == '0')
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                    @elseif($val->status_cek_it == '1')
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" /> 
                                                                @endif
                                                            @else
                                                                @if($pengajuan_v->kode_divisi == '2')
                                                                    @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                    @elseif($pengajuan_v->status_atasan == '1') <!-- Approved -->
                                                                        @if($val->status_cek_it == '0')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                        @elseif($val->status_cek_it == '1')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                        @endif
                                                                    @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                    @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                        <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" /> 
                                                                    @endif
                                                                @else
                                                                    @if($pengajuan_v->status_validasi_adm_ops == '0') <!-- Baru -->
                                                                        @if($val->status_cek_ops == '0')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                        @elseif($val->status_cek_ops == '1')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                        @endif
                                                                    @elseif($pengajuan_v->status_validasi_adm_ops == '1') <!-- Approved -->
                                                                        @if($val->status_cek_ops == '0')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                        @elseif($val->status_cek_ops == '1')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                        @endif
                                                                    @elseif($pengajuan_v->status_validasi_adm_ops == '2') <!-- denied -->

                                                                    @elseif($pengajuan_v->status_validasi_adm_ops == '3') <!-- pending -->
                                                                        @if($val->status_cek_ops == '0')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                        @elseif($val->status_cek_ops == '1')
                                                                            <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                        @endif
                                                                    @endif
                                                                @endif

                                                                
                                                            @endif
														@elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                            @if($pengajuan_v->status_validasi_adm_ga == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '1') <!-- Approved -->
                                                                @if($val->status_cek_ga == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_ga == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '3') <!-- pending -->
                                                                @if($val->status_cek_ga == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_ga == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '11') <!-- Jika PC-->
                                                            @if($pengajuan_v->status_validasi_adm_pc == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '1') <!-- Approved -->
                                                                @if($val->status_cek_pc == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_pc == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '3') <!-- pending -->
                                                                @if($val->status_cek_pc == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_pc == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '17') <!-- Jika tgsm / Supply D-->
                                                            @if($pengajuan_v->status_validasi_adm_tgsm == '0') <!-- Baru -->
                                                                @if($val->status_cek_tgsm == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_tgsm == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_tgsm == '1') <!-- Approved -->
                                                                @if($val->status_cek_tgsm == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_tgsm == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_validasi_adm_tgsm == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_tgsm == '3') <!-- pending -->
                                                                @if($val->status_cek_tgsm == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_tgsm == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_atasan == '1') <!-- Approved -->
                                                                @if($val->status_cek_it == '0')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" disabled />
                                                                @elseif($val->status_cek_it == '1')
                                                                    <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" checked disabled />
                                                                @endif
                                                            @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" />
                                                            @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                <input type="checkbox" name="chk[]{{ $i }}" id="chk[]{{ $i }}" onkeyup="input_ket( {{ $i }} );" onclick="input_ket( {{ $i }} );" value="1" /> 
                                                            @endif
                                                            
                                                        @endif
                                                    </td>
                                                    <td class="ceklist_temp" id="ceklist_temp{{ $i }}" hidden></td>
                                                    <td class="keterangan">
                                                        @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
                                                            @if($pengajuan_v->status_validasi_adm_it == '0') <!-- Baru -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '1') <!-- approved -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                            @elseif($pengajuan_v->status_validasi_adm_it == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_it == '3') <!-- pending -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '2') <!-- Jika OPS-->
                                                            @if(Auth::user()->kode_perusahaan == 'DTS')
                                                                @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                                @elseif($pengajuan_v->status_atasan == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                                @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}">
                                                                @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                                @endif
                                                            @elseif(Auth::user()->kode_perusahaan == 'DTS_A')
                                                                @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                                @elseif($pengajuan_v->status_atasan == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                                @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}">
                                                                @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                                @endif
                                                            @elseif(Auth::user()->kode_perusahaan == 'DTS_C')
                                                                @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                                @elseif($pengajuan_v->status_atasan == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                                @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}">
                                                                @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                                @endif
                                                            @else
                                                                @if($pengajuan_v->status_validasi_adm_ops == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                                @elseif($pengajuan_v->status_validasi_adm_ops == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_ops }}" readonly>
                                                                @elseif($pengajuan_v->status_validasi_adm_ops == '2') <!-- denied -->

                                                                @elseif($pengajuan_v->status_validasi_adm_ops == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_ops }}" readonly>
                                                                @endif
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                                            @if($pengajuan_v->status_validasi_adm_ga == '0') <!-- Baru -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '1') <!-- approved -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_ga }}" readonly>
                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_ga == '3') <!-- pending -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_ga }}" readonly>
                                                            @endif
                                                        @elseif(Auth::user()->kode_divisi == '11') <!-- Jika PC-->
                                                            @if($pengajuan_v->status_validasi_adm_pc == '0') <!-- Baru -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '1') <!-- approved -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_pc }}" readonly>
                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '2') <!-- denied -->

                                                            @elseif($pengajuan_v->status_validasi_adm_pc == '3') <!-- pending -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_pc }}" readonly>
                                                            @endif
                                                        @else
                                                            @if($pengajuan_v->status_atasan == '0') <!-- Baru -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                            @elseif($pengajuan_v->status_atasan == '1') <!-- approved -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}" readonly>
                                                            @elseif($pengajuan_v->status_atasan == '2') <!-- denied -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="{{ $val->keterangan_detail_adm_it }}">
                                                            @elseif($pengajuan_v->status_atasan == '3') <!-- pending -->
                                                                <input type="text" name="ket[]{{ $i }}" id="ket[]{{ $i }}" class="form-control" style="height: 20px" onkeyup="input_ket( {{ $i }} );" value="" required>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="keterangan_temp" id="keterangan_temp{{ $i }}" hidden></td>
                                                </tr>
                                                <?php $i++; ?>

                                                @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No data available</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
											<tfoot>
                                                <tr>
                                                    <td colspan="9" align="center"><b>T o t a l</b></td>
                                                    <td><input style="text-align: right" class="form-control" type="text" name="total_all" id="total_all" value="0" style="text-align:right; font-style:bold;" required readonly/></td>
                                                    <td colspan="3"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-md-12 mb-2">
                                        <div class="input-group mb-3">
                                            
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($approval_upload as $row)
                                                    <tr>
                                                        <td><i>Attachment_{{ $no }}</i></td>
                                                        <td>
                                                            <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                {{ $row->filename }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    @empty
                                                    
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                @if(Auth::user()->kode_divisi == '3') <!-- Jika IT-->
									@if($pengajuan_v->kode_divisi == '3')
                                        @if($pengajuan_v->status_atasan  == '1') <!-- 2: approved -->
                                            @if($pengajuan_v->status_validasi_adm_it == '1')
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                        Approved
                                                    </button>
                                                </div>

                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @elseif($pengajuan_v->status_validasi_adm_it == '0')
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>

                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @endif
                                        @elseif($pengajuan_v->status_atasan == '2') <!-- 3: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_atasan == '3') <!-- 4: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        @if($pengajuan_v->status_it  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_it == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_it == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @elseif($pengajuan_v->status_it == '0' && $pengajuan_v->status_validasi_adm_it == '0') <!-- Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Pending
                                                </button>
                                            </div>
                                        @elseif($pengajuan_v->status_it == '0' && $pengajuan_v->status_validasi_adm_it == '1')
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @elseif($pengajuan_v->status_it == '0' && $pengajuan_v->status_validasi_adm_it == '3')
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                @elseif(Auth::user()->kode_divisi == '4') <!-- Jika GA-->
                                    @if($pengajuan_v->status_ga  == '1') <!-- 2: approved -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_ga == '2') <!-- 3: denied -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_ga == '3') <!-- 4: Pending -->
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                Approved
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                Denied
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                Pending
                                            </button>
                                        </div>
                                    @elseif($pengajuan_v->status_ga == '0' && $pengajuan_v->status_validasi_adm_ga == '0') <!-- Pending -->
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                Approved
                                            </button>
                                        </div>
                                
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                Denied
                                            </button>
                                        </div>
                                    
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                Pending
                                            </button>
                                        </div>
                                    @elseif($pengajuan_v->status_ga == '0' && $pengajuan_v->status_validasi_adm_ga == '1')
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                Approved
                                            </button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                Denied
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                Pending
                                            </button>
                                        </div>
                                    @endif
                                @elseif(Auth::user()->kode_divisi == '2') <!-- Jika Operasional-->
                                    @if(Auth::user()->kode_perusahaan == 'DTS')
                                        @if($pengajuan_v->status_atasan  == '1') <!-- 2: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_atasan == '2') <!-- 3: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_atasan == '3') <!-- 4: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif

                                    @elseif(Auth::user()->kode_perusahaan == 'DTS_A')
                                        @if($pengajuan_v->status_atasan  == '1') <!-- 2: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_atasan == '2') <!-- 3: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_atasan == '3') <!-- 4: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif

                                    @elseif(Auth::user()->kode_perusahaan == 'DTS_C')
                                        @if($pengajuan_v->status_atasan  == '1') <!-- 2: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_atasan == '2') <!-- 3: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_atasan == '3') <!-- 4: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif

                                    @else
                                        <!--  -->
                                        @if($pengajuan_v->kode_divisi == '2')
                                            @if($pengajuan_v->status_atasan  == '1') <!-- 2: approved -->
                                                @if($pengajuan_v->status_validasi_adm_ops == '1')
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                            Approved
                                                        </button>
                                                    </div>

                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                            Denied
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="col-md-1 mb-2">
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                            Pending
                                                        </button>
                                                    </div>
                                                @elseif($pengajuan_v->status_validasi_adm_ops == '0')
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                    </div>

                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                    </div>
                                                
                                                    <div class="col-md-1 mb-2">
                                                        <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                    </div>
                                                @endif
                                            @elseif($pengajuan_v->status_atasan == '2') <!-- 3: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($pengajuan_v->status_atasan == '3') <!-- 4: Pending -->
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif
                                        @else
                                            @if($pengajuan_v->status_ops == '0' && $pengajuan_v->status_validasi_adm_ops == '0') <!-- Pending -->
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                        Pending
                                                    </button>
                                                </div>
                                            @elseif($pengajuan_v->status_ops == '0' && $pengajuan_v->status_validasi_adm_ops == '1')
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-update', $pengajuan_v->kode_pengajuan) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                        Approved
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-denied', $pengajuan_v->kode_pengajuan) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-pending', $pengajuan_v->kode_pengajuan) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @elseif($pengajuan_v->status_ops == '0' && $pengajuan_v->status_validasi_adm_ops == '2')
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-update', $pengajuan_v->kode_pengajuan) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve" disabled>
                                                        Approved
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-denied', $pengajuan_v->kode_pengajuan) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied" disabled>
                                                        Denied
                                                    </button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-pending', $pengajuan_v->kode_pengajuan) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending" disabled>
                                                        Pending
                                                    </button>
                                                </div>
                                            @elseif($pengajuan_v->status_ops == '0' && $pengajuan_v->status_validasi_adm_ops == '3')
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-update', $pengajuan_v->kode_pengajuan) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve" disabled>
                                                        Approved
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-denied', $pengajuan_v->kode_pengajuan) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied" disabled>
                                                        Denied
                                                    </button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <!-- <a href="{{ route('approval-pending', $pengajuan_v->kode_pengajuan) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending" disabled>
                                                        Pending
                                                    </button>
                                                </div>
                                            @elseif($pengajuan_v->status_ops  == '1') <!-- 2: approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($pengajuan_v->status_ops == '2') <!-- 3: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($pengajuan_v->status_ops == '3') <!-- 4: Pending -->
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                        Approved
                                                    </button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                                
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif
                                        @endif

                                        <!--  -->
                                    @endif
                                @elseif(Auth::user()->kode_divisi == '11') <!-- Jika Purchasing-->
                                    {{-- jika belum approve atasan --}}
                                    @if($pengajuan_v->status_atasan == '0')
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                Approved
                                            </button>
                                        </div>
                                
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                Denied
                                            </button>
                                        </div>
                                    
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                Pending
                                            </button>
                                        </div>
                                    @elseif($pengajuan_v->status_atasan == '1')
                                        {{-- jika sudah approve atasan --}}
                                        @if($pengajuan_v->status_pc  == '1') <!-- 2: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_pc == '2') <!-- 3: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($pengajuan_v->status_pc == '3') <!-- 4: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <!-- <a href="{{ route('approval-update', $pengajuan_v->kode_pengajuan) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <!-- <a href="{{ route('approval-denied', $pengajuan_v->kode_pengajuan) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <!-- <a href="{{ route('approval-pending', $pengajuan_v->kode_pengajuan) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @elseif($pengajuan_v->status_pc == '0' && $pengajuan_v->status_validasi_adm_pc == '0') <!-- Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Pending
                                                </button>
                                            </div>
                                        @elseif($pengajuan_v->status_pc == '0' && $pengajuan_v->status_validasi_adm_pc == '1') 
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @endif

                                @else
                                    @if($pengajuan_v->status_atasan  == '1') <!-- 2: approved -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                       
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_atasan == '2') <!-- 3: denied -->
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                        </div>
                                        
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                        </div>
                                    @elseif($pengajuan_v->status_atasan == '3') <!-- 4: Pending -->
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                Approved
                                            </button>
                                        </div>
                                
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                Denied
                                            </button>
                                        </div>
                                    
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                Pending
                                            </button>
                                        </div>
                                    @else
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                Approved
                                            </button>
                                        </div>
                                
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                Denied
                                            </button>
                                        </div>
                                    
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                Pending
                                            </button>
                                        </div>
                                    @endif
                                @endif
                                    <!-- MODAL APPROVED -->
                                            <div class="modal fade" id="modalTambahPesan_approve" tabindex="-1" aria-labelledby="modalTambahPesan_approve" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval-update', $pengajuan_v->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_v->no_urut }}" required readonly>
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL DENIED -->
                                            <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan ditolak </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval-denied', $pengajuan_v->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_v->no_urut }}" required readonly>
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL Pending -->
                                            <div class="modal fade" id="modalTambahPesan_pending" tabindex="-1" aria-labelledby="modalTambahPesan_pending" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk keterangan ditunda  </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval-pending', $pengajuan_v->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="text" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_v->no_urut }}" required readonly>
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                            
                                            <div class="modal fade" id="modalTambahPesan" tabindex="-1" aria-labelledby="modalTambahPesan" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Informasi</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                Pengajuan tidak bisa diproses. Pengajuan belum diverifikasi.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <div class="col-md-9 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">Kembali</button>
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