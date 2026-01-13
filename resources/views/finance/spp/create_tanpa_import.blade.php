@section('js')
<script type="text/javascript">
    $(document).on('click', '.pilih', function (e) {
        document.getElementById("kontrabon").value = $(this).attr('data-kontrabon');
        document.getElementById("supplier").value = $(this).attr('data-vendor');
        document.getElementById("status_pajak").value = $(this).attr('data-pajak');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("jt").value = $(this).attr('data-jt');
        document.getElementById("ket").value = $(this).attr('data-keterangan');
        document.getElementById("request_by").value = $(this).attr('data-user');
        document.getElementById("kode_supplier").value = $(this).attr('data-kdVendor');
        $('#myModal').modal('hide');
    });
    $(function () {
        $("#lookup").dataTable();
    });

    $(document).on('click', '.pilih_sparepart', function (e) { //jika menggunakan import rcm
        document.getElementById("spp_sparepart").value = $(this).attr('data-code');
        document.getElementById("kontra_sparepart").value = $(this).attr('data-kontra');
        document.getElementById("kode_supplier").value = $(this).attr('data-supplier_code');
        document.getElementById("supplier").value = $(this).attr('data-supplier');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("jt").value = $(this).attr('data-jt');
        document.getElementById("request_by").value = $(this).attr('data-user');
        $('#myModal_sparepart').modal('hide');
    });
    $(function () {
        $("#lookup_sparepart").dataTable();
    });

    $(document).on('click', '.pilih_kontra_sparepart', function (e) {
        //document.getElementById("spp_sparepart").value = $(this).attr('data-code');
        document.getElementById("kontra_sparepart").value = $(this).attr('data-kontrabon');
        document.getElementById("kode_supplier").value = $(this).attr('data-kodevendor');
        document.getElementById("supplier").value = $(this).attr('data-vendor');
        document.getElementById("status_pajak").value = $(this).attr('data-pajak');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("jt").value = $(this).attr('data-jt');
        document.getElementById("ket").value = $(this).attr('data-keterangan');
        document.getElementById("request_by").value = $(this).attr('data-user');
        $('#myModal_kontra_sparepart').modal('hide');
    });
    $(function () {
        $("#lookup_kontra_sparepart").dataTable();
    });

    $(document).on('click', '.pilih_request', function (e) {
        document.getElementById("request").value = $(this).attr('data-pengajuan');
        document.getElementById("total").value = $(this).attr('data-total');
        document.getElementById("terhitung").value = $(this).attr('data-terbilang');
        document.getElementById("ket").value = $(this).attr('data-keterangan');
        document.getElementById("request_by").value = $(this).attr('data-user');
        $('#myModal_request').modal('hide');
    });
    $(function () {
        $("#lookup_request").dataTable();
    });

    $(document).on('click', '.pilih_payment', function(e) {
        document.getElementById("payment").value = $(this).attr('data-norek');
        document.getElementById("bank").value = $(this).attr('data-bank');
        document.getElementById("kode_perusahaan").value = $(this).attr('data-kodeperusahaan');
        $('#myModal_payment').modal('hide');
    });
    $(function () {
        $('#lookup_payment').dataTable();
    });

    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById("kode_supplier").value = $(this).attr('data-kvendor');
        document.getElementById("supplier").value = $(this).attr('data-nvendor').concat(' / ',$(this).attr('data-status'));
        $('#myModal_vendor').modal('hide');
    });
    $(function () {
        $('#lookup_vendor').dataTable();
    });

    $(document).ready(function(){
        if ($("input[name='bayar']:checked").val() == "kredit" ) {
            $("#form-input-request").hide();
            $("#form-input-sparepart").hide();
        }else{
            $("#form-input-request").show();
        }
        var disabled = false;
        $(".detail").click(function(){ 
            if ($("input[name='bayar']:checked").val() == "kredit" ) { 
                $("#form-input").slideDown("fast"); 
                $("#form-input-request").slideUp("fast");
                $('#form-input-sparepart').slideUp("fast");
                $("#supplier").prop('readonly', true);
                $("#total").prop('readonly', true);
                $("#form-terhitung").slideDown("fast");
                $("#terhitung").prop('readonly', true);
                $("#jt").prop('readonly', true);
                $("#pajak_masukan").prop('readonly', false);
                $("#ket").prop('readonly', true); 


                document.getElementById("kontrabon").value = "-";
                document.getElementById("no_order").value = "-";
                document.getElementById("spp_sparepart").value = "-";
                document.getElementById("kontra_sparepart").value = "-";
                document.getElementById("request").value = "-";
                document.getElementById("kode_supplier").value = "";
                document.getElementById("supplier").value = "";
                document.getElementById("status_pajak").value = "";
                document.getElementById("total").value = "";
                document.getElementById("terhitung").value = "";
                document.getElementById("jt").value = "";
                document.getElementById("pajak_masukan").value = "0"; 
                document.getElementById("ket").value = ""; 
                document.getElementById("payment").value = "";
                document.getElementById("request_by").value = "";
                document.getElementById("bank").value = "";
                document.getElementById("kode_perusahaan").value = "";  
            } else if ($("input[name='bayar']:checked").val() == "sparepart" ) {
                $("#form-input").slideUp("fast"); 
                $("#form-input-request").slideUp("fast");
                $('#form-input-sparepart').slideDown("fast");
                $("#supplier").prop('readonly', true);
                $("#total").prop('readonly', true);
                $("#form-terhitung").slideDown("fast");
                $("#terhitung").prop('readonly', true);
                $("#jt").prop('readonly', true);
                $("#pajak_masukan").prop('readonly', false);
                $("#ket").prop('readonly', false); 

                document.getElementById("kontrabon").value = "-";
                document.getElementById("no_order").value = "-";
                document.getElementById("spp_sparepart").value = "-";
                document.getElementById("kontra_sparepart").value = "-";
                document.getElementById("request").value = "-";
                document.getElementById("kode_supplier").value = "";
                document.getElementById("supplier").value = "";
                document.getElementById("status_pajak").value = "";
                document.getElementById("total").value = "";
                document.getElementById("terhitung").value = "";
                document.getElementById("jt").value = "";
                document.getElementById("pajak_masukan").value = "0"; 
                document.getElementById("ket").value = ""; 
                document.getElementById("payment").value = "";
                document.getElementById("request_by").value = "";
                document.getElementById("bank").value = "";
                document.getElementById("kode_perusahaan").value = ""; 
            } else {
                $("#form-input").slideUp("fast"); 
                $('#form-input-sparepart').slideUp("fast");
                $("#form-input-request").slideDown("fast");
                $("#supplier").prop('readonly', false);
                $("#total").prop('readonly', true);
                $("#form-terhitung").slideDown("fast");
                $("#terhitung").prop('readonly', true);
                $("#jt").prop('readonly', false);
                $("#pajak_masukan").prop('readonly', false);
                $("#ket").prop('readonly', true);  

                document.getElementById("kontrabon").value = "-";
                document.getElementById("no_order").value = "-";
                document.getElementById("spp_sparepart").value = "-";
                document.getElementById("kontra_sparepart").value = "-";
                document.getElementById("request").value = "-";
                document.getElementById("kode_supplier").value = "";
                document.getElementById("supplier").value = "";
                document.getElementById("status_pajak").value = "";
                document.getElementById("total").value = "";
                document.getElementById("terhitung").value = "";
                document.getElementById("jt").value = ""; 
                document.getElementById("pajak_masukan").value = "0";
                document.getElementById("ket").value = ""; 
                document.getElementById("payment").value = "";
                document.getElementById("request_by").value = "";
                document.getElementById("bank").value = "";
                document.getElementById("kode_perusahaan").value = "";  
            }
        });
    });

    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_vendor.actionVendor") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_vendor tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_vendor', function(){
            var query = $(this).val();
            fetch_vendor_data(query);
        });
    });

    $(document).ready(function(){
        fetch_payment_data();
        function fetch_payment_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_payment.actionPayment") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_payment tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_payment', function(){
            var query = $(this).val();
            fetch_payment_data(query);
        });
    });

    $(document).ready(function(){
        fetch_kontra_data();
        function fetch_kontra_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_kontra.actionKontra") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_kontra', function(){
            var query = $(this).val();
            fetch_kontra_data(query);
        });
    });

    $(document).ready(function(){
        fetch_request_data();
        function fetch_request_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_request.actionRequest") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_request tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_request', function(){
            var query = $(this).val();
            fetch_request_data(query);
        });
    });

    function show_my_pdf() {
        var retVal = confirm("Do you want to continue to print?");
        if( retVal == true ) {
            window.open('{{ route('spp.spp_pdf', $no_urut) }}', '_blank');    
        }
    }

    $(document).ready(function(){ //jika menggunakan import rcm
        fetch_sparepart_data();
        function fetch_sparepart_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_sparepart.actionSparepart") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_sparepart tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_sparepart', function(){
            var query = $(this).val();
            fetch_sparepart_data(query);
        });
    });

    $(document).ready(function(){
        fetch_kontra_sparepart_data();
        function fetch_kontra_sparepart_data(query = '')
        {
            $.ajax({
                url:'{{ route("spp/action_sparepart_kontra.actionSparepartKontra") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_kontra_sparepart tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_Kontra_sparepart', function(){
            var query = $(this).val();
            fetch_kontra_sparepart_data(query);
        });
    });

    function show_my_pdf() {
        var retVal = confirm("Do you want to continue to print?");
        if( retVal == true ) {
            window.open('{{ route('spp.spp_pdf', $no_urut) }}', '_blank');    
        }
    }

</script>
@stop

@extends('layouts.admin')

@section('title')
	<title>Create SPP</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item active">Create SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
              	
              	<!-- FORM INPUT NEW CATEGORY  -->
                <div class="col-md-12">
                    <div class="card card-accent-primary">
                        <div class="card-header">
                            <h4 class="card-title">Create SPP</h4>
                        </div>
                        <div class="card-body">

                        	<form action="{{ route('spp.store') }}" method="post" enctype="multipart/form-data">
                        		@csrf
                        		<div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        no_urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $no_urut }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Company
                                        <select name="kode_perusahaan" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Source of funds
                                        <select name="kode_sumber" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($dana as $row)
                                                <option value="{{ $row->sumber_dana }}" {{ old('sumber_dana') == $row->sumber_dana ? 'selected':'' }}>{{ $row->sumber_dana }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2" hidden>
                                        Source of funds
                                        <select name="kode_sumber_1" class="form-control">
                                            <option value="">Select</option>
                                            <option value="TA 1">TA 1</option>
                                            <option value="TA 2">TA 2</option>
                                            <option value="TU 1">TU 1</option>
                                            <option value="TU 2">TU 2</option>
                                            <option value="TUA 1">TUA 1</option>
                                            <option value="TUA 2">TUA 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        SPP Date
                                        <input type="text" name="tgl_spp" id="tgl_spp" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        SPP
                                        <input type="text" name="no_spp" id="no_spp" class="form-control" value="" readonly>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-2 mb-2">
                                       <input name="bayar" type="radio" id="kredit" value="kredit" class="detail" checked="true"  />
                                       Non Sparepart
                                    </div>
                                    <div class="col-md-2 mb-2">
                                       <input name="bayar" type="radio" id="sparepart" value="sparepart" class="detail"  />
                                       Sparepart
                                    </div>
                                    <div class="col-md-2 mb-2">
                                       <input name="bayar" type="radio" id="tunai" value="tunai" class="detail"  />
                                       Etc
                                    </div>
                                    
                                      
                                </div>
                                
                                <div id="form-input">
                                    <div id="form-input" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Counter Bill
                                            <div class="input-group">
                                                <input id="kontrabon" name="kontrabon" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2" hidden>
                                            PO
                                            <input type="text" name="no_order" id="no_order" class="form-control" value="-" required readonly>
                                        </div> 
                                    </div>   
                                </div>

                                <div id="form-input-sparepart">
                                    <div id="form-input-sparepart" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        <div class="col-md-3 mb-2" hidden> <!-- jika versi import dari RCM -->
                                            SPP
                                            <div class="input-group">
                                                <input id="spp_sparepart" name="spp_sparepart" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_sparepart"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Kontrabon
                                            <div class="input-group">
                                                <input id="kontra_sparepart" name="kontra_sparepart" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_kontra_sparepart"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div> 
                                    </div>   
                                </div>

                                <div id="form-input-request">
                                    <div id="form-input-request" class="row">
                                        <div class="col-md-3 mb-2">
                                        
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            Request ID
                                            <div class="input-group">
                                                <input id="request" name="request" type="text" class="form-control" value="-" readonly required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_request"> <span class="fa fa-search"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        
                                    </div>   
                                </div>


                            
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Addressed to
                                        <input type="text" name="tujuan" id="tujuan" class="form-control" required>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2" hidden>
                                        kode supplier
                                        <input id="kode_supplier" name="kode_supplier" type="text" class="form-control" value="" readonly>
                                    </div>
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-6 mb-2">
                                        For
                                        <!--
                                        <input type="text" name="supplier" id="supplier" class="form-control" required readonly>
                                        -->
                                        <div class="input-group">
                                            <input id="supplier" name="supplier" type="text" class="form-control" value="-" readonly required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_vendor"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2" hidden>
                                        <input id="status_pajak" name="status_pajak" type="text" class="form-control" value="" readonly required>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                	<div class="col-md-6 mb-2">
                                        Amount
                                        <input type="text" name="total" id="total" class="form-control" style="text-align: right;" required readonly>
                                    </div>
                                </div>

                                <div id="form-terhitung" class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                	<div class="col-md-6 mb-2">
                                        Counted
                                        <textarea id="terhitung" name="terhitung" id="terhitung" class="form-control" rows="3" cols="50" readonly>

										</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Due Date
                                        <input type="date" name="jt" id="jt" class="form-control" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Faktur Pajak Masukan
                                        <input type="text" name="pajak_masukan" id="pajak_masukan" value="0" class="form-control" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Description
                                        <textarea id="ket" name="ket" class="form-control" rows="3" cols="50" required readonly> 
                                        	
										</textarea>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-3 mb-2">
                                        payment
                                        <div class="input-group">
                                            <input id="payment" name="payment" type="text" class="form-control" value="-" readonly required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal_payment"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-2 mb-2">
                                        Request By
                                        <input type="text" name="request_by" id="request_by" class="form-control" readonly required>
                                    </div>
                                    
                                    <div class="col-md-3 mb-2">
                                        <br>
                                        <button class="btn btn-primary btn-sm" onclick="show_my_pdf()">Create</button>
                                    </div> 

                                    <div class="col-md-2 mb-2" hidden>
                                        bank
                                        <input type="text" name="bank" id="bank" class="form-control">
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        kode perusahaan
                                        <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control">
                                    </div>
                                </div>

                        	</form>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModal_vendor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_vendor" id="cari_vendor" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_vendor" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Vendor Id</th>
                                <th>Vendor Name</th>
                                <th>Address</th>
                                <th>Status</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Counter Bill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_kontra" id="cari_kontra" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Counter Bill</th>
                                <th>Vendor</th>
                                <th>Total</th>
                                <th>Due Date</th>
                                <th>Description</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_sparepart" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SPP Sparepart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_sparepart" id="cari_sparepart" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_sparepart" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Counter Bill</th>
                                <th>Supplier</th>
                                <th>Total</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_kontra_sparepart" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kontrabon Sparepart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_Kontra_sparepart" id="cari_Kontra_sparepart" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_kontra_sparepart" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kontrabon</th>
                                <th>Supplier</th>
                                <th>Total</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_request" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cost Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_request" id="cari_request" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_request" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>date</th>
                                <th>Company</th>
                                <th>Description</th>
                                <th>Total</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_payment" id="cari_payment" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_payment" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th>Bank</th>
                                <th>Company Id</th>
                                <th>Company Name</th>
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

@endsection