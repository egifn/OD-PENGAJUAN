@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script> 
    $(document).ready(function() {
        //INISIASI DATERANGEPICKER
        $('#tanggal').daterangepicker({
               
        })        
    })
</script>

<script type="text/javascript">
    function twoDigit(number) {
        return (number < 10 ? '0' : '') + number;
    }

    fetchAllDataPengajuanBbm();
    function fetchAllDataPengajuanBbm(){
        let value = $("#cari").val();
        $.ajax({
            type: "GET",
            url: "{{ route('pengajuan_biaya_bbm_sales.getDataBbm') }}",
            data: {
                value: value
            },
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 1;
                response.data.forEach(daftar => {

                    //membuat format rupiah Harga//
                    var reverse_harga = daftar.harga_perliter.toString().split('').reverse().join(''),
                    ribuan_harga  = reverse_harga.match(/\d{1,3}/g);
                    harga_rupiah = ribuan_harga.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    //membuat format rupiah Harga//
                    var reverse_harga_total = daftar.total.toString().split('').reverse().join(''),
                    ribuan_harga_total  = reverse_harga_total.match(/\d{1,3}/g);
                    harga_rupiah_total = ribuan_harga_total.join(',').split('').reverse().join('');

                    var tanggalIzin = new Date(daftar.tgl_pengajuan_bbm);
                    var namaBulanSingkat = [
                        "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                        "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
                    ];
                    var namaBulan = namaBulanSingkat[tanggalIzin.getMonth()];
                    var formattedDate = `${twoDigit(tanggalIzin.getDate())}-${namaBulan}-${tanggalIzin.getFullYear()}`;
                    tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td>${daftar.kode_pengajuan_bbm}</td>`;
                        tabledata += `<td>${formattedDate}</td>`;
                        tabledata += `<td>${daftar.kode_perusahaan}</td>`;
                        tabledata += `<td>${daftar.nama_depo}</td>`;
                        tabledata += `<td>${daftar.nama_pengeluaran}</td>`;
                        tabledata += `<td>${daftar.nopol}</td>`;
                        tabledata += `<td>${daftar.nama_sales}</td>`;
                        tabledata += `<td align="right">${daftar.km_akhir}</td>`;
                        tabledata += `<td>${daftar.nama_bbm}</td>`;
                        tabledata += `<td align="right">${daftar.volume_perliter} liter</td>`;
                        tabledata += `<td align="right">${harga_rupiah}</td>`;
                        tabledata += `<td align="right">${harga_rupiah_total}</td>`;
                        tabledata += `<td hidden>${daftar.name}</td>`;
                        tabledata += `<td hidden>${daftar.no_urut}</td>`;
                        tabledata += `<td hidden align="center"><button type="button" data-id="${daftar.kode_pengajuan_bbm}" data-tgl="${daftar.tgl_pengajuan_bbm}"   data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-success btn-sm">View</button>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
            }
        });
    }

    $("#button_cari_tanggal").click(function(){
        let tgl_cari = $("#tanggal").val();
        let value = $("#cari").val();

        $.ajax({
            type: "GET",
            url: "{{ route('pengajuan_biaya_bbm_sales.cari') }}",
            data: {
                tgl_cari: tgl_cari,
                value: value
            },
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 1;

                $("#tabledata").empty();

                if (response.data.length > 0) {
                    response.data.forEach(daftar => {
                        //membuat format rupiah Harga//
                        var reverse_harga = daftar.harga_perliter.toString().split('').reverse().join(''),
                        ribuan_harga  = reverse_harga.match(/\d{1,3}/g);
                        harga_rupiah = ribuan_harga.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        //membuat format rupiah Harga//
                        var reverse_harga_total = daftar.total.toString().split('').reverse().join(''),
                        ribuan_harga_total  = reverse_harga_total.match(/\d{1,3}/g);
                        harga_rupiah_total = ribuan_harga_total.join(',').split('').reverse().join('');

                        var tanggalIzin = new Date(daftar.tgl_pengajuan_bbm);
                        var namaBulanSingkat = [
                            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                            "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
                        ];
                        var namaBulan = namaBulanSingkat[tanggalIzin.getMonth()];
                        var formattedDate = `${twoDigit(tanggalIzin.getDate())}-${namaBulan}-${tanggalIzin.getFullYear()}`;
                        tabledata += `<tr>`;
                            tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                            tabledata += `<td>${daftar.kode_pengajuan_bbm}</td>`;
                            tabledata += `<td>${formattedDate}</td>`;
                            tabledata += `<td>${daftar.kode_perusahaan}</td>`;
                            tabledata += `<td>${daftar.nama_depo}</td>`;
                            tabledata += `<td>${daftar.nama_pengeluaran}</td>`;
                            tabledata += `<td>${daftar.nopol}</td>`;
                            tabledata += `<td>${daftar.nama_sales}</td>`;
                            tabledata += `<td align="right">${daftar.km_akhir}</td>`;
                            tabledata += `<td>${daftar.nama_bbm}</td>`;
                            tabledata += `<td align="right">${daftar.volume_perliter} liter</td>`;
                            tabledata += `<td align="right">${harga_rupiah}</td>`;
                            tabledata += `<td align="right">${harga_rupiah_total}</td>`;
                            tabledata += `<td hidden>${daftar.name}</td>`;
                            tabledata += `<td hidden>${daftar.no_urut}</td>`;
                            tabledata += `<td hidden align="center"><button type="button" data-id="${daftar.kode_pengajuan_bbm}" data-tgl="${daftar.tgl_pengajuan_bbm}"   data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-success btn-sm">View</button>`;
                        tabledata += `</tr>`;
                    });
                } else {
                    tabledata = '<tr align = "center"><td colspan="11">Tidak ada data ditemukan.</td></tr>';
                }
                $("#tabledata").html(tabledata);
            }
        });
    });

</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Input BBM Sales</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Input BBM Sales</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Input BBM Sales
                                <a href="{{ route('pengajuan_biaya_bbm_sales.create') }}" class="btn btn-primary btn-sm float-right">Input BBM</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="get">
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="button" name="button_cari_tanggal" id="button_cari_tanggal" value="tgl">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">    
                                 <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Id</th>
                                            <th>Tgl Pengajuan</th>
                                            <th hidden>kode Perusahaan</th>
                                            <th hidden>Company Name</th>
                                            <th>Perusahaan</th>
                                            <th>Depo</th>
                                            <th hidden>Kode Pengajuan</th>
                                            <th>Permintaan Pengajuan</th>
                                            <th>No Pol</th>
                                            <th>Nama Sopir</th>
                                            <th>Km. Akhir</th>
                                            <th>Bbm</th>
                                            <th>Vol. perliter</th>
                                            <th>Harga perliter</th>
                                            <th>Total</th>
                                            <th hidden>Pengajuan Oleh</th>
                                            <th hidden>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
                                            
                                    </tbody>
                                    <tfoot id="table_footer">

                                    </tfoot>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection

