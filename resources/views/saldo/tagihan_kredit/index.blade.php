@extends('layouts.admin')

@section('title')
    <title>Opening Closing</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Tagihan Kredit</li>
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
                                    Opening Closing Setoran Tagihan Kredit

                                            <div class="input-group mb-3 col-md-7 float-right">
                                                <input type="text" id="created_at" name="created_at" class="form-control" hidden>
                                                &nbsp
                                                <select name="perusahaan" id="perusahaan" class="form-control">
                                                    <option value="">Perusahaan</option>
                                                     
                                                </select>
                                                &nbsp
                                                <select name="depo" id="depo" class="form-control">
                                                    <option value="">Depo</option>
                                                    
                                                </select>
                                                &nbsp
                                                <select name="norek" id="norek" class="form-control">
                                                    <option value="">No. Rek</option>
                                                    
                                                </select>
                                                &nbsp
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary detail" type="submit">Cari</button>
                                                </div>
                                            </div>
                                        
                                </h4>
                            </div>
                            
                            <div id="target">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!-- <table class="table table-hover table-bordered"> -->
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr style="background-color: #DCDCDC;">
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Saldo Awal</th>
                                                    <th>Debit</th>
                                                    <th>Kredit</th>
                                                    <th>Saldo Akhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6" class="text-center">Data tidak ditemukan</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                
                                                <td align="right" colspan="6">
                                                    <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm">tambah kolom</button>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
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

        // function show(){
        //     var x = document.getElementById("target");
        //     if (x.style.display === "none"){
        //         x.style.display = "block";
        //     } else {
        //         x.style.display = "none";
        //     }
        // }

    </script>
@endsection()