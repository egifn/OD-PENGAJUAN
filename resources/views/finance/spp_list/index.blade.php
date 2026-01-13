@extends('layouts.admin')

@section('title')
    <title>Pembayaran</title>
@endsection

@section('content')

<main class="main">
    <style>
        .modal-dialog.modal-fullscreen {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content {
            height: 100%;
            border-radius: 0;
        }

        .modal-header, .modal-body, .modal-footer {
            padding: 20px;
        }

        /* Agar isi modal memenuhi ruang yang tersedia */
        .modal-body {
            overflow-y: auto;
            max-height: calc(100vh - 120px); /* Sesuaikan untuk memberikan ruang untuk header dan footer */
        }
    </style>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item active">Pembayaran</li>
    </ol>
    
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Penerimaan Pengajuan
                                <a href="{{ route('list_spp.create') }}" class="btn btn-primary btn-sm float-right">Buat Penerimaan</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('spp/cari.cari') }}" method="get">
                                <div class="row">
                                    <div class="input-group mb-3 col-md-4">  
                                        
                                    </div> 
                                    
                                    <div class="input-group mb-3 col-md-4">

                                    </div>

                                    <div class="input-group mb-3 col-md-4 float-right">  
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                        &nbsp
                                        <button type="button" class="btn btn-secondary" name="button_cari_tanggal" id="button_cari_tanggal" value="tgl">C a r i</button>
                                    </div>    
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Penerimaan SPP</th>
											<th>Tanggal Penerimaan</th>
                                            <th>Cara Bayar</th>
                                            <th>Keterangan</th>
                                            <th>Nama Penerima</th>
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

    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document"> <!-- Menggunakan modal-fullscreen -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Penerimaan SPP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="inputNama" class="form-label">Kode Penerimaan: </label> 
                            <label for="inputNama" class="form-label kode" style="font-weight: bold;"></label> 
                        </div>
                    </div>

                    <table id="datatabel" class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th hidden>No Urut SPP</th>
                                <th>No SPP</th>
                                <th>Tgl SPP</th>
                                <th>Tgl Jatuh Tempo</th>
                                <th>Keterangan SPP</th>
                                <th>Perusahaan</th>
                                <th>Jumlah</th>
                                <th>Kode Vendor</th>
                                <th>Vendor/Supplier</th>
                                <th hidden>Cara Bayar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbl_detail" class="tbl_detail">

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

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
        fetchAllSppTerima();
        function fetchAllSppTerima() {
            $.ajax({
                type: "GET",
                url: "{{ route('list_spp/getDataSppTerima') }}",
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 0;
                    response.data.forEach(list => {
                        const formattedDateTerima = moment(list.tgl_penerimaan, 'YYYY-MM-DD').format('DD-MMM-YYYY');
                    
                        no = no + 1
                        tabledata += '<tr>';

                        tabledata += '<td class="no">'; 
                            tabledata += no; 
                            tabledata += '<input type="hidden" class="form-control" name="no[]' + no +'" id="no[]' + no +'" value="'+ no +'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="kode_spp_penerimaan">';
                            tabledata += list.kode_spp_penerimaan;
                            tabledata += '<input type="hidden" class="form-control" name="kode_spp_penerimaan[]' + no +'" id="kode_spp_penerimaan[]' + no +'" value="'+list.kode_spp_penerimaan+'">';
                        tabledata += '</td>';

                        tabledata += '<td class="tgl_spp">';
                            tabledata += formattedDateTerima;
                            tabledata += '<input type="hidden" class="form-control" name="tgl_penerimaan[]' + no +'" id="tgl_penerimaan[]' + no +'" value="'+list.tgl_penerimaan+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="cara_bayar">';
                            tabledata += list.cara_bayar;
                            tabledata += '<input type="hidden" class="form-control" name="cara_bayar[]' + no +'" id="cara_bayar[]' + no +'" value="'+list.cara_bayar+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="keterangan">';
                            tabledata += list.keterangan;
                            tabledata += '<input type="hidden" class="form-control" name="keterangan[]' + no +'" id="keterangan[]' + no +'" value="'+list.keterangan+'">';
                        tabledata += '</td>';
                    
                        tabledata += '<td class="name">';
                            tabledata += list.name;
                            tabledata += '<input type="hidden" class="form-control" name="nama_user[]' + no +'" id="nama_user[]' + no +'" value="'+list.name+'">';
                        tabledata += '</td>';

                        tabledata += '<td align="center">';
                            tabledata += '<button type="button" data-id="'+list.kode_spp_penerimaan+'" data-tgl="${list.tgl_penerimaan}" id="button_view" class="btn btn-success btn-sm">View</button>';
                        tabledata += '</td>';
                    
                        tabledata += '</tr>';
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }

        $("#button_cari_tanggal").click(function(){
            let tgl_cari = $("#tanggal").val();
            $.ajax({
                type: "GET",
                url: "{{ route('list_spp/cari.cari') }}",
                data: {
                    tgl_cari: tgl_cari
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 0;
                    response.data.forEach(list => {
                        const formattedDateTerima = moment(list.tgl_penerimaan, 'YYYY-MM-DD').format('DD-MMM-YYYY');
                    
                        no = no + 1
                        tabledata += '<tr>';

                        tabledata += '<td class="no">'; 
                            tabledata += no; 
                            tabledata += '<input type="hidden" class="form-control" name="no[]' + no +'" id="no[]' + no +'" value="'+ no +'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="kode_spp_penerimaan">';
                            tabledata += list.kode_spp_penerimaan;
                            tabledata += '<input type="hidden" class="form-control" name="kode_spp_penerimaan[]' + no +'" id="kode_spp_penerimaan[]' + no +'" value="'+list.kode_spp_penerimaan+'">';
                        tabledata += '</td>';

                        tabledata += '<td class="tgl_spp">';
                            tabledata += formattedDateTerima;
                            tabledata += '<input type="hidden" class="form-control" name="tgl_penerimaan[]' + no +'" id="tgl_penerimaan[]' + no +'" value="'+list.tgl_penerimaan+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="cara_bayar">';
                            tabledata += list.cara_bayar;
                            tabledata += '<input type="hidden" class="form-control" name="cara_bayar[]' + no +'" id="cara_bayar[]' + no +'" value="'+list.cara_bayar+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="keterangan">';
                            tabledata += list.keterangan;
                            tabledata += '<input type="hidden" class="form-control" name="keterangan[]' + no +'" id="keterangan[]' + no +'" value="'+list.keterangan+'">';
                        tabledata += '</td>';
                    
                        tabledata += '<td class="name">';
                            tabledata += list.name;
                            tabledata += '<input type="hidden" class="form-control" name="nama_user[]' + no +'" id="nama_user[]' + no +'" value="'+list.name+'">';
                        tabledata += '</td>';

                        tabledata += '<td align="center">';
                            tabledata += '<button type="button" data-id="'+list.kode_spp_penerimaan+'" id="button_view" class="btn btn-success btn-sm">View</button>';
                        tabledata += '</td>';
                    
                        tabledata += '</tr>';
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        });

        $(document).on("click", "#button_view", function(e) {
            e.preventDefault();
            let kode_penerimaan_spp = $(this).data('id');
            let no = 0;

            $.ajax({
                type: "GET",
                url: "{{ route('list_spp/getDataDetail') }}",
                data: {
                    kode_penerimaan_spp: kode_penerimaan_spp
                },
                dataType: "json",
                success: function(response) {
                    $(".kode").text(kode_penerimaan_spp);

                    let tbl_detail;
                    response.data.forEach(detail => {
                        let no_spp = detail.no_spp;
                        let tgl_spp = detail.tgl_spp;
                        let tgl_jatuh_tempo = detail.tgl_jatuh_tempo;
                        let keterangan_spp = detail.keterangan_spp;
                        let kode_perusahaan = detail.kode_perusahaan;
                        let jumlah = detail.jumlah;
                        let kode_vendor = detail.kode_vendor;
                        let nama_vendor = detail.nama_vendor;

                        //membuat format rupiah Harga//
                        var reverse_jumlah = jumlah.toString().split('').reverse().join(''),
                        ribuan_jumlah  = reverse_jumlah.match(/\d{1,3}/g);
                        jumlah_rupiah = ribuan_jumlah.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        no = no + 1
                        tbl_detail += `<tr>`;
                        tbl_detail += `<td>` +no+ `</td>`;
                        tbl_detail += `<td>${detail.no_spp}</td>`;
                        tbl_detail += `<td>${detail.tgl_spp}</td>`;
                        tbl_detail += `<td>${detail.tgl_jatuh_tempo}</td>`;
                        tbl_detail += `<td>${detail.keterangan_spp}</td>`;
                        tbl_detail += `<td>${detail.kode_perusahaan}</td>`; 
                        tbl_detail += `<td align="right">${jumlah_rupiah}</td>`;
                        tbl_detail += `<td>${detail.kode_vendor}</td>`;
                        tbl_detail += `<td>${detail.nama_vendor}</td>`;
                        tbl_detail += `</tr>`;
                    });

                    $("#tbl_detail").html(tbl_detail);
                }
            });
            $('#modalView').modal('show');
        });
    </script>
@endsection