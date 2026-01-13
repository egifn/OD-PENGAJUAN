@section('js')
<script type="text/javascript">

    $(document).ready(function(){
    var addButton = $('#add_button'); 
    var wrapper = $('.field_wrapper'); 
    var x = 1; 
        $(addButton).click(function(){
            x++;
            $(wrapper).append('<div class="form-group add"><div class="row"><div class="col-md-4 mb-2">No. SPP<div class="input-group"><input id="nospp_'+x+'" type="text" class="form-control" name="nospp[]" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalspp"><span class="fa fa-search"></span></button></span></div></div><div class="col-md-4 mb-2">Keterangan SPP<input type="text" name="ketspp[]" class="form-control" id="ketspp_'+x+'" readonly ></div><div class="col-md-3 mb-2">Total SPP<input type="text" style="text-align: right;" name="nominalspp[]" class="form-control" id="nominalspp_'+x+'" readonly/></div><div class="col-md-1 mb-2" align="right"><br><a class="remove_button btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'); 
        });

        var y = 1;
        var total_1 = 0;
        $('#lookup_spp').on('click', 'tbody tr', function(e){
            if($("input[name='radio']:checked").val() == "satu" ) {
                if(y=x){
                    e.preventDefault();
                    $('#nospp_'+y+'').val($(this).find('td').html());
                    $('#ketspp_'+y+'').val($(this).find('td').next().next().next().html());
                    $('#nominalspp_'+y+'').val($(this).find('td').next().next().html());
                    $('#nominalcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalspp').modal('hide'); 
                }else{
                    var total = 0;
                    y++;
                    $('#nospp_'+y+'').val($(this).find('td').html());
                    $('#ketspp_'+y+'').val($(this).find('td').next().next().next().html());
                    $('#nominalspp_'+y+'').val($(this).find('td').next().next().html());
                    $('#nominalcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalspp').modal('hide'); 
                }
            }else if($("input[name='radio']:checked").val() == "dua" ) {
                if(y=x){
                    var total =0;
                    e.preventDefault();
                    $('#nospp_'+y+'').val($(this).find('td').html());
                    $('#ketspp_'+y+'').val($(this).find('td').next().next().next().html());
                    $('#nominalspp_'+y+'').val($(this).find('td').next().next().html());
                    //str_replace(",", "", $request->get('total'))
                    //$('#nominalcek_'+y+'').val($(this).find('td').next().next().html());
                    var total = $('#nominalspp_'+y+'').val();
                    $('#myModalspp').modal('hide'); 
                }else{
                    var total =0;
                    y++;
                    $('#nospp_'+y+'').val($(this).find('td').html());
                    $('#ketspp_'+y+'').val($(this).find('td').next().next().next().html());
                    $('#nominalspp_'+y+'').val($(this).find('td').next().next().html());
                    //$('#nominalcek_'+y+'').val($(this).find('td').next().next().html());
                    var total = $('#nominalspp_'+y+'').val();
                    $('#myModalspp').modal('hide'); 
                }
                var totalTanpaKoma = total.replace(/,/g, '');
                total_1 = parseInt(total_1) + parseInt(totalTanpaKoma);

                //membuat format rupiah//
                var reverse_total = total_1.toString().split('').reverse().join(''),
                ribuan_total  = reverse_total.match(/\d{1,3}/g);
                total_rupiah = ribuan_total.join(',').split('').reverse().join('');
                //End membuat format rupiah//
                
                $('#nominalcek_dua').val(total_rupiah);
            }else if($("input[name='radio']:checked").val() == "tiga" ) {
                if(y=x){
                    e.preventDefault();
                    $('#nospp_'+y+'').val($(this).find('td').html());
                    $('#ketspp_'+y+'').val($(this).find('td').next().next().next().html());
                    $('#nominalspp_'+y+'').val($(this).find('td').next().next().html());
                    //$('#nominalcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalspp').modal('hide'); 
                }else{
                    y++;
                    $('#nospp_'+y+'').val($(this).find('td').html());
                    $('#ketspp_'+y+'').val($(this).find('td').next().next().next().html());
                    $('#nominalspp_'+y+'').val($(this).find('td').next().next().html());
                    //$('#nominalcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalspp').modal('hide'); 
                }
            }
        });
    
        $(wrapper).on('click', '.remove_button', function(e){
            if (confirm("Are you sure you want to delete this line?")) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); 
                x--; 
            }
        
        });
    });


    $(document).ready(function(){
    var addButton = $('#add_button_2'); 
    var wrapper = $('.field_wrapper_2 '); 
    var x = 1; 
        $(addButton).click(function(){
            x++;
            $(wrapper).append('<div class="form-group add"><div class="row"><div class="col-md-4 mb-2">No. Cek/Giro<div class="input-group"><input id="nocekgiro_'+x+'" type="text" class="form-control" name="nocekgiro[]" readonly><input id="id_nocekgiro_'+x+'" type="hidden" class=form-control" name="id_nocekgiro[]" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalcekgiro"><span class="fa fa-search"></span></button></span></div></div><div class="col-md-4 mb-2">Total Cek/Giro<input type="text" style="text-align: right;" name="nominalcek[]" class="form-control" id="nominalcek_'+x+'" readonly ></div><div class="col-md-3 mb-2">Tgl. Cek/Giro<input type="date" name="tglcek[]" class="form-control" id="tglcek_'+x+'" readonly/></div><div class="col-md-1 mb-2" align="right"><br><a class="remove_button_2 btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'); 
        });
    
        var y = 1;
        $('#lookup_cekgiro').on('click', 'tbody tr', function(e){
            if($("input[name='radio']:checked").val() == "satu" ) {
                if(y=x){
                    e.preventDefault();
                    $('#id_nocekgiro_'+y+'').val($(this).find('td').html());
                    $('#nocekgiro_'+y+'').val($(this).find('td').next().html());
                    $('#tglcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalcekgiro').modal('hide'); 
                }else{
                    y++;
                    $('#id_nocekgiro_'+y+'').val($(this).find('td').html());
                    $('#nocekgiro_'+y+'').val($(this).find('td').next().html());
                    $('#tglcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalcekgiro').modal('hide'); 
                }
            }else if($("input[name='radio']:checked").val() == "dua" ) {
                e.preventDefault();
                $('#id_nocekgiro_dua').val($(this).find('td').html());
                $('#nocekgiro_dua').val($(this).find('td').next().html());
                $('#tglcek_dua').val($(this).find('td').next().next().html());
                $('#myModalcekgiro').modal('hide'); 
            }else if($("input[name='radio']:checked").val() == "tiga" ) {

            }
            
        });
   
    
        $(wrapper).on('click', '.remove_button_2', function(e){
            if (confirm("Are you sure you want to delete this line?")) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); 
                x--; 
            }
        
        });
    });

    $(document).ready(function(){
    var addButton = $('#add_button_3'); 
    var wrapper = $('.field_wrapper_3 '); 
    var x = 1; 
        $(addButton).click(function(){
            x++;
            $(wrapper).append('<div class="form-group add"><div class="row"><div class="col-md-4 mb-2">No. Cek/Giro<div class="input-group"><input id="nocekgiro_tiga_'+x+'" type="text" class="form-control" name="nocekgiro_tiga[]" readonly><input id="id_nocekgiro_tiga_'+x+'" type="hidden" class=form-control" name="id_nocekgiro_tiga[]" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalcekgiro"><span class="fa fa-search"></span></button></span></div></div><div class="col-md-4 mb-2">Total Cek/Giro<input type="text" style="text-align: right;" name="nominalcek_tiga[]" class="form-control" id="nominalcek_tiga_'+x+'"></div><div class="col-md-3 mb-2">Tgl. Cek/Giro<input type="date" name="tglcek_tiga[]" class="form-control" id="tglcek_tiga_'+x+'" readonly/></div><div class="col-md-1 mb-2" align="right"><br><a class="remove_button_3 btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'); 
        });
    
        var y = 1;
        $('#lookup_cekgiro').on('click', 'tbody tr', function(e){
            if($("input[name='radio']:checked").val() == "satu" ) {
                if(y=x){
                    e.preventDefault();
                    $('#id_nocekgiro_'+y+'').val($(this).find('td').html());
                    $('#nocekgiro_'+y+'').val($(this).find('td').next().html());
                    $('#tglcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalcekgiro').modal('hide'); 
                }else{
                    y++;
                    $('#id_nocekgiro_'+y+'').val($(this).find('td').html());
                    $('#nocekgiro_'+y+'').val($(this).find('td').next().html());
                    $('#tglcek_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalcekgiro').modal('hide'); 
                }
            }else if($("input[name='radio']:checked").val() == "dua" ) {
                e.preventDefault();
                $('#id_nocekgiro_dua').val($(this).find('td').html());
                $('#nocekgiro_dua').val($(this).find('td').next().html());
                $('#tglcek_dua').val($(this).find('td').next().next().html());
                $('#myModalcekgiro').modal('hide'); 
            }else if($("input[name='radio']:checked").val() == "tiga" ) {
                if(y=x){
                    e.preventDefault();
                    $('#id_nocekgiro_tiga_'+y+'').val($(this).find('td').html());
                    $('#nocekgiro_tiga_'+y+'').val($(this).find('td').next().html());
                    $('#tglcek_tiga_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalcekgiro').modal('hide'); 
                }else{
                    y++;
                    $('#id_nocekgiro_tiga_'+y+'').val($(this).find('td').html());
                    $('#nocekgiro_tiga_'+y+'').val($(this).find('td').next().html());
                    $('#tglcek_tiga_'+y+'').val($(this).find('td').next().next().html());
                    $('#myModalcekgiro').modal('hide'); 
                }
            }
            
        });
   
    
        $(wrapper).on('click', '.remove_button_3', function(e){
            if (confirm("Are you sure you want to delete this line?")) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); 
                x--; 
            }
        
        });
    });

    $(document).ready(function(){
        if ($("input[name='radio']:checked").val() == "satu" ) {
            $("#form-input").show();
            $("#form-input-satu").show();
            $("#form-input-dua").hide();
            $("#form-input-tiga").hide();
            $("#add_button").show();
        }else if ($("input[name='radio']:checked").val() == "dua" ) {
            $("#form-input").show();
            $("#form-input-satu").hide();
            $("#form-input-dua").show();
            $("#form-input-tiga").hide();
            $("#add_button").show();
        }else if ($("input[name='radio']:checked").val() == "tiga" ) {
            $("#form-input").hide();
            $("#form-input-satu").hide();
            $("#form-input-dua").hide();
            $("#form-input-tiga").show();
            $("#add_button").hide();
        }
        var disabled = false;
        $(".detail").click(function(){ 
            if ($("input[name='radio']:checked").val() == "satu" ) { 
                $("#form-input").slideDown("fast");
                $("#form-input-satu").slideDown("fast"); 
                $("#form-input-dua").slideUp("fast");
                $('#form-input-tiga').slideUp("fast");
                $("#add_button").show();

                document.getElementById("nospp_1").value = "";
                document.getElementById("ketspp_1").value = "";
                document.getElementById("nominalspp_1").value = "";

                document.getElementById("nocekgiro_1").value = "";
                document.getElementById("id_nocekgiro_1").value = "";
                document.getElementById("nominalcek_1").value = "";
                document.getElementById("tglcek_1").value = "";
                
                document.getElementById("nocekgiro_dua").value = "";
                document.getElementById("id_nocekgiro_dua").value = "";
                document.getElementById("nominalcek_dua").value = "";
                document.getElementById("tglcek_dua").value = "";

                document.getElementById("nospp_tiga").value = "";
                document.getElementById("ketspp_tiga").value = "";
                document.getElementById("nominalspp_tiga").value = "";

                document.getElementById("nocekgiro_tiga_1").value = "";
                document.getElementById("id_nocekgiro_tiga_1").value = "";
                document.getElementById("nominalcek_tiga_1").value = "";
                document.getElementById("tglcek_tiga_1").value = "";
            } else if ($("input[name='radio']:checked").val() == "dua" ) {
                $("#form-input").slideDown("fast");
                $("#form-input-satu").slideUp("fast"); 
                $("#form-input-dua").slideDown("fast");
                $('#form-input-tiga').slideUp("fast");
                $("#add_button").show();

                document.getElementById("nospp_1").value = "";
                document.getElementById("ketspp_1").value = "";
                document.getElementById("nominalspp_1").value = "";

                document.getElementById("nocekgiro_1").value = "";
                document.getElementById("id_nocekgiro_1").value = "";
                document.getElementById("nominalcek_1").value = "";
                document.getElementById("tglcek_1").value = "";
                
                document.getElementById("nocekgiro_dua").value = "";
                document.getElementById("id_nocekgiro_dua").value = "";
                document.getElementById("nominalcek_dua").value = "";
                document.getElementById("tglcek_dua").value = "";

                document.getElementById("nospp_tiga").value = "";
                document.getElementById("ketspp_tiga").value = "";
                document.getElementById("nominalspp_tiga").value = "";

                document.getElementById("nocekgiro_tiga_1").value = "";
                document.getElementById("id_nocekgiro_tiga_1").value = "";
                document.getElementById("nominalcek_tiga_1").value = "";
                document.getElementById("tglcek_tiga_1").value = "";
            } else {
                $("#form-input").slideUp("fast");
                $("#form-input-satu").slideUp("fast"); 
                $('#form-input-dua').slideUp("fast");
                $("#form-input-tiga").slideDown("fast");
                $("#add_button").hide();

                document.getElementById("nospp_1").value = "";
                document.getElementById("ketspp_1").value = "";
                document.getElementById("nominalspp_1").value = "";

                document.getElementById("nocekgiro_1").value = "";
                document.getElementById("id_nocekgiro_1").value = "";
                document.getElementById("nominalcek_1").value = "";
                document.getElementById("tglcek_1").value = "";
                
                document.getElementById("nocekgiro_dua").value = "";
                document.getElementById("id_nocekgiro_dua").value = "";
                document.getElementById("nominalcek_dua").value = "";
                document.getElementById("tglcek_dua").value = "";

                document.getElementById("nospp_tiga").value = "";
                document.getElementById("ketspp_tiga").value = "";
                document.getElementById("nominalspp_tiga").value = "";

                document.getElementById("nocekgiro_tiga_1").value = "";
                document.getElementById("id_nocekgiro_tiga_1").value = "";
                document.getElementById("nominalcek_tiga_1").value = "";
                document.getElementById("tglcek_tiga_1").value = "";

            }
        });
    });

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("store.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        })
    });

    $(document).ready(function(){
        fetch_spp_data();
        function fetch_spp_data(query = '')
        {
            $.ajax({
                url:'{{ route("pengisian_cekgiro.actionSpp") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_spp tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_spp', function(){
            var query = $(this).val();
            fetch_spp_data(query);
        });
    });

    $(document).ready(function(){
        fetch_cekgiro_data();
        function fetch_cekgiro_data(query = '')
        {
            $.ajax({
                url:'{{ route("pengisian_cekgiro.actionCekgiro") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_cekgiro tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_cekgiro', function(){
            var query = $(this).val();
            fetch_cekgiro_data(query);
        });
    });

    $(document).ready(function(){
        fetch_spp_tiga_data();
        function fetch_spp_tiga_data(query = '')
        {
            $.ajax({
                url:'{{ route("pengisian_cekgiro.actionSpp") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_spp_tiga tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_spp_tiga', function(){
            var query = $(this).val();
            fetch_spp_tiga_data(query);
        });
    });

    $('#lookup_spp_tiga').on('click', 'tbody tr', function(e){
        e.preventDefault();
        $('#nospp_tiga').val($(this).find('td').html());
        $('#ketspp_tiga').val($(this).find('td').next().next().next().html());
        $('#nominalspp_tiga').val($(this).find('td').next().next().html());
        $('#nominalcek_tiga').val($(this).find('td').next().next().html());
        $('#myModalspp_tiga').modal('hide'); 
    });

    

$(function(){
    $('#kode_kategori').change(function(){
        var cat_id = $(this).val();
        if(cat_id){
            $.ajax({
                type:"GET",
                url:"/ajax_cat?cat_id="+cat_id,
                dataType:'JSON',
                success: function(res){
                    if(res){
                        $("#kode_subkategori").empty();
                        $("#kode_subkategori").append('<option>Select</option>');
                        $.each(res,function(nama,kode){
                            $("#kode_subkategori").append('<option value="'+kode+'">'+nama+'</option>');
                        });
                    }else{
                        $("#kode_subkategori").empty();
                    }
                }
            });
        }else{
            $("#kode_subkategori").empty();
        }
    });
});

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Charging</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Cek-Giro</li>
        <li class="breadcrumb-item">Pengisian</li>
        <li class="breadcrumb-item active">Isi Cek/Giro</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('store.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pengisian Cek/Giro</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Id
                                        <input type="text" name="kode" class="form-control" value="{{ $kode }}" required readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Tanggal
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Perusahaan
                                        <select name="kode_perusahaan" class="form-control" required>
                                            <option value="">Pilih</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>

                                
                                        
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                       <input name="radio" type="radio" id="satu" value="satu" class="detail" checked="true" />
                                       1 SPP - 1 Check/giro
                                    </div>
                                    <div class="col-md-3 mb-2">
                                       <input name="radio" type="radio" id="dua" value="dua" class="detail" />
                                       Banyak SPP - 1 Check/giro
                                    </div>
                                    <div class="col-md-3 mb-2">
                                       <input name="radio" type="radio" id="tiga" value="tiga" class="detail" />
                                       1 SPP - Banyak Check/giro
                                    </div>
                                </div>

                                <div id="form-input">
                                <div class="field_wrapper">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            No. SPP
                                            <div class="input-group">
                                                <input id="nospp_1" name="nospp[]" type="text" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalspp"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            Keterangan SPP
                                            <input type="text" id="ketspp_1" name="ketspp[]" class="form-control" value="" readonly>
                                        </div> 
                                        <div class="col-md-3 mb-2">
                                            Total SPP
                                            <input type="text" style="text-align: right;" id="nominalspp_1" name="nominalspp[]" class="form-control" value="" readonly>
                                        </div>
                                        <div class="col-md-1 mb-2" align="right">
                                            <br>
                                            <a class="btn btn-warning" href="javascript:void(0);" id="add_button" title="Add field">+</a>                                        
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div id="form-input-satu">
                                <div id="form-input-satu" class="field_wrapper_2">
                                    <div id="form-input-satu" class="row">
                                        <div class="col-md-4 mb-2">
                                            No. Cek/Giro
                                            <div class="input-group">
                                                <input id="nocekgiro_1" name="nocekgiro[]" type="text" class="form-control" readonly>
                                                <input id="id_nocekgiro_1" type="hidden" name="id_nocekgiro[]" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalcekgiro"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            Total Cek/Giro
                                            <input type="text" style="text-align: right;" id="nominalcek_1" name="nominalcek[]" class="form-control" value="" readonly>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Tgl. Cek/Giro
                                            <input type="date" id="tglcek_1" name="tglcek[]" class="form-control" value="" readonly>
                                        </div>
                                        <div class="col-md-1 mb-2" align="right">
                                            <br>
                                            <a class="btn btn-warning" href="javascript:void(0);" id="add_button_2" title="Add field">+</a>                                        
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div id="form-input-dua">
                                <div id="form-input-dua" class="field_wrapper_2">
                                    <div id="form-input-dua" class="row">
                                        <div class="col-md-4 mb-2">
                                            No. Cek/Giro
                                            <div class="input-group">
                                                <input id="nocekgiro_dua" name="nocekgiro_dua" type="text" class="form-control" readonly>
                                                <input id="id_nocekgiro_dua" type="hidden" name="id_nocekgiro_dua" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalcekgiro"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            Total Cek/Giro
                                            <input type="text" style="text-align: right;" id="nominalcek_dua" name="nominalcek_dua" class="form-control" value="" readonly>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Tgl. Cek/Giro
                                            <input type="date" id="tglcek_dua" name="tglcek_dua" class="form-control" value="" readonly>
                                        </div>
                                        <div class="col-md-1 mb-2" align="right" hidden>
                                            <br>
                                            <a class="btn btn-warning" href="javascript:void(0);" id="add_button_2" title="Add field">+</a>                                        
                                        </div>
                                    </div>  
                                </div>
                                </div>

                                <div id="form-input-tiga">
                                <div id="form-input-tiga" class="field_wrapper_3">
                                    <div id="form-input-tiga" class="row">
                                        <div class="col-md-4 mb-2">
                                            No. SPP
                                            <div class="input-group">
                                                <input id="nospp_tiga" name="nospp_tiga" type="text" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalspp_tiga"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            Keterangan SPP
                                            <input type="text" id="ketspp_tiga" name="ketspp_tiga" class="form-control" value="" readonly>
                                        </div> 
                                        <div class="col-md-3 mb-2">
                                            Total SPP
                                            <input type="text" style="text-align: right;" id="nominalspp_tiga" name="nominalspp_tiga" class="form-control" value="" readonly>
                                        </div>
                                    </div>

                                    <div id="form-input-tiga" class="row">
                                        <div class="col-md-4 mb-2">
                                            No. Cek/Giro
                                            <div class="input-group">
                                                <input id="nocekgiro_tiga_1" name="nocekgiro_tiga[]" type="text" class="form-control" readonly>
                                                <input id="id_nocekgiro_tiga_1" type="hidden" name="id_nocekgiro_tiga[]" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalcekgiro"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            Total Cek/Giro
                                            <input type="text" style="text-align: right;" id="nominalcek_tiga_1" name="nominalcek_tiga[]" class="form-control" value="">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Tgl. Cek/Giro
                                            <input type="date" id="tglcek_tiga_1" name="tglcek_tiga[]" class="form-control" value="" readonly>
                                        </div>
                                        <div class="col-md-1 mb-2" align="right">
                                            <br>
                                            <a class="btn btn-warning" href="javascript:void(0);" id="add_button_3" title="Add field">+</a>                                        
                                        </div>
                                    </div> 
                                </div>   
                                </div>
                                
                                
                                

                                <div class="row">
                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        Bulan Pengeluaran Awal
                                        <input type="date" id="bulan_awal" name="bulan_awal" class="form-control" value="">
                                        
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Bulan Pengeluaran Akhir
                                        <input type="date" id="bulan_akhir" name="bulan_akhir" class="form-control" value="">
                                        
                                    </div>  --}}
                                    <div class="col-md-4 mb-2">
                                        Tipe
                                        <select name="kode_sub" id="kode_sub" class="form-control">
                                            <option value="">Pilih</option>
                                            @foreach ($sub_tipe as $row)
                                                <option value="{{ $row->kode_sub }}" {{ old('kode_sub') == $row->kode_sub ? 'selected':'' }}>{{ $row->kode_sub }} {{ $row->sub_tipe }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Kategori
                                        <select name="kode_kategori" id="kode_kategori" class="form-control" required>
                                            <option value="">Pilih</option>
                                            @foreach ($kategori as $row)
                                                <option value="{{ $row->id_categories }}" {{ old('kode_kategori') == $row->id_categories ? 'selected':'' }}>{{ $row->categories_name }}</option>
                                            @endforeach 
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Sub Kategori
                                        <select name="kode_subkategori" id="kode_subkategori" class="form-control">
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        Catatan
                                        <input type="text" name="note" class="form-control" value="" required>
                                       
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        No. Invoice
                                        <input type="text" name="noinvoice" class="form-control" value="" >
                                       
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        No. Kontrabon
                                        <input type="text" name="nokontrabon" class="form-control" value="" >
                                        
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        No. Pengiriman
                                        <input type="text" name="nosuratjalan" class="form-control" value="" >
                                        
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        
                                        <button class="btn btn-primary btn-sm" hidden>Print Receipt</button>
                                        <button class="btn btn-primary btn-sm" hidden>Export to Excel</button>
                                    </div>
                                    <div class="col-md-8 mb-2" align="right">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">S i m p a n</button>
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

<div class="modal fade bd-example-modal-lg" id="myModalspp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_spp" id="cari_spp" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_spp" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SPP</th>
                                <th>Tgl SPP</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                                <th>Kategori</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalspp_tiga" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_spp_tiga" id="cari_spp_tiga" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_spp_tiga" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SPP</th>
                                <th>Tgl SPP</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                                <th>Kategori</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalcekgiro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cek/Giro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_cekgiro" id="cari_cekgiro" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_cekgiro" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No Izin B</th>
                                <th>Id cek</th>
                                <th>Tanggal</th>
                                <th>Judul Izin</th>
                                <th>No Rekening</th>
                                <th>Kode Vendor</th>
                                <th>Vendor</th>
                                <th>Nama Rekening</th>
                                <th>Kode Bank</th>
                                <th>Bank</th>
                                
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