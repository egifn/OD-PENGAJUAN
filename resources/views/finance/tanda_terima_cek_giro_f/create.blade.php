@section('js')
<script type="text/javascript">
    var x = 2;
    function tambah() {
        var table = document.getElementById("table_warkat");
        var row = table.insertRow(-1);
        for (var i = 0; i < 8; i++) { // Ganti 10 dengan jumlah kolom yang Anda miliki
            var cell = row.insertCell(i);
            if (i === 0) {
                cell.innerHTML = table.rows.length; // Nomor urutan
            } else if (i === 1) {
                cell.innerHTML = '<textarea name="tbl_keterangan[]" id="tbl_keterangan_'+x+'" rows="1" class="form-control" style="font-size: 12px; height: 30px;" required></textarea>';
            } else if (i === 2) {
                cell.innerHTML = '<div class="input-group"><input type="hidden" name="kode_seri[]" id="kode_seri_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><input type="text" name="seri_awal[]" id="seri_awal_'+x+'" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly><input type="hidden" name="kode_warkat[]" id="kode_warkat_'+x+'" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly><input type="hidden" name="no_cek[]" id="no_cek_'+x+'" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" name="seri" id="seri" data-toggle="modal" data-target="#myModalSeriAwal" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button></span></div>';
            } else if (i === 3) {
                cell.innerHTML = '<div class="input-group"><input type="hidden" name="kode_seri_akhir[]" id="kode_seri_akhir_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><input type="text" name="seri_akhir[]" id="seri_akhir_'+x+'" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" name="seri" id="seri" data-toggle="modal" data-target="#myModalSeriAkhir" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button></span></div>';
            } else if (i === 4) {
                cell.innerHTML = '<input type="hidden" name="kode_perusahaan[]" id="kode_perusahaan_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><input type="text" name="perusahaan[]" id="perusahaan_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>';
            } else if (i === 5) {
                cell.innerHTML = '<input type="hidden" name="kode_bank[]" id="kode_bank_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><input type="text" name="bank[]" id="bank_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>';
            } else if (i === 6) {
                cell.innerHTML = '<input type="text" name="no_rek[]" id="no_rek_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>';
            } else if (i === 7) {
                cell.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="hapus(' + (table.rows.length - 1) + ')"><i class="nav-icon icon-trash"></i></button>'; // Tombol hapus
            }
        }
        x++;
    };    

    function hapus(index) {
        var table = document.getElementById("table_warkat");
        if (table.rows.length > 1) { 
            table.deleteRow(index); 
        }

        for (var i = index; i < table.rows.length; i++) {
            table.rows[i].cells[0].innerHTML = i + 1;  // Mengupdate nomor urut
        }
    }

    function pilih(x){
        if(x >= 2){
            $('#kode_seri_'+x+'').change(function(){
                var kd_seri = $(this).val();
                if(kd_seri){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_seri_warkat?kd_seri="+kd_seri,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $('#seri_awal_'+x+'').empty();
                                $('#seri_awal_'+x+'').append('<option value="">pilih</option>');
                                $.each(res,function(seri,kode){
                                    $('#seri_awal_'+x+'').append('<option value="'+kode+'">'+seri+'</option>');
                                });

                                $('#seri_akhir_'+x+'').empty();
                                $('#seri_akhir_'+x+'').append('<option value="">pilih</option>');
                                $.each(res,function(seri,kode){
                                    $('#seri_akhir_'+x+'').append('<option value="'+kode+'">'+seri+'</option>');
                                });
                            }else{
                                $('#seri_awal_'+x+'').empty();   
                                $('#seri_akhir_'+x+'').empty();    
                            }
                        }
                    });
                }else{
                    $('#seri_awal_'+x+'').empty();
                    $('#seri_akhir_'+x+'').empty();
                }
            });
        }else{
            $("#kode_seri_1").change(function(){
                var kd_seri = $(this).val();
                if(kd_seri){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_seri_warkat?kd_seri="+kd_seri,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $('#seri_awal_1').empty();
                                $('#seri_awal_1').append('<option value="">pilih</option>');
                                $.each(res,function(seri,kode){
                                    $('#seri_awal_1').append('<option value="'+kode+'">'+seri+'</option>');
                                });

                                $('#seri_akhir_1').empty();
                                $('#seri_akhir_1').append('<option value="">pilih</option>');
                                $.each(res,function(seri,kode){
                                    $('#seri_akhir_1').append('<option value="'+kode+'">'+seri+'</option>');
                                });
                            }else{
                                $('#seri_awal_1').empty();
                                $('#seri_akhir_1').empty();    
                            }
                        }
                    });
                }else{
                    $('#seri_awal_1').empty();
                    $('#seri_akhir_1').empty();
                }
            });
        }
    }

    function pilih_sumber_dana(x){
        if(x >= 2){
            $('#perusahaan_'+x+'').change(function(){
                var perusahaan_id = $(this).val();
                if(perusahaan_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_perusahaan_bank?perusahaan_id="+perusahaan_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $('#bank_'+x+'').empty();
                                $('#bank_'+x+'').append('<option value="">Select</option>');
                                $.each(res,function(nama,kode){
                                    $('#bank_'+x+'').append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $('#bank_'+x+'').empty();
                            }
                        }
                    });
                }else{
                    $('#bank_'+x+'').empty();
                }
            });
        }else{
            $('#perusahaan_1').change(function(){
                var perusahaan_id = $(this).val();
                if(perusahaan_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_perusahaan_bank?perusahaan_id="+perusahaan_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#bank_1").empty();
                                $("#bank_1").append('<option value="">Select</option>');
                                $.each(res,function(nama,kode){
                                    $("#bank_1").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#bank_1").empty();
                            }
                        }
                    });
                }else{
                    $("#bank_1").empty();
                }
            });
        }
    }

    function pilih_sumber_dana_rek(x)
    {
        if(x >= 2){
            $('#perusahaan_'+ x +', #bank_'+ x +'').change(function () {
                var perusahaan_id = $('#perusahaan_'+ x +'').val();
                var bank_id = $('#bank_'+ x +'').val();

                if (perusahaan_id && bank_id) {
                    $.ajax({
                        type: "GET",
                        url: "/ajax_perusahaan_bank_rekening?perusahaan_id=" + perusahaan_id + "&bank_id=" + bank_id,
                        dataType: 'JSON',
                        success: function (res) {
                            if (res) {
                                $('#no_rek_'+x+'').empty();
                                $('#no_rek_'+x+'').append('<option value="">Select</option>');
                                $.each(res, function (nama, kode) {
                                    $('#no_rek_'+x+'').append('<option value="' + kode + '">' + nama + '</option>');
                                });
                            } else {
                                $('#no_rek_'+x+'').empty();
                            }
                        }
                    });
                } else {
                    $('#no_rek_'+x+'').empty();
                }
            });
        }else{
            $('#perusahaan_1, #bank_1').change(function () {
                var perusahaan_id = $('#perusahaan_1').val();
                var bank_id = $('#bank_1').val();

                if (perusahaan_id && bank_id) {
                    $.ajax({
                        type: "GET",
                        url: "/ajax_perusahaan_bank_rekening?perusahaan_id=" + perusahaan_id + "&bank_id=" + bank_id,
                        dataType: 'JSON',
                        success: function (res) {
                            if (res) {
                                $("#no_rek_1").empty();
                                $("#no_rek_1").append('<option value="">Select</option>');
                                $.each(res, function (nama, kode) {
                                    $("#no_rek_1").append('<option value="' + kode + '">' + nama + '</option>');
                                });
                            } else {
                                $("#no_rek_1").empty();
                            }
                        }
                    });
                } else {
                    $("#no_rek_1").empty();
                }
            });
        }
    }

    $(document).ready(function(){
        fetch_data_vendor();
        function fetch_data_vendor(query = '')
        {
            $.ajax({
                url:'{{ route("tanda_terima_f/action_vendor.actionVendor") }}',
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
            fetch_data_vendor(query);
        });
    });

    $(document).on('click', '.pilih_vendor', function (e) {
        baris = x - 1;
        
        document.getElementById('kode_vendor_'+baris+'').value = $(this).attr('data-kodevendor');
        document.getElementById('vendor_'+baris+'').value = $(this).attr('data-namavendor');
        document.getElementById('nama_rekening_'+baris+'').value = $(this).attr('data-atasnama');
        document.getElementById('kode_bank_vendor_'+baris+'').value = $(this).attr('data-kodebank');
        document.getElementById('bank_vendor_'+baris+'').value = $(this).attr('data-namabank');
        document.getElementById('no_rek_vendor_'+baris+'').value = $(this).attr('data-norek');

        $('#myModalVendor').modal('hide');
    });

    $(document).ready(function(){
        fetch_data_seri_awal();
        function fetch_data_seri_awal(query = '')
        {
            $.ajax({
                url:'{{ route("tanda_terima_f/action_seri_awal.action_seri_awal") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_seri_awal tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_seri_awal', function(){
            var query = $(this).val();
            fetch_data_seri_awal(query);
        });
    });

    $(document).on('click', '.pilih_seri_awal', function (e) {
        baris = x - 1;
        
        document.getElementById('kode_seri_'+baris+'').value = $(this).attr('data-kode_buku');
        document.getElementById('seri_awal_'+baris+'').value = $(this).attr('data-id_cek');
        document.getElementById('kode_perusahaan_'+baris+'').value = $(this).attr('data-kode_perusahaan');
        document.getElementById('perusahaan_'+baris+'').value = $(this).attr('data-nama_perusahaan');
        document.getElementById('kode_bank_'+baris+'').value = $(this).attr('data-kode_bank');
        document.getElementById('bank_'+baris+'').value = $(this).attr('data-nama_bank');
        document.getElementById('no_rek_'+baris+'').value = $(this).attr('data-no_rek');
        document.getElementById('kode_warkat_'+baris+'').value =$(this).attr('data-kode_seri');
        document.getElementById('no_cek_'+baris+'').value =$(this).attr('data-no_cek');
        $('#myModalSeriAwal').modal('hide');
    });

    $(document).ready(function(){
        fetch_data_seri_akhir();
        function fetch_data_seri_akhir(query = '')
        {
            $.ajax({
                url:'{{ route("tanda_terima_f/action_seri_akhir.action_seri_akhir") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_seri_akhir tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_seri_akhir', function(){
            var query = $(this).val();
            fetch_data_seri_akhir(query);
        });
    });

    $(document).on('click', '.pilih_seri_akhir', function (e) {
        baris = x - 1;
        
        document.getElementById('kode_seri_akhir_'+baris+'').value = $(this).attr('data-kode_buku');
        document.getElementById('seri_akhir_'+baris+'').value = $(this).attr('data-id_cek');
        $('#myModalSeriAkhir').modal('hide');
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Buat Izin F</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item">Izin F</li>
        <li class="breadcrumb-item active">Buat Izin F</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="{{ route('tanda_terima_f.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data"> 
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Izin F</h4>
                        </div>
                        <div class="card-body">
                        	<div class="row">
                                <div class="col-md-2 mb-2">
                                    Tanggal Izin
                                    <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                </div>
                                <div class="col-md-1 mb-2">
                                    No.Izin
                                    <input type="text" name="no_izin" id="no_izin" class="form-control" value="" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    Judul Izin <!-- Keterangan -->
                                    <textarea name="judul_izin" id="judul_izin" rows="1" class="form-control" required></textarea>
                                </div>
                                <div class="col-md-3 mb-2">
                                    Catatan <!-- Keterangan -->
                                    <input type="text" name="catatan" id="catatan" class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    Yang Mengajukan
                                    <select name="kode_pengaju" id="kode_pengaju" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1">Ratna pany</option>
                                        <option value="2">Cinta M.Tampubolon</option>
                                        <option value="3">Razel G. kaawoan</option>
                                        <option value="4">Nany Enggawati</option>
                                        <option value="5">Amelina</option>
                                        <option value="6">Lie Kwie Moy</option>
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
                                    <div>
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                                                    <th colspan="2" style="text-align: center;">Data Warkat</th>
                                                    <th colspan="3" style="text-align: center;">Sumber Dana</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Aksi</th>
                                                </tr>
                                                <tr align="center">
                                                    <th style="vertical-align: middle;">No Seri Awal</th>
                                                    <th style="vertical-align: middle;">No Seri Akhir</th>
                                                    <th style="vertical-align: middle; width: 300px;">Perusahaan</th>
                                                    <th style="vertical-align: middle;">Bank</th>
                                                    <th style="vertical-align: middle;">No Rekening</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_warkat">
                                                <tr>
                                                    <td>1</td>
                                                    <td><textarea name="tbl_keterangan[]" id="tbl_keterangan_1" rows="1" class="form-control" style="font-size: 12px; height: 30px;" required></textarea></td>
                                                    <td class="vndr">
                                                        <div class="input-group">
                                                            <input type="hidden" name="kode_seri[]" id="kode_seri_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <input type="text" name="seri_awal[]" id="seri_awal_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                            <input type="hidden" name="kode_warkat[]" id="kode_warkat_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                            <input type="hidden" name="no_cek[]" id="no_cek_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-secondary" name="seri" id="seri" data-toggle="modal" data-target="#myModalSeriAwal" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="vndr">
                                                        <div class="input-group">
                                                            <input type="hidden" name="kode_seri_akhir[]" id="kode_seri_akhir_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <input type="text" name="seri_akhir[]" id="seri_akhir_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-secondary" name="seri" id="seri" data-toggle="modal" data-target="#myModalSeriAkhir" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td hidden><input type="text" name="kode_perusahaan[]" id="kode_perusahaan_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly></td>
                                                    <td><input type="text" name="perusahaan[]" id="perusahaan_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly></td>
                                                    <td hidden><input type="text" name="kode_bank[]" id="kode_bank_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly></td>
                                                    <td><input type="text" name="bank[]" id="bank_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly></td>
                                                    <td><input type="text" name="no_rek[]" id="no_rek_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly></td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="tambah()">+</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Cek/Giro</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Cek/Giro</button> -->
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">S i m p a n</button>
                                        <!-- <button type="button" id="button_print" name="button_print" class="btn btn-primary btn-sm">Print</button> -->
                                    </div>  
                                  
                                    <div class="col-md-8 mb-2" hidden>
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
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

<div class="modal fade bd-example-modal-lg" id="myModalSeriAwal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Cek/Giro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_seri_awal" id="search_seri_awal" class="form-control" placeholder="Cari Cek/Giro . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_seri_awal" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Buku</th>
                                <th>No Izin</th>
                                <th>Judul</th>
                                <th>Perusahaan</th>
                                <th>No Cek</th>
                                <th>Bank</th>
                                <th>No Rekening</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalSeriAkhir" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Cek/Giro Akhir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_seri_akhir" id="search_seri_akhir" class="form-control" placeholder="Cari Cek/Giro . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_seri_akhir" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Buku</th>
                                <th>No Izin</th>
                                <th>Judul</th>
                                <th>Perusahaan</th>
                                <th>No Cek</th>
                                <th>Bank</th>
                                <th>No Rekening</th>
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