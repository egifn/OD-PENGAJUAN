@section('js')


<script type="text/javascript">

$(document).on('click', '.pilih', function(e) {
        document.getElementById('kode_produk').value = $(this).attr('data-kode_produk')
        document.getElementById('nama_produk').value = $(this).attr('data-nama_produk')

        $('#myModalProduk').modal('hide');
}); 

$(document).ready(function(){
        fetch_produk_data();
        function fetch_produk_data(query = '')
        {
            $.ajax({
                url:'{{ route("warehouse/action_product.actionProduct") }}',
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
            fetch_produk_data(query);
        });
});


$(function(){
    $('#kode_area').change(function(){
        var area_id = $(this).val();
        if(area_id){
            $.ajax({
                type:"GET",
                url:"/ajax_area?area_id="+area_id,
                dataType:'JSON',
                success: function(res){
                    if(res){
                        $("#kode_sub_area").empty();
                        $("#kode_sub_area").append('<option>Select</option>');
                        $.each(res,function(nama,kode){
                            $("#kode_sub_area").append('<option value="'+kode+'">'+nama+'</option>');
                        });
                    }else{
                        $("#kode_sub_area").empty();
                    }
                }
            });
        }else{
            $("#kode_sub_area").empty();
        }
    });
});


</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Add Warehouse</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Warehouse</li>
        <li class="breadcrumb-item active">Add Warehouse</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('warehouse/create.store_2') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Add Warehouse</h4>
                            </div>
                            <div class="card-body">
                                
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Product Id
                                                <div class="input-group">
                                                    <input id="kode_produk" type="text" name="kode_produk" class="form-control" value="{{ old('kode_produk') }}" required readonly>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalProduk"> <span class="fa fa-search"></span></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Product Name
                                                <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="" required readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Area
                                                <select name="kode_area" id="kode_area" class="form-control" required>
                                                    <option value="">select</option>
                                                    @foreach ($area as $row)
                                                        <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Sub Area
                                                <select name="kode_sub_area" id="kode_sub_area" class="form-control" onchange="pilih()">
                                                <option value="">select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 mb-2" align="right">
                                                <button class="btn btn-primary btn-sm">Create</button>
                                            </div>
                                            
                                        </div>

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>


<div class="modal fade bd-example-modal-lg" id="myModalProduk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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




