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
                            <form action="{{ route('ga_rekap_atk/rekap_excel.rekap_excel') }}" target="_blank" method="post" enctype="multipart/form-data">
                            @csrf
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
                                    <div class="col-md-12 mb-2" style="text-align: right;" hidden>
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
                                                        <th>Harga Satuan</th>
                                                        <th>Qty OPS</th>
                                                        <th>Qty GA</th>
                                                        <th>Qty PRC</th>
                                                        {{-- <th hidden>Qty Jadi temp</th> --}}
                                                        <th>Satuan</th>
                                                        <th>total OPS</th>
                                                        <th>total GA</th>
                                                        <th>total PRC</th>
                                                        <th hidden>ttl_price</th>
                                                        <th hidden>Persetujuan &nbsp; <input type="checkbox" id="select-all" class="float-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabledata">
                                                        
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="10">
                                                            <td colspan="1" align="right">
                                                                <input type="text"
                                                                    style="height: 30px; width: 125px; font-size: 15px; font-weight: bold; text-align: right;"
                                                                    class="form-control" name="f_subtotal_ops" id="f_subtotal_ops" value="0"
                                                                    readonly />
                                                            </td>
                                                            <td colspan="1" align="right">
                                                                <input type="text"
                                                                    style="height: 30px; width: 125px; font-size: 15px; font-weight: bold; text-align: right;"
                                                                    class="form-control" name="f_subtotal_ga" id="f_subtotal_ga" value="0"
                                                                    readonly />
                                                            </td>
                                                            <td colspan="1" align="right">
                                                                <input type="text" 
                                                                    style="height: 30px; width: 125px; font-size: 15px; font-weight: bold; text-align: right;"
                                                                    class="form-control" name="f_subtotal_prc" id="f_subtotal_prc" value="0"
                                                                    readonly />
                                                            </td>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        
                                        <button type="submit" class="btn btn-success btn-sm" name="btn_excel" id="btn_excel" value="excel">Import Excel</button>
                                        {{-- <button type="submit" class="btn btn-danger btn-sm" id="btn_pdf">Pdf</button>
                                        <button type="submit" class="btn btn-primary btn-sm float-right" id="btn_verifikasi" hidden>Proses</button> --}}
                                        
                                    </div>                               
                                </div>
                            </form>
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
                url: "{{ route('ga_rekap_atk/cari.cari') }}",
                data: {
                    tgl_cari: tgl_cari
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 0;

                    let totalQtyOps = 0;
                    let totalQtyGa = 0;
                    let totalQtyPc = 0;

                    if (response.data.length === 0) {
                        $("#tabledata").empty();

                        $("#tabledata").html(tabledata);
                        $('#f_subtotal_ops').val(0);
                        $('#f_subtotal_ga').val(0);
                        $('#f_subtotal_prc').val(0);
                        eventHandlerButtonCariTanggalAll();
                    } else {
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

                                tabledata += '<td class="price" align="right">';
                                    //membuat format rupiah//
                                    var reverse = data.price.toString().split('').reverse().join(''),
                                    ribuan  = reverse.match(/\d{1,3}/g);
                                    hasil_price = ribuan.join(',').split('').reverse().join('');
                                    //End membuat format rupiah//

                                    tabledata += hasil_price; 
                                    tabledata += '<input type="hidden" class="form-control" name="price[]' + x +'" id="price[]' + x +'" value="'+ data.price +'">';
                                tabledata += '</td>';

                                tabledata += '<td class="qty_ops" align="right">';
                                    tabledata += data.qty_ops;
                                    tabledata += '<input type="hidden" class="form-control" name="qty_ops[]' + x +'" id="qty_ops[]' + x +'" value="'+ data.qty_ops +'">';
                                tabledata += '</td>';

                                tabledata += '<td class="qty_ga" align="right">';
                                    tabledata += data.qty_ga;
                                    tabledata += '<input type="hidden" class="form-control" name="qty_ga[]' + x +'" id="qty_ga[]' + x +'" value="'+ data.qty_ga +'">';
                                tabledata += '</td>';
                                
                                if(data.qty_pc == null){
                                    tabledata += '<td class="qty_pc" align="right">';
                                    tabledata += 0;
                                    tabledata += '<input type="hidden" class="form-control" name="qty_pc[]' + x +'" id="qty_pc[]' + x +'" value="0">';
                                    tabledata += '</td>';
                                }else{
                                    tabledata += '<td class="qty_pc" align="right">';
                                    tabledata += data.qty_pc;
                                    tabledata += '<input type="hidden" class="form-control" name="qty_pc[]' + x +'" id="qty_pc[]' + x +'" value="'+ data.qty_pc +'">';
                                    tabledata += '</td>';
                                }
                                
                                tabledata += '<td class="satuan">';
                                    tabledata += data.satuan; 
                                tabledata += '</td>';

                                tabledata += '<td class="total_ops' + x +'" align="right">';
                                    var total_ops = data.qty_ops * data.price;
                                    //membuat format rupiah//
                                    var reverse_ops = total_ops.toString().split('').reverse().join(''),
                                    ribuan_ops  = reverse_ops.match(/\d{1,3}/g);
                                    hasil_total_ops = ribuan_ops.join(',').split('').reverse().join('');
                                    //End membuat format rupiah//
                                    tabledata += hasil_total_ops;
                                tabledata += '</td>';

                                tabledata += '<td class="total_ga' + x +'" align="right">';
                                    var total_ga = data.qty_ga * data.price;
                                    //membuat format rupiah//
                                    var reverse_ga = total_ga.toString().split('').reverse().join(''),
                                    ribuan_ga  = reverse_ga.match(/\d{1,3}/g);
                                    hasil_total_ga = ribuan_ga.join(',').split('').reverse().join('');
                                    //End membuat format rupiah//
                                    tabledata += hasil_total_ga;
                                tabledata += '</td>';

                                tabledata += '<td class="total_prc' + x +'" align="right">';
                                    var total_prc = data.qty_pc * data.price;
                                    //membuat format rupiah//
                                    var reverse_prc = total_prc.toString().split('').reverse().join(''),
                                    ribuan_prc  = reverse_prc.match(/\d{1,3}/g);
                                    hasil_total_prc = ribuan_prc.join(',').split('').reverse().join('');
                                    //End membuat format rupiah//
                                    tabledata += hasil_total_prc;
                                tabledata += '</td>';
                            tabledata += '</tr>';

                            totalQtyOps += data.qty_ops* data.price;
                            totalQtyGa += data.qty_ga* data.price;
                            totalQtyPc += data.qty_pc* data.price;

                            x++;
                        });
                        //membuat format rupiah//
                        var reverse_total_ops = totalQtyOps.toString().split('').reverse().join(''),
                                    total_ribuan_ops  = reverse_total_ops.match(/\d{1,3}/g);
                                    hasil_subtotal_ops = total_ribuan_ops.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        //membuat format rupiah//
                        var reverse_total_ga = totalQtyGa.toString().split('').reverse().join(''),
                                    total_ribuan_ga  = reverse_total_ga.match(/\d{1,3}/g);
                                    hasil_subtotal_ga = total_ribuan_ga.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        //membuat format rupiah//
                        var reverse_total_prc = totalQtyPc.toString().split('').reverse().join(''),
                                    total_ribuan_prc  = reverse_total_prc.match(/\d{1,3}/g);
                                    hasil_subtotal_prc = total_ribuan_prc.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        $("#tabledata").html(tabledata);
                        $('#f_subtotal_ops').val(hasil_subtotal_ops);
                        $('#f_subtotal_ga').val(hasil_subtotal_ga);
                        $('#f_subtotal_prc').val(hasil_subtotal_prc);
                        eventHandlerButtonCariTanggalAll();
                    }
                }
            });
        });

        function jumlah(x) {
            var temp_price = parseInt($("input[name='price[]" + x + "']").val());
            var temp_qty_jadi = parseInt($("input[name='qty_ga[]" + x + "']").val());
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
        }

        $("#btn_verifikasi").click(function() {
            // untuk Detail //
            let kode_produk = []
            let jml_qty_masuk = []
            let jml_qty_jadi = []
            let harga = []
            let total = []

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

                        window.location.href = "#";
                    }else{
                        Swal.fire("Gagal!", "Data transaksi penjualan gagal disimpan.", "error");
                    }
                }
            });
        });

        // $(document).on("click", "#button_buat_po", function(e) {
        //     $('#modalViewPenjualan').modal('show');
        // });

        $(document).ready(function() {
            $('#select-all').click(function(event) {   
                if(this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true; 

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
    </script>

@endsection