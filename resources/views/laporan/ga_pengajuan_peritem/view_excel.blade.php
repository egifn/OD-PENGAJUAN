@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Laporan Pengajuan Peritem.xls");
@endphp

<main class="main">

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Laporan Pengajuan Barang Peritem
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center">
                                    <thead class="table-warning text-dark" style="font-size: 13px;">
                                        <tr>
                                            <th>No</no>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Kode Pengajuan</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Depo</th>
                                            <th>Nama Divisi</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
                                        <?php $no=1 ?>
                                        @forelse($laporan as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tgl_pengajuan)->format('d-m-Y') }}</td>
                                                <td>{{ $row->kode_pengajuan }}</td>
                                                <td>{{ $row->nama_perusahaan }}</td>
                                                <td>{{ $row->nama_depo }}</td>
                                                <td>{{ $row->nama_divisi }}</td>
                                                <td>{{ $row->kode_product }}</td>
                                                <td>{{ $row->nama_barang }}</td>
                                                <td>{{ $row->qty }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted">Tidak ada data ditemukan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>