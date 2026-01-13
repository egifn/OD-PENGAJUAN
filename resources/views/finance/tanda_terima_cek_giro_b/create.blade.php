@section('js')
<script type="text/javascript">
    var x = 2;
    function tambah() {
        var table = document.getElementById("table_warkat");
        var row = table.insertRow(-1);
        for (var i = 0; i < 9; i++) { // Ganti 10 dengan jumlah kolom yang Anda miliki
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
                cell.innerHTML = '<div class="input-group"><input type="hidden" name="kode_vendor[]" id="kode_vendor_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><input type="text" name="vendor[]" id="vendor_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" name="btn_vendor_'+x+'" id="btn_vendor_'+x+'" onclick="tombol(' + x + ');" data-toggle="modal" data-target="#myModalVendor" value = " '+ x + '" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button></span></div>'
            } else if (i === 5) {
                cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="nama_rekening[]" id="nama_rekening_'+x+'" style="font-size: 13px;" required readonly>';
            } else if (i === 6) {
                cell.innerHTML = '<input type="hidden" style="height: 30px;" class="form-control" name="kode_bank_vendor[]" id="kode_bank_vendor_'+x+'" style="font-size: 13px;" required readonly><input type="text" style="height: 30px;" class="form-control" name="bank_vendor[]" id="bank_vendor_'+x+'" style="font-size: 13px;" required readonly>';
            } else if (i === 7) {
                cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="no_rek_vendor[]" id="no_rek_vendor_'+x+'" style="font-size: 13px;" required readonly>';
            } else if (i === 8) {
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

    $(document).ready(function() {
        fetch_data_rekening();

        function fetch_data_rekening(query = '') {
            $.ajax({
                url: '{{ route('tanda_terima_b/action_pembayar.actionPembayar') }}',
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    $('#lookup_rekening tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_rekening', function() {
            var query = $(this).val();
            fetch_data_rekening(query);
        });
    });

    $(document).on('click', '.pilih_rekening', function (e) {
        document.getElementById('kode_perusahaan').value = $(this).attr('data-kodeperusahaan');
        document.getElementById('nama_perusahaan').value = $(this).attr('data-namaperusahaan');
        document.getElementById('nama_rekening').value = $(this).attr('data-atasnama');
        document.getElementById('kode_bank').value = $(this).attr('data-kodebank');
        document.getElementById('bank_pembayar').value = $(this).attr('data-namabank');
        document.getElementById('norek_pembayar').value = $(this).attr('data-norek');
        document.getElementById('norek_awal').value = $(this).attr('data-norek');
        document.getElementById('norek_akhir').value = $(this).attr('data-norek');

        $('#myModalRekening').modal('hide');
    });

    $(document).ready(function(){
        $('#myModalSeriAwal').on('show.bs.modal', function (e) {
            var norek_awal = $('#norek_awal').val(); 
            fetch_data_seri_awal(norek_awal);
        });

        function fetch_data_seri_awal(norek_awal)
        {
            $.ajax({
                url:'{{ route("tanda_terima_b/action_seri_awal.action_seri_awal") }}',
                method:'GET',
                data:{
                    norek_awal: norek_awal,
                    query: $('#search_seri_awal').val()
                },
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_seri_awal tbody').html(data.table_data);   
                }
            })
        }

        $('#search_seri_awal').on('keyup', function() {
            var norek_awal = $('#norek_awal').val();
            fetch_data_seri_awal(norek_awal);  // Panggil fungsi untuk memuat data dengan filter baru
        });
    });

    $(document).on('click', '.pilih_seri_awal', function (e) {
        baris = x - 1;
        
        document.getElementById('kode_seri_'+baris+'').value = $(this).attr('data-kode_buku');
        document.getElementById('seri_awal_'+baris+'').value = $(this).attr('data-id_cek');
        document.getElementById('kode_warkat_'+baris+'').value =$(this).attr('data-kode_seri');
        document.getElementById('no_cek_'+baris+'').value =$(this).attr('data-no_cek');
        $('#myModalSeriAwal').modal('hide');
    });

    $(document).ready(function(){
        $('#myModalSeriAkhir').on('show.bs.modal', function (e) {
            var norek_akhir = $('#norek_akhir').val();
            fetch_data_seri_akhir(norek_akhir);
        });
        function fetch_data_seri_akhir(norek_akhir, query = '')
        {
            
            $.ajax({
                url:'{{ route("tanda_terima_b/action_seri_akhir.action_seri_akhir") }}',
                method:'GET',
                data:{
                    norek_akhir: norek_akhir,
                    query: query
                    
                },
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_seri_akhir tbody').html(data.table_data);
                }
            })
        }

        $('#search_seri_akhir').on('keyup', function() {
            var norek_akhir = $('#norek_akhir').val();
            var query = $(this).val();
            fetch_data_seri_akhir(norek_akhir,query);
        });
    });

    $(document).on('click', '.pilih_seri_akhir', function (e) {
        baris = x - 1;
        
        document.getElementById('kode_seri_akhir_'+baris+'').value = $(this).attr('data-kode_buku');
        document.getElementById('seri_akhir_'+baris+'').value = $(this).attr('data-id_cek');
        document.getElementById('no_cek_akhir_'+baris+'').value = $(this).attr('data-no_cek');

        $('#myModalSeriAkhir').modal('hide');
    });

    $(document).ready(function(){
        fetch_data_vendor();
        function fetch_data_vendor(query = '')
        {
            $.ajax({
                url:'{{ route("tanda_terima_b/action_vendor.actionVendor") }}',
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

    // var baris = 0;
    // function tombol(x){
    //     baris = $('#btn_vendor_'+x+'').val();
    //     if(baris >= 2){
    //         baris = $('#btn_vendor_'+x+'').val();
    //     }else{
    //         baris = $('#btn_vendor_1').val();
    //     }
    //     alert(baris);
    // }

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

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Buat Izin B</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item">Izin B</li>
        <li class="breadcrumb-item active">Buat Izin B</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="{{ route('tanda_terima_b.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data"> 
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Izin B</h4>
                        </div>
                        <div class="card-body">
                        	<div class="row">
                                <div class="col-md-2 mb-2">
                                    Tanggal Izin
                                    <input type="date" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required>
                                </div>
                                <div class="col-md-1 mb-2">
                                    No.Izin
                                    <input type="text" name="no_izin" id="no_izin" class="form-control" value="" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    Judul Izin <!-- Keterangan -->
                                    <textarea name="judul_izin" id="judul_izin" rows="1" class="form-control" required></textarea>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>

                <form id="savedatas">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Nama Rekening Pembayar
                                        <div class="input-group">
                                            <input type="hidden" name="kode_perusahaan" id="kode_perusahaan" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                            <input type="hidden" name="nama_perusahaan" id="nama_perusahaan" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                            <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" name="btn_rekening" id="btn_rekening" data-toggle="modal" data-target="#myModalRekening" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Nama Bank
                                        <input type="hidden" name="kode_bank" id="kode_bank" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                        <input type="text" name="bank_pembayar" id="bank_pembayar" class="form-control" value="" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        No. Rekening Pembayar
                                        <input type="text" name="norek_pembayar" id="norek_pembayar" class="form-control" value="" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 mb-2">
                                        Keterangan <!-- Keterangan -->
                                        <textarea name="keterangan" id="keterangan" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <div>
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                                                    <th colspan="2" style="text-align: center;">Data Warkat</th>
                                                    <th colspan="4" style="text-align: center;">Tujuan Cek</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Aksi</th>
                                                </tr>
                                                <tr align="center">
                                                    <th style="vertical-align: middle;">No Seri Awal</th>
                                                    <th style="vertical-align: middle;">No Seri Akhir</th>
                                                    <th style="vertical-align: middle;">Nama Vendor</th>
                                                    <th style="vertical-align: middle;">Nama Rekening</th>
                                                    <th style="vertical-align: middle;">Bank</th>
                                                    <th style="vertical-align: middle;">No Rekening</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_warkat">
                                                <tr>
                                                    <td>1</td>
                                                    <td><textarea name="tbl_keterangan[]" id="tbl_keterangan_1" rows="1" class="form-control" style="font-size: 12px; height: 30px;" required></textarea></td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="hidden" name="kode_seri[]" id="kode_seri_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <input type="text" name="seri_awal[]" id="seri_awal_1" class="form-control" style="font-size: 12px; height: 30px; width: 100px;" value="" readonly>
                                                            <input type="hidden" name="kode_warkat[]" id="kode_warkat_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                            <input type="hidden" name="no_cek[]" id="no_cek_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-secondary" name="seri" id="seri" data-toggle="modal" data-target="#myModalSeriAwal" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="hidden" name="kode_seri_akhir[]" id="kode_seri_akhir_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <input type="text" name="seri_akhir[]" id="seri_akhir_1" class="form-control" style="font-size: 12px; height: 30px; width: 100px;" value="" readonly>
                                                            <input type="hidden" name="no_cek_akhir[]" id="no_cek_akhir_1" class="form-control" style="font-size: 12px; height: 30px; width: 80px;" value="" readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-secondary" name="seri" id="seri" data-toggle="modal" data-target="#myModalSeriAkhir" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="vndr">
                                                        <div class="input-group">
                                                            <input type="hidden" name="kode_vendor[]" id="kode_vendor_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <input type="text" name="vendor[]" id="vendor_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-secondary" name="btn_vendor_1" id="btn_vendor_1" data-toggle="modal" data-target="#myModalVendor" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                
                                                    <td><input type="text" style="height: 30px;" class="form-control" name="nama_rekening[]" id="nama_rekening_1" style="font-size: 13px;" required readonly></td>
                                                    <td><input type="hidden" style="height: 30px;" class="form-control" name="kode_bank_vendor[]" id="kode_bank_vendor_1" style="font-size: 13px;" required><input type="text" style="height: 30px;" class="form-control" name="bank_vendor[]" id="bank_vendor_1" style="font-size: 13px;" required readonly></td>
                                                    <td><input type="text" style="height: 30px;" class="form-control" name="no_rek_vendor[]" id="no_rek_vendor_1" style="font-size: 13px;" required readonly></td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="tambah()">+</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <!-- <div class="col-md-4 mb-2"> -->
                                        <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Cek/Giro</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Cek/Giro</button> -->
                                        <!-- <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">Simpan</button> -->
                                        <!-- <button type="button" id="button_print" name="button_print" class="btn btn-primary btn-sm">Print</button> -->
                                    <!-- </div>   -->
                                  
                                    <div class="col-md-12 mb-2">
                                        <!-- <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Simpan</button> -->
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

<div class="modal fade bd-example-modal-lg" id="myModalVendor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_vendor" id="search_vendor" class="form-control" placeholder="Cari Vendor . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_vendor" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Vendor</th>
                                <th>Nama Rekening</th>
                                <th hidden>kode_bank</th>
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
                        <input type="hidden" name="norek_awal" id="norek_awal" class="form-control" value="" required readonly>
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
                    <input type="hidden" name="norek_akhir" id="norek_akhir" class="form-control" value="" required readonly>
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

<div class="modal fade bd-example-modal-lg" id="myModalRekening" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background: #fff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Rekening</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="get">
                        <div class="input-group mb-3 col-md-6 float-right">
                            <input type="text" name="search_rekening" id="search_rekening" class="form-control"
                                placeholder="Cari Pengeluaran . . .">
                        </div>
                    </form>
                    <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                        <table id="lookup_rekening" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th hidden>Kode Perusahaan</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Atas Nama Rekening</th>
                                    <th hidden>Kode Bank</th>
                                    <th>Nama Bank</th>
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