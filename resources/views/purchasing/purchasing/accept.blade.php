@section('js')
<script type="text/javascript">
    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("purchasing_accepted.accepted") }}',
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
            txttotal = txtharga * txtqty;

            $('#total_1').val(txttotal);

            tot = $('#total_1').val();   
        }else{
            var txtharga = $('#harga_'+i+'').val();
            var txtqty = $('#qty_'+i+'').val();
            txttotal = txtharga * txtqty;
            
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
        <li class="breadcrumb-item">Purchase & Payment</li>
        <li class="breadcrumb-item">PO</li>
        <li class="breadcrumb-item active">Accept Order</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('purchasing_accepted.accepted') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Terima Barang dr Vendor</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Kode Pembelian 
                                        <input type="text" name="kode_pembelian" class="form-control" value="{{ $penerimaan_v->kode_pembelian }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-4 mb-2 float-right">
                                        Pengajuan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{ $penerimaan_v->name }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        BTB
                                        <input type="text" name="btb" class="form-control" required readonly value="{{ $no_btb }}">
                                        
                                    </div>

                                </div>

                               
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pembelian
                                        <input type="text" name="tgl_pembelian" class="form-control" value="{{ $penerimaan_v->tgl_pembelian }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">
                                        Vendor
                                        <div class="input-group">
                                            <input id="supplier" type="text" name="supplier" value="{{ $penerimaan_v->nama_vendor }}" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ $penerimaan_v->kode_vendor }}" required readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        No Receive
                                        <input type="text" name="invoice" class="form-control" required>
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10 mb-2" >
                                        
                                    </div>
                                    <div class="col-md-2 mb-2" >
                                        Tgl Dokumen
                                        <input type="text" name="tgl_invoice" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <form id="savedatas">
                    <?php 
                        $total_all=0;
                    ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>#</th>
                                                    <th>Kode Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Keterangan/Spek</th>
                                                    <th>harga</th>
                                                    <th>Jml</th>
                                                    <th>Total</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @forelse ($penerimaan_detail as $row)
                                                <tr>
                                                    <td hidden>#</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_" style="font-size: 13px;" value="{{ $row->kode_product }}" readonly hidden>
                                                        {{ $row->kode_product }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="nama_produk[]" id="nama_produk_" style="font-size: 13px;" value="{{ $row->nama_barang }}" readonly hidden>
                                                        {{ $row->nama_barang }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="merk[]" id="merk_" style="font-size: 13px;" value="{{ $row->merk }}" readonly hidden>
                                                        {{ $row->merk }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="ket[]" id="ket_" style="font-size: 13px;" value="{{ $row->ket }}" readonly hidden>
                                                        {{ $row->ket }}
                                                    </td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="harga[]" id="harga_{{ $i }}" style="font-size: 13px; text-align: right;" value="{{ ($row->harga_satuan) }}" readonly hidden>
                                                        {{ $row->harga_satuan }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="qty[]" id="qty_{{ $i }}" style="font-size: 13px; text-align: right; width: 60px;" value="{{ $row->qty_po }}" onchange="jumlah(<?php echo $i;?>);">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="total[]" id="total_{{ $i }}" style="font-size: 13px; text-align: right; width: 100px;" value="{{ ($row->harga_total) }}" readonly>
                                                    </td>

                                                    <?php
                                                        $total_all += $row->harga_total;
                                                        $i++; 
                                                    ?>
                                                </tr>
                                                @empty
                                                <tr>
                                                
                                                </tr>
                                                @endforelse
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>    
                                <div class="row"> 
                                    <div class="col-md-10 mb-2">
                                        
                                        <label for="supplier" class="float-right" style="font-size:25px; ">Total</label>
                                        
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="<?php echo ($total_all) ?>" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div>

                                </div>
                              
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Terima</button>
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


@endsection

<script text="text/javascript">
    
       
</script> 


