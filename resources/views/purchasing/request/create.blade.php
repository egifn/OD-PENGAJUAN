@section('js')
<script type="text/javascript">
    // var tot =0;

    // $(document).on('click', '.pilih_vendor', function (e){
    //         // if(i=1){
        
    //         //     document.getElementById('kode_supp_1').value = $(this).attr('data-kode_vendor')
    //         //     document.getElementById('supplier_1').value = $(this).attr('data-nama_vendor')
    //         //     $('#myModalsupp').modal('hide');

    //         // }else{
    //         //     document.getElementById('kode_supp_'+i+'').value = $(this).attr('data-kode_vendor')
    //         //     document.getElementById('supplier_'+i+'').value = $(this).attr('data-nama_vendor')
    //         //     $('#myModalsupp').modal('hide');
    //         // }

    //         var tabel = document.getElementById("tabelinput");
    //         for(var i = 1; i < tabel.rows.length; i++){
    //                 var bacabarisyangke = tabel.rows[i];
    //                 var bacaceklist = bacabarisyangke.cells[5].childNodes[0];

    //                 document.getElementById('kode_supp_'+i+'').value = $(this).attr('data-kode_vendor')
    //                 document.getElementById('supplier_'+i+'').value = $(this).attr('data-nama_vendor')
    //                 $('#myModalsupp').modal('hide');   
    //         }
    // });

    // var x = 1;
    // $(document).on('click', '.pilih', function (e) {
    //             //document.getElementById('kode_produk').value = $(this).attr('data-kode_produk');
    //             x++;
    //             var tabel = document.getElementById("tabelinput");
    //             var row = tabel.insertRow(1);

    //             var cell1 = row.insertCell(0);
    //             var cell2 = row.insertCell(1);
    //             var cell3 = row.insertCell(2);
    //             var cell4 = row.insertCell(3);
    //             var cell5 = row.insertCell(4);
    //             var cell6 = row.insertCell(5);
    //             var cell7 = row.insertCell(6);
    //             var cell8 = row.insertCell(7);
                

    //             var a = $(this).attr('data-kode_produk');
    //             var b = $(this).attr('data-nama_produk');
    //             var c = $(this).attr('data-merk');
    //             var d = $(this).attr('data-ket');
    //             var e = $(this).attr('data-price')
               
    //             cell1.innerHTML = '<input name="chk" type="checkbox" />';
    //             cell2.innerHTML = '<input type="text" class="form-control" name="kode_produk[]" id="kode_produk" style="font-size: 13px;" value="'+a+'" readonly>'; //a
    //             cell3.innerHTML = '<input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="font-size: 13px;" value="'+b+'" readonly>'//b;
    //             cell4.innerHTML = '<input type="text" class="form-control" name="merk[]" id="merk" style="font-size: 13px;" value="'+c+'" readonly>'//c;
    //             cell5.innerHTML = '<input type="text" class="form-control" name="ket[]" id="ket" style="font-size: 13px;" value="'+d+'" readonly>'//d;
    //             cell6.innerHTML = '<input type="text" class="form-control" name="harga[]" id="harga_'+x+'" style="font-size: 13px; text-align: right;" value="'+e+'" onkeyup="jumlah();">'//e;
    //             cell7.innerHTML = '<input type="text" class="form-control" name="qty[]" id="qty_'+x+'" style="font-size: 13px; text-align: right;" onkeyup="jumlah();">';
    //             cell8.innerHTML = '<input type="text" class="form-control" name="total[]" id="total_'+x+'" style="font-size: 13px; text-align: right;" readonly>';
                

    //             $('#myModal').modal('hide');
    // });

    
    // $(function () {
    //             $("#lookup").dataTable();
    // });

    // function hapusbaris(tabel){
    //     var tabel = document.getElementById("tabelinput");
    //     var bacabaris = tabel.rows.length;
    //     for(var i=0;i<bacabaris;i++){
    //         //baca baris yang ke i
    //         var bacabarisyangke = tabel.rows[i];
    //         //baca ceklist di childnode cell ke 0
    //         var bacaceklist = bacabarisyangke.cells[0].childNodes[0];
    //         //jika ada ceklist
    //         if(null != bacaceklist && true == bacaceklist.checked){
    //             tabel.deleteRow(i);
    //             bacabaris--;
    //             i--;

    //             tot = tot - $('#total_'+y+'').val();
    //             $('#total_harga').val(tot);
    //         }
    //     }
    //     return false;
    // }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("request_purchasing_order.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    function jumlah(i){
        var tot = 0 ;
        if(i==1){
            
            var txtharga = $('#harga_1').val();
            var txtqty = $('#qty_1').val();
            txttotal =txtharga * txtqty;
            
            $('#total_1').val(txttotal);

            tot = $('#total_1').val();
        }else{
            var txtharga = $('#harga_'+i+'').val();
            var txtqty = $('#qty_'+i+'').val();
            txttotal =txtharga * txtqty;
            
            $('#total_'+i+'').val(txttotal);

            tot = $('#total_'+i+'').val();
        }

        var tabel = document.getElementById("tabelinput");
        var sumTotal = 0;
        for(var t = 1; t < tabel.rows.length; t++){
            sumTotal = sumTotal + parseInt($('#total_'+t+'').val());
            document.getElementById("total_harga").value = sumTotal;
        }
    }

    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("request_purchasing/action_vendor.actionVendor") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_vendor tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_vendor', function(){
            var query = $(this).val();
            fetch_vendor_data(query);
        });
    });
