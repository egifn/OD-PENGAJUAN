@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        fetch_data_cek();
        function fetch_data_cek(query = '')
        {
            $.ajax({
                url:'{{ route("tanda_terima/action_cek.actionCek") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_cek tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_cek', function(){
            var query = $(this).val();
            fetch_data_cek(query);
        });
    });

    $(document).on('click', '.pilih_cek', function(e){
        document.getElementById('no_cek').value = $(this).attr('data-id_cek')

        document.getElementById('rekening_pembayar').value = $(this).attr('data-kode_perusahaan')
        document.getElementById('nama_bank').value = $(this).attr('data-nama_bank')
        document.getElementById('kode_bank').value = $(this).attr('data-kode_bank')
        document.getElementById('no_rek').value = $(this).attr('data-no_rek')

        $('#myModalRekeningPembayar').modal('hide');
    });

    var x = 0;
    var total_1 = 0;
    $(document).on('click', '.pilih', function(e) {
        x++;
        var total = 0;
        var tabel = document.getElementById("tabelinput");
        var row = tabel.insertRow(2);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);
        var cell8 = row.insertCell(7);
        var cell9 = row.insertCell(8);
        var cell10 = row.insertCell(9);
        var cell11 = row.insertCell(10);

        cell1.width = '50px';
        cell8.width = '250px';
        var a = $(this).attr('');
        var b = $(this).attr('data-spp');
        var c = $(this).attr('data-keterangan');
        var d = $(this).attr('data-totalspp');
        var e = $(this).attr('data-nama_vendor');
        var f = $(this).attr('data-an');
        var g = $(this).attr('data-bank');
        var h = $(this).attr('data-norek');
        
        cell1.innerHTML = '<input name="chk" type="checkbox" />';
        cell2.innerHTML = '<input type="hidden" name="spp[]" id="spp" value="'+b+'" style="border:none;" disabled/>'+b+''//b;
        // cell3.innerHTML = '<input type="text" name="keterangan[]" id="keterangan" value="'+c+'" style="border:none;" disabled/>' //c
        cell3.innerHTML = '<input type="hidden" name="total_tagihan[]" id="total_tagihan" value="'+d+'" style="text-align:right; border:none;" disabled/>'+d+'' //c
        cell4.innerHTML = '<input type="hidden" name="total_nominal_cek[]" id="total_nominal_cek" value="'+d+'" style="text-align:right; border:none;" disabled/>'+d+''//d;
        cell5.innerHTML = '<input type="hidden" name="total_perkategori[]" id="total_perkategori" value="'+d+'" style="text-align:right; border:none;" disabled/>'+d+''        
        // cell7.innerHTML = '<input type="text" name="tgl_cek[]" id="tgl_cek" value="" style="border:none;" disabled/>'
        cell8.innerHTML = '<div class="input-group"><input id="nama_vendor" type="text" name="nama_vendor" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly required><span class="input-group-btn"><input type="hidden" name="kode_vendor[]" id="kode_vendor" value="" style="border:none;" disabled/><button type="button" class="btn btn-info btn-secondary" name="btn_vendor_1" id="btn_vendor_1" data-toggle="modal" data-target="#myModalVendor" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button></span></div>'
        cell9.innerHTML = '<input type="text" name="atas_nama[]" id="atas_nama" value="" style="border:none;" disabled/>'//e;
        cell10.innerHTML = '<input type="text" name="nama_bank_vendor[]" id="nama_bank_vendor" value="" style="border:none;" disabled/><span class="input-group-btn"><input type="hidden" name="kode_bank_vendor[]" id="kode_bank_vendor" value="" style="border:none;" disabled/>'//f;
        cell11.innerHTML = '<input type="text" name="no_rek_vendor[]" id="no_rek_vendor" value="" style="border:none;" disabled/>'//g;

        var total = c;
        $('#myModal').modal('hide');
        total_1 = parseInt(total_1) + parseInt(total);

        $('#total_harga').val(total_1);
    });
    
    $(function () {
        $("#lookup").dataTable();
    });

    $(document).on('click', '.pilih_vendor', function (e) {
           
        document.getElementById('kode_vendor').value = $(this).attr('data-kodevendor');
        document.getElementById('nama_vendor').value = $(this).attr('data-namavendor');
        document.getElementById('atas_nama').value = $(this).attr('data-atasnama');
        document.getElementById('kode_bank_vendor').value = $(this).attr('data-kodebank');
        document.getElementById('nama_bank_vendor').value = $(this).attr('data-namabank');
        document.getElementById('no_rek_vendor').value = $(this).attr('data-norek');
        
        $('#myModalVendor').modal('hide');
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

                //tot = $('#total_harga').val() - $('#total_'+x+'').val();
                //document.getElementById("total_harga").value = '99999';

            }
        }
        return false;
    }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("tanda_terima_d.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    function show_my_pdf() {
        var retVal = confirm("Do you want to continue to print?");
        if( retVal == true ) {
               window.open('#', '_blank'); 
        }
    }

    $(document).ready(function(){
        fetch_data_data();
        function fetch_data_data(query = '')
        {
            $.ajax({
                url:'{{ route("tanda_terima_d/action_cekgiro.actionCekgiro") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_data_data(query);
        });
    });
</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Create Permission D</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item">Izin D</li>
        <li class="breadcrumb-item active">Izin D</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="{{ route('tanda_terima_d.store') }}" method="post" enctype="multipart/form-data"> 
            @csrf
            <div class="row">

              	<div class="col-md-6" hidden>
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Detail Cek</h4>
                        </div>
                        <div class="col-md-8 mb-2">
                            <br>
                            Cek/Giro ID : <input type="text" name="cek1" id="cek1" value="-" style="border: none;" readonly><br>
                            Cek/Giro Date : <input type="text" name="tglcek" id="tglcek" value="-" style="border: none;" readonly><br>
                            <br>
                            Company : <input type="text" name="perusahaan" id="perusahaan" value="-" style="border: none;" readonly><br>
                            Category : <input type="text" name="kategori" id="kategori" value="-" style="border: none;" readonly><br>
                            Sub Category : <input type="text" name="subkategori" id="subkategori" value="-" style="border: none;" readonly><br>
                            <br>
                            No. Cek/Giro : <input type="text" name="nocek" id="nocek" value="-" style="border: none;" readonly><br>
                            No. SPP : <input type="text" name="spp" id="spp" value="-" style="border: none; width: 250px;" readonly><br>
                            Total : <input type="text" name="total" id="total" value="-" style="border: none;" readonly><br>
                            <br>
                            Bank : <input type="text" name="bank" id="bank" value="-" style="border: none;" readonly><br>
                            Account Number : <input type="text" name="norek" id="norek" value="-" style="border: none;" readonly><br>
                            
                            
                        </div>
                    </div>
                </div>
              	
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Izin D</h4>
                        </div>
                        <div class="card-body">
                        	<div class="row">
                                <div class="col-md-2 mb-2" hidden>
                                     Id
                                    <input type="text" name="receipt" id="receipt" class="form-control" value="{{ $receipt }}" required readonly>
                                </div>
                                <div class="col-md-2 mb-2">
                                    No Izin
                                    <input type="text" name="description_id" id="description_id" class="form-control" style="text-align: right;" required>
                                </div>
                                
                                <div class="col-md-4 mb-2" hidden>
                                    Penerima
                                    <input type="text" name="penerima" id="penerima" class="form-control" required>
                                </div>
                                <div class="col-md-10 mb-2">
                                    Keterangan
                                    <input type="text" name="description" id="description" class="form-control" required>
                                </div>
                                
                            </div>
                            <br>
                            <div class="row">   
                                <div class="col-md-4 mb-2">
                                    Tanggal
                                    <input type="text" name="tgl_receipt" id="tgl_receipt" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    Nama Rekening Pembayar
                                    <div class="input-group">
                                        <input id="rekening_pembayar" type="text" name="rekening_pembayar" class="form-control" readonly required>
                                        <input id="no_cek" type="hidden" nama="no_cek" class="form-control" readonly required>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalRekeningPembayar">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">   
                                <div class="col-md-4 mb-2">
                                    Bank
                                    <input type="text" name="nama_bank" id="nama_bank" class="form-control" style="text-align: right;" value="" required readonly>
                                    <input type="hidden" name="kode_bank" id="kode_bank" class="form-control" style="text-align: right;" value="" required readonly>
                                </div>
                            </div> 
                            <div class="row">   
                                <div class="col-md-4 mb-2">
                                    No. Rek. Pembayaran
                                    <input type="text" name="no_rek" id="no_rek" class="form-control" style="text-align: right;" value="" required readonly>
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
                                    <div style="border:1px white;height:200px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Nominal Tagihan</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Nominal Cek/giro</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Total Per Kategori</th>
                                                    <th rowspan="2" style="vertical-align: middle;">Nomor Cek</th>
                                                    <th rowspan="2" style="vertical-align: middle;">tanggal Cek</th>
                                                    <th colspan="4" style="text-align: center;">Tujuan Cek</th>
                                                </tr>
                                                <tr align="center">
                                                    <th style="vertical-align: middle;">Nama Vendor</th>
                                                    <th style="vertical-align: middle;">Nama Rekening</th>
                                                    <th style="vertical-align: middle;">Bank</th>
                                                    <th style="vertical-align: middle;">No Rekening</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            <!--
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" style="text-align: center;">Total</th>
                                                    <th colspan="1">
                                                        <input type="label" name="total_harga" id="total_harga" value="" style="text-align:right; font-style:bold; width: 70px; font-size: 14px; border: none;" required readonly>
                                                    <th colspan="9">Total usage of check/giro</th>
                                                </tr>
                                            </tfoot>
                                            -->
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Cek/Giro</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Cek/giro</button>
                                    </div>  
                                  
                                    <div class="col-md-8 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Simpan</button>
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

<div class="modal fade bd-example-modal-lg" id="myModalRekeningPembayar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Pembayar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_cek" id="search_cek" class="form-control" placeholder="Cari data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_cek" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th hidden>Kode</th>
                                <th>No Cek</th>
                                <th>Perusahaan</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No SPP</th>
                                <th>keterangan</th>
                                <th>Jumlah</th>
                                <th>Nama Vendor</th>
                                <th>No Rekening</th>
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

@endsection