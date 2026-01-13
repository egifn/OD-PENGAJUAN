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
                                : {{ $pengajuan_head->kode_pengajuan }}<br>
                                : {{ $pengajuan_head->kode_perusahaan }} {{ $pengajuan_head->nama_depo }} <br>
                                : {{ $pengajuan_head->name }} / {{ $pengajuan_head->nama_divisi }} <br>
                                : {{ date('d-M-Y', strtotime($pengajuan_head->tgl_pengajuan)) }}<br>
                                
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
                <td>Estimasi Harga Satuan</td>
                <td>Total Harga</td>
            </tr>
            {{ $no = 1 }}
            @forelse ($pengajuan_detail as $row)
            <tr class="detail">
                <td>{{ $no }}</td>
                <td>{{ $row->nama_barang }}</td>
                <td>{{ $row->merk }}</td>                   
                <td>{{ $row->ket}}</td>
                <td align="right">{{ $row->qty }}</td>
                <td align="right">{{ number_format($row->price) }}</td>
                <td align="right">{{ number_format($row->qty * $row->price) }}</td>                                    
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
                    <strong>{{ number_format($total_jml->total) }}</strong>
                </td>
            </tr>

        </table>
        ALASAN PENGAJUAN/PENGGANTIAN BARANG WAJIB DIISI SECARA DETAIL
        <table cellpadding="0" cellspacing="0" border=""> 
               
            <tr class="heading">
                <td>
                    @forelse ($pengajuan_detail as $row)
                        - {{ $row->description }} <br>

                    @empty
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    @endforelse  
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
                    <td colspan="3" align="center" style="width: 140px;">
                        Menyetujui
                    </td>
                    <!-- <td colspan="1" align="center" style="width: 120px;">
                        Menyetujui
                    </td> -->
                    <!-- <td colspan="1" align="center" style="width: 140px;">
                        Mengetahui
                    </td> -->
                    <td colspan="1" align="center">
                        Verifikasi Owner
                    </td>
                </tr>
                <tr class="detail">
                    <td align="center">
                        <span style="color: #ffffff;">------------------------------------</span>
                        {{ date('d-M-Y', strtotime($pengajuan_head->tgl_pengajuan)) }}<br>
                        <br><br><br><br><br>
                        <u>({{ $pengajuan_head->name }})</u><br>
                        Yang Mengajukan
                    </td>
                    <td align="center">
                        @if($pengajuan_head->id_user_approval_atasan != null)
                            <span style="color: #ffffff;">------------------------------------------------</span>
                            {{ date('d-M-Y', strtotime($pengajuan_head->tgl_approval_atasan)) }}<br>
                            <br><br>
                            {{ $pengajuan_head->kode_app_atasan }}
                            <br><br><br> 
                            <u>({{ $pengajuan_head->nama_atasan }})</u><br>
                            @if($pengajuan_head->kode_depo == '002' || $pengajuan_head->kode_depo == '003' || $pengajuan_head->kode_depo == '004' || $pengajuan_head->kode_depo == '006' || $pengajuan_head->kode_depo == '007' )
                                Kepala Divisi
                            @else
                                 @if(Auth::user()->kode_divisi == '10')
                                    Kepala Divisi
                                 @else
                                    Operasional Depo
                                 @endif
                                
                            @endif
                        @else
                            <span style="color: #ffffff;">--------------------------------------------------</span>
                            <br><br><br><br><br><br><br><br>
                            <u>(____________)</u><br>
                            @if($pengajuan_head->kode_depo == '002' || $pengajuan_head->kode_depo == '003' || $pengajuan_head->kode_depo == '004' || $pengajuan_head->kode_depo == '006' || $pengajuan_head->kode_depo == '007' )
                                Kepala Divisi
                            @else
                                 @if(Auth::user()->kode_divisi == '10')
                                    Kepala Divisi
                                 @else
                                    Operasional Depo
                                 @endif
                                
                            @endif
                        @endif
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
                    <td align="center">
                        @if($pengajuan_head->id_user_approval_it != null)
                            <span style="color: #ffffff;">----------------------------------------</span>
                            {{ date('d-M-Y', strtotime($pengajuan_head->tgl_approval_it)) }}<br>
                            <br><br>
                            {{ $pengajuan_head->kode_app_it }}
                            <br><br><br> 
                            <u>({{ $pengajuan_head->nama_atasan_it }})</u><br>
                            Kepala IT
                        @else
                            <span style="color: #ffffff;">--------------------------------------------</span>
                            <br><br><br><br><br><br><br>
                            <u>(____________)</u><br>
                            Kepala IT
                        @endif
                    </td>
                    <td align="center">
                        @if($pengajuan_head->id_user_approval_ops != null)
                            <span style="color: #ffffff;">---------------------------------------------------</span>
                            {{ date('d-M-Y', strtotime($pengajuan_head->tgl_approval_ops)) }}<br>
                            <br><br>
                            {{ $pengajuan_head->kode_app_ops }} 
                            <br><br><br>
                            <u>({{ $pengajuan_head->nama_atasan_ops }})</u><br>
                            Kepala Operasional HO
                        @else
                            <span style="color: #ffffff;">-------------------------------------------------------</span>
                            <br><br><br><br><br><br><br><br>
                            <u>(____________)</u><br>
                            Kepala Operasional HO
                        @endif
                    </td>
                    <td align="center">
						@if($pengajuan_head->id_user_approval_ga != null)
                            <span style="color: #ffffff;">----------------------------------------------</span>
                            {{ date('d-M-Y', strtotime($pengajuan_head->tgl_approval_ga)) }}<br>
                            <br><br>
                            {{ $pengajuan_head->kode_app_ga }} 
                            <br><br><br>
                            <u>({{ $pengajuan_head->nama_atasan_ga }})</u><br>
                            Kepala General Affair
                        @else
                            <span style="color: #ffffff;">------------------------------------------------</span>
                            <br><br><br><br><br><br><br><br>
                            <u>(____________)</u><br>
                            Kepala General Affair    
                        @endif
                    </td>
                    <!-- <td align="center">
                        <span style="color: #ffffff;">---------------------------------</span>
                        <br><br>
                        {{-- {{ $pengajuan_head->kode_app_pc }}  --}}
                        <br><br><br>
                        Purchasing
                    </td> -->
                    <td align="center">
                        @if($pengajuan_head->id_user_approval_pc != null)
                            <span style="color: #ffffff;">-----------------------------------</span>
                            {{ date('d-M-Y', strtotime($pengajuan_head->tgl_approval_pc)) }}<br>
                            <br><br>
                            {{-- {{ $pengajuan_head->kode_app_bod }}  --}}
                            {{ $pengajuan_head->kode_app_pc }} 
                            <br><br><br>
                            <u>(a.n. {{ $pengajuan_head->nama_atasan_pc }})</u><br>
                            Owner
                        @else
                            <span style="color: #ffffff;">---------------------------------------</span>
                            <br><br><br><br><br><br><br>
                            <u>(____________)</u><br>
                            Owner
                        @endif
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