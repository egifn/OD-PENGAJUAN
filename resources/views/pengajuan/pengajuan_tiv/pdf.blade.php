<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengajuan TIV #</title>
    
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
            <tr class="information">
                <td colspan="2">
                    <table>

                        <tr>
                            <td>
                                KATEGORI<br>
                                NO SERI<br>
                                Nama Pemohon<br>
                                Divisi<br>
                                Tanda Tangan Pemohon<br>
                                <br><br><br><br>
                                Tgl Permintaan<br>
                                Permintaan<br>
                                Persetujuan Atasan<br>
                                Tanda tangan<br>
                                <br><br><br><br>
                            </td>
                            
                            <td width="450">
                                : {{ $pengajuan_tiv_head->sifat }}<br>
                                : {{ $pengajuan_tiv_head->kode_pengajuan_b }}<br>
                                : {{ $pengajuan_tiv_head->name }}<br>
                                : {{ $pengajuan_tiv_head->nama_divisi }}<br>
                                : <br><br><br><br>
                                : ({{ $pengajuan_tiv_head->name }})<br>
                                : {{ $pengajuan_tiv_head->tgl_pengajuan_b }}<br>
                                : {{ $pengajuan_tiv_head->keterangan }} <br>
                                : {{ $pengajuan_tiv_head->kepala_divisi }}<br>
                                : <br><br><br>
                                : ({{ $pengajuan_tiv_head->kepala_divisi }})<br>
                                  <br> 
                                
                            </td>
                            <td>
                                <br>
                                <br>
                                <br>
                                Mengetahui<br>
                                <br>
                                <br>
                                <br>
                                <br><br>
                                Jeisni La Sesa P
                                <br>
                                Koord. Claim
                                <br> 
                                <br>
                                <br>
                                <br>
                                <br><br><br>
                                <br>
                                <br> 
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0">     
            <tr class="heading">
                <td>Area</td>
                <td>Nama Toko</td>
                <td>No Rekening</td>
                <td>Bank</td>
                <td>Pemilik Rek</td>
                <td align="right">Qty</td>
                <td align="right">Total Reward</td>
                <td align="right">Potongan</td>
                <td align="right">Ditransfer</td>
            </tr>

            @forelse ($data_view_program_all as $row)
            <tr class="detail">                   
                <td>{{ $row->dist_depo }}</td>
                <td>{{ $row->customer_name }}</td>
                <td>{{ $row->no_rek }}</td>
                <td>{{ $row->bank }}</td>
                <td>{{ $row->nama_rekening }}</td>
                <td align="right"></td>
                <td align="right">{{ number_format($row->reward_tiv) }}</td>
                <td align="right">{{ number_format($row->potongan) }}</td>   
                <td align="right">{{ number_format($row->ditransfer) }} </td>                                 
            </tr>
            @empty
            <tr>
                                                
            </tr>
            @endforelse

            
            

            <tr class="foot">
                <td colspan="5" style="text-align: center;">
                    
                     <strong>Total</strong>  
                  
                </td>
                <td align="right">
                    {{-- <strong>{{ $total_jml->qty }}</strong> --}}
                </td>
                <td align="right">
                    <strong>{{ number_format($total_jml->harga) }}</strong>
                </td>
                <td align="right">
                    <strong>{{ number_format($total_jml->potongan) }}</strong>
                </td>
                <td align="right">
                    <strong>{{ number_format($total_jml->ditransfer) }}</strong>
                </td>
            </tr>
        </table>
        
        <br>
        Persetujuan dari Keuangan Pusat &nbsp;: Linna Noviarti 
        <br>
        <br>
        <br>
        Tanda tangan 

    </div>
</body>
</html>