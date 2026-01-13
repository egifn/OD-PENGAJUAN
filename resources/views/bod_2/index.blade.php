@section('js')
<script type="text/javascript">
    $(function(){
        function loadDepo(perusahaan_id, selectedDepo = '') {
            if (perusahaan_id) {
                $.ajax({
                    type: "GET",
                    url: "/ajax_depo_user?perusahaan_id=" + perusahaan_id,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#kode_depo").empty();
                            $("#kode_depo").append('<option value="">Pilih</option>');
                            $.each(res, function(nama, kode) {
                                var selected = (kode == selectedDepo) ? 'selected' : '';
                                $("#kode_depo").append('<option value="'+kode+'" '+selected+'>'+nama+'</option>');
                            });
                        } else {
                            $("#kode_depo").empty();
                        }
                    }
                });
            } else {
                $("#kode_depo").empty().append('<option value="">Pilih</option>');
            }
        }

        // Ketika perusahaan berubah
        $('#kode_perusahaan').change(function(){
            var perusahaan_id = $(this).val();
            loadDepo(perusahaan_id);
        });

        // Saat halaman dimuat kembali (dari request sebelumnya)
        var perusahaanSaatIni = $('#kode_perusahaan').val();
        var depoSaatIni = '{{ request("kode_depo") }}';

        if (perusahaanSaatIni) {
            loadDepo(perusahaanSaatIni, depoSaatIni);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_mo').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/jugs') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_mo_sps').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/sps') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_iod').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/iod') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_afh').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/afh') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_ahs').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/ahs') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_mt').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/mt') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_retail').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/retail') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_so').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/so') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.link_ws').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // cegah navigasi langsung

                // Ambil nilai dari input form
                var principal = document.getElementById('principal').value;
                var entitas = document.getElementById('kode_perusahaan').value;
                var depo = document.getElementById('kode_depo').value;
                var tglDari = document.getElementById('tgl_dari').value;
                var sampaiDengan = document.getElementById('sampai_dengan').value;

                // Buat query string
                var query = new URLSearchParams({
                    principal: principal,
                    kode_perusahaan: entitas,
                    kode_depo: depo,
                    tgl_dari: tglDari,
                    sampai_dengan: sampaiDengan
                }).toString();

                // Buka link baru dengan parameter
                var url = "{{ route('bod_monitoring/ws') }}?" + query;
                window.open(url, '_blank');
            });
        });
    });

</script>

@stop

@extends('layouts.admin')

