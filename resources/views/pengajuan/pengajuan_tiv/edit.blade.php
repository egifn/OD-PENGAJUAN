@section('js')

<script type="text/javascript">
    function goBack() {
        window.history.back();
    }

    fetchAllData();
    function fetchAllData(){
        // let id = $(this).data('id_program');
        // let perusahaan = $(this).data('perusahaan');

        let perusahaan = $("#kode_perusahaan_tujuan").val();
        let kode_pengajuan = $("#kode_pengajuan_b").val();
        let id = $("#id_program").val();
        let tgl_import = $("#tgl_import").val();
        
        $.ajax({
        type: "GET",
        url: "{{ route('pengajuan_tiv/view_data_all.view_data_all') }}",
        data: {
            id: id,
            kode_pengajuan: kode_pengajuan,
            perusahaan: perusahaan,
			tgl_import: tgl_import
        },
        dataType: "json",
        success: function(response) {
            let tabledata_outlet;
            let totalReward = 0;
            let totalReward_tiv = 0;
            let totalPotongan = 0;
            let totalDitransfer = 0;
            let no = 0;
            response.data.forEach(program => {
                let reward = program.reward;
                //membuat format rupiah Harga//
                var reverse_reward = reward.toString().split('').reverse().join(''),
                ribuan_reward  = reverse_reward.match(/\d{1,3}/g);
                rupiah_reward = ribuan_reward.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                let reward_tiv = program.reward_tiv;
                //membuat format rupiah Harga//
                var reverse_reward_tiv = reward_tiv.toString().split('').reverse().join(''),
                ribuan_reward_tiv  = reverse_reward_tiv.match(/\d{1,3}/g);
                rupiah_reward_tiv = ribuan_reward_tiv.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                let potongan = program.potongan;
                //membuat format rupiah Harga//
                var reverse_potongan = potongan.toString().split('').reverse().join(''),
                ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                rupiah_potongan = ribuan_potongan.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                let ditransfer = program.ditransfer;
                //membuat format rupiah Harga//
                var reverse_ditransfer = ditransfer.toString().split('').reverse().join(''),
                ribuan_ditransfer  = reverse_ditransfer.match(/\d{1,3}/g);
                ditransfer_rupiah = ribuan_ditransfer.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                no = no + 1
                tabledata_outlet += `<tr>`;
                tabledata_outlet += `<td>` +no+ `</td>`;
                tabledata_outlet += `<td hidden>${program.id_program}</td>`;
                tabledata_outlet += `<td>${program.perusahaan}</td>`;
                tabledata_outlet += `<td>${program.dist_depo}</td>`;
                tabledata_outlet += `<td>${program.cluster}</td>`;
                tabledata_outlet += `<td>${program.customer_id}</td>`;
                tabledata_outlet += `<td>${program.customer_name}</td>`;
                tabledata_outlet += `<td>${program.no_rek}</td>`;
                tabledata_outlet += `<td>${program.bank}</td>`;
                tabledata_outlet += `<td>${program.nama_rekening}</td>`;
                tabledata_outlet += `<td align='right'>${rupiah_reward}</td>`;
                tabledata_outlet += `<td align='right'>${rupiah_reward_tiv}</td>`;
                tabledata_outlet += `<td align='right'>${rupiah_potongan}</td>`;
                tabledata_outlet += `<td align='right'>${ditransfer_rupiah}</td>`;
                tabledata_outlet += `</tr>`;

                totalReward += program.reward;
                totalReward_tiv += program.reward_tiv;
                totalPotongan += parseInt(program.potongan);
                totalDitransfer += program.ditransfer;
            });

            //membuat format rupiah totalReward//
            var reverse_totalReward = totalReward.toString().split('').reverse().join(''),
                ribuan_totalReward  = reverse_totalReward.match(/\d{1,3}/g);
                totalReward_rupiah = ribuan_totalReward.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            //membuat format rupiah totalReward//
            var reverse_totalReward_tiv = totalReward_tiv.toString().split('').reverse().join(''),
                ribuan_totalReward_tiv  = reverse_totalReward_tiv.match(/\d{1,3}/g);
                totalReward_tiv_rupiah = ribuan_totalReward_tiv.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            //membuat format rupiah totalPotongan//
            var reverse_totalPotongan = totalPotongan.toString().split('').reverse().join(''),
                ribuan_totalPotongan  = reverse_totalPotongan.match(/\d{1,3}/g);
                totalPotongan_rupiah = ribuan_totalPotongan.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            //membuat format rupiah totalPotongan//
            var reverse_totalDitransfer = totalDitransfer.toString().split('').reverse().join(''),
                ribuan_totalDitransfer  = reverse_totalDitransfer.match(/\d{1,3}/g);
                totalDitransfer_rupiah = ribuan_totalDitransfer.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            tabledata_outlet += `<tr>`;
            tabledata_outlet += `<td colspan="9" align='center'><b>T o t a l</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalReward_rupiah}</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalReward_tiv_rupiah}</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalPotongan_rupiah}</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalDitransfer_rupiah}</b></td>`;
            tabledata_outlet += `</tr>`;

            $("#tabledata_outlet").html(tabledata_outlet);
            $("#table_footer").html(table_footer);
        }
        });
    }

    $(document).on('click', '.pilih_program', function(e){
		document.getElementById('tgl_import').value = $(this).attr('data-tgl_import')
		document.getElementById('no_urut_upload').value = $(this).attr('data-no_urut_upload')
        document.getElementById('no_surat').value = $(this).attr('data-no_surat')
        document.getElementById('no_surat_program').value = $(this).attr('data-no_surat')
        document.getElementById('jenis_surat').value = $(this).attr('data-jenis_surat')
        document.getElementById('id_program').value = $(this).attr('data-id_program')
        document.getElementById('id_program_simpan').value = $(this).attr('data-id_program')
        document.getElementById('nama_program').value = $(this).attr('data-nama_program')
        document.getElementById('kategori_program').value = $(this).attr('data-kategori-program')
        //document.getElementById('no_urut').value = $(this).attr('data-no_urut')

        $('#myModalProgram').modal('hide');

        let id_perusahaan = $("#kode_perusahaan_tujuan").val();
        let id_program = $("#id_program").val();
		let tgl_import = $("#tgl_import").val();
		let no_urut_upload = $("#no_urut_upload").val();

        if ($("#kode_perusahaan_tujuan").val() == ""){
            alert("Pilih Perusahaan. Perusahaan harus diisi");
            $("#kode_perusahaan_tujuan").focus();
            return (false);
        }

        if ($("#id_program").val() == ""){
            alert("No Surat dan Id Program harus disi. No Surat dan Id Program tidak boleh kosong");
            $("#id_program").focus();
            return (false);
        }

        $.ajax({
            type: "GET",
            url: "{{ route('pengajuan_tiv/cari_data.cari_data') }}",
            data: {
                id_program: id_program,
                id_perusahaan: id_perusahaan,
				tgl_import: tgl_import,
				no_urut_upload: no_urut_upload
            },
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 0;
                response.data.forEach(program => {
                    let total_reward = program.total_reward;
                    //membuat format rupiah Harga//
                    var reverse_total_reward = total_reward.toString().split('').reverse().join(''),
                    ribuan_total_reward  = reverse_total_reward.match(/\d{1,3}/g);
                    total_rupiah_reward = ribuan_total_reward.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let total_reward_tiv = program.total_reward_tiv;
                    //membuat format rupiah Harga//
                    var reverse_total_reward_tiv = total_reward_tiv.toString().split('').reverse().join(''),
                    ribuan_total_reward_tiv  = reverse_total_reward_tiv.match(/\d{1,3}/g);
                    total_rupiah_reward_tiv = ribuan_total_reward_tiv.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let total_potongan = program.total_potongan;
                    //membuat format rupiah Harga//
                    var reverse_total_potongan = total_potongan.toString().split('').reverse().join(''),
                    ribuan_total_potongan  = reverse_total_potongan.match(/\d{1,3}/g);
                    total_rupiah_potongan = ribuan_total_potongan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let hasil_total = (parseInt(program.total_reward) + parseInt(program.total_reward_tiv)) - parseInt(program.total_potongan);
                    //membuat format rupiah Harga//
                    var reverse_hasil_total = hasil_total.toString().split('').reverse().join(''),
                    ribuan_hasil_total  = reverse_hasil_total.match(/\d{1,3}/g);
                    hasil_total_rupiah = ribuan_hasil_total.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    no = no + 1
                    tabledata += `<tr>`;
                    tabledata += `<td hidden>` +no+ `</td>`;
					tabledata += `<td hidden><input type="hidden" class="form-control" name="tgl_import" id="tgl_import" value="${program.tgl_import}">${program.tgl_import}</td>`;
                    tabledata += `<td><input type="hidden" class="form-control" name="id_program" id="id_program" value="${program.id_program}">${program.id_program}</td>`;
                    tabledata += `<td><input type="hidden" class="form-control" name="perusahaan" id="perusahaan" value="${program.perusahaan}">${program.perusahaan}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="jml_toko" id="jml_toko" value="${program.jml_toko}">${program.jml_toko}</td>`;
                    // tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_reward[]" id="total_reward" value="${program.total_reward}">Rp. ${total_rupiah_reward}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_reward_tiv" id="total_reward_tiv" value="${program.total_reward_tiv}">Rp. ${total_rupiah_reward_tiv}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_potongan" id="total_potongan" value="${program.total_potongan}">Rp. ${total_rupiah_potongan}</td>`; //total
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="hasil_total" id="hasil_total" value="${hasil_total}">Rp. ${hasil_total_rupiah}</td>`;
                    // tabledata += `<td align="center"><button type="button" data-id="${program.id_program}" data-perusahaan="${program.perusahaan}" data-tgl_import="${program.tgl_import}" id="button_view_data" class="btn btn-success btn-sm">View</button>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
                $("#total_harga").val(hasil_total_rupiah);
                eventHandlerButtonCariDatalAll();
            }
        });
    });

    $(document).on("keyup", "#no_surat", function(e) {
        let id_perusahaan = $("#kode_perusahaan_tujuan").val();
        let id_program = $("#id_program").val();
		let tgl_import = $("#tgl_import").val();
		let no_urut_upload = $("#no_urut_upload").val();

        if ($("#kode_perusahaan_tujuan").val() == ""){
            alert("Pilih Perusahaan. Perusahaan harus diisi");
            $("#kode_perusahaan_tujuan").focus();
            return (false);
        }

        if ($("#id_program").val() == ""){
            alert("No Surat dan Id Program harus disi. No Surat dan Id Program tidak boleh kosong");
            $("#id_program").focus();
            return (false);
        }

        $.ajax({
            type: "GET",
            url: "{{ route('pengajuan_tiv/cari_data.cari_data') }}",
            data: {
                id_program: id_program,
                id_perusahaan: id_perusahaan,
				tgl_import: tgl_import,
				no_urut_upload: no_urut_upload
            },
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 0;
                response.data.forEach(program => {
                    let total_reward = program.total_reward;
                    //membuat format rupiah Harga//
                    var reverse_total_reward = total_reward.toString().split('').reverse().join(''),
                    ribuan_total_reward  = reverse_total_reward.match(/\d{1,3}/g);
                    total_rupiah_reward = ribuan_total_reward.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let total_reward_tiv = program.total_reward_tiv;
                    //membuat format rupiah Harga//
                    var reverse_total_reward_tiv = total_reward_tiv.toString().split('').reverse().join(''),
                    ribuan_total_reward_tiv  = reverse_total_reward_tiv.match(/\d{1,3}/g);
                    total_rupiah_reward_tiv = ribuan_total_reward_tiv.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let total_potongan = program.total_potongan;
                    //membuat format rupiah Harga//
                    var reverse_total_potongan = total_potongan.toString().split('').reverse().join(''),
                    ribuan_total_potongan  = reverse_total_potongan.match(/\d{1,3}/g);
                    total_rupiah_potongan = ribuan_total_potongan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let hasil_total = (parseInt(program.total_reward) + parseInt(program.total_reward_tiv)) - parseInt(program.total_potongan);
                    //membuat format rupiah Harga//
                    var reverse_hasil_total = hasil_total.toString().split('').reverse().join(''),
                    ribuan_hasil_total  = reverse_hasil_total.match(/\d{1,3}/g);
                    hasil_total_rupiah = ribuan_hasil_total.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    no = no + 1
                    tabledata += `<tr>`;
                    tabledata += `<td hidden>` +no+ `</td>`;
					tabledata += `<td hidden><input type="hidden" class="form-control" name="tgl_import" id="tgl_import" value="${program.tgl_import}">${program.tgl_import}</td>`;
                    tabledata += `<td><input type="hidden" class="form-control" name="id_program" id="id_program" value="${program.id_program}">${program.id_program}</td>`;
                    tabledata += `<td><input type="hidden" class="form-control" name="perusahaan" id="perusahaan" value="${program.perusahaan}">${program.perusahaan}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="jml_toko" id="jml_toko" value="${program.jml_toko}">${program.jml_toko}</td>`;
                    // tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_reward[]" id="total_reward" value="${program.total_reward}">Rp. ${total_rupiah_reward}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_reward_tiv" id="total_reward_tiv" value="${program.total_reward_tiv}">Rp. ${total_rupiah_reward_tiv}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_potongan" id="total_potongan" value="${program.total_potongan}">Rp. ${total_rupiah_potongan}</td>`; //total
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="hasil_total" id="hasil_total" value="${hasil_total}">Rp. ${hasil_total_rupiah}</td>`;
                    // tabledata += `<td align="center"><button type="button" data-id="${program.id_program}" data-perusahaan="${program.perusahaan}" data-tgl_import="${program.tgl_import}" id="button_view_data" class="btn btn-success btn-sm">View</button>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
                $("#total_harga").val(hasil_total_rupiah);
                eventHandlerButtonCariDatalAll();
            }
        });
    });

    $(document).on("click", "#button_view_data", function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let perusahaan = $(this).data('perusahaan');
        let tgl_import = $(this).data('tgl_import');

        $.ajax({
        type: "GET",
        url: "{{ route('pengajuan_tiv/view_data_all.view_data_all') }}",
        data: {
             id: id,
             perusahaan: perusahaan,
             tgl_import: tgl_import
        },
        dataType: "json",
        success: function(response) {
                let tabledata_list;
                let no = 0;
                response.data.forEach(program => {
                    let reward = program.reward;
                    //membuat format rupiah Harga//
                    var reverse_reward = reward.toString().split('').reverse().join(''),
                    ribuan_reward  = reverse_reward.match(/\d{1,3}/g);
                    rupiah_reward = ribuan_reward.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let potongan = program.potongan;
                    //membuat format rupiah Harga//
                    var reverse_potongan = potongan.toString().split('').reverse().join(''),
                    ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                    rupiah_potongan = ribuan_potongan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let ditransfer = program.ditransfer;
                    //membuat format rupiah Harga//
                    var reverse_ditransfer = ditransfer.toString().split('').reverse().join(''),
                    ribuan_ditransfer  = reverse_ditransfer.match(/\d{1,3}/g);
                    ditransfer_rupiah = ribuan_ditransfer.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    no = no + 1
                    tabledata_list += `<tr>`;
                    tabledata_list += `<td>` +no+ `</td>`;
                    tabledata_list += `<td hidden>${program.id_program}</td>`;
                    tabledata_list += `<td>${program.perusahaan}</td>`;
                    tabledata_list += `<td>${program.dist_depo}</td>`;
                    tabledata_list += `<td>${program.cluster}</td>`;
                    tabledata_list += `<td>${program.customer_id}</td>`;
                    tabledata_list += `<td>${program.cuastomer_name}</td>`;
                    tabledata_list += `<td>${program.no_rek}</td>`;
                    tabledata_list += `<td>${program.bank}</td>`;
                    tabledata_list += `<td>${program.nama_rekening}</td>`;
                    tabledata_list += `<td>${program.ach}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_reward}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_potongan}</td>`;
                    tabledata_list += `<td alignt='right'>${ditransfer_rupiah}</td>`;
                    tabledata_list += `</tr>`;
                });
                $("#tabledata_list").html(tabledata_list);
            }
        });
        $('#modalView').modal('show');
    });

    $(document).ready(function(){
        fetch_data_program();
        function fetch_data_program(query = '')
        {
            let perusahaan_tujuan = $("#kode_perusahaan_tujuan").val();
            $.ajax({
                url:'{{ route("pengajuan_tiv/action_program.actionProgram") }}',
                method:'GET',
                data:{
                    query:query,
                    perusahaan_tujuan:perusahaan_tujuan
                },
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_program tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_program', function(){
            var query = $(this).val();
            fetch_data_program(query);
        });
    });

    // $("#button_hapus_lampiran").click(function(){
    //     $('#filename_1').val('');
    // });

</script>

<script>
    $(document).ready(function() {
        // Simpan file yang sudah dipilih dalam variabel
        var selectedFiles = [];

        // Fungsi untuk memperbarui file yang sudah dipilih
        function updateFileList() {
            var fileInput = $("#file_input")[0];
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
        $("#file_input").on("change", function(e) {
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
                    $("#file_input").focus();
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
    <title>Edit Pengajuan TIV</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Pengajuan Program</li>
        <li class="breadcrumb-item active">Edit Pengajuan Program</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan_tiv/edit.edit') }}" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Edit Tanggungan TIV - {{ $pengajuan_biaya_head->kode_pengajuan_b }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_biaya_head->tgl_pengajuan_b }}" readonly>
                                        <input type="hidden" name="kode_pengajuan_b" id="kode_pengajuan_b" class="form-control" value="{{ $pengajuan_biaya_head->kode_pengajuan_b }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_biaya_head->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $pengajuan_biaya_head->nama_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="depo" class="form-control" value="{{ $pengajuan_biaya_head->nama_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="nm_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->nama_pengeluaran }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Untuk Perusahaan
                                        <input type="text" name="perusahaan_tujuan" id="perusahaan_tujuan" class="form-control" value="{{ $pengajuan_biaya_head->perusahaan_tujuan }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2" hidden>
                                        Kode Untuk Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $pengajuan_biaya_head->kode_perusahaan_tujuan }}" required readonly>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        No Surat 
                                        {{-- <input id="no_surat" id="no_surat" type="text" name="no_surat" class="form-control" value="{{ $pengajuan_biaya_head->no_surat_program }}" readonly> --}}
                                        <div class="input-group">
                                            <input id="no_surat" id="no_surat" type="text" class="form-control" value="{{ $pengajuan_biaya_head->no_surat_program }}" required>
                                            <input id="no_surat_program" type="hidden" name="no_surat_program" value="{{ $pengajuan_biaya_head->no_surat_program }}" required>
                                            <input id="id_program_simpan" type="hidden" name="id_program_simpan" value="{{ $pengajuan_biaya_head->id_program }}" required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalProgram"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Id Program
                                        <input type="text" name="id_program" id="id_program" class="form-control" value="{{ $pengajuan_biaya_head->id_program }}" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Program
                                        <input type="text" name="nama_program" id="nama_program" class="form-control" value="{{ $pengajuan_biaya_head->nama_program }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Kategori Program
                                        <input type="text" name="kategori_program" id="kategori_program" class="form-control" value="{{ $pengajuan_biaya_head->kategori }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required>
                                    </div>
                                    
                                    

                                    <div class="col-md-2 mb-2" hidden>
                                        tgl_import
                                        <input type="text" name="tgl_import" id="tgl_import" class="form-control" value="{{ $pengajuan_biaya_head->tgl_import }}" required>
                                    </div>

                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" id="ket" class="form-control" value="{{ $pengajuan_biaya_head->keterangan }}">
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Division
                                        <input type="text" name="divisi" class="form-control" value="{{ $pengajuan_biaya_head->nama_divisi }}" readonly>
                                       
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        tipe
                                        <input type="text" name="tipe" class="form-control" value="" readonly>
                                       
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    
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
                                                <a class="nav-link active" data-toggle="tab" href="#pengajuan" role="tab" aria-controls="pengajuan">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Pengajuan</b>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#detail" role="tab" aria-controls="detail">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Detail Pengajuan</b>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="pengajuan" role="tabpanel">
                                                <br>

                                                <div class="table-responsive">
                                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th hidden>#</th>
                                                                    <th hidden>Tgl Import</th>
                                                                    <th>Id Program</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Jml Toko</th>
                                                                    <th>Total Reward</th>
                                                                    <th>Total Potongan</th>
                                                                    <th>Total</th>
                                                                    <th hidden>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tabledata">
                                                                @forelse ($pengajuan_biaya_detail as $row)
                                                                <tr>
                                                                    <td hidden>#</td>
                                                                    <td hidden><input type="hidden" class="form-control" name="tgl_import" id="tgl_import" value=""></td>
                                                                    <td><input type="hidden" class="form-control" name="perusahaan" id="perusahaan" value="{{ $row->description }}">{{ $row->description }}</td>
                                                                    <td><input type="hidden" class="form-control" name="id_program" id="id_program" value="{{ $row->spesifikasi }}">{{ $row->spesifikasi }}</td>
                                                                    <td align="right"><input type="hidden" class="form-control" name="jml_toko" id="jml_toko" value="{{ $row->qty }}">{{ $row->qty }}</td>
                                                                    <td align="right"><input type="hidden" class="form-control" name="total_reward_tiv" id="total_reward_tiv" value="{{ $row->harga }}">Rp. {{ number_format($row->harga)}}</td>
                                                                    <td align="right"><input type="hidden" class="form-control" name="total_potongan" id="total_potongan" value="{{ $row->potongan }}">Rp. {{ number_format($row->potongan)}}</td>
                                                                    <td align="right"><input type="hidden" class="form-control" name="hasil_total" id="hasil_total" value="{{ $row->tharga }}">Rp. {{ number_format($row->tharga)}}</td>
                                                                    <td align="center" hidden>
                                                                        <button type="button" data-id="{{ $row->description }}" data-perusahaan="{{ $row->spesifikasi }}" id="button_view_data" class="btn btn-success btn-sm">View</button>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                
                                                                </tr>
                                                                @endforelse               
                                                            </tbody>
                                                        </table>
                                                    <!--</div>-->
                                                    </div>
                                                    <br>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-8 mb-2">
                                                            <div class="input-group mb-3">
                                                                
                                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                                    <tbody>
                                                                        <?php $no=1 ?>
                                                                        @forelse ($approval_upload as $row)
                                                                        <tr>
                                                                            <td><i>Attachment_{{ $no }}</i></td>
                                                                            <td>
                                                                                <a href="{{url('images/'. $row->filename)}}">
                                                                                    {{ $row->filename}}
                                                                                </a>
                                                                                
                                                                            </td>
                                                                        </tr>
                                                                        <?php $no++ ?>
                                                                        @empty
                                                                        
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                
                                                            </div>
                                                        </div>
                
                                                        <div class="col-md-2 mb-2">
                                                            <label class="float-right" style="font-size:20px; ">Total Rp.</label>
                                                        </div>  
                                                        <div class="col-md-2 mb-2">
                                                            <input type="text" name="total_harga" id="total_harga" class="form-control" value="Rp. {{ number_format($pengajuan_biaya_detail_total) }}" style="text-align:right; font-style:bold;" required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <div class="input-group mb-3">
                                                                
                                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                                    <tbody>
                                                                        <?php $no=1 ?>
                                                                        @forelse ($pengajuan_biaya_upload as $row)
                                                                        <tr>
                                                                            <td><i>Attachment_{{ $no }}</i></td>
                                                                            <td>
                                                                                <a href="{{url('images/'. $row->filename)}}">
                                                                                    {{ $row->filename}}
                                                                                </a>
                                                                                <input type="text" class="form-control" name="filename_text[]" id="filename_text{{ $no }}" value="{{ $row->filename}}" hidden>
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="file" class="form-control" name="filename[]" id="filename{{ $no }}">  
                                                                                    {{-- <span class="input-group-btn">
                                                                                        <button type="button" class="btn btn-info btn-danger" id="button_hapus_lampiran" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                                                                    </span> --}}
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $no++ ?>
                                                                        @empty
                                                                           
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                
                                                            </div>
                                                        </div>
                                                    </div>
													
													{{-- tambah lampiran --}}
                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <strong>Tambah Lampiran/Attachment</strong>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control mr-1 col-2" name="filename_tambah[]" id="file_input" multiple>
                                                                <div type="file" id="fileList" class="form-control col-10 d-flex "></div>
                                                                {{-- <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-info btn-danger" id="button_hapus_lampiran" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                                                </span> --}}
                                                            </div>
                                                        </div>                                       
                                                    </div>
                                                    <br>
                   
                                                    <div class="row">     
                                                        <div class="col-md-12 mb-2" align="right">
                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">S i m p a n</button>
                                                            <button class="btn btn-primary btn-sm" onclick="goBack()">K e m b a l i</button>
                                                        </div>
                                                    </div>
                                            </div>        
                                            
                                            <div class="tab-pane" id="detail" role="tabpanel">
                                                <br>
                                                <div class="table-responsive">
                                                <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                        <thead>
                                                            <tr style="background-color: blue;">
                                                                <th >No</th>
                                                                <th hidden>Id</th>
                                                                <th >Perusahaan</th>
                                                                <th >Depo</th>
                                                                <th >Cluster</th>
                                                                <th >Id Toko</th>
                                                                <th >Nama Toko</th>
                                                                <th >No Rek</th>
                                                                <th >Bank</th>
                                                                <th >Nama Rekening</th>
                                                                <th >Reward Distributor</th>
                                                                <th >Reward TIV</th>
                                                                <th >Potongan</th>
                                                                <th >Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabledata_outlet">
                                                            
                                                        </tbody>
                                                        <tfoot id="table_footer">

                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
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

<div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="modalView" aria-hidden="true" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right" hidden>
                        <input type="text" name="cari_list" id="cari_list" class="form-control" value="">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_list" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th >No</th>
                                <th hidden>Id</th>
                                <th >Perusahaan</th>
                                <th >Depo</th>
                                <th >Cluster</th>
                                <th >Id Toko</th>
                                <th >Nama Toko</th>
                                <th >No Rek</th>
                                <th >Bank</th>
                                <th >Nama Rekening</th>
                                <th >Qty</th>
                                <th >Reward TIV</th>
                                <th >Potongan</th>
                                <th >Total</th>
                            </tr>
                        </thead>
                        <tbody id="tabledata_list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
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

<div class="modal fade bd-example-modal-lg" id="myModalProgram" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">No Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_program" id="search_program" class="form-control" placeholder="Cari No Program . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_program" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th hidden>Id</th>
								<th>Tanggal</th>
                                <th>No Surat</th>
                                <th>Jenis Surat</th>
								<th>Perusahaan</th>
                                <th>Id Program</th>
                                <th>Nama Program</th>
                                <th hidden>No Urut</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalCoa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" hidden>
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa" id="search_coa" class="form-control" placeholder="Search Data . . .">
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Claim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Area</th>
                            <th>Nama Toko</th>
                            <th>No Rekening</th>
                            <th>Bank</th>
                            <th>Pemilik</th>
                            <th>Qty</th>
                            <th>Reward</th>
                            <th>Total</th>
                            <th>Potongan</th>
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

@endsection




