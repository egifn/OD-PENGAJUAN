@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        $("#button_form_approved").click(function() {
            let kode_pengajuan_sppd = $("#kode_pengajuan_sppd").val();
            let total_uang_sppd = $("#uang_sppd").val();
            let jml_sppd = $("#jumlah_sppd").val();
            let subtotal_sppd = $("#total_sppd").val();
            let total_uang_bbm = $("#uang_bbm").val();
            let jml_bbm = $("#jumlah").val();
            let subtotal_bbm = $("#total").val();
            let total_uang_tol = $("#uang_tol").val();
            let jml_tol = $("#jumlah_tol").val();
            let subtotal_tol = $("#total_tol").val();
            let total_uang_parkir = $("#uang_parkir").val();
            let jml_parkir = $("#jumlah_parkir").val();
            let subtotal_parkir = $("#total_parkir").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('sppd_masuk/approved.approved') }}",
                data: {
                    kode_pengajuan_sppd: kode_pengajuan_sppd,
                    total_uang_sppd: total_uang_sppd,
                    jml_sppd: jml_sppd,
                    subtotal_sppd: subtotal_sppd,
                    total_uang_bbm: total_uang_bbm,
                    jml_bbm: jml_bbm,
                    subtotal_bbm: subtotal_bbm,
                    total_uang_tol: total_uang_tol,
                    jml_tol: jml_tol,
                    subtotal_tol: subtotal_tol,
                    total_uang_parkir: total_uang_parkir,
                    jml_parkir: jml_parkir,
                    subtotal_parkir: subtotal_parkir,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('sppd_masuk.index')}}";
                    }else{

                    }
                }
            });
        })

        $('#uang_sppd').maskMoney({thousands:',', decimal:'.', precision:0, allowZero: true, defaultZero: false});
        function jml_total_uang_sppd(){
            var uang_sppd = $('#uang_sppd').val();
            var jml_sppd = $('#jumlah_sppd').val();
            //menghilangka format rupiah//
            var temp_uang = uang_sppd.replace(/[.](?=.*?\.)/g, '');
            var temp_uang_sppd = parseFloat(temp_uang.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah//

            txttotal = temp_uang_sppd * jml_sppd;
            //membuat format rupiah//
            var reverse = txttotal.toString().split('').reverse().join(''),
                ribuan  = reverse.match(/\d{1,3}/g);
                hasil = ribuan.join(',').split('').reverse().join('');
            //End membuat format rupiah//
            $('#total_sppd').val(hasil);
        }

        $('#uang_bbm').maskMoney({thousands:',', decimal:'.', precision:0, allowZero: true, defaultZero: false});
        function jml_total_uang_bbm(){
            var uang_bbm = $('#uang_bbm').val();
            var jml_bbm = $('#jumlah').val();
            //menghilangka format rupiah//
            var temp_uang_b = uang_bbm.replace(/[.](?=.*?\.)/g, '');
            var temp_uang_bbm = parseFloat(temp_uang_b.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah//

            txttotal_bbm = temp_uang_bbm * jml_bbm;
            //membuat format rupiah//
            var reverse_bbm = txttotal_bbm.toString().split('').reverse().join(''),
                ribuan_bbm  = reverse_bbm.match(/\d{1,3}/g);
                hasil_bbm = ribuan_bbm.join(',').split('').reverse().join('');
            //End membuat format rupiah//
            $('#total').val(hasil_bbm);

        }

        $('#uang_tol').maskMoney({thousands:',', decimal:'.', precision:0, allowZero: true, defaultZero: false});
        function jml_total_uang_tol(){
            var uang_tol = $('#uang_tol').val();
            var jml_tol = $('#jumlah_tol').val();
            //menghilangka format rupiah//
            var temp_uang_b = uang_tol.replace(/[.](?=.*?\.)/g, '');
            var temp_uang_tol = parseFloat(temp_uang_b.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah//

            txttotal_tol = temp_uang_tol * jml_tol;
            //membuat format rupiah//
            var reverse_tol = txttotal_tol.toString().split('').reverse().join(''),
                ribuan_tol  = reverse_tol.match(/\d{1,3}/g);
                hasil_tol = ribuan_tol.join(',').split('').reverse().join('');
            //End membuat format rupiah//
            $('#total_tol').val(hasil_tol);

        }

        $('#uang_parkir').maskMoney({thousands:',', decimal:'.', precision:0, allowZero: true, defaultZero: false});
        function jml_total_uang_parkir(){
            var uang_parkir = $('#uang_parkir').val();
            var jml_parkir = $('#jumlah_parkir').val();
            //menghilangka format rupiah//
            var temp_uang_b = uang_parkir.replace(/[.](?=.*?\.)/g, '');
            var temp_uang_parkir = parseFloat(temp_uang_b.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah//

            txttotal_parkir = temp_uang_parkir * jml_parkir;
            //membuat format rupiah//
            var reverse_parkir = txttotal_parkir.toString().split('').reverse().join(''),
                ribuan_parkir  = reverse_parkir.match(/\d{1,3}/g);
                hasil_parkir = ribuan_parkir.join(',').split('').reverse().join('');
            //End membuat format rupiah//
            $('#total_parkir').val(hasil_parkir);

        }

    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Pengajuan Masuk SPPD</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan Masuk</li>
        <li class="breadcrumb-item active">SPPD</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pengajuan Masuk SPPD</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Pelaksana Tugas
                                        <input type="text" name="kode_pengajuan_sppd" id="kode_pengajuan_sppd" class="form-control" value="{{ $view_masuk_sppd->kode_pengajuan_sppd }}" required readonly hidden>
                                        <input type="text" name="pelaksana" class="form-control" value="{{ $view_masuk_sppd->pelaksana }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Divisi
                                        <input type="text" name="divisi" id="divisi" class="form-control" value="{{ $view_masuk_sppd->nama_divisi }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ $view_masuk_sppd->nama_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Depo
                                        <input type="text" name="depo" id="depo" class="form-control" value="{{ $view_masuk_sppd->nama_depo }}" required readonly>
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="col-md-3 mb-2">
                                        Tujuan/Lokasi Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $view_masuk_sppd->tujuan_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-">
                                        Tujuan/Lokasi Depo
                                        <input type="text" name="kode_depo_tujuan" id="kode_depo_tujuan" class="form-control" value="{{ $view_masuk_sppd->tujuan_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Keperluan Tugas
                                        <textarea name="keperluan" id="keperluan" rows="1" class="form-control" readonly>{{ $view_masuk_sppd->keperluan }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Lama Tugas (dari)
                                        <input type="text" name="lama_tugas" id="lama_tugas" class="form-control" value="{{ date('d-M-Y', strtotime($view_masuk_sppd->tgl_mulai)) }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        (sampai)
                                        <input type="text" name="sampai" id="sampai" class="form-control" value="{{ date('d-M-Y', strtotime($view_masuk_sppd->tgl_akhir)) }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Kendaraan yg digunakan
                                        <input type="text" name="kendaraan" id="kendaraan" class="form-control" value="{{ $view_masuk_sppd->kendaraan }}" readonly required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        sebagai
                                        <input type="text" name="sebagai" id="sebagai" class="form-control" value="{{ $view_masuk_sppd->sebagai }}" readonly required>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_masuk_sppd->nama_pengeluaran }}" readonly required>
                                    </div>
                                </div>

                                @if(Auth::user()->kode_divisi == '16') <!-- jika Biaya/cost  -->
                                    <hr>
                                    <span><b>Rincian Biaya:</b></span>
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            Biaya SPPD
                                            @if($rowCount > 0)
                                                <input type="text" name="uang_sppd" id="uang_sppd" class="form-control" style="text-align: right;" value="{{ number_format($rincian_sppd->total_uang) }}" readonly>
                                            @else
                                                <input type="text" name="uang_sppd" id="uang_sppd" class="form-control" style="text-align: right;" value="0" onchange="jml_total_uang_sppd();" onkeyup="jml_total_uang_sppd();" required>
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            x
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            Jumlah
                                            @if($rowCount > 0)
                                                <input type="text" name="jumlah_sppd" id="jumlah_sppd" class="form-control" style="text-align: right;" value="{{ $rincian_sppd->jml }}" readonly>
                                            @else
                                                <input type="text" name="jumlah_sppd" id="jumlah_sppd" class="form-control" style="text-align: right;" value="1" readonly required>
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            =
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            total
                                            @if($rowCount > 0)
                                                <input type="text" name="total_sppd" id="total_sppd" class="form-control" style="text-align: right;" value="{{ number_format($rincian_sppd->subtotal) }}" readonly>
                                            @else
                                                <input type="text" name="total_sppd" id="total_sppd" class="form-control" style="text-align: right;" value="0" readonly required>
                                            @endif
                                            
                                        </div>
                                        <div class="col-md-5 mb-2" hidden>
                                            Nama Pengeluaran
                                            <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_masuk_sppd->nama_pengeluaran }}" readonly required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            Biaya BBM
                                            @if($view_masuk_sppd->sebagai == 'Pengemudi')
                                                @if($rowCount > 0)
                                                    <input type="text" name="uang_bbm" id="uang_bbm" class="form-control" style="text-align: right;" value="{{ number_format($rincian_bbm->total_uang) }}" readonly>
                                                @else
                                                    <input type="text" name="uang_bbm" id="uang_bbm" class="form-control" style="text-align: right;" value="{{ number_format($data_bbm->uang) }}" onchange="jml_total_uang_bbm();" onkeyup="jml_total_uang_bbm();" required>
                                                @endif
                                            @else
                                                @if($rowCount > 0)
                                                    <input type="text" name="uang_bbm" id="uang_bbm" class="form-control" style="text-align: right;" value="{{ number_format($rincian_bbm->total_uang) }}" readonly>
                                                @else
                                                    <input type="text" name="uang_bbm" id="uang_bbm" class="form-control" style="text-align: right;" value="0" onchange="jml_total_uang_bbm();" onkeyup="jml_total_uang_bbm();" required>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            x
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            Jumlah
                                            @if($rowCount > 0)
                                                <input type="text" name="jumlah" id="jumlah" class="form-control" style="text-align: right;" value="{{ $rincian_bbm->jml }}" readonly required>
                                            @else
                                                <input type="text" name="jumlah" id="jumlah" class="form-control" style="text-align: right;" value="1" readonly required>
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            =
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            total
                                            @if($view_masuk_sppd->sebagai == 'Pengemudi')
                                                @if($rowCount > 0)
                                                    <input type="text" name="total" id="total" class="form-control" style="text-align: right;" value="{{ number_format($rincian_bbm->subtotal) }}" readonly>
                                                @else
                                                    <input type="text" name="total" id="total" class="form-control" style="text-align: right;" value="{{ number_format($data_bbm->uang * 1) }}" readonly required>
                                                @endif
                                            @else
                                                @if($rowCount > 0)
                                                    <input type="text" name="total" id="total" class="form-control" style="text-align: right;" value="{{ number_format($rincian_bbm->subtotal) }}" readonly>
                                                @else
                                                    <input type="text" name="total" id="total" class="form-control" style="text-align: right;" value="0" readonly required>
                                                @endif 
                                            @endif
                                            </div>
                                        <div class="col-md-5 mb-2" hidden>
                                            Nama Pengeluaran
                                            <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_masuk_sppd->nama_pengeluaran }}" readonly required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            Biaya Tol
                                            @if($rowCount > 0)
                                                <input type="text" name="uang_tol" id="uang_tol" class="form-control" style="text-align: right;" value="{{ number_format($rincian_tol->total_uang) }}" readonly>
                                            @else
                                                <input type="text" name="uang_tol" id="uang_tol" class="form-control" style="text-align: right;" value="0" onchange="jml_total_uang_tol();" onkeyup="jml_total_uang_tol();" required>
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            x
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            Jumlah
                                            @if($rowCount > 0)
                                            <input type="text" name="jumlah_tol" id="jumlah_tol" class="form-control" style="text-align: right;" value="{{ $rincian_tol->jml }}" readonly>
                                            @else
                                                <input type="text" name="jumlah_tol" id="jumlah_tol" class="form-control" style="text-align: right;" value="1" readonly required>
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            =
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            total
                                            @if($rowCount > 0)
                                                <input type="text" name="total_tol" id="total_tol" class="form-control" style="text-align: right;" value="{{ number_format($rincian_tol->subtotal) }}" readonly>
                                            @else
                                                <input type="text" name="total_tol" id="total_tol" class="form-control" style="text-align: right;" value="0" readonly required>
                                            @endif
                                        </div>
                                        <div class="col-md-5 mb-2" hidden>
                                            Nama Pengeluaran
                                            <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_masuk_sppd->nama_pengeluaran }}" readonly required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            Biaya Parkir
                                            @if($rowCount > 0)
                                                <input type="text" name="uang_parkir" id="uang_parkir" class="form-control" style="text-align: right;" value="{{ number_format($rincian_parkir->total_uang) }}" readonly>
                                            @else
                                                <input type="text" name="uang_parkir" id="uang_parkir" class="form-control" style="text-align: right;" value="0" onchange="jml_total_uang_parkir();" onkeyup="jml_total_uang_parkir();" required>
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            x
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            Jumlah
                                            @if($rowCount > 0)
                                                <input type="text" name="jumlah_parkir" id="jumlah_parkir" class="form-control" style="text-align: right;" value="{{ $rincian_parkir->jml }}" readonly>
                                            @else
                                                <input type="text" name="jumlah_parkir" id="jumlah_parkir" class="form-control" style="text-align: right;" value="1" readonly required>
                                            @endif
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <br>
                                            =
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            total
                                            @if($rowCount > 0)
                                                <input type="text" name="total_parkir" id="total_parkir" class="form-control" style="text-align: right;" value="{{ number_format($rincian_parkir->subtotal) }}" readonly required>
                                            @else
                                                <input type="text" name="total_parkir" id="total_parkir" class="form-control" style="text-align: right;" value="0" readonly required>
                                            @endif
                                        </div>
                                        <div class="col-md-5 mb-2" hidden>
                                            Nama Pengeluaran
                                            <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_masuk_sppd->nama_pengeluaran }}" readonly required>
                                        </div>
                                    </div>
                                @endif
                                

                                {{-- <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Uang Makan
                                        <input type="text" name="lama_tugas" id="lama_tugas" class="form-control" value="{{ $view_masuk_sppd->tgl_mulai }}" readonly required>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        x
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Jumlah
                                        <input type="text" name="sampai" id="sampai" class="form-control" value="{{ $view_masuk_sppd->tgl_akhir }}" readonly required>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <br>
                                        =
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        total
                                        <input type="text" name="sebagai" id="sebagai" class="form-control" value="{{ $view_masuk_sppd->sebagai }}" readonly required>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" type="text" class="form-control" value="{{ $view_masuk_sppd->nama_pengeluaran }}" readonly required>
                                    </div>
                                </div> --}}

                                <br>
                                <div class="row">
                                    @if(Auth::user()->kode_divisi == '1') <!-- Jika Hrd-->

                                        @if($view_masuk_sppd->status_hrd == '0')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                            </div>
                                        @elseif($view_masuk_sppd->status_hrd == '1')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>     
                                        @elseif($view_masuk_sppd->status_hrd == '2')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>                   
                                        @elseif($view_masuk_sppd->status_hrd == '3')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                            </div>
                                        @endif

                                    @elseif(Auth::user()->kode_divisi == '16') <!-- Jika cost/Biaya -->
                                        @if($view_masuk_sppd->status_validasi_adm_biaya == '0')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                            </div>
                                        @elseif($view_masuk_sppd->status_validasi_adm_biaya == '1')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>     
                                        @elseif($view_masuk_sppd->status_validasi_adm_biaya == '2')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>                   
                                        @elseif($view_masuk_sppd->status_validasi_adm_biaya == '3')
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                            </div>
                                        @endif
                                    @endif
                            
                                    <div class="col-md-10 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</main>


@endsection

@section('script')



@endsection




