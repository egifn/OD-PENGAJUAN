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

    fetchAllDataPendaftaran();
    function fetchAllDataPendaftaran(){
        let value = $("#cari").val();
        $.ajax({
            type: "GET",
            url: "{{ route('tanda_terima_h.getDataIzinH') }}",
            data: {
                value: value
            },
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 1;
                response.data.forEach(daftar => {
                    var tanggalIzin = new Date(daftar.tgl_izin);
                    var namaBulanSingkat = [
                        "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                        "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
                    ];
                    var namaBulan = namaBulanSingkat[tanggalIzin.getMonth()];
                    var formattedDate = `${twoDigit(tanggalIzin.getDate())}-${namaBulan}-${tanggalIzin.getFullYear()}`;
                    tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td>${daftar.kode_buku}</td>`;
                        tabledata += `<td>${formattedDate}</td>`;
                        tabledata += `<td>${daftar.nama_perusahaan}</td>`;
                        tabledata += `<td>${daftar.kode_seri_warkat} ${daftar.seri_awal} - ${daftar.seri_akhir}</td>`;
                        tabledata += `<td>${daftar.nama_bank}</td>`;
                        tabledata += `<td>${daftar.no_rekening}</td>`;
                        tabledata += `<td>${daftar.jml_lembar} Lembar</td>`;
                        tabledata += `<td>${daftar.jenis_warkat}</td>`;
                        tabledata += `<td>${daftar.name}</td>`;
                        tabledata += `<td hidden>${daftar.no_urut}</td>`;
                        tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_view" class="btn btn-success btn-sm">View</button>&nbsp;
                                        <button type="button" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_print" class="btn btn-primary btn-sm">Print</button>
                                        <button type="button" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_excel" class="btn btn-success btn-sm">Excel</button>  
                                      </td>`;
                                        

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
            url: "{{ route('tanda_terima_h/cari.cari') }}",
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
                        var tanggalIzin = new Date(daftar.tgl_izin);
                        var namaBulanSingkat = [
                            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                            "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
                        ];
                        var namaBulan = namaBulanSingkat[tanggalIzin.getMonth()];
                        var formattedDate = `${twoDigit(tanggalIzin.getDate())}-${namaBulan}-${tanggalIzin.getFullYear()}`;
                        tabledata += `<tr>`;
                            tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                            tabledata += `<td>${daftar.kode_buku}</td>`;
                            tabledata += `<td>${formattedDate}</td>`;
                            tabledata += `<td>${daftar.nama_perusahaan}</td>`;
                            tabledata += `<td>${daftar.kode_seri_warkat} ${daftar.seri_awal} - ${daftar.seri_akhir}</td>`;
                            tabledata += `<td>${daftar.nama_bank}</td>`;
                            tabledata += `<td>${daftar.no_rekening}</td>`;
                            tabledata += `<td>${daftar.jml_lembar} Lembar</td>`;
                            tabledata += `<td>${daftar.jenis_warkat}</td>`;
                            tabledata += `<td>${daftar.name}</td>`;
                            tabledata += `<td hidden>${daftar.no_urut}</td>`;
                            tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_view" class="btn btn-success btn-sm">View</button>&nbsp;
                                            <button type="hidden" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_print" class="btn btn-primary btn-sm">Print</button>
                                            <button type="button" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_excel" class="btn btn-success btn-sm">Excel</button> 
                                          </td>`;
                                        
                        tabledata += `</tr>`;
                    });
                } else {
                    tabledata = '<tr align = "center"><td colspan="11">Tidak ada data ditemukan.</td></tr>';
                }
                $("#tabledata").html(tabledata);
            }
        });
    });

    $("#cari").keyup(function() {
        let value = $("#cari").val();
        let tgl = $("#tanggal").val();
        if (this.value.length >= 2) {
            $.ajax({
                type: "GET",
                url: "{{ route('tanda_terima_h.getDataIzinH') }}",
                data: {
                    value: value,
                    tgl: tgl, 
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 1;
                    response.data.forEach(daftar => {
                        var tanggalIzin = new Date(daftar.tgl_izin);
                        var namaBulanSingkat = [
                            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                            "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
                        ];
                        var namaBulan = namaBulanSingkat[tanggalIzin.getMonth()];
                        var formattedDate = `${twoDigit(tanggalIzin.getDate())}-${namaBulan}-${tanggalIzin.getFullYear()}`;
                        tabledata += `<tr>`;
                            tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                            tabledata += `<td>${daftar.kode_buku}</td>`;
                            tabledata += `<td>${formattedDate}</td>`;
                            tabledata += `<td>${daftar.nama_perusahaan}</td>`;
                            tabledata += `<td>${daftar.kode_seri_warkat} ${daftar.seri_awal} - ${daftar.seri_akhir}</td>`;
                            tabledata += `<td>${daftar.nama_bank}</td>`;
                            tabledata += `<td>${daftar.no_rekening}</td>`;
                            tabledata += `<td>${daftar.jml_lembar} Lembar</td>`;
                            tabledata += `<td>${daftar.jenis_warkat}</td>`;
                            tabledata += `<td>${daftar.name}</td>`;
                            tabledata += `<td hidden>${daftar.no_urut}</td>`;
                            tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_view" class="btn btn-success btn-sm">View</button>&nbsp;
                                            <button type="hidden" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_print" class="btn btn-primary btn-sm">Print</button>
                                            <button type="button" data-id="${daftar.kode_buku}" data-tgl="${daftar.tgl_izin}" data-kode-seri="${daftar.kode_seri_warkat}" data-seri-awal="${daftar.seri_awal}" data-seri-akhir="${daftar.seri_akhir}" data-no-urut="${daftar.no_urut}" data-lembar="${daftar.jml_lembar}" id="button_excel" class="btn btn-success btn-sm">Excel</button>
                                          </td>`;
                        tabledata += `</tr>`;
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }else{
            fetchAllDataPendaftaran();
        }
    });

    $(document).on("click", "#button_view", function(e) {
        e.preventDefault();
        let no_izin = $(this).data('id');
        let tgl_izin = $(this).data('tgl');
        let kode_seri_warkat = $(this).data('kode-seri');
        let seri_awal = $(this).data('seri-awal');
        let seri_akhir = $(this).data('seri-akhir');
        let jml_lembar = $(this).data('lembar')
        let no_urut = $(this).data('no-urut');

        $.ajax({
            type: "GET",
            url: "{{ route('tanda_terima_h/getViewDetail') }}",
            data: {
                no_izin: no_izin,
                no_urut: no_urut,
                kode_seri_warkat: kode_seri_warkat,
                seri_awal: seri_awal,
                seri_akhir: seri_akhir
            },
            dataType: "json",
            success: function(response) {
                $(".kode").text(no_izin);
                $(".seri_warkat").text(kode_seri_warkat);
                $(".seri_awal").text(seri_awal);
                $(".seri_akhir").text(seri_akhir);
                $(".jml_lembar").text(jml_lembar);

                let tbl_detail;
                let no = 0;
                response.data.forEach(detail => {
                    no = no + 1
                    tbl_detail += `<tr>`;
                    tbl_detail += `<td>` +no+ `</td>`;
                    tbl_detail += `<td>${detail.id_cek}</td>`;
                    tbl_detail += `<td>${detail.nama_perusahaan}</td>`;
                    tbl_detail += `<td>${detail.nama_bank}</td>`;
                    tbl_detail += `<td>${detail.no_rekening}</td>`;
                    tbl_detail += `<td>${detail.jenis_warkat}</td>`;
                    tbl_detail += `</tr>`;
                });
                $("#tbl_detail").html(tbl_detail);
            }
        });
        $('#modalView').modal('show');
    });

    $(document).on("click", "#button_print", function(e) {
        e.preventDefault();
        let no_izin = $(this).data('id');
        let tgl_izin = $(this).data('tgl');
        let kode_seri_warkat = $(this).data('kode-seri');
        let seri_awal = $(this).data('seri-awal');
        let seri_akhir = $(this).data('seri-akhir');
        let jml_lembar = $(this).data('lembar')
        let no_urut = $(this).data('no-urut');

        $.ajax({
            type: "GET",
            url: "{{ route('tanda_terima_h/pdf') }}",
            data: {
                no_izin: no_izin,
                no_urut: no_urut,
                kode_seri_warkat: kode_seri_warkat,
                seri_awal: seri_awal,
                seri_akhir: seri_akhir
            },
            dataType: "json",
            success: function(response) {
            
            }
        });
        let mywindow = window.open("{{ route('tanda_terima_h/pdf') }}?kode_buku=" + no_izin + "", '_blank');
    });

    $(document).on("click", "#button_excel", function(e) {
        e.preventDefault();
        let no_izin = $(this).data('id');
        let tgl_izin = $(this).data('tgl');
        let kode_seri_warkat = $(this).data('kode-seri');
        let seri_awal = $(this).data('seri-awal');
        let seri_akhir = $(this).data('seri-akhir');
        let jml_lembar = $(this).data('lembar')
        let no_urut = $(this).data('no-urut');

        $.ajax({
            type: "GET",
            url: "{{ route('tanda_terima_h/excel') }}",
            data: {
                no_izin: no_izin,
                no_urut: no_urut,
                kode_seri_warkat: kode_seri_warkat,
                seri_awal: seri_awal,
                seri_akhir: seri_akhir
            },
            dataType: "json",
            success: function(response) {
            
            }
        });
        let mywindow = window.open("{{ route('tanda_terima_h/excel') }}?kode_buku=" + no_izin + "", '_blank');
    });

</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Izin H</title>
@endsection

@section('content')

<main class="main">
    <style>
        .modal-dialog {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
        }
    
        .modal-content {
            width: 100%;
            max-width: 100%;
            height: 100%;
            border: 0;
            border-radius: 0;
        }
    </style>
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">Izin</li>
        <li class="breadcrumb-item active">Izin H</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Izin H
                                <a href="{{ route('tanda_terima_h.create') }}" class="btn btn-primary btn-sm float-right" hidden>Buat Izin H</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="input-group mb-2">
                                        <input type="text" name="cari" id="cari" class="form-control" placeholder="Pencarian Data">
                                    </div>
                                </div>

                                <div class="col-md-5 mb-2">
                                </div>
                                
                                <div class="col-md-3 mb-2">
                                    <div class="input-group mb-2">
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" name="button_cari_tanggal" id="button_cari_tanggal" value="tgl">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                {{-- <table class="table table-bordered table-striped table-sm"> --}}
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Izin</th>
                                            <th>Tgl.Izin</th>
                                            <th>Perusahaan</th>
                                            <th>No.Warkat</th>
                                            <th>Bank</th>
                                            <th>No Rekening</th>
                                            <th>jml Lembar</th>
                                            <th>Jenis Warkat</th>
                                            <th>Dibuat oleh</th>
                                            <th hidden>No Urut</th>
                                            <th>Aksi</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">

                                                   
                                    </tbody>
                                </table>
                               
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="modalView" >
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="background: #fff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Izin H</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="inputNama" class="form-label">No Izin: </label> 
                        <label for="inputNama" class="form-label kode" style="font-weight: bold;"></label> 
                    </div>
                    {{-- <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Kode Seri Warkat: </label> 
                        <label for="inputNama" class="form-label seri_warkat" style="font-weight: bold;"></label>
                    </div>
                    <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Seri Awal: </label> 
                        <label for="inputNama" class="form-label seri_awal" style="font-weight: bold;"></label>
                    </div>
                    <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Seri Akhir: </label> 
                        <label for="inputNama" class="form-label seri_akhir" style="font-weight: bold;"></label>
                    </div>
                    <div class="col-sm-2">
                        <label for="inputNama" class="form-label">Jml Lembar: </label> 
                        <label for="inputNama" class="form-label jml_lembar" style="font-weight: bold;"></label>
                    </div> --}}
                </div>
                <div class="table-responsive">
                    <div style="border:1px white;width:100%;height:550px;overflow-y:scroll;">
                        <table id="datatabel" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Cek/Giro</th>
                                    <th>Perusahaan</th>
                                    <th>Bank</th>
                                    <th>No Rekening</th>
                                    <th>Jenis</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_detail" class="tbl_detail">
            
                            </tbody>
                        </table>
                    </div>
                </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection