@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script> 
    $(document).ready(function() {
        //INISIASI DATERANGEPICKER
        $('#tanggal').daterangepicker({
               
        })        
    })
</script>


<script type="text/javascript">
    fetchAllDataTransfer();
    function fetchAllDataTransfer(){
        let value = $("#cari").val();
        $.ajax({
            type: "GET",
            url: "{{ route('transfer_program_claim_his.getData') }}",
            data: {
                value: value
            },
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 1;
                response.data.forEach(daftar => {
                    var reverse_reward_dis = daftar.reward_distributor.toString().split('').reverse().join(''),
                    ribuan_reward_dis  = reverse_reward_dis.match(/\d{1,3}/g);
                    harga_reward_dis = ribuan_reward_dis.join(',').split('').reverse().join('');

                    var reverse_potongan = daftar.potongan.toString().split('').reverse().join(''),
                    ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                    harga_potongan = ribuan_potongan.join(',').split('').reverse().join('');

                    var reverse_total_reward = daftar.total_reward.toString().split('').reverse().join(''),
                    ribuan_total_reward  = reverse_total_reward.match(/\d{1,3}/g);
                    harga_total_reward = ribuan_total_reward.join(',').split('').reverse().join('');

                    tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td>${daftar.kode_pengajuan_b}</td>`;
						tabledata += `<td>${daftar.kode_perusahaan_tujuan}</td>`;
                        tabledata += `<td>${daftar.no_surat_program}</td>`;
                        tabledata += `<td>${daftar.id_program}</td>`;
                        tabledata += `<td>${daftar.nama_program}</td>`;
                        
                        tabledata += `<td align = "right">${harga_reward_dis}</td>`;
                        // tabledata += `<td align = "right">${daftar.reward_tiv}</td>`;
                        tabledata += `<td align = "right">${harga_potongan}</td>`;
                        tabledata += `<td align = "right">${harga_total_reward}</td>`;
                        tabledata += `<td hidden>${daftar.no_urut}</td>`;
                        //tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_pengajuan_b}" data-no_surat="${daftar.no_surat_program}" data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-success btn-sm" onclick="redirectToNewPage('${daftar.no_urut}')">View Transfer</button></td>`;
                        tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_pengajuan_b}" data-no_surat="${daftar.no_surat_program}" data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-success btn-sm" onclick="redirectToNewPage('${daftar.no_urut}')">View Transfer</button></td>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
            }
        });
    }

    $("#button_cari_tanggal").click(function() {
        let tgl_cari = $("#tanggal").val();
        $.ajax({
            type: "GET",
            url: "{{ route('transfer_program_claim_his/cari.cari') }}",
            data: {
                //value: value
                tgl_cari: tgl_cari
            },
            dataType: "json",
            success: function(response) {
                let tabledata;
                let no = 1;
                response.data.forEach(daftar => {
                    var reverse_reward_dis = daftar.reward_distributor.toString().split('').reverse().join(''),
                    ribuan_reward_dis  = reverse_reward_dis.match(/\d{1,3}/g);
                    harga_reward_dis = ribuan_reward_dis.join(',').split('').reverse().join('');

                    var reverse_potongan = daftar.potongan.toString().split('').reverse().join(''),
                    ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                    harga_potongan = ribuan_potongan.join(',').split('').reverse().join('');

                    var reverse_total_reward = daftar.total_reward.toString().split('').reverse().join(''),
                    ribuan_total_reward  = reverse_total_reward.match(/\d{1,3}/g);
                    harga_total_reward = ribuan_total_reward.join(',').split('').reverse().join('');

                    tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td>${daftar.kode_pengajuan_b}</td>`;
						tabledata += `<td>${daftar.kode_perusahaan_tujuan}</td>`;
                        tabledata += `<td>${daftar.no_surat_program}</td>`;
                        tabledata += `<td>${daftar.id_program}</td>`;
                        tabledata += `<td>${daftar.nama_program}</td>`;
                        
                        tabledata += `<td align = "right">${harga_reward_dis}</td>`;
                        // tabledata += `<td align = "right">${daftar.reward_tiv}</td>`;
                        tabledata += `<td align = "right">${harga_potongan}</td>`;
                        tabledata += `<td align = "right">${harga_total_reward}</td>`;
                        tabledata += `<td hidden>${daftar.no_urut}</td>`;
                        //tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_pengajuan_b}" data-no_surat="${daftar.no_surat_program}" data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-success btn-sm" onclick="redirectToNewPage('${daftar.no_urut}')">View Transfer</button></td>`;
                        tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_pengajuan_b}" data-no_surat="${daftar.no_surat_program}" data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-success btn-sm" onclick="redirectToNewPage('${daftar.no_urut}')">View Transfer</button></td>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
            }
        });

    });

    function redirectToNewPage(no_urut) {
        let newPageURL = "{{ route('transfer_program_claim_his', ['no_urut' => ':no_urut']) }}";
        newPageURL = newPageURL.replace(':no_urut', no_urut);
        window.location.href = newPageURL;
    }

    

</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>History Transfer</title>
@endsection

@section('content')

<main class="main">
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item">Transfer</li>
		<li class="breadcrumb-item">Program Claim</li>
        <li class="breadcrumb-item active">History</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                History Transfer
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="input-group mb-2">
                                        <input type="text" name="cari" id="cari" class="form-control" placeholder="Pencarian Data" hidden>
                                    </div>
                                </div>

                                <div class="col-md-5 mb-2">
                                </div>

								<div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button type="button" class="btn btn-secondary" name="button_cari_tanggal" id="button_cari_tanggal" value="tgl">C a r i</button>
                                </div> 
                                
                                <div class="col-md-3 mb-2">
                                    <div class="input-group mb-2">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Pengajuan</th>
											<th>Perusahaan</th>
                                            <th>No Surat</th>
                                            <th>Id Program</th>
                                            <th>Nama Program</th>
                                            <th>Reward</th>
                                            {{-- <th>Reward TIV</th> --}}
                                            <th>Potongan</th>
                                            <th>Total Reward</th>
                                            <th hidden>No Urut</th>
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
            </div>
        </div>
    </div>
</main>
@endsection