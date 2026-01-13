<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Pengajuan</title>
    
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
                <td colspan="5" align="center" style="font-size: 15px;"><b>FORM PENGGANTIAN & PENAMBAHAN BARANG (HO)</b></td>
            </tr>
        
            
            <tr class="information">
                <td colspan="1">
                   
                        <tr>
                            <td>
                                No Pengajuan<br>
                                Lokasi Kerja<br>
                                Nama Pemohon<br>
                                Tgl Pengajuan<br>

                            </td>
                            
                            <td>
                                : {{ $rekap_head->kode_rekap }}<br>
                                : All Depo <br>
                                : Rizka Abdurohman / General Affair <br>
                                : {{ date('d-M-Y', strtotime($rekap_head->tgl_rekap)) }}<br>
                                
                            </td>

                            <td></td>

                            {{-- <td align="center" style="border-style: solid; border-width:1px 1px 1px 1px;">
                                Cara pembayaran:<br>
                                <b style="font-size: 15px;">TUNAI</b><br>
                                User
                            </td>
                            <td align="center" style="border-style: solid; border-width:1px 1px 1px 1px;">
                                Lokasi pembelian:<br>
                                <b style="font-size: 15px;">HO</b><br>
                                User
                            </td> --}}

                        </tr>
                </td>
            </tr>
        </table>
        <br>
        <table cellpadding="0" cellspacing="0">    
            <tr class="heading">
                <td>No</td>
                <td>Nama Asset</td>
                <td>Merk</td>
                <td>Spesifikasi</td>
                <td>Jumlah Kebutuhan</td>
                <td>Harga</td>
                <td>Total Harga</td>
            </tr>
            {{ $no = 1 }}
            @forelse ($rekap_detail as $row)
            <tr class="detail">
                <td>{{ $no }}</td>
                <td>Rekap ATK</td>
                <td>-</td>                   
                <td>-</td>
                <td align="right">-</td>
                <td align="right">{{ number_format($row->total_harga) }}</td>
                <td align="right">{{ number_format($row->total_harga) }}</td>                                    
            </tr>
            {{ $no++ }}
            @empty
            <tr>
                                                
            </tr>
            @endforelse

            <tr class="foot">
                <td colspan="6" style="text-align: center;">
                     <strong>T o t a l</strong>  
                </td>
                <td align="right">
                    <strong>{{ number_format($rekap_total->total) }}</strong>
                </td>
            </tr>

        </table>
        ALASAN PENGAJUAN/PENGGANTIAN BARANG WAJIB DIISI SECARA DETAIL
        <table cellpadding="0" cellspacing="0" border=""> 
               
            <tr class="heading">
                <td>
                    
                        - Pengajuan permintaan barang All Depo <br>

                      
                </td>
                                    
           
            </tr>
        </table>
        <br>
        <div class="card">
            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td colspan="2" align="center" style="width: 200px;">
                        Pemohon
                    </td>
                    <td colspan="2" align="center" style="width: 140px;">
                        Menyetujui
                    </td>
                    {{-- <td colspan="1" align="center" style="width: 120px;">
                        Menyetujui
                    </td> --}}
                    <!-- <td colspan="1" align="center" style="width: 140px;">
                        Mengetahui
                    </td> -->
                    <td colspan="1" align="center">
                        Verifikasi Owner
                    </td>
                </tr>
                <tr class="detail">
                    <td align="center">
                        <span style="color: #ffffff;"></span>
                        {{ date('d-M-Y', strtotime($rekap_head->tgl_rekap)) }}<br>
                        <br><br><br><br><br>
                        <u>(Rizka Abdurohman)</u><br>
                        Yang Mengajukan
                    </td>
                    <td align="center">
                        <span style="color: #ffffff;"></span>
                            {{ date('d-M-Y', strtotime($rekap_head->tgl_rekap)) }}<br>
                            <br><br>
                            {{ $app_ga }}
                            <br><br><br> 
                            <u>(Haris Ali Mufti)</u><br>
                            Kepala General Affair
                        
                    </td>
                    {{-- <td align="center">
                        <span style="color: #ffffff;">-------------------------------</span>
                        {{ date('d-M-Y', strtotime($pengajuan_head->tgl_approval_atasan)) }}<br>
                        <br><br>
                        {{ $pengajuan_head->kode_app_atasan }}
                        <br><br><br> 
                        <u>({{ $pengajuan_head->nama_atasan }})</u><br>
                        K. Div
                    </td> --}}
                    {{-- <td align="center">
                        <span style="color: #ffffff;">--------------------------------------</span>
                            {{ date('d-M-Y', strtotime($rekap_head->tgl_rekap)) }}<br>
                            <br><br>
                            
                            <br><br><br> 
                            <u>(____________)</u><br>
                            Kepala IT
                    </td> --}}
                    <td align="center">
                        <span style="color: #ffffff;"></span>
                            {{ date('d-M-Y', strtotime($rekap_head->tgl_rekap)) }}<br>
                            <br><br>
                            {{ $app_ops }}
                            <br><br><br>
                            <u>(Noldy Tawaang)</u><br>
                            Kepala Operasional
                    </td>
                    <td align="center">
                        <span style="color: #ffffff;"></span>
                         @if($rekap_head->tgl_approval_pc == null)
                            <br>
                        @else
                            {{ date('d-M-Y', strtotime($rekap_head->tgl_approval_pc)) }}<br>
                        @endif
                        <br><br>
                        {{ $rekap_head->kode_approval_pc }}
                        <br><br><br>
                        <u>{{ $rekap_head->name }}</u><br>
                        Kepala Purchasing

                    </td>
                    <!-- <td align="center">
                        <span style="color: #ffffff;">---------------------------------</span>
                        <br><br>
                        {{-- {{ $pengajuan_head->kode_app_pc }}  --}}
                        <br><br><br>
                        Purchasing
                    </td> -->
                    <td align="center">
                        <span style="color: #ffffff;"></span>
                             @if($rekap_head->tgl_approval_pc == null)
                            <br>
                        @else
                            {{ date('d-M-Y', strtotime($rekap_head->tgl_approval_pc)) }}<br>
                        @endif
                            <br><br>
                            {{ $rekap_head->kode_approval_pc }}
                            <br><br><br>
                            <u>(a.n. Yani)</u><br>
                            Owner
                    </td>
                </tr>
            </table>
           
        </div>

        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="1">
                   
                    <tr>
                        <td>
                            NB: Untuk penggantian/penambahan barang yang berkaitan dengan IT akan ada verifikasi dari pihak IT. <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Pengajuan yang tidak sesuai dengan format GA tidak akan diproses. <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Pengajuan penambahan/perbaikan barang wajib melampirkan foto. <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Pengajuan pembelian barang di Depo wajib melampirkan foto, kwitansi cap basah/foto saat transaksi pembelian.
                        </td>
                    </tr>
                </td>
            </tr>
        </table>

      

    </div>
</body>
</html>