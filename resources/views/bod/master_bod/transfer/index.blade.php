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
        $.ajax({
        type: "GET",
        url: "{{ route('bod_transfer/getDataTransfer.getDataTransfer') }}",
        dataType: "json",
        success: function(response) {
            let tabledata;
            let no = 1;
            response.data.forEach(trf => {
            tabledata += `<tr>`;
                tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                tabledata += `<td>${trf.norek}</td>`;
                tabledata += `<td>${trf.virtualaccount}</td>`;
                tabledata += `<td hidden>${trf.kode_perusahaan}</td>`;
                tabledata += `<td>${trf.nama_perusahaan}</td>`;
                tabledata += `<td hidden>${trf.kode_bank}</td>`;
                tabledata += `<td>${trf.nama_bank}</td>`;
                tabledata += `<td>${trf.fungsi_rek}</td>`;
                tabledata += `<td>${trf.internet_banking}</td>`;
                tabledata += `<td>${trf.token}</td>`;
                tabledata += `<td>${trf.jml_pemegang_token_viewer}</td>`;
                tabledata += `<td>${trf.jml_pemegang_token_maker}</td>`;
                tabledata += `<td>${trf.jml_pemegang_token_verifier}</td>`;
                tabledata += `<td>${trf.jml_pemegang_token_authorizer}</td>`;
            tabledata += `</tr>`;
            });
            $("#tabledata").html(tabledata);
        }
        });
    }

    // $("#cari").keyup(function() {

    // });

    // function redirectToNewPage(no_urut) 
    // {
    //     let newPageURL = "{{ route('bod_otorisasi_claim/view') }}";
    //     newPageURL = newPageURL.replace();
    //     window.location.href = newPageURL;
    // }

    // function redirectToDetail(no_urut_pengajuan_biaya) 
    // {
    //     let detailPageURL = "{{ route('bod_otorisasi_claim_detail', ['no_urut_pengajuan_biaya' => ':no_urut_pengajuan_biaya']) }}";
    //     detailPageURL = detailPageURL.replace(':no_urut_pengajuan_biaya', no_urut_pengajuan_biaya);
    //     window.location.href = detailPageURL;
    // }

</script>
@stop


@extends('layouts.admin')

@section('title')
    <title>Transfer</title>
@endsection

@section('content')

<main class="main">
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master TUA Group</li>
        <li class="breadcrumb-item active">Transfer</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Transfer
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            
                            <!-- <div class="col-md-4 mb-2">
                                <div class="input-group mb-2">
                                    <input type="text" name="cari" id="cari" class="form-control" placeholder="Pencarian Data">
                                </div>
                            </div> -->

                            <!-- <div class="input-group mb-4 col-md-1 float-right">  
                                <a href="#" class="btn btn-success btn-sm ">O t o r i s a s i</a>
                            </div>   -->
                                
                                
                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No rekening</th>
                                            <th>Virtual Account</th>
                                            <th hidden>Kode Perusahaan</th>
                                            <th>Perusahaan</th>
                                            <th hidden>Kode Bank</th>
                                            <th>Bank</th>
                                            <th>Fungsi Rekening</th>
                                            <th>Internet Banking</th>
                                            <th>Token</th>
                                            <th>Jml Pemegang Token Viewer</th>
                                            <th>Jml Pemegang Token Maker</th>
                                            <th>Jml Pemegang Token Verifier</th>
                                            <th>Jml Pemegang Token Authorizer</th>
                                            <!-- <th>Jml Pemegang Token</th> -->
                                            <!-- <th>Aksi</th> -->
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