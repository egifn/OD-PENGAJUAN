@section('js')


<script type="text/javascript">
    function goBack() {
        window.history.back();
    }

    var x = 1;
    function input_ket(x) {
        if(x==1){
            var keterangan_detail = $("input[name='ket[]1']").val();
                     
            if ($("input[name='chk[]1']:checked").val()){
                var ceklist = '1';
            }else{
                var ceklist = '0';
            }
            
            $('#ceklist_temp1').text(ceklist);
            $('#keterangan_temp1').text(keterangan_detail);
        }else{
            //x++;
            var keterangan_detail = $("input[name='ket[]" +x+ "']").val();
                     
            if ($("input[name='chk[]" +x+ "']:checked").val()){
                var ceklist = '1';
            }else{
                var ceklist = '0';
            }

            $('#ceklist_temp' +x+ '').text(ceklist);
            $('#keterangan_temp' +x+ '').text(keterangan_detail);
        }    
    }

    $("#button_form_approved").click(function() {
        
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        
        let deskripsi = []
        let ceklist = []
        let keterangan_detail = []

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_biaya_masuk/approved.approved') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('pengajuan_biaya_masuk.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_denied").click(function() {
		// if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        
        let deskripsi = []
        let ceklist = []
        let keterangan_detail = []

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_biaya_masuk/denied.denied') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('pengajuan_biaya_masuk.index')}}";
                }else{

                }
            }
        })
    });

    $("#button_form_pending").click(function() {
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        
        let deskripsi = []
        let ceklist = []
        let keterangan_detail = []

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.ceklist_temp').each(function() {
            ceklist.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            keterangan_detail.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_biaya_masuk/pending.pending') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('pengajuan_biaya_masuk.index')}}";
                }else{

                }
            }
        });
    });

    //------ tambahan baru --------------- //
    $(document).ready(function(){
        $("#button_form_approved").prop("disabled", true);
        // alert('test');
        // setiap kali ada perubahan checkbox
        $(".chk-approval").on("change", function () {
            
            if ($(".chk-approval:checked").length > 0) {
                // alert('test');
                // kalau ada yg diceklis, enable tombol
                $("#button_form_approved").prop("disabled", false);
            } else {
                // kalau tidak ada yg diceklis, disable lagi
                $("#button_form_approved").prop("disabled", true);
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
    const totalInput = document.getElementById("total_harga");

    function cleanNumber(str) {
        return parseInt(str.replace(/,/g, "")) || 0;
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Hitung ulang saat checkbox diklik
    document.querySelectorAll(".chk-approval").forEach(chk => {
            chk.addEventListener("change", function() {
                let currentTotal = cleanNumber(totalInput.value);
                let harga = parseInt(this.getAttribute("data-harga")) || 0;

                if (this.checked) {
                    currentTotal += harga;
                } else {
                    currentTotal -= harga;
                }

                totalInput.value = formatNumber(currentTotal);
            });
        });
    });
    // Hitung ulang saat checkbox diklik

</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>View Pengajuan Masuk</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pengajuan Masuk</li>
        <li class="breadcrumb-item active">View Pengajuan Masuk</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
           
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Pengajuan Masuk</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan_b" class="form-control" value="{{ $approval_cost_head->kode_pengajuan_b }}" required readonly>   
                                    </div>
                        
                                    <div class="col-md-2 mb-2">
                                        Yang Mengajukan
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $approval_cost_head->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Perusahaan
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $approval_cost_head->nama_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="depo" class="form-control" value="{{ $approval_cost_head->nama_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Divisi
                                        <input type="text" name="divisi" class="form-control" value="{{ $approval_cost_head->nama_divisi }}" required readonly>
                                    </div>

                                </div>
                               
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Request Date
                                        <input type="text" name="tgl" class="form-control" value="{{ date('d-M-Y', strtotime($approval_cost_head->tgl_pengajuan_b)) }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="kategori" id="kategori" class="form-control" value="{{ $approval_cost_head->nama_pengeluaran }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Tipe
                                        <input type="text" name="tipe" class="form-control" value="{{ $approval_cost_head->tipe }}"  readonly>
                                       
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        Keterangan
                                        <input type="text" name="request" class="form-control" value="{{ $approval_cost_head->keterangan }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2" hidden>
                                        
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $approval_cost_head->no_urut }}" required readonly>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

<!-- ################################### COBA #################################### -->
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div style="border:1px white;width:100%;overflow-y:scroll;">
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput_1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th hidden>Id Tipe</th>
                                                    <th>Uraian</th>
                                                    <th>Spesifikasi</th>
                                                    @if($approval_cost_head->kategori == '1'|| $approval_cost_head->kategori == '2'|| $approval_cost_head->kategori == '3'|| $approval_cost_head->kategori == '4'|| $approval_cost_head->kategori == '5' )
                                                        <th>Jml Karyawan</th>
                                                    @else
                                                        <th>Qty</th>
                                                    @endif
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                    <th>Ceklist</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($approval_cost_detail as $row)
                                                    @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                        @if($approval_cost_head->status_validasi == '0')
                                                            <tr>
                                                        @elseif($approval_cost_head->status_validasi == '1')
                                                            @if($row->status_detail == '0' && $row->id_user_detail != '')
                                                                <tr style="background-color: #FF4A4A;">
                                                            @elseif($row->status_detail == '0' && $row->id_user_detail == '')
                                                                <tr>
                                                            @elseif($row->status_detail == '1' && $row->id_user_detail != '')
                                                                <tr>
                                                            @endif
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                        <!-- @if($row->status_detail == '0')
                                                            <tr style="background-color: #FF4A4A;">
                                                        @elseif($row->status_detail == '1') -->
                                                            <tr>
                                                        <!-- @endif -->
                                                    @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                        @if($row->status_detail == '0')
                                                            <tr style="background-color: #FF4A4A;">
                                                        @elseif($row->status_detail == '1')
                                                            <tr>
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                        @if($row->status_detail == '0')
                                                            <tr style="background-color: #FF4A4A;">
                                                        @elseif($row->status_detail == '1')
                                                            <tr>
                                                        @endif
                                                    @else
                                                    
                                                    @endif
                                                        <td>
                                                            <input type="text" class="form-control" name="no[]" id="no" style="font-size: 13px;" value="{{ $no }}" hidden>{{ $no }}
                                                        </td>
                                                        <td hidden>{{ $row->no_urut }}</td>
                                                        <td class="desc">
                                                            <input type="text" class="form-control" name="desc[]{{ $no }}" id="desc[]{{ $no }}" style="font-size: 13px;" value="{{ $row->description}}" hidden>{{ $row->description}}
                                                        </td>
                                                        <td>{{ $row->spesifikasi}}</td>
                                                        <td align="right">{{ $row->qty}}</td>
                                                        <td align="right">{{ number_format($row->harga) }}</td>
                                                        <td align="right">{{ number_format($row->tharga) }}</td>
                                                        <td align="center" class="ceklis">
                                                            @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                                @if($approval_cost_head->status_validasi == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                @elseif($approval_cost_head->status_validasi == '1') <!-- Approved -->
                                                                    @if($row->status_detail == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled/> <!--  -->
                                                                    @elseif($row->status_detail == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled/> <!--  -->
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi == '3') <!-- pending -->
                                                                    @if($row->status_detail == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" /> 
                                                                    @elseif($row->status_detail == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked />
                                                                    @endif
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                                @if($approval_cost_head->status_validasi_acc == '0') <!-- Baru -->
                                                                    @if($row->status_detail_atasan == '0')
                                                                        <input type="hidden" name="chk" id="chk" value="0">
                                                                        <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/>
                                                                    @elseif($row->status_detail_atasan == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0"  />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_acc == '1') <!-- Approved -->
                                                                    @if($row->status_detail_acc == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0"  />
                                                                    @elseif($row->status_detail_acc == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" checked  />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_acc == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi_acc == '3') <!-- pending -->
                                                                    @if($row->status_detail_acc == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" />
                                                                    @elseif($row->status_detail_acc == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" checked />
                                                                    @endif
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                @if($approval_cost_head->status_validasi_fin == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" />
                                                                @elseif($approval_cost_head->status_validasi_fin == '1') <!-- Approved -->
                                                                    @if($row->status_detail == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );"  value="1" disabled />
                                                                    @elseif($row->status_detail == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_fin == '2') <!-- denied -->
																	<input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );"  value="1" disabled />	
                                                                @elseif($approval_cost_head->status_validasi_fin == '3') <!-- pending -->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                                @if($approval_cost_head->status_validasi_clm == '0') <!-- Baru -->
                                                                    @if($row->status_detail_clm == '1')
                                                                        <input type="hidden" name="chk" id="chk" value="0">
                                                                        <input type="checkbox" class="chk" name="chk" id="chk" value="1" disabled/>
                                                                    @elseif($row->status_detail_clm == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0"  />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_clm == '1') <!-- Approved -->
                                                                    @if($row->status_detail_clm == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0"  disabled/>
                                                                    @elseif($row->status_detail_clm == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" checked  disabled/>
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_clm == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi_clm == '3') <!-- pending -->
                                                                    @if($row->status_detail_clm == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" />
                                                                    @elseif($row->status_detail_clm == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" class="chk-approval" data-harga="{{ $row->tharga }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" checked />
                                                                    @endif
                                                                @endif



                                                            @else
                                                                @if($approval_cost_head->status_validasi == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                @elseif($approval_cost_head->status_validasi == '1') <!-- Approved -->
                                                                    @if($row->status_detail == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                    @elseif($row->status_detail == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi == '3') <!-- pending -->

                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="ceklist_temp" id="ceklist_temp{{ $no }}" hidden></td>
                                                        <td class="keterangan">
                                                            @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                                @if($approval_cost_head->status_validasi == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required >
                                                                @elseif($approval_cost_head->status_validasi == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" required readonly>
                                                                @elseif($approval_cost_head->status_validasi == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" required>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                                @if($approval_cost_head->status_validasi_acc == '0') <!-- Baru -->
                                                                    @if($row->status_detail_atasan == '0')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" readonly>
                                                                    @elseif($row->status_detail_atasan == '1')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" required>
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_acc == '1') <!-- approved -->
                                                                    @if($row->status_detail_acc == '0')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" readonly>
                                                                    @elseif($row->status_detail_acc == '1')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" readonly>
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_acc == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi_acc == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" >
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                @if($approval_cost_head->status_validasi_fin == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                @elseif($approval_cost_head->status_validasi_fin == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_fin }}" readonly>
                                                                @elseif($approval_cost_head->status_validasi_fin == '2') <!-- denied -->
																	<input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_fin }}" readonly>
                                                                @elseif($approval_cost_head->status_validasi_fin == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_fin }}" >
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                                @if($approval_cost_head->status_validasi_clm == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                @elseif($approval_cost_head->status_validasi_clm == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_clm }}" readonly>
                                                                @elseif($approval_cost_head->status_validasi_clm == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi_clm == '3') <!-- pending -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_clm }}" >
                                                                @endif
                                                            @else
                                                                @if($approval_cost_head->status_validasi == '0') <!-- Baru -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                @elseif($approval_cost_head->status_validasi == '1') <!-- approved -->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" readonly>
                                                                @elseif($approval_cost_head->status_validasi == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi == '3') <!-- pending -->

                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="keterangan_temp" id="keterangan_temp{{ $no }}" hidden></td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                @empty
                                                <tr>
                                                
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-8 mb-2">
                                        <div class="input-group mb-3">
                                            
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($approval_cost_upload as $row)
                                                    <tr>
                                                        <td><i>Attachment_{{ $no }}</i></td>
                                                        <td>
                                                            <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                {{ $row->filename }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    @empty
                                                    
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label for="total" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                    </div>  
                                    <div class="col-md-2 mb-2">
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="0" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                        @if($approval_cost_head->status_validasi_acc  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi_acc  == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi_acc  == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" id="button_form_denied">Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" id="button_form_denied">Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                            </div>
                                        @endif
                                    @elseif(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                        @if($approval_cost_head->status_validasi  == '1') <!-- approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi  == '2') <!--denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi  == '3') <!-- Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="submit" class="btn btn-success btn-sm" id="savedatas" name="savedatas" >Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button type="submit" class="btn btn-warning btn-sm" id="savedatas" name="savedatas" >Pending</button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="submit" class="btn btn-success btn-sm" id="savedatas" name="savedatas" >Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                 <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                        @if(Auth::user()->kode_sub_divisi == '7') <!-- Jika Finance Payroll-->
                                            @if($approval_cost_head->status_validasi_fin  == '1') <!-- approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            @elseif($approval_cost_head->status_validasi_fin  == '2') <!--denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            @elseif($approval_cost_head->status_validasi_fin  == '3') <!-- Pending -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" id="button_form_denied">Denied</button>
                                                </div>
                                            @else
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" id="button_form_denied">Denied</button>
                                                </div>
                                            @endif
                                        @else                                            
                                            @if($approval_cost_head->status_validasi_fin  == '1') <!-- approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_head->status_validasi_fin  == '2') <!--denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_head->status_validasi_fin  == '3') <!-- Pending -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                </div>
                                            @else
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                </div>
                                            @endif
                                        @endif
                                    @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                        @if($approval_cost_head->status_validasi_clm  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi_clm  == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi_clm  == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" id="button_form_denied">Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" id="button_form_denied">Denied</button>
                                            </div>

                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                            </div>
                                        @endif

                                    @else
                                        @if($approval_cost_head->status_validasi  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi  == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                            </div>
                                        @elseif($approval_cost_head->status_validasi  == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <!-- <a href="{{ route('approval_cost_update', $approval_cost_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Verifikasi
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <!-- <a href="{{ route('approval_cost_update', $approval_cost_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Verifikasi
                                                </button>
                                            </div>
                                        @endif
                                    @endif

                                    @if(Auth::user()->kode_sub_divisi == '7') <!-- Jika Finance Payroll-->
                                        <div class="col-md-9 mb-2" align="right">
                                            @if(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                @if($approval_cost_head->status_validasi_fin  == '0')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_fin  == '1')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_fin  == '2')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_fin  == '3')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @endif
                                            @endif
                                        </div>
                                    @else
                                        <div class="col-md-9 mb-2" align="right">
                                            @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                @if($approval_cost_head->status_validasi_acc  == '0')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_acc  == '1')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_acc  == '2')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_acc  == '3')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @endif
                                            @elseif(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                @if($approval_cost_head->status_validasi  == '0')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi  == '1')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi  == '2')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi  == '3')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @endif
                                            @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                @if($approval_cost_head->status_validasi_fin  == '0')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_fin  == '1')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_fin  == '2')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_fin  == '3')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @endif
                                            @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                @if($approval_cost_head->status_validasi_clm  == '0')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_clm  == '1')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_clm  == '2')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()" hidden>K e m b a l i</button>
                                                @elseif($approval_cost_head->status_validasi_clm  == '3')
                                                    <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                @endif
                                            @endif
                                        </div>
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            

            <!-- MODAL Pending -->
                                            <div class="modal fade" id="modal_pending" tabindex="-1" aria-labelledby="modal_pending" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Informasi</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4 class="text-center">Apakah anda yakin akan menunda pengajuan dengan kode pengajuan '{{ $approval_cost_head->kode_pengajuan_b }}' ini?</h4>
                                                        
                                                            <form action="#" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">Isi keterangan jika akan ditunda/dipending:</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="2" class="form-control" required></textarea>
                                                                </div>
                                                                
                                                                <button type="submit" class="btn btn-primary">Ya</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            <!-- End MODAL -->
            

        </div>
    </div>
</main>

@endsection






