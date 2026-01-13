@section('js')
<script type="text/javascript">
    fetchAllDataRekening();
    function fetchAllDataRekening(){
        $.ajax({
        type: "GET",
        url: "{{ route('rekening_outlet/getDataRekening.getDataRekening') }}",
        dataType: "json",
        success: function(response) {
            let tabledata;
            let no = 1;
            response.data.forEach(rek => {
            tabledata += `<tr>`;
                tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                tabledata += `<td hidden>${rek.id}</td>`;
                tabledata += `<td hidden>${rek.kode_depo}</td>`;
                tabledata += `<td>${rek.nama_depo}</td>`;
                tabledata += `<td>${rek.kode_toko}</td>`;
                tabledata += `<td>${rek.nama_toko}</td>`;
                tabledata += `<td hidden>${rek.program}</td>`;
                tabledata += `<td>${rek.nama_pemilik}</td>`;
                tabledata += `<td>${rek.no_rekening}</td>`;
                tabledata += `<td>${rek.nama_rekening}</td>`;
                tabledata += `<td>${rek.bank_rekening}</td>`;
                tabledata += `<td hidden>${rek.id_user_input}</td>`;
                tabledata += `<td>${rek.name}</td>`;
                tabledata += `<td align="center"><button type="button" data-id="${rek.id}" id="button_edit_data" class="btn btn-warning btn-sm">Edit</button>`;
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
                url: "{{ route('rekening_outlet/getDataRekening.getDataRekening') }}",
                data: {
                    value: value
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 1;
                    response.data.forEach(rek => {
                        tabledata += `<tr>`;
                            tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                            tabledata += `<td hidden>${rek.id}</td>`;
                            tabledata += `<td hidden>${rek.kode_depo}</td>`;
                            tabledata += `<td>${rek.nama_depo}</td>`;
                            tabledata += `<td>${rek.kode_toko}</td>`;
                            tabledata += `<td>${rek.nama_toko}</td>`;
                            tabledata += `<td hidden>${rek.program}</td>`;
                            tabledata += `<td>${rek.nama_pemilik}</td>`;
                            tabledata += `<td>${rek.no_rekening}</td>`;
                            tabledata += `<td>${rek.nama_rekening}</td>`;
                            tabledata += `<td>${rek.bank_rekening}</td>`;
                            tabledata += `<td hidden>${rek.id_user_input}</td>`;
                            tabledata += `<td>${rek.name}</td>`;
                            tabledata += `<td align="center"><button type="button" data-id="${rek.id}" id="button_edit_data" class="btn btn-warning btn-sm">Edit</button>`;
                        tabledata += `</tr>`;
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }else{
            fetchAllDataRekening();
        }
    });

    $(function(){
        $('#kode_perusahaan').change(function(){
            var perusahaan_id = $(this).val();

            if(perusahaan_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax_depo_rekening?perusahaan_id="+perusahaan_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#kode_depo").empty();
                            $("#kode_depo").append('<option value="">Pilih</option>');
                            $.each(res,function(nama,kode){
                                $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#kode_depo").empty();
                        }
                    }
                });
            }else{
                $("#kode_depo").empty();
            }
        });
    });

    $("#button_form_insert").click(function(e) {
        e.preventDefault();
        let kode_depo = $("#kode_depo").val();
        let kode_toko = $('#kode_toko').val();
        let nama_toko = $('#nama_toko').val();
        let program = $('#program').val();
        let nama_pemilik = $('#nama_pemilik').val();
        let no_rekening = $('#no_rek').val();
        let nama_rekening = $('#nama_rekening').val();
        let bank_rekening = $('#nama_bank').val();
        let keterangan = $('#keterangan').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('rekening_outlet/store.store') }}",
            data: {
                kode_depo: kode_depo,
                kode_toko: kode_toko,
                nama_toko: nama_toko,
                program: program,
                nama_pemilik: nama_pemilik,
                no_rekening: no_rekening,
                nama_rekening: nama_rekening,
                bank_rekening: bank_rekening,
                keterangan: keterangan,
            },
            success: function(response) {
                if(response.res === true) {
                    $("#kode_depo").val('');
                    $('#kode_toko').val('');
                    $('#nama_toko').val('');
                    $('#program').val('');
                    $('#nama_pemilik').val('');
                    $('#no_rek').val('');
                    $('#nama_rekening').val('');
                    $('#nama_bank').val('');
                    $('#keterangan').val('');
                    $("#myModal").modal('hide');
                    fetchAllDataRekening();
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
                    fetchAllDataRekening();
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
	<title>Rekening Outlet</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Rekening Outlet</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Rekening Outlet
                                {{-- <a href="#" class="btn btn-primary btn-sm float-right">Tambah Rekening</a>
                                <a href="#" class="btn btn-warning btn-sm float-right" hidden>Import Data</a> --}}
                                <button type="button" class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#myModal">Tambah Rekening</button>
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('rekening_outlet/view.view_excel') }}" target="_blank" method="get" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <button class="btn btn-success" name="button_excel" id="button_excel" value="excel" type="submit">Import Excel</button>
                                    </div>
                                    <div class="col-4"></div>
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
                                            <th hidden>Kode Depo</th>
                                            <th>Depo</th>
                                            <th>Kode Toko</th>
                                            <th>Nama Toko</th>
                                            <th hidden>Program</th>
                                            <th>Nama Pemilik</th>
                                            <th>No. Rekening</th>
                                            <th>Nama Rekening</th>
                                            <th hidden>Kode Bank</th>
                                            <th>Bank</th>
                                            <th hidden>Kode User</th>
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Rekening</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                Perusahaan
                                                <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                                    <option value="">Pilih</option>
                                                    @foreach ($perusahaan as $row)
                                                        <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Depo
                                                <select name="kode_depo" id="kode_depo" class="form-control">
                                                    <option value="">Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                Kode Toko
                                                <input type="text" name="kode_toko" id="kode_toko" class="form-control" required>
                                            </div>
                                            <div class="col-md-8 mb-2">
                                                Nama Toko
                                                <input type="text" name="nama_toko" id="nama_toko" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-12 mb-2">
                                                Nama Pemilik
                                                <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Rekening
                                                <input type="text" name="no_rek" id="no_rek" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Nama Rekening
                                                <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Nama Bank
                                                <select name="nama_bank" id="nama_bank" class="form-control">
                                                    <option value="">Pilih</option>
                                                    @foreach ($bank as $row)
                                                        <option value="{{ $row->nama_bank }}" {{ old('nama_bank') == $row->nama_bank ? 'selected':'' }}>{{ $row->nama_bank }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Keterangan
                                                <input type="text" name="keterangan" id="keterangan" class="form-control">
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
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Rekening</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                Kode
                                                <input type="text" name="kode_update" id="kode_update" class="form-control" readonly required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                Kode_depo
                                                <input type="text" name="kode_depo_update" id="kode_depo_update" class="form-control" readonly required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Depo
                                                <input type="text" name="nama_depo_update" id="nama_depo_update" class="form-control" readonly required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                Kode Toko
                                                <input type="text" name="kode_toko_update" id="kode_toko_update" class="form-control" readonly required>
                                            </div>
                                            <div class="col-md-8 mb-2">
                                                Nama Toko
                                                <input type="text" name="nama_toko_update" id="nama_toko_update" class="form-control" readonly required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-12 mb-2">
                                                Nama Pemilik
                                                <input type="text" name="nama_pemilik_update" id="nama_pemilik_update" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                No Rekening
                                                <input type="text" name="no_rek_update" id="no_rek_update" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Nama Rekening
                                                <input type="text" name="nama_rekening_update" id="nama_rekening_update" class="form-control" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Nama Bank
                                                <select name="nama_bank_update" id="nama_bank_update" class="form-control">
                                                
                                                    @foreach ($bank as $row)
                                                        <option value="{{ $row->nama_bank }}" {{ old('nama_bank') == $row->nama_bank ? 'selected':'' }}>{{ $row->nama_bank }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                Keterangan
                                                <input type="text" name="keterangan_update" id="keterangan_update" class="form-control">
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