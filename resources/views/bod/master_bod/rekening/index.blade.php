@extends('layouts.admin')

@section('title')
<title>Dashboard</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active">Rekening</li>
    </ol>

    <style>
        .bg-penampung {
            background: #d4f8d4 !important;
            color: black !important;
        }

        /* hijau muda */
        .bg-master {
            background: #93c4f8ff !important;
            color: black !important;
        }

        /* biru muda */
        .bg-biaya {
            background: #ffd4e5 !important;
            color: black !important;
        }

        /* pink muda */
    </style>

    <style>
        .modal-dialog.modal-fullscreen {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content {
            height: 100%;
            border-radius: 0;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 20px;
        }

        /* Agar isi modal memenuhi ruang yang tersedia */
        .modal-body {
            overflow-y: auto;
            max-height: calc(100vh - 120px);
            /* Sesuaikan untuk memberikan ruang untuk header dan footer */
        }

        .role-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            /* jarak antar item */
            margin-top: 10px;
        }

        .role-item {
            display: flex;
            flex-direction: column;
            /* badge di atas, angka di bawah */
            align-items: center;
            /* rata tengah */
        }

        .role-badge-bulat {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            /* harus sama */
            height: 40px;
            /* harus sama */
            background: #28a745;
            color: #fff;
            border-radius: 50%;
            /* bulat sempurna */
            font-size: 12px;
            font-weight: bold;
        }

        .role-badge-kotak {
            display: inline-block;
            padding: 10px 10px;
            /* width: 40px;     harus sama
                            height: 40px; */
            background: #28a745;
            color: #fff;
            border-radius: 0;
            /* kotak sempurna */
            font-size: 12px;
            font-weight: bold;
        }

        .role-number {
            margin-top: 4px;
            font-size: 14px;
            font-weight: bold;
        }

        /* .list-item {
                            margin-bottom: 5px;
                            font-size: 14px;
                        } */
    </style>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Master Rekening</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                TUA (30)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                LP (10)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            5
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                WPS (15)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                APJ (8)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            3
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PK -->
                            <div class="row">
                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                PK (10)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            6
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            3
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                KU (7)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            2
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TGSM -->
                            <div class="row">
                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                TGSM (7)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            2
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                ARS (12)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            7
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DTS -->
                            <div class="row">
                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                DTS (10)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            5
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                TA (5)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            3
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TU -->
                            <div class="row">
                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                TU (9)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            6
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            2
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-lg-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-0 pt-0" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="text-center" style="font-size: 28px; font-weight: bold;">
                                                TTA (10)
                                            </div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Penampung</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            6
                                                        </div>
                                                    </td>

                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-penampung openModal" data-toggle="modal"
                                                        data-target="#modalView"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Master</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            1
                                                        </div>
                                                    </td>

                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">VW</span>
                                                                                    <span class="role-number">10</span>
                                                                                </div> -->

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <!-- <div class="role-item">
                                                                                    <span class="role-badge-kotak">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">M</span>
                                                                                    <span class="role-number">2</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-bulat">VR</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div>

                                                                                <div class="role-item">
                                                                                    <span class="role-badge-kotak">A</span>
                                                                                    <span class="role-number">1</span>
                                                                                </div> -->
                                                        </div>
                                                    </td>
                                                    <td class="bg-master openModal" data-toggle="modal"
                                                        data-target="#modalViewMaster"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b></b><br>

                                                        <div class="role-container">
                                                            <b>Biaya</b><br>
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:15%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Rek</b><br>

                                                        <div class="role-container">
                                                            4
                                                        </div>
                                                    </td>

                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:30%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <!-- <b>Penampung</b><br> -->
                                                        <div class="role-container">
                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VW</span>
                                                                <span class="role-number">10</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">M</span>
                                                                <span class="role-number">2</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-bulat">VR</span>
                                                                <span class="role-number">1</span>
                                                            </div>

                                                            <div class="role-item">
                                                                <span class="role-badge-kotak">A</span>
                                                                <span class="role-number">1</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="bg-biaya openModal" data-toggle="modal"
                                                        data-target="#modalViewBiaya"
                                                        style="cursor:pointer; width:20%; vertical-align:top;">
                                                        <!-- <td onclick="window.location.href='/penampung'" class="bg-penampung" style="cursor:pointer; width:30%; vertical-align:top;"> -->
                                                        <b style="text-align: center;">Jml Token</b><br>
                                                        <div class="role-container">
                                                            10
                                                        </div>
                                                    </td>
                                                </tr>
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

    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <!-- Menggunakan modal-fullscreen -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rekening Penampung</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">

                        </div>
                    </div>

                    <table id="datatabel" class="table table-striped table-bordered" style="width: 100%;">
                        <thead style="background-color: #d4f8d4;">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">Bank</th>
                                <th rowspan="2" style="vertical-align: middle;">No Rekening</th>
                                <th colspan="5" style="text-align: center;">internet Banking</th>
                                <th colspan="3" style="text-align: center;">Cek</th>
                            </tr>
                            <tr style="display: block; text-align: center;">
                                <th style="vertical-align: middle;">Viewer</th>
                                <th style="vertical-align: middle;">Maker</th>
                                <th style="vertical-align: middle;">Verifier</th>
                                <th style="vertical-align: middle;">Authoriser</th>
                                <th style="vertical-align: middle;">Jml Token</th>
                                <th style="vertical-align: middle;">Yg meminta cek ke bank</th>
                                <th style="vertical-align: middle;">Penyimpan cek</th>
                                <th style="vertical-align: middle;">Penandatangan cek</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_detail" class="tbl_detail">

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalViewMaster" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <!-- Menggunakan modal-fullscreen -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rekening Master</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">

                        </div>
                    </div>

                    <table id="datatabel" class="table table-striped table-bordered" style="width: 100%;">
                        <thead style="background-color: #d4e9ff;">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">Bank</th>
                                <th rowspan="2" style="vertical-align: middle;">No Rekening</th>
                                <th colspan="5" style="text-align: center;">internet Banking</th>
                                <th colspan="3" style="text-align: center;">Cek</th>
                            </tr>
                            <tr style="display: block; text-align: center;">
                                <th style="vertical-align: middle;">Viewer</th>
                                <th style="vertical-align: middle;">Maker</th>
                                <th style="vertical-align: middle;">Verifier</th>
                                <th style="vertical-align: middle;">Authoriser</th>
                                <th style="vertical-align: middle;">Jml Token</th>
                                <th style="vertical-align: middle;">Yg meminta cek ke bank</th>
                                <th style="vertical-align: middle;">Penyimpan cek</th>
                                <th style="vertical-align: middle;">Penandatangan cek</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_detail" class="tbl_detail">

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalViewBiaya" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <!-- Menggunakan modal-fullscreen -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rekening Biaya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">

                        </div>
                    </div>

                    <table id="datatabel" class="table table-striped table-bordered" style="width: 100%;">
                        <thead style="background-color: #ffd4e5;">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">Bank</th>
                                <th rowspan="2" style="vertical-align: middle;">No Rekening</th>
                                <th colspan="5" style="text-align: center;">internet Banking</th>
                                <th colspan="3" style="text-align: center;">Cek</th>
                            </tr>
                            <tr style="display: block; text-align: center;">
                                <th style="vertical-align: middle;">Viewer</th>
                                <th style="vertical-align: middle;">Maker</th>
                                <th style="vertical-align: middle;">Verifier</th>
                                <th style="vertical-align: middle;">Authoriser</th>
                                <th style="vertical-align: middle;">Jml Token</th>
                                <th style="vertical-align: middle;">Yg meminta cek ke bank</th>
                                <th style="vertical-align: middle;">Penyimpan cek</th>
                                <th style="vertical-align: middle;">Penandatangan cek</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_detail" class="tbl_detail">

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script>
    $(document).on('click', '.openModal', function () {
        let kategori = $(this).data('id');
        console.log("Klik kategori:", kategori);
    });

    $(document).on('click', '.openModalMaster', function () {
        let kategori = $(this).data('id');
        console.log("Klik kategori:", kategori);
    });

    $(document).on('click', '.openModalBiaya', function () {
        let kategori = $(this).data('id');
        console.log("Klik kategori:", kategori);
    });
</script>
@endsection