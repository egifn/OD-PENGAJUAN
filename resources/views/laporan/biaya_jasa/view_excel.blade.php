@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Laporan Pengajuan Biaya/Jasa.xls");
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
                                Laporan Pengajuan Biaya/Jasa
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
                                            <th>Kode Pengajuan</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Nama Pengeluaran</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Depo</th>
                                            <th>Nama Divisi</th>
                                            <th>Keterangan</th>
                                            <th>Status Ka. Keuangan Depo</th>
                                            <th>Status Ops Depo</th>
                                            <th>Status PIC HO</th>
                                            <th>Status Biaya Pusat</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
                                        <?php $no = 1; ?>
                                        @forelse($laporan as $row)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $row->kode_pengajuan_b }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tgl_pengajuan_b)->format('d-m-Y') }}</td>
                                                <td>{{ $row->nama_pengeluaran }}</td>
                                                <td>{{ $row->nama_perusahaan }}</td>
                                                <td>{{ $row->nama_depo }}</td>
                                                <td>{{ $row->nama_divisi }}</td>
                                                <td>{{ $row->keterangan }}</td>
                                                <td>
                                                    @if($row->ka_keuangan_depo == '0')
                                                        
                                                    @elseif($row->ka_keuangan_depo == '1')
                                                        {{ \Carbon\Carbon::parse($row->tgl_approval_detail)->format('d-m-Y') }}
                                                    @elseif($row->ka_keuangan_depo == '2')
                                                        Denied
                                                    @elseif($row->ka_keuangan_depo == '3')
                                                        Pending
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->ops_depo == '0')
                                                        
                                                    @elseif($row->ops_depo == '1')
                                                        {{ \Carbon\Carbon::parse($row->tgl_approval_detail_atasan)->format('d-m-Y') }}
                                                    @elseif($row->ops_depo == '2')
                                                        Denied
                                                    @elseif($row->ops_depo == '3')
                                                        Pending
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->pic_ho == '0')
                                                        
                                                    @elseif($row->pic_ho == '1')
                                                        {{ \Carbon\Carbon::parse($row->tgl_approval_detail_acc)->format('d-m-Y') }}
                                                    @elseif($row->pic_ho == '2')
                                                        Denied
                                                    @elseif($row->pic_ho == '3')
                                                        Pending
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->status_biaya_pusat == '0')
                                                        
                                                    @elseif($row->status_biaya_pusat == '1')
                                                        {{ \Carbon\Carbon::parse($row->tgl_approval_biaya_pusat)->format('d-m-Y') }}
                                                    @elseif($row->status_biaya_pusat == '2')
                                                        Denied
                                                    @elseif($row->status_biaya_pusat == '3')
                                                        Pending
                                                    @endif
                                                </td>
                                            </tr>
                                        <?php $no++ ?>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center text-muted">Tidak ada data ditemukan</td>
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