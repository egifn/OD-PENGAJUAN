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
    fetchAllDataOtorisasi();
    function fetchAllDataOtorisasi(){
        let value = $("#cari").val();
        $.ajax({
            type: "GET",
            url: "{{ route('otorisasi_claim_tua_bocbc.getData') }}",
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

                    var reverse_total_reward_tiv = daftar.reward_tiv.toString().split('').reverse().join(''),
                    ribuan_total_reward_tiv  = reverse_total_reward_tiv.match(/\d{1,3}/g);
                    harga_total_reward_tiv = ribuan_total_reward_tiv.join(',').split('').reverse().join('');

                    var reverse_potongan = daftar.potongan.toString().split('').reverse().join(''),
                    ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                    harga_potongan = ribuan_potongan.join(',').split('').reverse().join('');

                    var reverse_total = daftar.total.toString().split('').reverse().join(''),
                    ribuan_total  = reverse_total.match(/\d{1,3}/g);
                    harga_total = ribuan_total.join(',').split('').reverse().join('');                

                    tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td>${daftar.kode_pengajuan_b}</td>`;
                        tabledata += `<td>${daftar.no_surat_program}</td>`;
                        tabledata += `<td>${daftar.id_program_ssd}</td>`;
                        tabledata += `<td>${daftar.nama_program}</td>`;
                        tabledata += `<td>${daftar.keterangan_biaya}</td>`;
                        tabledata += `<td align = "right">${harga_reward_dis}</td>`;
                        tabledata += `<td align = "right">${harga_total_reward_tiv}</td>`;
                        tabledata += `<td align = "right">${harga_potongan}</td>`;
                        tabledata += `<td align = "right">${harga_total}</td>`;
                        // tabledata += `<td hidden>${daftar.no_urut}</td>`;
                        // tabledata += `<td hidden>${daftar.no_urut_pengajuan_biaya}</td>`;
                        //tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_pengajuan_b}" data-no_surat="${daftar.no_surat_program}" data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-success btn-sm" onclick="redirectToNewPage('${daftar.no_urut}')">View Transfer</button></td>`;
                        // tabledata += `<td align="center"><button type="button" data-id="${daftar.kode_pengajuan_b}" data-no_surat="${daftar.no_surat_program}" data-no_urut_pengajuan_biaya="${daftar.no_urut_pengajuan_biaya}" id="button_view" class="btn btn-success btn-sm" onclick="redirectToDetail('${daftar.no_urut_pengajuan_biaya}')">View </button>&nbsp;
                        //     <button type="button" data-id="${daftar.kode_pengajuan_b}" data-no_surat="${daftar.no_surat_program}" data-no-urut="${daftar.no_urut}" id="button_view" class="btn btn-warning btn-sm" onclick="redirectToNewPage('${daftar.no_urut}')">Otorisasi</button></td>`;
                    tabledata += `</tr>`;
                });
                $("#tabledata").html(tabledata);
            }
        });
    }

    $("#cari").keyup(function() {

    });

    function redirectToNewPage(no_urut) 
    {
        let newPageURL = "{{ route('otorisasi_claim_tua_bocbc/view') }}";
        newPageURL = newPageURL.replace();
        window.location.href = newPageURL;
    }

    function redirectToDetail(no_urut_pengajuan_biaya) 
    {
        let detailPageURL = "{{ route('otorisasi_claim_detail', ['no_urut_pengajuan_biaya' => ':no_urut_pengajuan_biaya']) }}";
        detailPageURL = detailPageURL.replace(':no_urut_pengajuan_biaya', no_urut_pengajuan_biaya);
        window.location.href = detailPageURL;
    }

</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Otorisasi Transfer Claim</title>
@endsection

@section('content')

<main class="main">
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Biaya Non Tunai</li>
        <li class="breadcrumb-item">Otorisasi Transfer</li>
        <li class="breadcrumb-item">Program Claim</li>
        <li class="breadcrumb-item active">Otorisasi Transfer Claim</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Otorisari Transfer Claim
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            
                                {{-- <div class="col-md-4 mb-2">
                                    <div class="input-group mb-2">
                                        <input type="text" name="cari" id="cari" class="form-control" placeholder="Pencarian Data">
                                    </div>
                                </div> --}}

                                
                                <div class="input-group mb-4 col-md-1 float-right">  
                                    

                                   
                                    <a href="{{ route('otorisasi_claim_tua_bocbc/view') }}" class="btn btn-success btn-sm ">O t o r i s a s i</a>
                                     
                                </div>  
                                
                                
                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Pengajuan</th>
                                            <th>No Surat</th>
                                            <th>Id Program</th>
                                            <th>Nama Program</th>
                                            <th>Keterangan Program</th>
                                            <th>Reward Distributor</th>
                                            <th>Reward TIV</th>
                                            <th>Potongan</th>
                                            <th>Total Reward</th>
                                            {{-- <th hidden>No Urut</th>
                                            <th hidden>No Urut Biaya</th> --}}
                                            {{-- <th>Aksi</th> --}}
                                            
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