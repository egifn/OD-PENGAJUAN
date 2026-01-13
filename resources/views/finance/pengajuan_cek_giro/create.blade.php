@section('js')
<script type="text/javascript">
     var x = 2;
     $(document).ready(function(){
        fetch_data_rek();
        function fetch_data_rek(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan_cek_giro/action_rek.actionRek") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_rek tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_rek', function(){
            var query = $(this).val();
            fetch_data_rek(query);
        });
    });

    $(document).on('click', '.pilih_rek', function (e) {
        baris = x - 1;
        
        document.getElementById('kode_perusahaan_'+baris+'').value = $(this).attr('data-kode');
        document.getElementById('nama_perusahaan_'+baris+'').value = $(this).attr('data-perusahaan');
        document.getElementById('kode_bank_'+baris+'').value = $(this).attr('data-kode_bank');
        document.getElementById('nama_bank_'+baris+'').value = $(this).attr('data-bank');
        document.getElementById('no_rek_'+baris+'').value = $(this).attr('data-norek');

        $('#myModalRekening').modal('hide');
    });

    function tambah() {
        var table = document.getElementById("table_warkat");
        var row = table.insertRow(-1);
        for (var i = 0; i < 7; i++) { // Ganti 10 dengan jumlah kolom yang Anda miliki
            var cell = row.insertCell(i);
            if (i === 0) {
                cell.innerHTML = table.rows.length; // Nomor urutan
            } else if (i === 1) {
                cell.innerHTML = '<div class="input-group"><input type="hidden" name="kode_perusahaan[]" id="kode_perusahaan_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><input type="text" name="nama_perusahaan[]" id="nama_perusahaan_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" name="btn_vendor_'+x+'" id="btn_vendor_'+x+'" data-toggle="modal" data-target="#myModalRekening" value = " '+ x + '" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button></span></div>'
            } else if (i === 2) {
                cell.innerHTML = '<input type="hidden" style="height: 30px;" class="form-control" name="kode_bank[]" id="kode_bank_'+x+'" style="font-size: 13px;" required readonly><input type="text" style="height: 30px;" class="form-control" name="nama_bank[]" id="nama_bank_'+x+'" style="font-size: 13px;" required readonly>'
            } else if (i === 3) {
                cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="no_rek[]" id="no_rek_'+x+'" style="font-size: 13px;" required readonly>';
            } else if (i === 4) {
                cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="banyak_buku[]" id="banyak_buku_'+x+'" style="font-size: 13px;" required>';
            } else if (i === 5) {
                cell.innerHTML = '<select name="jenis_buku[]" id="jenis_buku_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" required><option value="">Pilih</option><option value="Cek">Cek</option><option value="Giro">Giro</option><option value="Slip">Slip</option></select>';
            } else if (i === 6) {
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

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Permintaan Cek/Giro</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Permintaan Cek/Giro</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="{{ route('store.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data"> 
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Permintaan Cek Giro</h4>
                        </div>
                        <div class="card-body">
                        	<div class="row">
                                <div class="col-md-2 mb-2">
                                    Tanggal Permintaan
                                    <input type="date" name="tgl_permintaan" id="tgl_permintaan" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    Ket: Untuk Perusahaan
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    Pembawa Resi
                                    <select name="kode_pembawa_resi" id="kode_pembawa_resi" class="form-control">
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
                                                    <th style="vertical-align: middle;">No</th>
                                                    <th style="vertical-align: middle;">Nama Perusahaan</th>
                                                    <th style="text-align: center;" hidden>Kode Bank</th>
                                                    <th style="text-align: center;">Nama Bank</th>
                                                    <th style="text-align: center;">No Rekening</th>
                                                    <th style="text-align: center;">Banyak Buku</th>
                                                    <th style="text-align: center;">Jenis Buku</th>
                                                    <th style="vertical-align: middle;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_warkat">
                                                <tr>
                                                    <td>1</td>
                                                    <td class="vndr">
                                                        <div class="input-group">
                                                            <input type="hidden" name="kode_perusahaan[]" id="kode_perusahaan_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <input type="text" name="nama_perusahaan[]" id="nama_perusahaan_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-secondary" name="btn_vendor_1" id="btn_vendor_1" data-toggle="modal" data-target="#myModalRekening" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td hidden><input type="text" style="height: 30px;" class="form-control" name="kode_bank[]" id="kode_bank_1" style="font-size: 13px;" required readonly></td>
                                                    <td><input type="text" style="height: 30px;" class="form-control" name="nama_bank[]" id="nama_bank_1" style="font-size: 13px;" required readonly></td>
                                                    <td><input type="text" style="height: 30px;" class="form-control" name="no_rek[]" id="no_rek_1" style="font-size: 13px;" required readonly></td>
                                                    <td><input type="text" style="height: 30px;" class="form-control" name="banyak_buku[]" id="banyak_buku_1" style="font-size: 13px;" required></td>
                                                    <td><select name="jenis_buku[]" id="jenis_buku_1" class="form-control" style="font-size: 12px; height: 30px;" required><option value="">Pilih</option><option value="Cek">Cek</option><option value="Giro">Giro</option><option value="Slip">Slip</option></select></td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="tambah()">+</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Cek/Giro</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Cek/Giro</button> --}}
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                        {{-- <button type="button" id="button_print" name="button_print" class="btn btn-primary btn-sm">Print</button> --}}
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

<div class="modal fade bd-example-modal-lg" id="myModalRekening" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_rek" id="search_rek" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_rek" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th hidden>Kode</th>
                                <th>Perusahaan</th>
                                <th>Bank</th>
                                <th>No Rekening</th>
                                <th>Atas Nama</th>
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