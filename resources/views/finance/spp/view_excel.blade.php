@php
    header("Content-type: application/vnd-ms-excel"); 
    header("Content-Disposition: attachment; filename=Daftar SPP.xls");
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
                                Daftar SPP
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
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table border="1" style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. SPP</th>
                                            <th>Tgl SPP</th>
                                            <th>Yang Mengajukan</th>
                                            <th>Keterangan</th>
                                            <th>Nilai SPP</th>
                                            <th>Input oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        @forelse($spp as $val)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td><strong>{{ $val->no_spp }}</strong></td>
                                            <td>{{ $val->tgl_spp }}</td>
                                            <td>{{ $val->yang_mengajukan }}</td>
                                            <td>{{ $val->keterangan }}</td>
                                            <td align = "right">{{ number_format($val->jumlah) }}</td>
                                            <td>{{ $val->name }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
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
