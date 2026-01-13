@section('js')
    <script type="text/javascript">
        var temp_total = 0;

        $('#price_1').maskMoney({
            thousands: ',',
            decimal: '.',
            precision: 0,
            allowNegative: true
        });

        $(document).on('click', '.pilih_category', function(e) {
            document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
            document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
            document.getElementById('sifat').value = $(this).attr('data-sifat')
            document.getElementById('jenis').value = $(this).attr('data-jenis')
            document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
            document.getElementById('kategori').value = $(this).attr('data-kategori')
            document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')

            // document.getElementById('kode_coa').value = $(this).attr('data-kode_coa')
            // document.getElementById('coa').value = $(this).attr('data-nama_coa')
            // document.getElementById('debit').value = $(this).attr('data-debit')
            // document.getElementById('kredit').value = $(this).attr('data-kredit')

            $('#myModalKategori').modal('hide');
        });

        $(document).on('click', '.pilih_coa', function(e) {
            document.getElementById('kode_coa').value = $(this).attr('data-kode_coa')
            document.getElementById('coa').value = $(this).attr('data-coa')
            document.getElementById('debit').value = $(this).attr('data-debit')
            document.getElementById('kredit').value = $(this).attr('data-kredit')

            $('#myModalCoa').modal('hide');
        });

        $(document).ready(function() {
            //var maxField = 10;

            var addButton = $('#add_button');
            var wrapper = $('.field_wrapper');
            var x = 1;
            $(addButton).click(function() {
                temp_total = $('#total').val();
                //menghilangka format rupiah//
                var temp_tharga = temp_total.replace(/[.](?=.*?\.)/g, '');
                var temp_txttotal = parseFloat(temp_tharga.replace(/[^0-9.-]/g, ''));
                //End menghilangka format rupiah//
                //alert(temp_txttotal);

                x++;
                $(wrapper).append(
                    '<div class="form-group add"><div class="row"><div class="col-md-3" hidden><textarea name="no_description_detail[]" id="no_description_detail_' +
                    x + '" rows="1" ="" class="form-control" >' + x +
                    '</textarea></div><div class="col-md-3"><textarea name="description[]" id="description_' +
                    x +
                    '" rows="1" ="" class="form-control" ></textarea></div><div class="col-md-3"><textarea name="spek[]" id="spek_' +
                    x +
                    '" rows="1" ="" class="form-control"></textarea></div><div class="col-md-1"><input class="form-control" type="text" name="qty[]" id="qty_' +
                    x + '" style="text-align: right;" onchange="jumlah(' + x +
                    ');" required/></div><div class="col-md-2"><input class="form-control" type="text" name="price[]" id="price_' +
                    x + '" value="0" style="text-align: right;" onchange="jumlah(' + x +
                    ');"/></div><div class="col-md-2"><input class="form-control" type="text" style="text-align: right;" value="0" name="total_price[]" id="total_price_' +
                    x +
                    '" value="0"  readonly/></div><div class="col-md-1" align="right"><a href="javascript:void(0);" style="text-align: center; width: 100%" class="remove_button btn btn-danger"><i class="nav-icon icon-trash"></i></a></div></div></div>'
                );
                $('#price_' + x + '').maskMoney({
                    thousands: ',',
                    decimal: '.',
                    precision: 0,
                    allowNegative: true
                });
            });


            var y = 1;
            $('#lookup').on('click', 'tbody tr', function(e) {

                if (y = x) {
                    e.preventDefault();
                    $('#idtype_' + y + '').val($(this).find('td').html());
                    $('#type_' + y + '').val($(this).find('td').next().html());
                    $('#kode_produk_' + y + '').val($(this).find('td').next().next().html());
                    $('#nama_produk_' + y + '').val($(this).find('td').next().next().next().html());
                    $('#merk_' + y + '').val($(this).find('td').next().next().next().next().html());

                    $('#myModal').modal('hide');
                } else {
                    y++;

                    e.preventDefault();
                    $('#idtype_' + y + '').val($(this).find('td').html());
                    $('#type_' + y + '').val($(this).find('td').next().html());
                    $('#kode_produk_' + y + '').val($(this).find('td').next().next().html());
                    $('#nama_produk_' + y + '').val($(this).find('td').next().next().next().html());
                    $('#merk_' + y + '').val($(this).find('td').next().next().next().next().html());

                    $('#myModal').modal('hide');
                }

            });


            $(wrapper).on('click', '.remove_button', function(e) {
                if (confirm("Apakah anda yakin mau menghapus baris ini?")) {
                    e.preventDefault();
                    $(this).parent('').parent('').remove();
                    hitungTotal();
                }

            });
        });

        var a = 0;

        function jumlah(x) {
            $kode_pengeluaran = $('#id_pengeluaran').val();

            if ($kode_pengeluaran == '1' || $kode_pengeluaran == '2' || $kode_pengeluaran == '3' || $kode_pengeluaran ==
                '4' || $kode_pengeluaran == '5' || $kode_pengeluaran == '130') {
                var b = 0;
                if (x == 1) {
                    var txtharga = $('#price_1').val();
                    //menghilangka format rupiah//
                    var temp_tharga = txtharga.replace(/[.](?=.*?\.)/g, '');
                    var temp_txtharga = parseFloat(temp_tharga.replace(/[^0-9.-]/g, ''));
                    //End menghilangka format rupiah//

                    txttotal = temp_txtharga;
                    txttotal_harga_bawah = parseInt(txttotal) + parseInt(temp_total);

                    $('#total_price_1').val(txtharga);

                    //membuat format rupiah//
                    var reverse = txttotal_harga_bawah.toString().split('').reverse().join(''),
                        ribuan = reverse.match(/\d{1,3}/g);
                    hasil_total_bawah = ribuan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    //temp_total = hasil;
                    $('#total').val(hasil_total_bawah);

                    b = txttotal;
                } else {
                    var txtharga = $('#price_' + x + '').val();
                    //menghilangka format rupiah//
                    var temp_tharga = txtharga.replace(/[.](?=.*?\.)/g, '');
                    var temp_txtharga = parseFloat(temp_tharga.replace(/[^0-9.-]/g, ''));
                    //End menghilangka format rupiah//

                    //menghilangka format rupiah//
                    var temp_temp_total = temp_total.replace(/[.](?=.*?\.)/g, '');
                    var temp_temp_total_hasil = parseFloat(temp_temp_total.replace(/[^0-9.-]/g, ''));
                    //End menghilangka format rupiah//

                    txttotal_harga = temp_txtharga;
                    txttotal_harga_bawah = parseInt(txttotal_harga) + parseInt(temp_temp_total_hasil);

                    //membuat format rupiah//
                    var reverse = txttotal_harga.toString().split('').reverse().join(''),
                        ribuan = reverse.match(/\d{1,3}/g);
                    hasil = ribuan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                    $('#total_price_' + x + '').val(hasil);

                    // temp_total = hasil;
                    //membuat format rupiah//
                    var reverse = txttotal_harga_bawah.toString().split('').reverse().join(''),
                        ribuan = reverse.match(/\d{1,3}/g);
                    hasil_total_bawah = ribuan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                    $('#total').val(hasil_total_bawah);

                    b = txttotal;


                }
            } else {
                var b = 0;
                if (x == 1) {
                    var txtqty = $('#qty_1').val();
                    var txtharga = $('#price_1').val();

                    //menghilangka format rupiah//
                    var temp_tharga = txtharga.replace(/[.](?=.*?\.)/g, '');
                    var temp_txtharga = parseFloat(temp_tharga.replace(/[^0-9.-]/g, ''));
                    //End menghilangka format rupiah//

                    txttotal = temp_txtharga * txtqty;
                    txttotal_harga_bawah = parseInt(txttotal) + parseInt(temp_total);

                    var isNegative = txttotal < 0; // cek apakah hasil negatif
                    var absoluteValue = Math.abs(txttotal); // ambil nilai positifnya

                    //membuat format rupiah//
                    var reverse = absoluteValue.toString().split('').reverse().join('');
                    var ribuan = reverse.match(/\d{1,3}/g);
                    var hasil = ribuan.join(',').split('').reverse().join('');
                    if (isNegative) hasil = '-' + hasil;
                    //End membuat format rupiah//
                    $('#total_price_1').val(hasil);

                    var isNegativeTotal = txttotal_harga_bawah < 0;
                    var absoluteTotal = Math.abs(txttotal_harga_bawah);
                    //membuat format rupiah//
                    var reverseTotal = absoluteTotal.toString().split('').reverse().join('');
                    var ribuanTotal = reverseTotal.match(/\d{1,3}/g);
                    var hasil_total_bawah = ribuanTotal.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                    if (isNegativeTotal) hasil_total_bawah = '-' + hasil_total_bawah;
                    
                    //temp_total = hasil;
                    $('#total').val(hasil_total_bawah);

                    b = txttotal;
                } else {
                    var txtqty = $('#qty_' + x + '').val();
                    var txtharga = $('#price_' + x + '').val();

                    //menghilangka format rupiah//
                    var temp_tharga = txtharga.replace(/[.](?=.*?\.)/g, '');
                    var temp_txtharga = parseFloat(temp_tharga.replace(/[^0-9.-]/g, ''));
                    //End menghilangka format rupiah//

                    //menghilangka format rupiah//
                    var temp_temp_total = temp_total.replace(/[.](?=.*?\.)/g, '');
                    var temp_temp_total_hasil = parseFloat(temp_temp_total.replace(/[^0-9.-]/g, ''));
                    //End menghilangka format rupiah//

                    txttotal_harga = temp_txtharga * txtqty
                    txttotal_harga_bawah = parseInt(txttotal_harga) + parseInt(temp_temp_total_hasil);

                    var isNegative = txttotal_harga < 0; // cek apakah hasil negatif
                    var absoluteValue = Math.abs(txttotal_harga); // ambil nilai positifnya

                    //membuat format rupiah//
                    var reverse = absoluteValue.toString().split('').reverse().join('');
                    var ribuan = reverse.match(/\d{1,3}/g);
                    var hasil = ribuan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                   
                    if (isNegative) hasil = '-' + hasil;

                    $('#total_price_' + x + '').val(hasil);

                    // temp_total = hasil;
                    //membuat format rupiah//
                    var reverse = txttotal_harga_bawah.toString().split('').reverse().join(''),
                        ribuan = reverse.match(/\d{1,3}/g);
                    hasil_total_bawah = ribuan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                    $('#total').val(hasil_total_bawah);

                    b = txttotal;
                }
                hitungTotal();
            }

            // a = parseInt(a) + parseInt(b) ;
            // //membuat format rupiah//
            // var reverse = a.toString().split('').reverse().join(''),
            //     ribuan  = reverse.match(/\d{1,3}/g);
            //     hasil_a = ribuan.join(',').split('').reverse().join('');
            // //End membuat format rupiah//
            // $('#total').val(hasil_a);

        }

        function hitungTotal() {
            var grandTotal = 0;

            $("input[name='total_price[]']").each(function() {
                // ambil nilai setiap total harga
                var val = $(this).val().replace(/[.](?=.*?\.)/g, ''); 
                val = val.replace(/[^0-9-]/g, '');
                if(val !== "") {
                    grandTotal += parseFloat(val);
                }
            });

            // format ribuan
            var isNegative = grandTotal < 0;
            var absoluteValue = Math.abs(grandTotal);

            var reverse = absoluteValue.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var hasil = ribuan.join(',').split('').reverse().join('');

            if (isNegative) hasil = '-' + hasil;

            $("#total").val(hasil);
        }


        $('#savedatas').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('pengajuan_biaya.store') }}',
                type: 'POST',
                data: $(this).serializeArray(),
                success: function(data) {
                    console.log(data);
                }
            });
        });

        $(function() {
            $('#kode_perusahaan').change(function() {
                var perusahaan_id = $(this).val();
                if (perusahaan_id) {
                    $.ajax({
                        type: "GET",
                        url: "/ajax?perusahaan_id=" + perusahaan_id,
                        dataType: 'JSON',
                        success: function(res) {
                            if (res) {
                                $("#kode_depo").empty();
                                $("#kode_depo").append('<option>Select</option>');
                                $.each(res, function(nama, kode) {
                                    $("#kode_depo").append('<option value="' + kode +
                                        '">' + nama + '</option>');
                                });
                            } else {
                                $("#kode_depo").empty();
                            }
                        }
                    });
                } else {
                    $("#kode_depo").empty();
                }
            });
        });

        $(document).ready(function() {
            fetch_data_coa();

            function fetch_data_coa(query = '') {
                $.ajax({
                    url: '{{ route('pengajuan_biaya/action_coa.actionCoa') }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#lookup_coa tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search_coa', function() {
                var query = $(this).val();
                fetch_data_coa(query);
            });
        });


        $(document).ready(function() {
            fetch_data_category();

            function fetch_data_category(query = '') {
                $.ajax({
                    url: '{{ route('pengajuan_biaya/action_category.actionCategory') }}',
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#lookup_category tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search_category', function() {
                var query = $(this).val();
                fetch_data_category(query);
            });
        });

        $("#button_hapus_lampiran").click(function() {
            $('#filename_1').val('');
        });
    </script>

    <script>
        $(document).ready(function() {
            // Simpan file yang sudah dipilih dalam variabel
            var selectedFiles = [];

            // Fungsi untuk memperbarui file yang sudah dipilih
            function updateFileList() {
                var fileInput = $("#filename_1")[0];
                fileInput.files = new DataTransfer().files; // Kosongkan input file

                var dataTransfer = new DataTransfer();
                for (var i = 0; i < selectedFiles.length; i++) {
                    dataTransfer.items.add(selectedFiles[i]);
                }
                fileInput.files = dataTransfer.files;

                // Tampilkan daftar file yang sudah dipilih
                var fileList = $("#fileList");
                fileList.empty();
                var fileNames = [];
                for (var i = 0; i < selectedFiles.length; i++) {
                    fileNames.push(selectedFiles[i].name);
                    var fileItem = $("<div>").text(selectedFiles[i].name).css({
                        "display": "flex",
                        "align-items": "center",
                        "border": "1px",
                    });
                    var removeButton = $("<button>").text("x").css({
                        "margin-left": "7px",
                        "margin-right": "7px",
                        "color": "white",
                        "background-color": "gray",
                        "border": "none",
                        "border-radius": "50%",
                        "width": "20px",
                        "height": "20px",
                        "display": "flex",
                        "justify-content": "center",
                        "align-items": "center"
                    }).attr("data-index", i).click(function() {
                        var index = $(this).attr("data-index");
                        selectedFiles.splice(index, 1);
                        updateFileList();
                    });
                    fileItem.append(removeButton);
                    fileList.append(fileItem);
                }

                // Perbarui input teks dengan nama-nama file yang dipilih
                $("#filename_1").val(fileNames.join(", "));
            }

            // Saat input file berubah, tambahkan file baru ke daftar yang sudah ada
            $("#filename_1").on("change", function(e) {
                var files = e.target.files;
                for (var i = 0; i < files.length; i++) {
                    selectedFiles.push(files[i]);
                }
                updateFileList();
            });

            // Fungsi validasi untuk pengecekan input file
            function validateForm() {
                var id_pengeluaran = $("#id_pengeluaran").val();
                if (id_pengeluaran == 31 || id_pengeluaran == 19) {
                    if (selectedFiles.length === 0) {
                        pesanText_3.text(
                            'Untuk pengajuan di luar ATK harus disertakan dengan Lampiran/Attachment pendukung. Lampiran/Attachment wajib diisi...'
                        );
                        modal_3.modal('show');
                        $("#filename_1").focus();
                        return false;
                    }
                }
                return true;
            }

            // Gantikan return false dalam validasi form dengan pemanggilan fungsi validateForm()
            $("#submit_form").on("submit", function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });
        });
    </script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Buat Pengajuan</title>
@endsection

@section('content')



    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Pengajuan</li>
            <li class="breadcrumb-item">Pengajuan Biaya/Jasa</li>
            <li class="breadcrumb-item active">Buat Pengajuan</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <form action="{{ route('pengajuan_biaya.store') }}" method="post" onkeypress="return event.keyCode != 13"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Buat Pengajuan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            Tgl Pengajuan
                                            <input type="text" name="tgl" class="form-control"
                                                value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}"
                                                required readonly>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Diajukan Oleh
                                            <input type="text" name="nama" class="form-control"
                                                value="{{ Auth::user()->name }}" required readonly>

                                        </div>

                                        <div class="col-md-6 mb-2">
                                            Untuk Perusahaan
                                            <select name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan"
                                                class="form-control" required>
                                                <option value="">select</option>
                                                @foreach ($perusahaan as $row)
                                                    <option value="{{ $row->kode_perusahaan }}"
                                                        {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected' : '' }}>
                                                        {{ $row->nama_perusahaan }}</option>
                                                @endforeach
                                            </select>

                                            <input type="hidden" name="kode_perusahaan" class="form-control"
                                                value="{{ Auth::user()->kode_perusahaan }}" required readonly>
                                        </div>

                                        <div class="col-md-2 mb-2" hidden>
                                            Depo
                                            <!-- <select name="kode_depo" id="kode_depo" class="form-control">
                                                                                                                                                                                                                                                                                                                        <option value="">select</option>
                                                                                                                                                                                                                                                                                                                    </select> -->
                                            <input type="text" name="kode_depo" class="form-control"
                                                value="{{ Auth::user()->kode_depo }}" required readonly>
                                        </div>

                                        <div class="col-md-2 mb-2" hidden>
                                            Divisi
                                            <!-- <select name="kode_divisi" class="form-control">
                                                                                                                                                                                                                                                                                                                        <option value="">Pilih</option>
                                                                                                                                                                                                                                                                                                                        @foreach ($divisi as $row)
    <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected' : '' }}>{{ $row->nama_divisi }}</option>
    @endforeach
                                                                                                                                                                                                                                                                                                                    </select> -->
                                            <input type="text" name="kode_divisi" class="form-control"
                                                value="{{ Auth::user()->kode_divisi }}" required readonly>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 mb-2" hidden>
                                            Type
                                            <select name="tipe" class="form-control">
                                                <option value="">Select</option>
                                                <option value="OPS Rit">OPS Rit</option>
                                                <option value="BBM">BBM</option>
                                                <option value="Bengkel">Bengkel</option>
                                                <option value="Materai">Materai</option>
                                                <option value="REX">REX</option>
                                                <option value="Telepon/Internet">Telepon/Internet</option>
                                                <option value="Tiki">Tiki</option>
                                                <option value="Weekly">Weekly</option>
                                            </select>

                                        </div>

                                        <div class="col-md-6 mb-2">
                                            Nama Pengeluaran
                                            <!-- <select name="jenis" class="form-control" required>
                                                                                                                                                                                                                                                                                                                        <option value="">Select</option>
                                                                                                                                                                                                                                                                                                                        <option value="Rutin">Rutin</option>
                                                                                                                                                                                                                                                                                                                        <option value="Non Rutin">Non Rutin</option>
                                                                                                                                                                                                                                                                                                                    </select> -->
                                            <div class="input-group">
                                                <input id="id_pengeluaran" type="hidden" name="id_pengeluaran"
                                                    value="" required>
                                                <input id="nama_pengeluaran" type="text" class="form-control" readonly
                                                    required>
                                                <input id="sifat" type="hidden" name="sifat" class="form-control"
                                                    required>
                                                <input id="jenis" type="hidden" name="jenis" class="form-control"
                                                    required>
                                                <input id="pembayaran" type="hidden" name="pembayaran" class="form-control"
                                                    required>
                                                <input id="kategori" type="hidden" name="kategori" class="form-control"
                                                    required>
                                                <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran"
                                                    class="form-control" required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary"
                                                        data-toggle="modal" data-target="#myModalKategori"> <span
                                                            class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            Permintaan Pengajuan
                                            <input type="text" name="ket" id="ket" class="form-control"
                                                value="" required>
                                        </div>

                                        <div class="col-md-6 mb-2" hidden>
                                            C O A
                                            <div class="input-group">
                                                <input id="coa" type="text" class="form-control" readonly>
                                                <input id="kode_coa" type="hidden" name="kode_coa" value=""
                                                    readonly>
                                                <input id="debit" type="hidden" name="debit" value=""
                                                    readonly>
                                                <input id="kredit" type="hidden" name="kredit" value=""
                                                    readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary"
                                                        data-toggle="modal" data-target="#myModalCoa"> <span
                                                            class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    @if (Auth::user()->kode_divisi == '1')
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="">Pengajuan File (.xls, .xlsx)</label>
                                                <input type="file" name="file" class="form-control"
                                                    value="{{ old('file') }}">
                                                <p class="text-danger">{{ $errors->first('file') }}</p>
                                            </div>

                                            {{-- <div class="col-md-4 mb-2">
                                            <br>
                                            <br>
                                            <button class="btn btn-primary btn-sm">Import</button>
                                        </div> --}}
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>

                        <!-- ################################### COBA #################################### -->

                        <div class="col-md-12">
                            <div class="card">
                                <form id="savedatas">
                                    <div class="card-body">
                                        <div class="field_wrapper">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3" hidden>
                                                        <strong>No</strong>
                                                        <textarea name="no_description_detail[]" id="no_description_detail_1" rows="1" class="form-control">1</textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Uraian</strong>
                                                        <textarea name="description[]" id="description_1" rows="1" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Spesifikasi</strong>
                                                        <textarea name="spek[]" id="spek_1" rows="1" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <strong>Jumlah</strong>
                                                        <input class="form-control" type="text" name="qty[]"
                                                            id="qty_1" style="text-align: right;" value=""
                                                            onchange="jumlah('1');" required />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <strong>Harga</strong>
                                                        <input class="form-control" type="text" name="price[]"
                                                            id="price_1" style="text-align: right;" value="0"
                                                            onchange="jumlah('1');" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <strong>Total Harga</strong>
                                                        <input class="form-control" type="text" name="total_price[]"
                                                            id="total_price_1" style="text-align: right;" value="0"
                                                            readonly />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <strong>Aksi</strong>
                                                        <a class="btn btn-warning" href="javascript:void(0);"
                                                            id="add_button" style="text-align: center; width: 100%"
                                                            title="Add field">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <strong>Lampiran/Attachment</strong>
                                                <div class="d-flex ">
                                                    <input type="file" class="form-control" name="filename[]"
                                                        id="filename_1" multiple>
                                                    <div type="file" id="fileList"
                                                        class="form-control col-8 d-flex ml-1"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                            </div>
                                            <div class="col-md-4 mb-2" align="right">
                                                {{-- <button type="hidden" id="savedatas" name="savedatas" class="btn btn-primary">Simpan Sebagai draft </button> --}}
                                            </div>
                                            <div class="col-md-2 mb-2" align="right">
                                                <strong>T o t a l</strong>
                                            </div>
                                            <div class="col-md-2 mb-2" align="right">
                                                <input type="text" name="total" id="total" class="form-control"
                                                    value="0" style="text-align:right; font-style:bold;" required
                                                    readonly>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button type="submit" id="savedatas" name="savedatas"
                                                    style="width: 100%" class="btn btn-success">Kirim</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                </form>
            </div>
        </div>
    </main>

    <div class="modal fade bd-example-modal-lg" id="myModalCoa" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background: #fff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="get">
                        <div class="input-group mb-3 col-md-6 float-right">
                            <input type="text" name="search_coa" id="search_coa" class="form-control"
                                placeholder="Cari Data . . .">
                        </div>
                    </form>
                    <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                        <table id="lookup_coa" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Account Id</th>
                                    <th>Account Name</th>
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

    <div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background: #fff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="get">
                        <div class="input-group mb-3 col-md-6 float-right">
                            <input type="text" name="search_category" id="search_category" class="form-control"
                                placeholder="Cari Kategori . . .">
                        </div>
                    </form>
                    <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                        <table id="lookup_category" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nama Pengeluaran</th>
                                    <th>Sifat</th>
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

@section('script')



@endsection
