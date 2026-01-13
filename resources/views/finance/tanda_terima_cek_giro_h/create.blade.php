@section('js')
<script type="text/javascript">
    // var x = 2;

    // function tambah() {
    //     var table = document.getElementById("table_warkat");
    //     //buat baris baru
    //     var row = table.insertRow(-1);

    //     for (var i = 0; i < 10; i++) { // Ganti 10 dengan jumlah kolom yang Anda miliki
    //         var cell = row.insertCell(i);
    //         if (i === 0) {
    //             cell.innerHTML = table.rows.length; // Nomor urutan
    //         } else if (i === 1) {
    //             cell.innerHTML = '<select name="kode_perusahaan[]" id="kode_perusahaan_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" onchange="jumlah(' + x + ');" ><option value="">Perusahaan</option>@foreach ($perusahaan as $row)<option value="{{ $row->kode_perusahaan }}" data-nama-perusahaan="{{ $row->nama_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ?'selected':'' }}>{{ $row->nama_perusahaan }}</option>@endforeach</select>';
    //         } else if (i === 2) {
    //             cell.innerHTML = '<select name="kode_bank[]" id="kode_bank_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" onchange="jumlah(' + x + ');" ><option value="">Bank</option>@foreach ($bank as $row)<option value="{{ $row->kode_bank }}" data-nama-bank="{{ $row->nama_bank }}" {{ old('kode_bank') == $row->kode_bank ?'selected':'' }}>{{ $row->nama_bank }}</option>@endforeach</select>';
    //         } else if (i === 3) {
    //             cell.innerHTML = '<select name="norek[]" id="norek_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" onchange="jumlah(' + x + ');" ><option value="">No Rekening</option>@foreach ($rekening_fin_comp as $row)<option value="{{ $row->norek }}" {{ old('norek') == $row->norek ?'selected':'' }}>{{ $row->norek }}</option>@endforeach</select>';
    //         } else if (i === 4) {
    //             cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="kd_seri_warkat[]" id="kd_seri_warkat_'+x+'" style="font-size: 13px;" onkeyup="jumlah(' + x + ');">';
    //         } else if (i === 5) {
    //             cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="no_seri_awal[]" id="no_seri_awal_'+x+'" onkeyup="jumlah(' + x + ');" style="font-size: 13px;" value = "0">';
    //         } else if (i === 6) {
    //             cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="no_seri_akhir[]" id="no_seri_akhir_'+x+'" onkeyup="jumlah(' + x + ');" style="font-size: 13px;" value = "0">';
    //         } else if (i === 7) {
    //             cell.innerHTML = '<select name="jenis[]" id="jenis_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" onchange="jumlah(' + x + ');" ><option value="">Pilih</option><option value="Cek">Cek</option><option value="Giro">Giro</option><option>Slip</option></select>';
    //         } else if (i === 8) {
    //             cell.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="jml_lembar[]" id="jml_lembar_'+x+'" style="font-size: 13px;" value="">';
    //         } else if (i === 9) {
    //             cell.innerHTML = '<button type="button" class="btn btn-primary btn-sm" onclick="tambah()">+</button>'; // Tombol +
    //         }
    //     }

    //     var no_awal = document.getElementById("awal").value;
    //     var no_akhir = document.getElementById("akhir").value;
    //     var lembar = document.getElementById("jml_lembar").value;
    //     for(i=no_awal; i <=no_akhir; i++){
    //         var nol = String(i).padStart(no_awal.length, '0');
        
    //         var tabel = document.getElementById("tabelRincian");
    //         var row = tabel.insertRow(1);

    //         var kode_perusahaan = document.getElementById("perusahaan").value;
    //         var nama_perusahaan = document.getElementById("nm_perusahaan").value;
    //         var kode_bank = document.getElementById("bank").value;
    //         var nama_bank = document.getElementById("nm_bank").value;
    //         var no_rek = document.getElementById("no_rekening").value;
    //         var kode_seri_warkat = document.getElementById("kd_sr_warkat").value;
    //         var seri_awal = document.getElementById("awal").value;
    //         var seri_akhir = document.getElementById("akhir").value;
    //         var jenis = document.getElementById("jenis_w").value;
    //         var j_lembar = document.getElementById("jml_lembar").value;

    //         var cell1 = row.insertCell(0);
    //         var cell2 = row.insertCell(1);
    //         cell2.style.display = "none";
    //         var cell3 = row.insertCell(2);
    //         cell3.style.display = "none";
    //         var cell4 = row.insertCell(3);
    //         var cell5 = row.insertCell(4);
    //         cell5.style.display = "none";
    //         var cell6 = row.insertCell(5);
    //         var cell7 = row.insertCell(6); 
    //         var cell8 = row.insertCell(7);
    //         var cell9 = row.insertCell(8);
    //         var cell10 = row.insertCell(9);
    //         var cell11 = row.insertCell(10);
    //         var cell12 = row.insertCell(11);
    //         cell12.style.display = "none";

    //         cell1.innerHTML = '<input type="text" class="form-control" name="kode_cek[]" id="kode_cek" style="font-size:13px; width:100px;" value="'+kode_seri_warkat+''+" "+nol+'" readonly />'
    //         cell2.innerHTML = '<input type="hidden" class="form-control" name="no_cek[]" id="no_cek" style="font-size:13px; width:100px;" value="'+nol+'" readonly />'            
    //         cell3.innerHTML = '<input type="hidden" class="form-control" name="perusahaan_rincian[]" id="perusahaan_rincian" style="font-size: 13px; width:250px;" value="'+kode_perusahaan+'" readonly>'//b;
    //         cell4.innerHTML = '<input type="text" class="form-control" name="nama_perusahaan_rincian[]" id="nama_perusahaan_rincian" style="font-size: 13px; width:250px;" value="'+nama_perusahaan+'" readonly>'//b;
    //         cell5.innerHTML = '<input type="hidden" class="form-control" name="bank_rincian[]" id="bank_rincian" style="font-size: 13px;" value="'+kode_bank+'" readonly>'//c;
    //         cell6.innerHTML = '<input type="text" class="form-control" name="nama_bank_rincian[]" id="nama_bank_rincian" style="font-size: 13px; width:250px;" value="'+nama_bank+'" readonly>'//b;
    //         cell7.innerHTML = '<input type="text" class="form-control" name="no_rek_rincian[]" id="no_rek_rincian" style="font-size: 13px;" value="'+no_rek+'" readonly>'//d;
    //         cell8.innerHTML = '<input type="text" class="form-control" name="seri_warkat_rincian[]" id="seri_warkat_rincian" style="font-size: 13px;" value="'+kode_seri_warkat+'" readonly>'//e;
    //         cell9.innerHTML = '<input type="text" class="form-control" name="awal_rincian[]" id="awal_rincian" style="font-size: 13px;" value="'+seri_awal+'" readonly>'
    //         cell10.innerHTML = '<input type="text" class="form-control" name="akhir_rincian[]" id="akhir_rincian" style="font-size: 13px; width:100px;" value="'+seri_akhir+'" readonly>'
    //         cell11.innerHTML = '<input type="text" class="form-control" name="jenis_rincian[]" id="jenis_lembar_rincian" style="font-size: 13px;" value="'+jenis+'" readonly>'
    //         cell12.innerHTML = '<input type="hidden" class="form-control" name="jml_lembar_rincian[]" id="jml_lembar_rincian" style="font-size: 13px;" value="'+j_lembar+'" readonly>'
    //     }

    //     x++;
    // };

    function jumlah(x){
        var no_seri_awal = document.getElementById("seri_awal").value;
        var no_seri_akhir = document.getElementById("seri_akhir").value;
        
        alert(no_seri_awal);
        alert(no_seri_akhir);

        var jumlah = parseInt(no_seri_akhir) - parseInt(no_seri_awal) +1;
        document.getElementById("jml_lembar_" + x).value = jumlah;
        document.getElementById("jml_lembar").value = jumlah;

        var kode_perusahaan = document.getElementById("kode_perusahaan_" + x).value;
        document.getElementById("perusahaan").value = kode_perusahaan;
        //================================================================
        var kodePerusahaanComboBox = document.getElementById("kode_perusahaan_" + x);
        var selectedIndex = kodePerusahaanComboBox.selectedIndex;
        var selectedOption = kodePerusahaanComboBox.options[selectedIndex];
        var namaPerusahaanValue = selectedOption.getAttribute("data-nama-perusahaan");
        document.getElementById("nm_perusahaan").value = namaPerusahaanValue;
        //================================================================

        var kode_bank = document.getElementById("kode_bank_" + x).value;
        document.getElementById("bank").value = kode_bank;
        //================================================================
        var kodeBankComboBox = document.getElementById("kode_bank_" + x);
        var selectedIndex = kodeBankComboBox.selectedIndex;
        var selectedOption = kodeBankComboBox.options[selectedIndex];
        var namaBankValue = selectedOption.getAttribute("data-nama-bank");
        document.getElementById("nm_bank").value = namaBankValue;
        //================================================================

        var no_rekening = document.getElementById("norek_" + x).value;
        document.getElementById("no_rekening").value = no_rekening;

        var seri_warkat = document.getElementById("kd_seri_warkat_" + x).value;
        document.getElementById("kd_sr_warkat").value = seri_warkat;

        var no_awal = document.getElementById("no_seri_awal_" + x).value;
        document.getElementById("awal").value = no_awal;

        var no_akhir = document.getElementById("no_seri_akhir_" + x).value;
        document.getElementById("akhir").value = no_akhir;

        var jenis = document.getElementById("jenis_" + x).value;
        document.getElementById("jenis_w").value = jenis;        
    }

    $(document).ready(function() {
        fetch_data();

        function fetch_data(query = '') {
            $.ajax({
                url: '{{ route("tanda_terima_h.action") }}',
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            fetch_data(query);
        });
    });

    var x = 0;
    var total_1 = 0;
    $(document).on('click', '.pilih', function(e) {
        x++;
        var total = 0;
        var tabel = document.getElementById("tabelwarkat");
        var row = tabel.insertRow(1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell2.style.display = 'none';
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell4.style.display = 'none';
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);
        var cell8 = row.insertCell(7);
        var cell9 = row.insertCell(8);
        var cell10 = row.insertCell(9);
        var cell11 = row.insertCell(10);
        var cell12 = row.insertCell(11);

        cell7.width = '80px';
        cell8.width = '80px';
        cell9.width = '80px';

        var a = $(this).attr('');
        var b = $(this).attr('data-kode');
        var c = $(this).attr('data-kode_perusahaan');
        var d = $(this).attr('data-nama_perusahaan');
        var e = $(this).attr('data-kode_bank');
        var f = $(this).attr('data-nama_bank');
        var g = $(this).attr('data-no_rekening');
        var h = $(this).attr('data-jenis_buku');
        var i = $(this).attr('data-jml_lembar');
        
        cell1.innerHTML = '<input name="chk" type="checkbox" />';
        cell2.innerHTML = '<input type="hidden" name="kode_perusahaan[]" id="kode_perusahaan" value="'+c+'" style="border:none;"/>'+c+''
        cell3.innerHTML = '<input type="hidden" name="nama_perusahaan[]" id="nama_perusahaan" value="'+d+'" style="border:none;"/>'+d+''
        cell4.innerHTML = '<input type="hidden" name="kode_bank[]" id="kode_bank" value="'+e+'" style="border:none;"/>'+e+''
        cell5.innerHTML = '<input type="hidden" name="nama_bank[]" id="nama_bank" value="'+f+'" style="border:none;"/>'+f+''
        cell6.innerHTML = '<input type="hidden" name="no_rekening[]" id="no_rekening" value="'+g+'" style="border:none;"/>'+g+''
        cell7.innerHTML = '<input type="text" name="kode_seri[]" id="kode_seri" value="" style="text-align:right; width:50px"/>'//e;
        cell8.innerHTML = '<input type="text" name="seri_awal[]" id="seri_awal" value="" onchange="jumlah()"  style="text-align:right; width:50px"/>'//e;
        cell9.innerHTML = '<input type="text" name="seri_akhir[]" id="seri_akhir" value="" onchange="jumlah()" style="text-align:right; width:50px"/>'//e;
        cell10.innerHTML = '<input type="hidden" name="jenis_buku[]" id="jenis_buku" value="'+h+'" style="border:none;"/>'+h+''
        cell11.innerHTML = '<input type="text" name="jml_buku[]" id="jml_buku" value="" style="border:none;"/>'
        cell12.innerHTML = '<input type="text" name="jml_lembar[]" id="jml_lembar" value="'+i+'" style="border:none;"/>';
        

        var total = d;
        $('#myModal').modal('hide');
        total_1 = parseInt(total_1) + parseInt(total);

        $('#total_harga').val(total_1);
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
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item">Izin H</li>
        <li class="breadcrumb-item active">Buat Izin H</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('tanda_terima_h.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Izin H</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tanggal Izin
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        No.Izin
                                        <input type="text" name="no_izin" id="no_izin" class="form-control" value="" required>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Judul Izin <!-- Keterangan -->
                                        <input type="text" name="judul_izin" id="judul_izin" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Catatan <!-- Keterangan -->
                                        <input type="text" name="catatan" id="catatan" class="form-control">
                                    </div>


                                    <div class="col-md-1 mb-2" hidden>
                                        Jml lembar <!-- Keterangan -->
                                        <input type="text" name="jml_lembar" id="jml_lembar" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        perusahaan <!-- Keterangan -->
                                        <input type="text" name="perusahaan" id="perusahaan" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Nama Perusahaan <!-- Keterangan -->
                                        <input type="text" name="nm_perusahaan" id="nm_perusahaan" class="form-control">
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Bank <!-- Keterangan -->
                                        <input type="text" name="bank" id="bank" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Nama Bank <!-- Keterangan -->
                                        <input type="text" name="nm_bank" id="nm_bank" class="form-control">
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Rekening <!-- Keterangan -->
                                        <input type="text" name="no_rekening" id="no_rekening" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Kode Seri Warkat <!-- Keterangan -->
                                        <input type="text" name="kd_sr_warkat" id="kd_sr_warkat" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Seri Awal <!-- Keterangan -->
                                        <input type="text" name="awal" id="awal" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Seri Akhir <!-- Keterangan -->
                                        <input type="text" name="akhir" id="akhir" class="form-control">
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Jenis <!-- Keterangan -->
                                        <input type="text" name="jenis_w" id="jenis_w" class="form-control">
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
                                                                    <th>No</th>
                                                                    <th hidden>Kode Perusahaan</th>
                                                                    <th>Perusahaan</th>
                                                                    <th hidden>Kode Bank</th>
                                                                    <th>Bank</th>
                                                                    <th>No Rekening</th>
                                                                    <th>Kode Seri Warkat</th>
                                                                    <th>No Seri Awal</th>
                                                                    <th>No Seri Akhir</th>
                                                                    <th>Jenis Warkat</th>
                                                                    <th>Jml Lembar</th>
                                                                    <th>Jml Lembar 2</th>
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
                                                                    <th>No Warkat</th>
                                                                    <th hidden>No Warkat</th>
                                                                    <th hidden>Kode Perusahaan</th>
                                                                    <th>Perusahaan</th>
                                                                    <th hidden>KodeBank</th>
                                                                    <th>Bank</th>
                                                                    <th>No.Rek</th>
                                                                    <th>Seri Warkat</th>
                                                                    <th>Awal</th>
                                                                    <th>Akhir</th>
                                                                    <th>jenis</th>
                                                                    <th hidden>Lembar</th>
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
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Daftar Permintaan</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelwarkat')">Hapus SPP</button>
                                    </div>  
                                    <div class="col-md-8 mb-2">
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Permintaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode Permintaan</th>
                            <th>Tgl Permintaan</th>
                            <th hidden>Keterangan</th>
                            <th hidden>kode perusahaan</th>
                            <th>Perusahaan</th>
                            <th hidden>kode bank</th>
                            <th>Bank</th>
                            <th>No Rekening</th>
                            <th>Jml Buku</th>
                            <th>Jenis Buku</th>
                            <th hidden>Pembawa Resi</th>
                            <th>Jml Lembar</th>
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