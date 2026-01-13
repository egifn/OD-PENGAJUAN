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
            <td>
                <br>
                <b>{{ $header->judul_izin_b }}</b>
            </td>
            {{-- <td width="10">
                <div>
                    
                </div>
            </td>
            <td>
                <b>{{ $header->no_izin_b }}</b><br>
                Bandung, {{ date('d-M-Y', strtotime($header->tgl_izin_b)) }}    
            </td>  --}}
        </tr>
        <tr>
            {{-- <td colspan="3">
                No Izin <b>{{ $header->no_izin_b }}</b><br>
            </td> --}}
        </tr>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td width="20"></td>
                <td width="120">No Izin</td>
                <td>:</td>
                <td>{{ $header->no_izin_b }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Tanggal Izin</td>
                <td>:</td>
                <td>{{ date('d-M-Y', strtotime($header->tgl_izin_b)) }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Nama Rekening Pembayar</td>
                <td>:</td>
                <td> {{ $header->atas_nama_rek }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Bank</td>
                <td>:</td>
                <td> {{ $header->nama_bank }}</td>
            </tr>
            <tr>
                <td></td>
                <td>No. Rek. Pembayar</td>
                <td>:</td>
                <td> {{ $header->rekening_pembayar }}</td>
            </tr>
            
        </tbody>
    </table>
    
    <table border='1' style="border-collapse: collapse; border-color: black; width: 100%; font-size: 13px" >
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle;">No</th>
                <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                <th rowspan="2" style="text-align: center;">No Cek</th>
                <th colspan="4" style="text-align: center;">Tujuan Cek</th>
            </tr>
            <tr align="center">
                <th style="vertical-align: middle;">Nama Vendor</th>
                <th style="vertical-align: middle;">Nama Rekening</th>
                <th style="vertical-align: middle;">Bank</th>
                <th style="vertical-align: middle;">No Rekening</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
            @forelse($detail_b as $val)
            <tr>
                <td align="right">{{ $no++}} &nbsp;</td>
                <td>&nbsp; {{ $val->keterangan }}</td>
                <td>&nbsp; ({{ $val->jml }} Lembar) {{ $val->kode_seri_warkat }} {{ $val->seri_awal }} - {{ $val->kode_seri_warkat }} {{ $val->seri_akhir }}</td>
                <td>&nbsp; {{ $val->nama_vendor }}</td>
                <td>&nbsp; {{ $val->atas_nama }}</td>
                <td>&nbsp; {{ $val->nama_bank }}</td>
                <td>&nbsp; {{ $val->no_rekening_vendor }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data untuk saat ini</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                
                <td colspan="2" align="center"><b>Total</b></td>
                <td></td>
                <td align="center"><b>Jumlah Cek : </b> &nbsp;</td>
                <td colspan="3" align="center"><b>{{ $total_jml->total }} Lembar</b> &nbsp;</td>
                 
            </tr>
            <tr>
                <td colspan="2" align="center">Yang membuat</td>
                <td colspan="2" align="center">Mengetahui</td>
                <td colspan="3" align="center">Menyetujui</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    {{ date('d-M-Y', strtotime($header->tgl_izin_b)) }} 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="2" align="center">
                    @if($header->tgl_approval_1 == null)
                        <br>
                    @else
                        {{ date('d-M-Y', strtotime($header->tgl_approval_1)) }}
                    @endif
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
                <td colspan="3" align="center">
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
                <td colspan="2" align="center">{{ $header->mengetahui }}</td>
                <td colspan="3" align="center">{{ $header->approved }}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    Keterangan: {{ $header->catatan_b }}
    
    <table>
        
        
    </table>   
</body>
</html>