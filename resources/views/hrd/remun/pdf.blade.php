<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Remunerasi</title>
    
    <style>
    .invoice-box {
        max-width: 1100px;
        margin: auto;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 11px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: normal; /* inherit */
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(7) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 10px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 1px;
    }
    
    .invoice-box table tr.heading td {
       border-style: solid;
        font-weight: bold;
        border-width:1px 1px 1px 1px;
    }
    
    .invoice-box table tr.detail td {
        border-style: solid;
        border-width:1px 1px 1px 1px;
    }

    .invoice-box table tr.foot td {
        border-style: solid;
        border-width:1px 1px 1px 1px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(1) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(7) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5" align="center" style="font-size: 15px;"><b></b></td>
            </tr>
        
            
            <tr class="information">
                <td colspan="1">
                   
                        <tr>
                            <td>
                                Nama Calon Karyawan<br>
                                Jabatan<br>
                                Lokasi Kerja<br>
                                
                            </td>
                            
                            <td>
                                : {{ $data_remun_head->nama }} <br>
                                : {{ $data_remun_head->jabatan }}<br>
                                : {{ $data_remun_head->depo }}<br>
                                
                                
                            </td>

                            <td>
                                ID Finger<br>
                                Id DMS<br>
                                
                                Tgl Masuk<br>
                            </td>
                            
                            <td>
                                : {{ $data_remun_head->id_finger }}<br>
                                : {{ $data_remun_head->id_dms }} <br>
                                
                                : {{ date('d-M-Y', strtotime($data_remun_head->tgl_masuk)) }}
                                
                            </td>
                        </tr>
                </td>
            </tr>
        </table>
        <br>
        <table border="1" cellspacing="0" cellpadding="5" style="font-size:12px; width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background-color:LightGray; font-weight:bold; text-align:center;">
                    <th colspan="3">REMUNERASI CALON KARYAWAN</th>
                </tr>
                <tr style="background-color:LightGray; font-weight:bold;">
                    <th style="text-align:center;">No</th>
                    <th align="left">Tunjangan</th>
                    <th style="text-align:right;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1 ?>
                @forelse($data_remun_detail as $val)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $val->nama_tunjangan }}</td>
                    <td align="right">{{ number_format($val->nilai)}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data untuk saat ini</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color:LightGray; font-weight:bold;">
                    <th colspan="2" style="text-align:center; font-size: 15px;">T O T A L</th>
                    <th style="text-align:right;">Rp. {{ number_format($total->total) }}</th>
                </tr>
            </tfoot>
        </table>
        
        Bandung, {{ date('d-M-Y', strtotime($data_remun_head->tgl_remun)) }}

        <br><br>
        <table width="100%" style="text-align:center; font-size:12px;">
            <tr>
                <td>HRD</td>
                <td>Ka HRD</td>
                <td>Ka. Biaya</td>
                <td>Ka. Akunting</td>
            </tr>
            <tr>
                <td style="font-size: 10px;" height="20px">{{ $data_remun_head->tgl_remun }}</td>
                <td style="font-size: 10px;">{{ $data_remun_head->tgl_app_atasan }}</td>
                <td style="font-size: 10px;">{{ $data_remun_head->tgl_app_biaya_pusat }}</td>
                <td style="font-size: 10px;">{{ $data_remun_head->tgl_app_biaya_pusat_koor }}</td>
            </tr>
            <tr>
                <td style="font-size: 10px;" height="20px"></td>
                <td style="font-size: 10px;">{{ $data_remun_head->kode_app_atasan }}</td>
                <td style="font-size: 10px;">{{ $data_remun_head->kode_app_biaya_pusat }}</td>
                <td style="font-size: 10px;">{{ $data_remun_head->kode_app_biaya_pusat_koor }}</td>
            </tr>
            <tr style="font-weight:bold;">
                <td>({{ $data_remun_head->hrd }})</td>
                <td>({{ $data_remun_head->kahrd }})</td>
                <td>({{ $data_remun_head->kabiaya }})</td>
                <td>({{ $data_remun_head->kaakunting }})</td>
            </tr>
        </table>
        
    </div>
</body>
</html>