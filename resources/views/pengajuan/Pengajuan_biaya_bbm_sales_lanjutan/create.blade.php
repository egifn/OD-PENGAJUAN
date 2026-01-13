@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script> 
    $(document).ready(function() {
        //INISIASI DATERANGEPICKER
        $('#tanggal').daterangepicker({
               
        })        
    })
</script>

<script type="text/javascript">
    $("#button_simpan").click(function() {
        let id_pengeluaran = $("#id_pengeluaran").val();
        let kode_perusahaan = $("#kode_perusahaan").val();
        let kode_depo = $("#kode_depo").val();
        let kode_divisi = $("#kode_divisi").val();
        let kode_perusahaan_tujuan = $("#kode_perusahaan").val();
        let keterangan = $("#ket").val();
        let tgl_pengisian = $("#tanggal").val();

        let jml_liter = $("#jml_liter").val();
        let jml_total = $("#jml_total").val();

        let kode_pengajan_bbm = []
        $('.kode_pengajan_bbm').each(function() {
            kode_pengajan_bbm.push($(this).text())
        })

        var filename = $("#filename").val();

        // var input = document.getElementById('filename');
        // var files = input.files;
        // var fileCount = files.length;
        // var filenames = [];
        // for (var i = 0; i < fileCount; i++) {
        //     filenames.push(files[i].name);
        // }
        // alert(filenames);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_b_bbm_sales_lnjtn/store.store') }}",
            data: {
                id_pengeluaran: id_pengeluaran,
                kode_perusahaan: kode_perusahaan,
                kode_depo: kode_depo,
                kode_divisi: kode_divisi,
                kode_perusahaan_tujuan: kode_perusahaan_tujuan,
                keterangan: keterangan,
                tgl_pengisian: tgl_pengisian,

                jml_liter: jml_liter,
                jml_total: jml_total,

                kode_pengajan_bbm: kode_pengajan_bbm,
                filename: filename,

            },
            success: function(response) {
                if(response.res === true) {
                    $("#ket").val();

                    // $('.tabledata').remove('');
                    // $('.cari_produk').val('');
                    // $('#f_subtotal').val(0);
                    // $('#f_total').val(0);
                    // $('#f_jml_bayar').val(0);
                    // $(".f_kembali").text(0);

                    window.location.href = "{{ route('pengajuan_b_bbm_sales_lnjtn.index')}}";
                }else{
                    //Swal.fire("Gagal!", "Data transaksi penjualan gagal disimpan.", "error");
                    window.location.href = "{{ route('pengajuan_b_bbm_sales_lnjtn.index')}}";
                }
            }
        });

    });
    
