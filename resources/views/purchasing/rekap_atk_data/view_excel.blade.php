@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Rekap Pengajuan ATK.xls");
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


<H2>Rekap Pengajuan ATK</H2>
Periode: {{ $header->periode }} {{ date('Y', strtotime($header->tgl_rekap)) }}

<div>
    {{-- <b>Periode: {{ request()->tanggal_ex }} </b> --}}
    <br>
    <table>
        <thead>
            <tr style="background-color: skyblue">
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Keterangan</th>
                <th>Qty Masuk</th>
                <th>Qty Jadi</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1 ?>
            @forelse($rekap_pengajuan_v as $val)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $val->kode_product }}</td>
                <td>{{ $val->nama_barang }}</td>
                <td>{{ $val->merk }}</td>
                <td>{{ $val->ket }}</td>
                <td>{{ $val->qty_awal }}</td>
                <td>{{ $val->qty_jadi }}</td>
                <td>{{ $val->satuan }}</td>
                <td>{{ ($val->harga) }}</td>
                <td>{{ ($val->total_harga) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data untuk saat ini</td>
            </tr>
             @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" align="center"><b>T o t a l</b></td>
                <td align="right"><b> {{  ($total_rekap->total_all) }}</b></td>
            </tr>
        </tfoot>
    </table>
</div>                  







