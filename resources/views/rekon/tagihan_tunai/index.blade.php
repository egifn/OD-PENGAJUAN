@extends('layouts.admin')

@section('title')
    <title>Tagihan Tunai</title>
@endsection

@section('content')


<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Rekonsiliasi</li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Tagihan Tunai</li>
    </ol>
    <div class="container-fluid">
        <!-- DMS  -->
        <form action="{{ route('tagihan_tunai.dmscari') }}" method="get">
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
                                                <th >#</th>
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
                                            <?php $no=1 ?>
                                            @forelse ($kredit_dms as $valdms) 
                                            <?php 
                                                $urut = $no++;
                                                $panjang = strlen($urut) 
                                            ?>
                                            <tr>
                                                <td >{{ $urut }}</td>
                                                <td>{{ date('d-M-Y', strtotime($valdms->dtmDoc)) }}</td>
                                                @if($panjang == '1')
                                                    <td>D{{ date('my', strtotime($valdms->dtmDoc)) }}00{{ $urut }}</td>
                                                @elseif($panjang == '2')
                                                    <td>D{{ date('my', strtotime($valdms->dtmDoc)) }}0{{ $urut }}</td>
                                                @elseif($panjang == '3')
                                                    <td>D{{ date('my', strtotime($valdms->dtmDoc)) }}{{ $urut }}</td>
                                                @endif
                                                <td hidden></td> <!-- Kode Depo -->
                                                <td hidden></td> <!-- Depo -->
                                                <td hidden></td>
                                                <td>{{ $valdms->szName}} </td>
                                                <td>{{ number_format($valdms->decAmount) }}</td>
                                                <td>
                                                    <select name="norek_bank[]" id="norek_bank{{ $urut }}" class="form-control" style="height: 30px; width: 150px; font-size: 12px;">
                                                        <option value="">Pilih Rekening</option>
                                                        @foreach ($rekening as $rowrek_)
                                                            <option value="{{ $rowrek_->norek }}" {{ old('norek') == $rowrek_->norek ? 'selected':'' }}>{{ $rowrek_->norek }}</option>
                                                        @endforeach  
                                                    </select>
                                                </td>
                                                <td><input type="text" name="transaksi_lawan_d[]" id="transaksi_lawan_d{{ $urut }}" style="height: 30px" class="form-control" ></input>
                                                </td>
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
                                &nbsp
                                <select name="no_va" id="no_va" class="form-control">
                                    <option value="">Pilih VA</option>
                                    
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
                                            <?php $no=1 ?>
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
                                                    <input type="text" name="transaksi_lawan_b[]" id="transaksi_lawan_b{{ $no }}" style="height: 30px" class="form-control"></input>
                                                </td>
                                                <td>
                                                    <input type="text" name="tgl_btu[]" id="tgl_btu{{ $no }}" style="height: 30px" class="form-control" ></input>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
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
                            
                                
                            <button class="btn btn-primary btn-sm float-right" type="submit">C a r i</button> &nbsp;
                                            
                            <!-- <form action="#" method="post" enctype="multipart/form-data">
                                <button class="btn btn-primary btn-sm float-right">Posting</button>&nbsp;
                            </form> -->

                              <button type="button" id="posting" class="btn btn-success btn-sm" onclick="getInputValue();" data-toggle="modal" data-target="#modal_posting">
                                Posting
                            </button>

                            <!-- <a href="{{ route('pengajuan.create') }}" class="btn btn-success btn-sm">Posting</a> -->
                                
                            

                        </div>
                    </div>
                </div>

                <!-- MODAL Posting -->
                            <div class="modal fade" id="modal_posting" tabindex="-1" aria-labelledby="modal_posting" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rincian</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#" method="get">
                                                @csrf
                                                <div class="form-group">
                                                    <!-- <label for="">keterangan</label>
                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea> -->
                                                    
                                                    <div class="card-body">
                                                        <b>DMS</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <!-- <table class="table table-condensed table-hover table-striped" width="100%" cellspacing="0"> -->
                                                            <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">
                                                            <!-- <table id="table_bank" class="table table-bordered table-striped table-sm"> -->
                                                                <table id="datatabel-v3" class="table table-bordered table-sm" style="white-space: nowrap; margin-bottom: 0; height: 50px; ">     
                                                                    <thead>
                                                                        <tr>
                                                                            <th hidden>#</th>
                                                                            <th>Tanggal BTU</th>
                                                                            <th>No Transaksi</th>
                                                                            <th hidden>Kode Depo</th>
                                                                            <th hidden>Nama Depo</th>
                                                                            <th hidden>kode Dokumen</th>
                                                                            <th>Deskripsi</th>
                                                                            <th>Nilai</th>
                                                                            <th>No. Rek</th>
                                                                            <th>Transaksi Lawan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="input-group col-md-4 float-right"> 
                                                            Total DMS: 
                                                            &nbsp 
                                                            <input type="text" id="total_dms" name="total_dms" style="height: 25px; text-align: right;" class="form-control">
                                                        </div>           
                                                    </div>
                                                    <div class="card-body">
                                                        <b>Rekening</b>
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover table-bordered"> -->
                                                            <!-- <table class="table table-condensed table-hover table-striped" width="100%" cellspacing="0"> -->
                                                            <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">
                                                            <!-- <table id="table_bank" class="table table-bordered table-striped table-sm"> -->
                                                                <table id="datatabel-v4" class="table table-bordered table-sm" style="white-space: nowrap; margin-bottom: 0; height: 50px; ">     
                                                                    <thead>
                                                                        <tr>
                                                                            <th hidden>#</th>
                                                                            <th>Tanggal Rek</th>
                                                                            <th>No Transaksi</th>
                                                                            <th>Deskripsi</th>
                                                                            <th>Nilai</th>
                                                                            <th>No. Rek</th>
                                                                            <th>Transaksi Lawan</th>
                                                                            <th>Tanggal BTU</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div> 
                                                        <div class="input-group col-md-4 float-right"> 
                                                            Total Rekening:
                                                            &nbsp 
                                                            <input type="text" id="total_rek" name="total_rek" style="height: 25px; text-align: right;" class="form-control">
                                                        </div>        
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">k e m b a l i</button>
                                                <button type="submit" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <!-- End MODAL -->

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

        $(function(){
            $('#norek').change(function(){
                var norekk = $(this).val();
                if(norekk){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_rekening_va?norekk="+norekk,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#no_va").empty();
                                $("#no_va").append('<option value="">Pilih VA</option>');
                                $.each(res,function(virtualaccount,virtualaccount){
                                    $("#no_va").append('<option value="'+virtualaccount+'">'+virtualaccount+'</option>');
                                });
                            }else{
                                $("#no_va").empty();
                            }
                        }
                    });
                }else{
                    $("#no_va").empty();
                }
            });
        });


        function getInputValue(){
            var ttl_dms = 0;
            var ttl_bank = 0;            
            var tabel_dms = document.getElementById("datatabel-v1");
            for(var t = 1; t < tabel_dms.rows.length; t++){
                var input_tl_d = document.getElementById('transaksi_lawan_d'+t+'').value;
                var input_norek = document.getElementById('norek_bank'+t+'').value;
                if(input_tl_d != ''){
                    $('#datatabel-v3 tbody').append('<tr><td><input type="text" name="tgl[]" id="tgl'+t+'" value="'+tabel_dms.rows[t].cells[1].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_dms.rows[t].cells[1].innerHTML+'</td><td><input type="text" name="no_tran[]" id="no_tran'+t+'" value="'+tabel_dms.rows[t].cells[2].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_dms.rows[t].cells[2].innerHTML+'</td><td><input type="text" name="ket[]" id="ket'+t+'" value="'+tabel_dms.rows[t].cells[6].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_dms.rows[t].cells[6].innerHTML+'</td><td><input type="text" name="nilai[]" id="nilai'+t+'" value="'+tabel_dms.rows[t].cells[7].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_dms.rows[t].cells[7].innerHTML+'</td><td><input type="text" name="norek_dms[]" id="norek_dms'+t+'" value="'+input_norek+'" style="height: 30px; width: 140px;" class="form-control"></input></td><td><input type="text" name="transaksi_lawan_d_[]" id="transaksi_lawan_d_'+t+'" value="'+input_tl_d+'" style="height: 30px" class="form-control"></input></td></tr>')

                    var nilai_d = (tabel_dms.rows[t].cells[7].innerHTML);
                    //menghilangka format rupiah//
                    var temp_nilai_d = nilai_d.replace(/[.](?=.*?\.)/g, '');
                    var temp_nilai_d_nf = parseFloat(temp_nilai_d.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah//

                    ttl_dms = ttl_dms + temp_nilai_d_nf;

                    //membuat format rupiah//
                    var reverse = ttl_dms.toString().split('').reverse().join(''),
                        ribuan  = reverse.match(/\d{1,3}/g);
                        hasil_d = ribuan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                }
            }  

            document.getElementById("total_dms").value = hasil_d;      
            
            var tabel_rek = document.getElementById("datatabel-v2");
            for(var u = 1; u < tabel_rek.rows.length; u++){
                var input_tl_b = document.getElementById('transaksi_lawan_b'+u+'').value;
                var input_btu_b = document.getElementById('tgl_btu'+u+'').value;
                if(input_tl_b != ''){
                    $('#datatabel-v4 tbody').append('<tr><td><input type="text" name="tgl[]" id="tgl'+u+'" value="'+tabel_rek.rows[u].cells[1].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_rek.rows[u].cells[1].innerHTML+'</td><td><input type="text" name="no_tran_rek[]" id="no_tran_rek'+t+'" value="'+tabel_rek.rows[u].cells[2].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_rek.rows[u].cells[2].innerHTML+'</td><td><input type="text" name="desk[]" id="desk'+t+'" value="'+tabel_rek.rows[u].cells[4].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_rek.rows[u].cells[4].innerHTML+'</td><td><input type="text" name="nilai[]" id="nilai'+t+'" value="'+tabel_rek.rows[u].cells[5].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_rek.rows[u].cells[5].innerHTML+'</td><td><input type="text" name="norek_bank[]" id="norek_bank'+t+'" value="'+tabel_rek.rows[u].cells[6].innerHTML+'" style="height: 30px; width: 140px;" class="form-control" hidden></input>'+tabel_rek.rows[u].cells[6].innerHTML+'</td><td><input type="text" name="transaksi_lawan_b_[]" id="transaksi_lawan_b_'+u+'" value="'+input_tl_b+'" style="height: 30px; width: 140px;" class="form-control"></input></td><td><input type="text" name="tgl_btu_b[]" id="tgl_btu_b'+u+'" value="'+input_btu_b+'" style="height: 30px" class="form-control"></input></td></tr>')

                    var nilai_b = (tabel_rek.rows[u].cells[5].innerHTML);
                    //menghilangka format rupiah//
                    var temp_nilai_b = nilai_b.replace(/[.](?=.*?\.)/g, '');
                    var temp_nilai_b_nf = parseFloat(temp_nilai_b.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah//

                    ttl_bank = ttl_bank + temp_nilai_b_nf;

                    //membuat format rupiah//
                    var reverse = ttl_bank.toString().split('').reverse().join(''),
                        ribuan  = reverse.match(/\d{1,3}/g);
                        hasil_b = ribuan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//
                }
            }

            document.getElementById("total_rek").value = hasil_b;  
        }

    </script>





@endsection()