</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Tambah Pengajuan</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Daftar Pengajuan</li>
        <li class="breadcrumb-item">Daftar Pengajuan Barang</li>
        <li class="breadcrumb-item">Detail Pengajuan Barang</li>
        <li class="breadcrumb-item active">Buat Pesan Pembelian</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('request_purchasing_order.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pesan Pembelian</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2" hidden>
                                        PO
                                        <input type="text" name="kode_pembelian" class="form-control" value="{{ $kode }}" required readonly>
                                        
                                    </div>
                                    
                                    <div class="col-md-4 mb-2 float-right">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                        
                                    </div>

                                    <div class="col-md-2 mb-2 float-right">
                                        Id Pengajuan
                                        <input type="text" name="kode_pengajuan" class="form-control" value="{{ $head->kode_pengajuan }}" required readonly>
    
                                    </div>

                                    <!-- Object COA -->
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="id_pengeluaran" type="text" name="id_pengeluaran" value="{{ $head->jenis }}" >
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="nama_pengeluaran" type="text" class="form-control" value="{{ $head->nama_pengeluaran }}" readonly >
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="kode_coa" type="text" name="kode_coa" class="form-control" value="{{ $head->coa }}"  >
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="nama_coa" type="text" name="nama_coa" class="form-control" value="{{ $head->nama_transaksi }}"  >
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="debet" type="text" name="debet" class="form-control" value="{{ $head->debet_1 }}">
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="kredit" type="text" name="kredit" class="form-control" value="{{ $head->kredit_1 }}">
                                        </div>
                                    
                                    <div class="col-md-2 mb-2">
                                        tanggal
                                        <input type="text" name="tgl_pembelian" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                        
                                    </div>

                                    <div class="col-md-2 mb-2 float-right">
                                        Keterangan
                                        <select name="jenis" class="form-control" required>
                                            <option value="">Pilih</option>
                                            <option value="ATK">ATK</option>
                                            <option value="IT">IT</option>
                                            <option value="Operational">Operational</option>
                                        </select>
                                        
                                    </div>
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2 float-right" hidden>
                                        Vendor
                                        <div class="input-group">
                                            <input id="supplier" type="text" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="" required readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalsupp"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <form id="savedatas">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Id Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Keterangan/Spek</th>
                                                    <th>Vendor</th>
                                                    <th>Harga</th>
                                                    <th>Jml</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @forelse($details as $val)
                                                <tr>
                                                    <td >{{ $i }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_" style="font-size: 13px;" value="{{ $val->kode_product }}" readonly hidden>
                                                        {{ $val->kode_product }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="nama_produk[]" id="nama_produk_" style="font-size: 13px;" value="{{ $val->nama_barang }}" readonly hidden>
                                                        {{ $val->nama_barang }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="merk[]" id="merk_" style="font-size: 13px;" value="{{ $val->merk }}" readonly hidden>
                                                        {{ $val->merk}}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ket[]" id="ket_" style="font-size: 13px;" value="{{ $val->ket }}" readonly hidden>
                                                        {{ $val->ket }}
                                                    </td>
                                                    <td>
                                                       <!--  <div class="input-group">
                                                            <input type="text" name="supplier[]" id="supplier_{{ $i }}" class="form-control" readonly required>
                                                            <input type="hidden" name="kode_supp[]" id="kode_supp_{{ $i }}" value="" required readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" name="tombol[]" id="tombol_{{ $i }}" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalsupp" onclick ="ambil({{ $i }})"> <span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div> -->
                                                        
                                                        <select name="cvendor[]" id="cvendor_" class="form-control" style="width: 300px;" required>
                                                            <option value="">Pilih</option>
                                                            @foreach ($vendor as $row)
                                                                <option value="{{ $row->kode_vendor }}" {{ old('kode_vendor') == $row->kode_vendor ? 'selected':'' }}>{{ $row->nama_vendor }}</option>
                                                            @endforeach    
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="harga[]" id="harga_{{ $i }}" style="font-size: 13px; text-align: right; width: 120px" value="{{ $val->price }}" onchange="jumlah({{ $i }});">
                                                    </td>
                                                    <td align="right">
                                                        <input type="number" class="form-control" name="qty[]" id="qty_{{ $i }}" style="font-size: 13px; text-align: right;" value="{{ $val->qty }}" readonly hidden>
                                                        {{ $val->qty_pc }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="total[]" id="total_{{ $i }}" style="font-size: 13px; text-align: right; width: 120px" value="{{ $val->price * $val->qty }}" readonly>
                                                    </td>
                                                    <?php
                                                        //$total_all += $row->harga_total;
                                                        $i++; 
                                                    ?>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="11" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>    
                                <div class="row"> 
                                    <div class="col-md-10 mb-2">
                                        
                                        <label for="total" class="float-right" style="font-size:25px; ">Total</label>
                                        
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        @forelse($total as $row)
                                            <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ $row->total }}" style="text-align:right; font-style:bold;" required readonly>
                                         @empty

                                        @endforelse 
                                        
                                        
                                    </div>

                                </div>
                              
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" hidden>Choose Product</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')" hidden>Delete Product</button>
                                    </div>  
                                  
                                    <div class="col-md-8 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th hidden>#</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Merk</th>
                            <th>Keterangan/Spek</th>
                            <th>Kat</th>
                            <th>Qty</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $val)
                        <tr>
                            <td hidden></td>
                            <td>{{ $val->kode_product }}</td>
                            <td>{{ $val->nama_barang }}</td>
                            <td>{{ $val->merk }}</td>
                            <td>{{ $val->ket }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->qty }}</td>
                           
                                                        <input name="chk[]" id="chk_" type="checkbox" checked />
                          
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                       
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="modal fade bd-example-modal-lg" id="myModalsupp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_vendor" id="search_vendor" class="form-control" placeholder="Cari Vendor...">
                    </div>  
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_vendor" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('script')
    
   

@endsection