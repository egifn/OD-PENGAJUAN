@section('js')
<script type="text/javascript">
   var ttl = 0;

    $(document).on('click', '.pilih_vendor', function(e) {
        document.getElementById('kode_supp').value = $(this).attr('data-kode_vendor')
        document.getElementById('supplier').value = $(this).attr('data-nama_vendor')
        document.getElementById('cari_').value = $(this).attr('data-kode_vendor')

        $('#myModalsupp').modal('hide');
    });

    $(function () {
                $("#lookup").dataTable();
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
        cell2.innerHTML = '<input type="text" class="form-control" name="no_btb[]" id="no_btb" style="font-size:13px;" value="'+a+'" readonly hidden>'+a+'';
        cell3.innerHTML = '<input type="text" class="form-control" name="invoice[]" id="invoice" style="font-size: 13px;" value="'+b+'" readonly hidden>'+b+''; 
        cell4.innerHTML = '<input type="text" class="form-control" name="tgl[]" id="tgl" style="font-size: 13px;" value="'+c+'" readonly hidden>'+c+''
        cell5.innerHTML = '<input type="text" style="text-align:right;" class="form-control" name="total[]" id="total" style="font-size: 13px;" value="'+d+'" readonly hidden>'+d+''
        cell6.innerHTML = '<input type="text" style="text-align:right;" class="form-control" name="subtotal[]" id="subtotal" style="font-size: 13px;" value="'+d+'" readonly hidden>'+d+''
        cell7.innerHTML = '<a href="{{ route('counter_bill/create/view_invoice.view_detail', '') }}" target="_blank" class="btn btn-primary btn-sm">View</a>'

              
        ttl = ttl + Number($(this).attr('data-total'));
        document.getElementById('total_head').value = ttl;

        $('#myModal').modal('hide');
    });


    $(document).on('click', '.pilih_category', function(e){
        document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
        document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
        document.getElementById('sifat').value = $(this).attr('data-sifat')
        document.getElementById('jenis').value = $(this).attr('data-jenis')
        document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')

        document.getElementById('kode_coa').value = $(this).attr('data-coa')
        document.getElementById('nama_coa').value = $(this).attr('data-nama_coa')
        document.getElementById('debet').value = $(this).attr('data-debit')
        document.getElementById('kredit').value = $(this).attr('data-kredit')
        
        $('#myModalKategori').modal('hide');
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
            url: '{{ route('counter_bill.store') }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    $(document).ready(function(){
        fetch_vendor_data();
        function fetch_vendor_data(query = '')
        {
            $.ajax({
                url:'{{ route("counter_bill/action_vendor.actionVendor") }}',
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
                url:'{{ route("counter_bill/action_invoice.actionInvoice") }}',
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
        fetch_data_category();
        function fetch_data_category(query = '')
        {
            $.ajax({
                url:'{{ route("counter_bill/action_category.actionCategory") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_category tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_category', function(){
            var query = $(this).val();
            fetch_data_category(query);
        });
    });

</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Buat Kontrabon</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purchasing</li>
        <li class="breadcrumb-item">Kontrabon</li>
        <li class="breadcrumb-item active">Buat Kontrabon</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('counter_bill.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Buat Kontrabon</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        No Kontrabon
                                        <input type="text" name="no_kb" class="form-control" value="{{ $no_kb }}" required readonly>
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

                                    <div class="col-md-2 mb-2">
                                        Jatuh Tempo
                                        <input id="jatuh_tempo" type="date" class="form-control" name="jatuh_tempo" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required >
                                     
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <!-- Object COA -->
                                        <!-- <div class="col-md-4 mb-2" >
                                            <input id="id_pengeluaran" type="text" name="id_pengeluaran" value="" required >
                                        </div>
                                        <div class="col-md-4 mb-2" >
                                            <input id="nama_pengeluaran" type="text" value="" readonly required>
                                        </div>
                                        <div class="col-md-4 mb-2" >
                                            <input id="kode_coa" type="text" name="kode_coa" class="form-control" value=""  required>
                                        </div>
                                        <div class="col-md-4 mb-2" >
                                            <input id="nama_coa" type="text" name="nama_coa" class="form-control" value="" required>
                                        </div>
                                        <div class="col-md-4 mb-2" >
                                            <input id="debet" type="text" name="debet" class="form-control" value="" required>
                                        </div>
                                        <div class="col-md-4 mb-2" >
                                            <input id="kredit" type="text" name="kredit" class="form-control" value="" required>
                                        </div> -->
                                        <!-- End Object COA -->

                                        <!-- Object COA -->
                                        Nama Pengeluaran
                                        <div class="input-group">
                                            <input id="id_pengeluaran" type="hidden" class="form-control" name="id_pengeluaran" value="" required >
                                            <input id="nama_pengeluaran" type="text" class="form-control" readonly required>
                                            <input id="sifat" type="hidden" name="sifat" class="form-control"  required>
                                            <input id="jenis" type="hidden" name="jenis" class="form-control"  required>
                                            <input id="pembayaran" type="hidden" name="pembayaran" class="form-control"  required>
                                            <input id="kategori" type="hidden" name="kategori" class="form-control"  required>
                                            <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran" class="form-control"  required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                            
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="kode_coa" type="text" name="kode_coa" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="nama_coa" type="text" name="nama_coa" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="debet" type="text" name="debet" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-2" hidden>
                                            <input id="kredit" type="text" name="kredit" class="form-control" required>
                                        </div>
                                        <!-- End Object COA -->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Kontrabon
                                        <input type="text" name="tgl_kb" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>
                                    <div class="col-md-2 mb-2" >
                                        Total
                                        <input style="text-align: right;" type="text" name="total_head" id="total_head" class="form-control" value="" required readonly>
                                    </div>
                                
                                    <div class="col-md-6 mb-2" >
                                        Keterangan
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
                                                    <th>Dokumen Vendor</th>
                                                    <th>Tanggal</th>
                                                    <th>Total</th>
                                                    <th>Sub Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>    
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih No Dokumen</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('tabelinput')">Delete No Dokumen</button>
                                    </div>  
                                  
                                    <div class="col-md-8 mb-2">
                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Buat Kontrabon</button>
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
                                <th>Invoice</th>
                                <th>Invoice Date</th>
                                <th>Vendor</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_category" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Pengeluaran</th>
                                <th>Sifat</th>
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

@section('script')



@endsection


