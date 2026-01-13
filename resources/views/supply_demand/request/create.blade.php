@section('js')
<script type="text/javascript">
    var tot =0;

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

                var a = $(this).attr('data-kode_produk');
                var b = $(this).attr('data-nama_produk');
                var c = $(this).attr('data-merk');
                var d = ''; //$(this).attr('data-ket');
                var e = ''; //$(this).attr('data-price')
               
                cell1.innerHTML = '<input name="chk" type="checkbox" />';
                cell2.innerHTML = '<input type="text" class="form-control" name="kode_produk[]" id="kode_produk_'+x+'" style="font-size: 13px;" value="'+a+'" readonly>'; //a
                cell3.innerHTML = '<input type="text" class="form-control" name="nama_produk[]" id="nama_produk_'+x+'" style="font-size: 13px;" value="'+b+'" readonly>'//b;
                cell4.innerHTML = '<input type="text" class="form-control" name="merk[]" id="merk_'+x+'" style="font-size: 13px;" value="'+c+'" readonly>'//c;
                cell5.innerHTML = '<input type="text" class="form-control" name="harga[]" id="harga_'+x+'" style="font-size: 13px; text-align: right;" value="'+e+'" onchange="jumlah('+x+');">'//e;
                cell6.innerHTML = '<input type="text" class="form-control qty" name="qty[]" id="qty_'+x+'" style="font-size: 13px; text-align: right;" onchange="jumlah('+x+');">';
                cell7.innerHTML = '<input type="text" class="form-control" name="total[]" id="total_'+x+'" style="font-size: 13px; text-align: right;" readonly>';
                
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

var a = 0;
function jumlah(x){
    var b = 0 ;
    if(x==1){
        
        var txtqty = $('#qty_'+x+'').val();
        var txtharga = $('#harga_'+x+'').val();
        
        txttotal = 10000;
            
        $('#total_'+x+'').val(txttotal);
        
        b = $('#total_'+x+'').val();
    }else{
       
        var txtqty = $('#qty_'+x+'').val();
        var txtharga = $('#harga_'+x+'').val();
        
        txttotal = txtharga * txtqty;
            
        $('#total_'+x+'').val(txttotal);

        b = $('#total_'+x+'').val();
    }
    a = parseInt(a) + parseInt(b) ;
    $('#total_harga').val(a);
}

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("supply_demand.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    $(document).ready(function(){
        fetch_product_data();
        function fetch_product_data(query = '')
        {
            $.ajax({
                url:'{{ route("supply_demand/action_product.actionProduct") }}',
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

$(function(){
    $('#kode_perusahaan').change(function(){
        var perusahaan_id = $(this).val();
        if(perusahaan_id){
            $.ajax({
                type:"GET",
                url:"/ajax?perusahaan_id="+perusahaan_id,
                dataType:'JSON',
                success: function(res){
                    if(res){
                        $("#kode_depo").empty();
                        $("#kode_depo").append('<option>Select</option>');
                        $.each(res,function(nama,kode){
                            $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                        });
                    }else{
                        $("#kode_depo").empty();
                    }
                }
            });
        }else{
            $("#kode_depo").empty();
        }
    });
});

</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Create Request</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Supply Demand</li>
        <li class="breadcrumb-item">Goods Request</li>
        <li class="breadcrumb-item active">Create Request</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('supply_demand.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Create Request</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2 float-right">
                                        Applicant's Name
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Factory
                                        <select name="kode_pabrik" id="kode_pabrik" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Cianjur">Cianjur</option>
                                            <option value="Mekarsari">Mekarsari</option>
                                            <option value="Subang">Subang</option>
                                            <option value="Sukabumi">Sukabumi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        PO Number
                                        <input type="text" name="kode_pembelian" class="form-control" value="{{ $kode }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Company Name
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                            <option value="">select</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Date
                                        <input type="text" name="tgl_pembelian" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                        
                                    </div>

                                     <div class="col-md-3 mb-2">
                                        Depo Name
                                        <select name="kode_depo" id="kode_depo" class="form-control" required>
                                            <option value="">select</option>
                                        </select>
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
                                                    <th>Unit</th>
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
                                <th>Unit</th>
                                
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


