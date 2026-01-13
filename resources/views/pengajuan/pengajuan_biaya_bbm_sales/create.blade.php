@section('js')
    <script type="text/javascript">
        function getHarga() {
            var kode_bbm = document.getElementById("bahan_bakar").value;
            //================================================================
            var kodeBbmComboBox = document.getElementById("bahan_bakar");
            var selectedIndex = kodeBbmComboBox.selectedIndex;
            var selectedOption = kodeBbmComboBox.options[selectedIndex];
            var namaBbmValue = selectedOption.getAttribute("data-nama-perusahaan");

            //membuat format rupiah Harga//
            var reverse_harga = namaBbmValue.toString().split('').reverse().join(''),
                ribuan_harga = reverse_harga.match(/\d{1,3}/g);
            harga_rupiah = ribuan_harga.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            document.getElementById("hargaliter").value = namaBbmValue;
            document.getElementById("hargaliter_rupiah").value = harga_rupiah;
            //================================================================
        }

        function jumlah() {
            var harga_bbm = document.getElementById("hargaliter").value;
            var liter = document.getElementById("liter").value;
            total_harga = (harga_bbm) * (liter);

            //membuat format rupiah Harga//
            var reverse_harga = total_harga.toString().split('').reverse().join(''),
                ribuan_harga = reverse_harga.match(/\d{1,3}/g);
            harga_rupiah = ribuan_harga.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            document.getElementById("total").value = harga_rupiah;
        }
    </script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Pengajuan Biaya BBM Sales</title>
@endsection

@section('content')



    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Pengajuan</li>
            <li class="breadcrumb-item">Pengajuan Biaya BBM Sales</li>
            <li class="breadcrumb-item active">Buat Pengajuan</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <form action="{{ route('pengajuan_biaya_bbm_sales.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Buat Pengajuan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-2" hidden>
                                            Tanggal
                                            <input type="text" name="tgl" id="tgl" class="form-control"
                                                value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}"
                                                required>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            No Kendaraan
                                            <input type="text" name="no_kendaraan" id="no_kendaraan" class="form-control"
                                                required>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Nama Driver
                                            <input type="text" name="driver" id="driver" class="form-control"
                                                value="" required>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            Divisi
                                            <select name="divisi" id="divisi" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="Galon">Galon</option>
                                                <option value="SPS">SPS</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            Segmen
                                            <select name="segmen" id="segmen" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="AFH">FH</option>
                                                <option value="AHS">AHS</option>
                                                <option value="Canvasser">Canvasser</option>
                                                <option value="Dropping Galon">Dropping Galon</option>
                                                <option value="MT BKL">MT BKL</option>
                                                <option value="MT SPS">MT SPS</option>
                                                <option value="Retail Galon">Retail Galon</option>
                                                <option value="Semi Dropping">Semi Dropping</option>
                                                <option value="SO SPS">SO SPS</option>
                                                <option value="Semi Dropping">Semi Dropping</option>
                                                <option value="VIT">VIT</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            Km. Kendaraan
                                            <input type="text" name="km_kendaraan" id="km_kendaraan" class="form-control"
                                                value="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            Nama Bahan Bakar
                                            <select name="bahan_bakar" id="bahan_bakar" class="form-control"
                                                onchange="getHarga();" required>
                                                <option value="">select</option>
                                                @foreach ($bbm as $row)
                                                    <option value="{{ $row->kode_bbm }}"
                                                        data-nama-perusahaan="{{ $row->harga_perliter }}"
                                                        {{ old('kode_bbm') == $row->kode_bbm ? 'selected' : '' }}>
                                                        {{ $row->nama_bbm }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Harga/Liter
                                            <input type="hidden" name="hargaliter" id="hargaliter" class="form-control"
                                                value="" required readonly>
                                            <input type="text" name="hargaliter_rupiah" id="hargaliter_rupiah"
                                                class="form-control" value="" required readonly>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Liter
                                            <input type="text" name="liter" id="liter" class="form-control"
                                                value="" onkeyup="jumlah()" required>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            Total Rupiah
                                            <input type="text" name="total" id="total" class="form-control"
                                                value="" required readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            No Faktur
                                            <input type="text" name="no_faktur" id="no_faktur" class="form-control"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <strong>Lampiran/Attachment</strong>
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="filename[]"
                                                    id="filename_1" multiple>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-danger"
                                                        id="button_hapus_lampiran" style="height: 40px;"> <span
                                                            class="fa fa-eraser"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 mb-2" align="right">
                                            <br>
                                            <button class="btn btn-warning">B a t a l</button>
                                            <button class="btn btn-success">Buat Pengajuan</button>
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

    {{-- <div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_category" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Pengeluaran</th>
                                <th>Sifat</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}



@endsection

@section('script')



@endsection
