@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        var addButton = $('#add_button'); 
        var wrapper = $('.field_wrapper'); 
        var x = 1;
        $(addButton).click(function(){
            x++;
            $(wrapper).append('<div class="form-group"><div class="row"><div class="col-md-3 mb-2"></div><div class="col-md-3 mb-2">Depo<div class="input-group"><input id="kode_depo_'+x+'" type="text" class="form-control" name="kode_depo[]" readonly><input id="nama_depo_'+x+'" type="text" class="form-control" name="nama_depo[]" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalDepo"><span class="fa fa-search"></span></button></span></div></div><div class="col-md-3 mb-2">Rupiah<input type="text" style="text-align: right;" name="nominal[]" class="form-control" id="nominal_'+x+'"/></div><div class="col-md-1 mb-2"><br><a class="remove_button btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'); 

            $('#nominal_'+x+'').maskMoney({thousands:',', decimal:'.', precision:0});
        });                 

        var y = 1;
        var total_1 = 0;
        $('#lookup_depo').on('click', 'tbody tr', function(e){
            if(y=x){
                e.preventDefault();
                $('#kode_depo_'+y+'').val($(this).find('td').html());
                $('#nama_depo_'+y+'').val($(this).find('td').next().html());
                $('#myModalDepo').modal('hide'); 
            }else{
                var total = 0;
                y++;
                $('#kode_depo_'+y+'').val($(this).find('td').html());
                $('#nama_depo_'+y+'').val($(this).find('td').next().html());
                $('#myModalDepo').modal('hide'); 
            }
        });


        $(wrapper).on('click', '.remove_button', function(e){
            if (confirm("Anda yakin akan menghapus baris ini?")) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); 
                x--; 
            }
        
        });
    });

    $(document).ready(function(){
        var addButton_box = $('#add_button_box'); 
        var wrapper_box = $('.field_wrapper_box'); 
        var x = 1;
        $(addButton_box).click(function(){
            x++;
            $(wrapper_box).append('<div class="form-group"><div class="row"><div class="col-md-3 mb-2"></div><div class="col-md-2 mb-2">Nama Customer<input type="text" name="cus[]" class="form-control" id="cus_'+x+'"/></div><div class="col-md-2 mb-2">SKU/Produk<div class="input-group"><input id="kode_sku_'+x+'" name="kode_sku[]" type="text" class="form-control" readonly hidden><input id="nama_sku_'+x+'" name="nama_sku[]" type="text" class="form-control" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalSku"> <span class="fa fa-search"></span></button></span></div></div><div class="col-md-1 mb-2">Jumlah<input type="text" style="text-align: right;" name="jumlah[]" class="form-control" id="jumlah_'+x+'" value="0"></div><div class="col-md-1 mb-2">Harga<input type="text" style="text-align: right;" id="harga_'+x+'" name="harga[]" class="form-control" value="0"></div><div class="col-md-1 mb-2"><br><a class="remove_button btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'); 

            $('#harga_'+x+'').maskMoney({thousands:',', decimal:'.', precision:0});
        });                 

        var y = 1;
        var total_1 = 0;
        $('#lookup_sku').on('click', 'tbody tr', function(e){
            if(y=x){
                e.preventDefault();
                $('#kode_sku_'+y+'').val($(this).find('td').html());
                $('#nama_sku_'+y+'').val($(this).find('td').next().html());
                $('#myModalSku').modal('hide'); 
            }else{
                var total = 0;
                y++;
                $('#kode_sku_'+y+'').val($(this).find('td').html());
                $('#nama_sku_'+y+'').val($(this).find('td').next().html());
                $('#myModalSku').modal('hide'); 
            }
        });


        $(wrapper_box).on('click', '.remove_button', function(e){
            if (confirm("Anda yakin akan menghapus baris ini?")) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); 
                x--; 
            }
        
        });
    });

    $('#nominal_1').maskMoney({thousands:',', decimal:'.', precision:0});
    $('#harga_1').maskMoney({thousands:',', decimal:'.', precision:0});

    $(document).ready(function(){
        fetch_depo_data();
        function fetch_depo_data(query = '')
        {
            $.ajax({
                url:'{{ route("isi_surat/action_depo.actionDepo") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_depo tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_depo', function(){
            var query = $(this).val();
            fetch_depo_data(query);
        });
    });

    $(document).ready(function(){
        fetch_sku_data();
        function fetch_sku_data(query = '')
        {
            $.ajax({
                url:'{{ route("isi_surat/action_sku.actionSku") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_sku tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_depo', function(){
            var query = $(this).val();
            fetch_sku_data(query);
        });
    });

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("isi_surat/store.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        })
    });

    function show_my_pdf() {
        var retVal = confirm("Do you want to continue to print?");
        if( retVal == true ) {
            window.open('{{ route("isi_surat/pdf.pdf", $no_urut) }}', '_blank');    
        }
    }

    $(document).ready(function(){
        if ($("input[name='jenis']:checked").val() == "rupiah" ) {
            $("#form-input-rupiah").show();
            $("#form-input-box").hide();
        }else{
            $("#form-input-rupiah").hide();
            $("#form-input-box").show();
        }
        $(".detail").click(function(){ 
            if ($("input[name='jenis']:checked").val() == "rupiah" ) { 
                $("#form-input-rupiah").slideDown("fast");
                $("#form-input-box").slideUp("fast"); 
                // document.getElementById("kode_depo_1").value = "";
                // document.getElementById("nama_depo_1").value = "";
                // document.getElementById("nominal_1").value = "";
            }else{
                $("#form-input-rupiah").slideUp("fast");
                $("#form-input-box").slideDown("fast"); 
                // document.getElementById("kode_depo_box_1").value = "";
                // document.getElementById("nama_depo_box_1").value = "";
                // document.getElementById("box_1").value = "";
            }
        });
    });

    $(document).ready(function(){
        if ($("input[name='chk']:checked").val() == "chk" ) {
            $("#form-input-ext").show();
        }else{
            $("#form-input-ext").hide();
        }
        $(".detail").click(function(){ 
            if ($("input[name='chk']:checked").val() == "chk" ) { 
                $("#form-input-ext").slideDown("fast"); 
            }else{
                $("#form-input-ext").slideUp("fast"); 
            }
        });
    });

    $(document).ready(function(){
        if ($("input[name='chk_2']:checked").val() == "chk_2" ) {
            $("#form-input-ext2").show();
        }else{
            $("#form-input-ext2").hide();
        }
        $(".detail").click(function(){ 
            if ($("input[name='chk_2']:checked").val() == "chk_2" ) { 
                $("#form-input-ext2").slideDown("fast"); 
            }else{
                $("#form-input-ext2").slideUp("fast"); 
            }
        });
    });
</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Buat Surat</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Surat</li>
        <li class="breadcrumb-item">Buat Surat</li>
        <li class="breadcrumb-item active">Buat Surat</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('isi_surat/store.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Buat Surat</h4>
                            </div>
                            <div class="card-body">
                            	<div class="row">
                                    <div class="col-md-3 mb-2">
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $no_urut }}" required hidden>    
                                    </div>
                                        
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                            <option value="">Pilih</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach    
                                        </select>
                                    </div>
                                        
                                    <div class="col-md-2 mb-2">
                                        Tanggal
                                        <input type="date" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Prihal
                                        <input type="text" name="prihal" id="prihal" class="form-control" required>
                                    </div>
                                        
                                </div>
                                   
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Id Promo
                                        <input type="text" name="id_promo" id="id_promo" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-1 mb-2">
                                       <input name="jenis" type="radio" id="rupiah" value="rupiah" class="detail" checked="true"  />
                                       Rupiah
                                    </div>
                                    <div class="col-md-1 mb-2">
                                       <input name="jenis" type="radio" id="box" value="box" class="detail"  />
                                       Box
                                    </div> 
                                </div>

                                <div id="form-input-rupiah">
                                    <div class="field_wrapper">
                                        <div id="form-input-rupiah" class="row">
                                            <div class="col-md-3 mb-2">
                                            
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Depo
                                                <div class="input-group">
                                                    <input id="kode_depo_1" name="kode_depo[]" type="text" class="form-control" readonly>
                                                    <input id="nama_depo_1" name="nama_depo[]" type="text" class="form-control" readonly>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalDepo"> <span class="fa fa-search"></span></button>
                                                    </span>

                                                </div>
                                            </div> 
                                            <div class="col-md-3 mb-2">
                                                Rupiah
                                                <input type="text" style="text-align: right;" id="nominal_1" name="nominal[]" class="form-control" value="">
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <br>
                                                <a class="btn btn-warning" href="javascript:void(0);" id="add_button" title="Tambah Depo">+</a>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="form-input-box">
                                    <div class="field_wrapper_box">
                                        <div id="form-input-box" class="row">
                                            <div class="col-md-3 mb-2">
                                            
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                Nama Customer
                                                <input type="text" id="cus_1" name="cus[]" class="form-control" value="">
                                            </div> 
                                            <div class="col-md-2 mb-2">
                                                SKU/Produk
                                                <div class="input-group">
                                                    <input id="kode_sku_1" name="kode_sku[]" type="text" class="form-control" readonly hidden>
                                                    <input id="nama_sku_1" name="nama_sku[]" type="text" class="form-control" readonly>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalSku"> <span class="fa fa-search"></span></button>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                Jumlah
                                                <input type="text" style="text-align: right;" id="jumlah_1" name="jumlah[]" class="form-control" value="0">
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                Harga
                                                <input type="text" style="text-align: right;" id="harga_1" name="harga[]" class="form-control" value="0">
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <br>
                                                <a class="btn btn-warning" href="javascript:void(0);" id="add_button_box" title="Tambah Depo">+</a>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="form-terhitung" class="row">
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Dokumen
                                        <input type="text" name="dokumen" id="dokumen" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="checkbox" name="chk" id="chk" value="chk" class="detail"> &nbsp;Tambah Menyetujui
                                    </div>
                                </div>

                                <div id="form-input-ext">
                                    <div id="form-input-ext" class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Menyetujui
                                            <input type="text" name="menyetujui" id="menyetujui" class="form-control">
                                        </div>
                                    </div>
                                    <div id="form-input-ext" class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Bagian
                                            <input type="text" name="bagian" id="bagian" class="form-control">
                                        </div>
                                    </div>
                                    <div id="form-input-ext" class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="checkbox" name="chk_2" id="chk_2" value="chk_2" class="detail"> &nbsp;Tambah Menyetujui
                                        </div>
                                    </div>
                                </div>

                                <div id="form-input-ext2">
                                    <div id="form-input-ext2" class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Menyetujui (2)
                                            <input type="text" name="menyetujui_2" id="menyetujui_2" class="form-control">
                                        </div>
                                    </div>
                                    <div id="form-input-ext2" class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Bagian (2)
                                            <input type="text" name="bagian_2" id="bagian_2" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                       
                                    <div class="col-md-2 mb-2">
                                           
                                    </div>
                                        
                                    <div class="col-md-3 mb-2">
                                        <br>
                                        <button class="btn btn-primary btn-sm" onclick="show_my_pdf()">Buat Surat</button>
                                    </div> 

                                    <div class="col-md-2 mb-2" hidden>
                                            
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                            
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

<div class="modal fade bd-example-modal-lg" id="myModalDepo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Master Depo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_depo" id="cari_depo" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_depo" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Depo</th>
                                <th>Nama Depo</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalSku" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SKU/Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_sku" id="cari_Sku" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_sku" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode SKU</th>
                                <th>Nama SKU</th>
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