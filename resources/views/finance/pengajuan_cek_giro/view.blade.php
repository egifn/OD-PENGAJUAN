@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function cekDataDatabase(no) {
            // Ambil nilai dari input
            var jenisBuku = $('#jenis_buku_' + no).val();
            var kodeJenisBuku = $('#jenis_buku_' + no).val().charAt(0);
            var kodePerusahaan = $('#kode_perusahaan_' + no).val();
            var kodeWarkat = $('#kode_warkat_' + no).val();
            var seriAwal = $('#seri_awal_' + no).val();

            console.log(kodePerusahaan);
            // Lakukan AJAX request ke server
            if (kodeWarkat !== "" && seriAwal !== "") {
                $.ajax({
                    url: '{{ route('cek_izin') }}', // URL yang di-generate oleh Laravel
                    method: 'GET', // Karena route yang kamu buat menggunakan GET
                    data: {
                        jenis_buku: jenisBuku,
                        kode_perusahaan: kodePerusahaan,
                        kode_warkat: kodeWarkat,
                        seri_awal: seriAwal
                    },
                    success: function(response) {
                        if (response.exists) {
                            // Jika data sudah ada, tampilkan peringatan
                            alert('Data dengan kode : ' + kodeJenisBuku + '-' + kodeWarkat + seriAwal +
                                ' di Perusahaan ini sudah ada di database!');
                            $('#kode_warkat_' + no).val('');
                            $('#seri_awal_' + no).val('');
                            $('#seri_akhir_' + no).val('');
                            $('#jml_lembar_' + no).val('');
                        }
                    }
                });
            }
        }

        // Tambahkan keyup event pada input field
        $(document).on('keyup', 'input[name="kode_warkat[]"], input[name="seri_awal[]"]', function() {
            var inputId = $(this).attr('id'); // Ambil ID dari input yang diubah
            var no = inputId.split('_').pop(); // Ambil nomor dari ID input (misal: kode_warkat_1 -> 1)
            cekDataDatabase(no); // Panggil fungsi cek data
        });
    </script>

    <script type="text/javascript">
        var x = 1;

        function chk_jumlah(index) {
            // Ambil checkbox
            var checkbox = document.getElementById('chk_' + index);

            // Ambil kolom input yang akan diaktifkan
            var kodeWarkat = document.getElementById('kode_warkat_' + index);
            var seriAwal = document.getElementById('seri_awal_' + index);
            var seriAkhir = document.getElementById('seri_akhir_' + index);

            // Aktifkan atau non-aktifkan input sesuai dengan status checkbox
            var isChecked = checkbox.checked;
            kodeWarkat.disabled = !isChecked;
            seriAwal.disabled = !isChecked;
            seriAkhir.disabled = !isChecked;
        }

        // function jumlah(index) {
        //     var seriAwal = document.getElementById('seri_awal_' + index).value;

        //     if (seriAwal !== "") {
        //         // Hitung seri akhir berdasarkan seri awal (seri akhir = seri awal + 24)
        //         var seriAkhir = parseInt(seriAwal) + 24;

        //         // Set nilai seri akhir
        //         document.getElementById('seri_akhir_' + index).value = seriAkhir;

        //         // Set nilai jumlah lembar ke 25
        //         document.getElementById('jml_lembar_' + index).value = 25;
        //         document.getElementById('hidden_jml_lembar_' + index).value = 25;
        //     }
        // }

		function jumlah(index) {
            var seriAwal = document.getElementById('seri_awal_' + index).value;
            var seriAkhir = document.getElementById('seri_akhir_' + index).value;

            if (isNaN(seriAwal) || isNaN(seriAkhir)) {
                alert("Masukkan nilai yang valid untuk seri awal dan seri akhir.");
                return; // Tidak lanjutkan proses jika input tidak valid
            }

            var jumlah = parseInt(seriAkhir) - parseInt(seriAwal) + 1;

            if (jumlah >= 0) {
                document.getElementById('jml_lembar_' + index).value = jumlah;
                document.getElementById('hidden_jml_lembar_' + index).value = jumlah;
            } else {
                document.getElementById('jml_lembar_' + index).value = '';
                document.getElementById('hidden_jml_lembar_' + index).value = '';
            }
        }

        $(document).ready(function () {
            $('#storeForm').on('submit', function (e) {
                e.preventDefault();

                $("button").prop("disabled", true);
                $('#loading').show();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // alert('Data berhasil disimpan!');
                        $('#loading').hide();
                        window.location.href = "{{ route('pengajuan_cek_giro.index')}}";
                    },
                    error: function (xhr, status, error) {
                        alert('Terjadi kesalahan!');
                        $('#loading').hide();
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#select-all').change(function() {
                var isChecked = $(this).prop('checked');
                $('input[name="chk[]"]').prop('checked', isChecked);

                if (isChecked) {
                    $('input[type="text"]').prop('disabled', false);
                } else {
                    $('input[type="text"]').prop('disabled', true);
                }
            });
        });

    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Terima Cek/Giro</title>
