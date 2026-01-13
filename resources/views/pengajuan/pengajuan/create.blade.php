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
    var y = 0
    var aa = 0;

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
        var cell9 = row.insertCell(8);
        // var cell9 = row.insertCell(8);
        var cell10 = row.insertCell(9);
        cell10.style.cssText= 'text-align:right;';
        var cell11 = row.insertCell(10);
        cell11.style.cssText= 'text-align:right;';
        //var cell11 = row.insertCell(10);

        var a = $(this).attr('data-kategori');
        var aa = $(this).attr('data-kode_kategori');
        var b = $(this).attr('data-kode_produk');
        var c = $(this).attr('data-nama_produk');
        var d = $(this).attr('data-merk');
        var e = $(this).attr('data-price');
        var e_rupiah = e.toString().split('').reverse().join(''),
                ribuan  = e_rupiah.match(/\d{1,3}/g);
                hasil_e_rupiah = ribuan.join(',').split('').reverse().join('');
        var f = $(this).attr('data-satuan');

        var id_div = $("#kode_divisi").val();
        var nm_div = $("#nama_divisi").val();
                
        cell1.innerHTML = '<input name="chk" type="checkbox" />';
        cell2.innerHTML = '<input type="text" class="form-control" name="type_id[]" id="type_id_'+x+'" style="font-size: 13px;" value="'+aa+'" hidden>'+a+''; 
        cell3.innerHTML = '<input type="text" class="form-control" name="prod_id[]" id="prod_id_'+x+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
        cell4.innerHTML = '<input type="text" class="form-control" name="prod_name[]" id="prod_name_'+x+'" style="font-size: 13px;" value="'+c+'" hidden>'+c+''; 
        cell5.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="merk[]" id="merk_'+x+'" style="font-size: 13px;" value="'+d+'" hidden>'+d+''; 
        cell6.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="qty[]' + x + '" id="qty[]' + x + '" onkeyup="jumlah(' + x + ');" style="font-size: 13px;" required>'
        cell7.innerHTML = '<input type="text" class="form-control" name="prod_satuan[]" id="prod_satuan_'+x+'" style="font-size: 13px;" value="'+f+'" hidden>'+f+''; 
        if($("#kode_depo").val() == '002'){
            if($("#kode_divisi").val() == '5'){
                cell8.innerHTML = '<div class="col-md-10"><select name="kode_divisi[]" id="kode_divisi_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" required ><option value="">Division</option>@foreach ($divisi_finance as $row)<option value="{{ $row->kode_divisi }}" {{ old('kode_divisi[]') == $row->kode_divisi ?'selected':'' }}>{{ $row->nama_divisi }}</option>@endforeach</select></div>';
            }else{
                cell8.innerHTML = '<div class="col-md-10"><select name="kode_divisi[]" id="kode_divisi_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" required ><option value="'+id_div+'">'+nm_div+'</option></select></div>';
            }
        }else{
            cell8.innerHTML = '<div class="col-md-10"><select name="kode_divisi[]" id="kode_divisi_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" required ><option value="">Division</option>@foreach ($divisi as $row)<option value="{{ $row->kode_divisi }}" {{ old('kode_divisi[]') == $row->kode_divisi ?'selected':'' }}>{{ $row->nama_divisi }}</option>@endforeach</select></div>';
        }
        
        cell9.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="desc[]" id="desc_'+x+'" style="font-size: 13px;" required>';
        // cell9.innerHTML = '<input type="file" class="uploads form-control" name="image[]" id="image_'+x+'" style="font-size: 6px;" >';
        cell10.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="harga_satuan[]' + x +'" id="harga_satuan[]' + x + '" style="font-size: 13px;" value="'+hasil_e_rupiah+'" readonly>'; 
        cell11.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="total_harga[]' + x +'" id="total_harga[]' + x + '" style="font-size: 13px;" value="0" readonly>';
        //cell11.innerHTML = '<input type="text" style="text-align:right; height: 100px;" class="form-control" name="total_budget[]' + x +'" id="total_budget[]' + x + '" style="font-size: 13px;" value="'+f+'" readonly>'+f+'';  
        $('#myModal').modal('hide');
        x++;

    });

    function jumlah(x) {
        //alert(aa);
        var harga = ($("input[name='harga_satuan[]" +x+ "']").val());
        //menghilangka format rupiah harga//
        var temp_harga = harga.replace(/[.](?=.*?\.)/g, '');
        var temp_harga_jadi = parseInt(temp_harga.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//
        var jml = parseInt($("input[name='qty[]" +x+ "']").val());

        var total = temp_harga_jadi*jml;
        //membuat format rupiah total//
        var total_rupiah = total.toString().split('').reverse().join(''),
                ribuan  = total_rupiah.match(/\d{1,3}/g);
                hasil_total_rupiah = ribuan.join(',').split('').reverse().join('');
        //End membuat format rupiah total//
        
        $("input[name='total_harga[]" +x+ "']").val(hasil_total_rupiah);

        //var f = $('#total_budget').val();
        var temp_budget = $('#total_budget').val();
        //menghilangka format rupiah harga//
        var budget_hilang_format = temp_budget.replace(/[.](?=.*?\.)/g, '');
        var budget_hasil = parseInt(budget_hilang_format.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah harga//
        
        if(document.getElementById('id_pengeluaran').value == '8'){
			const budget_sisa = document.querySelector('.f_budget').innerHTML;
            const temp_budget_sisa = budget_sisa.split(" ").pop();

            //menghilangka format rupiah harga//
            var temp_budget_sisa_con = temp_budget_sisa.replace(/[.](?=.*?\.)/g, '');
            var hasil_temp_budget_sisa_con = parseInt(temp_budget_sisa_con.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah harga//
			
            if(hasil_temp_budget_sisa_con < total){
                alert('Budget yang tersedia tidak cukup...');
                $("input[name='qty[]" +x+ "']").val(0);
                $("input[name='total_harga[]" +x+ "']").val(0);
				
				//=====================================================
                var harga = ($("input[name='harga_satuan[]" +x+ "']").val());
                //menghilangka format rupiah harga//
                var temp_harga = harga.replace(/[.](?=.*?\.)/g, '');
                var temp_harga_jadi = parseInt(temp_harga.replace(/[^0-9.]/g,''));
                //End menghilangka format rupiah harga//
                var jml = parseInt($("input[name='qty[]" +x+ "']").val());

                var total = temp_harga_jadi*jml;
                //membuat format rupiah total//
                var total_rupiah = total.toString().split('').reverse().join(''),
                        ribuan  = total_rupiah.match(/\d{1,3}/g);
                        hasil_total_rupiah = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                
                $("input[name='total_harga[]" +x+ "']").val(hasil_total_rupiah);

                var temp_budget = $('#total_budget').val();
                //menghilangka format rupiah harga//
                var budget_hilang_format = temp_budget.replace(/[.](?=.*?\.)/g, '');
                var budget_hasil = parseInt(budget_hilang_format.replace(/[^0-9.]/g,''));
                //End menghilangka format rupiah harga//

                ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                var table = document.getElementById("datatabel-v1"), sumHsl = 0;
                for(var t = 1; t < table.rows.length; t++)
                {
                    var sub_total = table.rows[t].cells[10].children[0].value;
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    budget_hasil = budget_hasil - parseInt(sub_total_hasil);
                }
                $('#subtotal_harga').val(sumHsl);

                //membuat format rupiah total//
                var sumHsl_temp = sumHsl.toString().split('').reverse().join(''),
                        ribuan  = sumHsl_temp.match(/\d{1,3}/g);
                        hasil_sumHsl_temp = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#subtotal_harga_temp').val(hasil_sumHsl_temp);
                ////END PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                
                //membuat format rupiah total//
                var sisa = budget_hasil.toString().split('').reverse().join(''),
                        ribuan  = sisa.match(/\d{1,3}/g);
                        hasil_sisa = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $(".f_budget").text('Budget: Rp. ' + hasil_sisa + '');
                $("#sisa_budget").val(budget_hasil);
                //=====================================================
            }else{
                ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                var table = document.getElementById("datatabel-v1"), sumHsl = 0;
                for(var t = 1; t < table.rows.length; t++)
                {
                    var sub_total = table.rows[t].cells[10].children[0].value;
                    //menghilangka format rupiah harga//
                    var sub_total_non_format = sub_total.replace(/[.](?=.*?\.)/g, '');
                    var sub_total_hasil = parseInt(sub_total_non_format.replace(/[^0-9.]/g,''));
                    //End menghilangka format rupiah harga//

                    sumHsl = sumHsl + parseInt(sub_total_hasil);
                    budget_hasil = budget_hasil - parseInt(sub_total_hasil);
                }
                $('#subtotal_harga').val(sumHsl);

                //membuat format rupiah total//
                var sumHsl_temp = sumHsl.toString().split('').reverse().join(''),
                        ribuan  = sumHsl_temp.match(/\d{1,3}/g);
                        hasil_sumHsl_temp = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $('#subtotal_harga_temp').val(hasil_sumHsl_temp);
                ////END PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
                
                //membuat format rupiah total//
                var sisa = budget_hasil.toString().split('').reverse().join(''),
                        ribuan  = sisa.match(/\d{1,3}/g);
                        hasil_sisa = ribuan.join(',').split('').reverse().join('');
                //End membuat format rupiah total//
                $(".f_budget").text('Budget: Rp. ' + hasil_sisa + '');
                $("#sisa_budget").val(budget_hasil);
                
            }

        } 
    }

    $(document).on('click', '.pilih_tgsm', function(e) {
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
                    
        var a = $(this).attr('data-nama_cat');
        var aa = $(this).attr('data-id_cat');
        var b = $(this).attr('data-kode_produk');
        var c = $(this).attr('data-nama_produk');
        var d = '-';  //$(this).attr('data-merk');
                
                
        cell1.innerHTML = '<input name="chk" type="checkbox" />';
        cell2.innerHTML = '<input type="text" class="form-control" name="type_id[]" id="type_id_'+x+'" style="font-size: 13px;" value="'+aa+'" hidden>'+a+''; 
        cell3.innerHTML = '<input type="text" class="form-control" name="prod_id[]" id="prod_id_'+x+'" style="font-size: 13px;" value="'+b+'" hidden>'+b+''; 
        cell4.innerHTML = '<input type="text" class="form-control" name="prod_name[]" id="prod_name_'+x+'" style="font-size: 13px;" value="'+c+'" hidden>'+c+''; 
        cell5.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="merk[]" id="merk_'+x+'" style="font-size: 13px;" value="'+d+'" hidden>'+d+''; 
        cell6.innerHTML = '<input type="text" style="text-align:right; height: 30px;" class="form-control" name="qty[]" id="qty_'+x+'" style="font-size: 13px;" required>';
        cell7.innerHTML = '<div class="col-md-10"><select name="kode_divisi[]" id="kode_divisi_'+x+'" class="form-control" style="font-size: 12px; height: 30px;" required ><option value="">Division</option>@foreach ($divisi as $row)<option value="{{ $row->kode_divisi }}" {{ old('kode_divisi[]') == $row->kode_divisi ?'selected':'' }}>{{ $row->nama_divisi }}</option>@endforeach</select></div>';
        cell8.innerHTML = '<input type="text" style="height: 30px;" class="form-control" name="desc[]" id="desc_'+x+'" style="font-size: 13px;" required>';
        // cell9.innerHTML = '<input type="file" class="uploads form-control" name="image[]" id="image_'+x+'" style="font-size: 6px;" >';

        $('#myModal_produk_tgsm').modal('hide');
        x++;
    });

    $(document).ready(function(){
        //alert(document.getElementById('id_pengeluaran').value);
        if(document.getElementById('id_pengeluaran').value == '26'){
            $('#area_keterangan').show();
            $('#caridatas_tgsm').show();
            $('#caridatas').hide();
        }else if(document.getElementById('id_pengeluaran').value != '26'){
            $('#area_keterangan').hide();
            $('#caridatas_tgsm').hide();
            $('#caridatas').show();
        }else if(document.getElementById('id_pengeluaran').value == ''){
            $('#area_keterangan').hide();
            $('#caridatas_tgsm').hide();
            $('#caridatas').show();
        }

        if(document.getElementById('id_pengeluaran').value == '8'){
            $('#f_budget').show();
            $('#subtotal_harga_temp').show();
        }else{
            $('#f_budget').hide();
            $('#subtotal_harga_temp').hide();
        }
    });

    $(document).on('click', '.pilih_category', function(e){
        document.getElementById('id_pengeluaran').value = $(this).attr('data-id')
        document.getElementById('nama_pengeluaran').value = $(this).attr('data-nama_pengeluaran')
        document.getElementById('sifat').value = $(this).attr('data-sifat')
        document.getElementById('jenis').value = $(this).attr('data-jenis')
        document.getElementById('pembayaran').value = $(this).attr('data-pembayaran')
        document.getElementById('kategori').value = $(this).attr('data-kategori')
        document.getElementById('coa_pengeluaran').value = $(this).attr('data-coa')
        
        // alert(document.getElementById('id_pengeluaran').value);
        if(document.getElementById('id_pengeluaran').value == '26'){
            $('#area_keterangan').show();
            $('#caridatas_tgsm').show();
            $('#caridatas').hide();
        }else if(document.getElementById('id_pengeluaran').value != '26'){
            $('#area_keterangan').hide();
            $('#caridatas_tgsm').hide();
            $('#caridatas').show();
        }

        if(document.getElementById('id_pengeluaran').value == '8'){
            $('#f_budget').show();
            $('#subtotal_harga_temp').show();
        }else{
            $('#f_budget').hide();
            $('#subtotal_harga_temp').hide();
        }
        
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
            }
        }
        return false;
    }

    $("#savedatas").click(function() {
        var modal_1 = $('#pesanModal');
        var pesanText_1 = $('#pesanText');
        if ($("#id_pengeluaran").val() == ""){
            //alert("Pilih Nama Pengeluaran. Nama Pengeluaran harus diisi");
            pesanText_1.text('Pilih Nama Pengeluaran. Nama Pengeluaran harus diisi...');
            modal_1.modal('show');
            $("#nama_pengeluaran").focus();
            return (false);
        }

        var modal_2 = $('#pesanModal');
        var pesanText_2 = $('#pesanText');
        var tabel = document.getElementById("datatabel-v1");
        var bacabaris = tabel.rows.length;
        if (bacabaris == 1){
            pesanText_2.text('List Produk masih kosong. Cari Produk yang akan diajukan...');
            modal_2.modal('show');
            $("#caridatas").focus();
            return (false);
        }

        var modal_3 = $('#pesanModal');
        var pesanText_3 = $('#pesanText'); 
        if ($("#id_pengeluaran").val() == 31){
            if ($("#filename_1").val() == ""){
                pesanText_3.text('Untuk pengajuan di luar ATK harus disertakan dengan Lampiran/Attachment pendukung. Lampiran/Attachment wajib diisi...');
                modal_3.modal('show');
                $("#filename_1").focus();
                return (false);    
            }    
        }

        if ($("#id_pengeluaran").val() == 19){
            if ($("#filename_1").val() == ""){
                pesanText_3.text('Untuk pengajuan di luar ATK harus disertakan dengan Lampiran/Attachment pendukung. Lampiran/Attachment wajib diisi...');
                modal_3.modal('show');
                $("#filename_1").focus();
                return (false);    
            }    
        }
    });

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

    $(document).ready(function(){
        fetch_product_data();
        function fetch_product_data(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan/action_product.actionProduct_tgsm") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_produk_tgsm tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search_tgsm', function(){
            var query = $(this).val();
            fetch_product_data(query);
        });
    });

</script>



@stop

<!DOCTYPE html>
<html lang="en">
@extends('layouts.admin')

@section('title')
    <title>Create Request</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan</li>
        <li class="breadcrumb-item">Pengajuan Barang</li>
        <li class="breadcrumb-item active">Buat Pengajuan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('pengajuan.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Pengajuan Barang</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{Auth::user()->name}}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control" value="{{Auth::user()->kode_perusahaan}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="kode_depo" id="kode_depo" class="form-control" value="{{Auth::user()->kode_depo}}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Divisi
                                        <input type="text" name="kode_divisi" id="kode_divisi" class="form-control" value="{{ $divisi_ho->kode_divisi }}" required readonly>
                                        <input type="text" name="nama_divisi" id="nama_divisi" class="form-control" value="{{ $divisi_ho->nama_divisi }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $no_urut }}" required>
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
                                            <input id="id_pengeluaran" type="hidden" name="id_pengeluaran" id="id_pengeluaran" value="" required >
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
                               
                                <div class="row" hidden>
                                    <div class="col-md-10 mb-2">
                                        Description
                                        <input type="text" name="ket" id="ket" class="form-control" value="Pengajuan Permintaan Barang" required>
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
                                    <input type="hidden" name="sisa_budget" id="sisa_budget" class="form-control" value="{{ $budget }}" required readonly>
                                </div>
                                
                            </div>    
                        </div>
                    </div>

                                <form id="savedatas">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col-md-12 mb-2" style="text-align: right;">
                                                    <input type="hidden" name="total_budget" id="total_budget" class="form-control" value="{{ ($budget) }}" required readonly>
                                                    <h3 class="f_budget" id="f_budget">Budget: Rp. {{ number_format($budget) }}</h3>
                                                </div>
                                                <div class="table-responsive">
                                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="20">#</th>
                                                                    <th width="80">Tipe</th>
                                                                    <th width="80">Id Produk</th>
                                                                    <th width="150">Nama Produk</th>
                                                                    <th width="150">Merk</th>
                                                                    <th width="100">Qty</th>
                                                                    <th width="100">Satuan</th>
                                                                    <th width="300">Divisi</th>
                                                                    <th>Keterangan/Desc</th>
                                                                    <th hidden>File/attach</th>
                                                                    <th>Harga Satuan</th>
                                                                    <th>Total Harga</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            
                                                            </tbody>
                                                        </table>
                                                    <!--</div>-->
                                                </div>
                                                <br>
                                                <div class="input-group mb-2 col-md-2 float-right">  
                                                    <input type="hidden" style="text-align: right;" name="subtotal_harga" id="subtotal_harga" class="form-control" value="0" required readonly>
                                                    <input type="text" style="text-align: right;" name="subtotal_harga_temp" id="subtotal_harga_temp" class="form-control" value="0" required readonly>
                                                </div> 
                                                <br>
                                                <span id="hasil"></span>
                                                    
                                                @if(Auth::user()->type == 'Admin')
                                                    <br hidden> 
                                                    <div class="row" id="area_keterangan" hidden>
                                                        <div class="col-md-12">
                                                            <strong>Keterangan</strong>
                                                            <textarea name="Keterangan_tgsm" id="Keterangan_tgsm" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                @elseif(Auth::user()->type == 'Manager')
                                                    <br> 
                                                    <div class="row" id="area_keterangan">
                                                        <div class="col-md-12">
                                                            <strong>Keterangan</strong>
                                                            <textarea name="Keterangan_tgsm" id="Keterangan_tgsm" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                @endif
 
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <strong>Lampiran/Attachment</strong> <i style="color: crimson">(*Diluar pengajuan ATK dan Materai wajib untuk melampirkan Dokumen)</i>
                                                        <input type="file" class="form-control" name="filename[]" id="filename_1" multiple>
                                                    </div>                                       
                                                </div>
                                                <br>    
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        
                                                        <button type="button" id="caridatas" name="caridatas" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Cari Produk</button>

                                                        <button type="button" id="caridatas_tgsm" name="caridatas_tgsm" name="choose" id="choose" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_produk_tgsm">Cari Produk</button>
                                                        
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
                            <th>Satuan</th>
                            <th>Harga</th>
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

<div class="modal fade bd-example-modal-lg" id="myModal_produk_tgsm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                        <input type="text" name="search_tgsm" id="search_tgsm" class="form-control" placeholder="Cari Produk . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup_produk_tgsm" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th hidden>Id</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
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

<div class="modal fade" id="pesanModal" tabindex="-1" role="dialog" aria-labelledby="pesanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pesanModalLabel">Pesan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="pesanText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
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




