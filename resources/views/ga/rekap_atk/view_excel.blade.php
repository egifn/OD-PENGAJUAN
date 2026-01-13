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


<hr>
<div class="col-lg-12" style="text-align: center;">
    <b>Rekap Pengajuan ATK</b>
</div>
{{-- <div class="col-lg-12" style="text-align: center;">
    Per Tanggal: {{ $date }}
</div> --}}
<hr>

<div>
    {{-- <b>Periode: {{ request()->tanggal_ex }} </b> --}}
    <br>
    <table>
        <thead>
            <tr style="background-color: rgb(195, 199, 200)">
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Keterangan</th>
                <th>Harga Satuan</th>
                <th>Qty OPS</th>
                <th>Qty GA</th>
                <th>Qty PRC</th>
                <th>Satuan</th>
                <th>Total OPS</th>
                <th>Total GA</th>
                <th>Total PRC</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse($data_po as $val)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $val->kode_product }}</td>
                <td>{{ $val->nama_barang }}</td>
                <td>{{ $val->merk }}</td>
                <td>{{ $val->ket }}</td>
                <td align="right">{{ $val->price }}</td>
                <td align="right">{{ $val->qty_ops }}</td>
                <td align="right">{{ $val->qty_ga }}</td>
                <td align="right">{{ $val->qty_pc }}</td>
                <td>{{ $val->satuan }}</td>
                <td align="right">{{ $val->qty_ops * $val->price }}</td>
                <td align="right">{{ $val->qty_ga * $val->price }}</td>
                <td align="right">{{ $val->qty_pc * $val->price }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data untuk saat ini</td>
            </tr>
             @endforelse
        </tbody>
        {{-- <tfoot hidden>
            <tr style="background-color: rgb(195, 199, 200)">
                <td colspan="10" align="right"><b></b></td>
                <td align="right"><b>total</b></td>
                <td align="right"><b>total</b></td>
                <td align="right"><b>total</b></td>
                <td></td>
            </tr>
        </tfoot> --}}
    </table>
</div>                  







