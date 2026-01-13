<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cost Request #</title>
    
    <style>
    .invoice-box {
        max-width: 1100px;
        margin: auto;
        border: 1px solid rgb(6, 6, 6);
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 14px;
        line-height: 24px;
        /* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
        color: #080808;
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
        /* font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
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
            <tr class="heading">
                <td colspan="5" align="center">
                    <b>SURAT PERINTAH PERJALANAN DINAS (SPPD)</b>
                    <br>
                    No: {{ $pengajuan_sppd_v->kode_pengajuan_sppd }}
                </td>
            </tr>
        </table> 
    
		<hr>
    
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td width="160px">
                    <b>1. Nama</b><br>
                    <b>2. Lokasi Kerja</b><br>
                    <b>3. Jabatan/Divisi</b><br>
                    <b>4. Lokasi Tugas</b><br>
                    <b>5. Lama Penugasan</b><br>
                    <b>6. Keperluan Tugas</b><br>
                </td>

                <td>
                    : {{ $pengajuan_sppd_v->pelaksana }}<br>
                    : {{ $pengajuan_sppd_v->nama_depo }}<br>
                    : {{ $pengajuan_sppd_v->nama_divisi }}<br>
                    : @foreach ($detailSppdArray as $detail)
                            {{ $detail->nama_depo }},
                      @endforeach
                      <br>
                    : {{ $pengajuan_sppd_v->jml_hari }} Hari<br>
                    : @foreach ($detailSppdArray as $detail)
                            {{ $detail->keperluan }},
                      @endforeach 
                      <br>
                </td>
            </tr>
        </table> 
    
		<hr>
    
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td width="160px">
                    Berangkat tgl<br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td>
                    : {{ date('d-M-Y', strtotime($pengajuan_sppd_v->tgl_mulai)) }}<br>
                    <b>Pemberi Tugas</b><br>
                    <br>
                    <br>
                    <br>
                    <br>
                    ({{ $pengajuan_sppd_v->kepala_divisi }})
                </td>
                <td>
                    <br>
                    <b>Penerima Tugas</b><br>
                    <br>
                    <br>
                    <br>
                    <br>
                    ({{ $pengajuan_sppd_v->pelaksana }})
                </td>
                <td align="center">
                    <br>
                    <b>Mengetahui</b><br>
                    <b>Koordinator HRD</b><br>
                    <br>
                    <br>
                    <br>
                    (
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					)
                </td>
            </tr>
        </table> 
    
		<hr>
    
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td width="160px">
                    <b>Tiba pada tgl</b><br>
                    <b>Ka. Depo</b><br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
                <td width="205px">
                    :<br>
                    :<br>
                    <br>
                    <br>
                    <br>
					<br>
                    (
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					)
                </td>
                <td width="90px">
                    <b>Berangkat, tgl</b><br>
                    <br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
                <td align="center">
                    :<br>
                    <br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
            </tr>
        </table> 
         
		<hr>
		
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td width="160px">
                    <b>Tiba pada tgl</b><br>
                    <b>Ka. Depo</b><br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
                <td width="205px">
                    :<br>
                    :<br>
                    <br>
                    <br>
                    <br>
					<br>
                    (
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					)
                </td>
                <td width="90px">
                    <b>Berangkat, tgl</b><br>
                    <br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
                <td align="center">
                    :<br>
                    <br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
            </tr>
        </table> 
           
		<hr>
		
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td width="160px">
                    <b>Tiba pada tgl</b><br>
                    <b>Ka. Depo</b><br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
                <td width="205px">
                    :<br>
                    :<br>
                    <br>
                    <br>
                    <br>
					<br>
                    (
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					)
                </td>
                <td width="90px">
                    <b>Berangkat, tgl</b><br>
                    <br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
                <td align="center">
                    :<br>
                    <br>
                    <br>
                    <br>
                    <br>
					<br>
                </td>
            </tr>
        </table> 
         
		<hr>
		
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td width="160px">
                    <i>Tebusan:</i><br>
                    <i>Asli: untuk Bagian Biaya</i><br>
                    <i>Copy: untuk HRD</i><br>
                    <br>
                    <br>
                    <br>
                </td>
                <td width="205px">
                    <br>
                    <b>Pemberi Tugas</b><br>
                    <br>
                    <br>
                    <br>
                    ({{ $pengajuan_sppd_v->kepala_divisi }})
                </td>
                <td width="90px">
                    <b>Tiba pada tgl</b><br>
                    <br>
                    <br>
                    <br>
                </td>
                <td align="center">
                    :<br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
        </table> 
         
		<hr>
		
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td align="center">
                    <b><i>Penanganan dan hasil dari tugas yang dikerjakan harus dibuat laporan singkat dan jelas !</i></b>
                </td>
            </tr>
        </table> 
    
		<hr>
		
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td align="center">
                    <i>SPPD ditanda tangani <b>Pemberi Tugas</b> dan <b>Penerima Tugas</b> dan diserahkan ke HRD</i>
                </td>
            </tr>
        </table> 
    
		<hr>
		
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td align="center">
                    <i>SPPD diterima HRD Absensi maks <b>H-1 sebelum</b> Perjalanan Dinas (baik via email / diserahkan langsung ke HRD)</i>
                </td>
            </tr>
        </table> 
    <div>
</body>
</html>