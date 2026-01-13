@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Laporan Jatuh Tempo.xls");
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


<H2>Jatuh Tempo</H2>

<div>
    <input type="hidden" id="customer" name="customer" class="form-control" placeholder="Masukan ID Toko" value="{{ request()->customer }}">
    <input type="hidden" id="docId" name="docId" class="form-control" placeholder=" Masukan Invoice" value="{{ request()->docId }}">
    <input type="hidden" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">

    <table>
        <thead>
            <tr style="background-color: skyblue">
                <th>No</th>
                <th>No Invoice</th>
                <th>Id Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Nilai Invoice</th>
                <th>Sisa Invoice</th>
                <th>Tgl Invoice</th>
                <th>Tgl JT</th>
                <th>Tgl JT Baru</th>
                <th>Modifikasi Oleh</th>
                <th>Tgl Modifikasi</th>
                <th>Waktu Modifikasi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1 ?>
            @forelse($list_jt as $val)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $val->doc_id }}</td>
                <td>{{ $val->customer_id}}</td>
                <td>{{ $val->customer_name}}</td>
                <td align="right">{{ number_format($val->amount)}}</td>
                <td align="right">{{ number_format($val->remain)}}</td>
                <td align="center">{{ $val->doc_date }}</td> 
                <td align="center">{{ $val->due_date }}</td>
                <td align="center" style="background-color: gainsboro">{{ $val->due_date_updated }}</td>
                <td>{{ $val->name }}</td>
                <td align="center">{{ date('Y-m-d' , strtotime($val->created_at)) }}</td>
                <td align="center">{{ $val->time_update }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">Tidak ada data untuk saat ini</td>
            </tr>
             @endforelse
        </tbody>
    </table>
</div>                  







