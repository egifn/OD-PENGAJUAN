@section('js')

<script type="text/javascript">
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
            }
        }
        return false;
    }

    function hapusbaris_2(tabel){
        var tabel = document.getElementById("datatabel-v2");
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
            } 
        }
        return false;
    }

    //====== MODAL DEPO ========================================================
    // $(document).ready(function(){
    //     var x = 1;
    //     var y = 1;
    //     var total_1 = 0;
    //     var i =  $(this).attr('data-urut');
        
    //     $('#lookup_depo').on('click', 'tbody tr', function(e){
    //          e.preventDefault();
    //             $('#kode_depo_'+i+'').val($(this).find('td').html());
    //             $('#nama_depo_'+i+'').val($(this).find('td').next().html());
    //             $('#myModalDepo').modal('hide'); 
    //     });

        
    //     //$('#nominal_1').maskMoney({thousands:',', decimal:'.', precision:0});                                            
    // });
    //============================================================================

    var d = 1;
    $(document).on('click', '.pilih_depo', function(e) {
        var tabel = document.getElementById("datatabel-v1");
        var row = tabel.insertRow(1);
        
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        var a = $(this).attr('data-kode_depo');
        var b = $(this).attr('data-nama_depo');

        cell1.innerHTML = '<input name="chk" type="checkbox" />';
        cell2.innerHTML = '<input type="text" class="form-control" name="kode_depo[]" id="kode_depo'+d+'" style="font-size: 13px;" value="'+a+'" hidden>'+a+''; 
        cell3.innerHTML = '<input type="text" class="form-control" name="nama_depo[]" id="nama_depo'+d+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
        cell4.innerHTML = '<input type="text" class="form-control" name="amount[]" id="amount'+d+'" style="text-align: right; height: 20px;" value="" required>';    

        $('#amount'+d+'').maskMoney({thousands:',', decimal:'.', precision:0});

        $('#myModalDepo').modal('hide');
        d++;
    })

    var c = 1;
    $(document).on('click', '.pilih_sku', function(e) {
        var tabel = document.getElementById("datatabel-v2");
        var row = tabel.insertRow(1);
        
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);

        var a = $(this).attr('data-kode_produk');
        var b = $(this).attr('data-nama_produk');

        cell1.innerHTML = '<input name="chk" type="checkbox" />';
        cell2.innerHTML = '<input type="text" class="form-control" name="customer[]" id="customer'+c+'" style="height: 20px;">'; 
        cell3.hidden = '<input type="text" class="form-control" name="kode_sku[]" id="kode_sku'+c+'" style="font-size: 13px;" value="'+a+'" hidden>'+a+''; 
        cell4.innerHTML = '<input type="text" class="form-control" name="sku[]" id="sku'+c+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
        cell5.innerHTML = '<input type="text" class="form-control" name="jumlah[]" id="jumlah'+c+'" style="text-align: right; height: 20px; width: 60px;" value="" required>'; 
        cell6.innerHTML = '<input type="text" class="form-control" name="harga[]" id="harga'+c+'" style="text-align: right; height: 20px; width: 80px;" value="" required>';  


        $('#jumlah'+c+'').maskMoney({thousands:',', decimal:'.', precision:0});
        $('#harga'+c+'').maskMoney({thousands:',', decimal:'.', precision:0});

        $('#myModalSku').modal('hide');
        c++;
    })

    $(document).ready(function(){
        var x = 1;
        var y = 1;
        var total_1 = 0;
        var i =  $(this).attr('data-urut');
        
        $('#lookup_sku').on('click', 'tbody tr', function(e){
             e.preventDefault();
                $('#kode_sku_'+i+'').val($(this).find('td').html());
                $('#nama_sku_'+i+'').val($(this).find('td').next().html());
                $('#myModalSku').modal('hide'); 
        });

        
        //$('#nominal_1').maskMoney({thousands:',', decimal:'.', precision:0});
                                                    
    });

    $(document).ready(function(){
        fetch_depo_data();
        function fetch_depo_data(query = '')
        {
            $.ajax({
                url:'{{ route("isi_surat/action_depo.actionDepo") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_depo tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_depo', function(){
            var query = $(this).val();
            fetch_depo_data(query);
        });
    });

    $(document).ready(function(){
        fetch_sku_data();
        function fetch_sku_data(query = '')
        {
            $.ajax({
                url:'{{ route("isi_surat/action_sku.actionSku") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_sku tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#cari_depo', function(){
            var query = $(this).val();
            fetch_sku_data(query);
        });
    });

    $(document).ready(function(){
        if ($("input[name='chk']:checked").val() == "chk" ) {
            $("#form-input-ext").show();
        }else{
            $("#form-input-ext").hide();
        }
        $(".detail").click(function(){ 
            if ($("input[name='chk']:checked").val() == "chk" ) { 
                $("#form-input-ext").slideDown("fast"); 
            }else{
                $("#form-input-ext").slideUp("fast"); 
                document.getElementById("menyetujui").value = "";
                document.getElementById("bagian").value = "";
            }
        });
    });

    $(document).ready(function(){
        if ($("input[name='chk_2']:checked").val() == "chk_2" ) {
            $("#form-input-ext2").show();
        }else{
            $("#form-input-ext2").hide();
        }
        $(".detail").click(function(){ 
            if ($("input[name='chk_2']:checked").val() == "chk_2" ) { 
                $("#form-input-ext2").slideDown("fast"); 
            }else{
                $("#form-input-ext2").slideUp("fast"); 
                document.getElementById("menyetujui_2").value = "";
                document.getElementById("bagian_2").value = "";

            }
        });
    });

    function amount(){
        var tabel = document.getElementById("datatabel-v1");
        for(var t = 1; t < tabel.rows.length; t++){
            $('#amount'+t+'').maskMoney({thousands:',', decimal:'.', precision:0});  
        }
    }

    function jumlah(){
        var tabel = document.getElementById("datatabel-v2");
        for(var t = 1; t < tabel.rows.length; t++){
            $('#jumlah'+t+'').maskMoney({thousands:',', decimal:'.', precision:0});
        }
    }
    
    function harga(){
        var tabel = document.getElementById("datatabel-v2");
        for(var t = 1; t < tabel.rows.length; t++){
            $('#harga'+t+'').maskMoney({thousands:',', decimal:'.', precision:0});
        }
    }
    
    

</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $('#tgl').datepicker({
            dateFormat: 'dd/mm/yy',//check change
            changeMonth: true,
            changeYear: true
        });      
    });
</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Edit Surat</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Surat</li>
        <li class="breadcrumb-item">Buat Surat</li>
        <li class="breadcrumb-item active">Edit Surat</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('isi_surat/edit.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Edit Surat [Kode Surat: {{ $data_isi->kode_surat }}]</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $data_isi->no_urut }}" required hidden>    
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        <input type="text" name="kode_surat" id="kode_surat" class="form-control" value="{{ $data_isi->kode_surat }}" required hidden>    
                                    </div>
                                        
                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <select name="kode_perusahaan" id="kode_perusahaan" class="form-control" required>
                                            <option value="{{ $data_isi->kode_perusahaan }}">{{ $data_isi->nama_perusahaan }}</option>
                                            @foreach ($perusahaan as $row)
                                                <option value="{{ $row->kode_perusahaan }}" {{ old('kode_perusahaan') == $row->kode_perusahaan ? 'selected':'' }}>{{ $row->nama_perusahaan }}</option>
                                            @endforeach    
                                        </select>
                                    </div>
                                    

                                    <div class="col-md-2 mb-2">
                                        Tanggal
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d/m/Y', strtotime($data_isi->tanggal)) }}" style="text-align: center" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Prihal
                                        <input type="text" name="prihal" id="prihal" class="form-control" value="{{ $data_isi->prihal }}" required>
                                    </div>
                                        
                                </div>
                                   
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Id Promo
                                        <input type="text" name="id_promo" id="id_promo" class="form-control" value="{{ $data_isi->id_promo }}" >
                                    </div>
                                </div>
                                @if($data_isi->jenis == 'Rupiah')
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap;margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th align="center">#</th>
                                                            <th>Kode</th>
                                                            <th>Depo</th>
                                                            <th>Nilai Rupiah</th>    
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no=1; ?>
                                                        @forelse($data_isi_detail as $val)
                                                        <tr>
                                                            <td><input name="chk" type="checkbox" /></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="kode_depo[]" id="kode_depo{{ $no }}" style="font-size: 13px;" value="{{ $val->kode_depo }}" hidden>
                                                                {{ $val->kode_depo }}
                                                            </td>
                                                            <td width="50%">
                                                                <input type="text" class="form-control" name="nama_depo[]" id="nama_depo{{ $no }}" style="font-size: 13px;" value="{{ $val->nama_depo }}" hidden>
                                                                {{ $val->nama_depo }}
                                                            </td>
                                                            <td>
                                                                <input type="text" style="text-align: right; height: 20px;" class="form-control" name="amount[]" id="amount{{ $no }}" value="{{ number_format($val->amount) }}" onchange="amount(<?php echo $no;?>);" required>
                                                            </td>    
                                                        </tr>
                                                        <?php $no++ ?>
                                                        @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">Tidak ada data yang ditemukan</td>
                                                        </tr>

                                                        @endforelse
                                                    </tbody>
                                                    <tfoot>
                                                        <td colspan="2">
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris('datatabel-v1')">Hapus Depo</button>
                                                        </td>
                                                        <td align="right" colspan="2">
                                                            <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalDepo">Cari Depo</button>
                                                        </td>
                                                    </tfoot>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                    
                                @else

                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            
                                            <div class="table-responsive">
                                                <table id="datatabel-v2" class="table table-bordered table-sm" style="white-space: nowrap;margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th align="center">#</th>
                                                            <th>Nama Customer</th>
                                                            <th hidden>kode SKU/Produk</th>
                                                            <th>SKU/Produk</th>
                                                            <th>Jml Box</th>
                                                            <th>Harga</th>    
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no=1; ?>
                                                        @forelse($data_isi_detail_box as $val)
                                                        <tr>
                                                            <td><input name="chk" type="checkbox" /></td>
                                                            <td>
                                                                <input type="text" class="form-control" name="customer[]" id="customer{{ $no }}" style="height: 20px;" value="{{ $val->kode_depo }}">
                                                            </td>
                                                            <td hidden>
                                                                <input type="text" class="form-control" name="kode_sku[]" id="kode_sku{{ $no }}" style="font-size: 13px;" value="{{ $val->kode_produk }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="sku[]" id="sku{{ $no }}" style="font-size: 13px;" value="{{ $val->nama_produk }}" hidden>
                                                                {{ $val->nama_produk }}
                                                            </td>
                                                            <td>
                                                                <input type="text" style="text-align: right; height: 20px; width: 60px;" class="form-control" name="jumlah[]" id="jumlah{{ $no }}" value="{{ number_format($val->amount) }}" onchange="jumlah(<?php echo $no;?>);" required>
                                                            </td>  
                                                            <td>
                                                                <input type="text" style="text-align: right; height: 20px; width: 80px;" class="form-control" name="harga[]" id="harga{{ $no }}" value="{{ number_format($val->amount_2) }}" onchange="harga(<?php echo $no;?>);" required>
                                                            </td>    
                                                        </tr>
                                                        <?php $no++ ?>
                                                        @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">Tidak ada data yang ditemukan</td>
                                                        </tr>

                                                        @endforelse
                                                    </tbody>
                                                    <tfoot>
                                                        <td colspan="2">
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="return hapusbaris_2('datatabel-v2')">Hapus</button>
                                                        </td>
                                                        <td align="right" colspan="3">
                                                            <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalSku">Cari/Tambah</button>
                                                        </td>
                                                    </tfoot>
                                                </table>
                                            </div>


                                        </div>
                                    </div>

                                @endif
                                

                                <!-- <div id="form-input">
                                    <div class="field_wrapper">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                            
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                Depo
                                                <div class="input-group">
                                                    <input id="kode_depo_1" name="kode_depo[]" type="text" class="form-control" readonly>
                                                    <input id="nama_depo_1" name="nama_depo[]" type="text" class="form-control" readonly>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModalDepo"> <span class="fa fa-search"></span></button>
                                                    </span>

                                                </div>
                                            </div> 
                                            <div class="col-md-3 mb-2">
                                                Total/Amount
                                                <input type="text" style="text-align: right;" id="nominal_1" name="nominal[]" class="form-control" value="">
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <br>
                                                <a class="btn btn-warning" href="javascript:void(0);" id="add_button" title="Tambah Depo">+</a>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div id="form-terhitung" class="row">
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        Dokumen
                                        <input type="text" name="dokumen" id="dokumen" class="form-control" value="{{ $data_isi->dokumen }}" required>
                                    </div>
                                </div>

                                @if($data_isi->menyetujui_ext == '' && $data_isi->menyetujui_ext2 == '')
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="checkbox" name="chk" id="chk" value="chk" class="detail"> &nbsp;Tambah Menyetujui
                                        </div>
                                    </div>

                                    <div id="form-input-ext">
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Menyetujui
                                                <input type="text" name="menyetujui" id="menyetujui" class="form-control" >
                                            </div>
                                        </div>
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Bagian
                                                <input type="text" name="bagian" id="bagian" class="form-control" >
                                            </div>
                                        </div>
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="checkbox" name="chk_2" id="chk_2" value="chk_2" class="detail"> &nbsp;Tambah Menyetujui
                                            </div>
                                        </div>
                                    </div>

                                    <div id="form-input-ext2">
                                        <div id="form-input-ext2" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Menyetujui (2)
                                                <input type="text" name="menyetujui_2" id="menyetujui_2" class="form-control">
                                            </div>
                                        </div>
                                        <div id="form-input-ext2" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Bagian (2)
                                                <input type="text" name="bagian_2" id="bagian_2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                @elseif($data_isi->menyetujui_ext != '' && $data_isi->menyetujui_ext2 == '')
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="checkbox" name="chk" id="chk" value="chk" class="detail" checked="true"> &nbsp;Tambah Menyetujui
                                        </div>
                                    </div>

                                    <div id="form-input-ext">
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Menyetujui
                                                <input type="text" name="menyetujui" id="menyetujui" class="form-control" value="{{ $data_isi->menyetujui_ext }}">
                                            </div>
                                        </div>
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Bagian
                                                <input type="text" name="bagian" id="bagian" class="form-control" value="{{ $data_isi->sebagai_ext }}">
                                            </div>
                                        </div>
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="checkbox" name="chk_2" id="chk_2" value="chk_2" class="detail"> &nbsp;Tambah Menyetujui
                                            </div>
                                        </div>
                                    </div>

                                    <div id="form-input-ext2">
                                        <div id="form-input-ext2" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Menyetujui (2)
                                                <input type="text" name="menyetujui_2" id="menyetujui_2" class="form-control">
                                            </div>
                                        </div>
                                        <div id="form-input-ext2" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Bagian (2)
                                                <input type="text" name="bagian_2" id="bagian_2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                @elseif($data_isi->menyetujui_ext != '' && $data_isi->menyetujui_ext2 != '')
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                                
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="checkbox" name="chk" id="chk" value="chk" class="detail" checked="true"> &nbsp;Tambah Menyetujui
                                        </div>
                                    </div>

                                    <div id="form-input-ext">
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Menyetujui
                                                <input type="text" name="menyetujui" id="menyetujui" class="form-control" value="{{ $data_isi->menyetujui_ext }}">
                                            </div>
                                        </div>
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Bagian
                                                <input type="text" name="bagian" id="bagian" class="form-control" value="{{ $data_isi->sebagai_ext }}">
                                            </div>
                                        </div>
                                        <div id="form-input-ext" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="checkbox" name="chk_2" id="chk_2" value="chk_2" class="detail" checked="true"> &nbsp;Tambah Menyetujui
                                            </div>
                                        </div>
                                    </div>

                                    <div id="form-input-ext2">
                                        <div id="form-input-ext2" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Menyetujui (2)
                                                <input type="text" name="menyetujui_2" id="menyetujui_2" class="form-control" value="{{ $data_isi->menyetujui_ext2 }}">
                                            </div>
                                        </div>
                                        <div id="form-input-ext2" class="row">
                                            <div class="col-md-3 mb-2">
                                                    
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                Bagian (2)
                                                <input type="text" name="bagian_2" id="bagian_2" class="form-control" value="{{ $data_isi->sebagai_ext2 }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                    
                                <div class="row">
                                    <div class="col-md-3 mb-2">

                                    </div>
                                    <div class="col-md-3 mb-2">
                                            
                                    </div>
                                       
                                    <div class="col-md-2 mb-2">
                                           
                                    </div>
                                        
                                    <div class="col-md-3 mb-2">
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-sm float-right">Ubah Isi Surat</button>
                                    </div> 

                                    <div class="col-md-2 mb-2" hidden>
                                            
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id="myModalDepo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Master Depo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_depo" id="cari_depo" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_depo" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Depo</th>
                                <th>Nama Depo</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalSku" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SKU/Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right">
                        <input type="text" name="cari_sku" id="cari_Sku" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_sku" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode SKU</th>
                                <th>Nama SKU</th>
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

@section('js')


    
@endsection