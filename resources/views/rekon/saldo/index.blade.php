@extends('layouts.admin')

@section('title')
	<title>Saldo</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Saldo</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('saldo/cari.cari') }}" method="get">
                                <button type="button" id="konversi" class="btn btn-primary" data-toggle="modal" data-target="#modal_konversi">Konversi</button>

                                <div class="input-group col-md-9 float-right">  
                                    <input type="text" id="periode" name="periode" class="form-control">
                                    &nbsp
                                    <select name="perusahaan" id="perusahaan" class="form-control">
                                        <option value="">Pilih Perusahaan</option>
                                        @foreach ($perusahaan as $row_perusahaan)
                                            <option value="{{ $row_perusahaan->kode_perusahaan }}" {{ old('perusahaan') == $row_perusahaan->kode_perusahaan ? 'selected':'' }}>{{ $row_perusahaan->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                    &nbsp
                                    <select name="depo" id="depo" class="form-control">
                                        <option value="">Pilih Depo</option>
                                             
                                    </select> 
                                     &nbsp
                                    <select name="norek" id="norek" class="form-control">
                                        <option value="">Pilih Norek</option>
                                             
                                    </select> 
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">C a r i</button>
                                    </div>   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
              	<!-- TABLE LIST BANK  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <!-- <div class="card-header">
                            <h4 class="card-title">Perusahaan</h4>
                        </div> -->
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <strong><label for="bank" style="margin-top: 10px;">Saldo Awal : &nbsp&nbsp&nbsp&nbsp&nbsp <b>Rp. 950,000</b></label></strong>
                            <div class="input-group col-md-4 float-right" hidden>       
                                <input type="text" id="saldo_awal" name="saldo_awal" class="form-control" style="text-align: center; font-weight: bold;" value="Rp. Total Saldo Awal" readonly>
                            </div>
                            <br>
                            <br>
                            <!-- <strong><label for="bank">Perusahaan</label></strong> -->
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr style="background-color: #DCDCDC;">
                                            <th hidden>#</th>
                                            <th hidden>No Account</th>
                                            <th>Tanggal</th>
                                            <th>Nama Transaksi</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($saldo as $val) 
                                        <tr>
                                            <td hidden>#</td>
                                            <td hidden>{{ $val->account_no }}</td>
                                            <td>{{ $val->transaction_date }}</td>
                                            <td>{{ $val->description }}</td>
                                            <td align="right">{{ number_format($val->debet) }}</td>
                                            <td align="right">{{ number_format($val->kredit) }}</td>
                                        <tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #D3D3D3;">
                                            <td hidden>#</th>
                                            <td align="center" colspan="2"><b>Total</b></td>
                                            <td align="right"><b>Rp. {{ number_format($debet) }}</b></td>
                                            <td align="right"><b>Rp. {{ number_format($kredit) }}</b></td>
                                        <tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if($balance == '')
                                <strong><label for="bank" style="margin-top: 10px;">Saldo Akhir : &nbsp&nbsp&nbsp&nbsp&nbsp  <b>Rp. 0</b></label></strong>
                            @else
                                <strong><label for="bank" style="margin-top: 10px;">Saldo Akhir : &nbsp&nbsp&nbsp&nbsp&nbsp  <b>Rp. {{ number_format(950000 + $kredit - $debet) }}</b></label></strong> <!-- balance->balance -->
                            @endif
                            
                            <div class="input-group col-md-2 float-right" hidden>       
                                <input type="text" id="saldo_akhir" name="saldo_akhir" class="form-control" style="text-align: center; font-weight: bold;" value="Rp. 0" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
                <!-- ############################################################################################  -->
              
                <!-- TABLE LIST BANK  -->
                <div class="col-md-6" hidden>
                    <div class="card card-accent-primary">
                        <!-- <div class="card-header">
                            <h4 class="card-title">Bank</h4>
                        </div> -->
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <strong><label for="bank">Bank</label></strong>
                            <div class="table-responsive">
                                <!-- <table class="table table-hover table-bordered"> -->
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th hidden>#</th>
                                            <th hidden>No Account</th>
                                            <th>Tanggal</th>
                                            <th>Nama Transaksi</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      	
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>

                                    </tbody>
                                    <tfoot>                                        
                                        <td hidden>#</td>
                                        <td align="center" colspan="2"><b>Total</b></td>
                                        <td align="right"><b>Rp. (Total Debit)</b></td>
                                        <td align="right"><b>Rp. (Total Kredit)</b></td>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- FUNGSI INI AKAN SECARA OTOMATIS MEN-GENERATE TOMBOL PAGINATION  -->
                            
                        </div>
                    </div>
                </div>
                <!-- ##################################################################################################  -->
            </div>

            <!-- <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <strong><label for="bank" style="margin-top: 10px;">Saldo Awal</label></strong>
                            <div class="input-group col-md-4 float-right">       
                                <input type="text" id="saldo_awal" name="saldo_awal" class="form-control" style="text-align: center; font-weight: bold;" value="Rp. Total Saldo Awal" readonly>
                            </div>
                            <br>
                            <strong><label for="bank" style="margin-top: 10px;">Saldo Akhir</label></strong>
                            <div class="input-group col-md-4 float-right">       
                                <input type="text" id="saldo_akhir" name="saldo_akhir" class="form-control" style="text-align: center; font-weight: bold;" value="Rp. Total Saldo Akhir" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>


                                <!-- MODAL Posting -->
                                <div class="modal fade" id="modal_konversi" tabindex="-1" aria-labelledby="modal_konversi" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konversi Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('konversi_data.storeData') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-2">
                                                                <label for="">File (.xls, .xlsx)</label>
                                                                <input type="file" name="file" class="form-control" value="{{ old('file') }}" required>
                                                                <p class="text-danger">{{ $errors->first('file') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label for="">Perusahaan</label>
                                                                <select name="modal_perusahaan" id="modal_perusahaan" class="form-control">
                                                                    <option value="">Pilih Perusahaan</option>
                                                                    @foreach ($perusahaan as $row_perusahaan)
                                                                        <option value="{{ $row_perusahaan->kode_perusahaan }}" {{ old('perusahaan') == $row_perusahaan->kode_perusahaan ? 'selected':'' }}>{{ $row_perusahaan->nama_perusahaan }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label for="">Depo</label>
                                                                <select name="modal_depo" id="modal_depo" class="form-control">
                                                                    <option value="">Pilih Depo</option>
                                                                         
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" hidden>k e m b a l i</button>
                                                    <button class="btn btn-primary btn-sm float-right">K o n v e r s i</button>
                                                    <!-- <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">K o n v e r s i</button> -->
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End MODAL -->


    </div>
</main>
@endsection


@section('js')





    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        
        $(document).ready(function() {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            //INISIASI DATERANGEPICKER
            $('#periode').daterangepicker({
                startDate: start,
                endDate: end
            })

            $('#created_at_bank').daterangepicker({
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
                                $("#depo").append('<option value="">Pilih Depo</option>');
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

        $(function(){
            $('#depo').change(function(){
                var deporek_id = $(this).val();
                if(deporek_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_norek?deporek_id="+deporek_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#norek").empty();
                                $("#norek").append('<option value="">Pilih Norek</option>');
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
            $('#modal_perusahaan').change(function(){
                var perusahaan_id = $(this).val();
                if(perusahaan_id){
                    $.ajax({
                        type:"GET",
                        url:"/ajax_depo?perusahaan_id="+perusahaan_id,
                        dataType:'JSON',
                        success: function(res){
                            if(res){
                                $("#modal_depo").empty();
                                $("#modal_depo").append('<option value="">Pilih Depo</option>');
                                $.each(res,function(nama,kode){
                                    $("#modal_depo").append('<option value="'+kode+'">'+nama+'</option>');
                                });
                            }else{
                                $("#modal_depo").empty();
                            }
                        }
                    });
                }else{
                    $("#modal_depo").empty();
                }
            });
        });
    </script>





@endsection()