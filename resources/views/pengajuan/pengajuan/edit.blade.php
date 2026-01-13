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
                
                var tabel = document.getElementById("datatabel-v1");
                var row = tabel.insertRow(1);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                var cell8 = row.insertCell(7);
                // var cell9 = row.insertCell(8);
                

                var a = $(this).attr('data-kategori');
                var aa = $(this).attr('data-kode_kategori');
                var b = $(this).attr('data-kode_produk');
                var c = $(this).attr('data-nama_produk');
                var d = $(this).attr('data-merk');
               
               
                cell1.innerHTML = '<input name="chk" type="checkbox" />';
                cell2.innerHTML = '<input type="text" class="form-control" name="type_id[]" id="type_id_'+x+'" style="font-size: 13px;" value="'+aa+'" hidden>'+a+''; 
                cell3.innerHTML = '<input type="text" class="form-control" name="prod_id[]" id="prod_id_'+x+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
                cell4.innerHTML = '<input type="text" class="form-control" name="prod_name[]" id="prod_name_'+x+'" style="font-size: 13px;" value="'+c+'" hidden>'+c+''; 
                cell5.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="merk[]" id="merk_'+x+'" style="font-size: 13px;" value="'+d+'" hidden>'+d+''; 
                cell6.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="qty[]" id="qty_'+x+'" style="font-size: 13px;" required>'
                cell7.innerHTML = '<div class="col-md-10"><select name="kode_divisi[]" id="kode_divisi_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" required ><option value="">Division</option>@foreach ($divisi as $row)<option value="{{ $row->kode_divisi }}" {{ old('kode_divisi[]') == $row->kode_divisi ?'selected':'' }}>{{ $row->nama_divisi }}</option>@endforeach</select></div>';
                cell8.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="desc[]" id="desc_'+x+'" style="font-size: 13px;" required>';
                // cell9.innerHTML = '<input type="file" class="uploads form-control" name="image[]" id="image_'+x+'" style="font-size: 6px;" >';

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

$('#savedatas').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        url: '{{ route("pengajuan.store") }}',
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
            url:'{{ route("pengajuan/action_product.actionProduct") }}',
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
    <title>Edit Pengajuan</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Pengajuan Barang</li>
        <li class="breadcrumb-item active">Edit Pengajuan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan/edit.edit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Edit Pengajuan Barang</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2" hidden>
                                        kode Pengajuan
                                        <input type="text" name="kode_pengajuan" class="form-control" value="{{ $pengajuan_v->kode_pengajuan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
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
                                            <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" value="{{ $pengajuan_v->jenis }}" required >
                                            <input id="nama_pengeluaran" type="text" class="form-control" value="{{ $pengajuan_v->nama_pengeluaran }}" readonly required>
                                            <input id="sifat" type="hidden" name="sifat" class="form-control" value="{{ $pengajuan_v->sifat }}"  required>
                                            <input id="jenis" type="hidden" name="jenis" class="form-control" value="{{ $pengajuan_v->jenis }}"  required>
                                            <input id="pembayaran" type="hidden" name="pembayaran" class="form-control" value="{{ $pengajuan_v->pembayaran }}" required>
                                            <input id="kategori" type="hidden" name="kategori" class="form-control"  required>
                                            <input id="coa_pengeluaran" type="hidden" name="coa_pengeluaran" class="form-control" value="{{ $pengajuan_v->coa }}"  required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalKategori" disabled> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div>
                                       
                                    </div>
                                    
                                </div>
                               
                                <div class="row" hidden>
                                    <div class="col-md-10 mb-2">
                                        Description
                                        <input type="text" name="ket" class="form-control" value="Pengajuan Permintaan Barang" required>
                                    </div>
                                </div>
                                
                                <div class="row" hidden>
                                    <div class="col-md-2 mb-2">
                                        Division
                                        <select name="kode_divisi" class="form-control">
                                            <option value="">Pilih</option>
                                            @foreach ($divisi as $row)
                                                <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                            @endforeach 
                                        </select>
                                       
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    
                                </div>
                                
                            </div>

                                    

                        
                        </div>
                    </div>

