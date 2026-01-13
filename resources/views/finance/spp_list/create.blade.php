@extends('layouts.admin')

@section('title')
    <title>Buat Penerimaan</title>
@endsection

@section('content')

<main class="main">
    <style>
        .modal-dialog.modal-fullscreen {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content {
            height: 100%;
            border-radius: 0;
        }

        .modal-header, .modal-body, .modal-footer {
            padding: 20px;
        }

        /* Agar isi modal memenuhi ruang yang tersedia */
        .modal-body {
            overflow-y: auto;
            max-height: calc(100vh - 120px); /* Sesuaikan untuk memberikan ruang untuk header dan footer */
        }
    </style>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item">pembayaran</li>
        <li class="breadcrumb-item active">Buat Penerimaan</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="#" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Penerimaan Pengajuan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Cara Bayar
                                        {{-- <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" required readonly> --}}
                                        <select name="cara_bayar" id="cara_bayar" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Warkat">Warkat</option>
                                            <option value="Warkat-transfer">Warkat-transfer</option>
                                            <option value="Tunai">Tunai</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Keterangan
                                        <input type="text" name="keterangan_head" id="keterangan_head" class="form-control" value="" required>
                                    </div>    
                                    
                                    <div class="col-md-2 mb-2">
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success" id="button_terima"><span></span>Terima</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Pilih</th>
                                                <th>No</th>
                                                <th>No SPP</th>
                                                <th>Tgl SPP</th>
                                                <th>Tgl Jatuh Tempo</th>
                                                <th>Keterangan SPP</th>
                                                <th>Perusahaan</th>
                                                <th>Jumlah</th>
                                                <th hidden>Kode Vendor/Supplier</th>
                                                <th>Vendor/Supplier</th>
                                                <th>No Pengajuan</th>
                                                <th>File dokumen</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabledata">
                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document"> <!-- Menggunakan modal-fullscreen -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">File Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                             
                        </div>
                    </div>

                    <table id="datatabel" class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pengajuan</th>
                                <th>Dokumen Pengajuan</th>
                                <th>Dokumen Lainnya 1</th>
                                <th>Dokumen Lainnya 2</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_detail" class="tbl_detail">

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
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
        fetchAllUnit();
        function fetchAllUnit() {
            $.ajax({
                type: "GET",
                url: "{{ route('list_spp/getDataSpp') }}",
                dataType: "json",
                success: function(response) {
                    let tabledata;
                    let no = 0;
                    response.data.forEach(list => {
                        let status_pengajuan = list.kode_approved_spp_1;
                        let kategori = list.kategori;

                        let total = list.jumlah;
                        
                        var reverse_total = total.toString().split('').reverse().join(''),
                        ribuan_total  = reverse_total.match(/\d{1,3}/g);
                        total_rupiah = ribuan_total.join(',').split('').reverse().join('');
                       

                        const formattedDate = moment(list.tgl_spp, 'YYYY-MM-DD').format('DD-MMM-YYYY');
                        const formattedDateJt = moment(list.jatuh_tempo, 'YYYY-MM-DD').format('DD-MMM-YYYY');

                        no = no + 1
                        tabledata += '<tr>';
                        
                        tabledata += '<td class="ceklist" id="ceklist' + no +'">';
                            tabledata += '<input name="chk[]' + no +'" id="chk[]' + no +'" type="checkbox" class="checkbox" onclick="chk_jumlah(' + no + ');" data-index="' + no + '" value="'+ list.no_urut +'"/>'  ;
                            tabledata += ''
                        tabledata += '</td>';
                        tabledata += '<td class="ceklist_temp" id="ceklist_temp' + no +'" hidden>';
                        
                        tabledata += '<td class="no">'; 
                            tabledata += no; 
                            tabledata += '<input type="hidden" class="form-control" name="no[]' + no +'" id="no[]' + no +'" value="'+ no +'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="no_urut" hidden>';
                            tabledata += list.no_urut;
                            tabledata += '<input type="hidden" class="form-control" name="no_urut[]' + no +'" id="no_urut[]' + no +'" value="'+list.no_urut+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="no_spp">';
                            //tabledata += '<b><a href="{{ route("list_spp/pdf_spp.pdf_spp", "' + list.no_urut + '") }}" target="_blank">' + list.no_spp + '</a></b>';//list.no_spp;
                            tabledata += '<b><a href="' + "{{ route('list_spp/pdf_spp.pdf_spp', ['no_urut' => '__no_urut__']) }}".replace('__no_urut__', list.no_urut) + '" target="_blank">' + list.no_spp + '</a></b>';
                            tabledata += '<input type="hidden" class="form-control" name="no_spp[]' + no +'" id="no_spp[]' + no +'" value="'+list.no_spp+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="tgl_spp">';
                            tabledata += formattedDate;
                            tabledata += '<input type="hidden" class="form-control" name="tgl_spp[]' + no +'" id="tgl_spp[]' + no +'" value="'+list.tgl_spp+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="tgl_jt">';
                            tabledata += formattedDateJt;
                            tabledata += '<input type="hidden" class="form-control" name="tgl_jt[]' + no +'" id="tgl_jt[]' + no +'" value="'+list.jatuh_tempo+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="keterangan">';
                            tabledata += list.keterangan;
                            tabledata += '<input type="hidden" class="form-control" name="keterangan[]' + no +'" id="keterangan[]' + no +'" value="'+list.keterangan+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="perusahaan_tujuan">';
                            tabledata += list.kode_perusahaan_tujuan;
                            tabledata += '<input type="hidden" class="form-control" name="perusahaan_tujuan[]' + no +'" id="perusahaan_tujuan[]' + no +'" value="'+list.kode_perusahaan_tujuan+'">';
                        tabledata +='</td>';
                        
                        tabledata += '<td align="right" class="ttl_rupiah">';
                            tabledata += total_rupiah;
                            tabledata += '<input type="hidden" class="form-control" name="ttl_rupiah[]' + no +'" id="ttl_rupiah[]' + no +'" value="'+list.jumlah+'">';
                        tabledata += '</td>'; //total
                        
                        tabledata += '<td class="kode_vendor" hidden>';
                            tabledata += list.kode_vendor;
                            tabledata += '<input type="hidden" class="form-control" name="kode_vendor[]' + no +'" id="kode_vendor[]' + no +'" value="'+list.kode_vendor+'">';
                        tabledata += '</td>';
                        
                        tabledata += '<td class="vendor">';
                            tabledata += list.for;
                            tabledata += '<input type="hidden" class="form-control" name="vendor[]' + no +'" id="vendor[]' + no +'" value="'+list.for+'">';
                        tabledata += '</td>';
                        tabledata += '<td class="no_pengajuan">';
                        if (kategori === '43') {
                            tabledata += '<b><a href="' + "{{ route('list_spp/pdf_pengajuan.pdf_pengajuan', ['no_urut_pengajuan' => '__no_urut_pengajuan__']) }}".replace('__no_urut_pengajuan__', list.no_urut_pengajuan) + '" target="_blank">' + list.no_kontrabon + '</a></b>';
                            tabledata += '<input type="hidden" class="form-control" name="no_pengajuan[]' + no +'" id="no_pengajuan[]' + no +'" value="'+ list.no_kontrabon +'">';
                        } else if (kategori === '118') {
                            tabledata += '<b><a href="' + "{{ route('list_spp/pdf_pengajuan.pdf_pengajuan', ['no_urut_pengajuan' => '__no_urut_pengajuan__']) }}".replace('__no_urut_pengajuan__', list.no_urut_pengajuan) + '" target="_blank">' + list.no_kontrabon + '</a></b>';
                            tabledata += '<input type="hidden" class="form-control" name="no_pengajuan[]' + no +'" id="no_pengajuan[]' + no +'" value="'+ list.no_kontrabon +'">';
                        } else {
                            tabledata += '<b><a href="' + "{{ route('list_spp/pdf_pengajuan_biaya.pdf_pengajuan_biaya', ['no_urut_pengajuan' => '__no_urut_pengajuan__']) }}".replace('__no_urut_pengajuan__', list.no_urut_pengajuan) + '" target="_blank">' + list.no_kontrabon + '</a></b>';
                            tabledata += '<input type="hidden" class="form-control" name="no_pengajuan[]' + no +'" id="no_pengajuan[]' + no +'" value="'+ list.no_kontrabon +'">';
                        }
                        tabledata += '</td>';
                        if (status_pengajuan === 'MANUAL') {
                            tabledata += '<td align="center"><button type="button" data-id="'+list.no_urut+'" id="button_view_manual" class="btn btn-primary btn-sm">View</button></td>';
                        } else {
                            tabledata += '<td align="center"><button type="button" data-id="'+list.no_urut_pengajuan+'" id="button_view" class="btn btn-primary btn-sm">View</button></td>';
                        }
                        tabledata += '</tr>';
                    });
                    $("#tabledata").html(tabledata);
                }
            });
        }

        $(document).on("click", "#button_view_manual", function(e) {
        e.preventDefault();
            let no_urut = $(this).data('id');
            let no = 0;

            $.ajax({
                type: "GET",
                url: "{{ route('list_spp/getDataLampiranManual') }}",
                data: {
                    no_urut: no_urut
                },
                dataType: "json",
                success: function(response) {
                    let tbl_detail;
                    let previousKodePengajuan;
                    let previousFilename;
                    let previousFilenameSsd;
                    let previousFilenameLainnya;
                    response.data.forEach(detail => {
                        var imageUrl_1 = '{{ url('images/') }}' +'/'+ detail.filename;
                        //var imageUrl_2 = '{{ url('images/') }}' +'/'+ detail.filename_pengajuan_claim_ssd;
                        //var imageUrl_3 = '{{ url('images/') }}' +'/'+ detail.filename_upload;

                        no = no + 1
                        tbl_detail += `<tr>`;
                        tbl_detail += `<td>` +no+ `</td>`;
                        if (detail.no_kontrabon !== previousKodePengajuan) {
                            tbl_detail += `<td>${detail.no_kontrabon}</td>`; 
                            previousKodePengajuan = detail.no_kontrabon; 
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                        if (detail.filename !== previousFilename) {
                            // tbl_detail += `<td>${detail.filename}</td>`;
                            tbl_detail += `<td><a href="${imageUrl_1}">${detail.filename}</a></td>`;
                            previousFilename = detail.filename; 
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                        if (detail.filename !== previousFilename) {
                            tbl_detail += `<td></td>`; 
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                        if (detail.filename !== previousFilename) {
                            tbl_detail += `<td></td>`;
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                    });

                    $("#tbl_detail").html(tbl_detail);
                }
            });
            $('#modalView').modal('show');
        });

        $(document).on("click", "#button_view", function(e) {
            e.preventDefault();
            let no_urut_pengajuan = $(this).data('id');
            let no = 0;
            
            $.ajax({
                type: "GET",
                url: "{{ route('list_spp/getDataLampiran') }}",
                data: {
                    no_urut_pengajuan: no_urut_pengajuan
                },
                dataType: "json",
                success: function(response) {
                    let tbl_detail;
                    let previousKodePengajuan;
                    let previousFilename;
                    let previousFilenameSsd;
                    let previousFilenameLainnya;
                    response.data.forEach(detail => {
                        var imageUrl_1 = '{{ url('images/') }}' +'/'+ detail.filename;
                        var imageUrl_2 = '{{ url('images/') }}' +'/'+ detail.filename_pengajuan_claim_ssd;
                        var imageUrl_3 = '{{ url('images/') }}' +'/'+ detail.filename_upload;

                        no = no + 1
                        tbl_detail += `<tr>`;
                        tbl_detail += `<td>` +no+ `</td>`;
                        if (detail.kode_pengajuan_b !== previousKodePengajuan) {
                            tbl_detail += `<td>${detail.kode_pengajuan_b}</td>`; 
                            previousKodePengajuan = detail.kode_pengajuan_b; 
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                        if (detail.filename !== previousFilename) {
                            // tbl_detail += `<td>${detail.filename}</td>`;
                            tbl_detail += `<td><a href="${imageUrl_1}">${detail.filename}</a></td>`;
                            previousFilename = detail.filename; 
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                        if (detail.filename_pengajuan_claim_ssd !== previousFilenameSsd) {
                            tbl_detail += `<td><a href="${imageUrl_2}">${detail.filename_pengajuan_claim_ssd}</a></td>`;
                            previousFilenameSsd = detail.filename_pengajuan_claim_ssd; 
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                        if (detail.filename_upload !== previousFilenameLainnya) {
                            tbl_detail += `<td><a href="${imageUrl_3}">${detail.filename_upload}</a></td>`;
                            previousFilenameLainnya = detail.filename_upload; 
                        } else {
                            tbl_detail += `<td></td>`;
                        }
                        tbl_detail += `</tr>`;
                    });

                    $("#tbl_detail").html(tbl_detail);
                }
            });
            $('#modalView').modal('show');
        });
        
        var no = 1;
        function chk_jumlah(no) {
            var table = document.getElementsByClassName("checkbox");
            //=====Cek status Check==========================================
            if(no==1){
                if ($("input[name='chk[]1']:checked").val()){
                    var ceklist = '1';
                }else{
                    var ceklist = '0';
                }
                
                $('#ceklist_temp1').text(ceklist);
            }else{
                if ($("input[name='chk[]" +no+ "']:checked").val()){
                    var ceklist = '1';
                    //alert($("input[name='chk[]" +x+ "']").val());
                }else{
                    var ceklist = '0';
                }
                $('#ceklist_temp' +no+ '').text(ceklist);
            }
            //=====Cek status Check==========================================
        }

        $("#button_terima").click(function() {
            let cara_bayar = $("#cara_bayar").val();
            let keterangan_head = $("#keterangan_head").val();

            let chk = []
            let no_spp = []
            let tgl_spp = []
            let tgl_jt = []
            let keterangan = []
            let perusahaan_tujuan = []
            let ttl_rupiah = []
            let kode_vendor = []

            $('.ceklist_temp').each(function() {
                chk.push($(this).text())
            })
            $('.no_spp').each(function() {
                no_spp.push($(this).text())
            })
            $('.tgl_spp').each(function() {
                tgl_spp.push($(this).text())
            })
            $('.tgl_jt').each(function() {
                tgl_jt.push($(this).text())
            })
            $('.keterangan').each(function() {
                keterangan.push($(this).text())
            })
            $('.perusahaan_tujuan').each(function() {
                perusahaan_tujuan.push($(this).text())
            })
            $('.ttl_rupiah').each(function() {
                ttl_rupiah.push($(this).text())
            })
            $('.kode_vendor').each(function() {
                kode_vendor.push($(this).text())
            })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('list_spp/store') }}",
                data: {
                    cara_bayar: cara_bayar,
                    keterangan_head: keterangan_head,

                    chk: chk,
                    no_spp: no_spp,
                    tgl_spp: tgl_spp,
                    tgl_jt: tgl_jt,
                    keterangan: keterangan,
                    perusahaan_tujuan: perusahaan_tujuan,
                    ttl_rupiah: ttl_rupiah,
                    kode_vendor: kode_vendor,
                },
                success: function(response) {
                    if(response.res === true) {
                        window.location.href = "{{ route('list_spp.index') }}";
                    }else{
                        alert('Gagal mengosongkan tabel.');
                    }
                }
            });
            window.location.href = "{{ route('list_spp.index')}}";
        });
    </script>
@endsection