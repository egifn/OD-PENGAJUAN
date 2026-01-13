@section('js')


<script type="text/javascript">
    $(document).on('click', '.pilih_bkb', function (e) {
        document.getElementById("bkb").value = $(this).attr('data-szDocId');
        document.getElementById("no_mobil_secondary").value = $(this).attr('data-szVehicleId');
        document.getElementById("id_sopir_secondary").value = $(this).attr('data-szEmployeeId');
        document.getElementById("nama_sopir_secondary").value = $(this).attr('data-szName');

        $('#myModal_bkb').modal('hide');
    });
    
    $(function () {
        $("#lookup_bkb").dataTable();
    });


    $(document).on('click', '.pilih', function (e) {
        var tabel = document.getElementById("tabelinput");
        var row = tabel.insertRow(1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
               
        var a = $(this).attr('data-kode_produk');
        var b = $(this).attr('data-nama_produk');
               
        cell1.innerHTML = '<input name="chk" type="checkbox" />'
        cell2.innerHTML = '<input type="text" class="form-control" name="kode_produk[]" id="kode_produk" style="font-size: 13px;" value="'+a+'" readonly>'
        cell3.innerHTML = '<input type="text" class="form-control" name="nama_produk[]" id="nama_produk" style="font-size: 13px;" value="'+b+'" readonly>'
        cell4.innerHTML = '<input type="number" class="form-control" name="qty[]" id="qty" style="font-size: 13px; text-align: right;" value="0">'
        cell5.innerHTML = '<input type="number" class="form-control" name="qty_layak[]" id="qty_layak" style="font-size: 13px; text-align: right;" value="0">'
        if ($("input[name='kategori']:checked").val() == "Primary" ) {
            cell6.innerHTML = '<input type="number" class="form-control" name="qty_bs[]" id="qty_bs" style="font-size: 13px; text-align: right;" value="0">'
        }else{
            cell6.innerHTML = '<input type="number" class="form-control" name="qty_bs[]" id="qty_bs" style="font-size: 13px; text-align: right;" value="0" readonly>'
        }
         
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
                url:'{{ route("get_out/action_product_out.actionProductOut") }}',
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

    $(document).ready(function(){
        fetch_request_bkb();
        function fetch_request_bkb(query = '')
        {
            $.ajax({
                url:'{{ route("get_out/action_bkb.actionBkb") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_bkb tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_bkb', function(){
            var query = $(this).val();
            fetch_request_bkb(query);
        });
    });

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("get_out.store") }}',
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

    function validasi_input(form){
        if ($("input[name='kategori']:checked").val() == "Primary" ) {
            if (form.surat_jalan.value == ""){
                alert("Surat Jalan harus diisi, saat ini Surat Jalan masih kosong!");
                form.surat_jalan.focus();
                return (false);
            }

            if (form.no_mobil_primary.value == ""){
                alert("No Polisi harus diisi, saat ini No Polisi masih kosong!");
                form.no_mobil_primary.focus();
                return (false);
            }

            if (form.nama_sopir_primary.value == ""){
                alert("Nama Sopir harus diisi, saat ini Nama Sopir masih kosong!");
                form.nama_sopir_primary.focus();
                return (false);
            }

            if (form.pabrik.value == ""){
                alert("Pabrik harus diisi, saat ini Pabrik masih kosong!");
                form.pabrik.focus();
                return (false);
            }

            if (form.zona_primary_layak.value == ""){
                alert("Zona Layak harus diisi, saat ini Zona Layak masih kosong dan belum dipilih!");
                form.zona_primary_layak.focus();
                return (false);
            }  

            if (form.sub_zona_primary_layak.value == ""){
                alert("Sub Zona Layak harus diisi, saat ini Sub Zona Layak masih kosong dan belum dipilih!");
                form.sub_zona_primary_layak.focus();
                return (false);
            }     

            if (form.id_checker_primary.value == ""){
                alert("Nama Checker Layak harus diisi, saat ini Nama Checker Layak masih kosong dan belum dipilih!");
                form.id_checker_primary.focus();
                return (false);
            }

            if (form.zona_primary_bs.value == ""){
                alert("Zona BS harus diisi, saat ini Zona BS masih kosong dan belum dipilih!");
                form.zona_primary_bs.focus();
                return (false);
            }  

            if (form.sub_zona_primary_bs.value == ""){
                alert("Sub Zona BS harus diisi, saat ini Sub Zona BS masih kosong dan belum dipilih!");
                form.sub_zona_primary_bs.focus();
                return (false);
            }     

            if (form.id_checker_primary_bs.value == ""){
                alert("Nama Checker BS harus diisi, saat ini Nama Checker BS masih kosong dan belum dipilih!");
                form.id_checker_primary_bs.focus();
                return (false);
            }              
        }else if ($("input[name='kategori']:checked").val() == "Secondary" ){
            if (form.bkb.value == ""){
                alert("BKB harus diisi, saat ini masih kosong!");
                form.bkb.focus();
                return (false);
            }

            if (form.no_mobil_secondary.value == ""){
                alert("No Polisi harus diisi, saat ini No Polisi masih kosong!");
                form.no_mobil_secondary.focus();
                return (false);
            }

            if (form.nama_sopir_secondary.value == ""){
                alert("Nama Sopir harus diisi, saat ini Nama Sopir masih kosong!");
                form.nama_sopir_secondary.focus();
                return (false);
            }

            if (form.toko.value == ""){
                alert("Toko harus diisi, saat ini Toko masih kosong!");
                form.toko.focus();
                return (false);
            }

            if (form.zona_secondary_layak.value == ""){
                alert("Zona Layak harus diisi, saat ini Zona Layak masih kosong dan belum dipilih!");
                form.zona_secondary_layak.focus();
                return (false);
            }  

            if (form.sub_zona_secondary_layak.value == ""){
                alert("Sub Zona Layak harus diisi, saat ini Sub Zona Layak masih kosong dan belum dipilih!");
                form.sub_zona_secondary_layak.focus();
                return (false);
            }     

            if (form.id_checker_secondary.value == ""){
                alert("Nama Checker Layak harus diisi, saat ini Nama Checker Layak masih kosong dan belum dipilih!");
                form.id_checker_secondary.focus();
                return (false);
            }

            
        }

        return (true);
    }


</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Check and Verify</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Get Out</li>
        <li class="breadcrumb-item">Check and Verify</li>
        <li class="breadcrumb-item active">Check and Verify</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('get_out.store') }}" method="post" onkeypress="return event.keyCode != 13" onsubmit="return validasi_input(this)" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Check and Verify</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <input name="kategori" type="radio" id="primary" value="Primary" class="detail" checked="true"  />
                                        <b>Primary</b>
                                    </div>
                                    @if(Auth::user()->kode_depo == '034-W01' || Auth::user()->kode_depo == '034-W02')
                                        <div class="col-md-2 mb-2" hidden>
                                            <input name="kategori" type="radio" id="secondary" value="Secondary" class="detail"  />
                                            <b>Secondary</b>
                                        </div>
                                    @else
                                        <div class="col-md-2 mb-2">
                                            <input name="kategori" type="radio" id="secondary" value="Secondary" class="detail"  />
                                            <b>Secondary</b>
                                        </div>
                                    @endif
                                    
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

                                            @if(Auth::user()->kode_depo == '034-W01' || Auth::user()->kode_depo == '034-W02')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Zona Layak
                                                    <select name="zona_primary_layak" id="zona_primary_layak" class="form-control">
                                                        <option value="-">-</option>
                                                    </select>
                                                </div>
                                            @else
                                                <div class="col-md-3 mb-2">
                                                    Zona Layak
                                                    <select name="zona_primary_layak" id="zona_primary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            @endif
                                            

                                            <div class="col-md-3 mb-2">
                                                    Zona BS 
                                                    <select name="zona_primary_bs" id="zona_primary_bs" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($area_bs as $row)
                                                            <option value="{{ $row->kode_area }}" {{ old('kode_area') == $row->kode_area ? 'selected':'' }}>{{ $row->nama_area }}</option>
                                                        @endforeach 
                                                    </select>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_primary" id="no_mobil_primary" class="form-control" value="" >
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kode_depo == '034-W01' || Auth::user()->kode_depo == '034-W02')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Sub Zona Layak
                                                    <select name="sub_zona_primary_layak" id="sub_zona_primary_layak" class="form-control">
                                                        <option value="-">-</option>
                        
                                                    </select>

                                                </div>
                                            @else
                                                <div class="col-md-3 mb-2">
                                                    Sub Zona Layak
                                                    <select name="sub_zona_primary_layak" id="sub_zona_primary_layak" class="form-control">
                                                        <option value="">Pilih</option>
                                                        
                                                    </select>

                                                </div>
                                            @endif
                                            
                                            <div class="col-md-3 mb-2">
                                                Sub Zona BS
                                                <select name="sub_zona_primary_bs" id="sub_zona_primary_bs" class="form-control">
                                                    <option value="">Pilih</option>
                                                    
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_primary" id="nama_sopir_primary" class="form-control" value="" >
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            @if(Auth::user()->kode_depo == '034-W01' || Auth::user()->kode_depo == '034-W02')
                                                <div class="col-md-3 mb-2" hidden>
                                                    Nama Checker
                                                    <select name="id_checker_primary" class="form-control">
                                                        <option value="0">-</option> 
                                                    </select>
                                                </div>
                                            @else
                                                <div class="col-md-3 mb-2">
                                                    Nama Checker
                                                    <select name="id_checker_primary" class="form-control">
                                                        <option value="">Pilih</option>
                                                        @foreach ($checker_layak as $row)
                                                            <option value="{{ $row->id_checker }}" {{ old('id_checker') == $row->id_checker ? 'selected':'' }}>{{ $row->nama_checker }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            @endif
                                            

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <select name="id_checker_primary_bs" class="form-control">
                                                    <option value="">Pilih</option>
                                                    @foreach ($checker_bs as $row)
                                                        <option value="{{ $row->id_checker }}" {{ old('id_checker') == $row->id_checker ? 'selected':'' }}>{{ $row->nama_checker }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
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
                                                    <input name="bkb" id="bkb" type="text" class="form-control"> <!-- readonly -->
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_bkb" hidden> <span class="fa fa-search"></span></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Polisi
                                                <input type="text" name="no_mobil_secondary" id="no_mobil_secondary" class="form-control"> <!-- readonly -->
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

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
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2" hidden>
                                                Kode Sopir
                                                <input type="text" name="id_sopir_secondary" id="id_sopir_secondary" class="form-control"> 
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Sopir
                                                <input type="text" name="nama_sopir_secondary" id="nama_sopir_secondary" class="form-control"> <!-- readonly -->
                                            </div>

                                            <div class="col-md-2 mb-2">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                Nama Checker
                                                <select name="id_checker_secondary" class="form-control">
                                                    <option value="">Pilih</option>
                                                    @foreach ($checker_layak as $row)
                                                        <option value="{{ $row->id_checker }}" {{ old('id_checker') == $row->id_checker ? 'selected':'' }}>{{ $row->nama_checker }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2" hidden>
                                                Nama Checker
                                                <select name="id_checker_secondary_bs" class="form-control">
                                                    <option value="">Pilih</option>
                                                    @foreach ($checker_bs as $row)
                                                        <option value="{{ $row->id_checker }}" {{ old('id_checker') == $row->id_checker ? 'selected':'' }}>{{ $row->nama_checker }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Toko/Outlet
                                                <input type="text" name="toko" id="toko" class="form-control" >
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
                                                                    <th>Qty All</th>
                                                                    <th>Qty Layak</th>
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
                <form action="#" method="get" >
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

<div class="modal fade bd-example-modal-lg" id="myModal_bkb" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">BKB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" onkeypress="return event.keyCode != 13">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_bkb" id="search_bkb" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_bkb" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No BKB</th>
                                <th>No Pol</th>
                                <th>Kode Sopir</th>
                                <th>Nama Sopir</th>

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