<!-- ################################### COBA #################################### -->
                    
                        <!-- <div class="col-md-12">
                            <div class="card">
                                
                                <form id="savedatas">
                                <div class="card-body">
                                    <div class="field_wrapper">
                                        <div class="form-group">
                                            
                                            <div class="row">
                                                <div class="col-md-1" hidden>
                                                    <strong>Type ID</strong>
                                                    <input class="form-control" type="text" name="idtype[]" id="idtype_1" value="" readonly />
                                                </div>
                                                <div class="col-md-1">
                                                    <strong>Type</strong>
                                                    <input class="form-control" type="text" name="type[]" id="type_1" style="font-size: 12px;" value="" readonly />
                                                </div>
                                                <div class="col-md-1">
                                                    <strong>Prod ID</strong>
                                                    <input class="form-control" type="text" name="kode_produk[]" id="kode_produk_1" value="" style="font-size: 12px;" readonly />
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>Product Name</strong>
                                                    <input class="form-control" type="text" name="nama_produk[]" id="nama_produk_1" value="" style="font-size: 12px;" readonly />
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>Merk</strong>
                                                    <input class="form-control" type="text" name="merk[]" id="merk_1" value="" style="font-size: 12px;" readonly />
                                                </div>
                                                <div class="col-md-1">
                                                    <strong>Qty</strong>
                                                    <input class="form-control" type="text" name="qty[]" id="qty_1" style="font-size: 12px; text-align: right;" value="" required />
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>Division</strong>
                                                    <select name="kode_divisi[]" id="kode_divisi_1" class="form-control" style="font-size: 12px; height: 32px;" required>
                                                    <option value="">Division</option>
                                                    @foreach ($divisi as $row)
                                                        <option value="{{ $row->kode_divisi }}" {{ old('kode_divisi[]') == $row->kode_divisi ? 'selected':'' }}>{{ $row->nama_divisi }}</option>
                                                    @endforeach 
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <strong>Description</strong>
                                                    <input class="form-control" type="text" name="description[]" id="description_1" style="font-size: 12px;" value="" required />
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Select Product</button>
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <a class="btn btn-success" href="javascript:void(0);" id="add_button" title="Add field">Add</a>
                                        </div>
                                        <div class="col-md-2 mb-2" align="right">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                           
                            </div>
                        </div> -->

                                <form id="savedatas">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">

                                                

                                                {{-- ===untuk tabel temp========================================================================= --}}

                                                <div class="table-responsive">
                                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="20">#</th>
                                                                    <th width="80" hidden>Id_Tipe</th>
                                                                    <th width="80">Tipe</th>
                                                                    <th width="80">Id Produk</th>
                                                                    <th width="150">Nama Produk</th>
                                                                    <th width="150">Merk</th>
                                                                    <th width="100">Qty</th>
                                                                    <th width="100" hidden>kode_divisi</th>
                                                                    <th width="300">Divisi</th>
                                                                    <th>Keterangan/Desc</th>
                                                                    <th hidden>File/attach</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $no=1; ?>
                                                                @forelse ($details as $row)
                                                                <tr>
                                                                    <td><input name="chk" type="checkbox" /></td>
                                                                    <td hidden>
                                                                        <input type="text" class="form-control" name="type_id[]" id="type_id{{ $no }}" style="font-size: 13px;" value="{{ $row->id_kategori }}" hidden>
                                                                        {{ $row->id_kategori }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="type_name[]" id="type_name{{ $no }}" style="font-size: 13px;" value="{{ $row->name }}" hidden>
                                                                        {{ $row->name }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="prod_id[]" id="prod_id{{ $no }}" style="font-size: 13px;" value="{{ $row->kode_product }}" hidden>
                                                                        {{ $row->kode_product }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="nama_barang[]" id="nama_barang{{ $no }}" style="font-size: 13px;" value="{{ $row->nama_barang }}" hidden>
                                                                        {{ $row->nama_barang }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="merk[]" id="merk{{ $no }}" style="font-size: 13px;" value="{{ $row->merk }}" hidden>
                                                                        {{ $row->merk }}
                                                                    </td>
                                                                    <td align="right">
                                                                        <input type="text" class="form-control" name="qty[]" id="qty{{ $no }}" style="font-size: 13px;" value="{{ $row->qty }}" hidden>
                                                                        {{ $row->qty }}
                                                                    </td>
                                                                    <td hidden>
                                                                        <input type="text" class="form-control" name="kode_divisi[]" id="kode_divisi{{ $no }}" style="font-size: 13px;" value="{{ $row->kode_divisi }}" hidden>
                                                                        {{ $row->kode_divisi }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="nama_divisi[]" id="nama_divisi{{ $no }}" style="font-size: 13px;" value="{{ $row->nama_divisi }}" hidden>
                                                                        {{ $row->nama_divisi }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="desc[]" id="desc{{ $no }}" style="font-size: 13px;" value="{{ $row->description }}" hidden>
                                                                        {{ $row->description }}
                                                                    </td>
                                                                    <td hidden>

                                                                        <!-- <a href="{{url('images/pengajuan/'. $row->image)}}" >
                                                                            {{ $row->image }}
                                                                        </a> -->

                                                                        <a href="#" data-toggle="modal" data-target="#modal_image{{ $row->kode_product }}">
                                                                            {{ $row->image }}
                                                                        </a>

                                                                        <div class="modal fade" id="modal_image{{ $row->kode_product }}" tabindex="-1" role="dialog" aria-labelledby="modal_image" aria-hidden="true">
                                                                          <div class="modal-dialog" style="max-width: 55%; max-height: 55%;" role="document">                               
                                                                            <div class="modal-content">                                       
                                                                             <div class="modal-body">
                                                                                                                 
                                                                               <button type="button" class="close" data-dismiss="modal"><span 
                                                                               aria-hidden="true">&times;</span><span class="sr- 
                                                                               only"> Tutup</span></button>                              
                                                                               <img src="{{url('images/pengajuan/'. $row->image)}}" class="imagepreview" style="width: 100%;">
                                                                                                              
                                                                             </div>                             
                                                                           </div>                                  
                                                                          </div>
                                                                        </div>

                                                                        
                                                                    </td>
                                                                </tr>
                                                                <?php $no++ ?>
                                                                @empty
                                                                <tr>
                                                                    
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    <!--</div>-->
                                                </div>
                                                <br> 
                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                    <tbody>
                                                        <?php $no=1 ?>
                                                        @forelse ($pengajuan_upload as $row)
                                                            <tr>
                                                                <td><i>Attachment_{{ $no }}</i></td>
                                                                <td>
                                                                    <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                        {{ $row->filename }}
                                                                    </a>     
                                                                </td>
                                                                <td>
                                                                    <input type="file" class="form-control" name="filename[]" id="filename_1""    
                                                                </td>
                                                            </tr>
                                                            <?php $no++ ?>
                                                        @empty
                                                            <tr>
                                                                <td><i>Attachment_{{ $no }}</i></td>
                                                                <td>
                                                                    <i>(Tidak ada data Attachment)</i>       
                                                                </td>
                                                                <td>
                                                                    <input type="file" class="form-control" name="filename[]" id="filename_1""    
                                                                </td>
                                                            </tr>
                                                            <?php $no++ ?>       
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Cari Produk</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('datatabel-v1')">Hapus Produk</button>
                                                    </div>  
                                                  
                                                    <div class="col-md-8 mb-2">
                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Simpan</button>
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
                            <th hidden>Id</th>
                            <th>Tipe</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Merk</th>
                            <th>Keterangan/Spek</th>
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




