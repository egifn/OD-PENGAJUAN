
@extends('layouts.admin')

@section('title')
    <title>Data Pelunasan</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Data Pelunasan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Data Yang akan di payment
                            </h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('rekon_pelunasan/cari.cari') }}" method="get">
                                <div class="row">
                                    <div class="input-group mb-3 col-md-8">  
                                        
                                    </div>

                                    <div class="input-group mb-3 col-md-4">  
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                        &nbsp
                                        <button class="btn btn-secondary" type="submit">C a r i</button>
                                    </div>    
                                </div>
                            </form>

                                <div class="card">
                                    <div class="table-responsive">    
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                            <td>
                                                <b><i class="nav-icon icon-control-play"></i> Piutang</b>
                                                <div class="table-responsive">
                                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:60%; margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th hidden>id</th>
                                                                <th>No Cek</th>
                                                                <th>Nominal</th>
                                                                <th hidden>Jatuh Tempo</th>
                                                                <th hidden>Id Pelanggan</th>
                                                                <th>Nama Pelanggan</th>
                                                                <th>Bank</th>
                                                                <th hidden>Status Cek</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php $no = 1; @endphp
                                                        @forelse($data_piutang as $val)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td hidden>
                                                                    <input type="text" class="form-control" name="id[]" id="id" style="font-size: 13px;" value="{{ $val->id }}" >
                                                                        {{ $val->id }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="no_cek[]" id="no_cek" style="font-size: 13px;" value="{{ $val->no_cek }}" hidden>
                                                                    <a href="" data-toggle="modal" data-target="#myModal{{ $val->id }}">{{ $val->no_cek }}</a>
                                                                    
                                                                    {{-- Modal list invoice --}}
                                                                    <div class="modal fade" id="myModal{{ $val->id }}" tabindex="-1" aria-labelledby="myModal" aria-hidden="true""
                                                                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content" style="background: #fff;">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLabel">Daftar Invoice "<span>{{ $val->no_cek}}</span>"</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="#" method="get">
                                                                                        <div class="input-group mb-3 col-md-4 float-right">
                                                                                            <input type="text" name="cari_request" id="cari_request" class="form-control" value="MTR/DAKOTA4/EQ 107536/220822">
                                                                                        </div>
                                                                                    </form>
                                                                                    <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                                                                                        <input type="hidden" name="no_cek" id="no_cek" class="form-control" value="MTR/DAKOTA4/EQ 107536/220822">
                                                                                        <table id="lookup" class="table table-bordered table-hover table-striped">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th hidden>id</th>
                                                                                                    <th>No Rekening</th>
                                                                                                    <th>tgl Transaksi</th>
                                                                                                    <th>Deskripsi</th>
                                                                                                    <th>Kredit</th>
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
                                                                </td>
                                                                <td align="right">
                                                                    <input type="text" class="form-control" name="nominal[]" id="nominal" style="font-size: 13px;" value="{{ $val->nominal }}" hidden>
                                                                        {{ number_format($val->nominal) }}
                                                                </td>
                                                                <td align="center" hidden>
                                                                    <input type="text" class="form-control" name="jt[]" id="jt" style="font-size: 13px;" value="{{ $val->jatuh_tempo }}" hidden>
                                                                        {{ $val->jatuh_tempo }}
                                                                </td>
                                                                <td hidden>
                                                                    <input type="text" class="form-control" name="id_pelanggan[]" id="id_pelanggan" style="font-size: 13px;" value="{{ $val->id_pelanggan }}" hidden>
                                                                        {{ $val->id_pelanggan }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="nama_pelanggan[]" id="nama_pelanggan" style="font-size: 13px;" value="{{ $val->nama_pelanggan }}" hidden>
                                                                        {{ $val->nama_pelanggan }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="bank[]" id="bank" style="font-size: 13px;" value="{{ $val->bank }}" hidden>
                                                                        {{ $val->bank }}
                                                                </td>
                                                                <td hidden>{{ $val->status_cek }}</td>
                                                            </tr>
                                                            <?php $no++ ?>
                                                            @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                                            </tr>
                                                            @endforelse
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2" align="center" bgcolor="#E6E6E6"><b>Total<b></td>
                                                                    <td colspan="1" align="right" bgcolor="#E6E6E6"><b>Rp. {{ number_format($total_piutang->total) }}<b></td>
                                                                    <td colspan="6" align="center" bgcolor="#E6E6E6"></td>
                                                                </tr>
                                                            </tfoot>
                                                    </table>
                                                </div>
                                            </td>

                                            <td>
                                                <b><i class="nav-icon icon-control-play"></i> Kasir</b>
                                                <div class="table-responsive">
                                                    <!-- <table class="table table-hover table-bordered"> -->
                                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:60%; margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th hidden>id</th>
                                                                <th>No Cek</th>
                                                                <th>Nominal</th>
                                                                <th>Jatuh Tempo</th>
                                                                <th>Id Pelanggan</th>
                                                                <th>Nama Pelanggan</th>
                                                                <th>Bank</th>
                                                                <th>Status Cek</th>
                                                                <th>Pilih</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php $no = 1; @endphp
                                                        @forelse($pelunasan as $val)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td hidden>
                                                                    <input type="text" class="form-control" name="id_k[]" id="id_k" style="font-size: 13px;" value="{{ $val->id }}" hidden>
                                                                        {{ $val->id }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="no_cek_k[]" id="no_cek_k" style="font-size: 13px;" value="{{ $val->no_cek }}" hidden>
                                                                    {{ $val->no_cek }}    
                                                                </td>
                                                                <td align="right">
                                                                    <input type="text" class="form-control" name="nominal_k[]" id="nominal_k" style="font-size: 13px;" value="{{ $val->nominal }}" hidden>
                                                                        {{ number_format($val->nominal) }}
                                                                </td>
                                                                <td align="center">
                                                                    <input type="text" class="form-control" name="jt_k[]" id="jt_k" style="font-size: 13px;" value="{{ $val->jatuh_tempo }}" hidden>
                                                                        {{ $val->jatuh_tempo }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="id_pelanggan_k[]" id="id_pelanggan_k" style="font-size: 13px;" value="{{ $val->id_pelanggan }}" hidden>
                                                                        {{ $val->id_pelanggan }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="nama_pelanggan_k[]" id="nama_pelanggan_k" style="font-size: 13px;" value="{{ $val->nama_pelanggan }}" hidden>
                                                                        {{ $val->nama_pelanggan }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="bank_k[]" id="bank_k" style="font-size: 13px;" value="{{ $val->bank }}" hidden>
                                                                        {{ $val->bank }}
                                                                </td>
                                                                <td>{{ $val->status_cek }}</td>
                                                                <td align="center"><input type="checkbox" name="chk_k{{ $no }}" id="chk_k{{ $no }}"  value="1" /></td>
                                                            </tr>
                                                        <?php $no++ ?>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2" align="center" bgcolor="#E6E6E6"><b>Total<b></td>
                                                                <td colspan="1" align="right" bgcolor="#E6E6E6"><b>Rp. {{ number_format($total->total) }}<b></td>
                                                                <td colspan="6" align="center" bgcolor="#E6E6E6">
                                                                        
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </td>

                                            <td>
                                                <b><i class="nav-icon icon-control-play"></i> Mutasi Rekening</b>
                                                <div class="table-responsive">
                                                    <!-- <table class="table table-hover table-bordered"> -->
                                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:60%; margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th hidden>id</th>
                                                                <th>Tgl Rekening</th>
                                                                <th>No Rekening</th>
                                                                <th>Deskripsi</th>
                                                                <th>Nilai</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php $no = 1; @endphp
                                                        @forelse($catatan_rek as $val)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td hidden>
                                                                    <input type="text" class="form-control" name="id_k[]" id="id_k" style="font-size: 13px;" value="{{ $val->id }}" hidden>
                                                                        {{ $val->id }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="tgl_rek[]" id="tgl_rek" style="font-size: 13px;" value="{{ $val->tanggal_rek }}" hidden>
                                                                        {{ $val->tanggal_rek }}
                                                                </td>
                                                                <td align="right">
                                                                    <input type="text" class="form-control" name="norek[]" id="norek" style="font-size: 13px;" value="{{ $val->norek }}" hidden>
                                                                        {{ ($val->norek) }}
                                                                </td>
                                                                <td align="center">
                                                                    <input type="text" class="form-control" name="desc[]" id="desc" style="font-size: 13px;" value="{{ $val->description }}" hidden>
                                                                          {{ $val->description }}
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="nilai[]" id="nilai" style="font-size: 13px;" value="{{ $val->nilai }}" hidden>
                                                                        {{ $val->nilai }}
                                                                </td>
                                                                </tr>
                                                            <?php $no++ ?>
                                                            @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2" align="center" bgcolor="#E6E6E6"><b>Total<b></td>
                                                                <td colspan="1" align="right" bgcolor="#E6E6E6"><b>Rp. {{ number_format($total_catatan_rek->total_catatan_rekening) }}<b></td>
                                                                <td colspan="6" align="center" bgcolor="#E6E6E6">
                                                                        
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </td>
                                        </table>
                                        </div>

                                    </div>
                                    
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-primary btn-sm float-right">Approval</button>
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

@section('js')
    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v2').DataTable({
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
                    left: 3,
                    right: 1,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

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
        $('#savedatas').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("rekon_pelunasan/approval.approval") }}',
                type: 'post',
                data: $(this).serializeArray(),
                success: function(data){
                    console.log(data);
                }
            });
        });

        $(document).ready(function(){
            fetch_product_data();
            function fetch_product_data(query = '')
            {
                $.ajax({
                    url:'{{ route("rekon_pelunasan/getDmsInvoice.getDmsInvoice") }}',
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#lookup tbody').html(data.table_data);
                    }
                })
            }

            $("#cari_request").change(function(e) {
                e.preventDefault();
                alert('asd');

                var query = $(this).val();
                fetch_product_data(query);
            })
        });

        // $("#cari_request").click(function(e) {
        //         e.preventDefault();
        //         alert('asd');

        //         var query = $(this).val();
        //         fetch_product_data(query);
        // })


    </script>



@endsection