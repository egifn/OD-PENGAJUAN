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

   var ttl = 0;

    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById('kode_supp').value = $(this).attr('data-kode_vendor')
        document.getElementById('supplier').value = $(this).attr('data-nama_vendor')
        document.getElementById('cari_').value = $(this).attr('data-kode_vendor')

        $('#myModalsupp').modal('hide');
    });

    var x = 1;
    $(document).on('click', '.pilih', function (e) {
                //document.getElementById('kode_produk').value = $(this).attr('data-kode_produk');
                x++;
                var tabel = document.getElementById("tabelinput");
                var row = tabel.insertRow(1);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                
                var a = $(this).attr('data-btb');
                var b = $(this).attr('data-invoice');
                var c = $(this).attr('data-tgl');
                var d = $(this).attr('data-total');
               
                cell1.innerHTML = '<input name="chk" type="checkbox" />';
                cell2.innerHTML = '<input type="text" class="form-control" name="no_btb[]" id="no_btb" style="font-size:13px;" value="'+a+'" readonly>';
                cell3.innerHTML = '<input type="text" class="form-control" name="invoice[]" id="invoice" style="font-size: 13px;" value="'+b+'" readonly>'; 
                cell4.innerHTML = '<input type="text" class="form-control" name="tgl[]" id="tgl" style="font-size: 13px;" value="'+c+'" readonly>'
                cell5.innerHTML = '<input type="text" style="text-align:right;" class="form-control" name="total[]" id="total" style="font-size: 13px;" value="'+d+'" readonly>'
                cell6.innerHTML = '<input type="text" style="text-align:right;" class="form-control" name="subtotal[]" id="subtotal" style="font-size: 13px;" value="'+d+'" readonly>'
                cell7.innerHTML = '<a href="{{ route('counter_bill/create/view_invoice.view_detail', '') }}" target="_blank" class="btn btn-primary btn-sm">View</a>'

              
                ttl = ttl + Number($(this).attr('data-total'));
                document.getElementById('total_head').value = ttl;

                if ($("input[name='jenis']:checked").val() == "sparepart" ) {
                    $('#myModal').modal('hide');
                }else{
                    $('#myModal_tire').modal('hide');
                }
                
    });

    
    $(function () {
                $("#lookup").dataTable();
    });

    function hapusbaris(tabel){
        var tabel = document.getElementById("tabelinput");
        var bacabaris = tabel.rows.length;
        for(var i=0;i<bacabaris;i++){
            //baca baris yang ke i
            var bacabarisyangke = tabel.rows[i];
            //baca ceklist di childnode cell ke 0
            var bacaceklist = bacabarisyangke.cells[0].childNodes[0];
            //jika ada ceklist
            if(null != bacaceklist && true == bacaceklist.checked){
                tabel.deleteRow(i);
                bacabaris--;
                i--;

                //tot = tot - $('#total_'+y+'').val();
                //document.getElementById("total_harga").value = (tot);
                //var total =  document.getElementById("total_head").value;
                //ttotal = ttotal - $('#total').val()
                //document.getElementById('total_head').value = ttotal;
            }
        }
        return false;
    }

    $('#savedatas').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("kontrabon.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    function show_my_pdf() {
        var retVal = confirm("Do you want to continue to print?");
        if( retVal == true ) {
            window.open('{{ route('kontrabon.kontrabon_pdf', $no_kb) }}', '_blank');    
        }
    }


    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("kontrabon/action_vendor.actionVendor") }}',
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
        fetch_invoice_vendor();
        function fetch_invoice_vendor(query = '')
        {
             $.ajax({
                url:'{{ route("kontrabon/action_invoice.actionInvoice") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup tbody').html(data.table_data);
                }
            })
        }

        $('#caridatas').on('click', function(e){
            var query = document.getElementById("cari_").value;
            fetch_invoice_vendor(query);
        });
    });

    $(document).ready(function(){
        fetch_invoice_vendor_tire();
        function fetch_invoice_vendor_tire(query = '')
        {
             $.ajax({
                url:'{{ route("kontrabon/action_invoice_tire.actionInvoiceTire") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_tire tbody').html(data.table_data);
                }
            })
        }

        $('#caridatas_tire').on('click', function(e){
            var query = document.getElementById("cari_").value;
            fetch_invoice_vendor_tire(query);
        });
    });

    $(document).ready(function(){
        if ($("input[name='jenis']:checked").val() == "sparepart" ) {
            $("#form-input-tire").hide();
        }else{
            $("#form-input-sparepart").show();
        }
        $(".detail").click(function(){
            if ($("input[name='jenis']:checked").val() == "sparepart" ) {
                $("#form-input-sparepart").slideDown("fast"); 
                $("#form-input-tire").slideUp("fast");
            }else{
                $("#form-input-sparepart").slideUp("fast"); 
                $("#form-input-tire").slideDown("fast");
            }
        });
    });



