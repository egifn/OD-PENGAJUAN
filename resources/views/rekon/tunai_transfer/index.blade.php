@extends('layouts.admin')

@section('title')
    <title>Tunai Transfer</title>
@endsection

@section('content')



<!--############### live edit #################-->
               
    

<!--##########################################-->


<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Rekonsiliasi</li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Tunai Transfer</li>
    </ol>
    <div class="container-fluid">
        <!-- DMS  -->
        <form action="{{ route('tunai_transfer.cari') }}" method="get">
        <div class="animated fadeIn">
            
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <strong>DMS</strong>
                            <div class="input-group col-md-8 float-right">  
                                <input type="text" id="created_at" name="created_at" class="form-control" value="{{ request()->created_at }}">
                                &nbsp
                                <select name="perusahaan_dms" id="perusahaan_dms" class="form-control">
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach ($perusahaan_dms as $row_pe_dms)
                                        <option value="{{ $row_pe_dms->kode_perusahaan }}" {{ old('perusahaan_dms') == $row_pe_dms->kode_perusahaan ? 'selected':'' }}>{{ $row_pe_dms->nama_perusahaan }}</option>
                                    @endforeach 
                                </select>
                                &nbsp
                                <select name="depo_dms" id="depo_dms" class="form-control">
                                    <option value="">Pilih Depo</option>
                                    
                                </select>
                                <div class="input-group-append" hidden>
                                    <button class="btn btn-secondary" type="submit">Cari</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <!-- <div style="border:1px white;width:150%;height:150px;overflow-y:scroll;"> -->
                                <div>
                                    <!-- <table id="data_table" class="table table-bordered table-striped table-sm" > -->
                                    <table  id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; margin-bottom: 0; width:250%;">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Tanggal BTU</th>
                                                <th>No Transaksi</th>
                                                <th hidden>Kode Depo</th>
                                                <th hidden>Depo</th>
                                                <th hidden>Kode Dokumen</th>
                                                <th>Keterangan</th>
                                                <th>Nilai</th>
                                                <th>No Rekening</th>
                                                <th>No Transaksi Lawan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @forelse ($kredit_dms as $valdms) 
                                            <tr>
                                                <td hidden>#</td>
                                                <td>{{ date('Y-m-d', strtotime($valdms->dtmDoc)) }}</td>
                                                <td></td> <!-- No Transaksi -->
                                                <td hidden></td> <!-- Kode Depo -->
                                                <td hidden></td> <!-- Depo -->
                                                <td hidden></td>
                                                <td>{{ $valdms->szName}} </td>
                                                <td>{{ number_format($valdms->decAmount) }}</td>
                                                <td>
                                                    <select name="norek_bank" class="form-control" style="height: 30px; width: 150px; font-size: 12px;">
                                                        <option value="">Pilih Rekening</option>
                                                        @foreach ($rekening as $rowrek_)
                                                            <option value="{{ $rowrek_->norek }}" {{ old('norek') == $rowrek_->norek ? 'selected':'' }}>{{ $rowrek_->norek }}</option>
                                                        @endforeach  
                                                    </select>
                                                </td>
                                                <td><input type="text" name="transaksi_lawan" id="transaksi_lawan" style="height: 30px" class="form-control" ></input></td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12" class="text-center">Tidak ada data</td>
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

        <!-- Bank  -->
        <div class="animated fadeIn">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <strong>Bank</strong>
                            <div class="input-group col-md-10 float-right">
                                <input type="text" id="created_at_bank" name="created_at_bank" value="{{ request()->created_at_bank }}" class="form-control">
                                &nbsp
                                <select name="perusahaan_bank" id="perusahaan_bank" class="form-control">
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach ($perusahaan_bank as $row_pe_bank)
                                        <option value="{{ $row_pe_bank->kode_perusahaan }}" {{ old('perusahaan_bank') == $row_pe_bank->kode_perusahaan ? 'selected':'' }}>{{ $row_pe_bank->nama_perusahaan }}</option>
                                    @endforeach    
                                </select>
                                &nbsp
                                <select name="depo_bank" id="depo_bank" class="form-control">
                                    <option value="">Pilih Depo</option>
                                    
                                </select>
                                &nbsp
                                <select name="norek" id="norek" class="form-control">
                                    <option value="">Pilih Rekening</option>
                                    
                                </select>
                                <div class="input-group-append" hidden>
                                    <button class="btn btn-secondary" type="submit">Cari</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- <div style="border:1px white;width:150%;height:150px;overflow-y:scroll;"> -->
                                <div>
                                    <!-- <table class="table table-bordered table-striped table-sm" > -->
                                    <table  id="datatabel-v2" class="table table-bordered table-sm" style="white-space: nowrap; margin-bottom: 0;">
                                        <thead>
                                            <tr>
                                                <th hidden>#</th>
                                                <th>Tanggal Rek</th>
                                                <th>No Transaksi</th>
                                                <th hidden>No Cheque</th>
                                                <th>Deskripsi</th>
                                                <th>Nilai</th>
                                                <th>No. Rek</th>
                                                <th>Transaksi Lawan</th>
                                                <th>Tanggal BTU</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($kredit as $val) 
                                            <tr>
                                                <td hidden>#</td>
                                                <td>{{ date('Y-m-d', strtotime($val->tanggal_rek)) }}</td>
                                                <td>{{ $val->id }}</td>
                                                <td hidden>{{ $val->kode }}</td>
                                                <td>{{ $val->description }}</td>
                                                <td align="right">{{ number_format($val->nilai) }}</td>
                                                <td>{{ $val->norek }}</td>
                                                <td>
                                                    <input type="text" name="transaksi_lawan" id="transaksi_lawan" style="height: 30px" class="form-control"></input>
                                                </td>
                                                <td>
                                                    <input type="text" name="tgl_btu" id="tgl_btu" style="height: 30px" class="form-control" ></input>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data</td>
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

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary btn-sm float-right" type="submit">Cari</button>
                                            
                            <form action="#" method="post" enctype="multipart/form-data">
                                <button class="btn btn-primary btn-sm float-right">Posting</button>&nbsp;
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
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
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: true,
                bFilter: true,
                lengthChange: false,
                scrollY: "200px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 2,
                },
            });
            $('#searchbox').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>

    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v2').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: true,
                bFilter: true,
                lengthChange: false,
                scrollY: "200px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 2,
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
               
            })

            $('#created_at_bank').daterangepicker({
               
            })
        })

        $(function(){
            $('#perusahaan_dms').change(function(){
                var perusahaandms_id = $(this).val();
                if(perusahaandms_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo_dms?perusahaandms_id="+perusahaandms_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#depo_dms").empty();
                                $("#depo_dms").append('<option value="">Pilih Depo</option>');
                                $.each(res,function(nama,kode){
                                    $("#depo_dms").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#depo_dms").empty();
                            }
                        }
                    });
                }else{
                    $("#depo_dms").empty();
                }
            });
        });

        $(function(){
            $('#perusahaan_bank').change(function(){
                var perusahaanbank_id = $(this).val();
                if(perusahaanbank_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo_bank?perusahaanbank_id="+perusahaanbank_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#depo_bank").empty();
                                $("#depo_bank").append('<option value="">Pilih Depo</option>');
                                $.each(res,function(nama,kode){
                                    $("#depo_bank").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#depo_bank").empty();
                            }
                        }
                    });
                }else{
                    $("#depo_bank").empty();
                }
            });
        });

        $(function(){
            $('#perusahaan_bank').change(function(){
                var perusahaanrek_id = $(this).val();
                if(perusahaanrek_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_rekening_bank?perusahaanrek_id="+perusahaanrek_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#norek").empty();
                                $("#norek").append('<option value="">Pilih Rekening</option>');
                                $.each(res,function(norek,norek){
                                    $("#norek").append('<option value="'+norek+'">'+norek+'</option>');
                                });
                            }else{
                                $("#norek").empty();
                            }
                        }
                    });
                }else{
                    $("#norek").empty();
                }
            });
        });

        $(function(){
            $('#depo_bank').change(function(){
                var deporek_id = $(this).val();
                if(deporek_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_rekening_bank_depo?deporek_id="+deporek_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#norek").empty();
                                $("#norek").append('<option value="">Pilih Rekening</option>');
                                $.each(res,function(norek,norek){
                                    $("#norek").append('<option value="'+norek+'">'+norek+'</option>');
                                });
                            }else{
                                $("#norek").empty();
                            }
                        }
                    });
                }else{
                    $("#norek").empty();
                }
            });
        });

    </script>





@endsection()