@section('js')
<script type="text/javascript">
    //----------PERUSAHAAN--------------------------------------------------------------------
    $(document).on('click', '.pilih_perusahaan', function (e) {
        document.getElementById("kode_perusahaan").value = $(this).attr('data-kodeperusahaan');
        document.getElementById("perusahaan").value = $(this).attr('data-namaperusahaan');
        $('#myModal_perusahaan').modal('hide');
    });
    $(function () {
        $("#lookup_Perusahaan").dataTable();
    });
    //----------REKENING----------------------------------------------------------------------
    $(document).on('click', '.pilih', function (e) {
        document.getElementById("norek").value = $(this).attr('data-norek');
        document.getElementById("kode_bank").value = $(this).attr('data-kodebank');
        document.getElementById("nama_bank").value = $(this).attr('data-namabank');
        $('#myModal_rek').modal('hide');
    });
    $(function () {
        $("#lookup_Rek").dataTable();
    });
    //----------KATEGORI----------------------------------------------------------------------
    $(document).on('click', '.pilih_kat', function (e) {
        document.getElementById("kode_kategori").value = $(this).attr('data-id');
        document.getElementById("kategori").value = $(this).attr('data-nama');
        $('#myModal_kat').modal('hide');
    });
    $(function () {
        $("#lookup_kat").dataTable();
    });
    //----------BANK-------------------------------------------------------------------------
    //$(document).on('click', '.pilih_bank', function (e) {
    //    document.getElementById("kode_bank").value = $(this).attr('data-kodebank');
    //    document.getElementById("nama_bank").value = $(this).attr('data-namabank');
    //    $('#myModal_bank').modal('hide');
    //});
    //$(function () {
    //    $("#lookup_Bank").dataTable();
    //});

    $(document).on('click', '.add_button', function (e) {
        //=================================================================
        if ($("#kode_perusahaan").val() == ""){
            alert("Perusahaan harus diisi, saat ini Perusahaan masih kosong!");
            $("#kode_perusahaan").focus();
            return (false);
        }
        if ($("#perusahaan").val() == ""){
            alert("Perusahaan harus diisi, saat ini Perusahaan masih kosong!");
            $("#perusahaan").focus();
            return (false);
        }
        if ($("#norek").val() == ""){
            alert("Norek harus diisi, saat ini Norek masih kosong!");
            $("#norek").focus();
            return (false);
        }
        if ($("#kode_bank").val() == ""){
            alert("Bank harus diisi, saat ini Bank masih kosong!");
            $("#kode_bank").focus();
            return (false);
        }
        if ($("#nama_bank").val() == ""){
            alert("Bank harus diisi, saat ini Bank masih kosong!");
            $("#nama_bank").focus();
            return (false);
        }
        if ($("#buku").val() == ""){
            alert("Kode Seri Warkat harus diisi, saat ini Kode Seri Warkat masih kosong!");
            $("#buku").focus();
            return (false);
        }
        if ($("#no_awal").val() == ""){
            alert("No Seri Awal harus diisi, saat ini No Seri Awal masih kosong!");
            $("#no_awal").focus();
            return (false);
        }
        if ($("#no_akhir").val() == ""){
            alert("No Seri Akhir harus diisi, saat ini No Seri Akhir masih kosong!");
            $("#no_akhir").focus();
            return (false);
        }
        if($("#jenis").val() == ""){
            alert("Jenis harus diisi, saat ini Jenis masih kosong!");
            $("#jenis").focus();
            return (false);
        }
        //=================================================================

        var no_awal = document.getElementById("no_awal").value;
        var no_akhir = document.getElementById("no_akhir").value;
        
        // == Warkat == //
        var tabel_warkat = document.getElementById("tabelwarkat");
        var row_warkat = tabel_warkat.insertRow(1);

        var reg = "REG";
        var kode_daftar_warkat = document.getElementById("kode").value;
        var kode_perusahaan_warkat = document.getElementById("kode_perusahaan").value;
        var nama_perusahaan_warkat = document.getElementById("perusahaan").value;
        var id_cek_warkat = document.getElementById("buku").value;
        var no_rek_warkat = document.getElementById("norek").value;
        var kode_bank_warkat = document.getElementById("kode_bank").value;
        var nama_bank_warkat = document.getElementById("nama_bank").value;
        var ket_warkat = document.getElementById("ket").value;
        var tgl_warkat = document.getElementById("tgl").value;
        var kode_kategori_warkat = document.getElementById("kode_kategori").value;
        var kategori_warkat = document.getElementById("kategori").value;
        var jenis_warkat = document.getElementById("jenis").value;

        //--format untuk kode warkat--/
        var date = new Date();
        var tahun = date.getFullYear();
        var bulan = date.getMonth();
        if(bulan == 0){
            var bulan_romawi = "I";
        }else if(bulan == 1){
            var bulan_romawi = "II";
        }else if(bulan == 2){
            var bulan_romawi = "III";
        }else if(bulan == 3){
            var bulan_romawi = "IV";
        }else if(bulan == 4){
            var bulan_romawi = "V";
        }else if(bulan == 5){
            var bulan_romawi = "VI";
        }else if(bulan == 6){
            var bulan_romawi = "VII";
        }else if(bulan == 7){
            var bulan_romawi = "VIII";
        }else if(bulan == 8){
            var bulan_romawi = "IX";
        }else if(bulan == 9){
            var bulan_romawi = "X";
        }else if(bulan == 10){
            var bulan_romawi = "XI";
        }else if(bulan == 11){
            var bulan_romawi = "XII";
        }else{
                    
        } 

        var no_pendaftaran_warkat = reg+' '+kode_daftar_warkat+' '+'/'+' '+kode_perusahaan_warkat+' '+'/'+' '+bulan_romawi+' '+'/'+' '+tahun
        //--End format untuk kode warkat--//

        var cell1_warkat = row_warkat.insertCell(0);
        var cell2_warkat = row_warkat.insertCell(1);
        var cell3_warkat = row_warkat.insertCell(2);
        var cell4_warkat = row_warkat.insertCell(3);
        var cell5_warkat = row_warkat.insertCell(4);
        var cell6_warkat = row_warkat.insertCell(5);
        var cell7_warkat = row_warkat.insertCell(6);
        var cell8_warkat = row_warkat.insertCell(7);

        // var cell9_warkat = row_warkat.insertCell(8); //kode perusahaan
        // var cell10_warkat = row_warkat.insertCell(9); //kode bank
        // var cell11_warkat = row_warkat.insertCell(10); //kode kategori
        // var cell12_warkat = row_warkat.insertCell(11); //kode seri buku
        // var cell13_warkat = row_warkat.insertCell(12); //seri awal
        // var cell14_warkat = row_warkat.insertCell(13); //seri akhir

        cell1_warkat.innerHTML = '<input type="text" class="form-control" name="no_warkat[]" id="no_warkat" style="font-size:13px; width:170px;" value="'+id_cek_warkat+''+" "+''+no_awal+''+" "+''+'-'+''+" "+''+no_akhir+'" readonly />';
        cell2_warkat.innerHTML = '<input type="text" class="form-control" name="perusahaan_warkat[]" id="perusahaan_warkat" style="font-size: 13px; width:200px;" value="'+nama_perusahaan_warkat+'" readonly>'//b;
        cell3_warkat.innerHTML = '<input type="text" class="form-control" name="bank_warkat[]" id="bank_warkat" style="font-size: 13px;" value="'+nama_bank_warkat+'" readonly>'//c;
        cell4_warkat.innerHTML = '<input type="text" class="form-control" name="no_rek_warkat[]" id="no_rek_warkat" style="font-size: 13px;" value="'+no_rek_warkat+'" readonly>'//d;
        cell5_warkat.innerHTML = '<input type="text" class="form-control" name="kategori_warkat[]" id="kategori_warkat" style="font-size: 13px;" value="'+kategori_warkat+'" readonly>'//e;
        cell6_warkat.innerHTML = '<input type="text" class="form-control" name="keterangan_warkat[]" id="keterangan_warkat" style="font-size: 13px;" value="'+ket_warkat+'" readonly>';
        cell7_warkat.innerHTML = '<input type="text" class="form-control" name="jenis_warkat[]" id="jenis_warkat" style="font-size: 13px;" value="'+jenis_warkat+'" readonly>';
        cell8_warkat.innerHTML = '<input type="text" class="form-control" name="tanggal_daftar_warkat[]" id="tanggal_daftar_warkat" style="font-size: 13px;" value="'+tgl_warkat+'" readonly><input type="hidden" class="form-control" name="kode_perusahaan_warkat[]" id="kode_perusahaan_warkat" style="font-size: 13px;" value="'+kode_perusahaan_warkat+'" readonly><input type="hidden" class="form-control" name="kode_bank_warkat[]" id="kode_bank_warkat" style="font-size: 13px;" value="'+kode_bank_warkat+'" readonly><input type="hidden" class="form-control" name="kode_kategori_warkat[]" id="kode_kategori_warkat" style="font-size: 13px;" value="'+kode_kategori_warkat+'" readonly><input type="hidden" class="form-control" name="kode_seri_buku_warkat[]" id="kode_seri_buku_warkat" style="font-size: 13px;" value="'+id_cek_warkat+'" readonly><input type="hidden" class="form-control" name="no_awal_warkat[]" id="no_awal_warkat" style="font-size: 13px;" value="'+no_awal+'" readonly><input type="hidden" class="form-control" name="no_akhir_warkat[]" id="no_akhir_warkat" style="font-size: 13px;" value="'+no_akhir+'" readonly><input type="hidden" class="form-control" name="kode_daftar_warkat[]" id="kode_daftar_warkat" style="font-size: 13px;" value="'+kode_daftar_warkat+'" readonly>';

        // cell9_warkat.innerHTML = '<input type="hidden" class="form-control" name="kode_perusahaan[]" id="kode_perusahaan" style="font-size: 13px;" value="'+kode_perusahaan_warkat+'" readonly>';
        // cell10_warkat.innerHTML = '<input type="hidden" class="form-control" name="kode_bank[]" id="kode_bank" style="font-size: 13px;" value="'+kode_bank_warkat+'" readonly>';
        // cell11_warkat.innerHTML = '<input type="hidden" class="form-control" name="kode_kategori[]" id="kode_kategori" style="font-size: 13px;" value="'+kode_kategori_warkat+'" readonly>';
        // cell12_warkat.innerHTML = '<input type="hidden" class="form-control" name="kode_seri_buku[]" id="kode_seri_buku" style="font-size: 13px;" value="'+id_cek_warkat+'" readonly>';
        // cell13_warkat.innerHTML = '<input type="hidden" class="form-control" name="no_awal[]" id="no_awal" style="font-size: 13px;" value="'+no_awal+'" readonly>';
        // cell14_warkat.innerHTML = '<input type="hidden" class="form-control" name="no_akhir[]" id="no_akhir" style="font-size: 13px;" value="'+no_akhir+'" readonly>';

        // ============ //

        // == Rincian Warkat == //
        var jumlah = no_akhir - no_awal;
        for(i=no_awal; i <=no_akhir; i++){
            if(i == no_awal){
                 var nol =  '';
            }else{
                if(i <= 9){
                    var nol = "00000";
                }else if(i <= 99){
                    var nol = "0000";
                }else if(i <= 999){
                    var nol = "000";
                }else if(i <= 9999){
                    var nol = "00";
                }else if(i <= 99999){
                    var nol = "0";
                }else{
                    
                }
            }

            var tabel = document.getElementById("tabelRincian");
            var row = tabel.insertRow(1);
            
            var kode_daftar = document.getElementById("kode").value;
            var kode_perusahaan = document.getElementById("kode_perusahaan").value;
            var nama_perusahaan = document.getElementById("perusahaan").value;
            var id_cek = document.getElementById("buku").value;
            var no_rek = document.getElementById("norek").value;
            var kode_bank = document.getElementById("kode_bank").value;
            var nama_bank = document.getElementById("nama_bank").value;
            var ket = document.getElementById("ket").value;
            var tgl = document.getElementById("tgl").value;
            var kategori = document.getElementById("kategori").value;
            var jenis = document.getElementById("jenis").value;

             //--format untuk kode warkat--/
            var date = new Date();
            var tahun = date.getFullYear();
            var bulan = date.getMonth();
            if(bulan == 0){
                var bulan_romawi = "I";
            }else if(bulan == 1){
                var bulan_romawi = "II";
            }else if(bulan == 2){
                var bulan_romawi = "III";
            }else if(bulan == 3){
                var bulan_romawi = "IV";
            }else if(bulan == 4){
                var bulan_romawi = "V";
            }else if(bulan == 5){
                var bulan_romawi = "VI";
            }else if(bulan == 6){
                var bulan_romawi = "VII";
            }else if(bulan == 7){
                var bulan_romawi = "VIII";
            }else if(bulan == 8){
                var bulan_romawi = "IX";
            }else if(bulan == 9){
                var bulan_romawi = "X";
            }else if(bulan == 10){
                var bulan_romawi = "XI";
            }else if(bulan == 11){
                var bulan_romawi = "XII";
            }else{
                        
            } 

            var no_pendaftaran_rincian = reg+' '+kode_daftar+' '+'/'+' '+kode_perusahaan+' '+'/'+' '+bulan_romawi+' '+'/'+' '+tahun
            //--End format untuk kode warkat--//

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            //var cell8 = row.insertCell(7);
            
            cell1.innerHTML = '<input type="text" class="form-control" name="kode_cek[]" id="kode_cek" style="font-size:13px; width:100px;" value="'+id_cek+''+" "+''+nol+''+i+'" readonly /><input type="hidden" class="form-control" name="no_cek[]" id="no_cek" style="font-size: 13px;" value="'+nol+''+i+'" readonly>'; //a
            cell2.innerHTML = '<input type="text" class="form-control" name="perusahaan[]" id="perusahaan" style="font-size: 13px; width:250px;" value="'+nama_perusahaan+'" readonly>'//b;
            cell3.innerHTML = '<input type="text" class="form-control" name="bank[]" id="bank" style="font-size: 13px;" value="'+nama_bank+'" readonly>'//c;
            cell4.innerHTML = '<input type="text" class="form-control" name="no_rek[]" id="no_rek" style="font-size: 13px;" value="'+no_rek+'" readonly>'//d;
            cell5.innerHTML = '<input type="text" class="form-control" name="kategori[]" id="kategori" style="font-size: 13px;" value="'+kategori+'" readonly>'//e;
            cell6.innerHTML = '<input type="text" class="form-control" name="keterangan[]" id="keterangan" style="font-size: 13px;" value="'+ket+'" readonly>';
            cell7.innerHTML = '<input type="text" class="form-control" name="tanggal_daftar[]" id="tanggal_daftar" style="font-size: 13px; width:100px;" value="'+tgl+'" readonly><input type="hidden" class="form-control" name="kode_daftar_rincian[]" id="kode_daftar_rincian" style="font-size: 13px;" value="'+kode_daftar+'" readonly><input type="hidden" class="form-control" name="kode_perusahaan[]" id="kode_perusahaan" style="font-size: 13px;" value="'+kode_perusahaan+'" readonly>';
        }

        $('#ket').val('');
        $('#perusahaan').val('');
        $('#kode_perusahaan').val('');
        $('#norek').val('');
        $('#nama_bank').val('');
        $('#kode_bank').val('');
        $('#kategori').val('');
        $('#kode_kategori').val('');
        $('#buku').val('');
        $('#no_awal').val('');
        $('#no_akhir').val('');
        $('#jenis').val('');

        var kode_daftar = document.getElementById("kode").value;
        var kode_daftar_int = parseInt(kode_daftar.replace(/^0+/, ''));
        var kode_daftar_int_jml = kode_daftar_int + 1;

        if(kode_daftar_int_jml <= 9){
            var nol = "000";
        }else if(kode_daftar_int_jml <= 99){
            var nol = "00";
        }else if(kode_daftar_int_jml <= 999){
            var nol = "0";
        }else{

        }

        // if(kode_daftar_int_jml <= 9){
        //     var nol = "000000";
        // }else if(kode_daftar_int_jml <= 99){
        //     var nol = "00000";
        // }else if(kode_daftar_int_jml <= 999){
        //     var nol = "0000";
        // }else if(kode_daftar_int_jml <= 9999){
        //     var nol = "000";
        // }else if(kode_daftar_int_jml <= 99999){
        //      var nol = "00";
        // }else if(kode_daftar_int_jml <= 999999){
        //      var nol = "0";
        // }else{
                    
        // }

        var kode_daftar_selanjutnya = kode_daftar_int_jml;
        $('#kode').val(kode_daftar_selanjutnya);

    });

    $(document).ready(function(){
        fetch_company_data();
        function fetch_company_data(query = '')
        {
            $.ajax({
                url:"{{ route('pendaftaran_cek_giro.action') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_Perusahaan tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_perusahaan', function(){
            var query = $(this).val();
            fetch_company_data(query);
        });
    });

    $(document).ready(function(){
        fetch_kategori_data();
        function fetch_kategori_data(query = '')
        {
            $.ajax({
                url:"{{ route('pendaftaran_cek_giro.actionCategory') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_kat tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_kategori', function(){
            var query = $(this).val();
            fetch_kategori_data(query);
        });
    });


    $(document).ready(function(){
        fetch_rekening_data();
        function fetch_rekening_data(query = '')
        {
            $.ajax({
                url:"{{ route('pendaftaran_cek_giro.actionRekening') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_Rek tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_rekening', function(){
            var query = $(this).val();
            fetch_rekening_data(query);
        });
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Tambah Pendaftaran</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Check/Giro </li>
        <li class="breadcrumb-item">Pendaftaran</li>
        <li class="breadcrumb-item active">Tambah Pendaftaran</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pendaftaran_cek_giro.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pendaftaran Check/Giro</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2" hidden>
                                        No.Pendaftaran
                                        <input type="text" name="kode" id="kode" class="form-control" value="{{ $kode }}" required readonly>
                                       
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Tanggal Reg.
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                       
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Keterangan
                                        <input type="text" name="ket" id="ket" class="form-control">
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Perusahaan
                                        <div class="input-group">
                                        <input id="perusahaan" type="text" name="perusahaan" class="form-control" readonly="" required>
                                        <input id="kode_perusahaan" type="hidden" name="kode_perusahaan" value="{{ old('kode_perusahaan') }}" required readonly="">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_perusahaan"> <span class="fa fa-search"></span></button>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        No. Rek
                                        <div class="input-group">
                                        <input id="norek" type="text" name="norek" class="form-control" readonly="" required>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_rek"> <span class="fa fa-search"></span></button>
                                        </span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Bank
                                        <div class="input-group">
                                        <input id="nama_bank" type="text" name="nama_bank" class="form-control" readonly="" required>
                                        <input id="kode_bank" type="hidden" name="kode_bank" value="{{ old('kode_bank') }}" required readonly="">
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Kategori
                                        <div class="input-group">
                                        <input id="kategori" type="text" name="kategori" class="form-control" readonly="" required>
                                        <input id="kode_kategori" type="hidden" name="kode_kategori" value="{{ old('kode_kategori') }}" required readonly="">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_kat"> <span class="fa fa-search"></span></button>
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Kode Seri Warkat
                                        <input type="text" name="buku" id="buku" class="form-control">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        No Seri Awal
                                        <input type="text" name="no_awal" id="no_awal" style="text-align: right;" class="form-control">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2">
                                       No Seri Akhir
                                        <input type="text" name="no_akhir" id="no_akhir" style="text-align: right;" class="form-control">
                                        
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jenis Buku Warkat
                                        <select name="jenis" id="jenis" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Cek">Cek</option>
                                            <option value="Giro">Giro</option>
                                            <option value="Slip">Slip</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        <a class="btn btn-primary add_button" href="javascript:void(0);" id="add_button" title="Add field">+</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 mb-4">
                                    <div class="nav-tabs-boxed">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#warkat" role="tab" aria-controls="warkat">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Warkat</b>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#rincian" role="tab" aria-controls="rincian">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Rincian Warkat</b>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="warkat" role="tabpanel">
                                                <br>
                                                <div class="table-responsive">
                                                    <div style="border:1px white;height:250px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelwarkat">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.Warkat</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Bank</th>
                                                                    <th>No.Rek</th>
                                                                    <th>Kategori Buku</th>
                                                                    <th>Keterangan</th>
                                                                    <th>Jenis</th>
                                                                    <th>Tgl.Reg</th>

                                                                    {{-- <th hidden>kode perusahaan</th>
                                                                    <th hidden>kode bank</th>
                                                                    <th hidden>kode kategori</th>
                                                                    <th hidden>kode seri buku</th>
                                                                    <th hidden>seri awal</th>
                                                                    <th hidden>seri akhir</th> --}}
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="rincian" role="tabpanel">
                                                <br>
                                                <div class="table-responsive">
                                                    <div style="border:1px white;height:250px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelRincian">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.warkat</th>
                                                                    <th hidden>No</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Bank</th>
                                                                    <th>No.Rek</th>
                                                                    <th>Kategori Buku</th>
                                                                    <th>Keterangan</th>
                                                                    <th>Tgl.Reg</th>
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
                                </div>


                                {{-- <div class="table-responsive">
                                    <div style="border:1px white;height:250px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>Id. Cek</th>
                                                    <th>No. Cek</th>
                                                    <th>Perusahaan</th>
                                                    <th>Bank</th>
                                                    <th>No. Rek</th>
                                                    <th>Kategori Buku</th>
                                                    <th>Keterangan</th>
                                                    <th>Tgl. Reg.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-primary btn-sm float-right">Simpan</button>
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

<div class="modal fade bd-example-modal-lg" id="myModal_kat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_kategori" id="cari_kategori" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <table id="lookup_kat" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_perusahaan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_perusahaan" id="cari_perusahaan" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>

                <table id="lookup_Perusahaan" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Company Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModal_rek" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_rekening" id="cari_rekening" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <table id="lookup_Rek" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Account</th>
                            <th hidden>kode bank</th>
                            <th>Bank</th>
                            <th>Depo</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')



@endsection