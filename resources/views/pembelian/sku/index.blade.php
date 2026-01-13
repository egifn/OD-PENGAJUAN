@section('js')
<script type="text/javascript">
    fetchAllDataSku();
    function fetchAllDataSku(){
        $.ajax({
        type: "GET",
        url: "{{ route('master_sku/getDatasku.getDataSku') }}",
        dataType: "json",
        success: function(response) {
            let tabledata;
            let no = 1;
            response.data.forEach(hrg => {
            tabledata += `<tr>`;
                tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                tabledata += `<td hidden>${hrg.id}</td>`;
                tabledata += `<td>${hrg.kode_sku}</td>`;
                tabledata += `<td>${hrg.nama_sku}</td>`;
                tabledata += `<td>${hrg.perusahaan}</td>`;
                tabledata += `<td>${hrg.pabrik}</td>`;
                tabledata += `<td>${hrg.harga}</td>`;
                tabledata += `<td hidden>${hrg.id_user_input}</td>`;
                tabledata += `<td>${hrg.name}</td>`;
                tabledata += `<td align="center"><button type="button" data-id="${hrg.id}" id="button_edit_data" class="btn btn-warning btn-sm">Edit</button>`;
            tabledata += `</tr>`;
            });
            $("#tabledata").html(tabledata);
        }
        });
    }

    $("#cari_rekening").keyup(function() {
        let value = $("#cari_rekening").val();
        if (this.value.length >= 2) {
            $.ajax({
                type: "GET",
                url: "{{ route('master_sku/getDatasku.getDataSku') }}",
                data: {
                    value: value
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 1;
                    response.data.forEach(hrg => {
                        tabledata += `<tr>`;
                            tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                            tabledata += `<td hidden>${hrg.id}</td>`;
                            tabledata += `<td hidden>${hrg.kode_sku}</td>`;
                            tabledata += `<td>${hrg.nama_sku}</td>`;
                            tabledata += `<td>${hrg.pabrik}</td>`;
                            tabledata += `<td>${hrg.pabrik}</td>`;
                            tabledata += `<td>${hrg.harga}</td>`;
                            tabledata += `<td hidden>${hrg.id_user_input}</td>`;
                            tabledata += `<td>${hrg.name}</td>`;
                            tabledata += `<td align="center"><button type="button" data-id="${hrg.id}" id="button_edit_data" class="btn btn-warning btn-sm">Edit</button>`;
                        tabledata += `</tr>`;
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }else{
            fetchAllDataSku();
        }
    });

    $("#button_form_insert").click(function(e) {
        e.preventDefault();
        let kode_sku = $("#kode_sku").val();
        let nama_sku = $('#nama_sku').val();
        let perusahaan = $('#perusahaan').val();
        let pabrik = $('#pabrik').val();
        let harga = $('#harga').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('master_sku/store.store') }}",
            data: {
                kode_sku: kode_sku,
                nama_sku: nama_sku,
                perusahaan: perusahaan,
                pabrik: pabrik,
                harga: harga,
            },
            success: function(response) {
                if(response.res === true) {
                    $("#kode_sku").val('');
                    $('#nama_sku').val('');
                    $('#perusahaan').val('');
                    $('#pabrik').val('');
                    $('#harga').val('');
                    $('#myModal').modal('hide');
                    fetchAllDataSku();
                }else{
                    Swal.fire("Gagal!", "Data gagal disimpan.", "error");
                }
            }
        });
    });

    $(document).on("click", "#button_edit_data", function(e) {
        e.preventDefault();
        let kode = $(this).data('id');

        $.ajax({
            type: "GET",
            url: "{{ route('rekening_outlet/getDataRekeningDetail.getDataRekeningDetail') }}",
            data: {
                kode: kode
            },
            dataType: "json",
            success: function(response) {
                $("#kode_update").val(response.data.id);
                $("#kode_depo_update").val(response.data.kode_depo);
                $('#nama_depo_update').val(response.data.nama_depo);
                $('#kode_toko_update').val(response.data.kode_toko);
                $('#nama_toko_update').val(response.data.nama_toko);
                $('#program_update').val(response.data.program);
                $('#nama_pemilik_update').val(response.data.nama_pemilik);
                $('#no_rek_update').val(response.data.no_rekening);
                $('#nama_rekening_update').val(response.data.nama_rekening);
                $('#nama_bank_update').val(response.data.bank_rekening);
                $('#keterangan_update').val(response.data.keterangan);
            }
        });
        $('#myModal_edit').modal('show');
    });

    $("#button_form_update").click(function() {
        let kode = $("#kode_update").val(); 
        let nama_pemilik = $("#nama_pemilik_update").val();
        let no_rekening = $("#no_rek_update").val();
        let nama_rekening = $("#nama_rekening_update").val();
        let bank_rekening = $("#nama_bank_update").val();
        let keterangan = $("#keterangan_update").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('rekening_outlet/update.update') }}",
            data: {
                kode: kode,
                nama_pemilik: nama_pemilik,
                no_rekening: no_rekening,
                nama_rekening: nama_rekening,
                bank_rekening: bank_rekening,
                keterangan: keterangan,
            },
            success: function(response) {
                if (response.status === true) {
                    $("#nama_pemilik_update").val('');
                    $("#no_rek_update").val('');
                    $("#nama_rekening_update").val('');
                    $("#nama_bank_update").val('');
                    $("#keterangan_update").val('');
                    $("#myModal_edit").modal('hide');
                    fetchAllDataSku();
                }else{
                    alert('Gagal, Data tidak berhasil diubah...');
                }
            }
        });
    });

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Master SKU</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Master SKU</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Master SKU
                                <button type="button" class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#myModal">Tambah SKU</button>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" target="_blank" method="get" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <!-- <div class="col-4">
                                        <button class="btn btn-success" name="button_excel" id="button_excel" value="excel" type="submit">Import Excel</button>
                                    </div>
                                    <div class="col-4"></div> -->
                                    <div class="col-4">
                                        <input type="text" class="form-control" name="cari_rekening" id="cari_rekening" placeholder="Cari data..."/>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th hidden>id</th>
                                            <th>Kode sku</th>
                                            <th>Nama SKU</th>
                                            <th>Perusahaan</th>
                                            <th>Pabrik</th>
                                            <th>Harga</th>
                                            <th>User Input</th>
                                            <th hidden>Created At</th>
                                            <th hidden>Updated At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                           
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" >
                        <div class="modal-content" style="background: #fff;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah SKU</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Kode SKU
                                                <input type="text" name="kode_sku" id="kode_sku" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Nama SKU
                                                <input type="text" name="nama_sku" id="nama_sku" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Perusahaan
                                                <input type="text" name="perusahaan" id="perusahaan" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Pabrik
                                                <input type="text" name="pabrik" id="pabrik" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Harga
                                                <input type="text" name="harga" id="harga" class="form-control" required>
                                            </div>
                                        </div>
                                        <hr>
                                        <br>
                                        <button type="button" class="btn btn-success" id="button_form_insert">Simpan</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade bd-example-modal-lg" id="myModal_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" >
                        <div class="modal-content" style="background: #fff;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Update SKU</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Kode SKU
                                                <input type="text" name="kode_sku_update" id="kode_sku_update" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Nama SKU
                                                <input type="text" name="nama_sku_update" id="nama_sku_update" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Perusahaan
                                                <input type="text" name="perusahaan_update" id="perusahaan_update" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Pabrik
                                                <input type="text" name="pabrik_update" id="pabrik_update" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Harga
                                                <input type="text" name="harga_update" id="harga_update" class="form-control" required>
                                            </div>
                                        </div>
                                        <hr>
                                        <br>
                                        <button type="button" class="btn btn-success" id="button_form_update">Simpan</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection