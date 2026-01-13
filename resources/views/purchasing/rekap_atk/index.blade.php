@extends('layouts.admin')

@section('title')
    <title>Daftar Rekap ATK</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Rekap ATK</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn" id="page_form">
            <div class="row">
                
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                   Rekap ATK
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
    
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
    
                                
                                <div class="input-group mb-3 col-md-4 float-right">  
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{ request()->tanggal }}">&nbsp
                                    <button type="button" class="btn btn-secondary" name="button_cari_tanggal" id="button_cari_tanggal" value="tgl">C a r i</button>
                                    <button type="button" class="btn btn-secondary" name="button_cari_tanggal_all" id="button_cari_tanggal_all" value="tgl" hidden>Cari All</button>
                                </div>    
                                <br>
                                <br>
                                <br>
                                <div class="col-md-12 mb-2" style="text-align: right;">
                                    <h3 class="f_budget" id="f_budget">Total: Rp. 0</h3>
                                </div>

                                <div class="table-responsive">
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <div style="width:100%;">
                                        <table id="datatabel_rekap" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Merk</th>
                                                    <th>Keterangan</th>
                                                    <th>Qty Masuk</th>
                                                    <th>Qty Jadi</th>
                                                    {{-- <th hidden>Qty Jadi temp</th> --}}
                                                    <th>Satuan</th>
                                                    <th>Harga</th>
                                                    <th>total</th>
                                                    <th hidden>ttl_price</th>
                                                    <th>Persetujuan &nbsp; <input type="checkbox" id="select-all" class="float-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata" class="tabledata">
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                        
                                    <button type="button" class="btn btn-primary btn-sm float-right" id="btn_verifikasi">Proses</button>
                                        
                                </div>
                               
                                
                                {{-- ======================================================================================================= --}}
                                <div class="table-responsive" hidden>
                                    <!-- <table class="table table-hover table-bordered"> -->
                                    <div style="width:100%;">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Pengajuan</th>
                                                    <th>Tgl Pengajuan</th>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Merk</th>
                                                    <th>Keterangan</th>
                                                    <th>Qty Masuk</th>
                                                    <th>Qty Jadi</th>
                                                    <th>Satuan</th>
                                                    <th>Harga</th>
                                                    <th>Total</th>
                                                    <th>Pilih &nbsp; <input type="checkbox" id="select-all" class="float-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabledata_all" class="tabledata_all">
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>
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

    <script type="text/javascript">
        var x = 1;
        $("#button_cari_tanggal").click(function(){
            let tgl_cari = $("#tanggal").val();
            $.ajax({
                type: "GET",
                url: "{{ route('rekap_atk/cari.cari') }}",
                data: {
                    tgl_cari: tgl_cari
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 0;
                    response.data.forEach(data => {
                        no = no + 1
                        tabledata += '<tr>';
                            tabledata += '<td>';
                                tabledata += no; 
                            tabledata += '</td>';
                            tabledata += '<td class="kode_product">';
                                tabledata += data.kode_product; 
                            tabledata += '</td>';
                            tabledata += '<td class="nama_barang">';
                                tabledata += data.nama_barang; 
                            tabledata += '</td>';
                            tabledata += '<td class="merk">';
                                tabledata += data.merk; 
                            tabledata += '</td>';
                            tabledata += '<td class="ket">';
                                tabledata += data.ket; 
                            tabledata += '</td>';
                            
                            tabledata += '<td class="qty" align="right">'; 
                                tabledata += data.qty;
                                tabledata += '<input type="hidden" class="form-control" name="qty[]' + x +'" id="qty[]' + x +'" value="'+ data.qty +'">';
                            tabledata += '</td>';

                            tabledata += '<td class="qty_jadi">';
                                tabledata += '<input name="qty_jadi[]' + x +'" id="qty_jadi[]' + x +'" type="text" class="form-control" style="text-align:right; width: 75px; height: 30px;" onkeyup="jumlah(' + x + ');" value="'+ data.qty +'"/>'           
                            tabledata += '</td>';
                            tabledata += '<td class="qty_jadi_temp" id="qty_jadi_temp' + x +'" contenteditable="true" hidden>';
                                tabledata += data.qty;
                            tabledata += '</td>';
                            
                            tabledata += '<td class="satuan">';
                                tabledata += data.satuan; 
                            tabledata += '</td>';

                            tabledata += '<td class="price" align="right">';
                                //membuat format rupiah//
                                var reverse = data.price.toString().split('').reverse().join(''),
                                ribuan  = reverse.match(/\d{1,3}/g);
                                hasil_price = ribuan.join(',').split('').reverse().join('');
                                //End membuat format rupiah//

                                tabledata += hasil_price; 
                                tabledata += '<input type="hidden" class="form-control" name="price[]' + x +'" id="price[]' + x +'" value="'+ data.price +'">';
                            tabledata += '</td>';

                            tabledata += '<td class="price' + x +'" align="right">';
                                var total_rp = data.qty * data.price;
                                //membuat format rupiah//
                                var reverse = total_rp.toString().split('').reverse().join(''),
                                ribuan  = reverse.match(/\d{1,3}/g);
                                hasil_total_rp = ribuan.join(',').split('').reverse().join('');
                                //End membuat format rupiah//

                                tabledata +=  hasil_total_rp; 
                                // tabledata += '<input type="text" class="form-control" name="ttl_price[]' + x +'" id="ttl_price[]' + x +'" value="'+ total_rp +'">';
                            tabledata += '</td>';

                            tabledata += '<td class="ttl_price" hidden>';
                                tabledata += '<input name="ttl_price[]' + x +'" id="ttl_price[]' + x +'" type="text" class="form-control" style="text-align:right; width: 75px; height: 30px;" onkeyup="jumlah(' + x + ');" value="'+  data.qty * data.price +'"/>'
                                //tabledata += data.qty;            
                            tabledata += '</td>';
                            // tabledata += '<td class="ttl_price_temp" id="ttl_price_temp' + x +'" contenteditable="true" hidden>';
                            //     tabledata += data.qty * data.price;
                            // tabledata += '</td>';

                            tabledata += '<td class="ceklist" id="ceklist' + x +'" align = "center">';
                                tabledata += '<input name="chk[]' + x +'" id="chk[]' + x +'" type="checkbox" class="checkbox" onclick="chk_jumlah(' + x + ');" data-index="' + x + '" value="'+ data.kode_product +'"/> App'  ;
                                //tabledata += ''
                                //tabledata += '<input name="chk[]' + x +'" id="chk[]' + x +'" type="checkbox" class="checkbox" onclick="chk_jumlah(' + x + ');" value="'+ data.kode_product +'"/> denied'  ;
                            tabledata += '</td>';
                            tabledata += '<td class="ceklist_temp" id="ceklist_temp' + x +'" hidden>';
                        tabledata += '</tr>';
                        x++;
                    });
                    $("#tabledata").html(tabledata);
                    eventHandlerButtonCariTanggalAll();
                }
            });
        });

        $("#button_cari_tanggal_all").click(eventHandlerButtonCariTanggalAll);

        function eventHandlerButtonCariTanggalAll() {
            let tgl_cari = $("#tanggal").val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('rekap_atk/cari_all.cari_all') }}",
                    data: {
                        tgl_cari: tgl_cari
                    },
                    dataType: "json",
                    success: function(response) {
                        let tabledata_all;
                        let no = 0;
                        response.data.forEach(data => {
                            no = no + 1
                            tabledata_all += '<tr>';
                                tabledata_all += '<td>';
                                    tabledata_all += no; 
                                tabledata_all += '</td>';
                                tabledata_all += '<td class="kode_pengajuan_all">';
                                    tabledata_all += data.kode_pengajuan; 
                                tabledata_all += '</td>';
                                tabledata_all += '<td class="tgl_pengajuan_all">';
                                    tabledata_all += data.tgl_pengajuan; 
                                tabledata_all += '</td>';
                                tabledata_all += '<td class="kode_product_all">';
                                    tabledata_all += data.kode_product; 
                                tabledata_all += '</td>';
                                tabledata_all += '<td class="nama_barang_all">';
                                    tabledata_all += data.nama_barang; 
                                tabledata_all += '</td>';
                                tabledata_all += '<td class="merk_all">';
                                    tabledata_all += data.merk; 
                                tabledata_all += '</td>';
                                tabledata_all += '<td class="ket_all">';
                                    tabledata_all += data.ket; 
                                tabledata_all += '</td>';
                                
                                tabledata_all += '<td class="qty_all" align="right">'; 
                                    tabledata_all += data.qty;
                                    tabledata_all += '<input type="hidden" class="form-control" name="qty[]' + x +'" id="qty[]' + x +'" value="'+ data.qty +'">';
                                tabledata_all += '</td>';

                                tabledata_all += '<td class="qty_jadi_all">';
                                    tabledata_all += '<input name="qty_jadi[]' + x +'" id="qty_jadi[]' + x +'" type="text" class="form-control" style="text-align:right; width: 75px; height: 30px;" onkeyup="jumlah(' + x + ');" value="'+ data.qty +'"/>'           
                                tabledata_all += '</td>';
                                tabledata_all += '<td class="qty_jadi_temp_all" id="qty_jadi_temp' + x +'" contenteditable="true" hidden>';
                                    tabledata_all += data.qty;
                                tabledata_all += '</td>';
                                
                                tabledata_all += '<td class="satuan_all">';
                                    tabledata_all += data.satuan; 
                                tabledata_all += '</td>';

                                tabledata_all += '<td class="price_all" align="right">';
                                    //membuat format rupiah//
                                    var reverse = data.price.toString().split('').reverse().join(''),
                                    ribuan  = reverse.match(/\d{1,3}/g);
                                    hasil_price = ribuan.join(',').split('').reverse().join('');
                                    //End membuat format rupiah//

                                    tabledata_all += hasil_price; 
                                    tabledata_all += '<input type="hidden" class="form-control" name="price[]' + x +'" id="price[]' + x +'" value="'+ data.price +'">';
                                tabledata_all += '</td>';

                                tabledata_all += '<td class="price' + x +'" align="right">';
                                    var total_rp = data.qty * data.price;
                                    //membuat format rupiah//
                                    var reverse = total_rp.toString().split('').reverse().join(''),
                                    ribuan  = reverse.match(/\d{1,3}/g);
                                    hasil_total_rp = ribuan.join(',').split('').reverse().join('');
                                    //End membuat format rupiah//

                                    tabledata_all +=  hasil_total_rp; 
                                    // tabledata_all += '<input type="text" class="form-control" name="ttl_price[]' + x +'" id="ttl_price[]' + x +'" value="'+ total_rp +'">';
                                tabledata_all += '</td>';

                                tabledata_all += '<td class="ttl_price" hidden>';
                                    tabledata_all += '<input name="ttl_price[]' + x +'" id="ttl_price[]' + x +'" type="text" class="form-control" style="text-align:right; width: 75px; height: 30px;" onkeyup="jumlah(' + x + ');" value="'+  data.qty * data.price +'"/>'
                                    //tabledata_all += data.qty;            
                                tabledata_all += '</td>';
                                // tabledata_all += '<td class="ttl_price_temp" id="ttl_price_temp' + x +'" contenteditable="true" hidden>';
                                //     tabledata_all += data.qty * data.price;
                                // tabledata_all += '</td>';


                                //tabledata_all += '<td align = "center">';
                                //    tabledata_all += '<input name="chk[]' + x +'" id="chk[]' + x +'" type="checkbox" class="checkbox" onclick="chk_jumlah(' + x + ');" data-index="' + x + '" value="'+ data.kode_product +'"/>';
                                //tabledata_all += '</td>';
                            tabledata_all += '</tr>';
                            x++;
                        });
                        $("#tabledata_all").html(tabledata_all);
                        
                    }
                });
        }

        function jumlah(x) {
            var temp_price = parseInt($("input[name='price[]" + x + "']").val());
            var temp_qty_jadi = parseInt($("input[name='qty_jadi[]" + x + "']").val());
            var temp_total = temp_price*temp_qty_jadi;
            //membuat format rupiah//
            var reverse = temp_total.toString().split('').reverse().join(''),
                ribuan  = reverse.match(/\d{1,3}/g);
                hasil_total_price = ribuan.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            $('.price' + x + '').text(hasil_total_price);
            $('#qty_jadi_temp' + x + '').text(temp_qty_jadi);
            $("input[name='ttl_price[]" +x+ "']").val(temp_total);
            $('#ttl_price_temp' + x + '').text(temp_total);
        } 

        var x = 1;
        function chk_jumlah(x) {
            var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
            for(var t = 0; t < table.length; t++)
            {
                if (table[t].checked) {
                    var row = table[t].parentNode.parentNode;
                    var price = row.cells[11].children[0].value;
                    sumHsl = sumHsl + parseInt(price);
                }
            }
            //membuat format rupiah//
            var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
            //End membuat format rupiah//
            document.getElementById('f_budget').innerHTML = 'Total: Rp. ' + hasil_total;
            //=====Cek status Check==========================================
            if(x==1){
                if ($("input[name='chk[]1']:checked").val()){
                    var ceklist = '1';
                    
                    //if($("input[name='chk[]1']:checked").val()){
                        //alert('checked');
                    //}
                }else{
                    var ceklist = '0';

                    //if($("input[name='chk[]1']:unchecked").val()){
                        //alert('unchecked');
                    //}
                }
                
                $('#ceklist_temp1').text(ceklist);
                $('#keterangan_temp1').text(keterangan_detail);

               
            }else{
                if ($("input[name='chk[]" +x+ "']:checked").val()){
                    var ceklist = '1';
                    //alert($("input[name='chk[]" +x+ "']").val());
                }else{
                    var ceklist = '0';
                }
                
                $('#ceklist_temp' +x+ '').text(ceklist);
                $('#keterangan_temp' +x+ '').text(keterangan_detail);
            }
            //=====Cek status Check==========================================
            
        }

        $(document).ready(function() {
            $('#select-all').click(function(event) {   
                if(this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true; 

                        var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
                        for(var t = 0; t < table.length; t++)
                        {
							var i = 1+t;
                            if (table[t].checked) {
                                var row = table[t].parentNode.parentNode;
                                var price = row.cells[11].children[0].value;
                                sumHsl = sumHsl + parseInt(price);
								
								$('#ceklist_temp' +i+ '').text('1');
                            }
                        }
                        //membuat format rupiah//
                        var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                            ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                            hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
                        //End membuat format rupiah//
                        document.getElementById('f_budget').innerHTML = 'Total: Rp. ' + hasil_total;                     
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;   
                        
                        var table = document.getElementsByClassName("checkbox"), sumHsl = 0;
                        for(var t = 0; t < table.length; t++)
                        {
                            if (table[t].checked) {
                                var row = table[t].parentNode.parentNode;
                                var price = row.cells[11].children[0].value;
                                sumHsl = sumHsl + parseInt(price);
								
								$('#ceklist_temp' +t+ '').text('0');
                            }
                        }
                        //membuat format rupiah//
                        var reverse_hasil = sumHsl.toString().split('').reverse().join(''),
                            ribuan_hasil  = reverse_hasil.match(/\d{1,3}/g);
                            hasil_total = ribuan_hasil.join(',').split('').reverse().join('');
                        //End membuat format rupiah//
                        document.getElementById('f_budget').innerHTML = 'Total: Rp. ' + hasil_total;  
                    });
                }
            });
        });

        $("#btn_verifikasi").click(function() {
            // untuk Detail //
            let kode_produk = []
            let jml_qty_masuk = []
            let jml_qty_jadi = []
            let harga = []
            let total = []
            let chk = []

            $('.kode_product').each(function() {
                kode_produk.push($(this).text())
            })
            $('.qty').each(function() {
                jml_qty_masuk.push($(this).text())
            })
            $('.qty_jadi_temp').each(function() {
                jml_qty_jadi.push($(this).text())
            })
            $('.price').each(function() {
                harga.push($(this).text())
            })
            $('.ceklist_temp').each(function() {
                chk.push($(this).text())
            })



            let kode_pengajuan_all = []
            let tgl_pengajuan_all =[]
            let kode_product_all =[]

            $('.kode_pengajuan_all').each(function() {
                kode_pengajuan_all.push($(this).text())
            })
            $('.tgl_pengajuan_all').each(function() {
                tgl_pengajuan_all.push($(this).text())
            })
            $('.kode_product_all').each(function() {
                kode_product_all.push($(this).text())
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('rekap_atk/store') }}",
                data: {

                    kode_produk: kode_produk,
                    jml_qty_masuk: jml_qty_masuk,
                    jml_qty_jadi: jml_qty_jadi,
                    harga: harga,
                    chk: chk,

                    kode_pengajuan_all: kode_pengajuan_all,
                    tgl_pengajuan_all: tgl_pengajuan_all,
                    kode_product_all: kode_product_all,
                },
                success: function(response) {
                    if(response.res === true) {
                        // $("#kode_transaksi").val('');
                        // $("#tgl_transaksi").val('');
                        // $("#jenis").val('');

                        // $('.tabledata').remove('');
                        // $('.cari_produk').val('');
                        // $('#f_subtotal').val(0);
                        // $('#f_total').val(0);
                        // $('#f_jml_bayar').val(0);
                        // $(".f_kembali").text(0);
                        window.location.href = "{{ route('rekap_atk.index') }}";
                    }else{
                        // Swal.fire("Gagal!", "Data transaksi penjualan gagal disimpan.", "error");
                        alert('Gagal mengosongkan tabel.');
                    }
                }
            });

            $('.tabledata').remove('');
            $('.tabledata_all').remove('');
            window.location.href = "{{ route('rekap_atk.index')}}";
        });

        // $(document).on("click", "#button_buat_po", function(e) {
        //     $('#modalViewPenjualan').modal('show');
        // });

    </script>

@endsection