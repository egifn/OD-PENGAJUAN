<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cost Request #</title>
    
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
                <td colspan="5" align="center" style="font-size: 15px;"><b>{{ $pengajuan_biaya_head->nama_perusahaan }}</b></td>
            </tr>
        
            
            <tr class="information">
                <td colspan="1">
                   
                        <tr>
                            <td>
                                No Pengajuan<br>
                                Pengajuan<br>
                                Tgl Pengajuan<br>
                                Kategori<br>
                            </td>
                            
                            <td>
                                : {{ $pengajuan_biaya_head->kode_pengajuan_b }}<br>
                                : {{ $pengajuan_biaya_head->keterangan }} <br>
                                : {{ date('d-M-Y', strtotime($pengajuan_biaya_head->tgl_pengajuan_b)) }}<br>
                                : {{ $pengajuan_biaya_head->sifat }}
                                
                            </td>
                        </tr>
                </td>
            </tr>
        </table>
        <br>
        <table cellpadding="0" cellspacing="0">    
            <tr class="heading">
                <td>No</td>
                <td>Uraian</td>
                <td>Depo</td>
                <td align="right">Jumlah Data</td>
                <td align="right">Total Pengajuan</td>
            </tr>
            {{ $no = 1 }}
            @forelse ($pengajuan_biaya_detail as $row)
            <tr class="detail">
                <td>{{ $no }}</td>                   
                <td>{{ $row->description }}</td>
                <td>{{ $row->spesifikasi }}</td>
                <td align="right">{{ $row->qty }}</td>
                <td align="right">{{ number_format($row->tharga) }}</td>                                    
            </tr>
            {{ $no++ }}
            @empty
            <tr>
                                                
            </tr>
            
            @endforelse
            <tr class="foot">
                <td colspan="4" style="text-align: center;">
                    
                     <strong>Total</strong>  
                  
                </td>
                <td align="right">
                    <strong> Rp {{ number_format($total_jml) }}</strong>
                </td>


            </tr>

        </table>
        <br>
        <br>
        <div class="card">
            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td align="center">
                        Yang Mengajukan,
                    </td>
                    <td colspan="3" align="center">
                        Yang Menyetujui,
                    </td>
                </tr>
                <tr class="detail">
                <td align="center">
                        <br><br><br><br><br>
                        <u>{{ $pengajuan_biaya_head->name }}</u>
                    </td>
                    <td align="center">
                        <br><br>
                        {{ $pengajuan_biaya_head->kode_app_atasan }}
                        <br><br><br>
                        
                        <u>{{ $pengajuan_biaya_head->nama_atasan }}</u>
                    </td>
                    <td align="center">
                        <br><br>
                        APP 0001/PIC-HO/PIC/X/2025
                        <br><br><br>
                        
                        <u>{{ $pengajuan_biaya_head->nama_pic }}</u>
                    </td>
                    <td align="center">
                        <br><br>
                        {{ $pengajuan_biaya_head->kode_app_biaya_pusat }}
                        <br><br><br>
                        
                        <u>{{ $pengajuan_biaya_head->nama_biaya_pusat }}</u>
                    </td>
                </tr>
            </table>
           
        </div>

    </div>
</body>
</html>