@section('js')


<script type="text/javascript">

    $(document).on('click', '.pilih', function (e) {
        var tabel = document.getElementById("tabelinput");
        var row = tabel.insertRow(1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        
               

        var a = $(this).attr('data-kode_produk');
        var b = $(this).attr('data-nama_produk');
               
        cell1.innerHTML = '<input name="chk" type="checkbox" />'
        cell2.innerHTML = '<input type="text" class="form-control" name="kode_produk[]" id="kode_produk" style="font-size: 13px;" value="'+a+'" readonly>'
        cell3.innerHTML = '<input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="font-size: 13px;" value="'+b+'" readonly>'
        cell4.innerHTML = '<input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right;" value="">'
        cell5.innerHTML = '<input type="number" class="form-control" name="qty_layak_bs[]" id="qty_layak_bs" style="font-size: 13px; text-align: right;" value="">'
         
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
        if ($("input[name='kategori']:checked").val() == "Primary" ) {
            $("#form-input-secondary").hide();
            $("#form-input-primary").show();
        }else{
            $("#form-input-secondary").show();
            $("#form-input-primary").hide();
        }
        $(".detail").click(function(){
            if ($("input[name='kategori']:checked").val() == "Primary" ) {
                $("#form-input-primary").slideDown("fast"); 
                $("#form-input-secondary").slideUp("fast"); 
            }else{
                $("#form-input-primary").slideUp("fast"); 
                $("#form-input-secondary").slideDown("fast"); 
            }
        });
    });

     $(document).ready(function(){
        fetch_request_product();
        function fetch_request_product(query = '')
        {
            $.ajax({
                url:'{{ route("get_in/action_product.actionProduct") }}',
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
            url: '{{ route("check_control_out.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    $(function(){
        $('#zona_primary_layak').change(function(){
            var zona_primary_layak_id = $(this).val();
            if(zona_primary_layak_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax_zona_primary_layak?zona_primary_layak_id="+zona_primary_layak_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#sub_zona_primary_layak").empty();
                            $("#sub_zona_primary_layak").append('<option>Pilih</option>');
                            $.each(res,function(nama,kode){
                                $("#sub_zona_primary_layak").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#sub_zona_primary_layak").empty();
                        }
                    }
                });
            }else{
                $("#sub_zona_primary_layak").empty();
            }
        });
    });

    $(function(){
        $('#zona_primary_bs').change(function(){
            var zona_primary_bs_id = $(this).val();
            if(zona_primary_bs_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax_zona_primary_bs?zona_primary_bs_id="+zona_primary_bs_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#sub_zona_primary_bs").empty();
                            $("#sub_zona_primary_bs").append('<option>Pilih</option>');
                            $.each(res,function(nama,kode){
                                $("#sub_zona_primary_bs").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#sub_zona_primary_bs").empty();
                        }
                    }
                });
            }else{
                $("#sub_zona_primary_bs").empty();
            }
        });
    });

    $(function(){
        $('#zona_secondary_layak').change(function(){
            var zona_secondary_layak_id = $(this).val();
            if(zona_secondary_layak_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax_zona_secondary_layak?zona_secondary_layak_id="+zona_secondary_layak_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#sub_zona_secondary_layak").empty();
                            $("#sub_zona_secondary_layak").append('<option>Pilih</option>');
                            $.each(res,function(nama,kode){
                                $("#sub_zona_secondary_layak").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#sub_zona_secondary_layak").empty();
                        }
                    }
                });
            }else{
                $("#sub_zona_secondary_layak").empty();
            }
        });
    });

    $(function(){
        $('#zona_secondary_bs').change(function(){
            var zona_secondary_bs_id = $(this).val();
            if(zona_secondary_bs_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax_zona_secondary_bs?zona_secondary_bs_id="+zona_secondary_bs_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#sub_zona_secondary_bs").empty();
                            $("#sub_zona_secondary_bs").append('<option>Pilih</option>');
                            $.each(res,function(nama,kode){
                                $("#sub_zona_secondary_bs").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#sub_zona_secondary_bs").empty();
                        }
                    }
                });
            }else{
                $("#sub_zona_secondary_bs").empty();
            }
        });
    });


