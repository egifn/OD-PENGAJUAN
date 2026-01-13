@section('js')
<script type="text/javascript">

    $(document).ready(function(){
    var addButton = $('#add_button'); 
    var wrapper = $('.field_wrapper'); 
    var x = 1; 
        $(addButton).click(function(){
            x++;
            $(wrapper).append('<div class="form-group add"><div class="row"><div class="col-md-4 mb-2">SPP Number<div class="input-group"><input id="nospp_'+x+'" type="text" class="form-control" name="nospp[]" readonly required><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalspp"><span class="fa fa-search"></span></button></span></div></div><div class="col-md-4 mb-2">SPP Description<input type="text" name="ketspp[]" class="form-control" id="ketspp_'+x+'" required readonly ></div><div class="col-md-3 mb-2">Total SPP<input type="text" style="text-align: right;" name="nominalspp[]" class="form-control" id="nominalspp_'+x+'" required readonly/></div><div class="col-md-1 mb-2" align="right"><br><a class="remove_button btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'); 
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
                total_1 = parseInt(total_1) + parseInt(total);
                $('#nominalcek_1').val(total_1);
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
    var wrapper = $('.field_wrapper_2'); 
    var x = 1; 
        $(addButton).click(function(){
            x++;
            $(wrapper).append('<div class="form-group add"><div class="row"><div class="col-md-4 mb-2">Cek/Giro Number<div class="input-group"><input id="nocekgiro_'+x+'" type="text" class="form-control" name="nocekgiro[]" readonly required><input id="id_nocekgiro_'+x+'" type="hidden" class=form-control" name="id_nocekgiro[]" readonly required><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalcekgiro"><span class="fa fa-search"></span></button></span></div></div><div class="col-md-4 mb-2">Total Cek/Giro<input type="text" style="text-align: right;" name="nominalcek[]" class="form-control" id="nominalcek_'+x+'" required readonly ></div><div class="col-md-3 mb-2">Cek/Giro Date<input type="date" name="tglcek[]" class="form-control" id="tglcek_'+x+'" required readonly/></div><div class="col-md-1 mb-2" align="right"><br><a class="remove_button_2 btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'); 
        });
    
        var y = 1;
        $('#lookup_cekgiro').on('click', 'tbody tr', function(e){
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
        });
   
    
        $(wrapper).on('click', '.remove_button_2', function(e){
            if (confirm("Are you sure you want to delete this line?")) {
                e.preventDefault();
                $(this).parent('').parent('').remove(); 
                x--; 
            }
        
        });
    });


    $(document).on('click', '.pilih_kategori', function (e) {
        document.getElementById("kode_kategori").value = $(this).attr('data-id');
        document.getElementById("kategori").value = $(this).attr('data-name');
        $('#myModalKategori').modal('hide');
    });
    $(function () {
        $("#lookup_kategori").dataTable();
    });


    $(document).on('click', '.pilih_subKategori', function (e) {
        document.getElementById("kode_subkategori").value = $(this).attr('data-idSub');
        document.getElementById("subkategori").value = $(this).attr('data-nameSub');
        $('#myModalSubKategori').modal('hide');
    });
    $(function () {
        $("#lookup_subKategori").dataTable();
    });

    $(function(){
        $('#kode_kategori').change(function(){
            var cat_id = $(this).val();
            if(cat_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax?cat_id="+cat_id,
                    dataType: 'JSON',
                    success: function(res){
                        if(res){
                            $("#kode_subkategori").empty();
                            $("#kode_subkategori").append('<option>select</option>');
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
        <li class="breadcrumb-item">Charging</li>
        <li class="breadcrumb-item active">Add Charging</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('store.store') }}" method="post" enctype="multipart/form-data">
            
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Cek/Giro Charging </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Id
                                        <input type="text" name="kode" class="form-control" value="{{ $kode }}" required readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Date
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Company
                                        <select name="kode_perusahaan" class="form-control" required>
                                            <option value="">select</option>
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
                                    <div class="col-md-2 mb-2">
                                       <input name="radio" type="radio" id="dua" value="dua" class="detail" />
                                       Many SPP - 1 Check/giro
                                    </div>
                                    <div class="col-md-2 mb-2">
                                       <input name="radio" type="radio" id="tiga" value="tiga" class="detail" />
                                       1 SPP - Many Check/giro
                                    </div>
                                </div>   
                                
                                <div class="field_wrapper">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            SPP Number
                                            <div class="input-group">
                                                <input id="nospp_1" name="nospp[]" type="text" class="form-control" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalspp"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            SPP Description
                                            <input type="text" id="ketspp_1" name="ketspp[]" class="form-control" value="" required readonly>
                                        </div> 
                                        <div class="col-md-3 mb-2">
                                            Total SPP
                                            <input type="text" style="text-align: right;" id="nominalspp_1" name="nominalspp[]" class="form-control" value="" required readonly>
                                        </div>
                                        <div class="col-md-1 mb-2" align="right">
                                            <br>
                                            <a class="btn btn-warning" href="javascript:void(0);" id="add_button" title="Add field">+</a>                                        
                                        </div>
                                    </div>
                                </div>
                                
                                

                                <div class="field_wrapper_2">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            Cek/Giro Number
                                            <div class="input-group">
                                                <input id="nocekgiro_1" name="nocekgiro[]" type="text" class="form-control" readonly required>
                                                <input id="id_nocekgiro_1" type="hidden" name="id_nocekgiro[]" class="form-control" required readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalcekgiro"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            Total Cek/Giro
                                            <input type="text" style="text-align: right;" id="nominalcek_1" name="nominalcek[]" class="form-control" value="" required readonly>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Cek/Giro Date
                                            <input type="date" id="tglcek_1" name="tglcek[]" class="form-control" value="" required readonly>
                                        </div>
                                        <div class="col-md-1 mb-2" align="right">
                                            <br>
                                            <a class="btn btn-warning" href="javascript:void(0);" id="add_button_2" title="Add field">+</a>                                        
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Early Release Month
                                        <input type="date" id="bulan_awal" name="bulan_awal" class="form-control" value="" required>
                                        
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Final Month
                                        <input type="date" id="bulan_akhir" name="bulan_akhir" class="form-control" value="" required>
                                        
                                    </div> 
                                    <div class="col-md-2 mb-2">
                                        Type
                                        <select name="kode_sub" id="kode_sub" class="form-control">
                                            <option value="">select</option>
                                            @foreach ($sub_tipe as $row)
                                                <option value="{{ $row->kode_sub }}" {{ old('kode_sub') == $row->kode_sub ? 'selected':'' }}>{{ $row->kode_sub }} {{ $row->sub_tipe }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        
                                        Category
                                        <!--
                                        <div class="input-group">
                                        <input id="kategori" name="kategori" type="text" class="form-control" readonly="" required>
                                        <input id="kode_kategori" type="hidden" name="kode_kategori" value="{{ old('kode_kategori') }}" required readonly="">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori"> <span class="fa fa-search"></span></button>
                                        </span>
                                        </div>
                                        -->
                                        <select name="kode_kategori" id="kode_kategori" class="form-control">
                                            <option value="">select</option>
                                            @foreach ($kategori as $row)
                                                <option value="{{ $row->id_categories }}" {{ old('kode_kategori') == $row->id_categories ? 'selected':'' }}>{{ $row->categories_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Sub Category
                                        <!--
                                        <div class="input-group">
                                        <input id="subkategori" type="text" class="form-control" readonly="" required>
                                        <input id="kode_subkategori" type="hidden" name="kode_subkategori" value="{{ old('kode_subkategori') }}" required readonly="">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalSubKategori"> <span class="fa fa-search"></span></button>
                                        </span>
                                        </div>
                                        -->
                                        <select name="kode_subkategori" id="kode_subkategori" class="form-control">
                                            <option value="">select</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        Note
                                        <input type="text" name="note" class="form-control" value="" required>
                                       
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Invoice Number
                                        <input type="text" name="noinvoice" class="form-control" value="" required>
                                       
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Counter Bill Number
                                        <input type="text" name="nokontrabon" class="form-control" value="" required>
                                        
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Delivery Orders Number
                                        <input type="text" name="nosuratjalan" class="form-control" value="" required>
                                        
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        
                                        <button class="btn btn-primary btn-sm">Print Receipt</button>
                                        <button class="btn btn-primary btn-sm">Export to Excel</button>
                                    </div>
                                    <div class="col-md-8 mb-2" align="right">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">Save</button>
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
                                <th>SPP Number</th>
                                <th>SPP Date</th>
                                <th>Total</th>
                                <th>Description</th>
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
                                <th>Id cek</th>
                                <th>Cek/Giro Number</th>
                                <th>Date</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="lookup_kategori" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $data)
                        <tr class="pilih_kategori" data-id="<?php echo $data->id_categories ?>" data-name="<?php echo $data->categories_name ?>" >
                            <td>{{ $data->id_categories }}</td>
                            <td>{{ $data->categories_name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModalSubKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sub Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="lookup_subKategori" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th hidden>Kode</th>
                            <th>Sub Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subkategori as $data)
                        <tr class="pilih_subKategori" data-idSub="<?php echo $data->id_sub_categories ?>" data-nameSub="<?php echo $data->sub_categories_name ?>" >
                            <td hidden>{{ $data->id_sub_categories }}</td>
                            <td>{{ $data->sub_categories_name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')



@endsection