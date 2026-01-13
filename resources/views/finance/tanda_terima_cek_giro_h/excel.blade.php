@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Penerimaan Buku.xls");
@endphp
    
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
        background: rgb(195, 195, 193);
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


<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="7">
                    <table>
                        <tr>
                            <td style="width: 30%;">
                                <!-- Tangggal: <br> -->
                                <!-- No PO     : <br> -->
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>No</td>
                <td>No Cek/Giro/Slip</td>
                <td>Tgl Izin</td>
                <td>No Izin</td>
                <td>Perusahaan</td>
                <td>Bank</td>
                <td>No Rekening</td>
                <td>Yang Membuat</td>
                <td>Tgl Resi Keluar</td>
                <td>Tgl Terima</td>
                <td>Yang Mengambil</td>
            </tr>
            <?php $no = 1; ?>
            @forelse ($detail as $row)
            <tr>
                <td>{{ $no }}</td>                          
                <td>{{ $row->id_cek }}</td>
                <td>{{ $row->tgl_izin }}</td>
                <td>{{ $row->no_izin }}</td>
                <td>{{ $row->nama_perusahaan }}</td>
                <td>{{ $row->nama_bank }}</td>
                <td align="right">{{ $row->no_rekening }}</td>
                <td>{{ $row->name }}</td>
                <td></td>
                <td>{{ $row->tgl_izin }}</td>
                <td>{{ $row->pembawa_resi }}</td>                                 
            </tr>
            <?php $no++ ?>
            @empty
            <tr>
                                                
            </tr>
            @endforelse
                    
        </table>
    </div>
</body>