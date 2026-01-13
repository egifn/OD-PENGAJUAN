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
                <b>{{ $header->judul_izin }}</b>
            </td>
            <td width="10">
                <div>
                    
                </div>
            </td>
            <td>
                <b>{{ $header->no_izin }}</b><br>
                <b>{{ date('d-M-y', strtotime($header->tgl_izin)) }}</b>    
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
                <th>No Warkat</th>
                <th>Jml Lembar</th>
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
                <td>&nbsp; {{ $val->kode_seri_warkat }} {{ $val->seri_awal }} - {{ $val->seri_akhir }}</td>
                <td align="right">{{ $val->jml_lembar }} Lembar &nbsp; </td>
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
                <td align="center"><b>Total Warkat:</b></td>
                <td align="right"><b>{{ $total_jml->total }}</b> Lembar &nbsp;</td>
                <td colspan="3"></td> 
            </tr>
            <tr>
                <td colspan="2" align="center">Yang membuat</td>
                <td colspan="2" align="center">Di ambil oleh</td>
                <td colspan="2" align="center">Menyetujui</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    {{ date('d-M-Y', strtotime($header->tgl_izin)) }} 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="2" align="center">
                    @if($header->tgl_izin == null)
                        <br>
                    @else
                        {{ date('d-M-Y', strtotime($header->tgl_izin)) }}
                    @endif
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="2" align="center">
                    @if($header->tgl_approval_bod == null)
                        <br>
                    @else
                        {{ date('d-M-Y', strtotime($header->tgl_approval_bod)) }}
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
                <td colspan="2" align="center">{{ $header->pembawa_resi }}</td>
                <td colspan="2" align="center">{{ $header->name_approval_bod }}</td>
            </tr>
        </tfoot>
    </table>
    
    <table>
        <tr>
            <td style="font-size: 13px">Catatan:</td>
        </tr>
        
        
    </table>   
</body>
</html>