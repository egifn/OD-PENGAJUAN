@section('js')
<script type="text/javascript">
    //menampilkan data//
    fetchAll();
    function fetchAll() {
        $.ajax({
            type: "GET",
            url: "{{ route('getData') }}",
            dataType: "json",
            success: function(response) {
                let tabledata;
                response.data.forEach(element => {
                    tabledata += `<tr>`;
                        tabledata += `<td hidden>${element.id}</td>`;
                        tabledata += `<td>${element.norek}</td>`;
                        tabledata += `<td>${element.nama_pelanggan}</td>`;
                        tabledata += `<td>${element.atas_nama}</td>`;
                        tabledata += `<td>${element.bank}</td>`;
                        tabledata += `<td align="center"><button type="button" data-id="${element.id}" id="button_edit" class="btn btn-warning btn-sm">Ubah</button>&emsp;
                          <button type="button" data-id="${element.id}" id="button_delete" class="btn btn-danger btn-sm">Hapus</button></td>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
            }
        });
    }
    //end menampilkan data//

    //Pencarian data//
    $("#cari").keyup(function() {
        let value = $("#cari").val();
        if (this.value.length >= 2) {
            $.ajax({
                type: "GET",
                url: "{{ route('getData') }}",
                data: {
                    value: value
                },
                dataType: "json",
                success: function(response) {
                let tabledata;
                response.data.forEach(element => {
                    tabledata += `<tr>`;
                        tabledata += `<td hidden>${element.id}</td>`;
                        tabledata += `<td>${element.norek}</td>`;
                        tabledata += `<td>${element.nama_pelanggan}</td>`;
                        tabledata += `<td>${element.atas_nama}</td>`;
                        tabledata += `<td>${element.bank}</td>`;
                        tabledata += `<td align="center"><button type="button" data-id="${element.id}" id="button_edit" class="btn btn-warning btn-sm">Ubah</button>&emsp;
                          <button type="button" data-id="${element.id}" id="button_delete" class="btn btn-danger btn-sm">Hapus</button></td>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
                }
            });
        }else{
            fetchAll();
        }
    });
    //End Pencarian data//

    //insert data//
    $("#button_form_insert").click(function () { 
        let norek = $("#norek").val();
        let nama_pelanggan = $("#nama_pelanggan").val();
        let atas_nama = $("#atas_nama").val();
        let bank = $("#bank").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('store') }}",
            data: {
                norek: norek,
                nama_pelanggan: nama_pelanggan,
                atas_nama: atas_nama,
                bank: bank,
            },
            success: function(response) {
                if(response.res === true) {
                    $("#nama_pelanggan").val('');
                    $("#norek").val('');
                    $("#atas_nama").val('');
                    $("#bank").val('');
                    fetchAll();
                }else{
                    Swal.fire("Gagal!", "Data unit gagal disimpan.", "error");
                }
            }
        });
    });
    //end insert data//

    //Edit Data//
    $(document).on("click", "#button_edit", function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "{{ route('getDetailData') }}",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                $('#update_id').val(id);
                $('#update_nama_pelanggan').val(response.data.nama_pelanggan);
                $('#update_norek').val(response.data.norek);
                $('#update_atas_nama').val(response.data.atas_nama);
                $('#update_bank').val(response.data.bank);
            }
        });
        $('#modalEdit').modal('show');
    });
    $("#button_form_update").click(function() {
        let id = $('#update_id').val();
        let nama_pelanggan = $('#update_nama_pelanggan').val();
        let norek = $('#update_norek').val();
        let atas_nama = $('#update_atas_nama').val();
        let bank = $('#update_bank').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('update') }}",
            data: {
                id: id,
                norek: norek,
                nama_pelanggan: nama_pelanggan,
                atas_nama: atas_nama,
                bank: bank,
            },
            success: function(response) {
                if (response.status === true) {
                    $('#modalEdit').modal('hide');
                    // Swal.fire("Sukses!", `${response.message}`, "success");
                    alert('Sukses, Data Berhasil diubah...');
                    fetchAll();
                }else{
                    // Swal.fire("Gagal!", "unit tidak bisa diupdate.", "error");
                    alert('Gagal, Data tidak berhasil diubah...');
                }
            }
        });
    });
    //end Edit Data//

    //Delete Hapus Data//
    $(document).on("click", "#button_delete", function(e) {
        e.preventDefault();
        let id = $(this).data("id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('delete') }}",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.status === true) {
                    alert('Sukses, Data Berhasil dihapus...');
                    fetchAll();
                }else{
                    alert('Gagal, Data gagal dihapus...');
                }
            }
        });
    });
    //End Delete Hapus Data//
</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Rekening Pelanggan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Norek Pelanggan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Daftar Rekening Pelanggan
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalTambah">
                                    Tambah Data
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

                            <div class="input-group mb-3 col-md-4 float-right">  
                                <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari data...">
                            </div> 

                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>Id</th>
                                            <th>No. Rekening</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Atas Nama</th>
                                            <th>Bank</th>
                                            <th hidden>Kode User</th>
                                            <th hidden>User Input</th>
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
                
                <!-- Modal Tambah Data -->
                <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambah" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Norek Pelanggan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!--FORM TAMBAH BARANG-->
                                <form>
                                    <div class="form-group">
                                        <label for="">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">No Rekening</label>
                                        <input type="text" class="form-control" id="norek" name="norek" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Atas Nama / Nama Rekening</label>
                                        <input type="text" class="form-control" id="atas_nama" name="atas_nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Bank</label>
                                        <input type="text" class="form-control" id="bank" name="bank">
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm float-right" id="button_form_insert" data-dismiss="modal">S i m p a n</button>
                                    
                                </form>
                                <!--END FORM TAMBAH BARANG-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Tambah Data -->

                <!-- Modal Edit Data -->
                <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEdit" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ubah Norek Pelanggan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!--FORM TAMBAH BARANG-->
                                <form>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="update_id" name="update_id" value="" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="update_nama_pelanggan" name="update_nama_pelanggan" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">No Rekening</label>
                                        <input type="text" class="form-control" id="update_norek" name="update_norek" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Atas Nama / Nama Rekening</label>
                                        <input type="text" class="form-control" id="update_atas_nama" name="update_atas_nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Bank</label>
                                        <input type="text" class="form-control" id="update_bank" name="update_bank" required>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm float-right" id="button_form_update" data-dismiss="modal">S i m p a n</button>
                                    
                                </form>
                                <!--END FORM TAMBAH BARANG-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Edit Data -->
            </div>
        </div>
    </div>
</main>


@endsection