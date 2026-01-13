@section('js')
<script type="text/javascript">
    var tot =0;

    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById('kode_supp').value = $(this).attr('data-kode_vendor')
        document.getElementById('supplier').value = $(this).attr('data-nama_vendor')

        $('#myModalsupp').modal('hide');
    });

    var x = 1;
    $(document).on('click', '.pilih', function (e) {
                //document.getElementById('kode_produk').value = $(this).attr('data-kode_produk');
                x++;
                var tabel = document.getElementById("tabelinput");
                var row = tabel.insertRow(1);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                var cell8 = row.insertCell(7);
                

                var a = $(this).attr('data-kode_produk');
                var b = $(this).attr('data-nama_produk');
                var c = $(this).attr('data-merk');
                var d = $(this).attr('data-ket');
                var e = $(this).attr('data-price')
               
                cell1.innerHTML = '<input name="chk" type="checkbox" />';
                cell2.innerHTML = '<input type="text" class="form-control" name="kode_produk[]" id="kode_produk" style="font-size: 13px;" value="'+a+'" readonly>'; //a
                cell3.innerHTML = '<input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="font-size: 13px;" value="'+b+'" readonly>'//b;
                cell4.innerHTML = '<input type="text" class="form-control" name="merk[]" id="merk" style="font-size: 13px;" value="'+c+'" readonly>'//c;
                cell5.innerHTML = '<input type="text" class="form-control" name="ket[]" id="ket" style="font-size: 13px;" value="'+d+'" readonly>'//d;
                cell6.innerHTML = '<input type="text" class="form-control" name="harga[]" id="harga_'+x+'" style="font-size: 13px; text-align: right;" value="'+e+'" onkeyup="jumlah('+x+');">'//e;
                cell7.innerHTML = '<input type="text" class="form-control qty" name="qty[]" id="qty_'+x+'" style="font-size: 13px; text-align: right;" onkeyup="jumlah('+x+');">';
                cell8.innerHTML = '<input type="text" class="form-control" name="total[]" id="total_'+x+'" style="font-size: 13px; text-align: right;" readonly>';
                
                $('#myModal').modal('hide');
    });

    
    $(function () {
                $("#lookup").dataTable();
    });

    function hapusbaris(tabel){
        var tabel = document.getElementById("tabelinput");
        var bacabaris = tabel.rows.length;
        for(var i=0;i<bacabaris;i++){
            //baca baris yang ke i
            var bacabarisyangke = tabel.rows[i];
            //baca ceklist di childnode cell ke 0
            var bacaceklist = bacabarisyangke.cells[0].childNodes[0];
            //jika ada ceklist
            if(null != bacaceklist && true == bacaceklist.checked){
                tabel.deleteRow(i);
                bacabaris--;
                i--;

                tot = $('#total_harga').val() - $('#total_'+x+'').val();
                document.getElementById("total_harga").value = '99999';

            }
        }
        return false;
    }

    function jumlah(x){

        var txtharga = $('#harga_'+x+'').val();
        var txtqty = $('#qty_'+x+'').val();
        txttotal =txtharga * txtqty;
            
        $('#total_'+x+'').val(txttotal);
        

        tot += parseInt(txttotal);
        tot1 = tot;
        document.getElementById("total_harga").value = (tot1); 

    }

    

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("purchasing.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
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

    $(document).ready(function(){
        fetch_product_data();
        function fetch_product_data(query = '')
        {
            $.ajax({
                url:'{{ route("purchasing/action_product.actionProduct") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_product', function(){
            var query = $(this).val();
            fetch_product_data(query);
        });
    });

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
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item active">Create Purchasing</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('purchasing.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Purchase Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="kode">PO Number</label>
                                        <input type="text" name="kode_pembelian" class="form-control" value="{{ $kode }}" required readonly>
                                        
                                    </div>
                                    
                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="nama">Applicant's Name</label>
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                        
                                    </div>
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="tgl">Date</label>
                                        <input type="text" name="tgl_pembelian" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                        
                                    </div>

                                    <div class="col-md-4 mb-2 float-right">
                                        <label for="supplier">Vendor</label>
                                        <div class="input-group">
                                            <input id="supplier" type="text" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ old('kode_supp') }}" required readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalsupp"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                        <p class="text-danger">{{ $errors->first('kode_supp') }}</p>
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
                                                    <th>#</th>
                                                    <th>Product Id</th>
                                                    <th>Product Name</th>
                                                    <th>Merk</th>
                                                    <th>Desc/Spek</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
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
                                        
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div>

                                </div>
                              
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Choose Product</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Delete Product</button>
                                    </div>  
                                  
                                    <div class="col-md-8 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Save</button>
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
                                <th>Merk</th>
                                <th>Desc/Spek</th>
                                <th>Price</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalsupp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                <th>Vendor</th>
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


