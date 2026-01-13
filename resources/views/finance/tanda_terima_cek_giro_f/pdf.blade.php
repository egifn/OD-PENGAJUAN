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
                <b>{{ $header->judul_izin_f }}</b>
            </td>
            <td width="10">
                <div>
                    
                </div>
            </td>
            <td>
                <b>{{ $header->no_izin_f }}</b><br>
                <b>{{ date('d-M-y', strtotime($header->tgl_izin_f)) }}</b>    
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
                <th rowspan="2" style="vertical-align: middle;">No</th>
                <th rowspan="2" style="vertical-align: middle;">Jenis Pengeluaran</th>
                <th rowspan="2" style="vertical-align: middle;">No Cek/BG</th>
                <th colspan="3" style="vertical-align: middle;">Sumber Dana</th>
            </tr>    
            <tr align="center">
                <th style="vertical-align: middle;">Perusahaan</th>
                <th style="vertical-align: middle;">Bank</th>
                <th style="vertical-align: middle;">No Rekening</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse($detail as $val)
            <tr>
                <td align="right">{{ $no++}} &nbsp;</td>
                <td>&nbsp; {{ $val->keterangan }}</td>
                <td align="center">{{ $val->seri_awal }} - {{ $val->seri_akhir }} &nbsp; </td>
                <td>&nbsp; {{ $val->kode_perusahaan }}</td>
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
                <td>&nbsp;&nbsp;<b>Total Cek/Giro:</b></td>
                <td align="center" colspan="4"><b>{{ $total_jml->total }}</b> Lembar &nbsp;</td>
                 
            </tr>
            <tr>
                <td colspan="2" align="center">Yang membuat,</td>
                <td colspan="2" align="center">Mengajukan,</td>
                <td colspan="2" align="center">Menyetujui,</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="2" align="center">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="2" align="center">
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
                <td colspan="2" align="center">{{ $header->approval }}</td>
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