<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Part Kontrabon #{{ $kontra_print_head->no_kontrabon }}</title>
    
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
        font-size: 12px;
        line-height: 5px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
        font-size: 12px;
        line-height: 20px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
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
                            <td class="title" align="center">
                                <strong>PART CONTRABON: {{ $kontra_print_head->no_kontrabon }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="7">
                    <table>
                        <tr>
                            <td>
                                Operator : {{ $kontra_print_head->name }}<br>
                                Sender: - <br>
                                Date: {{ $kontra_print_head->tgl_kontrabon }} 
                            </td>
                            
                            <td>
                                Supplier: {{ $kontra_print_head->nama_vendor }}<br>
                                Total Value: Rp.{{ number_format($kontra_print_head->total) }}<br>
                                Company: -
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>No</td>
                <td>No Bon</td>
                <td>Receiver</td>
                <td>No Transaksi</td>
                <td>Price Retur</td>
                <td>Qty Retur</td>
                <td>Total Price</td>
                
            </tr>

            @forelse ($kontra_print_detail as $row)
            <tr>
                                                    
                <td></td>
                <td>{{ $row->no_faktur }}</td>
                <td></td>
                <td>{{ $row->no_transaksi }}</td>
                <td></td>
                <td></td>
                <td>Rp. {{ number_format($row->total_faktur) }}</td>
                                                    
            </tr>
            @empty
            <tr>
                                                
            </tr>
            @endforelse
            

            <tr class="total">
                <td colspan="7">
                    <table>
                        <td align="right">
                            <strong>TOTAL:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             Rp. {{ number_format($kontra_print_head->total) }}</strong>
                        </td>
                        
                   </table>

                </td>
            </tr>
            
            

            
        </table>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        Operator
        <br>
        <br>
        
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        {{ $kontra_print_head->name }}
        <br>
        Print User: &nbsp;&nbsp; {{ $kontra_print_head->name }}<br>
        Print Date: &nbsp;&nbsp; {{ $kontra_print_head->tgl_kontrabon }}
    </div>
</body>
</html>