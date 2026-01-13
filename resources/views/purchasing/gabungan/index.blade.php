@extends('layouts.admin')

@section('title')
    <title>Daftar Pengajuan - Gabungan</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Purch & Payment</li>
        <li class="breadcrumb-item">Daftar Pengajuan</li>
        <li class="breadcrumb-item active">Gabungan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn" id="page_form">
            <div class="row">
                
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                   Gabungan
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
                                </div>    
                                
                                <div class="table-responsive">
                                        <!-- <table class="table table-hover table-bordered"> -->
                                        <div style="width:100%;">
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th>Merk</th>
                                                        <th>Keterangan</th>
                                                        <th>Qty</th>
                                                        <th>Satuan</th>
                                                        <th hidden>Harga</th>
                                                        <th>Pilih &nbsp; <input type="checkbox" id="select-all" class="float-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabledata">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="col-mb-15 float-right">
                                        <button type="submit" class="btn btn-success btn-sm" style="width: 100%;" id="btn_buat_po">Buat PO</button>
                                        {{-- <a href="{{ route('po_gabungan/create') }}" class="btn btn-success btn-sm" id="btn_buat_po">Buat PO</a> --}}
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
        fetchAllDataPembelian();
        function fetchAllDataPembelian() {
            $.ajax({
                type: "GET",
                url: "{{ route('po_gabungan/getDataCreatePo') }}",
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 0;
                    response.data.forEach(create_po => {
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
                            tabledata += '<td class="qty">';
                                tabledata += data.qty; 
                            tabledata += '</td>';
                            tabledata += '<td class="satuan">';
                                tabledata += data.satuan; 
                            tabledata += '</td>';
                            tabledata += '<td hidden class="price">';
                                tabledata += data.price; 
                            tabledata += '</td>';
                            tabledata += '<td align = "center">';
                                tabledata += '<input name="chk[]" id="chk[]" type="checkbox" class="checkbox" value="'+data.kode_product+'"/>'; 
                            tabledata += '</td>';
                        tabledata += '</tr>';
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }

        $("#button_cari_tanggal").click(function(){
            let tgl_cari = $("#tanggal").val();
            $.ajax({
                type: "GET",
                url: "{{ route('po_gabungan/cari.cari') }}",
                data: {
                    tgl_cari: tgl_cari
                },
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 0;
                    response.data.forEach(data => {
                        if(data.sisa_qty > 0){
                            no = no + 1
                            tabledata += '<tr>';
                                tabledata += '<td>';
                                    tabledata += no; 
                                tabledata += '</td>';
								
								tabledata += '<td class="kode_rekap" hidden>';
                                    tabledata += data.kode_rekap; 
                                tabledata += '</td>';
								//tabledata += '<td class="tgl_rekap" hidden>';
                                //    tabledata += data.tgl_rekap; 
                                //tabledata += '</td>';
								
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
                                tabledata += '<td class="sisa_qty">';
                                    tabledata += data.sisa_qty; 
                                tabledata += '</td>';
                                tabledata += '<td class="satuan">';
                                    tabledata += data.satuan; 
                                tabledata += '</td>';
                                tabledata += '<td hidden class="price">';
                                    tabledata += data.price; 
                                tabledata += '</td>';
                                tabledata += '<td align = "center">';
                                    //tabledata += '<input name="chk[]'+data.kode_product+'" id="chk[]'+data.kode_product+'" type="checkbox" class="checkbox" value="'+data.kode_product+'"/>';
									tabledata += '<input name="chk[]" id="chk[]' + data.kode_product + '" type="checkbox" class="checkbox" value="' + data.kode_product + '" data-kode-rekap="' + data.kode_rekap + '" data-tgl-rekap="' + data.tgl_rekap + '"/>';
								tabledata += '</td>';
                            tabledata += '</tr>';
                        }
                    });
                    $("#tabledata").html(tabledata);
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
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;                       
                    });
                }
            });
        });

        $("#btn_buat_po").click(function() {
            let selectedCheckboxes = $("input[type='checkbox']:checked");
            let selectedValues = [];
			let kodeRekapValues = [];
			//let tglRekapValues = [];
            selectedCheckboxes.each(function() {
                selectedValues.push($(this).val());
				kodeRekapValues.push($(this).data('kode-rekap'));
				//tglRekapValues.push($(this).data('tgl-rekap'));
            });

            //alert(selectedValues);
			//alert(kodeRekapValues);
			//alert(tglRekapValues);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ route('po_gabungan/create') }}",
                data: { 
                    kode_produk: selectedValues,
					kode_rekap: kodeRekapValues,
					//tgl_rekap: tglRekapValues
                },
                success: function(response) {
                    $("#page_form").html(response);
                }
            });
        });
    </script>

@endsection