@endsection

@section('content')

    <main class="main">
        <style>
            #loading {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999; /* Pastikan spinner berada di atas elemen lain */
                background-color: rgba(0, 0, 0, 0.5); /* Untuk memberikan latar belakang transparan */
                padding: 20px;
                border-radius: 5px;
            }
            
            .spinner {
                width: 40px;
                height: 40px;
                border: 5px solid rgba(0, 0, 0, 0.1); /* Warna border luar */
                border-top: 5px solid #3498db; /* Warna border atas untuk efek spinner */
                border-radius: 50%;
                animation: spin 1s linear infinite; /* Animasi berputar */
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Pengajuan Cek/Giro</li>
            <li class="breadcrumb-item active">Terima Cek/Giro</li>
        </ol>
        <div class="container-fluid">
            <div id="loading" style="display: none;">
                <div class="spinner"></div>
            </div>

            <div class="animated fadeIn">
                <form id="storeForm" action="{{ route('store_terima.store_terima') }}" method="post" onkeypress="return event.keyCode != 13"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Terima Cek/Giro</h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                Tanggal Izin
                                                <input type="date" name="tgl" id="tgl" class="form-control" required>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                No.Izin
                                                <input type="text" name="no_izin" id="no_izin" class="form-control"
                                                    value="" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Judul Izin <!-- Keterangan -->
                                                <input type="text" name="judul_izin" id="judul_izin" value="PENAMBAHAN SALDO 2A DARI BANK"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Catatan <!-- Keterangan -->
                                                <input type="text" name="catatan" id="catatan" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                Pengambil
                                                <select name="kode_penerima_resi" id="kode_penerima_resi"
                                                    class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="1">Ratna pany</option>
                                                    <option value="2">Cinta M.Tampubolon</option>
                                                    <option value="3">Razel G. kaawoan</option>
                                                    <option value="4">Nany Enggawati</option>
                                                    <option value="5">Amelina</option>
                                                    <option value="6">Lie Kwie Moy</option>
                                                </select>
                                            </div>
                                            {{-- <div class="col-md-2 mb-2" hidden>
                                                Kode Permintaan <!-- Keterangan -->
                                                <input type="text" name="kode_permintaan" id="kode_permintaan"
                                                    class="form-control" value="">
                                            </div> --}}


                                            <div class="col-md-1 mb-2" hidden>
                                                Jml lembar <!-- Keterangan -->
                                                <input type="text" name="jml_lembar" id="jml_lembar"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2" hidden>
                                                perusahaan <!-- Keterangan -->
                                                <input type="text" name="perusahaan" id="perusahaan"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2" hidden>
                                                Nama Perusahaan <!-- Keterangan -->
                                                <input type="text" name="nm_perusahaan" id="nm_perusahaan"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-2 mb-2" hidden>
                                                Bank <!-- Keterangan -->
                                                <input type="text" name="bank" id="bank" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2" hidden>
                                                Nama Bank <!-- Keterangan -->
                                                <input type="text" name="nm_bank" id="nm_bank" class="form-control">
                                            </div>

                                            <div class="col-md-2 mb-2" hidden>
                                                No Rekening <!-- Keterangan -->
                                                <input type="text" name="no_rekening" id="no_rekening"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2" hidden>
                                                Kode Seri Warkat <!-- Keterangan -->
                                                <input type="text" name="kd_sr_warkat" id="kd_sr_warkat"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2" hidden>
                                                Seri Awal <!-- Keterangan -->
                                                <input type="text" name="awal" id="awal" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2" hidden>
                                                Seri Akhir <!-- Keterangan -->
                                                <input type="text" name="akhir" id="akhir" class="form-control">
                                            </div>
                                            <div class="col-md-2 mb-2" hidden>
                                                Jenis <!-- Keterangan -->
                                                <input type="text" name="jenis_w" id="jenis_w" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 mb-4">
                                        <div class="nav-tabs-boxed">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#warkat"
                                                        role="tab" aria-controls="warkat">
                                                        <i class="nav-icon icon-folder"></i>
                                                        &nbsp;<b>Warkat</b>
                                                    </a>
                                                </li>
                                                <li class="nav-item" hidden>
                                                    <a class="nav-link" data-toggle="tab" href="#rincian" role="tab"
                                                        aria-controls="rincian">
                                                        <i class="nav-icon icon-folder"></i>
                                                        &nbsp;<b>Rincian Warkat</b>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="warkat" role="tabpanel">
                                                    <br>
                                                    <div class="table-responsive">
                                                        <div style="border:1px white;height:250px;overflow-y:scroll;">
                                                            <table class="table table-bordered table-striped table-sm"
                                                                id="tabelwarkat">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="select-all" class="float-right"></th>
                                                                        <th>No</th>
                                                                        <th hidden>Kode Pengajuan</th>
                                                                        <th hidden>Kode_perusahaan</th>
                                                                        <th>Perusahaan</th>
                                                                        <th hidden>Kode_bank</th>
                                                                        <th>Bank</th>
                                                                        <th>No Rekening</th>
                                                                        <th>Kode Seri Warkat</th>
                                                                        <th>No Seri Awal</th>
                                                                        <th>No Seri Akhir</th>
                                                                        <th>Jenis Warkat</th>
                                                                        <th>Jml Lembar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="table_warkat">
                                                                    @php $no = 1; @endphp
                                                                    @forelse ($details as $row)
                                                                        @for ($i = 0; $i < $row->sisa_banyak_buku; $i++)
                                                                            <tr>
                                                                                <input type="hidden" id="kode_permintaan"
                                                                                    name="kode_permintaan"
                                                                                    value="{{ $row->kode_pengajuan_cek }}">
                                                                                <td><input name="chk[]"
                                                                                        id="chk_{{ $no }}"
                                                                                        type="checkbox" class="checkbox"
                                                                                        onclick="chk_jumlah( {{ $no }} )"
                                                                                        data-index="{{ $no }}"
                                                                                        value="{{ $no }}" /></td>
                                                                                <td>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="nomor[]"
                                                                                        id="nomor_{{ $no }}"
                                                                                        value = "{{ $no }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $no }}
                                                                                </td>
                                                                                <td hidden>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="kode_pengajuan_cek[]"
                                                                                        id="kode_pengajuan_cek_{{ $no }}"
                                                                                        value = "{{ $row->kode_pengajuan_cek }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $row->kode_pengajuan_cek }}
                                                                                </td>
                                                                                <td hidden>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="kode_perusahaan[]"
                                                                                        id="kode_perusahaan_{{ $no }}"
                                                                                        value = "{{ $row->kode_perusahaan }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $row->kode_perusahaan }}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="nama_perusahaan[]"
                                                                                        id="nama_perusahaan_{{ $no }}"
                                                                                        value = "{{ $row->nama_perusahaan }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $row->nama_perusahaan }}
                                                                                </td>
                                                                                <td hidden>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="kode_bank[]"
                                                                                        id="kode_bank_{{ $no }}"
                                                                                        value = "{{ $row->kode_bank }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $row->kode_bank }}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="nama_bank[]"
                                                                                        id="nama_bank_{{ $no }}"
                                                                                        value = "{{ $row->nama_bank }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $row->nama_bank }}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="no_rekening[]"
                                                                                        id="no_rekening_{{ $no }}"
                                                                                        value = "{{ $row->no_rekening }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $row->no_rekening }}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="kode_warkat[]"
                                                                                        id="kode_warkat_{{ $no }}"
                                                                                        value = ""
                                                                                        style="font-size: 13px;" disabled>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="seri_awal[]"
                                                                                        id="seri_awal_{{ $no }}"
                                                                                        value=""
                                                                                        onkeyup="jumlah( {{ $no }} )"
                                                                                        style="font-size: 13px;" disabled>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="seri_akhir[]"
                                                                                        id="seri_akhir_{{ $no }}"
                                                                                        value=""
                                                                                        onkeyup="jumlah( {{ $no }} )"
                                                                                        style="font-size: 13px;" disabled>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="jenis_buku[]"
                                                                                        id="jenis_buku_{{ $no }}"
                                                                                        value = "{{ $row->jenis_buku }}"
                                                                                        style="font-size: 13px;">
                                                                                    {{ $row->jenis_buku }}
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        style="height: 30px;"
                                                                                        class="form-control"
                                                                                        name="jml_lembar[]"
                                                                                        id="jml_lembar_{{ $no }}"
                                                                                        value = ""
                                                                                        style="font-size: 13px;" disabled>
                                                                                </td>
                                                                                <input type="hidden"
                                                                                    id="hidden_jml_lembar_{{ $no }}"
                                                                                    name="hidden_jml_lembar[]" />
                                                                                @php $no++; @endphp
                                                                            </tr>
                                                                        @endfor
                                                                    @empty

                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="rincian" role="tabpanel">
                                                    <br>
                                                    <div class="table-responsive">
                                                        <div style="border:1px white;height:250px;overflow-y:scroll;">
                                                            <table class="table table-bordered table-striped table-sm"
                                                                id="tabelRincian">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No Warkat</th>
                                                                        <th hidden>No Warkat</th>
                                                                        <th hidden>Kode Perusahaan</th>
                                                                        <th>Perusahaan</th>
                                                                        <th hidden>KodeBank</th>
                                                                        <th>Bank</th>
                                                                        <th>No.Rek</th>
                                                                        <th>Seri Warkat</th>
                                                                        <th>Awal</th>
                                                                        <th>Akhir</th>
                                                                        <th>jenis</th>
                                                                        <th hidden>Lembar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">

                                            <div class="col-md-12 mb-2">
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm float-right">Simpan</button>
                                            </div>
                                        </div>
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

@section('script')



@endsection
