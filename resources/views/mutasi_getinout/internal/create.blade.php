@section('js')


<script type="text/javascript">

    $(document).on('click', '.pilih', function (e) {
        var tabel = document.getElementById("tabelinput");
        var row = tabel.insertRow(1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        var a = $(this).attr('data-kode_produk');
        var b = $(this).attr('data-nama_produk');
               
        cell1.innerHTML = '<input name="chk" type="checkbox" />'
        cell2.innerHTML = '<input type="text" class="form-control" name="kode_produk[]" id="kode_produk" style="font-size: 13px;" value="'+a+'" readonly>'
        cell3.innerHTML = '<input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="font-size: 13px;" value="'+b+'" readonly>'
        cell4.innerHTML = '<input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right;" value="0">'
        
               
        $('#myModal').modal('hide');
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

    
    $(function () {
        $("#lookup").dataTable();
    });


    $(document).ready(function(){
        fetch_request_product();
        function fetch_request_product(query = '')
        {
            $.ajax({
                url:'{{ route("mutasi/action_product.actionProduct") }}',
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
            fetch_request_product(query);
        });
    });

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '#',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    $(function(){
        $('#dari_zona').change(function(){
            var dari_zona_ = $(this).val();
            if(dari_zona_){
                $.ajax({
                    type:"GET",
                    url:"/ajax_zona_mutasi?dari_zona_="+dari_zona_,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#dari_sub_zona").empty();
                            $("#dari_sub_zona").append('<option></option>');
                            $.each(res,function(nama,kode){
                                $("#dari_sub_zona").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#dari_sub_zona").empty();
                        }
                    }
                });
            }else{
                $("#dari_sub_zona").empty();
            }
        });
    });

    $(function(){
        $('#ke_zona').change(function(){
            var ke_zona_ = $(this).val();
            if(ke_zona_){
                $.ajax({
                    type:"GET",
                    url:"/ajax_zona_mutasi_ke?ke_zona_="+ke_zona_,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#ke_sub_zona").empty();
                            $("#ke_sub_zona").append('<option></option>');
                            $.each(res,function(nama,kode){
                                $("#ke_sub_zona").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#ke_sub_zona").empty();
                        }
                    }
                });
            }else{
                $("#ke_sub_zona").empty();
            }
        });
    });



</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Mutasi Internal</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Mutasi</li>
        <li class="breadcrumb-item">Internal</li>
        <li class="breadcrumb-item active">Mutasi Internal</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('mutasi.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Mutasi Internal</h4>
                            </div>
                            <div class="card-body">
                                <div id="form-input-primary">
                                    <div id="form-input-primary" class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-3 mb-2">
                                                Dari Zona
                                                <select name="dari_zona" id="dari_zona" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    @foreach ($area_dari as $row)
                                                        <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Ke Zona 
                                                <select name="ke_zona" id="ke_zona" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    @foreach ($area_ke as $row)
                                                        <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                        
                                            <div class="col-md-3 mb-2">
                                                Dari Sub Zona
                                                <select name="dari_sub_zona" id="dari_sub_zona" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    
                                                </select>

                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Ke Sub Zona
                                                <select name="ke_sub_zona" id="ke_sub_zona" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row" hidden>
                                            
                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <select name="id_checker_primary" class="form-control">
                                                    <option value="">Pilih</option>
                                                    
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <select name="id_checker_primary_bs" class="form-control">
                                                    <option value="">Pilih</option>
                                                   
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                            <form id="savedatas">
                                                <div class="card-body">
                                                <div class="table-responsive">
                                                    <div style="border:1px white;width:100%;height:130px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Product Id</th>
                                                                    <th>Product Name</th>
                                                                    <th>Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Produk</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Produk</button>
                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                                    </div> 
                                                </div>
                                                </div>
                                            </form>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Produk</h5>
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




