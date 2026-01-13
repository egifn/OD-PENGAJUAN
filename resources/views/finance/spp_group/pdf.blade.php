<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>SPP</title>

    
</head>

<body>
@foreach($spp_pdf->chunk(2) as $chunk)
    
            @foreach($chunk as $spp_pdf)
            <table border="1" cellspacing="0" width="700px" style="font-size:13px;">
                <thead>
                    <tr>
                        <th align="left" colspan="2" style="font-size: 17px; font-weight: bold; color: #003366;">SURAT PERINTAH PEMBAYARAN</th>
                        <th style="font-size: 17px; font-weight: bold; color: #003366;" align="right">NO:</th>
                        <th colspan="2" style="font-size: 17px; font-weight: bold; color: #f02323ff;">{{ $spp_pdf->no_spp }}</th>
                    </tr>
                    <tr>
                        <td>Tanggal SPP</td>
                        <td colspan="4">{{ date('d-M-Y', strtotime($spp_pdf->tgl_spp)) }}</td>


                    </tr>
                    <tr>
                        <td>Tgl Jatuh Tempo</td>
                        <td colspan="4">{{ date('d-M-Y', strtotime($spp_pdf->jatuh_tempo)) }}</td>
                        <!-- <td>Ditujukan Kepada</td>
                        <td colspan="4">{{ $spp_pdf->ditujukan }}</td> -->
                    </tr>
                    <tr>
                        <td>Tujuan Pembayaran</td>
                        <td colspan="4">
                            {{ $spp_pdf->kode_vendor }} &nbsp;&nbsp; {{ $spp_pdf->for }}<br> 
                            <!-- @if ($spp_pdf->pembayaran == '-')
                                Bank {{ $spp_pdf->nama_bank }} &nbsp;&nbsp; no. 06 &nbsp;&nbsp; a.n {{ $spp_pdf->yang_mengajukan }}
                            @else
                                Bank {{ $spp_pdf->nama_bank }} &nbsp;&nbsp; no. {{ $spp_pdf->pembayaran }} &nbsp;&nbsp; a.n {{ $spp_pdf->atas_nama }}
                            @endif -->
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah yang dibayarkan</td>
                        <td colspan="4">
                            <span style="color: #003366; font-weight: bold; font-size: 15px;">
                                Rp. {{ number_format($spp_pdf->jumlah) }}
                            </span>
                            <br> <b><i>( {{terbilang($spp_pdf->jumlah) }} rupiah )</i></b>
                        </td>
                    </tr>
                    <tr>
                        <td>Keterangan Pembayaran</td>
                        <td colspan="4">{{ $spp_pdf->keterangan }}</td>
                    </tr>
                    <!-- <tr>
                        <td>Metode pembayaran</td>
                        <td colspan="4">{{ $spp_pdf->metode_pembayaran }}</td>
                    </tr> -->
                    <tr>
                        <td>Bank tujuan</td>
                        <td colspan="4">
                            <span style="color: #003366; font-weight: bold; font-size: 13px;">
                                @if ($spp_pdf->pembayaran == '-')
                                    {{ $spp_pdf->nama_bank }} 
                                @else
                                    {{ $spp_pdf->nama_bank }}
                                @endif    
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>No Rekening tujuan</td>
                        <td colspan="4">
                            <span style="color: #003366; font-weight: bold; font-size: 13px;">
                                @if ($spp_pdf->pembayaran == '-')
                                06
                                @else
                                    {{ $spp_pdf->pembayaran }}
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Atas nama</td>
                        <td colspan="4">
                            <span style="color: #003366; font-weight: bold; font-size: 13px;">
                                @if ($spp_pdf->pembayaran == '-')
                                    @if ($spp_detail->kode_vendor == 'PCBDG 2')
                                        Ibu Yani
                                    @else
                                        {{ $spp_detail->yang_mengajukan }}
                                    @endif
                                @else
                                    {{ $spp_pdf->atas_nama }}
                                @endif    
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td align="center">Yang Mengajukan</td>
                        <td align="center">Yang Membuat</td>
                        <td align="center" colspan="2">Mengetahui</td>
                        <td align="center">Menyetujui</td>
                    </tr>
                    <tr>
                    <td height="80px" VALIGN="BOTTOM" align="center">
                            @if ($spp_pdf->tgl_pengajuan_b == '')
                                {{ $spp_pdf->tgl_pengajuan_b }}
                            @else
                                {{ date('d-M-Y', strtotime($spp_pdf->tgl_pengajuan_b)) }}
                            @endif
                            <br>  
                            <br>
                            <i style="font-size: 10px">{{ $spp_pdf->no_kontrabon }}</i>
                            <br>
                            <br>
                            {{ $spp_pdf->yang_mengajukan }}
                        </td>
                        <td height="80px" VALIGN="BOTTOM" align="center">
                            @if ($spp_pdf->tgl_spp == '')
                                {{ $spp_pdf->tgl_spp }}
                            @else
                                {{ date('d-M-Y', strtotime($spp_pdf->tgl_spp)) }}
                            @endif
                            <br>
                            <br>
                            <i style="font-size: 10px">{{ $spp_pdf->kode_user_input_spp }}</i>
                            <br>
                            <br>
                            {{ $spp_pdf->name }}
                        </td>
                        <td height="80px" VALIGN="BOTTOM" colspan="2" align="center">
                            @if ($spp_pdf->tgl_approval_spp_1 == '')
                                {{ $spp_pdf->tgl_approval_spp_1 }}
                            @else
                                {{ date('d-M-Y', strtotime($spp_pdf->tgl_approval_spp_1)) }}
                            @endif
                            <br>
                            <br>
                            <i style="font-size: 10px">{{ $spp_pdf->kode_approved_spp_1 }}</i>
                            <br>
                            <br>
                            {{ $spp_pdf->ka_biaya }}
                        </td>
                        <td height="80px" VALIGN="BOTTOM" align="center">
                            @if ($spp_pdf->tgl_approval_spp_2 == '')
                                {{ $spp_pdf->tgl_approval_spp_2 }}
                            @else
                                {{ date('d-M-Y', strtotime($spp_pdf->tgl_approval_spp_2)) }}
                            @endif
                            <i style="font-size: 10px">{{ $spp_pdf->kode_approved_spp_2 }}</i>
                            <br>
                            <br>
                            {{ $spp_pdf->ka_acc }}
                        </td>
                    </tr>
                    <tr>
                        <td align="center"></td>
                        <td align="center">Accounting</td>
                        <td align="center" colspan="2">Ka. Biaya Pusat</td>
                        <td align="center">PJS. Ka. Accounting</td>
                    </tr>
                </thead>
                
            </table>
            
            <table border="0" cellspacing="0" width="700px" style="font-size:13px;">
                <thead>
                    
                    <tr>
                        <td style="font-style: bold;">Dicetak: {{ $tgl_cetak }}</td>  
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
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    {{-- <tr>
                        <td style="font-style: italic;">
                        Ket: {{ $sd_1->sumber_dana }} = {{ $sd_1->keterangan }}, {{ $sd_2->sumber_dana }} = {{ $sd_2->keterangan }}, {{ $sd_3->sumber_dana }} = {{ $sd_3->keterangan }}, {{ $sd_4->sumber_dana }} = {{ $sd_4->keterangan }}.
                        </td>             
                    </tr> --}}
                </thead>
            </table>
            <br>
            <br>
            <br>
            
            @endforeach
    
    @if(!$loop->last)
        <div style="page-break-after: always;"></div>
    @endif

@endforeach
    
  
</body>
</html>