</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Create Kontra</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Sparepart</li>
        <li class="breadcrumb-item">Kontrabon</li>
        <li class="breadcrumb-item active">Create Kontrabon</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('kontrabon.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Create Kontrabon
                                    &nbsp;&nbsp;
                                    <input name="jenis" type="radio" id="sparepart" value="sparepart" class="detail" checked="true"  />
                                       Sparepart
                                       &nbsp;&nbsp;
                                    <input name="jenis" type="radio" id="tire" value="tire" class="detail"  />
                                       Tire 
                                </h4>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Kontrabon ID
                                        <input type="text" name="no_kb" id="no_kb" class="form-control" value="{{ $no_kb }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2 float-right">
                                        Date
                                        <input type="text" name="tgl_kb" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2 float-right">
                                        
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Termin
                                        <input type="text" name="termin" class="form-control" required value="">
                                        
                                    </div>
                                </div>

                               
                                <div class="row">
                                    <div class="col-md-4 mb-2 float-right">
                                        Vendor
                                        <div class="input-group">
                                            <input id="supplier" type="text" class="form-control" readonly required>
                                            <input id="kode_supp" type="hidden" name="kode_supp" value="{{ old('kode_supp') }}" required readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalsupp"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-2 mb-2 float-right">

                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Due date
                                        <input id="jatuh_tempo" type="date" class="form-control" name="jatuh_tempo" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                     
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        Periode start-end
                                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        Total
                                        <input style="text-align: right;" type="text" name="total_head" id="total_head" class="form-control" value="" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" >
                                        
                                    </div>
                                    <div class="col-md-6 mb-2" >
                                        Description
                                        <input type="text" name="description" class="form-control" value="" required>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <form id="savedatas">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No BTB</th>
                                                    <th>Invoice</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Sub Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br> 
                                
                                <div id="form-input-sparepart">
                                    <div id="form-input-sparepart" class="row">
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="caridatas" name="caridatas" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Choose Invoice</button>

                                            <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Delete Product</button>
                                        </div>  
                                  
                                        <div class="col-md-8 mb-2">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right" onclick="show_my_pdf()">Save</button>
                                        </div> 
                                    </div>
                                </div>   
                                <div id="form-input-tire">
                                    <div class="row">
                                        <div id="form-input-tire" class="col-md-4 mb-2">
                                            <button type="button" id="caridatas_tire" name="caridatas_tire" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_tire">Choose Invoice</button>

                                            <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Delete Product</button>
                                        </div>  
                                  
                                        <div class="col-md-8 mb-2">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right" onclick="show_my_pdf()">Save</button>
                                        </div> 
                                    </div>
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

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right" hidden>
                        <input type="text" name="cari_" id="cari_" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Partinsupp Code</th>
                                <th>Partinsupp Date</th>
                                <th>Partinsupp Nobon</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_tire" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document_product" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right" hidden>
                        <input type="text" name="cari_" id="cari_" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_tire" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Tireinsupp Code</th>
                                <th>Tireinsupp Date</th>
                                <th>Tireinsupp Nobon</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalsupp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supplier</h5>
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
                                <th>Kode</th>
                                <th>Supplier</th>
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




