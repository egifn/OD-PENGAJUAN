<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order #{{ $po_head->part_purchase_order_h_code }}</title>
    
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
        border-bottom: 1px solid #eee;;
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
                <td colspan="10">
                    <table>
                        <tr>
                            <td class="title" align="right">
                                Purchase Order: {{ $po_head->part_purchase_order_h_code }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="10">
                    <table>
                        <tr>
                            <td>
                                Purchase Request : {{ $po_head->part_purchase_order_reqcode }}<br>
                                Date             : {{ $po_head->part_purchase_order_date }}<br>
                                Operator         : {{ $po_head->part_purchase_order_operator }}<br>
                                Client           :  
                            </td>
                            
                            <td>
                                Supplier         : {{ $po_head->supp_desc }}<br>
                                Manager          : {{ $po_head->mgr }}<br>
                                Approved         : {{ $po_head->Appoved }}<br>
                                Code             : {{ $group_vendor->kelompok }}-{{ $group_vendor->sub_kelompok }}{{ $kode_urut }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>No</td>
                <td>Sparepart</td>
                <td>Part Desc</td>
                <td>Part Standard</td>
                <td>Part Name</td>
                <td>S/N</td>
                <td>Stock</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Total Price</td>
            </tr>

            @php $no = 1; @endphp
            @forelse ($po_detail as $row)
            <tr class="detail">
                                                    
                <td>{{ $no++ }}</td>
                <td>{{ $row->part_purchase_order_part_code }}</td>
                <td>{{ $row->part_desc}}</td>
                <td>{{ $row->partstandard_Desc }}</td>
                <td>{{ $row->partname_desc }}</td>
                <td>{{ $row->part_sn }}</td>
                <td align="right">0</td>
                <td align="right">{{ number_format($row->part_purchase_order_qty) }}</td>
                <td align="right">Rp.{{ number_format($row->part_purchase_order_price) }}</td>
                <td align="right">Rp.{{ number_format($row->part_purchase_order_qty * $row->part_purchase_order_price) }}</td>
                              
            </tr>
            @empty
            <tr>
                                                
            </tr>
            @endforelse
           
            <tr class="foot">
               
                    
                        <td colspan="8" align="center">
                            <strong>TOTAL
                             </strong>
                        </td>
                        
                  
                
                   
                        <td colspan="2" align="right">
                            <strong>Rp.{{ number_format($po_total->total_price) }}</strong>
                        </td>
                        
               
               
            </tr>
            
            <tr >
                <td colspan="3">
                    <table>
                        <td align="center">
                            Operator
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <u>{{ $po_head->part_purchase_order_operator }}</u>
                        </td>

                   </table>
                </td>
                <td colspan="4">
                    <table>
                        <td align="center">
                            Manager
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <u>{{ $po_head->mgr }}</u>
                        </td>
                        
                   </table>
                </td>
                <td colspan="3">
                    <table>
                        <td align="center">
                            PIC
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <u>{{ $po_head->Appoved }}</u>
                        </td>
                        
                   </table>
                </td>
            </tr>
            
        </table>

        
        Print User: &nbsp;&nbsp; {{ $po_head->part_purchase_order_operator }}<br>
        Print Date: &nbsp;&nbsp; 
    </div>
</body>
</html>