<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Permission</title>
    
    <style>
    .invoice-box {
        max-width: 1100px;
        margin: auto;
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
        padding-bottom: 10px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 12px;
        line-height: 5px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 20px;
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
                <td colspan="12">
                    <table>
                        <tr>
                            <td class="title">
                                {{ $tanda_terima_head->keterangan }} 
                            </td>

                            <td class="title" align="right">
                                {{ $tanda_terima_head->keterangan_id }} 
                            </td>
                        </tr>
                        <tr colspan="10">
                            <td class="title" align="right">
                                Bandung 
                            </td>

                            <td class="title" align="right">
                                {{ $tanda_terima_head->date_receipt }} 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            
            <tr class="heading">
                <td rowspan="2" style="vertical-align: middle;">No</td>
                <td rowspan="2" style="vertical-align: middle;">Jenis Pengeluaran</td>
                <td rowspan="2" style="vertical-align: middle;">Nominal Cek/giro</td>
                <td rowspan="2" style="vertical-align: middle;">No Cek/giro</td>
                <td rowspan="2" style="vertical-align: middle;">Tgl Cek/giro</td>
                <td colspan="3" style="text-align: center;">Sumber Dana</td>
                <td colspan="4" style="text-align: center;">Tujuan Cek/giro</td>
                <tr class="heading">
                	<td>Perusahaan</td>
                	<td>Bank</td>
                	<td>No. Rek</td>
                	<td>Vendor</td>
                	<td>Nama Rek</td>
                	<td>Bank</td>
                	<td>No. Rek</td>	
                </tr>
            </tr>

           	@php $no = 1; @endphp
            @forelse ($tanda_terima_detail as $row)
            <tr class="detail">
                                                    
                <td>{{ $no++ }}</td>
                <td>{{ $row->jenis_pengeluaran }}</td>
                <td align="right">{{ number_format($row->total) }}</td>
                <td>{{ $row->cek_giro }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->kd_perusahaan }}</td>
                <td>{{ $row->bank}}</td>
                <td>{{ $row->norek_perusahaan }}</td>
                <td>{{ $row->vendor }}</td>
                <td>{{ $row->atas_nama }}</td>
                <td>{{ $row->bank_vendor }}</td>
                <td>{{ $row->norek_vendor }}</td>
            </tr>
            @empty
            <tr>
                                                
            </tr>
            @endforelse
           
            <tr class="foot">
                <td colspan="2" style="text-align: center;">
                    <strong>TOTAL</strong>
                </td>
                        
                <td colspan="1" style="text-align: right;">
                    <strong>{{ number_format($total_jml) }}</strong>
                </td>

                <td colspan="9" style="text-align: left;">
                    <strong>Total pemakaian cek/giro: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $count }}</strong>
                </td>

                <tr class="foot">
                	<td colspan="3" align="center">
                        Yang membuat,
                	</td>
                	<td colspan="3" align="center">
                        Mengetahui,
                	</td>
                	<td colspan="3" align="center">
                        Mengetahui,
                    </td>
                	<td colspan="3" align="center">
                        Menyetujui,
                	</td>
            	</tr>
            	<tr class="foot">
                	<td colspan="3" align="center">
                       
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <u></u>
                	</td>
                	<td colspan="3" align="center">
                       
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <u></u>
                	</td>
                	<td colspan="3" align="center">
                        
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <u></u>
                    </td>
                	<td colspan="3" align="center">
                       
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <u></u>  
                	</td>
            	</tr>
            	<tr class="foot">
            		<td colspan="6" align="center">
            			Tanda terima pengambilan cek,
            		</td>
            		<td colspan="6" rowspan="3" align="center">
            			
            		</td>
            		
            	</tr>
            	<tr class="foot">
            		<td colspan="3" align="center">
                        Yang menyerahkan,
                	</td>
                	<td colspan="3" align="center">
                        Yang Menerima,
                	</td>
            	</tr>
            	<tr class="foot">
            		<td colspan="3" align="center">
                       
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <u></u>
                	</td>
                	<td colspan="3" align="center">
                       
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <u></u>
                	</td>
            	</tr>
            </tr>
            
            
            
        </table>
    </div>
</body>
</html>