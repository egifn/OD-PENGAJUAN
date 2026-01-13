@section('js')
<script type="text/javascript">
    $(document).on('click', '.pilih', function (e) {
        document.getElementById("kontrabon").value = $(this).attr('data-kontrabon');
        document.getElementById("supplier").value = $(this).attr('data-vendor');
        document.getElementById("status_pajak").value = $(this).attr('data-pajak');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("jt").value = $(this).attr('data-jt');
        document.getElementById("ket").value = $(this).attr('data-keterangan');
        document.getElementById("jenis_pembayaran").value = $(this).attr('data-pembayaran');
        document.getElementById("request_by").value = $(this).attr('data-user');
        document.getElementById("kode_supplier").value = $(this).attr('data-kdVendor');
        $('#myModal').modal('hide');
    });
    $(function () {
        $("#lookup").dataTable();
    });

    $(document).on('click', '.pilih_sparepart', function (e) { //jika menggunakan import rcm
        document.getElementById("spp_sparepart").value = $(this).attr('data-code');
        document.getElementById("kontra_sparepart").value = $(this).attr('data-kontra');
        document.getElementById("kode_supplier").value = $(this).attr('data-supplier_code');
        document.getElementById("supplier").value = $(this).attr('data-supplier');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("jt").value = $(this).attr('data-jt');
        document.getElementById("request_by").value = $(this).attr('data-user');
        $('#myModal_sparepart').modal('hide');
    });
    $(function () {
        $("#lookup_sparepart").dataTable();
    });

    $(document).on('click', '.pilih_kontra_sparepart', function (e) {
        //document.getElementById("spp_sparepart").value = $(this).attr('data-code');
        document.getElementById("kontra_sparepart").value = $(this).attr('data-kontrabon');
        document.getElementById("kode_supplier").value = $(this).attr('data-kodevendor');
        document.getElementById("supplier").value = $(this).attr('data-vendor');
        document.getElementById("status_pajak").value = $(this).attr('data-pajak');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("jt").value = $(this).attr('data-jt');
        document.getElementById("ket").value = $(this).attr('data-keterangan');
        document.getElementById("request_by").value = $(this).attr('data-user');
        $('#myModal_kontra_sparepart').modal('hide');
    });
    $(function () {
        $("#lookup_kontra_sparepart").dataTable();
    });

    $(document).on('click', '.pilih_request', function (e) {
        document.getElementById("request").value = $(this).attr('data-pengajuan');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("ket").value = $(this).attr('data-keterangan');
        document.getElementById("jenis_pembayaran").value = $(this).attr('data-pembayaran');
        document.getElementById("request_by").value = $(this).attr('data-user');
        $('#myModal_request').modal('hide');
    });
    $(function () {
        $("#lookup_request").dataTable();
    });

    $(document).on('click', '.pilih_payment', function(e) {
        document.getElementById("payment").value = $(this).attr('data-norek');
        document.getElementById("bank").value = $(this).attr('data-bank');
        document.getElementById("kode_perusahaan").value = $(this).attr('data-kodeperusahaan');
        $('#myModal_payment').modal('hide');
    });
    $(function () {
        $('#lookup_payment').dataTable();
    });

    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById("kode_supplier").value = $(this).attr('data-kvendor');
        document.getElementById("supplier").value = $(this).attr('data-nvendor');
        document.getElementById("nama_bank").value = $(this).attr('data-bank');
        document.getElementById("norek").value = $(this).attr('data-norek');
        document.getElementById("atas_nama").value = $(this).attr('data-atas_nama');
        //document.getElementById("supplier").value = $(this).attr('data-nvendor').concat(' / ',$(this).attr('data-status'));
        $('#myModal_vendor').modal('hide');
    });
    $(function () {
        $('#lookup_vendor').dataTable();
    });

    $(document).ready(function(){
        if ($("input[name='bayar']:checked").val() == "kredit" ) {
            $("#form-input-request").hide();
            $("#form-input-sparepart").hide();
            $("#form-input-manual").hide();
        }else{
            $("#form-input-request").show();
        }
        var disabled = false;
        $(".detail").click(function(){ 
            if ($("input[name='bayar']:checked").val() == "kredit" ) { 
                $("#form-input").slideDown("fast"); 
                $("#form-input-request").slideUp("fast");
                $('#form-input-sparepart').slideUp("fast");
                $("#form-input-manual").slideUp("fast");
                $("#supplier").prop('readonly', true);
                $("#total").prop('readonly', false);
                $("#form-terhitung").slideDown("fast");
                $("#terhitung").prop('readonly', false);
                $("#jt").prop('readonly', false);
                $("#pajak_masukan").prop('readonly', false);
                $("#ket").prop('readonly', false); 
                $("#request_by").prop('readonly', false); 

                document.getElementById("kontrabon").value = "-";
                document.getElementById("no_order").value = "-";
                document.getElementById("spp_sparepart").value = "-";
                document.getElementById("kontra_sparepart").value = "-";
                document.getElementById("request").value = "-";
                document.getElementById("kode_dokumen").value = "-";
                document.getElementById("kode_supplier").value = "";
                document.getElementById("supplier").value = "";
                document.getElementById("status_pajak").value = "";
                document.getElementById("total").value = "";
                document.getElementById("terhitung").value = "";
                document.getElementById("jt").value = "";
                document.getElementById("pajak_masukan").value = "0"; 
                document.getElementById("ket").value = ""; 
                document.getElementById("payment").value = "";
                document.getElementById("request_by").value = "";
                document.getElementById("bank").value = "";
                document.getElementById("kode_perusahaan").value = "";  
            } else if ($("input[name='bayar']:checked").val() == "sparepart" ) {
                $("#form-input").slideUp("fast"); 
                $("#form-input-request").slideUp("fast");
                $("#form-input-manual").slideUp("fast");
                $('#form-input-sparepart').slideDown("fast");
                $("#supplier").prop('readonly', true);
                $("#total").prop('readonly', true);
                $("#form-terhitung").slideDown("fast");
                $("#terhitung").prop('readonly', true);
                $("#jt").prop('readonly', true);
                $("#pajak_masukan").prop('readonly', false);
                $("#ket").prop('readonly', false); 
                $("#request_by").prop('readonly', true); 

                document.getElementById("kontrabon").value = "-";
                document.getElementById("no_order").value = "-";
                document.getElementById("spp_sparepart").value = "-";
                document.getElementById("kontra_sparepart").value = "-";
                document.getElementById("request").value = "-";
                document.getElementById("kode_dokumen").value = "-";
                document.getElementById("kode_supplier").value = "";
                document.getElementById("supplier").value = "";
                document.getElementById("status_pajak").value = "";
                document.getElementById("total").value = "";
                document.getElementById("terhitung").value = "";
                document.getElementById("jt").value = "";
                document.getElementById("pajak_masukan").value = "0"; 
                document.getElementById("ket").value = ""; 
                document.getElementById("payment").value = "";
                document.getElementById("request_by").value = "";
                document.getElementById("bank").value = "";
                document.getElementById("kode_perusahaan").value = ""; 
            } else if ($("input[name='bayar']:checked").val() == "tunai" ) {
                $("#form-input").slideUp("fast"); 
                $('#form-input-sparepart').slideUp("fast");
                $("#form-input-manual").slideUp("fast");
                $("#form-input-request").slideDown("fast");
                $("#supplier").prop('readonly', true);
                $("#total").prop('readonly', true);
                $("#form-terhitung").slideDown("fast");
                $("#terhitung").prop('readonly', true);
                $("#jt").prop('readonly', false);
                $("#pajak_masukan").prop('readonly', false);
                $("#ket").prop('readonly', true);  

                document.getElementById("kontrabon").value = "-";
                document.getElementById("no_order").value = "-";
                document.getElementById("spp_sparepart").value = "-";
                document.getElementById("kontra_sparepart").value = "-";
                document.getElementById("request").value = "-";
                document.getElementById("kode_dokumen").value = "-";
                document.getElementById("kode_supplier").value = "";
                document.getElementById("supplier").value = "";
                document.getElementById("status_pajak").value = "";
                document.getElementById("total").value = "";
                document.getElementById("terhitung").value = "";
                document.getElementById("jt").value = ""; 
                document.getElementById("pajak_masukan").value = "0";
                document.getElementById("ket").value = ""; 
                document.getElementById("payment").value = "";
                document.getElementById("request_by").value = "";
                document.getElementById("bank").value = "";
                document.getElementById("kode_perusahaan").value = "";   
            } else if ($("input[name='bayar']:checked").val() == "manual" ) {
                $("#form-input").slideUp("fast"); 
                $('#form-input-sparepart').slideUp("fast");
                $("#form-input-request").slideUp("fast");
                $("#form-input-manual").slideDown("fast");
                $("#supplier").prop('readonly', true);
                $("#total").prop('readonly', false);
                $("#form-terhitung").slideDown("fast");
                $("#terhitung").prop('readonly', false);
                $("#jt").prop('readonly', false);
                $("#pajak_masukan").prop('readonly', false);
                $("#ket").prop('readonly', false);  

                document.getElementById("kontrabon").value = "-";
                document.getElementById("no_order").value = "-";
                document.getElementById("spp_sparepart").value = "-";
                document.getElementById("kontra_sparepart").value = "-";
                document.getElementById("request").value = "-";
                document.getElementById("kode_dokumen").value = "-";
                document.getElementById("kode_supplier").value = "";
                document.getElementById("supplier").value = "";
                document.getElementById("status_pajak").value = "";
                document.getElementById("total").value = "";
                document.getElementById("terhitung").value = "";
                document.getElementById("jt").value = ""; 
                document.getElementById("pajak_masukan").value = "0";
                document.getElementById("ket").value = ""; 
                document.getElementById("payment").value = "";
                document.getElementById("request_by").value = "";
                document.getElementById("bank").value = "";
                document.getElementById("kode_perusahaan").value = "";
            }
        });
    });

    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_vendor.actionVendor") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_vendor tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_vendor', function(){
            var query = $(this).val();
            fetch_vendor_data(query);
        });
    });

    $(document).ready(function(){
        fetch_payment_data();
        function fetch_payment_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_payment.actionPayment") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_payment tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_payment', function(){
            var query = $(this).val();
            fetch_payment_data(query);
        });
    });

    $(document).ready(function(){
        fetch_kontra_data();
        function fetch_kontra_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_kontra.actionKontra") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_kontra', function(){
            var query = $(this).val();
            fetch_kontra_data(query);
        });
    });

    $(document).ready(function(){
        fetch_request_data();
        function fetch_request_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_request.actionRequest") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_request tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_request', function(){
            var query = $(this).val();
            fetch_request_data(query);
        });
    });

    

    $(document).ready(function(){ //jika menggunakan import rcm
        fetch_sparepart_data();
        function fetch_sparepart_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_sparepart.actionSparepart") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_sparepart tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_sparepart', function(){
            var query = $(this).val();
            fetch_sparepart_data(query);
        });
    });

    $(document).ready(function(){
        fetch_kontra_sparepart_data();
        function fetch_kontra_sparepart_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_sparepart_kontra.actionSparepartKontra") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_kontra_sparepart tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_Kontra_sparepart', function(){
            var query = $(this).val();
            fetch_kontra_sparepart_data(query);
        });
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
                            'Lampiran/Attachment pendukung. Lampiran/Attachment wajib diisi...'
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
	<title>Buat SPP</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item active">Buat SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Buat SPP</h4>
                        </div>
                        <div class="card-body">

                        	<form action="{{ route('spp.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                        		@csrf
                        		<div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    
                                    <div class="col-md-6 mb-2">
                                        Perusahaan
                                        <select name="kode_perusahaan_spp" id="kode_perusahaan_spp" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Sumber Dana
                                        <select name="kode_sumber" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($dana as $row)
                                                <option value="{{ $row->sumber_dana }}" {{ old('sumber_dana') == $row->sumber_dana ? 'selected':'' }}>{{ $row->sumber_dana }}  -  {{ $row->keterangan }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Source of funds
                                        <select name="kode_sumber_1" class="form-control">
                                            <option value="">Select</option>
                                            <option value="TA 1">TA 1</option>
                                            <option value="TA 2">TA 2</option>
                                            <option value="TU 1">TU 1</option>
                                            <option value="TU 2">TU 2</option>
                                            <option value="TUA 1">TUA 1</option>
                                            <option value="TUA 2">TUA 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Tgl SPP
                                        <input type="text" name="tgl_spp" id="tgl_spp" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        SPP
                                        <input type="text" name="no_spp" id="no_spp" class="form-control" value="" readonly>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-2 mb-2">
                                       <input name="bayar" type="radio" id="kredit" value="kredit" class="detail" checked="true"  />
                                       Barang Operasional
                                    </div>
                                    <div class="col-md-2 mb-2">
                                       <input name="bayar" type="radio" id="sparepart" value="sparepart" class="detail"  />
                                       Sparepart
                                    </div>
                                    <div class="col-md-1 mb-2">
                                       <input name="bayar" type="radio" id="tunai" value="tunai" class="detail"  />
                                       Biaya/Jasa
                                    </div>
                                    <div class="col-md-1 mb-2">
                                       <input name="bayar" type="radio" id="manual" value="manual" class="detail"  />
                                       Manual
                                    </div>
                                    
                                      
                                </div>
                                
                                <div id="form-input">
                                    <div id="form-input" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Kontrabon
                                            <div class="input-group">
                                                <input id="kontrabon" name="kontrabon" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            PO
                                            <input type="text" name="no_order" id="no_order" class="form-control" value="-" required readonly>
                                        </div> 
                                    </div>   
                                </div>

                                <div id="form-input-sparepart">
                                    <div id="form-input-sparepart" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        <div class="col-md-6 mb-2" > <!-- jika versi import dari RCM -->
                                            SPP
                                            <div class="input-group">
                                                <input id="spp_sparepart" name="spp_sparepart" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_sparepart"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            Kontrabon
                                            <div class="input-group">
                                                <input id="kontra_sparepart" name="kontra_sparepart" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_kontra_sparepart"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div> 
                                    </div>   
                                </div>

                                <div id="form-input-request">
                                    <div id="form-input-request" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Kode permintaan
                                            <div class="input-group">
                                                <input id="request" name="request" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_request"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        
                                    </div>   
                                </div>

                                <div id="form-input-manual">
                                    <div id="form-input-manual" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            Kode Dokumen
                                            <input type="text" name="kode_dokumen" id="kode_dokumen" class="form-control" value="" required>
                                        </div>
                            
                                    </div>
                                    
                                    <div id="form-input-manual" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        
                                        <div class="col-md-6 mb-2">
                                            Lampiran/Attachment                                           
                                            <div class="d-flex">
                                                <input type="file" class="form-control mr-1" name="filename[]" id="filename_1" multiple>
                                                <div type="file" id="fileList" class="form-control col-8 d-flex "></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" hidden>
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Jenis Pembayaran
                                        <input type="text" name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" >
                                    </div>
                                    
                                </div>    
                            
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Ditujukan Kepada
                                        <input type="text" name="tujuan" id="tujuan" class="form-control" value="Nany Enggawati" required>
                                    </div>
                                    
                                </div>

                                <!-- <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Metode Pembayaran
                                        <select name="metode_pembayaran" class="form-control">
                                            <option value="-">Select</option>
                                            <option value="Tunai">Tunai</option>
                                            <option value="Transfer">Transfer</option>
                                            <option value="Cek">Cek</option>
                                        </select>
                                </div> -->
                                    
                                </div>

                                
                                <div class="row">
                                    <div class="col-md-3 mb-2" hidden>
                                        kode vendor
                                        <input id="kode_supplier" name="kode_supplier" type="text" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Vendor/Supplier
                                        <!--
                                        <input type="text" name="supplier" id="supplier" class="form-control" required readonly>
                                        -->
                                        <div class="input-group">
                                            <input id="supplier" name="supplier" type="text" class="form-control" value="-" readonly required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_vendor"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3 mb-2">
                                        <input id="kode_bank" name="kode_bank" type="text" class="form-control" value="" readonly required>
                                    </div> --}}
                                    <div class="col-md-3 mb-2" hidden>
                                        <input id="status_pajak" name="status_pajak" type="text" class="form-control" value="" readonly required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Bank
                                        <input id="nama_bank" name="nama_bank" type="text" class="form-control" value="" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Norek
                                        <input id="norek" name="norek" type="text" class="form-control" value="" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Atas Nama
                                        <input id="atas_nama" name="atas_nama" type="text" class="form-control" value="" readonly required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                	<div class="col-md-6 mb-2">
                                        Jumlah
                                        <input type="text" name="total" id="total" class="form-control" style="text-align: right;" required >
                                    </div>
                                </div>

                                <div id="form-terhitung" class="row" hidden>
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                	<div class="col-md-6 mb-2">
                                        Terhitung
                                        <textarea id="terhitung" name="terhitung" id="terhitung" class="form-control" rows="3" cols="50" >

										</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Tgl Jatuh Tempo
                                        <input type="date" name="jt" id="jt" class="form-control" required >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Faktur Pajak Masukan
                                        <input type="text" name="pajak_masukan" id="pajak_masukan" value="0" class="form-control" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Keperluan
                                        <textarea id="ket" name="ket" class="form-control" rows="3" cols="50" required > 
                                        	
										</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Pembayaran
                                        <div class="input-group">
                                            <input id="payment" name="payment" type="text" class="form-control" value="-" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_payment"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-5 mb-2">
                                        Pengajuan oleh
                                        <input type="text" name="request_by" id="request_by" class="form-control"  >
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        <br>
                                        <button class="btn btn-primary btn-sm">Buat SPP</button>
                                    </div> 

                                    <div class="col-md-2 mb-2" hidden>
                                        bank
                                        <input type="text" name="bank" id="bank" class="form-control">
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        kode perusahaan
                                        <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                    </div>
                                </div>

                        	</form>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal_vendor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_vendor" id="cari_vendor" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_vendor" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Vendor Id</th>
                                <th>Vendor Name</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Bank</th>
                                <th>No Rek</th>
                                <th hidden>Atas Nama</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Kontrabon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_kontra" id="cari_kontra" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>kontrabon</th>
                                <th>Vendor</th>
                                <th>Total</th>
                                <th>Tgl Jatuh Tempo</th>
                                <th>Keterangan</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_sparepart" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SPP Sparepart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_sparepart" id="cari_sparepart" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_sparepart" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Kontrabon</th>
                                <th>Vendor</th>
                                <th>Total</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_kontra_sparepart" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kontrabon Sparepart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_Kontra_sparepart" id="cari_Kontra_sparepart" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_kontra_sparepart" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kontrabon</th>
                                <th>Vendor</th>
                                <th>Total</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_request" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biaya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_request" id="cari_request" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_request" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Permintaan</th>
                                <th>Tanggal</th>
                                <th>Perusahaan</th>
                                <th>Keterangan</th>
                                <th>Total</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_payment" id="cari_payment" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_payment" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th>Bank</th>
                                <th>Kode</th>
                                <th>Perusahaan</th>
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