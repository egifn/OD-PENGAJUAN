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
        <table>
            <tr>
                
                
                <td ><img src="{{ ('TUA.jpg') }}" style="width: 80px; height: 40px" ></td>
                
                <td >
                    <div >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b><font size="5">PT. Tirta Utama Abadi</font></b><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Jl. Soekarno Hatta No. 608, Sekejati, Kec. Buahbatu</b><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>Kota Bandung, Jawa Barat 40286</b>
                  </div>
                </td> 
            </tr>
        </table>

        <hr>

        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5" align="center" style="font-size: 15px;"><b>BUKTI PENGELUARAN ATK</b></td>
            </tr>
        
            
            <tr class="information">
                <td colspan="1">
                   
                        <tr>
                            <td>
                                Tgl Pengajuan<br>
                                Depo<br>
                                Penerima<br>
                                Periode<br>
                                Deskripsi<br>
                                No Bukti Terima<br>
                                
                            </td>
                            
                            <td>
                                : {{ date('d-M-Y', strtotime($pengajuan_head->tgl_terima)) }}<br>
                                : {{ $pengajuan_head->nama_depo }} <br>
                                : {{ $pengajuan_head->penerima }}<br>
                                : {{ date('M', strtotime($pengajuan_head->tgl_pengajuan)) }}<br>
                                : LIST ATK ACC <br>
                                : {{ $pengajuan_head->no_bkb_user }} <br>
                                
                                
                                
                                
                            </td>
                        </tr>
                </td>
            </tr>
        </table>
        <br>
        <table cellpadding="0" cellspacing="0">    
            <tr class="heading">
                <td>No</td>
                <td>Item</td>
                <td>Unit</td>
                <td>Qty</td>
                <td>Note</td>
            </tr>
            {{ $no = 1 }}
            @forelse ($pengajuan_detail as $row)
            <tr class="detail">
                <td>{{ $no }}</td>
                <td style="width: 250px;">{{ $row->nama_barang }}</td>
                <td>{{ $row->satuan }}</td>
                <td align="right">{{ $row->qty_ga }}</td>
                <td style="width: 250px;"></td>                                  
            </tr>
            {{ $no++ }}
            @empty
            <tr>
                                                
            </tr>
            
            @endforelse
            {{-- <tr class="foot">
                <td colspan="6" style="text-align: center;">
                    
                     <strong>Total</strong>  
                  
                </td>
                <td align="right">
                    <strong> Rp {{ number_format($total_jml) }}</strong>
                </td>


            </tr> --}}

        </table>
        <br>
        <div class="card">
            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td colspan="1" align="center" style="width: 120px;">
                        Approval GA
                    </td>
                    <td colspan="1" align="center" style="width: 140px;">
                        Checker
                    </td>
                    <td colspan="1" align="center" style="width: 120px;">
                        Penerima
                    </td>
                    
                </tr>
                <tr class="detail">
                    <td align="center">
                        <span style="color: #ffffff;">-----------------------------</span>
                        <br><br>
                        
                        <br><br><br>
                        General Affair
                    </td>

                    <td align="center">
                        <span style="color: #ffffff;">-------------------------------</span>
                        <br><br>
                        
                        <br><br><br>
                        
                    </td>

                    <td align="center">
                        <span style="color: #ffffff;">-------------------------------</span>
                        <br><br><br><br><br>
                        {{ $pengajuan_head->penerima }}
                    </td>
                    
                    
                </tr>
            </table>
           
        </div>

        

      

    </div>
</body>
</html>