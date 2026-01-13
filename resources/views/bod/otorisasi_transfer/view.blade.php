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

    $("#button_form_upload").click(function() {
        
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let kode_pengajuan_b = $("#kode_pengajuan_b").val();
        let no_urut = $("#no_urut").val();
        
        let deskripsi = []
        let spesifikasi = []
        

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.spes').each(function() {
            spesifikasi.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_biaya_upload/upload.upload') }}",
            data: {
                kode_pengajuan_b: kode_pengajuan_b,
                no_urut: no_urut,

                deskripsi: deskripsi,
                spesifikasi: spesifikasi,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('pengajuan_biaya_upload.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_denied").click(function() {
		let kode_pengajuan_b = $("#kode_pengajuan_b").val();
        let no_urut = $("#no_urut").val();
        
        let deskripsi = []
        let spesifikasi = []
        

        $('.desc').each(function() {
            deskripsi.push($(this).text())
        })
        $('.spes').each(function() {
            spesifikasi.push($(this).text())
        })
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('bod_otorisasi/denied.denied') }}",
            data: {
                kode_pengajuan_b: kode_pengajuan_b,
                no_urut: no_urut,

                deskripsi: deskripsi,
                spesifikasi: spesifikasi,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('bod_otorisasi.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_pending").click(function() {
        
    });

    $("#button_hapus_lampiran").click(function() {
        $('#filename_1').val('');
    });

</script>



@stop

@extends('layouts.admin')

@section('title')
    <title>Otorisasi Transfer</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Otorisasi Transfer</li>
        <li class="breadcrumb-item active">View</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('bod_otorisasi/otorisasi') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data"> 
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Otorisasi Transfer</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan_b" id="kode_pengajuan_b" class="form-control" value="{{ $approval_cost_head->kode_pengajuan_b }}" required readonly>   
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
                                    <div style="border:1px white;width:100%;height:180px;overflow-y:scroll;">
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
                                                    @if($approval_cost_head->kategori == '1'|| $approval_cost_head->kategori == '2'|| $approval_cost_head->kategori == '3'|| $approval_cost_head->kategori == '4'|| $approval_cost_head->kategori == '5' )
                                                        <th hidden>Harga Satuan</th>
                                                    @else
                                                        <th>Harga Satuan</th>
                                                    @endif
                                                    <th>Total Harga</th>
                                                    {{-- <th>Ceklist</th>
                                                    <th>Keterangan</th> --}}
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
                                                        @if($row->status_detail == '0')
                                                            <tr style="background-color: #FF4A4A;">
                                                        @elseif($row->status_detail == '1')
                                                            <tr>
                                                        @endif
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
                                                        <td class="spes">
                                                            <input type="text" class="form-control" name="spes[]{{ $no }}" id="spes[]{{ $no }}" style="font-size: 13px;" value="{{ $row->spesifikasi}}" hidden>{{ $row->spesifikasi}}
                                                        </td>
                                                        <td align="right">{{ $row->qty}}</td>
                                                        @if($approval_cost_head->kategori == '1'|| $approval_cost_head->kategori == '2'|| $approval_cost_head->kategori == '3'|| $approval_cost_head->kategori == '4'|| $approval_cost_head->kategori == '5' )
                                                            <td align="right" hidden>{{ number_format($row->harga) }}</td>
                                                        @else
                                                            <td align="right">{{ number_format($row->harga) }}</td>
                                                        @endif
                                                        <td align="right">{{ number_format($row->tharga) }}</td>
                                                        {{-- <td align="center" class="ceklis">
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
                                                                    @if($row->status_detail == '0' && $row->status_detail_fin == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                    @elseif($row->status_detail == '1' && $row->status_detail_fin == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                    @elseif($row->status_detail == '1' && $row->status_detail_fin == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_acc == '1') <!-- Approved -->
                                                                    @if($row->status_detail_acc == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                    @elseif($row->status_detail_acc == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_acc == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi_acc == '3') <!-- pending -->
                                                                    @if($row->status_detail_acc == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                    @elseif($row->status_detail_acc == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked />
                                                                    @endif
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                @if($approval_cost_head->status_validasi_fin == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" />
                                                                @elseif($approval_cost_head->status_validasi_fin == '1') <!-- Approved -->
                                                                    @if($row->status_detail == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );"  value="1" disabled />
                                                                    @elseif($row->status_detail == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_fin == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi_fin == '3') <!-- pending -->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                                @if($approval_cost_head->status_validasi_clm == '0') <!-- Baru -->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                @elseif($approval_cost_head->status_validasi_clm == '1') <!-- Approved -->
                                                                    @if($row->status_detail_clm == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                    @elseif($row->status_detail_clm == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_clm == '2') <!-- denied -->

                                                                @elseif($approval_cost_head->status_validasi_clm == '3') <!-- pending -->
                                                                    @if($row->status_detail_clm == '0')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                    @elseif($row->status_detail_clm == '1')
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked />
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
                                                                    @if($row->status_detail == '0' && $row->status_detail_fin == '0')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" hidden>{{ $row->keterangan_detail }}
                                                                    @elseif($row->status_detail == '1' && $row->status_detail_fin == '1')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" required>
                                                                    @elseif($row->status_detail == '1' && $row->status_detail_fin == '0')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" required>
                                                                    @endif
                                                                @elseif($approval_cost_head->status_validasi_acc == '1') <!-- approved -->
                                                                    @if($row->status_detail == '0' && $row->status_detail_acc == '0')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" hidden>{{ $row->keterangan_detail }}
                                                                    @elseif($row->status_detail == '1' && $row->status_detail_acc == '0')
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" required>
                                                                    @elseif($row->status_detail == '1' && $row->status_detail_acc == '1')
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
                                                        <td class="keterangan_temp" id="keterangan_temp{{ $no }}" hidden></td> --}}
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
                                                            <a href="{{url('images/'. $row->filename)}}" target="_blank">
                                                                {{ $row->filename}}
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
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ number_format($approval_cost_total) }}" style="text-align:right; font-style:bold;" required readonly>
                                        
                                    </div>

                                </div>

                                <div class="row">
                                    {{-- <div class="col-md-8 mb-2">
                                        <strong>Upload Lampiran/Attachment</strong>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="filename[]" id="filename_1" multiple>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-danger" id="button_hapus_lampiran" style="height: 40px;"> <span class="fa fa-eraser"></span></button>
                                            </span>
                                        </div>
                                    </div>  --}}

                                    <div class="col-md-8 mb-2">
                                        <div class="input-group mb-3">
                                            
                                            <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($attach_upload_fin as $row)
                                                    <tr>
                                                        <td><i>Attachment Upload</i></td>
                                                        <td>
                                                            <a href="{{url('images/'. $row->filename_upload)}}" target="_blank">
                                                                {{ $row->filename_upload}}
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
                                </div>
                                
                                
                                <div class="row">
                                    @if($approval_cost_head->status_bod_otorisasi  == '1') <!-- approved -->
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-success btn-sm" disabled>O t o r i s a s i</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-danger btn-sm" disabled>D e n i e d</button>
                                        </div>
									@elseif($approval_cost_head->status_bod_otorisasi  == '2') <!-- approved -->
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-success btn-sm" disabled>O t o r i s a s i</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-danger btn-sm" disabled>D e n i e d</button>
                                        </div>
                                    @else
                                        <div class="col-md-1 mb-2">
                                            <button type="submit" class="btn btn-success btn-sm" id="button_form_upload">O t o r i s a s i</button>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            {{-- <button type="submit" class="btn btn-danger btn-sm" id="button_form_denied">D e n i e d</button> --}}
                                            <a href="#" class="btn btn-danger btn-sm" id="button_form_denied">D e n i e d</a>
                                        </div>
                                    @endif

                                    <div class="col-md-10 mb-2" align="right">
                                        {{-- <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button> --}}
                                        <a href="#" onclick="goBack()" class="btn btn-primary btn-sm">K e m b a l i</a>
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

@endsection