@section('title')
	<title>Monitoring Saldo</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Monitoring Saldo</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Monitoring Saldo</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('bod_monitoring/cari') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-group row">
                                        <label for="principal" class="col-sm-2 col-form-label">PRINCIPAL</label>
                                        <div class="col-sm-3">
                                            <select name="principal" id="principal" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="PT. TIRTA INVESTAMA" {{ request('principal') == 'PT. TIRTA INVESTAMA' ? 'selected' : '' }}>PT. TIRTA INVESTAMA</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2"></div>

                                        <label for="tgl_dari" class="col-sm-2 col-form-label">TANGGAL DARI</label>
                                        <div class="col-sm-3">
                                            <input type="date" name="tgl_dari" id="tgl_dari" class="form-control" value="{{ request('tgl_dari') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="entitas" class="col-sm-2 col-form-label">ENTITAS</label>
                                        <div class="col-sm-3">
                                            <select name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                                <option value="">Pilih</option>
                                                @foreach ($perusahaan as $item)
                                                    <option value="{{ $item->kode_perusahaan }}" {{ request('kode_perusahaan') == $item->kode_perusahaan ? 'selected' : '' }}>
                                                    {{ $item->kode_perusahaan }} - {{ $item->nama_perusahaan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-2"></div>
                                        
                                        <label for="sampai_dengan" class="col-sm-2 col-form-label">SAMPAI DENGAN</label>
                                        <div class="col-sm-3">
                                            <input type="date" name="sampai_dengan" id="sampai_dengan" class="form-control" value="{{ request('sampai_dengan') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="depo" class="col-sm-2 col-form-label">DEPO</label>
                                        <div class="col-sm-3">
                                            <select name="kode_depo" id="kode_depo" class="form-control">
                                                <option value="">Pilih</option>
                                                
                                            </select>
                                        </div>

                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-primary">C a r i</button>
                                        </div>
                                    </div>   
                                </form>
                            </div>
                        </div>
                    </div>

                        <div class="col-md-12">
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div>
                                            <table class="table table-bordered  table-sm" id="tabelinput">
                                                <thead>
                                                    <tr>
                                                        <th style="vertical-align: middle;">Category</th>
                                                        <th style="vertical-align: middle;">Sub Category</th>
                                                        <th style="vertical-align: middle; width: 300px;">QTY</th>
                                                        <th style="vertical-align: middle;">Value</th>
                                                    </tr>
                                                </thead>
                                               <tbody>
    <!-- Bagian SKU -->
    <tr>
        <td rowspan="11">SKU</td>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>JUGS</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($monitoring[0]->TOTAL_QTY ?? 0) }}</a></td><td align="right">{{ number_format($monitoring[0]->TOTAL_BEFORE_PROMO ?? 0) }}</a></td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($monitoring[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_mo" target="_blank">{{ number_format($monitoring[0]->TOTAL_QTY ?? 0) }}</td><td align="right"><a href="#" class="link_mo" target="_blank">{{ number_format($monitoring[0]->TOTAL_AFTER_PROMO ?? 0) }}</td>
    </tr>
    
    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>SPS</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($monitoring[2]->TOTAL_QTY ?? 0) }}</a></td><td align="right">{{ number_format($monitoring[2]->TOTAL_BEFORE_PROMO ?? 0) }}</a></td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($monitoring[2]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_mo_sps" target="_blank">{{ number_format($monitoring[2]->TOTAL_QTY ?? 0) }}</td><td align="right"><a href="#" class="link_mo_sps" target="_blank">{{ number_format($monitoring[2]->TOTAL_AFTER_PROMO ?? 0) }}</td>
    </tr>

    <tr>
        <td><strong>TOTAL BEFORE PROMO</strong></td><td align="right"><b>{{ number_format(($monitoring[0]->TOTAL_QTY ?? 0) + ($monitoring[2]->TOTAL_QTY ?? 0)) }}</b></b></td><td align="right"><b>{{ number_format(($monitoring[0]->TOTAL_BEFORE_PROMO ?? 0) + ($monitoring[2]->TOTAL_BEFORE_PROMO ?? 0)) }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL PROMO</strong></td><td></td><td align="right"><b>{{ number_format(($monitoring[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($monitoring[2]->TOTAL_PIUTANG_PROMO_TIV ?? 0))  }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL AFTER PROMO</strong></td><td align="right"><b>{{ number_format(($monitoring[0]->TOTAL_QTY ?? 0) + ($monitoring[2]->TOTAL_QTY ?? 0)) }}</b></td><td align="right"><b>{{ number_format(($monitoring[0]->TOTAL_AFTER_PROMO ?? 0) + ($monitoring[2]->TOTAL_AFTER_PROMO ?? 0)) }}</b></td>
    </tr>

    <!-- Bagian SEGMENT -->
    <tr>
        <td rowspan="35">SEGMENT</td>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>IOD</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[3]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[3]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[3]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_iod" target="_blank">{{ number_format($segmen[3]->TOTAL_QTY ?? 0) }}</a></td><td align="right"><a href="#" class="link_iod" target="_blank">{{ number_format($segmen[3]->TOTAL_AFTER_PROMO ?? 0) }}</a></td>
    </tr>

    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>AFH</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[0]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[0]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_afh" target="_blank">{{ number_format($segmen[0]->TOTAL_QTY ?? 0) }}</a></td><td align="right"><a href="#" class="link_afh" target="_blank">{{ number_format($segmen[0]->TOTAL_AFTER_PROMO ?? 0) }}</a></td>
    </tr>

    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>AHS</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[1]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[1]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[1]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_ahs" target="_blank">{{ number_format($segmen[1]->TOTAL_QTY ?? 0) }}</a></td><td align="right"><a href="#" class="link_ahs" target="_blank">{{ number_format($segmen[1]->TOTAL_AFTER_PROMO ?? 0) }}</a></td>
    </tr>

    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>MT</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[4]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[4]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[4]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_mt" target="_blank">{{ number_format($segmen[4]->TOTAL_QTY ?? 0) }}</a></td><td align="right"><a href="#" class="link_mt" target="_blank">{{ number_format($segmen[4]->TOTAL_AFTER_PROMO ?? 0) }}</a></td>
    </tr>

    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>RETAIL</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[5]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[5]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[5]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_retail" target="_blank">{{ number_format($segmen[5]->TOTAL_QTY ?? 0) }}</a></td><td align="right"><a href="#" class="link_retail" target="_blank">{{ number_format($segmen[5]->TOTAL_AFTER_PROMO ?? 0) }}</a></td>
    </tr>

    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>SO</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[6]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[6]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[6]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_so" target="_blank">{{ number_format($segmen[6]->TOTAL_QTY ?? 0) }}</a></td><td align="right"><a href="#" class="link_so" target="_blank">{{ number_format($segmen[6]->TOTAL_AFTER_PROMO ?? 0) }}</a></td>
    </tr>

    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>WS</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[7]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[7]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[7]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right"><a href="#" class="link_ws" target="_blank">{{ number_format($segmen[7]->TOTAL_QTY ?? 0) }}</a></td><td align="right"><a href="#" class="link_ws" target="_blank">{{ number_format($segmen[7]->TOTAL_AFTER_PROMO ?? 0) }}</a></td>
    </tr>

    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>INTERN</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($segmen[2]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[2]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($segmen[2]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right">{{ number_format($segmen[2]->TOTAL_QTY ?? 0) }}</td><td align="right">{{ number_format($segmen[2]->TOTAL_AFTER_PROMO ?? 0) }}</td>
    </tr>

    <tr>
        <td><strong>TOTAL BEFORE PROMO</strong></td><td align="right"><b>{{ number_format(($segmen[0]->TOTAL_QTY ?? 0) + ($segmen[1]->TOTAL_QTY ?? 0) + ($segmen[2]->TOTAL_QTY ?? 0) + ($segmen[3]->TOTAL_QTY ?? 0) + ($segmen[4]->TOTAL_QTY ?? 0) + ($segmen[5]->TOTAL_QTY ?? 0) + ($segmen[6]->TOTAL_QTY ?? 0)) }}</b></td><td align="right"><b>{{ number_format(($segmen[0]->TOTAL_BEFORE_PROMO ?? 0) + ($segmen[1]->TOTAL_BEFORE_PROMO ?? 0) + ($segmen[2]->TOTAL_BEFORE_PROMO ?? 0) + ($segmen[3]->TOTAL_BEFORE_PROMO ?? 0) + ($segmen[4]->TOTAL_BEFORE_PROMO ?? 0) + ($segmen[5]->TOTAL_BEFORE_PROMO ?? 0) + ($segmen[6]->TOTAL_BEFORE_PROMO ?? 0)) }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL PROMO</strong></td><td></td><td align="right"><b>{{ number_format(($segmen[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($segmen[1]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($segmen[2]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($segmen[3]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($segmen[4]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($segmen[5]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($segmen[6]->TOTAL_PIUTANG_PROMO_TIV ?? 0)) }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL AFTER PROMO</strong></td><td align="right"><b>{{ number_format(($segmen[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($segmen[1]->TOTAL_QTY ?? 0) + ($segmen[2]->TOTAL_QTY ?? 0) + ($segmen[3]->TOTAL_QTY ?? 0) + ($segmen[4]->TOTAL_QTY ?? 0) + ($segmen[5]->TOTAL_QTY ?? 0) + ($segmen[6]->TOTAL_QTY ?? 0)) }}</b></td><td align="right"><b>{{ number_format(($segmen[0]->TOTAL_AFTER_PROMO ?? 0) + ($segmen[1]->TOTAL_AFTER_PROMO ?? 0) + ($segmen[2]->TOTAL_AFTER_PROMO ?? 0) + ($segmen[3]->TOTAL_AFTER_PROMO ?? 0) + ($segmen[4]->TOTAL_AFTER_PROMO ?? 0) + ($segmen[5]->TOTAL_AFTER_PROMO ?? 0) + ($segmen[6]->TOTAL_AFTER_PROMO ?? 0)) }}</b></td>
    </tr>

    <!-- Bagian TIPE SALES -->
    <tr>
        <td rowspan="11">TIPE SALES</td>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>KREDIT</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($tipe_sales[0]->TOTAL_SKU ?? 0) }}</td><td align="right">{{ number_format($tipe_sales[0]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($tipe_sales[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right">{{ number_format($tipe_sales[0]->TOTAL_SKU ?? 0) }}</td><td align="right">{{ number_format($tipe_sales[0]->TOTAL_AFTER_PROMO ?? 0) }}</td>
    </tr>
    
    <tr>
        <td colspan="3" style="background-color:rgb(182, 182, 185)"><strong>TUNAI</strong></td>
    </tr>
    <tr>
        <td>– Before Promo</td><td align="right">{{ number_format($tipe_sales[1]->TOTAL_SKU ?? 0) }}</td><td align="right">{{ number_format($tipe_sales[1]->TOTAL_BEFORE_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>– Piutang Promo TIV</td><td></td><td align="right">{{ number_format($tipe_sales[1]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</td>
    </tr>
    <tr>
        <td>– After Promo</td><td align="right">{{ number_format($tipe_sales[1]->TOTAL_SKU ?? 0) }}</td><td align="right">{{ number_format($tipe_sales[1]->TOTAL_AFTER_PROMO ?? 0) }}</td>
    </tr>

    <tr>
        <td><strong>TOTAL BEFORE PROMO</strong></td><td align="right"><b>{{ number_format(($tipe_sales[0]->TOTAL_SKU ?? 0) + ($tipe_sales[1]->TOTAL_SKU ?? 0)) }} </b></td><td align="right"><b>{{ number_format(($tipe_sales[0]->TOTAL_BEFORE_PROMO ?? 0) + ($tipe_sales[1]->TOTAL_BEFORE_PROMO ?? 0)) }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL PROMO</strong></td><td></td><td align="right"><b>{{ number_format(($tipe_sales[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) + ($tipe_sales[1]->TOTAL_PIUTANG_PROMO_TIV ?? 0)) }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL AFTER PROMO</strong></td><td align="right"><b>{{ number_format(($tipe_sales[0]->TOTAL_SKU ?? 0) + ($tipe_sales[1]->TOTAL_SKU ?? 0)) }}</b></td><td align="right"><b>{{ number_format(($tipe_sales[0]->TOTAL_AFTER_PROMO ?? 0) + ($tipe_sales[1]->TOTAL_AFTER_PROMO ?? 0)) }}</b></td>
    </tr>

    <!-- Bagian SALESMAN -->
    <tr>
        <td rowspan="1">SALESMAN</td>
        <td><strong>TOTAL</strong></td>
        <td align="right"><b>{{ number_format($salesman[0]->TOTAL_QTY ?? 0) }}</b></td>
        <td align="right"><b>{{ number_format($salesman[0]->TOTAL_AFTER_PROMO ?? 0) }}</b></td>
    </tr>

    <!-- Bagian SALES -->
    <tr>
        <td rowspan="3">SALES</td>
        <td><strong>TOTAL BEFORE PROMO</strong></td><td align="right"><b>{{ number_format($salesman[0]->TOTAL_QTY ?? 0) }}</b></td><td align="right"><b>{{ number_format($salesman[0]->TOTAL_BEFORE_PROMO ?? 0) }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL PROMO</strong></td><td></td><td align="right"><b>{{ number_format($salesman[0]->TOTAL_PIUTANG_PROMO_TIV ?? 0) }}</b></td>
    </tr>
    <tr>
        <td><strong>TOTAL AFTER PROMO</strong></td><td align="right"><b>{{ number_format($salesman[0]->TOTAL_QTY ?? 0) }}</b></td><td align="right"><b>{{ number_format($salesman[0]->TOTAL_AFTER_PROMO ?? 0) }}</b></td>
    </tr>

    <!-- Bagian GUDANG -->
    <tr>
        <td rowspan="6">GUDANG</td>
        <td>BKB Distribusi</td><td align="right">{{ number_format($gudang_dist[0]->TOTAL_QTY ?? 0) }}</td><td></td>
    </tr>
    <tr>
        <td>BTB Distribusi</td><td align="right">{{ number_format($gudang_dist[1]->TOTAL_QTY ?? 0) }}</td><td></td>
    </tr>
    <tr>
        <td>BKB Suplier</td><td align="right">{{ number_format($gudang_supp[0]->TOTAL_QTY ?? 0) }}</td><td></td>
    </tr>
    <tr>
        <td>BTB Suplier</td><td align="right">{{ number_format($gudang_supp[1]->TOTAL_QTY ?? 0) }}</td><td></td>
    </tr>
    <tr>
        <td><strong>TOTAL Distribusi</strong></td><td align="right"><b>{{ number_format(($gudang_dist[0]->TOTAL_QTY ?? 0) + ($gudang_dist[1]->TOTAL_QTY ?? 0)) }}</b></td><td></td>
    </tr>
    <tr>
        <td><strong>TOTAL Suplier</strong></td><td align="right"><b>{{ number_format(($gudang_supp[0]->TOTAL_QTY ?? 0) + ($gudang_supp[1]->TOTAL_QTY ?? 0)) }}</b></td><td></td>
    </tr>

    <!-- Bagian KASIR PENERIMAAN DEPO -->
    <tr>
        <td rowspan="5">PENERIMAAN KASIR DEPO (AFTER PROMO)</td>
        <td>Penjualan Tunai</td><td></td><td align="right">{{ number_format($kasir['Penjualan Tunai Transfer'] ?? 0)}}</td>
    </tr>
    <tr>
        <td>Penjualan Tunai Transfer</td><td></td><td align="right">{{ number_format($kasir['Penjualan Tunai Transfer'] ?? 0)}}</td>
    </tr>
    <tr>
        <td>Tagihan Tunai</td><td></td><td align="right">{{ number_format($kasir['Tagihan Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td>Tagihan NON Tunai</td><td></td><td align="right">{{ number_format($kasir['Tagihan Non Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td><strong>TOTAL</strong></td><td></td><td align="right"><b>{{ number_format(($kasir['Penjualan Tunai Transfer'] ?? 0) + ($kasir['Tagihan Tunai'] ?? 0) + ($kasir['Tagihan Tunai'] ?? 0)) }}</b></td>
    </tr>

    <!-- Bagian KASIR PENYETORAN DEPO -->
    <tr>
        <td rowspan="5">PENYETORAN KASIR DEPO (AFTER PROMO)</td>
        <td>Setoran Penjualan Tunai</td><td></td><td align="right">{{ number_format($kasir['Setoran Penjualan Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td>Setoran Penjualan Tunai Transfer</td><td></td><td align="right">-</td>
    </tr>
    <tr>
        <td>Setoran Tagihan Tunai</td><td></td><td align="right">{{ number_format($kasir['Setoran Tagihan Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td>Setoran Tagihan NON Tunai</td><td></td><td align="right">{{ number_format($kasir['Setoran Tagihan Non Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td><strong>TOTAL</strong></td><td></td><td align="right"><b>{{ number_format(($kasir['Setoran Penjualan Tunai'] ?? 0) + ($kasir['Setoran Tagihan Tunai'] ?? 0) + ($kasir['Setoran Tagihan Non Tunai'] ?? 0)) }}</b></td>
    </tr>

    <!-- Bagian KASIR PENERIMAAN HO -->
    <tr>
        <td rowspan="5">PENERIMAAN KASIR HO (AFTER PROMO)</td>
        <td>Penerimaan Setoran Penjualan Tunai</td><td></td><td align="right">{{ number_format($kasir['Penerimaan Setoran Penjualan Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td>Penerimaan Setoran Penjualan Tunai Transfer</td><td></td><td align="right">{{ number_format($kasir['Penerimaan Setoran Tagihan Non Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td>Penerimaan Setoran Tagihan Tunai</td><td></td><td align="right">{{ number_format($kasir['Penerimaan Setoran Tagihan Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td>Penerimaan Setoran Tagihan NON Tunai</td><td></td><td align="right">{{ number_format($kasir['Penerimaan Setoran Tagihan Non Tunai'] ?? 0) }}</td>
    </tr>
    <tr>
        <td><strong>TOTAL</strong></td><td></td><td align="right"><b>{{ number_format(($kasir['Penerimaan Setoran Penjualan Tunai'] ?? 0) + ($kasir['Penerimaan Setoran Tagihan Non Tunai'] ?? 0)  + ($kasir['Penerimaan Setoran Tagihan Tunai'] ?? 0) + ($kasir['Penerimaan Setoran Tagihan Non Tunai'] ?? 0)) }}</b></td>
    </tr>
    <tr>
        <td rowspan="3"></td>
        <td>Invoice Baru</td><td></td><td align="right">{{ number_format($invoice[0]->total_sales_after_promo ?? 0) }}</td>
    </tr>
    <tr>
        <td>Pelunasan Tunai dan NON Tunai</td><td></td><td align="right">{{ number_format($pelunasan[2]->TOTAL_NILAI_PAYMENT ?? 0) }}</td>
    </tr>
    <tr>
        <td><strong>TOTAL</strong></td><td></td><td align="right"><b>{{ number_format(($invoice[0]->total_sales_after_promo ?? 0) + ($pelunasan[2]->TOTAL_NILAI_PAYMENT ?? 0)) }}</b></td>
    </tr>

    <!-- Bagian PIUTANG PROMO TIV -->
    <tr>
        <td rowspan="5">PIUTANG PROMO TIV (CLAIM)</td>
        <td>JUGS</td><td></td><td align="right">{{ number_format($monitoring[0]->TOTAL_AFTER_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td>SPS</td><td></td><td align="right">{{ number_format($monitoring[1]->TOTAL_AFTER_PROMO ?? 0) }}</td>
    </tr>
    <tr>
        <td><strong>TOTAL PIUTANG PROMO TIV</strong></td><td></td><td align="right"><b>{{ number_format(($monitoring[0]->TOTAL_AFTER_PROMO ?? 0) + ($monitoring[1]->TOTAL_AFTER_PROMO ?? 0)) }}</b></td>
    </tr>
    <tr>
        <td>Pelunasan Piutang Promo TIV</td><td></td><td></td>
    </tr>
    <tr>
        <td><strong>SALDO AKHIR</strong></td><td><b></b></td><td><b></b></td>
    </tr>

    <!-- Bagian KASIR PENGELUARAN DEPO -->
    <tr>
        <td rowspan="1">KASIR PENGELUARAN DEPO</td>
        <td>Pengeluaran Petty Cash</td>
        <td></td>
        <td align="right">{{ number_format($kasir['Pengeluaran Petty Cash'] ?? 0) }}</td>
    </tr>

    <!-- Bagian BIAYA PENERIMAAN DEPO -->
    <tr>
        <td rowspan="3">BIAYA PENERIMAAN DEPO</td>
        <td>Penerimaan Petty Cash</td><td></td><td align="right">{{ number_format($kasir['Penerimaan Petty Cash'] ?? 0) }}</td>
    </tr>
    <tr>
        <td>Pengeluaran Biaya</td><td></td><td></td>
    </tr>
</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                          
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
    </div>
</main>


@endsection