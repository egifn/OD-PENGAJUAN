
@extends('layouts.admin')

@section('title')
    <title>Laporan Pengajuan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Laporan</li>
        <li class="breadcrumb-item active">Pengajuan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Laporan Pengajuan
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="#" method="GET" class="mb-4">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label for="tanggal_awal">Periode Awal</label>
                                        <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tanggal_akhir">Periode Akhir</label>
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="perusahaan">Perusahaan</label>
                                        <select name="perusahaan" id="perusahaan" class="form-control">
                                            <option value="">-- Semua Perusahaan --</option>
                                            @foreach($perusahaan as $p)
                                                <option value="{{ $p->kode_perusahaan }}" {{ request('perusahaan') == $p->kode_perusahaan ? 'selected' : '' }}>
                                                    {{ $p->nama_perusahaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="depo">Depo</label>
                                        <select name="depo" id="depo" class="form-control">
                                            <option value="">-- Semua Depo --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Tampilkan
                                        </button>
                                        <a href="#" id="btnExportExcel" class="btn btn-success">
                                            <i class="bi bi-file-earmark-excel"></i> Cetak Excel
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center">
                                    <thead class="table-warning text-dark" style="font-size: 13px;">
                                        <tr>
                                            <th>No</no>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Kode Pengajuan</th>
                                            <th>Nama Pengeluaran</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Depo</th>
                                            <th>Nama Divisi</th>
                                            <th>Keterangan</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px;">
                                        <?php $no=1 ?>
                                        @forelse($laporan as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tgl_pengajuan)->format('d-m-Y') }}</td>
                                                <td>{{ $row->kode_pengajuan }}</td>
                                                <td>{{ $row->nama_pengeluaran }}</td>
                                                <td>{{ $row->nama_perusahaan }}</td>
                                                <td>{{ $row->nama_depo }}</td>
                                                <td>{{ $row->nama_divisi }}</td>
                                                <td>{{ $row->nama_pengeluaran }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada data ditemukan</td>
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

@endsection

@section('js')
<script>
    document.getElementById('btnExportExcel').addEventListener('click', function(e) {
        e.preventDefault();
        let params = new URLSearchParams({
            tanggal_awal: document.getElementById('tanggal_awal').value,
            tanggal_akhir: document.getElementById('tanggal_akhir').value,
            perusahaan: document.getElementById('perusahaan').value,
            depo: document.getElementById('depo').value
        }).toString();

        window.open(`{{ route('laporan_pengajuan/view.view_excel') }}?${params}`, '_blank');
    });

    $(function() {
        function loadDepo(perusahaan_id, selected_depo = '') {
            if (perusahaan_id) {
                $.ajax({
                    type: "GET",
                    url: "laporan_biaya_jasa/ajax_depo?perusahaan_id=" + perusahaan_id,
                    dataType: 'JSON',
                    success: function(res) {
                        $("#depo").empty().append('<option value="">-- Semua Depo --</option>');
                        $.each(res, function(nama, kode) {
                            var selected = (kode == selected_depo) ? 'selected' : '';
                            $("#depo").append('<option value="'+kode+'" '+selected+'>'+nama+'</option>');
                        });
                    }
                });
            } else {
                $("#depo").empty().append('<option value="">-- Semua Depo --</option>');
            }
        }

        // Event ketika perusahaan diganti
        $('#perusahaan').change(function() {
            var perusahaan_id = $(this).val();
            loadDepo(perusahaan_id);
        });

        // Saat halaman pertama kali diload (misalnya setelah klik "Tampilkan")
        var perusahaan_terpilih = "{{ request('perusahaan') }}";
        var depo_terpilih = "{{ request('depo') }}";
        if (perusahaan_terpilih) {
            loadDepo(perusahaan_terpilih, depo_terpilih);
        }
    });

</script>
@endsection