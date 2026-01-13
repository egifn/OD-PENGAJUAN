@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Data Rekening Outlet.xls");
@endphp

<style>
table, td, th {
  border: 1px outset gray;
}

table {
  width: 100%;
  border-collapse: collapse;
}
</style>


<H2>Data Rekening Outlet</H2>

<div>
    <br>
    <table>
        <thead>
            <tr style="background-color: skyblue">
                <th>No</th>
                <th>Kode Depo</th>
                <th>Nama Depo</th>
                <th>Kode Toko</th>
                <th>Nama Toko</th>
                <th>No Rekening</th>
                <th>Nama Rekening</th>
                <th>Bank Rekening</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse($data_toko_excel as $val)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $val->kode_depo }}</td>
                <td>{{ $val->nama_toko }}</td>
                <td>{{ $val->kode_toko }}</td>
                <td>{{ $val->nama_toko }}</td>
                <td>'{{ $val->no_rekening }}</td>
                <td>{{ $val->nama_rekening }}</td>
                <td>{{ $val->bank_rekening }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data untuk saat ini</td>
            </tr>
             @endforelse
        </tbody>
    </table>
</div>                  







