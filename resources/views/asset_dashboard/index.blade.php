@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script type="text/javascript">
    fetchTotalAsset();
    function fetchTotalAsset() {
        $.ajax({
            type: "GET",
            url: "{{ route('asset_dashboard/getDataTotalAsset.getDataTotalAsset') }}",
            // data: {
            //     value: value
            // },
            dataType: "json",
            success: function(data) {
                
                $('.total_asset').text(data.data.total_asset);
                $('.total_baik').text(data.data.total_baik);
                $('.total_perlu_diganti').text(data.data.total_perlu_ganti);
                $('.total_perlu_perbaikan').text(data.data.total_perlu_perbaikan);
                $('.total_dalam_perbaikan').text(data.data.total_dalam_perbaikan); 

            }
        });    
    }

    fetchTotalChart();
    function fetchTotalChart(){
        $.ajax({
            type: "GET",
            url: "{{ route('asset_dashboard/getDataTotalChart.getDataTotalChart') }}",
            // data: {
            //     value: value
            // },
            dataType: "json",
            success: function(data) {
               // Data untuk grafik
               // var totalAsset = data.data.total_asset;
                var ttlTUA_baik = data.data.Jml_TUA_baik;
                var ttlTU_baik = data.data.Jml_TU_baik;
                var ttlTA_baik = data.data.Jml_TA_baik;

                var ttlTUA_perlu_diganti = data.data.Jml_TUA_rusak_perlu_diganti;
                var ttlTU_perlu_diganti = data.data.Jml_TU_rusak_perlu_diganti;
                var ttlTA_perlu_diganti = data.data.Jml_TA_rusak_perlu_diganti;

                var ttlTUA_perlu_diperbaiki = data.data.Jml_TUA_rusak_perlu_diperbaiki;
                var ttlTU_perlu_diperbaiki = data.data.Jml_TU_rusak_perlu_diperbaiki;
                var ttlTA_perlu_diperbaiki = data.data.Jml_TA_rusak_perlu_diperbaiki;

                var ttlTUA_dalam_perbaikan = data.data.Jml_TUA_dalam_perbaikan;
                var ttlTU_dalam_perbaikan = data.data.Jml_TU_dalam_perbaikan;
                var ttlTA_dalam_perbaikan = data.data.Jml_TA_dalam_perbaikan;

                // Membuat Grafik
                var ctx = document.getElementById('totalAssetChart').getContext('2d');
                var totalAssetChart = new Chart(ctx, {
                    type: 'bar', // Jenis grafik batang
                    data: {
                        labels: ['TA', 'TU', 'TUA'], // Label untuk grafik
                        datasets: [
                            {
                                label: 'Baik', // Nama dataset
                                data: [ttlTA_baik, ttlTU_baik, ttlTUA_baik], // Data batang (A, B, C)
                                backgroundColor: ['#4caf50'], // Warna untuk setiap batang
                                borderColor: ['#4caf50'], // Border untuk batang
                                borderWidth: 1,
                                barThickness: 40
                            },
                            {
                                label: 'Rusak Perlu Diganti', // Nama dataset
                                data: [ttlTA_perlu_diganti, ttlTU_perlu_diganti, ttlTUA_perlu_diganti], // Data batang
                                backgroundColor: ['#f44336'], // Warna merah
                                borderColor: ['#f44336'], // Border merah
                                borderWidth: 1,
                                barThickness: 40
                            },
                            {
                                label: 'Rusak Perlu Diperbaiki', // Nama dataset
                                data: [ttlTA_perlu_diperbaiki, ttlTU_perlu_diperbaiki, ttlTUA_perlu_diperbaiki], // Data batang
                                backgroundColor: ['#ffeb3b', '#ffeb3b', '#ffeb3b'], // Warna kuning
                                borderColor: ['#fbc02d', '#fbc02d', '#fbc02d'], // Border kuning
                                borderWidth: 1,
                                barThickness: 40
                            },
                            {
                                label: 'Dalam Perbaikan', // Nama dataset
                                data: [ttlTA_dalam_perbaikan, ttlTU_dalam_perbaikan, ttlTUA_dalam_perbaikan], // Data batang
                                backgroundColor: ['#2196f3', '#2196f3', '#2196f3'], // Warna biru
                                borderColor: ['#1976d2', '#1976d2', '#1976d2'], // Border biru
                                borderWidth: 1,
                                barThickness: 40
                            }
                        ]
                    },
                    options: {
                        indexAxis: 'y', // Mengubah grafik menjadi horizontal
                        scales: {
                            x: {
                                beginAtZero: true, // Mulai dari angka 0
                                stacked: true, // Mengaktifkan tumpukan batang pada sumbu x
                            },
                            y: {
                                stacked: true, // Mengaktifkan tumpukan batang pada sumbu y
                            }
                        },
                        responsive: true, // Membuat grafik responsif
                        plugins: {
                            legend: {
                                position: 'top', // Posisi legend
                            }
                        }
                    }
                });

            }
        });
    }

    fetchTotalDepoChart();
    function fetchTotalDepoChart(){
        $.ajax({
            type: "GET",
            url: "{{ route('asset_dashboard/getDataTotalDepoChart.getDataTotalDepoChart') }}",
            dataType: "json",
            success: function(data) {
                var ttl_lembang = data.data.Lembang;
                var ttl_majalaya = data.data.Majalaya;
                var ttl_padalarang = data.data.Padalarang;
                var ttl_sadakeling = data.data.Sadakeling;
                var ttl_metro = data.data.Metro;
                var ttl_katapang = data.data.Katapang;
                var ttl_cicalengka = data.data.Cicalengka;
                var ttl_soreang = data.data.Soreang;
                var ttl_sumedang = data.data.Sumedang;
                var ttl_pangandaran = data.data.Pangandaran;
                var ttl_tasikmalaya = data.data.Tasikmalaya;
                var ttl_penggung = data.data.Penggung;
                var ttl_kuningan = data.data.Kuningan;
                var ttl_purwakarta = data.data.Purwakarta;
                var ttl_kanci = data.data.Kanci;
                var ttl_kasomalang = data.data.Kasomalang;
                var ttl_pamanukan = data.data.Pamanukan;
                var ttl_jatisari = data.data.Jatisari;
                var ttl_banjarsari = data.data.Banjarsari;
                var ttl_garut = data.data.Garut;
                var ttl_jatibarang = data.data.Jatibarang;
                var ttl_majalengka = data.data.Majalengka;
                var ttl_pelabuhan_ratu = data.data.Pelabuhan_ratu;
                var ttl_bogor = data.data.Bogor;
                var ttl_citeureup = data.data.Citeureup;
                var ttl_parung = data.data.Parung;
                var ttl_sukabumi = data.data.Sukabumi;
                var ttl_cianjur = data.data.Cianjur;
                var ttl_sentul = data.data.Sentul;
                var ttl_parung_panjang = data.data.Parung_panjang;
                var ttl_tapos = data.data.Tapos;

                // Membuat Grafik
                var ctx = document.getElementById('totalAssetDepoChart').getContext('2d');
                var totalAssetDepoChart = new Chart(ctx, {
                    type: 'bar', // Jenis grafik batang
                    data: {
                        labels: ['Lembang','Majalaya','Padalarang','Sadakeling','Metro','Katapang','Cicalengka','Soreang','Sumedang',
                            'Pangandaran','Tasikmalaya','Penggung','Kuningan','Purwakarta','Kanci','Kasomalang','Pamanukan','Jatisari','Banjarsari','Garut','Jatibarang','Majalengka',
                            'Pelabuhan Ratu','Bogor','Citeureup','Parung','Sukabumi','Cianjur','Sentul','Parung Panjang','Tapos'], // Label untuk grafik
                        datasets: [
                            {
                                label: 'Total Asset', // Nama dataset
                                data: [ttl_lembang,ttl_majalaya,ttl_padalarang,ttl_sadakeling,ttl_metro,ttl_katapang,ttl_cicalengka,ttl_soreang,ttl_sumedang,
                                    ttl_pangandaran,ttl_tasikmalaya,ttl_penggung,ttl_kuningan,ttl_purwakarta,ttl_kanci,ttl_kasomalang,ttl_pamanukan,ttl_jatisari,ttl_banjarsari,ttl_garut,ttl_jatibarang,ttl_majalengka,
                                    ttl_pelabuhan_ratu,ttl_bogor,ttl_citeureup,ttl_parung,ttl_sukabumi,ttl_cianjur,ttl_sentul,ttl_parung_panjang,ttl_tapos
                                ], // Data batang (A, B, C)
                                backgroundColor: ['#4caf50'], // Warna untuk setiap batang
                                borderColor: ['#4caf50'], // Border untuk batang
                                borderWidth: 1,barThickness: 20
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true, // Mulai dari angka 0
                                stacked: true,
                                grid: {
                                    drawBorder: true, // Menampilkan garis horizontal
                                    drawOnChart: true, // Garis grid akan muncul di chart
                                }
                            },
                            x: {
                                stacked: true,
                                grid: {
                                    drawBorder: true, // Menampilkan garis vertikal
                                }
                            }
                        },
                        responsive: true, // Membuat grafik responsif
                        plugins: {
                            legend: {
                                position: 'top', // Posisi legend
                            }
                        }
                    }
                });

            }
        });
    }
