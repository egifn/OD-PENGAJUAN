@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(document).ready(function() {
            //INISIASI DATERANGEPICKER
            $('#tanggal_').daterangepicker({
             
            })
        })
    </script>

    <script type="text/javascript">
        function kembali() {
            window.history.back();
        }

        $(document).on('click', '.pilih_rekening', function (e) {
            document.getElementById("nama_perusahaan").value = $(this).attr('data-nama_perusahaan');
            document.getElementById("kode_bank").value = $(this).attr('data-kode_bank');
            document.getElementById("nama_bank").value = $(this).attr('data-nama_bank');
            document.getElementById("norek").value = $(this).attr('data-norek');
			document.getElementById("atas_nama").value = $(this).attr('data-atas_nama');
            $('#myModal').modal('hide');
        });

        $(document).ready(function(){
            fetch_data_program();
            function fetch_data_program(query = '')
            {
                $.ajax({
                    url:'{{ route("pengajuan_tiv/action_rekening.actionRekening") }}',
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#lookup_list_rekening tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#cari_rekening', function(){
                var query = $(this).val();
                fetch_data_program(query);
            });
        });

        function tekan_transfer_ng (x) {
            if ($("#nama_perusahaan").val() == ""){
                alert("Perusahaan harus dipilih/diisi. Perusahaan tidak boleh kosong");
                $("#nama_perusahaan").focus();
                return (false);
            }

            let kode_perusahaan_head = $('#kode_perusahaan').val();
            let nama_perusahaan_head = $('#nama_perusahaan').val();
            let kode_depo_head = $('#kode_depo').val();
            let nama_depo_head = $('#nama_depo').val();
            let kode_bank_head = $('#kode_bank').val();
            let nama_bank_head = $('#nama_bank').val();
            let norek_head = $('#norek').val();
            let radio_head = $("input[name='radio']:checked").val();
            let no_urut = $('#no_urut').val();

            let kode_pengajuan_b  = $('#kode_pengajuan_b'+ x +'').val();
            let kategori = $('#kategori'+ x +'').val();
            let no_surat_program = $('#no_surat_program'+ x +'').val();
            let id_program_ssd = $('#id_program_ssd'+ x +'').val();
            let nama_program = $('#nama_program'+ x +'').val();
            let kode_perusahaan_detail = $('#kode_perusahaan_detail'+ x +'').val();
            let nama_depo = $('#nama_depo_ng'+ x +'').val();
            let kode_outlet = $('#kode_outlet'+ x +'').val();
            let nama_outlet = $('#nama_outlet'+ x +'').val();
            let bank_ng  = $('#bank_ng'+ x +'').val();
            let norek_ng = $('#norek_ng'+ x +'').val();
            let atas_nama_rek_ng = $('#atas_nama_rek_ng'+ x +'').val();
            let reward = '0';
            let reward_tiv = '0';
            let potongan = '0';
            let ng_piutang = $('#ng_piutang'+ x +'').val();

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('transfer_program_claim/transfer_ng.transfer_ng') }}",
                data: {
                    kode_perusahaan_head: kode_perusahaan_head, 
                    nama_perusahaan_head: nama_perusahaan_head,
                    kode_depo_head: kode_depo_head,
                    nama_depo_head: nama_depo_head,
                    kode_bank_head: kode_bank_head,
                    nama_bank_head: nama_bank_head,
                    norek_head: norek_head,
                    radio_head: radio_head,
                    no_urut: no_urut,

                    kode_pengajuan_b: kode_pengajuan_b,
                    kategori: kategori,
                    no_surat_program: no_surat_program, 
                    id_program_ssd: id_program_ssd,
                    nama_program: nama_program,
                    kode_perusahaan_detail: kode_perusahaan_detail,
                    nama_depo: nama_depo,
                    kode_outlet: kode_outlet,
                    nama_outlet: nama_outlet,
                    bank_ng: bank_ng,
                    norek_ng: norek_ng,
                    atas_nama_rek_ng: atas_nama_rek_ng,
                    reward: reward,
                    reward_tiv: reward_tiv,
                    potongan: potongan,
                    ng_piutang: ng_piutang
                },
                success: function(response) {
                    if (response.res == true) {
                        window.location.href = "{{ route('transfer_program_claim', ['no_urut' => ':no_urut']) }}".replace(':no_urut', no_urut);
                    }else{
                        alert('Gagal, Data tidak berhasil diretur...');
                    }
                }
            });
            
        }

        function tekan_transfer_depo (x) {
            if ($("#nama_perusahaan").val() == ""){
                alert("Perusahaan harus dipilih/diisi. Perusahaan tidak boleh kosong");
                $("#nama_perusahaan").focus();
                return (false);
            }

            let kode_perusahaan_head = $('#kode_perusahaan').val();
            let nama_perusahaan_head = $('#nama_perusahaan').val();
            let kode_depo_head = $('#kode_depo').val();
            let nama_depo_head = $('#nama_depo').val();
            let kode_bank_head = $('#kode_bank').val();
            let nama_bank_head = $('#nama_bank').val();
            let norek_head = $('#norek').val();
            let radio_head = $("input[name='radio']:checked").val();
            let no_urut = $('#no_urut').val();

            let kode_pengajuan_b  = $('#kode_pengajuan_b'+ x +'').val();
            let kategori = $('#kategori'+ x +'').val();
            let no_surat_program = $('#no_surat_program'+ x +'').val();
            let id_program_ssd = $('#id_program_ssd'+ x +'').val();
            let nama_program = $('#nama_program'+ x +'').val();
            let kode_perusahaan_detail = $('#kode_perusahaan_detail'+ x +'').val();
            let nama_depo = $('#nama_depo_piutang'+ x +'').val();
            let kode_outlet = $('#kode_outlet'+ x +'').val();
            let nama_outlet = $('#nama_outlet'+ x +'').val();
            let nama_bank_depo  = $('#nama_bank_depo'+ x +'').val();
            let norek_depo = $('#norek_depo'+ x +'').val();
            let atas_nama_rek_depo = $('#atas_nama_rek_depo'+ x +'').val();
            let reward = '0';
            let reward_tiv = '0';
            let potongan = '0';
            let piutang_depo = $('#piutang_depo'+ x +'').val();

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('transfer_program_claim/transfer_depo.transfer_depo') }}",
                data: {
                    kode_perusahaan_head: kode_perusahaan_head, 
                    nama_perusahaan_head: nama_perusahaan_head,
                    kode_depo_head: kode_depo_head,
                    nama_depo_head: nama_depo_head,
                    kode_bank_head: kode_bank_head,
                    nama_bank_head: nama_bank_head,
                    norek_head: norek_head,
                    radio_head: radio_head,
                    no_urut: no_urut,

                    kode_pengajuan_b: kode_pengajuan_b,
                    kategori: kategori,
                    no_surat_program: no_surat_program, 
                    id_program_ssd: id_program_ssd,
                    nama_program: nama_program,
                    kode_perusahaan_detail: kode_perusahaan_detail,
                    nama_depo: nama_depo,
                    kode_outlet: kode_outlet,
                    nama_outlet: nama_outlet,
                    nama_bank_depo: nama_bank_depo,
                    norek_depo: norek_depo,
                    atas_nama_rek_depo: atas_nama_rek_depo,
                    reward: reward,
                    reward_tiv: reward_tiv,
                    potongan: potongan,
                    piutang_depo: piutang_depo
                },
                success: function(response) {
                    if (response.res == true) {
                        window.location.href = "{{ route('transfer_program_claim', ['no_urut' => ':no_urut']) }}".replace(':no_urut', no_urut);
                    }else{
                        alert('Gagal, Data tidak berhasil diretur...');
                    }
                }
            });
        }

        var x = 1;
        function tekan_transfer(x){
            if ($("#nama_perusahaan").val() == ""){
                alert("Perusahaan harus dipilih/diisi. Perusahaan tidak boleh kosong");
                $("#nama_perusahaan").focus();
                return (false);
            }

            let kode_perusahaan_head = $('#kode_perusahaan').val();
            let nama_perusahaan_head = $('#nama_perusahaan').val();
            let kode_depo_head = $('#kode_depo').val();
            let nama_depo_head = $('#nama_depo').val();
            let kode_bank_head = $('#kode_bank').val();
            let nama_bank_head = $('#nama_bank').val();
            let norek_head = $('#norek').val();
            let radio_head = $("input[name='radio']:checked").val();
            let no_urut = $('#no_urut').val();

            let kode_pengajuan_b  = $('#kode_pengajuan_b'+ x +'').val();
            let kategori = $('#kategori'+ x +'').val();
            let no_surat_program = $('#no_surat_program'+ x +'').val();
            let id_program_ssd = $('#id_program_ssd'+ x +'').val();
            let nama_program = $('#nama_program'+ x +'').val();
            let kode_perusahaan_detail = $('#kode_perusahaan_detail'+ x +'').val();
            let nama_depo = $('#nama_depo'+ x +'').val();
            let kode_outlet = $('#kode_outlet'+ x +'').val();
            let nama_outlet = $('#nama_outlet'+ x +'').val();
            let bank_rekening = $('#bank_rekening'+ x +'').val();
            let no_rekening = $('#no_rekening'+ x +'').val();
            let nama_rekening = $('#nama_rekening'+ x +'').val();
            let reward = $('#reward'+ x +'').val();
            let reward_tiv = $('#reward_tiv'+ x +'').val();
            let potongan = $('#potongan'+ x +'').val();
            let total = $('#total'+ x +'').val();
            // let chk = $('#chk'+ x +'').val();
            
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('transfer_program_claim/transfer.transfer') }}",
                data: {
                    kode_perusahaan_head: kode_perusahaan_head,
                    nama_perusahaan_head: nama_perusahaan_head,
                    kode_depo_head: kode_depo_head,
                    nama_depo_head: nama_depo_head,
                    kode_bank_head: kode_bank_head,
                    nama_bank_head: nama_bank_head,
                    norek_head: norek_head,
                    radio_head: radio_head,
                    no_urut: no_urut,

                    kode_pengajuan_b:kode_pengajuan_b,
                    kategori: kategori,
                    no_surat_program: no_surat_program,
                    id_program_ssd: id_program_ssd,
                    nama_program: nama_program,
                    kode_perusahaan_detail: kode_perusahaan_detail,
                    nama_depo: nama_depo,
                    kode_outlet: kode_outlet,
                    nama_outlet: nama_outlet,
                    bank_rekening: bank_rekening,
                    no_rekening: no_rekening,
                    nama_rekening: nama_rekening,
                    reward: reward,
                    reward_tiv: reward_tiv,
                    potongan: potongan,
                    total: total
                    // chk:$('#chk'+ x +'').val();
                },
                success: function(response) {
                    if (response.res == true) {
                        window.location.href = "{{ route('transfer_program_claim', ['no_urut' => ':no_urut']) }}".replace(':no_urut', no_urut);
                    }else{
                        alert('Gagal, Data tidak berhasil diretur...');
                    }
                }
            });
        }

        function all_transfer(){
            if ($("#nama_perusahaan").val() == ""){
                alert("Perusahaan harus dipilih/diisi. Perusahaan tidak boleh kosong");
                $("#nama_perusahaan").focus();
                return (false);
            }

            let kode_perusahaan_head = $('#kode_perusahaan').val();
            let nama_perusahaan_head = $('#nama_perusahaan').val();
            let kode_depo_head = $('#kode_depo').val();
            let nama_depo_head = $('#nama_depo').val();
            let kode_bank_head = $('#kode_bank').val();
            let nama_bank_head = $('#nama_bank').val();
            let norek_head = $('#norek').val();
            let radio_head = $("input[name='radio']:checked").val();
            let no_urut = $('#no_urut').val();

            let tgl_import = $('#tgl_import1').val();
            let kode_pengajuan_b  = $('#kode_pengajuan_b1').val();
            let kategori = $('#kategori1').val();
            let no_surat_program = $('#no_surat_program1').val();
            let id_program_ssd = $('#id_program_ssd1').val();
            let nama_program = $('#nama_program1').val();
            let kode_perusahaan_detail = $('#kode_perusahaan_detail1').val();
            let nama_depo = '';
            let kode_outlet = '';
            let nama_outlet = '';
            let bank_rekening = '';
            let no_rekening = '';
            let nama_rekening = '';
            let reward = $('#ttl_reward_dis').val();
            let reward_tiv = $('#ttl_reward_tiv').val();
            let potongan = $('#ttl_potongan').val();
            let total = $('#sub_total').val();

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('transfer_program_claim/transfer_all.transfer_all') }}",
                data: {
                    kode_perusahaan_head: kode_perusahaan_head,
                    nama_perusahaan_head: nama_perusahaan_head,
                    kode_depo_head: kode_depo_head,
                    nama_depo_head: nama_depo_head,
                    kode_bank_head: kode_bank_head,
                    nama_bank_head: nama_bank_head,
                    norek_head: norek_head,
                    radio_head: radio_head,
                    no_urut: no_urut,

                    tgl_import: tgl_import,
                    kode_pengajuan_b: kode_pengajuan_b,
                    kategori: kategori,
                    no_surat_program: no_surat_program,
                    id_program_ssd: id_program_ssd,
                    nama_program: nama_program,
                    kode_perusahaan_detail: kode_perusahaan_detail,
                    nama_depo: nama_depo,
                    kode_outlet: kode_outlet,
                    nama_outlet: nama_outlet,
                    bank_rekening: bank_rekening,
                    no_rekening: no_rekening,
                    nama_rekening: nama_rekening,
                    reward: reward,
                    reward_tiv: reward_tiv,
                    potongan: potongan,
                    total: total
                },
                success: function(response) {
                    if (response.res == true) {
                        window.location.href = "{{ route('transfer_program_claim', ['no_urut' => ':no_urut']) }}".replace(':no_urut', no_urut);
                    }else{
                        alert('Gagal, Data tidak berhasil diretur...');
                    }
                }
            });
        }

        $(document).ready(function(){
            if ($("input[name='radio']:checked").val() == "transfer" ) {
                $("#form-input").hide();
                $("#button_alltransfer").hide();
                $(".aksi").show();
                // $(".ceklis").hide();
            }else{
                $("#form-input").show();
                $("#button_alltransfer").show();
                $(".aksi").hide();
                // $(".ceklis").show();
            }
            var disabled = false;
            $(".detail").click(function(){ 
                if ($("input[name='radio']:checked").val() == "transfer" ) { 
                    $("#form-input").slideUp("fast"); 
                    $("#button_alltransfer").hide();
                    $(".aksi").show();
                    // $(".ceklis").hide();
                    
                    document.getElementById("cara_bayar").value = "";
                } else if ($("input[name='radio']:checked").val() == "bulk" ) {
                    $("#form-input").slideDown("fast"); 
                    $("#button_alltransfer").show();
                    $(".aksi").hide();
                    // $(".ceklis").show();
                }
            });
        });

        $(document).ready(function() {
            $('#select-all').click(function(event) {   
                if(this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;     
                        
                        var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
                        for(var t = 0; t < table.length; t++)
                        {
                             var i = 1+t;
                             if (table[t].checked) {
                                 var row = table[t].parentNode.parentNode;
                                 var price = row.cells[17].children[0].value;
                                
                                 sumHsl = sumHsl + parseInt(price);
                             }
                        }
                        //membuat format rupiah//
                        var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                            ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                            hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
                        //End membuat format rupiah//
                        
                        $('#sub_total').val(hasil_total);
                        $(".sub_total").text(hasil_total); 
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false; 
                        
                        var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
                        for(var t = 0; t < table.length; t++)
                        {
                            var i = 1+t;
                             if (table[t].checked) {
                                 var row = table[t].parentNode.parentNode;
                                 var price = row.cells[17].children[0].value;
                                 sumHsl = sumHsl + parseInt(price);
                             }
                        }
                        //membuat format rupiah//
                        var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                             ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                             hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
                        //End membuat format rupiah//
                        
                        $('#sub_total').val(hasil_total);
                        $(".sub_total").text(hasil_total);  
                    });
                }
            });
        });

        function chk_jumlah(x) {
            var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
            for(var t = 0; t < table.length; t++)
            {
                var row = table[t].parentNode.parentNode;
                var price = row.cells[17].children[0].value;
                

                if (table[t].checked) {
                    var row = table[t].parentNode.parentNode;
                    var price = row.cells[17].children[0].value;
                    sumHsl = sumHsl + parseInt(price);
                }
            }
            //membuat format rupiah//
            var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
            //End membuat format rupiah//
            $('#sub_total').val(hasil_total);
            $(".sub_total").text(hasil_total); 
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Daftar Transfer</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Transfer</li>
        <li class="breadcrumb-item active">Daftar Transfer</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn" id="page_form">
            
                <div class="row">
                
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                   Daftar Transfer
                                </h4>
                            </div>
                            <div class="card-body">
								<form action="{{ route('transfer_program_claim.excel_bulk', $data_transfer_head->no_urut_pengajuan) }}" target="_blank" method="get" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <div class="input-group">
                                            <input id="kode_perusahaan" name="kode_perusahaan" type="text" class="form-control" value="{{ request()->kode_perusahaan }}" hidden>
                                            <input id="nama_perusahaan" name="nama_perusahaan" type="text" class="form-control" value="{{ request()->nama_perusahaan }}" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" id="kode_depo" name="kode_depo" class="form-control" value="{{ request()->kode_depo }}" hidden>
                                        <input type="text" id="nama_depo" name="nama_depo" class="form-control" value="{{ request()->nama_depo }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Bank
                                        <input type="text" id="kode_bank" name="kode_bank" class="form-control" value="{{ request()->kode_bank }}" hidden>
                                        <input type="text" id="nama_bank" name="nama_bank" class="form-control" value="{{ request()->nama_bank }}" readonly>
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        No Rekening Perusahaan
                                        <input type="text" style="text-align: right;" id="norek" name="norek" class="form-control" value="{{ request()->norek }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Atas Nama
                                        <input type="text" style="text-align: right;" id="atas_nama" name="atas_nama" class="form-control" value="{{ request()->atas_nama }}" readonly>
                                    </div>

                                    <div class="col-md-1 mb-2">

                                    </div>

                                    <div class="col-md-1 mb-2 ml-auto">
                                        <br>
                                        <button class="btn btn-success" name="button_excel" id="button_excel" value="excel" type="submit">E x c e l</button>
                                    </div>
    
                                    <div class="col-md-3 mb-2" hidden>
                                        No urut
                                        <input name="no_urut" type="text" id="no_urut" class="form-control" value="{{ $data_transfer_head->no_urut_pengajuan }}" />
                                    </div>
                                    
                                </div>
                            
                            
                                <div class="row">
                                    <div class="col-md-1 mb-2">
                                        <input name="radio" type="radio" id="transfer" value="transfer" class="detail" checked="true" />
                                        Transfer {{-- (tampilan detail) --}}
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <input name="radio" type="radio" id="bulk" value="bulk" class="detail" />
                                        Bulk Transfer {{-- (tampilan keseluruhan) --}}
                                    </div>
                                </div>

                                <div id="form-input">
                                    <div id="form-input" class="row">
                                        <div class="col-md-3 mb-2">
                                            Cara Pembayaran
                                            <select name="cara_bayar" id="cara_bayar" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="LLG">LLG</option>
                                                <option value="RTGS">RTGS</option>
                                                <option value="FAST">FAST - BI Fast</option>
                                                <option value="OT">OT - Online Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Value Date
                                            {{-- <input type="text" name="value_date" id="value_date" class="form-control" value="-" required> --}}
                                            <input type="date" id="tanggal" name="tanggal" class="form-control">
                                        </div> 
                                        <div class="col-md-6 mb-2">
                                            Remarks
                                            {{-- <input type="text" name="value_date" id="value_date" class="form-control" value="-" required> --}}
                                            <input type="text" id="remarks" name="remarks" class="form-control">
                                        </div> 
                                    </div>   
                                    <br>
                                </div>
								</form>
                                <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <div style="width:100%;">
                                        <table class="table table-bordered table-sm" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>Tgl_import</th>
                                                    <th hidden>Kode_pengajuan</th>
                                                    <th>Kategori</th>
                                                    <th hidden>No Surat Program</th>
                                                    <th hidden>Id Program</th>
                                                    <th>Nama Program</th>
                                                    <th>Perusahaan</th>
                                                    <th>Depo</th>
                                                    <th hidden>Kode Toko</th>
                                                    <th>Nama Toko</th>
                                                    <th>Bank</th>
                                                    <th>No Rekening</th>
                                                    <th>Atas Nama Rekening</th>
                                                    <th>Reward Distributor</th>
                                                    <th>Reward TIV</th>
                                                    <th>Potongan</th>
                                                    <th>Total</th>
                                                    <th class="aksi">Aksi</th>
                                                    <th class="ceklis" hidden>Pilih &nbsp; <input type="checkbox" id="select-all"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($data_list_transfer as $row)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td class="tgl_import" hidden>
                                                        <input class="form-control" type="text" name="tgl_import[]" id="tgl_import{{ $no }}" value="{{ $row->tgl_import }}" hidden/>
                                                        {{ $row->tgl_import }}
                                                    </td>
                                                    <td class="kode_pengajuan_b" hidden>
                                                        <input class="form-control" type="text" name="kode_pengajuan_b[]" id="kode_pengajuan_b{{ $no }}" value="{{ $row->kode_pengajuan_b }}" hidden/>
                                                        {{ $row->kode_pengajuan_b }}
                                                    </td>
                                                    <td class="kategori">
                                                        <input class="form-control" type="text" name="kategori[]" id="kategori{{ $no }}" value="{{ $row->kategori }}" hidden/>
                                                        {{ $row->kategori }}
                                                    </td>
                                                    <td class="no_surat_program" hidden>
                                                        <input class="form-control" type="text" name="no_surat_program[]" id="no_surat_program{{ $no }}" value="{{ $row->no_surat_program }}" hidden/>
                                                        {{ $row->no_surat_program }}
                                                    </td>
                                                    <td class="id_program_ssd" hidden>
                                                        <input class="form-control" type="text" name="id_program_ssd[]" id="id_program_ssd{{ $no }}" value="{{ $row->id_program_ssd }}" hidden/>
                                                        {{ $row->id_program_ssd }}
                                                    </td>
                                                    <td class="nama_program">
                                                        <input class="form-control" type="text" name="nama_program[]" id="nama_program{{ $no }}" value="{{ $row->nama_program }}" hidden/>
                                                        {{ $row->nama_program }}
                                                    </td>
                                                    <td class="kode_perusahaan_detail">
                                                        <input class="form-control" type="text" name="kode_perusahaan_detail[]" id="kode_perusahaan_detail{{ $no }}" value="{{ $row->kode_perusahaan_detail }}" hidden/>
                                                        {{ $row->kode_perusahaan_detail }}
                                                    </td>
                                                    <td class="nama_depo">
                                                        <input class="form-control" type="text" name="nama_depo[]" id="nama_depo{{ $no }}" value="{{ $row->nama_depo }}" hidden/>
                                                        {{ $row->nama_depo }}
                                                    </td>
                                                    <td class="kode_outlet" hidden>
                                                        <input class="form-control" type="text" name="kode_outlet[]" id="kode_outlet{{ $no }}" value="{{ $row->kode_outlet }}" hidden/>
                                                        {{ $row->kode_outlet }}
                                                    </td>
                                                    <td class="nama_outlet">
                                                        <input class="form-control" type="text" name="nama_outlet[]" id="nama_outlet{{ $no }}" value="{{ $row->nama_outlet }}" hidden/>
                                                        {{ $row->nama_outlet }}
                                                    </td>
                                                    <td class="bank_rekening">
                                                        <input class="form-control" type="text" name="bank_rekening[]" id="bank_rekening{{ $no }}" value="{{ $row->bank_rekening }}" hidden/>
                                                        {{ $row->bank_rekening }}
                                                    </td>
                                                    <td class="no_rekening">
                                                        <input class="form-control" type="text" name="no_rekening[]" id="no_rekening{{ $no }}" value="{{ $row->no_rekening }}" hidden/>
                                                        {{ $row->no_rekening }}
                                                    </td>
                                                    <td class="nama_rekening">
                                                        <input class="form-control" type="text" name="nama_rekening[]" id="nama_rekening{{ $no }}" value="{{ $row->nama_rekening }}" hidden/>
                                                        {{ $row->nama_rekening }}
                                                    </td>
                                                    <td class="reward" align="right">
                                                        <input class="form-control" type="text" name="reward[]" id="reward{{ $no }}" value="{{ $row->reward }}" hidden/>
                                                        {{ number_format($row->reward) }}
                                                    </td>
                                                    <td class="reward_tiv" align="right">
                                                        <input class="form-control" type="text" name="reward_tiv[]" id="reward_tiv{{ $no }}" value="{{ $row->reward_tiv }}" hidden/>
                                                        {{ number_format($row->reward_tiv) }}
                                                    </td>
                                                    <td class="potongan" align="right">
                                                        <input class="form-control" type="text" name="potongan[]" id="potongan{{ $no }}" value="{{ $row->potongan }}" hidden/>
                                                        {{ number_format($row->potongan) }}
                                                    </td>
                                                    <td class="total" align="right">
                                                        <input class="form-control" type="text" name="total[]" id="total{{ $no }}" value="{{ $row->total - $row->piutang_ng - $row->piutang_depo }}" hidden/>
                                                        {{ number_format($row->total - $row->piutang_ng - $row->piutang_depo) }}
                                                    </td>

                                                    {{-- @if($row->status == '1' && $row->status_upload_ng == '0' && $row->status_upload_depo == '0')
                                                    <td class="aksi">
                                                        <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_transfer( {{ $no }} );">Transfer</button>
                                                    </td>
                                                    @elseif($row->status == '1' && $row->status_upload_ng == '1' && $row->status_upload_depo == '0')
                                                    <td class="aksi">
                                                        <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-secondary btn-sm" onclick="tekan_transfer( {{ $no }} );" disabled>Transfer</button>
                                                    </td>
                                                    @elseif($row->status == '1' && $row->status_upload_ng == '0' && $row->status_upload_depo == '1')
                                                    <td class="aksi">
                                                        <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-secondary btn-sm" onclick="tekan_transfer( {{ $no }} );" disabled>Transfer</button>
                                                    </td>
                                                    @endif --}}

                                                    <!-- temp piutang -->
                                                    <td class="nilai_ng" align="center" hidden>
                                                        <input type="text" name="nilai_ng[]" id="nilai_ng{{ $no }}" value="{{ $row->piutang_ng }}"/>
                                                    </td>

                                                    <td class="nilai_depo" align="center" hidden>
                                                        <input type="text" name="nilai_depo[]" id="nilai_depo{{ $no }}" value="{{ $row->piutang_depo }}"/>
                                                    </td>
                                                    <!-- temp piutang -->

                                                    {{-- <td class="ceklis" align="center">
                                                        <input type="checkbox" name="chk{{ $no }}" id="chk{{ $no }}" class="checkbox" onclick="chk_jumlah( {{ $no }} );" data-index=" {{ $no }} " value="{{ $row->kode_outlet }}"/>
                                                    </td> --}}

                                                    <!-- temp piutang -->
                                                    <td class="nilai_ng" align="center" hidden>
                                                        <input type="text" name="nilai_ng[]" id="nilai_ng{{ $no }}" value="{{ $row->piutang_ng }}"/>
                                                    </td>

                                                    <td class="nilai_depo" align="center" hidden>
                                                        <input type="text" name="nilai_depo[]" id="nilai_depo{{ $no }}" value="{{ $row->piutang_depo }}"/>
                                                    </td>
                                                    <!-- temp piutang -->

                                                    <td class="ceklis" id="ceklist{{ $no }}" align="center" hidden>
                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="checkbox" onclick="chk_jumlah( {{ $no }} );" data-index=" {{ $no }} " value="{{ $row->kode_outlet }}"/>
                                                    </td>
                                                    @if($row->piutang_ng != '0' and $row->piutang_depo == '0' )
                                                        @if($row->status_upload_ng == '0')
                                                            <td class="aksi">
                                                                <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" disabled>Transfer</button>
                                                            </td>
                                                        @else
                                                            <td class="aksi">
                                                                <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_transfer( {{ $no }} );">Transfer</button>
                                                            </td>
                                                        @endif
                                                    @elseif($row->piutang_ng == '0' and $row->piutang_depo != '0' )
                                                         @if($row->status_upload_depo == '0')
                                                            <td class="aksi">
                                                                <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" disabled>Transfer</button>
                                                            </td>
                                                        @else
                                                            <td class="aksi">
                                                                <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_transfer( {{ $no }} );">Transfer</button>
                                                            </td>
                                                        @endif
                                                    @elseif($row->piutang_ng != '0' and $row->piutang_depo != '0' )
                                                        <td class="aksi">
                                                            <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" disabled>Transfer</button>
                                                        </td>
                                                    @elseif($row->piutang_ng == '0' and $row->piutang_depo == '0' )
                                                        <td class="aksi">
                                                            <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_transfer( {{ $no }} );">Transfer</button>
                                                        </td>
                                                    @endif

                                                </tr>
                                                <?php $no++; ?>
                                                    <!-- untuk Piutadepo depo dan piutang depo -->
                                                    @if($row->piutang_ng != '0')
                                                        @if($row->status_upload_ng == '0')
                                                            <tr style="background-color: rgb(215, 241, 251)">
                                                                <td></td>
                                                                <td class="tgl_import" hidden>
                                                                    <input class="form-control" type="text" name="tgl_import[]" id="tgl_import{{ $no }}" value="{{ $row->tgl_import }}" hidden/>
                                                                    {{ $row->tgl_import }}
                                                                </td>
                                                                <td class="kode_pengajuan_b" hidden>
                                                                    <input class="form-control" type="text" name="kode_pengajuan_b[]" id="kode_pengajuan_b{{ $no }}" value="{{ $row->kode_pengajuan_b }}" hidden/>
                                                                    {{ $row->kode_pengajuan_b }}
                                                                </td>
                                                                <td class="kategori">
                                                                    <input class="form-control" type="text" name="kategori[]" id="kategori{{ $no }}" value="{{ $row->kategori }}" hidden/>
                                                                    {{ $row->kategori }}
                                                                </td>
                                                                <td class="no_surat_program" hidden>
                                                                    <input class="form-control" type="text" name="no_surat_program[]" id="no_surat_program{{ $no }}" value="{{ $row->no_surat_program }}" hidden/>
                                                                    {{ $row->no_surat_program }}
                                                                </td>
                                                                <td class="id_program_ssd" hidden>
                                                                    <input class="form-control" type="text" name="id_program_ssd[]" id="id_program_ssd{{ $no }}" value="{{ $row->id_program_ssd }}" hidden/>
                                                                    {{ $row->id_program_ssd }}
                                                                </td>
                                                                <td class="nama_program">
                                                                    <input class="form-control" type="text" name="nama_program[]" id="nama_program{{ $no }}" value="{{ $row->nama_program }}" hidden/>
                                                                    {{ $row->nama_program }}
                                                                </td>
                                                                <td class="kode_perusahaan_detail">
                                                                    <input class="form-control" type="text" name="kode_perusahaan_detail[]" id="kode_perusahaan_detail{{ $no }}" value="{{ $row->kode_perusahaan_detail }}" hidden/>
                                                                    {{ $row->kode_perusahaan_detail }}
                                                                </td>
                                                                <td class="nama_depo">
                                                                    <input class="form-control" type="text" name="nama_depo_ng[]" id="nama_depo_ng{{ $no }}" value="Piutang NG" hidden/>
                                                                    Piutang NG
                                                                </td>
                                                                <td class="kode_outlet" hidden>
                                                                    <input class="form-control" type="text" name="kode_outlet[]" id="kode_outlet{{ $no }}" value="{{ $row->kode_outlet }}" hidden/>
                                                                    {{ $row->kode_outlet }}
                                                                </td>
                                                                <td class="nama_outlet">
                                                                    <input class="form-control" type="text" name="nama_outlet[]" id="nama_outlet{{ $no }}" value="{{ $row->nama_outlet }}" hidden/>
                                                                    {{ $row->nama_outlet }}
                                                                </td>
                                                                <td class="bank_ng">
                                                                    <input class="form-control" type="text" name="bank_ng[]" id="bank_ng{{ $no }}" value="{{ $row->nama_bank_ng }}" hidden/>
                                                                    {{ $row->nama_bank_ng }}
                                                                </td>
                                                                <td class="norek_ng">
                                                                    <input class="form-control" type="text" name="norek_ng[]" id="norek_ng{{ $no }}" value="{{ $row->norek_ng }}" hidden/>
                                                                    {{ $row->norek_ng }}
                                                                </td>
                                                                <td class="atas_nama_rek_ng">
                                                                    <input class="form-control" type="text" name="atas_nama_rek_ng[]" id="atas_nama_rek_ng{{ $no }}" value="{{ $row->atas_nama_rek_ng }}" hidden/>
                                                                    {{ $row->atas_nama_rek_ng }}
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="ng_piutang" align="right">
                                                                    <input class="form-control" type="text" name="ng_piutang[]" id="ng_piutang{{ $no }}" value="{{ $row->piutang_ng }}" hidden/>
                                                                    {{ number_format($row->piutang_ng) }}
                                                                </td>
                                                                <td class="aksi">
                                                                    <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_transfer_ng( {{ $no }} );">Transfer</button>
                                                                </td>
            
                                                                <td class="ceklis" id="ceklist{{ $no }}" align="center" hidden>
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="checkbox" onclick="chk_jumlah( {{ $no }} );" data-index=" {{ $no }} " value="{{ $row->kode_outlet }}"/>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif

                                                    @if($row->piutang_depo != '0')
                                                        @if($row->status_upload_depo == '0')
                                                            <tr style="background-color: rgb(215, 241, 251)">
                                                                <td></td>
                                                                <td class="tgl_import" hidden>
                                                                    <input class="form-control" type="text" name="tgl_import[]" id="tgl_import{{ $no }}" value="{{ $row->tgl_import }}" hidden/>
                                                                    {{ $row->tgl_import }}
                                                                </td>
                                                                <td class="kode_pengajuan_b" hidden>
                                                                    <input class="form-control" type="text" name="kode_pengajuan_b[]" id="kode_pengajuan_b{{ $no }}" value="{{ $row->kode_pengajuan_b }}" hidden/>
                                                                    {{ $row->kode_pengajuan_b }}
                                                                </td>
                                                                <td class="kategori">
                                                                    <input class="form-control" type="text" name="kategori[]" id="kategori{{ $no }}" value="{{ $row->kategori }}" hidden/>
                                                                    {{ $row->kategori }}
                                                                </td>
                                                                <td class="no_surat_program" hidden>
                                                                    <input class="form-control" type="text" name="no_surat_program[]" id="no_surat_program{{ $no }}" value="{{ $row->no_surat_program }}" hidden/>
                                                                    {{ $row->no_surat_program }}
                                                                </td>
                                                                <td class="id_program_ssd" hidden>
                                                                    <input class="form-control" type="text" name="id_program_ssd[]" id="id_program_ssd{{ $no }}" value="{{ $row->id_program_ssd }}" hidden/>
                                                                    {{ $row->id_program_ssd }}
                                                                </td>
                                                                <td class="nama_program">
                                                                    <input class="form-control" type="text" name="nama_program[]" id="nama_program{{ $no }}" value="{{ $row->nama_program }}" hidden/>
                                                                    {{ $row->nama_program }}
                                                                </td>
                                                                <td class="kode_perusahaan_detail">
                                                                    <input class="form-control" type="text" name="kode_perusahaan_detail[]" id="kode_perusahaan_detail{{ $no }}" value="{{ $row->kode_perusahaan_detail }}" hidden/>
                                                                    {{ $row->kode_perusahaan_detail }}
                                                                </td>
                                                                <td class="nama_depo">
                                                                    <input class="form-control" type="text" name="nama_depo_piutang[]" id="nama_depo_piutang{{ $no }}" value="Piutang Depo" hidden/>
                                                                    Piutang Depo
                                                                </td>
                                                                <td class="kode_outlet" hidden>
                                                                    <input class="form-control" type="text" name="kode_outlet[]" id="kode_outlet{{ $no }}" value="{{ $row->kode_outlet }}" hidden/>
                                                                    {{ $row->kode_outlet }}
                                                                </td>
                                                                <td class="nama_outlet">
                                                                    <input class="form-control" type="text" name="nama_outlet[]" id="nama_outlet{{ $no }}" value="{{ $row->nama_outlet }}" hidden/>
                                                                    {{ $row->nama_outlet }}
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="nama_bank_depo[]" id="nama_bank_depo{{ $no }}" value="{{ $row->nama_bank_depo }}" hidden/>
                                                                    {{ $row->nama_bank_depo }}
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="norek_depo[]" id="norek_depo{{ $no }}" value="{{ $row->norek_depo }}" hidden/>
                                                                    {{ $row->norek_depo}}
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="atas_nama_rek_depo[]" id="atas_nama_rek_depo{{ $no }}" value="{{ $row->atas_nama_rek_depo }}" hidden/>
                                                                    {{ $row->atas_nama_rek_depo }}
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td align="right">
                                                                    <input class="form-control" type="text" name="piutang_depo[]" id="piutang_depo{{ $no }}" value="{{ $row->piutang_depo }}" hidden/>
                                                                    {{ number_format($row->piutang_depo) }}
                                                                </td>
                                                                <td class="aksi">
                                                                    <button type="button" name="button_transfer[]" id="button_transfer{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_transfer_depo( {{ $no }} );">Transfer</button>
                                                                </td>
            
                                                                <td class="ceklis" id="ceklist{{ $no }}" align="center" hidden>
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="checkbox" onclick="chk_jumlah( {{ $no }} );" data-index=" {{ $no }} " value="{{ $row->kode_outlet }}"/>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif

                                                @empty
                                                <tr>
                                                        
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9s" align="center"><b>Total:</b></td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="ttl_reward_dis" id="ttl_reward_dis" style="font-size: 13px;" value="{{ $data_list_transfer->sum('reward') }}" hidden>
                                                        <b>{{ $data_list_transfer->sum('reward') }}</b> &nbsp;
                                                    </td>
                        
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="ttl_reward_tiv" id="ttl_reward_tiv" style="font-size: 13px;" value="{{ $data_list_transfer->sum('reward_tiv') }}" hidden>
                                                        <b>{{ number_format($data_list_transfer->sum('reward_tiv')) }}</b> &nbsp;
                                                    </td>

                                                    <td align="right">
                                                        <input type="text" class="form-control" name="ttl_potongan" id="ttl_potongan" style="font-size: 13px;" value="{{ $data_list_transfer->sum('potongan') }}" hidden>
                                                        <b>{{ number_format($data_list_transfer->sum('potongan')) }}</b> &nbsp;
                                                    </td>

                                                    <td align="right" class="sub_total">
                                                        <input type="text" class="form-control" name="sub_total" id="sub_total" style="font-size: 13px;" value="{{ $data_list_transfer->sum('total') }}" hidden>
                                                        <b>{{ number_format($data_list_transfer->sum('total')) }}</b> &nbsp;
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                    
                                <div class="col-mb-15 float-right">
                                    <button type="button" name="button_alltransfer" id="button_alltransfer" class="btn btn-success btn-sm" onclick="all_transfer();">T r a n s f e r</button>
                                    <button class="btn btn-primary btn-sm" name=kembali id="kembali" hidden>K e m b a l i</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
            
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="input-group mb-3 col-md-4 float-right">
                    <input type="text" name="cari_rekening" id="cari_rekening" class="form-control" placeholder="Search Data . . .">
                </div>
              
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_list_rekening" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                
                                <th>Perusahaan</th>
                                <th hidden>kode_bank</th>
                                <th>Bank</th>
                                <th>No Rekening</th>
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


@endsection
