@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Laporan SPP.xls");
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
                                Laporan SPP
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
                                            <th>No</th>
                                            <th>No SPP</th>
                                            <th>Tanggal SPP</th>
                                            <th>Keterangan</th>
                                            <th hidden>Jenis SPP</th>
                                            <th>Nilai SPP</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
                                        <?php $no=1 ?>
                                        @forelse($laporan as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->no_spp }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tgl_spp)->format('d-m-Y') }}</td>
                                                <td>{{ $row->keterangan }}</td>
                                                <td hidden>{{ $row->kategori }}</td>
                                                <td>{{ $row->jumlah }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Tidak ada data ditemukan</td>
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