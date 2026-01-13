@section('js')
<script type="text/javascript">
    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("permintaan_aqua/accepted.accepted") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });


    function jumlah($i){ 
        if($i>0){
            a=(document.getElementById("harga_"+$i).value);
            b=(document.getElementById("qty_"+$i).value);
            c=a*b;
            document.getElementById("total_"+$i).value=c;      
        }else{
            a=(document.getElementById("harga_"+$i).value);
            b=(document.getElementById("qty_"+$i).value);
            c=a*b;
            document.getElementById("total_"+$i).value=c;      
        }
      

     
        //document.getElementById("total_harga").value = 0;
    }

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Accept Order</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Aqua</li>
        <li class="breadcrumb-item">PO</li>
        <li class="breadcrumb-item active">Accept Order</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('permintaan_aqua/accepted.accepted') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Accept Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        PO ID
                                        <input type="text" name="kode_pembelian" class="form-control" value="{{ $penerimaan_v->kode_pembelian }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-4 mb-2 float-right">
                                        Buyer's name
                                        <input type="text" name="nama" class="form-control" value="{{ $penerimaan_v->name }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        BTB ID
                                        <input type="text" name="btb" class="form-control" required readonly value="{{ $no_btb }}">
                                        
                                    </div>

                                </div>

                               
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Date
                                        <input type="text" name="tgl_pembelian" class="form-control" value="{{ $penerimaan_v->tgl_pembelian }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">
                                        Supplier Name
                                        <div class="input-group">
                                            <input id="supplier" type="text" name="supplier" value="{{ $penerimaan_v->nama_vendor }}" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ $penerimaan_v->kode_vendor }}" required readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Invoice
                                        <input type="text" name="invoice" class="form-control" required>
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10 mb-2" >
                                        
                                    </div>
                                    <div class="col-md-2 mb-2" >
                                        Invoice Date
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
                                                    <th>Harga</th>
                                                    <th>Jumlah</th>
                                                    <th>Total</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; ?>
                                                @forelse ($penerimaan_detail as $row)
                                                <tr>
                                                    <td hidden>#</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_" style="font-size: 13px;" value="{{ $row->kode_product }}" readonly hidden>{{ $row->kode_product }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="nama_produk[]" id="nama_produk_" style="font-size: 13px;" value="{{ $row->nama_produk }}" readonly hidden>{{ $row->nama_produk }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="harga[<?php echo $i; ?>]" id="harga_<?php echo $i; ?>" style="font-size: 13px; text-align: right;" value="{{ ($row->harga) }}" readonly hidden>{{ number_format($row->harga) }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="qty[<?php echo $i; ?>]" id="qty_<?php echo $i; ?>" style="font-size: 13px; text-align: right;" value="{{ $row->qty }}" onkeyup="jumlah(<?php echo $i;?>);" readonly hidden>{{ number_format($row->qty) }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="total[<?php echo $i; ?>]" id="total_<?php echo $i; ?>" style="font-size: 13px; text-align: right;" value="{{ ($row->harga_total) }}" readonly hidden>{{ number_format($row->harga_total) }}
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
                                        
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="<?php echo number_format($total_all) ?>" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div>

                                </div>
                              
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">A c c e p t</button>
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


