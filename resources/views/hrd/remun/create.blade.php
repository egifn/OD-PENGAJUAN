@section('js')
<script type="text/javascript">
    var x = 2;
    function tambah() {
        var table = document.getElementById("table_tunjangan");
        var row = table.insertRow(-1);
        for (var i = 0; i < 4; i++) { // Ganti 10 dengan jumlah kolom yang Anda miliki
            var cell = row.insertCell(i);
            if (i === 0) {
                cell.style.textAlign = "center";
                cell.innerHTML = table.rows.length; // Nomor urutan
            } else if (i === 1) {
                cell.innerHTML = '<div class="input-group"><input type="hidden" name="kode_tunjangan[]" id="kode_tunjangan_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><input type="text" name="nama_tunjangan[]" id="nama_tunjangan_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly><span class="input-group-btn"><button type="button" class="btn btn-info btn-secondary" name="btn_'+x+'" id="btn_'+x+'" onclick="tombol(' + x + ');" data-toggle="modal" data-target="#myModalTunjangan" value = " '+ x + '" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button></span></div>'
            } else if (i === 2) {
                cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="nilai[]" id="nilai_'+x+'" style="font-size: 13px;" onkeyup="hitungTotal()" required>';
            } else if (i === 3) {
                cell.style.textAlign = "center"; 
                cell.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="hapus(' + (table.rows.length - 1) + ')"><i class="nav-icon icon-trash"></i></button>'; // Tombol hapus
            }
        }
        x++;
        hitungTotal();
    };

    function hapus(index) {
        var table = document.getElementById("table_tunjangan");
        if (table.rows.length > 1) { 
            table.deleteRow(index); 
        }

        for (var i = index; i < table.rows.length; i++) {
            table.rows[i].cells[0].innerHTML = i + 1;  // Mengupdate nomor urut
        }

        hitungTotal();
    }


    function hitungTotal() {
        var inputs = document.getElementsByName("nilai[]");
        var total = 0;
        for (var i = 0; i < inputs.length; i++) {
            var val = parseFloat(inputs[i].value.replace(/,/g, "")) || 0;
            total += val;
        }
        document.getElementById("total_nilai").innerText = total.toLocaleString();
    }

    $(document).ready(function(){
        fetch_data_karyawan();
        function fetch_data_karyawan(query = '')
        {
            $.ajax({
                url:'{{ route("remun/action_karyawan.actionKaryawan") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_karyawan tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_karyawan', function(){
            var query = $(this).val();
            fetch_data_karyawan(query);
        });
    });

    $(document).on('click', '.pilih_karyawan', function(e){
        document.getElementById('nama').value = $(this).attr('data-nama')
        document.getElementById('jabatan').value = $(this).attr('data-jabatan')
        document.getElementById('base').value = $(this).attr('data-nama_area')
        document.getElementById('id_finger').value = $(this).attr('data-nik')
        document.getElementById('id_dms').value = $(this).attr('data-id_dms')
        document.getElementById('lokasi').value = $(this).attr('data-nama_depo')
        document.getElementById('tgl_masuk').value = $(this).attr('data-tgl')
        
        $('#myModal').modal('hide');
    });

    $(document).ready(function(){
        fetch_data_tunjangan();
        function fetch_data_tunjangan(query = '')
        {
            $.ajax({
                url:'{{ route("remun/action_tunjangan.actionTunjangan") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_tunjangan tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_tunjangan', function(){
            var query = $(this).val();
            fetch_data_tunjangan(query);
        });
    });

    $(document).on('click', '.pilih_tunjangan', function (e) {
        baris = x - 1;
        
        document.getElementById('kode_tunjangan_'+baris+'').value = $(this).attr('data-id');
        document.getElementById('nama_tunjangan_'+baris+'').value = $(this).attr('data-nama_tun');
        document.getElementById('nilai_'+baris+'').value = $(this).attr('data-nilai');
        hitungTotal();

        $('#myModalTunjangan').modal('hide');
    });

    //Pilih jenis Remun
    document.getElementById('jenis_remun').addEventListener('change', function() {
        const section = document.getElementById('tanggalSection');
        section.innerHTML = ''; // reset

        if (this.value === 'Remun tetap') {
            section.innerHTML = `
                <div class="row mt-2">
                    <label class="col-sm-2 col-form-label">Tanggal Berlaku</label>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="tgl_berlaku" id="tgl_berlaku" class="form-control" required>
                    </div>
                </div>
            `;
        } else if (this.value === 'Remun tidak tetap') {
            section.innerHTML = `
                <div class="row mt-2">
                    <label class="col-sm-2 col-form-label">Periode Dari</label>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="periode_dari" id="periode_dari" class="form-control" required>
                    </div>
                    <div class="col-sm-2"></div>
                    <label class="col-sm-2 col-form-label">Sampai</label>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="periode_sampai" id="periode_sampai" class="form-control" required>
                    </div>
                </div>
            `;
        }
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Buat Remunerasi</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Remunerasi</li>
        <li class="breadcrumb-item active">Buat Remunerasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
        <form action="{{ route('remun/simpan.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data"> 
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Buat Remunerasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- <label for="principal" class="col-sm-2 col-form-label">No PTK Calon Karyawan</label> -->
                                <div class="col-md-3 mb-2" hidden>
                                    <input type="text" name="no_ptk" id="no_ptk" class="form-control" value="">
                                </div>

                                <label for="entitas" class="col-sm-2 col-form-label">Nama Calon Karyawan</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="nama" id="nama" class="form-control" value="" required>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="principal" class="col-sm-2 col-form-label">ID Finger</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="id_finger" id="id_finger" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <label for="entitas" class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="" required>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="entitas" class="col-sm-2 col-form-label">Id DMS</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="id_dms" id="id_dms" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <label for="entitas" class="col-sm-2 col-form-label">Lokasi Kerja</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="lokasi" id="lokasi" class="form-control" value="" required>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="entitas" class="col-sm-2 col-form-label">Tgl Masuk</label>
                                <div class="col-md-3 mb-2">
                                    <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control" value="" required>
                                </div>
                            </div>
                            
                            <div class="row" hidden>
                                <label for="entitas" class="col-sm-2 col-form-label">GP Base</label>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="base" id="base" class="form-control" value="">
                                </div>
                                <div class="col-sm-2"></div>
                                
                            </div>

                            <!-- Row 5: Select Remun -->
                            <div class="row">
                                <label for="jenis_remun" class="col-sm-2 col-form-label">Jenis Remunerasi</label>
                                <div class="col-md-3 mb-2">
                                    <select name="jenis_remun" id="jenis_remun" class="form-control" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Remun tetap">Remun tetap</option>
                                        <option value="Remun tidak tetap">Remun tidak tetap</option>
                                    </select>
                                </div>
                                <div class="col-sm-2"></div>
                                <label for="remin_dicairkan_di" class="col-sm-2 col-form-label">Remun dicairkan di</label>
                                <div class="col-md-3 mb-2">
                                    <select name="pencairan" id="pencairan" class="form-control" required>
                                        <option value="">-- Pilih Pencairan --</option>
                                        <option value="Biaya Depo">Biaya Depo</option>
                                        <option value="Biaya HO">Biaya HO</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 6: Tanggal Berlaku / Periode -->
                            <div id="tanggalSection"></div>
                        </div>
                    </div>  
                </div>

                

                
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="display: flex; gap: 20px; overflow-x: auto;">
                                        <table border="1" cellspacing="0" cellpadding="5" style="font-size:12px; width:100%;">
                                            <thead>
                                                <tr style="background-color:aqua; font-weight:bold; text-align:center;">
                                                    <th colspan="15">REMUNERASI CALON KARYAWAN</th>
                                                </tr>
                                                <tr style="font-weight:bold;">
                                                    <th style="text-align:center;">No</th>
                                                    <th colspan="15" align="left">Tunjangan:</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_tunjangan">
                                                <tr>
                                                    <td style="text-align:center;">1</td>
                                                    <td class="vndr">
                                                        <div class="input-group">
                                                            <input type="hidden" name="kode_tunjangan[]" id="kode_tunjangan_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <input type="text" name="nama_tunjangan[]" id="nama_tunjangan_1" class="form-control" style="font-size: 12px; height: 30px;" value="" readonly>
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-info btn-secondary" name="btn_1" id="btn_1" data-toggle="modal" data-target="#myModalTunjangan" value = "1" style="font-size: 12px; height: 30px; width: 30px;"><span class="fa fa-search"></span></button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" style="height: 30px;" class="form-control" name="nilai[]" id="nilai_1" style="font-size: 13px;" onkeyup="hitungTotal()" required></td>
                                                    <td style="text-align:center;"><button type="button" class="btn btn-primary btn-sm" onclick="tambah()">+</button></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr style="font-weight:bold;">
                                                    <th colspan="2" style="text-align:center; font-size: 15px;">T O T A L</th>
                                                    <th id="total_nilai" style="text-align:right;">0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Cek/Giro</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Hapus Cek/Giro</button> -->
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                        <!-- <button type="button" id="button_print" name="button_print" class="btn btn-primary btn-sm">Print</button> -->
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_karyawan" id="search_karyawan" class="form-control" placeholder="Cari Karyawan . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_karyawan" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Id DMS</th>
                                <th>Jabatan</th>
                                <th>Perusahaan</th>
                                <th hidden>Perusahaan</th>
                                <th hidden>Kode Depo</th>
                                <th>Depo</th>
                                <th hidden>Kode Area</th>
                                <th>Area</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalTunjangan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Tunjangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_tunjangan" id="search_tunjangan" class="form-control" placeholder="Cari Tunjangan . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_tunjangan" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tunjangan</th>
                                <th>Nilai</th>
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