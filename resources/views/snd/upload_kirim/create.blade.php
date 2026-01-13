@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        $(document).ready(function() {
            $('.select2').select2();
        });

        $("#jenis_surat").change(function() {
            let value = $("#jenis_surat").val();
            //alert(value);

            if (value == 'Eksternal') {
                $("#form-input-tiv").slideDown("fast");
            } else {
                $("#form-input-tiv").slideUp("fast");

                // document.getElementById("no_surat").value = "";
                document.getElementById("id_program_tiv").value = "";
                document.getElementById("nama_program_tiv").value = "";
                document.getElementById("filename_tiv[]").value = "";
            }
        });

        $(document).ready(function() {
            let jenis_surat = $("#jenis_surat").val();
        });

        let temp_no_surat = $("#no_surat").val();
        $("#surat_dist").change(function() {
            let value = $("#surat_dist").val();
            //alert(value);

            if (value == '1') {
                $("#form-surat-dist").slideDown("fast");
                $('#no_surat').val(temp_no_surat);
            } else {
                $("#form-surat-dist").slideUp("fast");
                $('#no_surat').val('-');
            }
        });

        $("#batal").click(function() {
            $('#no_surat').val('');
            $('#id_program').val('');
            $('#nama_program').val('');
            $('#filename_1').val('');
        });

        $(document).ready(function() {
            var addButton = $('#add_button_ta');
            var wrapper = $('.field_wrapper_ta');
            var x = 1;

            $(addButton).click(function() {
                x++;
                $(wrapper).append(
                    '<div class="row"><div class="col-md-4 mb-2">Untuk Depo<select name="id_depo_ta[]" id="id_depo_ta_' +
                    x +
                    '" class="form-control"><option value="">Pilih Depo</option>@foreach ($kode_depo_ta as $row) <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected' : '' }}>{{ $row->nama_depo }}</option> @endforeach</select></div><div class="col-md-1 mb-2"><br><a class="remove_button_ta btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'
                );
            });

            $(wrapper).on('click', '.remove_button_ta', function(e) {
                if (confirm("Are you sure you want to delete this line?")) {
                    e.preventDefault();
                    $(this).parent('').parent('').remove();
                    x--;
                }
            });
        });

        $(document).ready(function() {
            var addButton = $('#add_button_tu');
            var wrapper = $('.field_wrapper_tu');
            var x = 1;
            $(addButton).click(function() {
                x++;
                $(wrapper).append(
                    '<div class="row"><div class="col-md-4 mb-2">Untuk Depo<select name="id_depo_tu[]" id="id_depo_tu_' +
                    x +
                    '" class="form-control"><option value="">Pilih Depo</option>@foreach ($kode_depo_tu as $row) <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected' : '' }}>{{ $row->nama_depo }}</option> @endforeach</select></div><div class="col-md-1 mb-2"><br><a class="remove_button_tu btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'
                );
            });

            $(wrapper).on('click', '.remove_button_tu', function(e) {
                if (confirm("Are you sure you want to delete this line?")) {
                    e.preventDefault();
                    $(this).parent('').parent('').remove();
                    x--;
                }
            });
        });

        $(document).ready(function() {
            var addButton = $('#add_button_tua');
            var wrapper = $('.field_wrapper_tua');
            var x = 1;
            $(addButton).click(function() {
                x++;
                $(wrapper).append(
                    '<div class="row"><div class="col-md-4 mb-2">Untuk Depo<select name="id_depo_tua[]" id="id_depo_tua_' +
                    x +
                    '" class="form-control"><option value="">Pilih Depo</option>@foreach ($kode_depo_tua as $row) <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected' : '' }}>{{ $row->nama_depo }}</option> @endforeach</select></div><div class="col-md-1 mb-2"><br><a class="remove_button_tua btn btn-danger" href="javascript:void(0);"><i class="nav-icon icon-trash"></i></a></div></div>'
                );
            });

            $(wrapper).on('click', '.remove_button_tua', function(e) {
                if (confirm("Are you sure you want to delete this line?")) {
                    e.preventDefault();
                    $(this).parent('').parent('').remove();
                    x--;
                }
            });
        });

        $('#savedatas').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('upload_kirim_surat/ajax/store.store') }}',
                type: 'POST',
                data: $(this).serializeArray(),
                success: function(data) {
                    console.log(data);
                }
            })
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function createFileHandler(inputId, listId) {
                var selectedFiles = [];

                function updateFileList() {
                    var fileInput = document.getElementById(inputId);
                    var dataTransfer = new DataTransfer();

                    selectedFiles.forEach(function(file) {
                        dataTransfer.items.add(file);
                    });

                    fileInput.files = dataTransfer.files;

                    var fileList = document.getElementById(listId);
                    fileList.innerHTML = "";

                    selectedFiles.forEach(function(file, index) {
                        var fileItem = document.createElement("div");
                        fileItem.textContent = file.name;

                        var removeButton = document.createElement("button");
                        removeButton.textContent = "x";
                        removeButton.style.marginLeft = "10px";
                        removeButton.style.marginRight = "10px";
                        removeButton.style.width = "20px";
                        removeButton.style.height = "20px";
                        removeButton.style.borderRadius = "50%";
                        removeButton.style.border = "none";
                        removeButton.style.backgroundColor = "gray";
                        removeButton.style.color = "white";
                        removeButton.style.display = "flex";
                        removeButton.style.alignItems = "center";
                        removeButton.style.justifyContent = "center";
                        removeButton.setAttribute("data-index", index);
                        removeButton.onclick = function() {
                            var index = parseInt(this.getAttribute("data-index"));
                            selectedFiles.splice(index, 1);
                            updateFileList();
                        };

                        var fileContainer = document.createElement("div");
                        fileContainer.style.display = "flex";
                        fileContainer.style.alignItems = "center";
                        fileContainer.style.marginBottom = "5px";
                        fileContainer.appendChild(fileItem);
                        fileContainer.appendChild(removeButton);

                        fileList.appendChild(fileContainer);
                    });
                }

                document.getElementById(inputId).addEventListener("change", function(e) {
                    Array.from(e.target.files).forEach(function(file) {
                        selectedFiles.push(file);
                    });
                    updateFileList();
                });
            }

            createFileHandler("filename_tiv_1", "fileList_tiv_1");
            createFileHandler("file_list", "fileList_tiv_2");
            createFileHandler("filename_tiv_lain_1", "fileList_tiv_3");
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function createFileHandler(inputId, listId) {
                var selectedFiles = [];

                function updateFileList() {
                    var fileInput = document.getElementById(inputId);
                    var dataTransfer = new DataTransfer();

                    selectedFiles.forEach(function(file) {
                        dataTransfer.items.add(file);
                    });

                    fileInput.files = dataTransfer.files;

                    var fileList = document.getElementById(listId);
                    fileList.innerHTML = "";

                    selectedFiles.forEach(function(file, index) {
                        var fileItem = document.createElement("div");
                        fileItem.textContent = file.name;

                        var removeButton = document.createElement("button");
                        removeButton.textContent = "x";
                        removeButton.style.marginLeft = "10px";
                        removeButton.style.marginRight = "10px";
                        removeButton.style.width = "20px";
                        removeButton.style.height = "20px";
                        removeButton.style.borderRadius = "50%";
                        removeButton.style.border = "none";
                        removeButton.style.backgroundColor = "gray";
                        removeButton.style.color = "white";
                        removeButton.style.display = "flex";
                        removeButton.style.alignItems = "center";
                        removeButton.style.justifyContent = "center";
                        removeButton.setAttribute("data-index", index);
                        removeButton.onclick = function() {
                            var index = parseInt(this.getAttribute("data-index"));
                            selectedFiles.splice(index, 1);
                            updateFileList();
                        };

                        var fileContainer = document.createElement("div");
                        fileContainer.style.display = "flex";
                        fileContainer.style.alignItems = "center";
                        fileContainer.style.marginBottom = "5px";
                        fileContainer.appendChild(fileItem);
                        fileContainer.appendChild(removeButton);

                        fileList.appendChild(fileContainer);
                    });
                }

                document.getElementById(inputId).addEventListener("change", function(e) {
                    Array.from(e.target.files).forEach(function(file) {
                        selectedFiles.push(file);
                    });
                    updateFileList();
                });
            }

            createFileHandler("filenameta_1", "fileList_ta");
            createFileHandler("filenametu_1", "fileList_tu");
            createFileHandler("filenametua_1", "fileList_tua");
        });
    </script>


