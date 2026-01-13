@section('js')


<script type="text/javascript">
    function goBack() {
        window.history.back();
    }

    var x = 1;
    function input_ket(x) {
        if(x==1){
            var keterangan_detail = $("input[name='ket[]1']").val();
                     
            if ($("input[name='chk[]1']:checked").val()){
                var ceklist = '1';
            }else{
                var ceklist = '0';
            }
            
            $('#ceklist_temp1').text(ceklist);
            $('#keterangan_temp1').text(keterangan_detail);
        }else{
            //x++;
            var keterangan_detail = $("input[name='ket[]" +x+ "']").val();
                     
            if ($("input[name='chk[]" +x+ "']:checked").val()){
                var ceklist = '1';
            }else{
                var ceklist = '0';
            }

            $('#ceklist_temp' +x+ '').text(ceklist);
            $('#keterangan_temp' +x+ '').text(keterangan_detail);
        }    
    }

    fetchAllData();
    function fetchAllData(){
        //let id = $(this).data('id_program');
        //let perusahaan = $(this).data('perusahaan');
		
		var kodeDivisi = "{{ Auth::user()->kode_divisi }}";
        
        let perusahaan = $("#kode_perusahaan_tujuan").val();
		let kode_pengajuan = $("#kode_pengajuan").val();
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

                let piutang_d = program.piutang_depo;
                //membuat format rupiah Harga//
                var reverse_piutang_d = piutang_d.toString().split('').reverse().join(''),
                ribuan_piutang_d  = reverse_piutang_d.match(/\d{1,3}/g);
                piutang_d_rupiah = ribuan_piutang_d.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                let piutang_n = program.piutang_ng;
                //membuat format rupiah Harga//
                var reverse_piutang_n = piutang_n.toString().split('').reverse().join(''),
                ribuan_piutang_n  = reverse_piutang_n.match(/\d{1,3}/g);
                piutang_n_rupiah = ribuan_piutang_n.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                let total_ditransfer = program.ditransfer - program.piutang_depo - program.piutang_ng;
                //membuat format rupiah Harga//
                var reverse_ttl_ditransfer = total_ditransfer.toString().split('').reverse().join(''),
                ribuan_ttl_ditransfer  = reverse_ttl_ditransfer.match(/\d{1,3}/g);
                ttl_ditransfer_rupiah = ribuan_ttl_ditransfer.join(',').split('').reverse().join('');
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
				if (kodeDivisi == '30' || kodeDivisi == '6' || kodeDivisi == '24' || kodeDivisi == '16') {
					tabledata_outlet += `<td align='right'>${piutang_d_rupiah}</td>`;
					tabledata_outlet += `<td>${program.norek_depo}</td>`;
					tabledata_outlet += `<td align='right'>${piutang_n_rupiah}</td>`;
					tabledata_outlet += `<td>${program.norek_ng}</td>`;
					tabledata_outlet += `<td align='right'>${ttl_ditransfer_rupiah}</td>`;
				}
				
                
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

    $("#button_form_approved").click(function() {
        
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        let kode_divisi = $("#kode_divisi").val();
        let kode_sub_divisi = $("#kode_sub_divisi").val();
        
        let deskripsi = []
        let ceklist = []
        let keterangan_detail = []

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('approval_tiv/approved.approved') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    if(kode_divisi === '6'){
                        if(kode_sub_divisi === '4'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else if(kode_sub_divisi === '5'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else{
                            window.location.href = "{{ route('pengajuan_biaya.index')}}";
                        }
                    }else if(kode_divisi === '5'){
                        window.location.href = "{{ route('approval_cost.index')}}";
                    }else{
                        window.location.href = "{{ route('pengajuan_biaya.index')}}";
                    }
                    // window.location.href = "{{ route('pengajuan_biaya.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_denied").click(function() {
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        let kode_sub_divisi = $("#kode_sub_divisi").val();
        
        let deskripsi = []
        let ceklist = []
        let keterangan_detail = []

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('approval_tiv/denied.denied') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    if(response.res === true) {
                        if(kode_divisi === '6'){
                            if(kode_sub_divisi === '4'){
                                window.location.href = "{{ route('approval_cost.index')}}";
                            }else if(kode_sub_divisi === '4'){
                                window.location.href = "{{ route('approval_cost.index')}}";
                            }else{
                                window.location.href = "{{ route('pengajuan_biaya.index')}}";
                            }
                        }else if(kode_divisi === '5'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else{
                            window.location.href = "{{ route('pengajuan_biaya.index')}}";
                        }
                        // window.location.href = "{{ route('pengajuan_biaya.index')}}";
                    }else{

                    }
                }else{

                }
            }
        });
    });

    $("#button_form_pending").click(function() {
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        let kode_sub_divisi = $("#kode_sub_divisi").val();
        
        let deskripsi = []
        let ceklist = []
        let keterangan_detail = []

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('approval_tiv/pending.pending') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    if(kode_divisi === '6'){
                        if(kode_sub_divisi === '4'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else if(kode_sub_divisi === '4'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else{
                            window.location.href = "{{ route('pengajuan_biaya.index')}}";
                        }
                    }else if(kode_divisi === '5'){
                        window.location.href = "{{ route('approval_cost.index')}}";
                    }else{
                        window.location.href = "{{ route('pengajuan_biaya.index')}}";
                    }
                    // window.location.href = "{{ route('pengajuan_biaya.index')}}";
                }else{

                }
            }
        });
    });

    $(document).on("click", "#button_view_data", function(e) {
        e.preventDefault();
        let id = $(this).data('id');
		let kode_pengajuan = $(this).data('kode_pengajuan');
        let perusahaan = $(this).data('perusahaan');

        $.ajax({
        type: "GET",
        url: "{{ route('pengajuan_tiv/view_data_all.view_data_all') }}",
        data: {
             id: id,
			 kode_pengajuan: kode_pengajuan,
             perusahaan: perusahaan
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
</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>View Approval Pengajuan TIV</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Approval</li>
        <li class="breadcrumb-item">Pengajuan TIV</li>
        <li class="breadcrumb-item active">Approval Pengajuan TIV</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Approval Pengajuan TIV</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ $approval_pengajuan_tiv_head->tgl_pengajuan_b }}" readonly>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden>
                                        Tgl Pengajuan Import
                                        <input type="text" name="tgl_import" id="tgl_import" class="form-control" value="{{ $approval_pengajuan_tiv_head->tgl_import }}" readonly>
                                    </div>
									
									<div class="col-md-3 mb-2">
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan" id="kode_pengajuan" class="form-control" value="{{ $approval_pengajuan_tiv_head->kode_pengajuan_b }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{ $approval_pengajuan_tiv_head->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $approval_pengajuan_tiv_head->nama_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="depo" class="form-control" value="{{ $approval_pengajuan_tiv_head->nama_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="nm_pengeluaran" class="form-control" value="{{ $approval_pengajuan_tiv_head->nama_pengeluaran }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Untuk Perusahaan
                                        <input type="text" name="perusahaan_tujuan" class="form-control" value="{{ $approval_pengajuan_tiv_head->perusahaan_tujuan }}" required readonly>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden>
                                        Kode Untuk Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $approval_pengajuan_tiv_head->kode_perusahaan_tujuan }}" required readonly>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" class="form-control" value="{{ $approval_pengajuan_tiv_head->keterangan }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        No Surat 
                                        <input type="text" name="no_surat" class="form-control" value="{{ $approval_pengajuan_tiv_head->no_surat_program }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Id Program
                                        <input type="text" name="id_program" id="id_program" class="form-control" value="{{ $approval_pengajuan_tiv_head->id_program }}" required readonly>
                                    </div>

                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        Nama Program
                                        <input type="text" name="nama_program" id="nama_program" class="form-control" value="{{ $approval_pengajuan_tiv_head->nama_program }}" required>
                                    </div> --}}

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $approval_pengajuan_tiv_head->no_urut }}" required>
                                    </div>
                                    
                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        Jenis Surat
                                        <input type="text" name="jenis_surat" id="jenis_surat" class="form-control" value="" required>
                                    </div> --}}
                                </div>
                                
                                <div class="row" hidden>
                                    <div class="col-md-2 mb-2">
                                        Division
                                        <input type="text" name="divisi" class="form-control" value="{{ $approval_pengajuan_tiv_head->nama_divisi }}" readonly>
                                       
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        tipe
                                        <input type="text" name="tipe" class="form-control" value="" readonly>
                                       
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    
                                </div>
                            </div>

                        </div>
                    </div>