</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Check Control Sheet</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Get Out</li>
        <li class="breadcrumb-item">Check Control Sheet</li>
        <li class="breadcrumb-item active">Check Control Sheet</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('check_control_out.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Check Control Sheet</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <input name="kategori" type="radio" id="primary" value="Primary" class="detail" checked="true"  />
                                        <b>Primary</b>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <input name="kategori" type="radio" id="secondary" value="Secondary" class="detail"  />
                                        <b>Secondary</b>
                                    </div>
                                </div>

                                <div id="form-input-primary">
                                    <div id="form-input-primary" class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Surat Jalan
                                                <input type="text" name="surat_jalan" id="surat_jalan" class="form-control" value=""    >
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                                <div class="col-md-3 mb-2">
                                                    Zona Layak
                                                    <select name="zona_primary_layak" id="zona_primary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-2" hidden>
                                                    Zona BS 
                                                    <select name="zona_primary_bs" id="zona_primary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row-> kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Zona Layak
                                                    <select name="zona_primary_layak" id="zona_primary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    Zona BS 
                                                    <select name="zona_primary_bs" id="zona_primary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row-> kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            @endif

                                            <div class="col-md-3 mb-2">
                                                Kode Produksi
                                                <input type="text" name="kode_produksi_primary" id="kode_produksi_primary" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_primary" id="no_mobil_primary" class="form-control" value="" >
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                                <div class="col-md-3 mb-2">
                                                    Sub Zona Layak
                                                    <select name="sub_zona_primary_layak" id="sub_zona_primary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>

                                                </div>

                                                <div class="col-md-3 mb-2" hidden>
                                                    Sub Zona BS
                                                    <select name="sub_zona_primary_bs" id="sub_zona_primary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>
                                                </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Sub Zona Layak
                                                    <select name="sub_zona_primary_layak" id="sub_zona_primary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>

                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    Sub Zona BS
                                                    <select name="sub_zona_primary_bs" id="sub_zona_primary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>
                                                </div>
                                            @endif
                                            

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_primary" id="nama_sopir_primary" class="form-control" value="" >
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                                <div class="col-md-3 mb-2">
                                                    Nama Checker
                                                    <input type="text" name="nama_checker_primary" id="nama_checker_primary" class="form-control" value="{{ $checker->nama_checker }}" readonly>
                                                </div>

                                                <div class="col-md-3 mb-2" hidden>
                                                    Nama Checker
                                                    <input type="text" name="nama_checker_primary_bs" id="nama_checker_primary_bs" class="form-control" value="" readonly>
                                                </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Nama Checker
                                                    <input type="text" name="nama_checker_primary" id="nama_checker_primary" class="form-control" value="" readonly>
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    Nama Checker
                                                    <input type="text" name="nama_checker_primary_bs" id="nama_checker_primary_bs" class="form-control" value="{{ $checker->nama_checker }}" readonly>
                                                </div>
                                            @endif
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Pabrik
                                                <input type="text" name="pabrik" id="pabrik" class="form-control" value="" >
                                            </div>
                                        </div>


                                        
                                    </div>
                                </div>

                                <div id="form-input-secondary">
                                    <div id="form-input-secondary" class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                BKB
                                                <div class="input-group">
                                                    <input name="bkb" id="bkb" type="text" class="form-control"  > <!-- readonly -->
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_bkb" hidden> <span class="fa fa-search"></span></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                                <div class="col-md-3 mb-2">
                                                    Zona Layak
                                                    <select name="zona_secondary_layak" id="zona_secondary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-2" hidden>
                                                    Zona BS 
                                                    <select name="zona_secondary_bs" id="zona_secondary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Zona Layak
                                                    <select name="zona_secondary_layak" id="zona_secondary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    Zona BS 
                                                    <select name="zona_secondary_bs" id="zona_secondary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            @endif

                                            <div class="col-md-3 mb-2">
                                                Kode Produksi
                                                <input type="text" name="kode_produksi_secondary" id="kode_produksi_secondary" class="form-control" value="" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_secondary" id="no_mobil_secondary" class="form-control" value="" > <!-- readonly -->
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                                <div class="col-md-3 mb-2">
                                                    Sub Zona Layak
                                                    <select name="sub_zona_secondary_layak" id="sub_zona_secondary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>

                                                </div>

                                                <div class="col-md-3 mb-2" hidden>
                                                    Sub Zona BS
                                                    <select name="sub_zona_secondary_bs" id="sub_zona_secondary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>
                                                </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Sub Zona Layak
                                                    <select name="sub_zona_secondary_layak" id="sub_zona_secondary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>

                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    Sub Zona BS
                                                    <select name="sub_zona_secondary_bs" id="sub_zona_secondary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                    
                                                    </select>
                                                </div>
                                            @endif
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2" hidden>
                                                Kode Sopir
                                                <input type="text" name="id_sopir_secondary" id=" id_sopir_secondary" class="form-control" value="" readonly> 
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_secondary" id=" nama_sopir_secondary" class="form-control" value="" > <!-- readonly -->
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kategori == 'Layak')
                                                <div class="col-md-3 mb-2">
                                                    Nama Checker
                                                    <input type="text" name="nama_checker_secondary" id=" nama_checker_secondary" class="form-control" value="{{ $checker->nama_checker }}" readonly> 
                                                </div>

                                                <div class="col-md-3 mb-2" hidden>
                                                    Checker Name
                                                    <input type="text" name="nama_checker_secondary_bs" id=" nama_checker_secondary_bs" class="form-control" value="" readonly>
                                                </div>
                                            @elseif(Auth::user()->kategori == 'BS')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Nama Checker
                                                    <input type="text" name="nama_checker_secondary" id=" nama_checker_secondary" class="form-control" value="" readonly> 
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    Checker Name
                                                    <input type="text" name="nama_checker_secondary_bs" id=" nama_checker_secondary_bs" class="form-control" value="{{ $checker->nama_checker }}" readonly>
                                                </div>
                                            @endif
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Toko/Outlet
                                                <input type="text" name="toko" id="toko" class="form-control" value="" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @if(Auth::user()->kategori == 'Layak')
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
                                                                    <th>Qty All</th>
                                                                    <th>Qty Layak</th>
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
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Choose Product</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Delete Product</button>
                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S a v e</button>
                                                    </div> 
                                                </div>
                                                </div>
                                            </form>
                                    @elseif(Auth::user()->kategori == 'BS')
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
                                                                    <th>Qty All</th>
                                                                    <th>Qty BS</th>
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
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Choose Product</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Delete Product</button>
                                                    </div>  
                                  
                                                    <div class="col-md-8 mb-2">
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S a v e</button>
                                                    </div> 
                                                </div>
                                                </div>
                                            </form>
                                    @endif
                                              
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




