@section('js')
    <script type="text/javascript">
        function goBack() {
            window.history.back();
        }

        $("#button_form_approved").click(function() {
            let no_urut = $("#no_urut").val();
        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('pengajuan_biaya_masuk_bbm/approved.approved') }}",
                data: {
                    no_urut: no_urut,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('pengajuan_biaya_masuk_bbm.index')}}";
                    }else{

                    }
                }
            });
        });
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>View Pengajuan BBM Sales</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Biaya BBM Sales</li>
        <li class="breadcrumb-item active">View Pengajuan BBM Sales</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Pengajuan Biaya BBM Sales</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ $view_pengajuan_h->tgl_pengajuan_b }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" id="name" class="form-control" value="{{ $view_pengajuan_h->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control" value="" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="kode_depo" id="kode_depo" class="form-control" value="" required readonly>
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
                                        <input type="text" name="ket" id="ket" class="form-control" value="{{ $view_pengajuan_h->keterangan }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Tgl pengisian yang diajukan
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ $view_pengajuan_h->no_surat_program }}" readonly>
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
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $view_pengajuan_h->no_urut }}">
                                    </div>
                                </div>
                                
                                <div class="row" hidden>
                                    <div class="col-md-2 mb-2">
                                        Division
                                        <input type="text" name="kode_divisi" id="kode_divisi" class="form-control" value="" required readonly>
                                    </div>                                    
                                </div>

                                <div class="row">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    
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
                                                    <th>Divisi</th>
                                                    <th>Segmen</th>
                                                    <th>KM Akhir</th>
                                                    <th hidden>kode_bbm</th>
                                                    <th>Jenis BBM</th>
                                                    <th>Volume/liter</th>
                                                    <th>Harga/liter</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($view_pengajuan_d as $row)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td hidden></td>
                                                    <td>{{ $row->no_faktur }}</td>
                                                    <td>{{ $row->tgl_faktur }}</td>
                                                    <td>{{ $row->nopol }}</td>
                                                    <td>{{ $row->nama_sales }}</td>
                                                    <td>{{ $row->divisi }}</td>
                                                    <td>{{ $row->segmen }}</td>
                                                    <td>{{ $row->km_akhir }}</td>
                                                    <td hidden>{{ $row->kode_bbm }}</td>
                                                    <td>{{ $row->nama_bbm }}</td>
                                                    <td align="right">{{ $row->volume_perliter }} Liter</td>
                                                    <td align="right">{{ number_format($row->harga_perliter) }}</td>
                                                    <td align="right">{{ number_format($row->total) }}</td>
                                                </tr>
                                                <?php $no++ ?>
                                                @empty
                                                <tr>
                                                    
                                                </tr>
                                                @endforelse     
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9" align="center"><b>Total:</b></td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="jml_liter" id="jml_liter" style="font-size: 13px;" value="{{ $view_total_d->total_vol }}" hidden>
                                                        <b>{{ $view_total_d->total_vol }} Liter</b> &nbsp;
                                                    </td>
                                                    <td align="right"><b></b> &nbsp;</td>
                                                    <td align="right">
                                                        <input type="text" class="form-control" name="jml_total" id="jml_total" style="font-size: 13px;" value="{{ $view_total_d->total_biaya }}" hidden>
                                                        <b>{{ number_format($view_total_d->total_biaya) }}</b> &nbsp;
                                                    </td>
                                                     
                                                </tr>
                                            </tfoot>
                                        </table>
                                    <!--</div>-->
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8 mb-2">
                                            <div class="input-group mb-3">
                                                
                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                    <tbody>
                                                        
                                                        <tr>
                                                            {{-- <td colspan="2" class="text-center">Tidak file yang di lampirkan</td> --}}
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
    
                                            </div>
                                        </div>                                       
                                    </div>
                                    <br>    
                                    <div class="row">
                                        {{-- <div class="col-md-4 mb-2"> --}}
                                            {{-- <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Cari Data</button> --}}
                                            {{-- <button type="button" id="caridatas" name="caridatas" class="btn btn-primary btn-sm" hidden>Cari Data</button>
                                            <button type="button" class="btn btn-danger btn-sm" hidden>Hapus Data</button>
                                            <button type="button" class="btn btn-secondary" name="button_cari_data_all" id="button_cari_data_all" hidden>Cari All</button>
                                        </div>   --}}
                                                  
                                        {{-- <div class="col-md-8 mb-2">
                                            <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                        </div> --}}

                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                        </div>
                                        <div class="col-md-1 mb-2" hidden>
                                            <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button class="btn btn-danger btn-sm" id="button_form_denied">Denied</button>
                                        </div>

                                        <input type="text" name="total_biaya" id="total_biaya" class="form-control" value="0" required readonly hidden> 
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

    {{-- <!-- UNTUK TABLE -->
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
    </script> --}}

@endsection