</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Dashboard Asset</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Monitoring Asset</li>
        <li class="breadcrumb-item active">Dashboard Asset</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Dashboard Asset</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-2 col-lg-2">
                                        <div class="card text-white bg-success">
                                            <div class="card-body pb-0">
                                                <div>Total Asset</div>
                                                <div class="text-value-lg total_asset" align="center">0</div>
                                                <!-- <h3 class="jumlah_penjualan">0</h3> -->
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-2 col-lg-2"></div>

                                    <div class="col-sm-2 col-lg-2">
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div>Kondisi Baik</div>
                                                <div class="text-value-lg total_baik" align="right">0</div>
                                                <div class="text-value-lg" align="right">0%</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 col-lg-2">
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div>Perlu diganti</div>
                                                <div class="text-value-lg total_perlu_diganti" align="right">0</div>
                                                <div class="text-value-lg" align="right">0%</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 col-lg-2">
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div>Perlu perbaikan</div>
                                                <div class="text-value-lg total_perlu_perbaikan" align="right">0</div>
                                                <div class="text-value-lg" align="right">0%</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 col-lg-2">
                                        <div class="card text-white bg-primary">
                                            <div class="card-body pb-0">
                                                <div>Dlm perbaikan</div>
                                                <div class="text-value-lg total_dalam_perbaikan" align="right">0</div>
                                                <div class="text-value-lg" align="right">0%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <canvas id="totalAssetChart"></canvas>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <canvas id="totalAssetDepoChart"></canvas>
                                    </div>
                                </div>
                                
                            </div>  
                              

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Filter</h4>
                            </div>
                            <div class="card-body">
                            
                                <div class="form-group">
                                        <label for="perusahaan">Perusahaan</label>
                                        <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                        
                                </div>

                                <div class="form-group">
                                        <label for="depo">Depo</label>
                                        <input type="text" name="kode_depo" id="kode_depo" class="form-control" required>
                                        
                                </div>

                                <div class="form-group">
                                        <label for="asset">Jenis Asset/Item</label>
                                        <input type="text" name="asset" id="asset" class="form-control" required>
    
                                </div>
                            
                            </div>
                        </div>
                    </div>

                </div>      

            </form>
        </div>
    </div>
</main>



@endsection