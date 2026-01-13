@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>SPP Detail</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item ">Daftar SPP</li>
        <li class="breadcrumb-item active">SPP Detail (View)</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                SPP Detail (View)
                                @if(Auth::user()->kode_divisi == '5') <!-- Jika Finance SPP-->
                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                        <table border="1" cellspacing="0" width="100%" style="font-size:13px; border-collapse: collapse;">
                                <thead>
                                    <!-- Header Judul -->
                                    <tr>
                                        <th align="left" width="40%" style="font-size: 17px; font-weight: bold; color: #003366;">
                                            SURAT PERINTAH PEMBAYARAN
                                        </th>
                                        <th width="10%" style="font-size: 17px; font-weight: bold; color: #003366;" align="right">
                                            NO:
                                        </th>
                                        <th colspan="3" width="50%" style="font-size: 17px; font-weight: bold; color: #f02323;">
                                            {{ $spp_detail->no_spp }}
                                        </th>
                                    </tr>

                                    <!-- Isi -->
                                    <tr>
                                        <td width="20%">Tanggal SPP</td>
                                        <td colspan="4">{{ date('d-M-Y', strtotime($spp_detail->tgl_spp)) }}</td>
                                    </tr>

                                    <tr>
                                        <td>Tgl Jatuh Tempo</td>
                                        <td colspan="4">{{ date('d-M-Y', strtotime($spp_detail->jatuh_tempo)) }}</td>
                                    </tr>

                                    <tr>
                                        <td>Tujuan Pembayaran</td>
                                        <td colspan="4">
                                            {{ $spp_detail->for }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Jumlah yang dibayarkan</td>
                                        <td colspan="4">
                                            <span style="color: #003366; font-weight: bold; font-size: 15px;">
                                                Rp. {{ number_format($spp_detail->jumlah) }}
                                            </span>
                                            <br><b><i>( {{ terbilang($spp_detail->jumlah) }} rupiah )</i></b>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Keterangan Pembayaran</td>
                                        <td colspan="4">{{ $spp_detail->keterangan }}</td>
                                    </tr>

                                    <tr>
                                        <td>Bank tujuan</td>
                                        <td colspan="4">
                                            <span style="color: #003366; font-weight: bold; font-size: 13px;">
                                                {{ $spp_detail->nama_bank }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>No Rekening tujuan</td>
                                        <td colspan="4">
                                            <span style="color: #003366; font-weight: bold; font-size: 13px;">
                                                @if ($spp_detail->pembayaran == '-')
                                                    06
                                                @else
                                                    {{ $spp_detail->pembayaran }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Atas nama</td>
                                        <td colspan="4">
                                            <span style="color: #003366; font-weight: bold; font-size: 13px;">
                                                @if ($spp_detail->pembayaran == '-')
                                                    @if ($spp_detail->kode_vendor == 'PCBDG 2')
                                                        Ibu Yani
                                                    @else
                                                        {{ $spp_detail->yang_mengajukan }}
                                                    @endif
                                                @else
                                                    {{ $spp_detail->atas_nama }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>

                                    
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
@endsection