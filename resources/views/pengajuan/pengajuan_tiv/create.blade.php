@section('js')

<script type="text/javascript">
     var tot =0;

     var x = 1;
    $(document).on('click', '.pilih_tanggungan', function (e) {
                //document.getElementById('kode_produk').value = $(this).attr('data-kode_produk');
                
                var tabel = document.getElementById("datatabel-v1");
                var row = tabel.insertRow(1);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                var cell8 = row.insertCell(7);
                var cell9 = row.insertCell(8);
                var cell10 = row.insertCell(9);
                var cell11 = row.insertCell(10);

                var a = $(this).attr('data-id');
                var b = $(this).attr('data-area');
                var c = $(this).attr('data-nama_toko');
                var d = $(this).attr('data-no_rekening');
                var e = $(this).attr('data-bank');
                var f = $(this).attr('data-pemilik_rekening');
                var g = $(this).attr('data-qty');
                var h = $(this).attr('data-reward_tiv');
                var i = $(this).attr('data-total_reward');
                var j = $(this).attr('data-potongan');

               
                cell1.innerHTML = '<input name="chk" type="checkbox" />';
                cell2.innerHTML = '<input type="text" class="form-control" name="id[]" id="id_'+x+'" style="font-size: 13px;" value="'+a+'" hidden>'+a+''; 
                cell3.innerHTML = '<input type="text" class="form-control" name="area[]" id="area_'+x+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
                cell4.innerHTML = '<input type="text" class="form-control" name="nama_toko[]" id="nama_toko_'+x+'" style="font-size: 13px;" value="'+c+'" hidden>'+c+''; 
                cell5.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="no_rekening[]" id="no_rekening_'+x+'" style="font-size: 13px;" value="'+d+'" hidden>'+d+''; 
                cell6.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="bank[]" id="bank_'+x+'" style="font-size: 13px;" value="'+e+'" hidden>'+e+'';
                cell7.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="pemilik_rek[]" id="pemilik_rek_'+x+'" style="font-size: 13px;" value="'+f+'" hidden>'+f+'';
                cell8.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="qty[]" id="qty_'+x+'" style="font-size: 13px;" value="'+g+'" hidden>'+g+'';
                cell9.innerHTML = '<input type="text" class="uploads form-control" name="reward[]" id="reward_'+x+'" style="font-size: 6px;" value="'+h+'" hidden>'+h+'';
                cell10.innerHTML = '<input type="text" class="uploads form-control" name="total[]" id="total_'+x+'" style="font-size: 6px;" value="'+i+'" hidden>'+i+'';
                cell11.innerHTML = '<input type="text" class="uploads form-control" name="potongan[]" id="potongan_'+x+'" style="font-size: 6px;" value="'+j+'" hidden>'+j+'';

                $('#myModal').modal('hide');
                x++;

                tot = tot + ($(this).attr('data-total_reward') - $(this).attr('data-potongan'))
                document.getElementById('total_biaya').value = tot
    });

    $(document).on('click', '.pilih_category', function(e){
        document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
        document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
        document.getElementById('sifat').value = $(this).attr('data-sifat')
        document.getElementById('jenis').value = $(this).attr('data-jenis')
        document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')
        
        document.getElementById('kode_coa').value = $(this).attr('data-kode_coa')
        document.getElementById('coa').value = $(this).attr('data-nama_coa')
        document.getElementById('debit').value = $(this).attr('data-debit')
        document.getElementById('kredit').value = $(this).attr('data-kredit')

        $('#myModalKategori').modal('hide');
    });

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
    });

    $(document).on('click', '.pilih_coa', function(e) {
        document.getElementById('kode_coa').value = $(this).attr('data-kode_coa')
        document.getElementById('coa').value = $(this).attr('data-coa')
        document.getElementById('debit').value = $(this).attr('data-debit')
        document.getElementById('kredit').value = $(this).attr('data-kredit')

        $('#myModalCoa').modal('hide');
    });

    function hapusbaris(tabel){
        var tabel = document.getElementById("datatabel-v1");
        var bacabaris = tabel.rows.length;
        for(var i=0;i<bacabaris;i++){
            //baca baris yang ke i
            var bacabarisyangke = tabel.rows[i];
            //baca ceklist di childnode cell ke 0
            var bacaceklist = bacabarisyangke.cells[0].childNodes[0];
            //jika ada ceklist
            if(null != bacaceklist && true == bacaceklist.checked){
                tabel.deleteRow(i);
                bacabaris--;
                i--;

                    //tot = tot - $('#total_'+y+'').val();
                    //document.getElementById("total_harga").value = (tot);
                    //var total =  document.getElementById("total_head").value;
                    //ttotal = ttotal - $('#total').val()
                    //document.getElementById('total_head').value = ttotal;
            }
        }
        return false;
    }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("pengajuan_tiv.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    $(document).ready(function(){
        fetch_data_category();
        function fetch_data_category(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan_tiv/action_category.actionCategory") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_category tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_category', function(){
            var query = $(this).val();
            fetch_data_category(query);
        });
    });

    $(document).ready(function(){
        var isFetchingData = false;
        $('#kode_perusahaan_tujuan').change(function(){
        // Tambahkan kondisi untuk memeriksa apakah sedang mengambil data sebelum memanggil fungsi fetch_data_program()
            if (!isFetchingData) {
                fetch_data_program();
            }
        });
       
        function fetch_data_program(query = '')
        {
            isFetchingData = true;
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
                    isFetchingData = false;
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    isFetchingData = false;
                }
            });
        }

        $(document).on('keyup', '#search_program', function(){
            var query = $(this).val();
            fetch_data_program(query);
        });
    });

    $(document).ready(function(){
        fetch_data_coa();
        function fetch_data_coa(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan_biaya/action_coa.actionCoa") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_coa tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_coa', function(){
            var query = $(this).val();
            fetch_data_coa(query);
        });
    });

    $(document).ready(function(){
        fetch_tanggungan_data();
        function fetch_tanggungan_data(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan_tiv/action_tanggungan.actionTanggungan") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_tanggungan_data(query);
        });
    });

    $("#caridatas").click(function() {
        // kode_perusahaan_tujuan
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
					tabledata += `<td hidden><input type="hidden" class="form-control" name="tgl_import[]" id="tgl_import" value="${program.tgl_import}">${program.tgl_import}</td>`;
                    tabledata += `<td><input type="hidden" class="form-control" name="id_program[]" id="id_program" value="${program.id_program}">${program.id_program}</td>`;
                    tabledata += `<td><input type="hidden" class="form-control" name="perusahaan[]" id="perusahaan" value="${program.perusahaan}">${program.perusahaan}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="jml_toko[]" id="jml_toko" value="${program.jml_toko}">${program.jml_toko}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_reward[]" id="total_reward" value="${program.total_reward}">Rp. ${total_rupiah_reward}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_reward_tiv[]" id="total_reward_tiv" value="${program.total_reward_tiv}">Rp. ${total_rupiah_reward_tiv}</td>`;
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="total_potongan[]" id="total_potongan" value="${program.total_potongan}">Rp. ${total_rupiah_potongan}</td>`; //total
                    tabledata += `<td align="right"><input type="hidden" class="form-control" name="hasil_total[]" id="hasil_total" value="${hasil_total}">Rp. ${hasil_total_rupiah}</td>`;
                    tabledata += `<td align="center"><button type="button" data-id="${program.id_program}" data-perusahaan="${program.perusahaan}" data-tgl_import="${program.tgl_import}" id="button_view_data" class="btn btn-success btn-sm">View</button>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
                eventHandlerButtonCariDatalAll();
            }
        });

        //==== data Upload =====//
        $.ajax({
            type: "GET",
            url: "{{ route('pengajuan_tiv/cari_data_upload.cari_data_upload') }}",
            data: {
                id_program: id_program,
                id_perusahaan: id_perusahaan,
				tgl_import: tgl_import,
				no_urut_upload: no_urut_upload
            },
            dataType: "json",
            success: function(response) {
                let tabledata_upload;
                let no = 0;
                response.data.forEach(item => {
                    no = no + 1
                    tabledata_upload += `<tr>`;
                        tabledata_upload += `<td><i><b>Attachment_` +no+ `</b></i></td>`; 
                        tabledata_upload += `<td><a href="/images/${item.filename}" target="_blank">${item.filename}</a></td>`;
                    tabledata_upload += `</tr>`;
                });
                $("#tabledata_upload").html(tabledata_upload);
            }
        });


    });

    $("#button_cari_data_all").click(eventHandlerButtonCariDatalAll);

    function eventHandlerButtonCariDatalAll() {
        // kode_perusahaan_tujuan
        let id_perusahaan = $("#kode_perusahaan_tujuan").val();
        let id_program = $("#id_program").val();
		let tgl_import = $("#tgl_import").val();

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
            url: "{{ route('pengajuan_tiv/cari_data_all.cari_data_all') }}",
            data: {
                id_program: id_program,
                id_perusahaan: id_perusahaan,
				tgl_import: tgl_import
            },
            dataType: "json",
            success: function(response) {
                let tabledata_toko;
                let no = 0;
                response.data.forEach(program => {
                    // let total_reward = program.total_reward;
                    // //membuat format rupiah Harga//
                    // var reverse_total_reward = total_reward.toString().split('').reverse().join(''),
                    // ribuan_total_reward  = reverse_total_reward.match(/\d{1,3}/g);
                    // total_rupiah_reward = ribuan_total_reward.join(',').split('').reverse().join('');
                    // //End membuat format rupiah//

                    // let total_potongan = program.total_potongan;
                    // //membuat format rupiah Harga//
                    // var reverse_total_potongan = total_potongan.toString().split('').reverse().join(''),
                    // ribuan_total_potongan  = reverse_total_potongan.match(/\d{1,3}/g);
                    // total_rupiah_potongan = ribuan_total_potongan.join(',').split('').reverse().join('');
                    // //End membuat format rupiah//

                    // let hasil_total = program.total_reward - program.total_potongan;
                    // //membuat format rupiah Harga//
                    // var reverse_hasil_total = hasil_total.toString().split('').reverse().join(''),
                    // ribuan_hasil_total  = reverse_hasil_total.match(/\d{1,3}/g);
                    // hasil_total_rupiah = ribuan_hasil_total.join(',').split('').reverse().join('');
                    // //End membuat format rupiah//

                    no = no + 1
                    tabledata_toko += `<tr>`;
                    tabledata_toko += `<td>` +no+ `</td>`;
                    tabledata_toko += `<td>${program.id_program}</td>`;
                    tabledata_toko += `<td>${program.perusahaan}</td>`;
                    tabledata_toko += `<td>${program.dist_depo}</td>`;
                    tabledata_toko += `<td>${program.cluster}</td>`;
                    tabledata_toko += `<td>${program.customer_id}</td>`;
                    tabledata_toko += `<td>${program.cuastomer_name}</td>`;
                    tabledata_toko += `<td>${program.no_rek}</td>`;
                    tabledata_toko += `<td>${program.bank}</td>`;
                    tabledata_toko += `<td>${program.nama_rekening}</td>`;
                    tabledata_toko += `<td>${program.ach}</td>`;
                    tabledata_toko += `<td>${program.reward}</td>`;
                    tabledata_toko += `<td>${program.reward_tiv}</td>`;
                    tabledata_toko += `<td>${program.potongan}</td>`;
                    tabledata_toko += `<td>${program.ditransfer}</td>`;
                    tabledata_toko += `</tr>`;
                });
                $("#tabledata_toko").html(tabledata_toko);
            }
        });
    }

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
                    tabledata_list += `<tr>`;
                    tabledata_list += `<td>` +no+ `</td>`;
                    tabledata_list += `<td hidden>${program.id_program}</td>`;
                    tabledata_list += `<td>${program.perusahaan}</td>`;
                    tabledata_list += `<td>${program.dist_depo}</td>`;
                    tabledata_list += `<td>${program.cluster}</td>`;
                    tabledata_list += `<td>${program.customer_id}</td>`;
                    tabledata_list += `<td>${program.customer_name}</td>`;
                    tabledata_list += `<td>${program.no_rek}</td>`;
                    tabledata_list += `<td>${program.bank}</td>`;
                    tabledata_list += `<td>${program.nama_rekening}</td>`;
                    // tabledata_list += `<td></td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_reward}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_reward_tiv}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_potongan}</td>`;
                    tabledata_list += `<td alignt='right'>${ditransfer_rupiah}</td>`;
                    tabledata_list += `</tr>`;
                });
                $("#tabledata_list").html(tabledata_list);
            }
        });
        $('#modalView').modal('show');
    });

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
    <title>Pengajuan (Program)</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item active">Pengajuan (Program)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan_tiv.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pengajuan TIV</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" class="form-control" value="{{Auth::user()->kode_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="kode_depo" class="form-control" value="{{Auth::user()->kode_depo}}" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <div class="input-group">
                                            <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" value="" required >
                                            <input id="nama_pengeluaran" type="text" class="form-control" readonly required>
                                            <input id="sifat" type="hidden" name="sifat" class="form-control"  required>
                                            <input id="jenis" type="hidden" name="jenis" class="form-control"  required>
                                            <input id="pembayaran" type="hidden" name="pembayaran" class="form-control"  required>
                                            <input id="kategori" type="hidden" name="kategori" class="form-control"  required>
                                            <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran" class="form-control"  required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Untuk Perusahaan
                                        <select name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" required>
                                            <option value="">select</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                    </div>

                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6 mb-2" hidden>
                                        C O A
                                        <div class="input-group">
                                            <input id="coa" type="text" class="form-control" readonly >
                                            <input id="kode_coa" type="hidden" name="kode_coa" value=""  readonly>
                                            <input id="debit" type="hidden" name="debit" value="" readonly>
                                            <input id="kredit" type="hidden" name="kredit" value="" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalCoa"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        No Surat 
                                        <div class="input-group">
                                            <input id="no_surat" id="no_surat" type="text" class="form-control" readonly required>
                                            <input id="no_surat_program" type="hidden" name="no_surat_program" value="" required>
                                            <input id="id_program_simpan" type="hidden" name="id_program_simpan" value="" required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalProgram"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Id Program
                                        <input type="text" name="id_program" id="id_program" class="form-control" value="" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Program
                                        <input type="text" name="nama_program" id="nama_program" class="form-control" value="" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Kategori Program
                                        <input type="text" name="kategori_program" id="kategori_program" class="form-control" value="" required readonly>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2" hidden>
                                        Jenis Surat
                                        <input type="text" name="jenis_surat" id="jenis_surat" class="form-control" value="" required>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden>
                                        tgl_import
                                        <input type="text" name="tgl_import" id="tgl_import" class="form-control" value="" required>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden>
                                        no_urut_upload
                                        <input type="text" name="no_urut_upload" id="no_urut_upload" class="form-control" value="" required>
                                    </div>
                                </div>
                                
                                <div class="row">
									<div class="col-md-5 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" class="form-control" value="" required>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Division
                                        <input type="text" name="kode_divisi" class="form-control" value="{{Auth::user()->kode_divisi}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        tipe
                                        <input type="text" name="tipe" class="form-control" value="" required readonly>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>



                    <form id="savedatas">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                            <thead>
                                                <tr>
                                                    {{-- <th width="20">#</th>
                                                    <th width="20">Id</th>
                                                    <th width="80">Area</th>
                                                    <th width="150">Nama Toko</th>
                                                    <th width="80">No Rekening</th>
                                                    <th width="80">Bank</th>
                                                    <th width="150">Pemilik Rekening</th>
                                                    <th width="100">Qty</th>
                                                    <th width="100">Reward TIV</th>
                                                    <th width="100">Total Reward</th>
                                                    <th width="100">Potongan</th> --}}

                                                    <th hidden>#</th>
                                                    <th>Id Program</th>
                                                    <th>Perusahaan</th>
                                                    <th>Jml Toko</th>
                                                    <th>Total Reward Distributor</th>
                                                    <th>Total Reward TIV</th>
                                                    <th>Total Potongan</th>
                                                    <th>Total</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata">
                                                            
                                            </tbody>
                                        </table>
                                    <!--</div>-->
                                    </div>

                                    <div class="table-responsive" hidden>
                                        <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                        <table id="datatabel-v2" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                            <thead>
                                                <tr>
                                                    <th width="20">No</th>
                                                    <th width="20">Id</th>
                                                    <th width="20">Perusahaan</th>
                                                    <th width="80">Depo</th>
                                                    <th width="150">Cluster</th>
                                                    <th width="80">Id Toko</th>
                                                    <th width="80">Nama Toko</th>
                                                    <th width="150">No Rek</th>
                                                    <th width="150">Bank</th>
                                                    <th width="150">Nama Rekening</th>
                                                    <th width="100">Qty</th>
                                                    <th width="100">Reward TIV</th>
                                                    <th width="100">Potongan</th>
                                                    <th width="100">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata_toko">
                                                                
                                            </tbody>
                                        </table>
                                        <!--</div>-->
                                    </div>

                                    <!-- ##########################################################  -->
                                    <br>
                                    <div class="row"> 
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group mb-3">
                                                
                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                    <tbody id="tabledata_upload">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ########################################################## -->

                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <strong>Lampiran/Attachment</strong>
                                            <div class="input-group">
                                                <input type="file" class="form-control mr-1 col-2" name="filename[]" id="file_input" multiple>
                                                <div type="file" id="fileList" class="form-control col-10 d-flex "></div>
                                            </div>
                                            {{-- <input type="file" class="form-control mr-1 col-2" name="filename_tambah[]" id="file_input" multiple>
                                            <div type="file" id="fileList" class="form-control col-10 d-flex "></div> --}}
                                        </div>                                       
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            {{-- <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Cari Data</button> --}}
                                            <button type="button" id="caridatas" name="caridatas" class="btn btn-primary btn-sm">Cari Data</button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('datatabel-v1')" hidden>Hapus Data</button>
                                            <button type="button" class="btn btn-secondary" name="button_cari_data_all" id="button_cari_data_all" hidden>Cari All</button>
                                        </div>  
                                                  
                                        <div class="col-md-8 mb-2">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Simpan</button>
                                        </div>

                                        <input type="text" name="total_biaya" id="total_biaya" class="form-control" value="0" required readonly hidden> 
                                    </div>
                                                
                                </div>
                            </div>
                        </div>
                    </form>
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
                                <th >Reward Distributor</th>
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




