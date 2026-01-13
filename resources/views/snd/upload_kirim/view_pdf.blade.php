<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approval Surat Program</title>
</head>

<style>
    table, td, th {
      border: 1px outset gray;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
    }
    </style>

<body>
    <H2><i>Lampiran Approval Surat Program</i></H2>

    <div>
        <br>
        <table>
            <thead>
                <tr style="background-color: rgb(184, 183, 183)">
                    <th>No Surat</th>
                    <th>Program</th>
                    <th>Yang Membuat</th>
                    <th>Approval SSD</th>
                    <th>Approval Manager SSD</th>
                    <th>Approval SOM</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekap_app_surat as $val)
                <tr>
                    <td style="font-size: 13px;">{{ $val->no_surat }}</td>
                    <td style="font-size: 13px;">
                        Id Program: {{ $val->id_program }} <br>
                        Nama Program: {{ $val->nama_program }} <br>
                        Periode: {{ date('d-M-Y', strtotime($val->periode_awal)) }} s/d {{ date('d-M-Y', strtotime($val->periode_akhir)) }}
                    </td>
                    <td style="font-size: 13px;">
                        {{ $val->yang_membuat }} <br>
                        
                    </td>
                    <td style="font-size: 13px;">
                        {{ $val->nama_ssd }} <br>
                        {{ $val->kode_app_ssd }}
                    </td>
                    <td style="font-size: 13px;">
                        {{ $val->nama_mssd }} <br>
                        {{ $val->kode_app_manager }}
                    </td>
                    <td style="font-size: 13px;">
                        {{ $val->nama_som }} <br>
                        {{ $val->kode_app_som }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data untuk saat ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>   
    
</body>
</html>