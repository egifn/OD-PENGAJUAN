@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        $("#button_form_approved").click(function() {
            if ($("#penerima").val() == ""){
                alert("Nama Penerima Tidak boleh kosong...!");
                $("#penerima").focus();
                return (false);
            }

            let kode_pengajuan = $("#kode").val();
            let penerima = $("#penerima").val();
            let no_urut = $("#no_urut").val();
            let kode_depo = $("#kode_depo").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('serah_terima_user/approved.approved') }}",
                data: {
                    kode_pengajuan: kode_pengajuan,
                    penerima: penerima,
                    no_urut: no_urut,
                    kode_depo: kode_depo,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('serah_terima_user.index')}}";
                    }else{

                    }
                }
            });
        });

        function show_my_pdf() {
            if ($("#penerima").val() == ""){
                alert("Nama Penerima Tidak boleh kosong...!");
                $("#penerima").focus();
                return (false);
            }

            let kode_pengajuan = $("#kode").val();
            let penerima = $("#penerima").val();
            let no_urut = $("#no_urut").val();
            $.ajax({
                type: "GET",
                url: "{{ route('serah_terima_user/approved/pdf') }}",
                data: {
                    kode_pengajuan: kode_pengajuan,
                    no_urut: no_urut,
                },
                dataType: "json",
                success: function(response) {
                    
                }
            });
            window.open("{{ route('serah_terima_user/approved/pdf') }}?no_urut=" + no_urut + "", '_blank');
           
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Detail Pengajuan Barang</title>
@endsection

@section('content')


<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item active">Detail Pengajuan Barang</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Pengajuan Barang - {{ $pengajuan_v->kode_pengajuan }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2" hidden>
                                        Id Pengajuan
                                        <input type="text" name="kode" id="kode" class="form-control" value="{{ $pengajuan_v->kode_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $pengajuan_v->no_urut }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_v->tgl_pengajuan }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama_pemohon" class="form-control" value="{{ $pengajuan_v->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        Perusahaan
                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $pengajuan_v->nama_perusahaan }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="hidden" name="kode_depo" id="kode_depo" class="form-control" value="{{ $pengajuan_v->kode_depo }}" readonly>
                                        <input type="text" name="nama_depo" class="form-control" value="{{ $pengajuan_v->nama_depo }}" readonly>
                                    </div>
                                </div>

                                <div class="row" >    
                                    <div class="col-md-4 mb-2" hidden>
                                        Kategori Pengeluaran
                                        <input type="text" name="kategori_pengeluaran" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-4 mb-2" hidden>
                                        Keterangan
                                        <input type="text" name="ket" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-5 mb-2" hidden>
                                        Pengajuan
                                        <input type="text" name="pengajuan" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_v->nama_pengeluaran }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Penerima
                                        <input type="text" name="penerima" id="penerima" class="form-control" value="" required>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Sifat Pengeluaran
                                        <input type="text" name="sifat_pengeluaran" class="form-control" value="{{ $pengajuan_v->sifat }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Jenis Pengeluaran
                                        <input type="text" name="jenis_pengeluaran" class="form-control" value="{{ $pengajuan_v->jenis }}" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        Sistem Pembayaran
                                        <input type="text" name="sistem_pengeluaran" class="form-control" value="{{ $pengajuan_v->pembayaran }}" readonly>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    
                
                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:150px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Id Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Merk</th>
                                                    <th>Spek</th>
                            
                                                    <th>Qty Pengajuan</th>
                                                    <th>Qty Approved</th>
                                                    <th>Satuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1 ?>
                                                @forelse($details as $val)

                                                <tr>
                                                    <td>{{ $i }}</td>
                                    
                                                    <td class="kode_produk">
                                                        <input class="form-control" type="text" name="kode_produk[]" id="kode_produk{{ $i }}" value="{{ $val->kode_product }}" hidden/>{{ $val->kode_product }}
                                                    </td>
                                                    <td class="nama_produk">
                                                        <input class="form-control" type="text" name="nama_produk[]" id="nama_produk{{ $i }}" value="{{ $val->nama_barang  }}" hidden/>{{ $val->nama_barang }}
                                                    </td>
                                                    <td class="merk">
                                                        <input class="form-control" type="text" name="merk[]" id="merk{{ $i }}" value="{{ $val->merk }}" hidden/>{{ $val->merk }}
                                                    </td>
                                                    <td class="ket">
                                                        <input class="form-control" type="text" name="ket[]" id="ket{{ $i }}" value="{{ $val->ket }}" hidden/>{{ $val->ket }}
                                                    </td>
                                                    <td class="qty" align="right">
                                                        <input style="text-align: right" class="form-control" type="text" name="qty[]" id="qty{{ $i }}" value="{{ $val->qty }}" hidden/>{{ $val->qty }}
                                                    </td>
                                                    <td class="qty_ga" align="right">
                                                        {{-- <input type="text" name="qty_ops[]{{ $i }}" id="qty_ops[]{{ $i }}" style="text-align: right; width: 30px;" class="form-control"  value="{{ $val->qty }}"/> --}}
                                                        <input type="text" name="qty_ga[]{{ $i }}" id="qty_ga{{ $i }}" style="text-align: right; height: 20px; width: 50px;"" class="form-control" value="{{ $val->qty_ga }}" hidden>{{ $val->qty_ga }}
                                                    </td>
                                                    
                                                    <!-- filterisasi Qty -->
                                                    <td class="satuan">
                                                        <input class="form-control" type="text" name="satuan[]" id="satuan{{ $i }}" value="{{ $val->satuan }}" hidden/>{{ $val->satuan }}
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <?php $i++; ?>
                                                @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data yang tersedia</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-success btn-sm float-right" id="button_form_approved" onclick="show_my_pdf()">Serah Terima</button> 
                                        <button class="btn btn-primary btn-sm" onclick="goBack()">K e m b a l i</button>
                                        
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


