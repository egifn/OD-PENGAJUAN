@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Laporan Get In.xls");
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


<H2>Get In</H2>

<div>
    <b>Periode: {{ request()->tanggal_ex }} </b>
    <br>
    <table>
        <thead>
            <tr style="background-color: skyblue">
                <th>Depo</th>
                <th>Pabrik/Sumber</th>
                <th>No Polisi</th>   
                <th>Sopir</th>
                <th>SKU</th>
                <th>Qty BS</th>
                <th>Kode Produksi</th>
                <th>Sub Zona</th>
                <th>Nama Leader</th>
                <th>Nama Checker</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $val)
            <tr>
                <td>{{ $val->nama_depo }}</td>
                <td>{{ $val->from }}</td>
                <td>{{ $val->no_mobil }}</td>
                <td>{{ $val->nama_driver }}</td>
                <td>{{ $val->nama_produk }}</td>
                <td>{{ $val->qty_bs }}</td>
                <td>{{ $val->kode_produksi }}</td>
                <td>{{ $val->nama_sub_area }}</td>
                <td>{{ $val->name }}</td>
                <td>{{ $val->nama_checker }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data untuk saat ini</td>
            </tr>
             @endforelse
        </tbody>
    </table>
</div>                  