<!-- ################################### COBA #################################### -->
                    
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
                                                    <div style="border:1px white;width:100%;height:180px;overflow-y:scroll;">
                                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                            <thead>
                                                                <tr>
                                                                    <th hidden>#</th>
                                                                    <th>Id Program</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Jml Toko</th>
                                                                    <th>Total Reward</th>
                                                                    <th>Total Potongan</th>
                                                                    <th>Total</th>
                                                                    <th>Keterangan</th>
                                                                    <th hidden>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $no=1 ?>
                                                                @forelse ($approval_pengajuan_tiv_detail as $row)
                                                                    @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                                        @if($row->status_detail == '0')
                                                                            <tr style="background-color: #FF4A4A;">
                                                                        @elseif($row->status_detail == '1')
                                                                            <tr>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                                        @if($row->status_detail == '0')
                                                                            <tr style="background-color: #FF4A4A;">
                                                                        @elseif($row->status_detail == '1')
                                                                            <tr>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                        @if($row->status_detail_fin == '0')
                                                                            <tr style="background-color: #FF4A4A;">
                                                                        @elseif($row->status_detail == '1')
                                                                            <tr>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                                        @if($row->status_detail_clm == '0')
                                                                            <tr style="background-color: #FF4A4A;">
                                                                        @elseif($row->status_detail_clm == '1')
                                                                            <tr>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '30') <!-- Jika Non Gudang-->
                                                                        @if($row->status_detail_ng == '0')
                                                                            <tr style="background-color: #FF4A4A;">
                                                                        @elseif($row->status_detail_ng == '1')
                                                                            <tr>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '24') <!-- Jika claim-->
                                                                        @if($row->status_detail_piutang == '0')
                                                                            <tr style="background-color: #FF4A4A;">
                                                                        @elseif($row->status_detail_piutang == '1')
                                                                            <tr>
                                                                        @endif
                                                                    @else
                
                                                                    @endif
                                                                        <td class="desc">
                                                                            <input type="text" class="form-control" name="desc[]{{ $no }}" id="desc[]{{ $no }}" style="font-size: 13px;" value="{{ $row->description}}" hidden>{{ $row->description}}
                                                                        </td>
                                                                        <td>{{ $row->spesifikasi}}</td>
                                                                        <td align="right">{{ $row->qty}}</td>
                                                                        <td align="right">{{ number_format($row->harga) }}</td>
                                                                        <td align="right">{{ number_format($row->potongan) }}</td>
                                                                        <td align="right">{{ number_format($row->harga - $row->potongan)}}</td>
                                                                        <td class="keterangan">
                                                                            @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                                                {{ $row->keterangan_detail }}
                                                                            @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                                                {{ $row->keterangan_detail }}
                                                                            @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                                {{ $row->keterangan_detail_fin }}
                                                                            @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                                                {{ $row->keterangan_detail_clm }}
                                                                            @elseif(Auth::user()->kode_divisi == '30') <!-- Jika claim-->
                                                                                {{ $row->keterangan_detail_ng }}
                                                                            @elseif(Auth::user()->kode_divisi == '24') <!-- Jika claim-->
                                                                                {{ $row->keterangan_detail_piutang }}
                                                                            @else
                                                                                @if($approval_pengajuan_tiv_head->status_atasan == '0') <!-- Baru -->
                                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                                @elseif($approval_pengajuan_tiv_head->status_atasan == '1') <!-- approved -->
                                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" readonly>
                                                                                @elseif($approval_pengajuan_tiv_head->status_atasan == '2') <!-- denied -->
                
                                                                                @elseif($approval_pengajuan_tiv_head->status_atasan == '3') <!-- pending -->
                                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}">
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td align="center" hidden>
                                                                            <button type="button" data-id="{{ $row->description }}" data-perusahaan="{{ $row->spesifikasi }}" id="button_view_data" class="btn btn-success btn-sm">View</button>
                                                                        </td>
                                                                        <td class="keterangan_temp" id="keterangan_temp{{ $no }}" hidden></td>
                                                                    </tr>
                                                                    <?php $no++ ?>
                                                                @empty
                                                                <tr>
                                                                
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
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
                                                                            <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                                    {{ $row->filename }}
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
                                                        <label for="total" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                                    </div>  
                                                    <div class="col-md-2 mb-2">
                                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ number_format($total_jml->ditransfer) }}" style="text-align:right; font-style:bold;" required readonly>
                                                        
                                                    </div>
                
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <div class="input-group mb-3">
                                                            
                                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                                <tbody>
                                                                    <?php $no=1 ?>
                                                                    @forelse ($approval_tiv_upload as $row)
                                                                    <tr>
                                                                        <td><i>Attachment_{{ $no }}</i></td>
                                                                        <td>
                                                                            <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                                {{ $row->filename }}
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
                                                </div>
                                                <br>
                                                <div class="row">
                                                    @if(Auth::user()->kode_divisi == '10') <!-- Jika CLAIM-->
                                                        @if($approval_pengajuan_tiv_head->status_claim  == '1') <!-- 1: approved -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_claim  == '2') <!-- 2: denied -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_claim  == '3') <!-- 3: Pending -->
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '30') <!-- Jika Non Gudang-->
                                                        @if($approval_pengajuan_tiv_head->status_ng  == '1') <!-- 1: approved -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_ng  == '2') <!-- 2: denied -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_ng  == '3') <!-- 3: Pending -->
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '24') <!-- Jika Piutang-->
                                                        @if($approval_pengajuan_tiv_head->status_piutang  == '1') <!-- 1: approved -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_piutang  == '2') <!-- 2: denied -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_piutang  == '3') <!-- 3: Pending -->
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                        @if($approval_pengajuan_tiv_head->status_biaya  == '1') <!-- approved -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_biaya  == '2') <!--denied -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_biaya  == '3') <!-- Pending -->
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                               <!--  <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                               <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting/Biaya Pusat-->
                                                        @if($approval_pengajuan_tiv_head->status_biaya_pusat  == '1') <!-- approved -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_biaya_pusat  == '2') <!--denied -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_biaya_pusat  == '3') <!-- Pending -->
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                               <!--  <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                               <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_update', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_denied', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <!-- <a href="{{ route('approval_cost_pending', $approval_pengajuan_tiv_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @else
                                                        @if($approval_pengajuan_tiv_head->status_biaya_pusat  == '1') <!-- approved -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_biaya_pusat  == '2') <!--denied -->
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                            </div>
                                                        @elseif($approval_pengajuan_tiv_head->status_biaya_pusat  == '3') <!-- Pending -->
                                                            <div class="col-md-1 mb-2">
                                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                    
                                                            <div class="col-md-1 mb-2">
                                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-1 mb-2">
                                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                                    Approved
                                                                </button>
                                                            </div>
                                                       
                                                            <div class="col-md-1 mb-2">
                                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                                    Denied
                                                                </button>
                                                            </div>
                                                        
                                                            <div class="col-md-1 mb-2">
                                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                                    Pending
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @endif
                
                
                                                    <!-- MODAL APPROVED -->
                                                            <div class="modal fade" id="modalTambahPesan_approve" tabindex="-1" aria-labelledby="modalTambahPesan_approve" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Isi untuk Keterangan</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!--FORM TAMBAH BARANG-->
                                                                            <form action="{{ route('approval_tiv/approved.approved', $approval_pengajuan_tiv_head->no_urut) }}" method="post">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $approval_pengajuan_tiv_head->no_urut }}" required readonly>
                                                                                    <input type="hidden" name="kategori_nama" id="kategori_nama" class="form-control" value="{{ $approval_pengajuan_tiv_head->nama_pengeluaran }}" required readonly>
                                                                                    <label for="">keterangan</label>
                                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                                </div>
                                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                                            </form>
                                                                            <!--END FORM TAMBAH BARANG-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <!-- End MODAL -->
                                                    <!-- MODAL DENIED -->
                                                            <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Isi untuk Keterangan ditolak </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!--FORM TAMBAH BARANG-->
                                                                            <form action="{{ route('approval_tiv/denied.denied', $approval_pengajuan_tiv_head->no_urut) }}" method="post">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $approval_pengajuan_tiv_head->no_urut }}" required readonly>
                                                                                    <label for="">keterangan</label>
                                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                                </div>
                                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                                            </form>
                                                                            <!--END FORM TAMBAH BARANG-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <!-- End MODAL -->
                                                    <!-- MODAL Pending -->
                                                            <div class="modal fade" id="modalTambahPesan_pending" tabindex="-1" aria-labelledby="modalTambahPesan_pending" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Isi untuk keterangan ditunda  </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!--FORM TAMBAH BARANG-->
                                                                            <form action="{{ route('approval_tiv/pending.pending', $approval_pengajuan_tiv_head->no_urut) }}" method="post">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $approval_pengajuan_tiv_head->no_urut }}" required readonly>
                                                                                    <label for="">keterangan</label>
                                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                                </div>
                                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                                            </form>
                                                                            <!--END FORM TAMBAH BARANG-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <!-- End MODAL -->
                
                
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
                                                                            <footer id="table_footer">

                                                                            </footer>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                
                
                                                    <div class="col-md-9 mb-2" align="right">
                                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="detail" role="tabpanel">
                                                <br>
                                                <div class="table-responsive">
                                                <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th hidden>Id</th>
                                                                <th>Perusahaan</th>
                                                                <th>Depo</th>
                                                                <th>Cluster</th>
                                                                <th>Id Toko</th>
                                                                <th>Nama Toko</th>
                                                                <th>No Rek</th>
                                                                <th>Bank</th>
                                                                <th>Nama Rekening</th>
                                                                <th>Reward Distributor</th>
                                                                <th>Reward TIV</th>
                                                                <th>Potongan</th>
                                                                <th>Total</th>
																@if(Auth::user()->kode_divisi == '24' || Auth::user()->kode_divisi == '6' || Auth::user()->kode_divisi == '30' || Auth::user()->kode_divisi == '16') <!-- Jika Piutang, akunting dan Non Gudang -->
                                                                    <th>Piutang Depo</th>
                                                                    <th>No rek Depo</th>
                                                                    <th>Piutang NG</th>
                                                                    <th>No Rek NG</th>
                                                                    <th>Sub Total</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabledata_outlet">
                                                            
                                                        </tbody>
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
    </div>
</main>





@endsection

@section('script')



@endsection




