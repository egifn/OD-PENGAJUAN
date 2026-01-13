@section('js')
<script type="text/javascript">
    $(document).on('click', '.pilih_category', function(e){
        document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
        document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
        document.getElementById('sifat').value = $(this).attr('data-sifat')
        document.getElementById('jenis').value = $(this).attr('data-jenis')
        document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')
        
        // document.getElementById('kode_coa').value = $(this).attr('data-kode_coa')
        // document.getElementById('coa').value = $(this).attr('data-nama_coa')
        // document.getElementById('debit').value = $(this).attr('data-debit')
        // document.getElementById('kredit').value = $(this).attr('data-kredit')

        $('#myModalKategori').modal('hide');
    });

    $(document).on('click', '.pilih_coa', function(e) {
        document.getElementById('kode_coa').value = $(this).attr('data-kode_coa')
        document.getElementById('coa').value = $(this).attr('data-coa')
        document.getElementById('debit').value = $(this).attr('data-debit')
        document.getElementById('kredit').value = $(this).attr('data-kredit')

        $('#myModalCoa').modal('hide');
    });


    // var tot =0;
    // var x = 1;
    // $(document).on('click','.pilih_biaya', function(e) {
    //     var tabel = document.getElementById("datatabel-v1");
    //     var row = tabel.insertRow(1);

    //     var cell1 = row.insertCell(0);
    //     var cell2 = row.insertCell(1);
    //     var cell3 = row.insertCell(2);
    //     var cell4 = row.insertCell(3);
    //     var cell5 = row.insertCell(4);
    //     var cell6 = row.insertCell(5);
    //     var cell7 = row.insertCell(6);
        
    //     var a = $(this).attr('data-id');
    //     var b = $(this).attr('data-uraian');
    //     var c = $(this).attr('data-spek');
    //     var d = $(this).attr('data-qty');
    //     var e = $(this).attr('data-harga');
    //     var f = $(this).attr('data-tharga');
        
    //     cell1.innerHTML = '<input name="chk" type="checkbox" />';
    //     cell2.innerHTML = '<input type="text" class="form-control" name="kode[]" id="kode_'+x+'" style="font-size: 13px;" value="'+a+'" hidden>'+a+''; 
    //     cell3.innerHTML = '<input type="text" class="form-control" name="uraian[]" id="uraian_'+x+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
    //     cell4.innerHTML = '<input type="text" class="form-control" name="spesifikasi[]" id="spesifikasi_'+x+'" style="font-size: 13px;" value="'+c+'" hidden>'+c+'';
    //     cell5.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="jumlah[]" id="jumlah_'+x+'" style="font-size: 13px;" value="'+d+'" hidden>'+d+'';
    //     cell6.innerHTML = '<input type="text" class="form-control" name="harga[]" id="harga_'+x+'" style="font-size: 6px;" value="'+e+'" hidden>'+e+'';
    //     cell7.innerHTML = '<input type="text" class="form-control" name="tharga[]" id="tharga_'+x+'" style="font-size: 6px;" value="'+f+'" hidden>'+f+'';

    //     $('#myModalBiaya').modal('hide');
    //     x++;

    //     //menghilangka format rupiah//
    //     var temp_tharga = $(this).attr('data-tharga').replace(/[.](?=.*?\.)/g, '');
    //     var outStr = parseFloat(temp_tharga.replace(/[^0-9.]/g,''));
    //     //End menghilangka format rupiah//
    //     tot = tot + (outStr);

    //     //membuat format rupiah//
    //     var reverse = tot.toString().split('').reverse().join(''),
    //         ribuan  = reverse.match(/\d{1,3}/g);
    //         hasil = ribuan.join(',').split('').reverse().join('');
    //     //End membuat format rupiah//

    //     document.getElementById('total_biaya').value = (hasil);
    // });


    $(document).ready(function(){

        // Check / Uncheck semua
        $("#checkAll").click(function(){
            $(".checkItem").prop('checked', $(this).prop('checked'));
        });

        // Saat klik Simpan
        $("#btnSimpanBiaya").click(function(){
            $("#lookup_biaya tbody tr").each(function(){
                var checked = $(this).find(".checkItem").is(":checked");
                if(checked){
                    var kode = $(this).find("td:eq(1)").text();
                    var uraian = $(this).find("td:eq(3)").text();
                    var spesifikasi = $(this).find("td:eq(4)").text();
                    var qty = $(this).find("td:eq(9)").text();
                    var harga = $(this).find("td:eq(10)").text();
                    var total = $(this).find("td:eq(13)").text();

                    // Tambahkan ke tabel utama
                    var rowCount = $("#datatabel-v1 tbody tr").length + 1;
                    var newRow = "<tr>" +
                                    "<td>"+rowCount+"</td>" +
                                    "<td>"+kode+"<input type='hidden' name='kode[]' value='"+kode+"'></td>" +
                                    "<td>"+uraian+"<input type='hidden' name='uraian[]' value='"+uraian+"'></td>" +
                                    "<td>"+spesifikasi+"<input type='hidden' name='spesifikasi[]' value='"+spesifikasi+"'></td>" +
                                    "<td style='text-align:right;'>"+qty+"<input type='hidden' name='jumlah[]' value='"+qty+"'></td>" +
                                    "<td style='text-align:right;'>"+harga+"<input type='hidden' name='harga[]' value='"+harga+"'></td>" +
                                    "<td style='text-align:right;'>"+total+"<input type='hidden' name='tharga[]' value='"+total+"'></td>" +
                                    "<td><button type='button' class='btn btn-danger btn-sm btnHapus'>Hapus</button></td>" +
                                "</tr>";
                    $("#datatabel-v1 tbody").append(newRow);
                }
            });

            // Hitung total biaya
            hitungTotal();

            // Tutup modal
            $("#myModalBiaya").modal('hide');
        });

        // Fungsi hitung total
        function hitungTotal(){
            var total = 0;
            $("#datatabel-v1 tbody tr").each(function(){
                var nilaiText = $(this).find("td:eq(6)").text().trim();
                // hapus semua karakter selain digit
                var nilai = parseFloat(nilaiText.replace(/[^0-9.-]+/g,"")) || 0;
                total += nilai;
            });

            // format hasil total ke ribuan lagi
            $("#total_biaya").val(total.toLocaleString('id-ID'));
            
            let total_temp = $("#total_biaya").val().replace(/\./g,'').replace(/,/g,'');
            $("#total_biaya_temp").val(total_temp);
        }

        $(document).on("click", ".btnHapus", function(){
            $(this).closest("tr").remove();
            hitungTotal(); // panggil ulang fungsi hitung total
            resetNomorUrut(); // supaya nomor urut (#) rapi lagi
        });

        function resetNomorUrut(){
            $("#datatabel-v1 tbody tr").each(function(index){
                $(this).find("td:eq(0)").text(index+1);
            });
        }

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
            url: '{{ route("pengajuan_spp.store") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(data){
                console.log(data);
            }
        });
    });

    $(function(){
        $('#kode_perusahaan').change(function(){
            var perusahaan_id = $(this).val();
            if(perusahaan_id){
                $.ajax({
                    type:"GET",
                    url:"/ajax?perusahaan_id="+perusahaan_id,
                    dataType:'JSON',
                    success: function(res){
                        if(res){
                            $("#kode_depo").empty();
                            $("#kode_depo").append('<option>Select</option>');
                            $.each(res,function(nama,kode){
                                $("#kode_depo").append('<option value="'+kode+'">'+nama+'</option>');
                            });
                        }else{
                            $("#kode_depo").empty();
                        }
                    }
                });
            }else{
                $("#kode_depo").empty();
            }
        });
    });

    $(document).ready(function(){
            fetch_data_coa();
            function fetch_data_coa(query = '')
            {
                $.ajax({
                    url:'{{ route("pengajuan_biaya/action_coa.actionCoa") }}',
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#lookup_coa tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search_coa', function(){
                var query = $(this).val();
                fetch_data_coa(query);
            });
    });

    $(document).ready(function(){
            fetch_data_category();
            function fetch_data_category(query = '')
            {
                $.ajax({
                    url:'{{ route("pengajuan_biaya/action_category.actionCategory") }}',
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
        fetch_data_biaya();
        function fetch_data_biaya(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan_spp/action_Biaya.actionBiaya") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_biaya tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_biaya', function(){
            var query = $(this).val();
            fetch_data_biaya(query);
        });
    });

    $("#btnFilter").click(function() {
        var tgl_awal = $("#tanggal_awal").val();
        var tgl_akhir = $("#tanggal_akhir").val();
        var search = $("#search_biaya").val();

        $.ajax({
            url: '{{ route("pengajuan_spp/action_Biaya.actionBiaya") }}',
            type: "GET",
            data: {
                tanggal_awal: tgl_awal,
                tanggal_akhir: tgl_akhir,
                query: search
            },
            dataType:'json',
            success: function(data) {
                $('#lookup_biaya tbody').html(data.table_data);
            }
        });
});



</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Buat Pengajuan SPP</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">SPP</li>
        <li class="breadcrumb-item active">Buat Pengajuan SPP</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan_spp.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Buat Pengajuan SPP</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan SPP
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" class="form-control" value="{{Auth::user()->kode_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                            Untuk Perusahaan
                                            <select name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan"
                                                class="form-control" required>
                                                <option value="">select</option>
                                                @foreach ($perusahaan as $row)
                                                    <option value="{{ $row->kode_perusahaan }}"
                                                        {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected' : '' }}>
                                                        {{ $row->nama_perusahaan }}</option>
                                                @endforeach
                                            </select>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <!-- <select name="kode_depo" id="kode_depo" class="form-control">
                                            <option value="">select</option>
                                        </select> -->
                                        <input type="text" name="kode_depo" class="form-control" value="{{Auth::user()->kode_depo}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Divisi
                                        
                                        <input type="text" name="kode_divisi" class="form-control" value="{{Auth::user()->kode_divisi}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-2 mb-2" hidden>
                                        Type
                                        <select name="tipe" class="form-control">
                                            <option value="">Select</option>
                                            <option value="OPS Rit">OPS Rit</option>
                                            <option value="BBM">BBM</option>
                                            <option value="Bengkel">Bengkel</option>
                                            <option value="Materai">Materai</option>
                                            <option value="REX">REX</option>
                                            <option value="Telepon/Internet">Telepon/Internet</option>
                                            <option value="Tiki">Tiki</option>
                                            <option value="Weekly">Weekly</option>
                                        </select>
                                       
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Nama Pengeluaran
                                        <!-- <select name="jenis" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Rutin">Rutin</option>
                                            <option value="Non Rutin">Non Rutin</option>
                                        </select> -->
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

                                    <div class="col-md-6 mb-2">
                                        <!-- C O A
                                        <div class="input-group">
                                            <input id="coa" type="text" class="form-control" readonly >
                                            <input id="kode_coa" type="hidden" name="kode_coa" value=""  readonly>
                                            <input id="debit" type="hidden" name="debit" value="" readonly>
                                            <input id="kredit" type="hidden" name="kredit" value="" readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalCoa"> <span class="fa fa-search"></span></button>
                                            </span>
                                        </div> -->
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" class="form-control" value="" required>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" class="form-control" value="{{ $no_urut }}" required>
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
                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                            <thead>
                                                <tr>
                                                    <th width="20">#</th>
                                                    <th width="20">Kode</th>
                                                    <th width="80">uraian</th>
                                                    <th width="150">Spesifikasi</th>
                                                    <th width="80">Jumlah</th>
                                                    <th width="80">Harga</th>
                                                    <th width="150">total Harga</th>
                                                    <th width="50">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                            
                                            </tbody>
                                            <tfoot>
                                                <th colspan="6" style="text-align: center;">Total : </th>
                                                <th style="text-align: right;">
                                                    <input type="text" class="form-control" name="total_biaya" id="total_biaya" style="text-align: right;" value="0" >
                                                </th>
                                                <th></th>
                                            </tfoot>
                                        </table>
                                    <!--</div>-->
                                    </div>
                                    <br>    
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalBiaya">Cari Data</button>
                                            <!-- <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('datatabel-v1')">Hapus Data</button> -->
                                        </div>  
                                                  
                                        <div class="col-md-8 mb-2">
                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm float-right">Simpan</button>
                                        </div>

                                        <input type="text" name="total_biaya_temp" id="total_biaya_temp" class="form-control" value="0" required readonly hidden> 
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

<div class="modal fade bd-example-modal-lg" id="myModalCoa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" hidden>
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa" id="search_coa" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_coa" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Account Id</th>
                                <th>Account Name</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Search Category . . .">
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

<div class="modal fade bd-example-modal-lg" id="myModalBiaya" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Biaya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" id="formFilterBiaya">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search_biaya" id="search_biaya" class="form-control" placeholder="Cari Data . . .">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="btnFilter" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </form>
                <br>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup_biaya" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>kode Pengajuan</th>
                            <th>Tgl Pengajuan</th>
                            <th>Keterangan</th>
                            <th>Spesifikasi</th>
                            <th hidden>Kode Vendor</th>
                            <th hidden>NoRek</th>
                            <th hidden>Bank</th>
                            <th hidden>Pemilik Rek</th>
                            <th hidden>Qty</th>
                            <th hidden>Harga</th>
                            <th hidden>Jml_harga</th>
                            <th hidden>Potongan</th>
                            <th>Total</th>
                            <th hidden>No Urut</th>
                            <th>Depo</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSimpanBiaya" class="btn btn-success btn-sm">Simpan Pilihan</button>
            </div>
        </div>
    </div>
</div>



@endsection

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

@endsection