</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Pengajuan BBM Sales</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Biaya BBM Sales</li>
        <li class="breadcrumb-item active">Buat Pengajuan BBM Sales</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan_b_bbm_sales_lnjtn/cari.cari') }}" method="get">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pengajuan Biaya BBM Sales</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" id="name" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control" value="{{Auth::user()->kode_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="kode_depo" id="kode_depo" class="form-control" value="{{Auth::user()->kode_depo}}" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2" hidden>
                                        Nama Pengeluaran
                                        <div class="input-group">
                                            <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" value="19" required >
                                            <input id="nama_pengeluaran" type="text" class="form-control" value="BBM Sales" readonly required>
                                            <input id="sifat" type="hidden" name="sifat" class="form-control" value="Rutin"  required>
                                            <input id="jenis" type="hidden" name="jenis" class="form-control"  value="Barang" required>
                                            <input id="pembayaran" type="hidden" name="pembayaran" class="form-control" value="Kredit" required>
                                            <input id="kategori" type="hidden" name="kategori" class="form-control" value="Kontrabon" required>
                                            <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Untuk Perusahaan
                                        <select name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control">
                                            <option value="">select</option>
                                             
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" id="ket" class="form-control" value="{{ request()->ket }}" required>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Tgl pengisian yang diajukan
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    </div>

                                    <div class="col-md-1 mb-2">
                                        <br>
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6 mb-2" hidden>
                                        C O A
                                        <div class="input-group">
                                            <input id="coa" type="text" class="form-control" readonly >
                                            <input id="kode_coa" type="hidden" name="kode_coa" value=""  readonly>
                                            <input id="debit" type="hidden" name="debit" value="" readonly>
                                            <input id="kredit" type="hidden" name="kredit" value="" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalCoa"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="">
                                    </div>
                                </div>
                                
                                <div class="row" hidden>
                                    <div class="col-md-2 mb-2">
                                        Division
                                        <input type="text" name="kode_divisi" id="kode_divisi" class="form-control" value="{{Auth::user()->kode_divisi}}" required readonly>
                                    </div>                                    
                                </div>

                                <div class="row">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <form id="savedatas">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>Kode Pengajuan Bbm</th>
                                                    <th>No Faktur</th>
                                                    <th>Tgl Faktur</th>
                                                    <th>No Kendaraan</th>
                                                    <th>Sales Driver</th>
                                                    {{-- <th>Divisi</th> --}}
                                                    <th>Segmen</th>
                                                    <th>KM Akhir</th>
                                                    {{-- <th hidden>kode_bbm</th> --}}
                                                    <th>Jenis BBM</th>
                                                    <th>Volume/liter</th>
                                                    <th>Harga/liter</th>
                                                    <th>Jumlah</th>
                                                    <th>Attachment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1 ?>
                                                @forelse($pengajuan_bbm as $val)
                                                <tr>
                                                    <td>
                                                        {{ $no }}
                                                    </td>
                                                    <td class="kode_pengajan_bbm" hidden>
                                                        <input type="text" class="form-control" name="kode_pengajuan_bbm[]" id="kode_pengajuan_bbm_{{ $no }}" style="font-size: 13px;" value="{{ $val->kode_bbm }}" hidden>
                                                        {{ $val->kode_bbm }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="no_faktur[]" id="no_faktur_{{ $no }}" style="font-size: 13px;" value="{{ $val->no_vocer }}" hidden>
                                                        {{ $val->no_vocer }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="tgl_faktur[]" id="tgl_faktur_{{ $no }}" style="font-size: 13px;" value="{{ $val->tgl_voucer }}" hidden>
                                                        {{ date('d-M-Y', strtotime($val->tgl_voucer)) }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="no_po[]" id="no_pol_{{ $no }}" style="font-size: 13px;" value="{{ $val->no_polisi }}" hidden>
                                                        {{ $val->no_polisi }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="nama_sales[]" id="nama_sales_{{ $no }}" style="font-size: 13px;" value="{{ $val->salesman }}" hidden>
                                                        {{ $val->salesman }}
                                                    </td>
                                                    {{-- <td>
                                                        <input type="text" class="form-control" name="divisi[]" id="divisi_{{ $no }}" style="font-size: 13px;" value="{{ $val->divisi }}" hidden>
                                                        {{ $val->divisi }}
                                                    </td> --}}
                                                    <td>
                                                        <input type="text" class="form-control" name="segmen[]" id="segmen_{{ $no }}" style="font-size: 13px;" value="{{ $val->segmen }}" hidden>
                                                        {{ $val->segmen }}
                                                    </td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="km_akhir[]" id="km_akhir_{{ $no }}" style="font-size: 13px;" value="{{ $val->kilometer }}" hidden>
                                                        {{ number_format($val->kilometer) }}
                                                    </td>
                                                    {{-- <td hidden>
                                                        <input type="text" class="form-control" name="kode_bbm[]" id="kode_bbm_{{ $no }}" style="font-size: 13px;" value="{{ $val->kode_bbm }}" hidden>
                                                        {{ $val->kode_bbm }}
                                                    </td> --}}
                                                    <td>
                                                        <input type="text" class="form-control" name="nama_bbm[]" id="nama_bbm_{{ $no }}" style="font-size: 13px;" value="{{ $val->jenis_bbm }}" hidden>
                                                        {{ $val->jenis_bbm }}
                                                    </td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="vol_perliter[]" id="vol_perliter_{{ $no }}" style="font-size: 13px;" value="{{ $val->liter_qty }}" hidden>
                                                        {{ $val->liter_qty }} liter
                                                    </td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="harga_perliter[]" id="harga_perliter_{{ $no }}" style="font-size: 13px;" value="{{ $val->harga_perliter }}" hidden>
                                                        {{ number_format($val->harga_perliter) }}
                                                    </td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="total[]" id="total_{{ $no }}" style="font-size: 13px;" value="{{ $val->biaya_bbm }}" hidden>
                                                        {{ number_format($val->biaya_bbm) }}
                                                    </td>
                                                    <td>
                                                        {{-- <input type="text" class="form-control" name="lampiran[]" id="lampiran_{{ $no }}" style="font-size: 13px;" value="{{ $val->filename }}" hidden>
                                                        {{ $val->filename }} --}}
                                                        <a href="{{url('images/'. $val->filename)}}">
                                                            {{ $val->filename}}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $no++ ?>
                                                @empty
                                                <tr>
                                                    <td colspan="13" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse        
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="8" align="center"><b>Total:</b></td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="jml_liter" id="jml_liter" style="font-size: 13px;" value="{{ $pengajuan_bbm->sum('liter_qty') }}" hidden>
                                                        <b>{{ $pengajuan_bbm->sum('liter_qty') }} liter</b> &nbsp;
                                                    </td>
                                                    <td align="right"><b></b> &nbsp;</td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="jml_total" id="jml_total" style="font-size: 13px;" value="{{ $pengajuan_bbm->sum('biaya_bbm') }}" hidden>
                                                        <b>{{ number_format($pengajuan_bbm->sum('biaya_bbm')) }}</b> &nbsp;
                                                    </td>
                                                    <td></td>
                                                     
                                                </tr>
                                            </tfoot>
                                        </table>
                                    <!--</div>-->
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <strong>Lampiran/Attachment</strong>
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="filename[]" id="filename" multiple>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-danger" id="button_hapus_lampiran" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                                </span>
                                            </div>
                                        </div>  
                                    </div>
                                    <br>    
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            {{-- <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Cari Data</button> --}}
                                            <button type="button" id="caridatas" name="caridatas" class="btn btn-primary btn-sm" hidden>Cari Data</button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('datatabel-v1')" hidden>Hapus Data</button>
                                            <button type="button" class="btn btn-secondary" name="button_cari_data_all" id="button_cari_data_all" hidden>Cari All</button>
                                        </div>  
                                                  
                                        <div class="col-md-8 mb-2">
                                            <button type="button" id="button_simpan" name="button_simpan" class="btn btn-success btn-sm float-right">Buat Pengajuan</button>
                                        </div>

                                        <input type="text" name="total_biaya" id="total_biaya" class="form-control" value="0" required readonly hidden> 
                                    </div>
                                                
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                
            </form>
        </div>
    </div>
</main>

@endsection

@section('script')

    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: false,
                bFilter: false,
                lengthChange: false,
                scrollY: "355px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });

            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });

        });
    </script>

@endsection




