@section('js')

<script type="text/javascript">
    function readURL(){
        var input = this;
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e){
                $(input).prev().attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function(){
        $(".uploads").change(readURL)
        $("#f").submit(function(){
            return false
        })
    })
</script>

<script type="text/javascript">
 var tot =0;

 var x = 1;
 $(document).on('click', '.pilih', function (e) {
                //document.getElementById('kode_produk').value = $(this).attr('data-kode_produk');
                
                var tabel = document.getElementById("tabelinput");
                var row = tabel.insertRow(1);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                var cell8 = row.insertCell(7);
                
                var a = $(this).attr('data-kode_id');
                var b = $(this).attr('data-pekerjaan');
                var c = $(this).attr('data-kode_vendor');
                var d = $(this).attr('data-nama_vendor');
                var e = $(this).attr('data-satuan');
                var f = $(this).attr('data-harga');
               
                cell1.innerHTML = '<input name="chk" type="checkbox" />';
                cell2.innerHTML = '<input type="text" class="form-control" name="id[]" id="id_'+x+'" style="font-size: 13px;" value="'+a+'" hidden>'+a+'';  
                cell3.innerHTML = '<input type="text" class="form-control" name="pekerjaan[]" id="pekerjaan_'+x+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
                cell4.innerHTML = '<input type="text" style="text-align:right; font-size: 13px; height: 30px; width: 80px;" class="form-control" name="vol[]" id="vol_'+x+'" onchange="jumlah('+x+');" required>' 
                cell5.innerHTML = '<input type="text" style="font-size: 13px;" class="form-control" name="satun[]" id="satuan_'+x+'" style="font-size: 13px;" value="'+e+'" hidden>'+e+'';
                cell6.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="harga[]" id="harga_'+x+'" style="font-size: 13px;" value="'+f+'" hidden>'+f+'';
                cell7.innerHTML = '<input type="text" style="text-align:right; height: 30px; width: 150px;" class="form-control" name="total[]" id="total_'+x+'" style="font-size: 13px;" value="0" required>'
                cell8.innerHTML = '<input type="text" style="text-align:right; height: 30px; width: 80px;" class="form-control" name="persen[]" id="persen_'+x+'" style="font-size: 13px;" value="0" required>'

                $('#myModal').modal('hide');
                x++;
});


    $(document).on('click', '.pilih_category', function(e){
        document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
        document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
        document.getElementById('sifat').value = $(this).attr('data-sifat')
        document.getElementById('jenis').value = $(this).attr('data-jenis')
        document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')
        
        $('#myModalKategori').modal('hide');
    });



function hapusbaris(tabel){
    var tabel = document.getElementById("datatabel-v1");
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

function jumlah(x){
    var tot = 0 ;
    if(x==1){            
        var txtvol = $('#vol_1').val();
        var txtharga = $('#harga_1').val();
        txttotal =txtvol * txtharga;
            
        $('#total_1').val(txttotal);

        tot = $('#total_1').val();
    }else{
        var txtvol = $('#vol_'+x+'').val();
        var txtharga = $('#harga_'+x+'').val();
        txttotal =txtvol * txtharga;
            
        $('#total_'+x+'').val(txttotal);

        tot = $('#total_'+x+'').val();
    }

    /*var tabel = document.getElementById("tabelinput");
    var sumTotal = 0;
    for(var t = 1; t < tabel.rows.length; t++){
            sumTotal = sumTotal + parseInt($('#total_'+t+'').val());
            document.getElementById("total_harga").value = sumTotal;
    }*/
}

$('#savedatas').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        url: '#',
        type: 'POST',
        data: $(this).serializeArray(),
        success: function(data){
            console.log(data);
        }
    });
});

$(document).ready(function(){
        fetch_data_category();
        function fetch_data_category(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan/action_category.actionCategory") }}',
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

$(document).ready(function(){
    fetch_product_data();
    function fetch_product_data(query = '')
    {
        $.ajax({
            url:'{{ route("rab/action_rab.actionRab") }}',
            method:'GET',
            data:{query:query},
            dataType:'json',
            success:function(data)
            {
                $('#lookup tbody').html(data.table_data);
            }
        })
    }

    $(document).on('keyup', '#search', function(){
        var query = $(this).val();
        fetch_product_data(query);
    });
});


</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Create Request</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">R A B</li>
        <li class="breadcrumb-item active">Buat R A B</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Buat R A B</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-2 mb-2">
                                        Tanggal
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" class="form-control" value="{{Auth::user()->kode_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="kode_depo" class="form-control" value="{{Auth::user()->kode_depo}}" required readonly>
                                    </div>

                                    <!-- <div class="col-md-2 mb-2">
                                        Type
                                        <select name="jenis" class="form-control" required>
                                            <option value="">Pilih</option>
                                            <option value="Rutin">Rutin</option>
                                            <option value="Non Rutin">Non Rutin</option>
                                        </select>
                                       
                                    </div> -->

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <div class="input-group">
                                            <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" value="" required >
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
                                       
                                    </div>
                                    
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-10 mb-2">
                                        Nama Proyek
                                        <input type="text" name="ket" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    
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
                                                                    <th>Kode</th>
                                                                    <th>Pekerjaan</th>
                                                                    <th>Vol</th>
                                                                    <th>Satuan</th>
                                                                    <th>Harga Satuan</th>
                                                                    <th>Sub Total</th>
                                                                    <th>%</th>
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
                                                        <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_head">Tambah Header</button>

                                                        <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Pilih Pekerjaan</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('datatabel-v1')">H a p u s</button>
                                                    </div>  
                                                  
                                                    <div class="col-md-8 mb-2">
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                                    </div> 
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>

            </form>
        </div>
    </div>
</main>

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

<div class="modal fade bd-example-modal-lg" id="myModal_head" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-6 col-md-10 float-right">
                        <input type="text" name="header" id="header" class="form-control" placeholder="Isi header sesuai kebutuhan....">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Produk . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nama Pekerjaan</th>
                            <th>Kd Vendor</th>
                            <th>Nama Vendor</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
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
    </script>

@endsection




