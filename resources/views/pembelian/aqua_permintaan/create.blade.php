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
    // var tot =0;

    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById('kode_supp').value = $(this).attr('data-kode_vendor')
        document.getElementById('supplier').value = $(this).attr('data-nama_vendor')

        $('#myModalsupp').modal('hide');
    });

    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("purchasing/action_vendor.actionVendor") }}',
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

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("permintaan_aqua/store.store") }}',
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
	
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Purchase Order</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Aqua</li>
        <li class="breadcrumb-item">PO</li>
        <li class="breadcrumb-item active">Buat PO</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- <form action="#"  enctype="multipart/form-data">
                @csrf -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Purchase Order</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('permintaan_aqua/cari_permintaan.cari_permintaan') }}" method="get">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        PO
                                        <input type="text" name="kode_pembelian" id="kode_pembelian" class="form-control" value="{{ $kode }}" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Tanggal
                                        <input type="text" name="tgl_pembelian" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                   
                                    <div class="col-md-2 mb-2 float-right" hidden>
                                        Applicant's Name
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Nama Vendor
                                        <div class="input-group">
                                            <input id="supplier" type="text" name="supplier" class="form-control" value="{{ request()->supplier }}" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ request()->kode_supp }}" required readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalsupp"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                        <p class="text-danger">{{ $errors->first('kode_supp') }}</p>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2" > 
                                        actual_pickup_date 
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    </div>  
                                    <div>  
                                        <br>
                                        <button class="btn btn-secondary" type="submit">C a r i</button>
                                    </div>   
                                
                                </div>
                                </form>
                            </div>
                        </div>
                    
                        <form action="{{ route('permintaan_aqua/store.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="kode_pembelian" id="kode_pembelian" class="form-control" value="{{ $kode }}" required readonly>
                                    <input id="kode_supp" type="hidden" name="kode_supp" value="{{ request()->kode_supp }}" required readonly>
                                    <div class="table-responsive">
                                        <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1; ?>
                                                    @forelse($permintaan as $val)
                                                    <tr>
                                                        <td >{{ $i }}</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="kode_produk[]" id="kode_produk_" style="font-size: 13px;" value="{{ $val->material_id }}" readonly hidden>
                                                            {{ $val->material_id }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="nama_produk[]" id="nama_produk_" style="font-size: 13px;" value="{{ $val->material_desc }}" readonly hidden>
                                                            {{ $val->material_desc }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="harga[]" id="harga_{{ $i }}" style="font-size: 13px; text-align: right;" value="{{ $val->harga }}" onchange="jumlah({{ $i }});">
                                                        </td>
                                                        <td align="right">
                                                            <input type="number" class="form-control" name="qty[]" id="qty_{{ $i }}" style="font-size: 13px; text-align: right;" value="{{ $val->actual_quantity }}" readonly hidden>
                                                            {{ $val->actual_quantity }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="total[]" id="total_{{ $i }}" style="font-size: 13px; text-align: right;" value="{{ $val->harga * $val->actual_quantity }}" readonly>
                                                        </td>
                                                        <?php
                                                            //$total_all += $row->harga_total;
                                                            $i++; 
                                                        ?>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tidak ada data</td>
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
                                            
                                            <input type="text" name="total_harga" id="total_harga" class="form-control" value="0" style="text-align:right; font-style:bold;" readonly>
                                            
                                        </div>

                                    </div>
                                  
                                    <div class="row">  
                                        <div class="col-md-12 mb-2">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <!-- </form> -->
        </div>
    </div>
</main>


<div class="modal fade bd-example-modal-lg" id="myModalsupp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_vendor" id="search_vendor" class="form-control" placeholder="Search Data . . .">
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
</div>

@endsection




