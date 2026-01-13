<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>

<body>

    <table>
        <tr>
            <td width="420" align="center">
                <br>
                <b>{{ $header->judul_izin_e }}</b>
            </td>
            <td width="10">
                <div>
                    
                </div>
            </td>
            <td>
                <b>{{ $header->no_izin_e }}</b><br>
                <b>{{ date('d-M-y', strtotime($header->tgl_izin_e)) }}</b>    
            </td> 
        </tr>
        <tr>
            <td colspan="3">
                
            </td>
        </tr>
    </table>
   
    <table>
        
    </table>
    
    <table border='1' style="border-collapse: collapse; border-color: black; width: 100%; font-size: 13px" >
        <thead>
            <tr>
                <th>No</th>
                <th>No Cek/BG/Slip</th>
                <th>Jml Cek/BG/Slip</th>
                <th>Perusahaan</th>
                <th>Bank</th>
                <th>No Rekening</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse($detail as $val)
            <tr>
                <td align="right">{{ $no++}} &nbsp;</td>
                <td>&nbsp; {{ $val->seri_awal }} - {{ $val->seri_akhir }}</td>
                <td align="right">{{ $val->total_cek }} Lembar &nbsp; </td>
                <td>&nbsp; {{ $val->nama_perusahaan }}</td>
                <td>&nbsp; {{ $val->nama_bank }}</td>
                <td>&nbsp; {{ $val->no_rekening }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data untuk saat ini</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="1"></td>
                <td align="center"><b>Total Cek/Giro/Slip:</b></td>
                <td align="right"><b>{{ $total_jml->total }}</b> Lembar &nbsp;</td>
                <td colspan="3"></td> 
            </tr>
            <tr>
                <td colspan="2" align="center">Yang membuat,</td>
                <td colspan="2" align="center">Yang mengajukan,</td>
                <td colspan="2" align="center">Menyetujui,</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    {{ date('d-M-Y', strtotime($header->tgl_izin_e)) }} 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="2" align="center">
                    <!-- @if($header->tgl_approval == null) -->
                        <br>
                    <!-- @else
                        {{ date('d-M-Y', strtotime($header->tgl_approval)) }}
                    @endif -->
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="2" align="center">
                    @if($header->tgl_approval == null)
                        <br>
                    @else
                        {{ date('d-M-Y', strtotime($header->tgl_approval)) }}
                    @endif
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">{{ $header->name }}</td>
                <td colspan="2" align="center"></td>
                <td colspan="2" align="center">{{ $header->approval }}</td>
            </tr>
        </tfoot>
    </table>
    
    <table>
        <tr>
            <td style="font-size: 13px">Catatan:</td>
            @if($header->catatan == null)
                -<br>
            @else
                {{ $header->catatan }}
            @endif
        </tr>
        
        
    </table>   
</body>
</html>