<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order #{{ $pembelian_v->kode_pembelian }}</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 10px;
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
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: yellow;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(1) {
        border-top: 1px solid #eee;
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
            <tr class="top">
                <td colspan="7">
                    <table>
                        <tr>
                            <td style="width: 30%; font-weight: bold; font-size: 15px; color: blue;">
                                {{ $pembelian_v->nama_perusahaan }}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="font-weight: bold; font-size: 15px;">
                                <u>Purchase Order</u>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="7">
                    <table>
                        <tr>
                            <td style="width: 30%;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                            <td>
                                Date: {{ $pembelian_v->tgl_pembelian }}<br>
                                P.O : {{ $pembelian_v->kode_pembelian }}<br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">
                                To : <b>{{ $pembelian_v->nama_vendor }}</b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $pembelian_v->alamat }}<br>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="width: 30%;">
                               No REK : {{ $pembelian_v->norek }}<br>
                               ({{ $pembelian_v->nama_bank }})  ({{ $pembelian_v->nama_vendor }})
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">
                                Attn : {{ $pembelian_v->contact_person }} <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $pembelian_v->telp }}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
           
            <tr>
                <td colspan="3"><b>Shipping Invoice:</b></td> 
                <td colspan="2">Delivery Date</td> 
                <td colspan="2" align="right">TOP</td>
            </tr>
            <tr>
                <td colspan="3">Address Jl Soekarno Hatta No 608</td> 
                <td colspan="2">ASAP</td> 
                <td colspan="2" align="right">{{ $pembelian_v->top }}</td>
            </tr>

            <tr class="heading">
                <td>No</td>
                <td>Item</td>
                <td>Qty</td>
                <td>Satuan</td>
                <td>Spesifikasi</td>
                <td>Harga</td>
                <td>Total</td>
                
            </tr>
            <?php $no = 1; ?>
            @forelse ($detail as $row)
            <tr>
                <td>{{ $no }}</td>                          
                <td>{{ $row->nama_barang }}</td>
                <td>{{ $row->qty_po }}</td>
                <td></td>
                <td>{{ $row->ket }}</td>
                <td>{{ number_format($row->harga_satuan) }}</td>
                <td>{{ number_format($row->harga_total) }}</td>
                                                    
            </tr>
            <?php $no++ ?>
            @empty
            <tr>
                                                
            </tr>
            @endforelse
            

            <tr class="total">
                <td colspan="7">
                    <table>
                        <td align="right" style="width: 50%;">Total</td>
                        <td align="right" style="background: rgb(167, 241, 194);">
                            <strong>Rp {{ number_format($total_jml) }} </strong>
                        </td>
                   </table>
                </td>
            </tr>
            
            
            <br>
            <br>

            <tr>
                <td colspan="7">
                    <table>
                        <tr>
                            <td style="width: 30%;">
                                Dibuat Oleh
                            </td>
                            
                            
                            
                            <td >
                               Disetujui Oleh
                            </td>
                        </tr>
                        
						<tr>
							<td></td>
						</tr>
						
						<tr>
							<td></td>
						</tr>
						
						<tr>
							<td></td>
						</tr>
                        
						<tr>
                            <td>
                                <b>{{ $pembelian_v->name }}</b>
                            </td>
                            
                            <td>
                               <b>Ibu Yani</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            
        </table>
    </div>
</body>
</html>