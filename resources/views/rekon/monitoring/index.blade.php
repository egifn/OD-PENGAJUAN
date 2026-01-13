@extends('layouts.admin')

@section('title')
    <title>Monitoring</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Monitoring</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                @csrf
                <div class="row">
                <!-- TABLE LIST CATEGORY  -->
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Monitoring
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('monitoring/cari.index_cari') }}" method="get">
                                    <div class="input-group mb-3 col-md-7 float-right">
                                        <input type="text" id="created_at" name="created_at" class="form-control">
                                        &nbsp
                                        <select name="perusahaan" id="perusahaan" class="form-control">
                                            <option value="">Perusahaan</option>
                                            @foreach ($perusahaan as $row_pe)
                                                <option value="{{ $row_pe->kode_perusahaan }}" {{ old('perusahaan') == $row_pe->kode_perusahaan ? 'selected':'' }}>{{ $row_pe->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                        &nbsp
                                        <select name="depo" id="depo" class="form-control">
                                            <option value="">Depo</option>
                                            
                                        </select>
                                        &nbsp
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="submit">Filter</button>
                                        </div>
                                    </div>
                                </form>

                                <!--
                                <div class="row">
                                    <div class="col-md-2 mb-2"">
                                        <label for="tgl_1">Periode Tanggal 1</label>
                                        <input type="text" name="tgl_1" class="date form-control" required> 
                                        <p class="text-danger">{{ $errors->first('tgl_1') }}</p>
                                    </div>
                                    <div class="col-md-2 mb-2"">
                                        <label for="tgl_2">Periode Tanggal 2</label>
                                        <input type="text" name="tgl_2" class="date form-control" required>
                                        <p class="text-danger">{{ $errors->first('tgl_2') }}</p>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label for="name">No.Rekening</label>
                                        <input type="text" name="norek" class="form-control" required>
                                        <p class="text-danger">{{ $errors->first('norek') }}</p>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label for="name" style="color: #ffffff">.</label><br>
                                        <button class="btn btn-primary btn-sm">Cari Mutasi</button>
                                    </div>
                                </div>
                                -->
                                <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <table  id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Id Depo</th>
                                                <th>Nama Depo</th>
                                                <th>Tgl Penarikan Cek</th>
                                                <th>Dok Penerimaan Cek</th>
                                                <th>Int1</th>
                                                <th>No Cek</th>
                                                <th>Bank</th>
                                                <th>Id Sales</th>
                                                <th>Nama Sales</th>
                                                <th>No Akun</th>
                                                <th>Nama Akun</th>
                                                <th>No Akun Kliring</th>
                                                <th>Nama Akun Kliring</th>
                                                <th>Id Pelanggan Cek</th>
                                                <th>Nama Pelanggan Cek</th>
                                                <th>Nilai Cek</th>
                                                <th>Tgl Jt Cek</th>
                                                <th>Status Cek</th>
                                                <th>Status Dok Cek</th>
                                                <th>Dok Payment</th>
                                                <th>No Invoice</th>
                                                <th>Nilai Invoice</th>
                                                <th>Id Pelanggan Payment</th>
                                                <th>Nama Pelanggan Payment</th>
                                                <th>Nilai Payment</th>
                                                <th>Tipe Pembayaran</th>
                                                <th>Status Dok Payment</th>
                                                <th>Dok Penyetoran</th>
                                                <th>Tgl Penyetoran</th>
                                                <th>Status Dok Penyetoran</th>
                                                <th>Dok Kliring</th>
                                                <th>Int2</th>
                                                <th>Tgl Kliring</th>
                                                <th>Status Dok Kliring</th>
                                                <th>Dok Reject</th>
                                                <th>Tgl Reject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($monitoring as $val)
                                                <tr>
                                                    <td hidden>#</td>
                                                    <td>{{ $val->ID_DEPO }}</td>
                                                    <td>{{ $val->NAMA_DEPO }}</td>
                                                    <td>{{ $val->TGGL_PENERIMAAN_CEK }}</td>
                                                    <td>{{ $val->DOK_PENERIMAAN_CEK }}</td>
                                                    <td>{{ $val->INT1 }}</td>
                                                    <td>{{ $val->NO_CEK }}</td>
                                                    <td>{{ $val->BANK }}</td>
                                                    <td>{{ $val->ID_SALES }}</td>
                                                    <td>{{ $val->NAMA_SALES }}</td>
                                                    <td>{{ $val->NO_AKUN }}</td>
                                                    <td>{{ $val->NAMA_AKUN }}</td>
                                                    <td>{{ $val->NO_AKUN_KLIRING }}</td>
                                                    <td>{{ $val->NAMA_AKUN_KLIRING }}</td>
                                                    <td>{{ $val->ID_PELANGGAN_CEK }}</td>
                                                    <td>{{ $val->NAMA_PELANGGAN_CEK }}</td>
                                                    <td>{{ $val->NILAI_CEK }}</td>
                                                    <td>{{ $val->TGGL_JTH_TEMPO_CEK }}</td>
                                                    <td>{{ $val->STATUS_CEK }}</td>
                                                    <td>{{ $val->STATUS_DOK_CEK }}</td>
                                                    <td>{{ $val->DOK_PAYMENT }}</td>
                                                    <td>{{ $val->NO_INVOICE }}</td>
                                                    <td>{{ $val->NILAI_INVOICE }}</td>
                                                    <td>{{ $val->ID_PELANGGAN_PAYMENT }}</td>
                                                    <td>{{ $val->NAMA_PELANGGAN_PAYMENT }}</td>
                                                    <td>{{ $val->NILAI_PAYMENT }}</td>
                                                    <td>{{ $val->TIPE_PEMBAYARAN }}</td>
                                                    <td>{{ $val->STATUS_DOK_PAYMENT }}</td>
                                                    <td>{{ $val->DOK_PENYETORAN }}</td>
                                                    <td>{{ $val->TGGL_PENYETORAN }}</td>
                                                    <td>{{ $val->STATUS_DOK_PENYETORAN }}</td>
                                                    <td>{{ $val->DOK_KLIRING }}</td>
                                                    <td>{{ $val->INT2 }}</td>
                                                    <td>{{ $val->TGGL_KLIRING }}</td>
                                                    <td>{{ $val->STATUS_DOK_KLIRING }}</td>
                                                    <td>{{ $val->DOK_REJECT }}</td>
                                                    <td>{{ $val->TGGL_REJECT }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="37" class="text-center">Tidak ada data</td>
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

    <!--
    <script type="text/javascript">
        $('.date').datepicker({  
            format: 'mm-dd-yyyy'
        });  
    </script>
    -->

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
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: true,
                bFilter: true,
                lengthChange: false,
                scrollY: "300px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });
            $('#searchbox').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        
        $(document).ready(function() {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            //INISIASI DATERANGEPICKER
            $('#created_at').daterangepicker({
                startDate: start,
                endDate: end
            })
        })

        $(function(){
            $('#perusahaan').change(function(){
                var perusahaan_id = $(this).val();
                if(perusahaan_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo?perusahaan_id="+perusahaan_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#depo").empty();
                                $("#depo").append('<option value="">Depo</option>');
                                $.each(res,function(nama,kode){
                                    $("#depo").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#depo").empty();
                            }
                        }
                    });
                }else{
                    $("#depo").empty();
                }
            });
        });
    </script>
@endsection()