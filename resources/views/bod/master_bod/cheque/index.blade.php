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
        fetchAllDataCheque();

        function fetchAllDataCheque() {
            $.ajax({
                type: "GET",
                url: "{{ route('bod_cheque/getDataCheque.getDataCheque') }}",
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 1;
                    response.data.forEach(chq => {
                        tabledata += `<tr>`;
                        tabledata += `<td style="padding-left: 13px;">${no++}</td>`;
                        tabledata += `<td>${chq.kode_pengajuan_cek}</td>`;
                        tabledata += `<td>${chq.kode_terima_cek}</td>`;
                        tabledata += `<td>${chq.kode_buku}</td>`;
                        tabledata += `<td>${chq.id_cek}</td>`;
                        tabledata += `<td>${chq.no_rekening}</td>`;
                        tabledata += `<td>${chq.nama_perusahaan}</td>`;
                        tabledata += `<td>${chq.nama_bank}</td>`;
                        tabledata += `<td>${chq.pembawa_resi}</td>`;
                        tabledata += `<td>${chq.pengambil}</td>`;
                        tabledata += `<td></td>`;
                        tabledata += `<td>${chq.tujuan ?? ''}</td>`;
                        tabledata += `<td>${chq.total_cek ?? 0}</td>`;
                        tabledata += `<td></td>`;
                        tabledata += `<td></td>`;
                        tabledata += `<td></td>`;
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
    <title>Cheque</title>
@endsection

@section('content')

    <main class="main">

        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Master TUA Group</li>
            <li class="breadcrumb-item active">Cheque</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Cheque
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
                                    <table id="datatabel-v1" class="table table-bordered table-sm"
                                        style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Pengajuan</th>
                                                <th>Kode Terima</th>
                                                <th>Kode Buku Cheque</th>
                                                <th>No Cheque</th>
                                                <th>No Rekening</th>
                                                <th>Perusahaan</th>
                                                <th>Bank</th>
                                                <th>Pengajuan Cheque</th>
                                                <th>Pengambil Cheque</th>
                                                <th>Pengisi Cheque</th>
                                                <th>Tujuan</th>
                                                <th>Nominal</th>
                                                <th>Ttd Cheque</th>
                                                <th>Penyimpan dan menyerahkan Cheque ke vendor</th>
                                                <th>Transaksi ke bank</th>
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