@stop

@extends('layouts.admin')

@section('title')
    <title>Upload dan Kirim Surat Program</title>
@endsection

@section('content')

    <main class="main">
        <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet"
            type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />

        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Surat Program</li>
            <li class="breadcrumb-item">Upload dan Kirim</li>
            <li class="breadcrumb-item active">Upload dan Kirim Surat Program</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <form action="{{ route('upload_kirim_surat/ajax/store.store') }}" method="post"
                    onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Upload dan Kirim Surat Program</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            Jenis Surat
                                            <select name="jenis_surat" id="jenis_surat" class="form-control">
                                                <option value="Eksternal">Eksternal</option>
                                                <option value="Internal">Internal</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Tgl Upload dan Kirim
                                            <input type="text" name="tgl" id="tgl" class="form-control"
                                                value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}"
                                                required readonly>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Diajukan Oleh
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                value="{{ Auth::user()->name }}" required readonly>
                                            <input type="hidden" name="id_user_input" id="id_user_input"
                                                class="form-control" value="{{ Auth::user()->id }}" required readonly>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Perusahaan
                                            <input type="text" name="kode_perusahaan_user" id="kode_perusahaan_user"
                                                class="form-control" value="{{ Auth::user()->kode_perusahaan }}" required
                                                readonly>
                                        </div>
                                        <div class="col-md-2 mb-2" hidden>
                                            Depo
                                            <input type="text" name="kode_depo_user" id="kode_depo_user"
                                                class="form-control" value="{{ Auth::user()->kode_depo }}" required
                                                readonly>
                                        </div>
                                        <div class="col-md-2 mb-2" hidden>
                                            Divisi
                                            <input type="text" name="kode_divisi_user" id="kode_divisi_user"
                                                class="form-control" value="{{ Auth::user()->kode_divisi }}" required
                                                readonly>
                                        </div>
                                    </div>

                                    <hr>
                                    {{-- <div id="form-input-satu">
                                    <div id="form-input-satu" class="field_wrapper_2">
                                        <div id="form-input-satu" class="row">
                                        </div>
                                    </div>
                                </div>
                                <div id="form-input-satu">
                                    <div id="form-input-satu" class="field_wrapper_2">
                                        <div id="form-input-satu" class="row">
                                        </div>
                                    </div>
                                </div> --}}
                                    <div id="form-input-tiv">
                                        <div class="field_wrapper_tiv">
                                            <h4>Surat Program TIV</h4>
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    ID Program
                                                    <input type="text" name="id_program_tiv" id="id_program_tiv"
                                                        class="form-control" value="">
                                                </div>
                                                <div class="col-md-7 mb-2">
                                                    Nama Program
                                                    <input type="text" name="nama_program_tiv" id="nama_program_tiv"
                                                        class="form-control" value="">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    Jml Peserta
                                                    <input type="text" name="jml_peserta" id="jml_peserta"
                                                        class="form-control" value="">
                                                </div>
                                                {{-- <div class="col-md-2 mb-2" hidden>
                                                No. Urut
                                                <input type="text" name="no_urut" id="no_urut" class="form-control" value="">
                                            </div> --}}
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <strong>Lampiran/Attachment Surat Program</strong>
                                                    <div class="d-flex mb-2 mt-1">
                                                        <input type="file" class="form-control col-md-3 mr-1"
                                                            name="filename_tiv[]" id="filename_tiv_1" multiple>
                                                        <div class="form-control col-md-9 d-flex" id="fileList_tiv_1"></div>
                                                    </div>


                                                    <strong>Lampiran/Attachment Lain-lain</strong>
                                                    <div class="d-flex mb-2 mt-1">
                                                        <input type="file" class="form-control mr-1"
                                                            name="filename_tiv_lain[]" id="filename_tiv_lain_1" multiple>
                                                        <div class="form-control col-md-9 d-flex" id="fileList_tiv_3">
                                                        </div>
                                                    </div>

                                                    <strong>Import File List Peserta (file *.xlsx, *.xls)</strong>
                                                    <div class="d-flex mb-2 mt-1">
                                                        <input type="file" class="form-control mr-1" name="file"
                                                            id="file_list">
                                                        <div class="form-control col-md-9 d-flex" id="fileList_tiv_2">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
									</div>
                                        <h4>Surat Distributor</h4>
                                        <div class="row">
                                            {{-- <div class="col-md-2 mb-2">
                                        No. Surat
                                        <input type="text" name="no_surat" id="no_surat" class="form-control" value="" required>
                                    </div> --}}
                                            <div class="col-md-2 mb-2">
                                                No Surat
                                                <input type="text" name="no_surat" id="no_surat"
                                                    class="form-control" value="" required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Nama Program
                                                <input type="text" name="nama_program_distributor"
                                                    id="nama_program_distributor" class="form-control" value=""
                                                    required>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                Periode awal
                                                <input type="date" name="periode_awal" id="periode_awal"
                                                    class="form-control" value="" required>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                Periode akhir
                                                <input type="date" name="periode_akhir" id="periode_akhir"
                                                    class="form-control" value="" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Penerima
                                                <select name="penerima" id="penerima" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Outlet">Outlet</option>
                                                    <option value="Tim Distributor">Tim Distributor</option>
                                                    <option value="Tim TIV">Tim TIV</option>
                                                    <option value="Tim Distributor dan Tim TIV">Tim Distributor dan Tim
                                                        TIV
                                                    </option>
                                                    <option value="Vendor">Vendor</option>
                                                    <option value="Mix">Mix</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                Kategori
                                                <select name="kategori" id="kategori" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Program TIV">Program TIV</option>
                                                    <option value="Program Distributor">Program Distributor</option>
                                                    <option value="Sharing TUA TIV">Sharing TUA TIV</option>
                                                    <option value="Program Multi">Program Multi</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                                SKU
                                                {{-- <select name="sku" id="sku" class="form-control">
                                            <option value="">Select</option>
                                            <option value="SPS AQUA">SPS AQUA</option>
                                            <option value="SPS VIT">SPS VIT</option>
                                            <option value="Jugs AQUA">Jugs AQUA</option>
                                            <option value="Jugs VIT">Jugs VIT</option>
                                            <option value="Beverage">Beverage</option>
                                            <option value="Mix">Mix</option>
                                            <option value="None">None</option>
                                        </select> --}}
                                                <select name="sku[]" id="sku[]" class="form-control select2"
                                                    multiple>
                                                    {{-- <option value="">Pilih Segmen</option> --}}
                                                    @foreach ($sku as $row)
                                                        <option value="{{ $row->sku }}"
                                                            {{ old('sku') == $row->sku ? 'selected' : '' }}>
                                                            {{ $row->sku }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Channel/Segmen
                                                <select name="segmen[]" id="segmen[]" class="form-control select2"
                                                    multiple>
                                                    {{-- <option value="">Pilih Segmen</option> --}}
                                                    @foreach ($segmen as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ old('id') == $row->id ? 'selected' : '' }}>
                                                            {{ $row->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                Surat Distributor
                                                <select name="surat_dist" id="surat_dist" class="form-control">
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="form-surat-dist">
                                            <div class="field_wrapper_surat">
                                                <h5>* Wenang Palm Solusindo</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        Untuk Perusahaan
                                                        <select name="id_perusahaan_ta" id="id_perusahaan_ta"
                                                            class="form-control">
                                                            <option value="WPS">Wenang Palm Solusindo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <strong>Lampiran/Attachment</strong>
                                                        <div class="d-flex">
                                                            <input type="file" class="form-control mr-1"
                                                                name="filenameta[]" id="filenameta_1" multiple>
                                                            <div class="form-control col-md-9 d-flex flex-wrap"
                                                                id="fileList_ta"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="form-input">
                                                    <div class="field_wrapper_ta">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                Untuk Depo
                                                                <select name="id_depo_ta[]" id="id_depo_ta_1"
                                                                    class="form-control">
                                                                    <option value="">Pilih Depo</option>
                                                                    @foreach ($kode_depo_ta as $row)
                                                                        <option value="{{ $row->kode_depo }}"
                                                                            {{ old('kode_depo') == $row->kode_depo ? 'selected' : '' }}>
                                                                            {{ $row->nama_depo }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1 mb-2">
                                                                <br>
                                                                <a class="btn btn-primary" href="javascript:void(0);"
                                                                    id="add_button_ta" title="Add field">+</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <h5>* Lokon Prima</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        Untuk Perusahaan
                                                        <select name="id_perusahaan_tu" id="id_perusahaan_tu"
                                                            class="form-control">
                                                            <option value="LP">Lokon Prima</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <strong>Lampiran/Attachment</strong>
                                                        <div class="d-flex">
                                                            <input type="file" class="form-control mr-1"
                                                                name="filenametu[]" id="filenametu_1" multiple>
                                                            <div class="form-control col-md-9 d-flex flex-wrap"
                                                                id="fileList_tu"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="form-input">
                                                    <div class="field_wrapper_tu">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                Untuk Depo
                                                                <select name="id_depo_tu[]" id="id_depo_tu_1"
                                                                    class="form-control">
                                                                    <option value="">Pilih Depo</option>
                                                                    @foreach ($kode_depo_tu as $row)
                                                                        <option value="{{ $row->kode_depo }}"
                                                                            {{ old('kode_depo') == $row->kode_depo ? 'selected' : '' }}>
                                                                            {{ $row->nama_depo }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1 mb-2">
                                                                <br>
                                                                <a class="btn btn-primary" href="javascript:void(0);"
                                                                    id="add_button_tu" title="Add field">+</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <h5>* Tirta Utama Abadi</h5>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        Untuk Perusahaan
                                                        <select name="id_perusahaan_tua" id="id_perusahaan_tua"
                                                            class="form-control">
                                                            <option value="TUA">Tirta Utama Abadi</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <strong>Lampiran/Attachment</strong>
                                                        <div class="d-flex">
                                                            <input type="file" class="form-control mr-1"
                                                                name="filenametua[]" id="filenametua_1" multiple>
                                                            <div class="form-control col-md-9 d-flex flex-wrap"
                                                                id="fileList_tua"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="form-input">
                                                    <div class="field_wrapper_tua">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                Untuk Depo
                                                                <select name="id_depo_tua[]" id="id_depo_tua_1"
                                                                    class="form-control">
                                                                    <option value="">Pilih Depo</option>
                                                                    @foreach ($kode_depo_tua as $row)
                                                                        <option value="{{ $row->kode_depo }}"
                                                                            {{ old('kode_depo') == $row->kode_depo ? 'selected' : '' }}>
                                                                            {{ $row->nama_depo }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-1 mb-2">
                                                                <br>
                                                                <a class="btn btn-primary" href="javascript:void(0);"
                                                                    id="add_button_tua" title="Add field">+</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">

                                                    <button type="button" id="kembali" name="kembali"
                                                        class="btn btn-primary btn-sm" onclick="goBack()">Kembali</button>

                                                    <button type="button" id="batal" name="batal"
                                                        class="btn btn-warning btn-sm">Batal</button>

                                                    <button type="submit" id="savedatas" name="savedatas"
                                                        class="btn btn-success btn-sm float-right">Kirim Surat</button>
                                                </div>
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


@endsection

@section('script')


    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: false,
                bFilter: false,
                lengthChange: false,
                scrollY: "355px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

    <!-- jQuery (pastikan Anda sudah menginstalnya atau tambahkan juga melalui CDN jika belum) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>



@endsection
