@extends('layouts.admin')

@section('title')
    <title>Uang Rit</title>
@endsection
<style>
    .dropdown-container {
        position: relative;
    }

    .dropdown-content {
        border-radius: 8px;
        /* display: none; */
        position: absolute;
        background-color: #fff;
        border: 1px solid #ffffff;
        z-index: 1000;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        margin-top: px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-content div {
        padding: 5px 16px;
        cursor: pointer;
    }

    .dropdown-content div:hover {
        background-color: #f1f1f1;
    }
</style>
@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Uang Rit</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">


                    <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Uang Rit
                                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                        data-target="#modalTambahRit">
                                        <i class="nav-icon icon-plus"></i>&nbsp T a m b a h
                                    </button>
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
                                    <div class="input-group mb-3 col-md-6" hidden>
                                        <input type="text" id="tanggal" name="tanggal" class="form-control"
                                            value="{{ request()->tanggal }}" hidden>
                                        <input type="text" id="customer" name="customer" class="form-control"
                                            placeholder="Masukan ID Toko" value="{{ request()->customer }}">

                                        &nbsp
                                        <input type="text" id="docId" name="docId" class="form-control"
                                            placeholder=" Masukan Invoice" value="{{ request()->docId }}">
                                        &nbsp &nbsp
                                        <button class="btn btn-primary" type="submit">C a r i</button>
                                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                                        <a href="{{ route('list_due_date/export.export') }}"
                                            class="btn btn-primary float-right" hidden>E x c e l</a>
                                    </div>
                                </form>


                                <div class="table-responsive">
                                    <div style="width:200%;">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>Id</th>
                                                    <th>Kode SKU</th>
                                                    <th>Nama SKU</th>
                                                    <th hidden>Kode Pelanggan</th>
                                                    <th>Nama Pelanggan</th>
                                                    <th hidden>Kode Area</th>
                                                    <th>Nama Area</th>
                                                    <th hidden>Kode Pabrik</th>
                                                    <th>Nama Pabrik</th>
                                                    <th>Qty</th>
                                                    <th>Uang Rit Berlaku</th>
                                                    <th>Claim Tol</th>
                                                    <th>Revisi</th>
                                                    <th>Keterangan</th>
                                                    <th>Tgl Berlaku</th>
                                                    <th>PIC</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- PAGINATION  -->
                            </div>
                        </div>
                    </div>
                    <!-- ##################################################################################################  -->
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade bd-example-modal-lg" id="modalTambahRit" tabindex="-1" aria-labelledby="modalTambahRit"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Uang Rit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--FORM TAMBAH BARANG-->
                    <form action="#" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Code</label>
                            <input type="text" class="form-control" id="addCode" name="addCode">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-2 dropdown-container">
                                    <label for="addSKU">SKU/Produk</label>
                                    <input type="text" class="form-control" id="addSKU" name="addSKU" required>
                                    <div id="listDropdown" class="dropdown-content"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="addPabrik">Pabrik</label>
                                    <select class="form-control" id="addPabrik" name="addPabrik" required>
                                        <option value="">Pilih Pabrik</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="addDestinasi">Destinasi</label>
                                    <select class="form-control" id="addDestinasi" name="addDestinasi" required>
                                        <option value="">Pilih Destinasi</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Jarak</label>
                                    <input type="text" class="form-control" id="addJarak" name="addJarak">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="">Qty</label>
                                    <input type="text" class="form-control" id="addQty" name="addQty">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Rasio</label>
                                    <input type="text" class="form-control" id="addRasio" name="addRasio">
                                </div>
                                {{-- <div class="col-md-6 mb-2">
                                    <label for="">Pabrik</label>
                                    <input type="text" class="form-control" id="addPabrik" name="addPabrik">
                                </div> --}}
                                {{-- <div class="col-md-6 mb-2">
                                    <label for="">Area</label>
                                    <input type="text" class="form-control" id="addArea" name="addArea">
                                </div> --}}
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <label for="">Qty</label>
                                    <input type="text" class="form-control" id="addQty" name="addQty">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="">Uang Rit</label>
                                    <input type="text" class="form-control" id="addRit" name="addRit">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Claim Tol</label>
                                    <input type="text" class="form-control" id="addTol" name="addTol">
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="">Revisi</label>
                            <input type="text" class="form-control" id="addRevisi" name="addRevisi">
                        </div> --}}
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" id="addKeterangan" name="addKeterangan">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="">Tanggal Berlaku</label>
                                    <input type="text" class="form-control" id="addTglBerlaku" name="addTglBerlaku">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">PIC</label>
                                    <input type="text" class="form-control" id="addPic" name="addPic">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="button_form_insert"> Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> Tutup</button>
                    </form>
                    <!--END FORM TAMBAH BARANG-->
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade bd-example-modal-lg" id="modalEdit" tabindex="-1" aria-labelledby="modalEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Uang Rit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--FORM TAMBAH BARANG-->
                    <form action="#" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Code</label>
                            <input type="text" class="form-control" id="update_addCode" name="update_addCode">
                        </div>
                        {{-- <div class="form-group">
                        <label for="">SKU</label>
                        <select id="addKategori" name="addKategori" class="form-control" required>
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pelanggan</label>
                        <select id="addKategori" name="addKategori" class="form-control" required>
                            <option value="">Pilih</option>
                            
                        </select>
                    </div> --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="">SKU</label>
                                    <input type="text" class="form-control" id="update_addSku" name="update_addSku">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Nama Toko</label>
                                    <input type="text" class="form-control" id="update_addNamaToko"
                                        name="update_addNamaToko">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="">Area</label>
                                    <input type="text" class="form-control" id="update_addArea"
                                        name="update_addArea">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Pabrik</label>
                                    <input type="text" class="form-control" id="update_addPabrik"
                                        name="update_addPabrik">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <label for="">Qty</label>
                                    <input type="text" class="form-control" id="update_addQty" name="update_addQty">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="">Uang Rit</label>
                                    <input type="text" class="form-control" id="update_addRit" name="update_addRit">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Claim Tol</label>
                                    <input type="text" class="form-control" id="update_addTol" name="update_addTol">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Revisi</label>
                            <input type="text" class="form-control" id="update_addRevisi" name="update_addRevisi">
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" id="update_addKeterangan"
                                name="update_addKeterangan">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="">Tanggal Berlaku</label>
                                    <input type="text" class="form-control" id="update_addTglBerlaku"
                                        name="update_addTglBerlaku">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">PIC</label>
                                    <input type="text" class="form-control" id="update_addPic" name="update_addPic">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="button_form_update"> Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> Tutup</button>
                    </form>
                    <!--END FORM TAMBAH BARANG-->
                </div>
            </div>
        </div>
    </div>
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
        $('#addRit').maskMoney({
            thousands: ',',
            decimal: '.',
            precision: 0
        });
        $('#update_addRit').maskMoney({
            thousands: ',',
            decimal: '.',
            precision: 0
        });

        fetchAllData();

        function fetchAllData() {
            $.ajax({
                type: "GET",
                url: "{{ route('logistik/getDataUangRit.getDataUangRit') }}",
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 1;
                    response.data.forEach(uang_rit => {
                        tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td>${uang_rit.kode}</td>`;
                        tabledata += `<td>${uang_rit.sku}</td>`;
                        tabledata += `<td>${uang_rit.nama_toko}</td>`;
                        tabledata += `<td>${uang_rit.area}</td>`;
                        tabledata += `<td>${uang_rit.pabrik}</td>`;
                        tabledata += `<td>${uang_rit.qty}</td>`;
                        tabledata += `<td>${uang_rit.uang_rit}</td>`;
                        tabledata += `<td>${uang_rit.claim_tol}</td>`;
                        tabledata += `<td>${uang_rit.revisi}</td>`;
                        tabledata += `<td>${uang_rit.keterangan}</td>`;
                        tabledata += `<td>${uang_rit.tgl_berlaku}</td>`;
                        tabledata += `<td>${uang_rit.pic}</td>`;
                        tabledata +=
                            `<td align="center"><button type="button" data-id="${uang_rit.kode}" id="button_edit_data" class="btn btn-warning btn-sm"><i class="nav-icon icon-pencil"></i></button>`;
                        tabledata += `</tr>`;
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }
        //===End Select data Pegawai====// 

        //=== Edit Data Pegawai ============================//
        $(document).on("click", "#button_edit_data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "{{ route('logistik/getDataDetail.getDataDetail') }}",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    let temp_uang_rit = response.data.uang_rit;
                    //membuat format rupiah Harga//
                    var reverse_harga = temp_uang_rit.toString().split('').reverse().join(''),
                        ribuan_harga = reverse_harga.match(/\d{1,3}/g);
                    harga_rupiah_rit = ribuan_harga.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                    $("#update_addCode").val(id);
                    $("#update_addSku").val(response.data.sku);
                    $("#update_addNamaToko").val(response.data.nama_toko);
                    $("#update_addArea").val(response.data.area);
                    $("#update_addPabrik").val(response.data.pabrik);
                    $("#update_addQty").val(response.data.qty);
                    $("#update_addRit").val(harga_rupiah_rit);
                    $("#update_addTol").val(response.data.claim_tol);
                    $("#update_addRevisi").val(response.data.revisi);
                    $("#update_addKeterangan").val(response.data.keterangan);
                    $("#update_addTglBerlaku").val(response.data.tgl_berlaku);
                    $("#update_addPic").val(response.data.pic);
                }
            });
            $('#modalEdit').modal('show');
        });
        //=== End Edit Data Pegawai ============================//

        //=== End Edit Data ============================//
        $("#button_form_update").click(function() {
            let code = $("#update_addCode").val();
            let sku = $("#update_addSku").val();
            let nama_toko = $("#update_addNamaToko").val();
            let area = $("#update_addArea").val();
            let pabrik = $("#update_addPabrik").val();
            let qty = $("#update_addQty").val();
            let uang_rit = $("#update_addRit").val();
            let claim_tol = $("#update_addTol").val();
            let revisi = $("#update_addRevisi").val();
            let keterangan = $("#update_addKeterangan").val();
            let tgl_berlaku = $("#update_addTglBerlaku").val();
            let pic = $("#update_addPic").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('logistik/update.update') }}",
                data: {
                    code: code,
                    sku: sku,
                    nama_toko: nama_toko,
                    area: area,
                    pabrik: pabrik,
                    qty: qty,
                    uang_rit: uang_rit,
                    claim_tol: claim_tol,
                    revisi: revisi,
                    keterangan: keterangan,
                    tgl_berlaku: tgl_berlaku,
                    pic: pic,
                },
                success: function(response) {
                    if (response.status === true) {
                        $("#addCode").val('');
                        $("#addSku").val('');
                        $("#addNamaToko").val('');
                        $("#addArea").val('');
                        $("#addPabrik").val('');
                        $("#addQty").val('');
                        $("#addRit").val('');
                        $("#addTol").val('');
                        $("#addRevisi").val('');
                        $("#addKeterangan").val('');
                        $("#addTglBerlaku").val('');
                        $("#modalEdit").modal('hide');
                        fetchAllData();
                        //alert('Sukses, Data Berhasil diubah...');
                    } else {
                        alert('Gagal, Data tidak berhasil diubah...');
                    }
                }
            });
        });
        //=== End Edit Data ============================//

        //=== Insert data Pegawai =================//
        $("#button_form_insert").click(function(e) {
            e.preventDefault();
            let code = $("#addCode").val();
            let sku = $("#addSku").val();
            let nama_toko = $("#addNamaToko").val();
            let area = $("#addArea").val();
            let pabrik = $("#addPabrik").val();
            let qty = $("#addQty").val();
            let uang_rit = $("#addRit").val();
            let claim_tol = $("#addTol").val();
            let revisi = $("#addRevisi").val();
            let keterangan = $("#addKeterangan").val();
            let tgl_berlaku = $("#addTglBerlaku").val();
            let pic = $("#addPic").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('logistik/store.store') }}",
                data: {
                    code: code,
                    sku: sku,
                    nama_toko: nama_toko,
                    area: area,
                    pabrik: pabrik,
                    qty: qty,
                    uang_rit: uang_rit,
                    claim_tol: claim_tol,
                    revisi: revisi,
                    keterangan: keterangan,
                    tgl_berlaku: tgl_berlaku,
                    pic: pic,
                },
                success: function(response) {
                    if (response.res === true) {
                        $("#addCode").val('');
                        $("#addSku").val('');
                        $("#addNamaToko").val('');
                        $("#addArea").val('');
                        $("#addPabrik").val('');
                        $("#addQty").val('');
                        $("#addRit").val('');
                        $("#addTol").val('');
                        $("#addRevisi").val('');
                        $("#addKeterangan").val('');
                        $("#addTglBerlaku").val('');
                        $("#modalTambahRit").modal('hide');
                        fetchAllDataPegawai();
                    } else {
                        Swal.fire("Gagal!", "Data pegawai gagal disimpan.", "error");
                    }
                }
            });

        });
        //=== End Insert data Pegawai =================//

        $(document).ready(function() {
            $.ajax({
                url: "{{ route('logistik/getData') }}", // URL rute yang benar
                method: 'GET',
                success: function(response) {
                    if (response.status) {
                        var produkDropdown = $('#produkDropdown');
                        response.produk.forEach(function(produk) {
                            produkDropdown.append('<option value="' + produk.product_name +
                                '">' + produk.product_name + '</option>');
                        });
                    } else {
                        alert('Gagal mendapatkan data produk');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan dalam permintaan AJAX');
                }
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi debounce
        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        $(document).ready(function() {
            // Variabel untuk menyimpan data destinasi dan pabrik
            var destinasiData = null;
            var pabrikData = null;

            // Fungsi untuk memuat data destinasi
            function loadDestinasiData() {
                if (!destinasiData) {
                    $.ajax({
                        url: "{{ route('logistik.getDataDestinasi') }}",
                        method: 'GET',
                        success: function(response) {
                            console.log(response.status);
                            if (response.status && response.data.length > 0) {
                                destinasiData = response.data;
                                populateDropdown($('#addDestinasi'), destinasiData);
                            } else {
                                alert('Tidak ada data destinasi yang ditemukan');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan dalam permintaan AJAX');
                        }
                    });
                } else {
                    populateDropdown($('#addDestinasi'), destinasiData);
                }
            }

            // Fungsi untuk memuat data pabrik
            function loadPabrikData() {
                if (!pabrikData) {
                    $.ajax({
                        url: "{{ route('logistik.getDataPabrik') }}",
                        method: 'GET',
                        success: function(response) {
                            console.log(response.status);
                            if (response.status && response.data.length > 0) {
                                pabrikData = response.data;
                                populateDropdown($('#addPabrik'), pabrikData);
                            } else {
                                alert('Tidak ada data pabrik yang ditemukan');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan dalam permintaan AJAX');
                        }
                    });
                } else {
                    populateDropdown($('#addPabrik'), pabrikData);
                }
            }

            // Fungsi untuk mengisi dropdown
            function populateDropdown(element, data) {
                element.empty(); // Kosongkan dropdown sebelum menambahkan opsi baru
                element.append('<option value="">Pilih</option>');
                data.forEach(function(item) {
                    element.append(
                        '<option value="' + item.szName + '">' +
                        item.szName + '</option>'
                    );
                });
            }

            $('#addDestinasi').on('focus click', function() {
                loadDestinasiData();
            });

            $('#addPabrik').on('focus click', function() {
                loadPabrikData();
            });

            $('#addSKU').on('keyup', debounce(function() {
                var query = $(this).val().toLowerCase();
                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('logistik.getDataProduk') }}",
                        method: 'GET',
                        data: {
                            q: query
                        },
                        success: function(response) {
                            console.log(response.success);
                            if (response.status && response.data.length > 0) {
                                var listDropdown = $('#listDropdown');
                                listDropdown.empty();
                                response.data.forEach(function(produk) {
                                    listDropdown.append(
                                        '<div class="" data-value="' + produk
                                        .product_name + '">' +
                                        produk.product_name + '</div>'
                                    );
                                });
                                listDropdown.show();
                            } else {
                                $('#listDropdown').show();
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan dalam permintaan AJAX');
                        }
                    });
                } else {
                    $('#listDropdown').hide();
                }
            }, 300));

            $(document).on('click', '#listDropdown div', function() {
                var text = $(this).text();
                var value = $(this).data('value');
                $('#addSKU').val(text).data('selected-value', value);
                $('#listDropdown').hide();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown-container').length) {
                    $('#listDropdown').hide();
                }
            });

            $('#addSKU').on('focus', function() {
                if ($(this).val().length > 0) {
                    $('#listDropdown').show();
                }
            });
        });
    </script>
@endsection
