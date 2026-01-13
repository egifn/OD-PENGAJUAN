@section('js')


<script type="text/javascript">
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
        let kode_divisi = $("#kode_divisi").val();
        let kode_sub_divisi = $("#kode_sub_divisi").val();
        let jenis = $("#jenis").val();
        
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
            url: "{{ route('approval_cost/approved.approved') }}",
            data: {
                no_urut: no_urut,
                jenis: jenis,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    if(kode_divisi === '6'){
                        if(kode_sub_divisi === '4'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else if(kode_sub_divisi === '5'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else{
                            window.location.href = "{{ route('pengajuan_biaya.index')}}";
                        }
                    }else if(kode_divisi === '5'){
                        window.location.href = "{{ route('approval_cost.index')}}";
                    }else{
                        window.location.href = "{{ route('pengajuan_biaya.index')}}";
                    }
                    // window.location.href = "{{ route('pengajuan_biaya.index')}}";
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
        let kode_sub_divisi = $("#kode_sub_divisi").val();
        
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
            url: "{{ route('approval_cost/denied.denied') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    if(response.res === true) {
                        if(kode_divisi === '6'){
                            if(kode_sub_divisi === '4'){
                                window.location.href = "{{ route('approval_cost.index')}}";
                            }else if(kode_sub_divisi === '4'){
                                window.location.href = "{{ route('approval_cost.index')}}";
                            }else{
                                window.location.href = "{{ route('pengajuan_biaya.index')}}";
                            }
                        }else if(kode_divisi === '5'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else{
                            window.location.href = "{{ route('pengajuan_biaya.index')}}";
                        }
                        // window.location.href = "{{ route('pengajuan_biaya.index')}}";
                    }else{

                    }
                }else{

                }
            }
        });
    });

    $("#button_form_pending").click(function() {
        // if ($('.keterangan_temp').text() == ""){
        //         alert("Keterangan harus diisi...!");
        //         //form.surat_jalan.focus();
        //         return (false);
        // }

        let no_urut = $("#no_urut").val();
        let kode_sub_divisi = $("#kode_sub_divisi").val();
        
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
            url: "{{ route('approval_cost/pending.pending') }}",
            data: {
                no_urut: no_urut,

                deskripsi: deskripsi,
                ceklist: ceklist,
                keterangan_detail:keterangan_detail,
            },
            success: function(response) {
                if(response.res === true) {
                    if(kode_divisi === '6'){
                        if(kode_sub_divisi === '4'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else if(kode_sub_divisi === '4'){
                            window.location.href = "{{ route('approval_cost.index')}}";
                        }else{
                            window.location.href = "{{ route('pengajuan_biaya.index')}}";
                        }
                    }else if(kode_divisi === '5'){
                        window.location.href = "{{ route('approval_cost.index')}}";
                    }else{
                        window.location.href = "{{ route('pengajuan_biaya.index')}}";
                    }
                    // window.location.href = "{{ route('pengajuan_biaya.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_back").click(function() {
        window.history.back();
    });
</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>View Pengajuan Biaya Prepaid</title>
@endsection

@section('content')


    
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Biaya Prepaid</li>
        <li class="breadcrumb-item">Daftar Pengajuan</li>
        <li class="breadcrumb-item active">View Pengajuan Biaya Prepaid</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">View Pengajuan Biaya Prepaid</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan_b" class="form-control" value="{{ $approval_cost_head->kode_pengajuan_b }}" required readonly>   
                                    </div>
                        
                                    <div class="col-md-2 mb-2">
                                        Yang Mengajukan
                                        <input type="text" name="nama" class="form-control" value="{{ $approval_cost_head->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Untuk Perusahaan
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $approval_cost_head->perusahaan_tujuan }}" required readonly>
                                        <input type="hidden" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $approval_cost_head->kode_perusahaan_tujuan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Depo
                                        <input type="text" name="depo" class="form-control" value="{{ $approval_cost_head->nama_depo }}" required readonly>
                                        <input type="hidden" name="kode_depo" id="kode_depo" class="form-control" value="{{ $approval_cost_head->kode_depo }}" required readonly>
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
                                        <input type="text" name="kategori" class="form-control" value="{{ $approval_cost_head->nama_pengeluaran }}" required readonly>
                                        <input type="hidden" name="jenis" id="jenis" class="form-control" value="{{ $approval_cost_head->id }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Tipe
                                        <input type="text" name="tipe" class="form-control" value="{{ $approval_cost_head->tipe }}"  readonly>
                                       
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        Keterangan
                                        <input type="text" name="request" class="form-control" value="{{ $approval_cost_head->keterangan }}" required readonly>
                                    </div>

                                    <div class="col-md-4 mb-2" hidden>
                                        sub divisi
                                        <input type="text" name="kode_divisi" id="kode_divisi" class="form-control" value="{{ Auth::user()->kode_divisi }}" required readonly>
                                        sub divisi
                                        <input type="text" name="kode_sub_divisi" id="kode_sub_divisi" class="form-control" value="{{ Auth::user()->kode_sub_divisi }}" required readonly>
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
                                        <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                            <thead>
                                                <tr>
                                                    <th hidden>Id Tipe</th>
                                                    <th>No</th>
                                                    <th>Uraian</th>
                                                    <th>Spesifikasi</th>
                                                    @if($approval_cost_head->kategori == '1'|| $approval_cost_head->kategori == '2'|| $approval_cost_head->kategori == '3'|| $approval_cost_head->kategori == '4'|| $approval_cost_head->kategori == '5' )
                                                        <th>Jml Karyawan</th>
                                                    @else
                                                        <th>Qty</th>
                                                    @endif
                                                    <th>Harga</th>
                                                    <th>Total Harga</th>
                                                    @if(Auth::user()->kode_divisi == '14') <!-- BOD-->
                                                        <th hidden>Persetujuan</th>
                                                        <th hidden>Keterangan</th>
                                                    @else
                                                        <th>Persetujuan</th>
                                                        <th>Keterangan</th>
                                                    @endif
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1 ?>
                                                @forelse ($approval_cost_detail as $row)
                                                    @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                        @if($row->status_detail == '0')
                                                            <tr style="background-color: #FF4A4A;">
                                                        @elseif($row->status_detail == '1')
                                                            <tr>
                                                        @endif
                                                    @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                        
                                                    @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                        
                                                    @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                        @if($row->status_detail == '0')
                                                            <tr style="background-color: #FF4A4A;">
                                                        @elseif($row->status_detail == '1')
                                                            <tr>
                                                        @endif
                                                    @else

                                                    @endif
                                                        <td hidden>{{ $row->no_urut}}</td>
                                                        <td class="no">{{ $no }}</td>
                                                        <td class="desc">
                                                            <input type="text" class="form-control" name="desc[]{{ $no }}" id="desc[]{{ $no }}" style="font-size: 13px;" value="{{ $row->description}}" hidden>{{ $row->description}}
                                                        </td>
                                                        <td>{{ $row->spesifikasi}}</td>
                                                        <td align="right">{{ $row->qty}}</td>
                                                        <td align="right">{{ number_format($row->harga) }}</td>
                                                        <td align="right">{{ number_format($row->tharga) }}</td>
                                                        @if(Auth::user()->kode_divisi == '14') <!-- BOD-->

                                                        @else
                                                            <td align="center" class="ceklist">
                                                                @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
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
                                                                        @if($row->status_detail == '0')
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                        @elseif($row->status_detail == '1')
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                        @elseif($row->status_detail == '3')
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                        @endif
                                                                    @endif
                                                                @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                                    @if(Auth::user()->kode_sub_divisi == '5') <!-- Manager Biaya Acc (bu Yeni) -->
                                                                        @if($approval_cost_head->status_validasi_acc == '0') <!-- Baru -->
                                                                            @if($row->status_detail == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1"  />
                                                                            @elseif($row->status_detail == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled/>
                                                                            @elseif($row->status_detail == '3')
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
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1"  />
                                                                            @elseif($row->status_detail_acc == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked  />
                                                                            @elseif($row->status_detail_acc == '3')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1"  />
                                                                            @endif
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_sub_divisi == '4') <!-- manager Akunting (pa eddy) -->
                                                                        @if($approval_cost_head->status_validasi_ka_akunting == '0') <!-- Baru -->
                                                                            @if($row->status_detail == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @elseif($row->status_detail == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled/>
                                                                            @elseif($row->status_detail == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled/>
                                                                            @endif
                                                                        @elseif($approval_cost_head->status_validasi_ka_akunting == '1') <!-- Approved -->
                                                                            @if($row->status_detail_acc == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @elseif($row->status_detail_acc == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                            @endif
                                                                        @elseif($approval_cost_head->status_validasi_ka_akunting == '2') <!-- denied -->

                                                                        @elseif($approval_cost_head->status_validasi_ka_akunting == '3') <!-- pending -->
                                                                            @if($row->status_detail_acc == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                            @elseif($row->status_detail_acc == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                            @elseif($row->status_detail_acc == '3')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                    @if($approval_cost_head->kategori == '1' || $approval_cost_head->kategori == '2' || $approval_cost_head->kategori == '5')
                                                                        @if($approval_cost_head->status_validasi_fin == '0') <!-- Baru -->
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}"  value="1" />
                                                                        @elseif($approval_cost_head->status_validasi_fin == '1') <!-- Approved -->
                                                                            @if($row->status_detail_fin == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @elseif($row->status_detail_fin == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                            @endif
                                                                        @elseif($approval_cost_head->status_validasi_fin == '2') <!-- denied -->

                                                                        @elseif($approval_cost_head->status_validasi_fin == '3') <!-- pending -->
                                                                            @if($row->status_detail_fin == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @elseif($row->status_detail_fin == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                            @elseif($row->status_detail_fin == '3')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @if($approval_cost_head->status_atasan == '0') <!-- Baru -->
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}"  value="1" />
                                                                        @elseif($approval_cost_head->status_atasan == '1') <!-- Approved -->
                                                                            @if($row->status_detail_atasan == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @elseif($row->status_detail_atasan == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                            @endif
                                                                        @elseif($approval_cost_head->status_atasan == '2') <!-- denied -->

                                                                        @elseif($approval_cost_head->status_atasan == '3') <!-- pending -->
                                                                            @if($row->status_detail_atasan == '0')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @elseif($row->status_detail_atasan == '1')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                            @elseif($row->status_detail_atasan == '3')
                                                                                <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                            @endif
                                                                        @endif
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
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                        @elseif($row->status_detail_clm == '1')
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                        @elseif($row->status_detail_clm == '3')
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" disabled />
                                                                        @endif
                                                                    @endif
                                                                @elseif(Auth::user()->kode_divisi == '14') <!-- BOD-->
                                                                    <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" hidden />
                                                                @else
                                                                    @if($approval_cost_head->status_atasan == '0') <!-- Baru -->
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="0" />
                                                                    @elseif($approval_cost_head->status_atasan == '1') <!-- Approved -->
                                                                        @if($row->status_detail == '0')
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );"  value="1" disabled />
                                                                        @elseif($row->status_detail == '1')
                                                                            <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" checked disabled />
                                                                        @endif
                                                                    @elseif($approval_cost_head->status_atasan == '2') <!-- denied -->

                                                                    @elseif($approval_cost_head->status_atasan == '3') <!-- pending -->
                                                                        <input type="checkbox" name="chk[]{{ $no }}" id="chk[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" onclick="input_ket( {{ $no }} );" value="1" />
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td class="ceklist_temp" id="ceklist_temp{{ $no }}" hidden></td>

                                                            <td class="keterangan">
                                                                @if(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                                                    {{ $row->keterangan_detail }}
                                                                @elseif(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                                                    {{-- {{ $row->keterangan_detail_acc }} --}}
                                                                    @if(Auth::user()->kode_sub_divisi == '5') <!-- Manager Biaya Acc (bu Yeni) -->
                                                                        @if($approval_cost_head->status_validasi_acc == '0') <!-- Baru -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                        @elseif($approval_cost_head->status_validasi_acc == '1') <!-- Approved -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" readonly>
                                                                        @elseif($approval_cost_head->status_validasi_acc == '2') <!-- denied -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}" readonly>
                                                                        @elseif($approval_cost_head->status_validasi_acc == '3') <!-- pending -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_acc }}">
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_sub_divisi == '4') <!-- manager Akunting (pa eddy) -->
                                                                        @if($approval_cost_head->status_validasi_ka_akunting == '0') <!-- Baru -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                        @elseif($approval_cost_head->status_validasi_ka_akunting == '1') <!-- Approved -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_ka_akunting }}" readonly>
                                                                        @elseif($approval_cost_head->status_validasi_ka_akunting == '2') <!-- denied -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_ka_akunting }}" readonly>
                                                                        @elseif($approval_cost_head->status_validasi_ka_akunting == '3') <!-- pending -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_ka_akunting }}">
                                                                        @endif
                                                                    @endif
                                                                @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                                                    @if($approval_cost_head->kategori == '1' || $approval_cost_head->kategori == '2' || $approval_cost_head->kategori == '5')
                                                                        @if($approval_cost_head->status_validasi_fin == '0') <!-- Baru -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                        @elseif($approval_cost_head->status_validasi_fin == '1') <!-- Approved -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_fin }}" readonly>
                                                                        @elseif($approval_cost_head->status_validasi_fin == '2') <!-- denied -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_fin }}" readonly>
                                                                        @elseif($approval_cost_head->status_validasi_fin == '3') <!-- pending -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_fin }}">
                                                                        @endif
                                                                    @else
                                                                        @if($approval_cost_head->status_atasan == '0') <!-- Baru -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                        @elseif($approval_cost_head->status_atasan == '1') <!-- Approved -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_atasan }}" readonly>
                                                                        @elseif($approval_cost_head->status_atasan == '2') <!-- denied -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_atasan }}" readonly>
                                                                        @elseif($approval_cost_head->status_atasan == '3') <!-- pending -->
                                                                            <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail_atasan }}">
                                                                        @endif
                                                                    @endif


                                                                    
                                                                @elseif(Auth::user()->kode_divisi == '10') <!-- Jika claim-->
                                                                    {{ $row->keterangan_detail_clm }}
                                                                @elseif(Auth::user()->kode_divisi == '14') <!-- BOD-->
                                                                    <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" hidden>
                                                                @else
                                                                    {{-- @if($approval_cost_head->status_validasi == '0') <!-- Baru -->
                                                                        <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="" required>
                                                                    @elseif($approval_cost_head->status_validasi == '1') <!-- approved -->
                                                                        <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" readonly>
                                                                    @elseif($approval_cost_head->status_validasi == '2') <!-- denied -->
    
                                                                    @elseif($approval_cost_head->status_validasi == '3') <!-- pending -->
                                                                        <input type="text" name="ket[]" id="ket" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" readonly>
                                                                    @endif --}}
    
                                                                    @if($approval_cost_head->status_atasan == '0') <!-- Baru -->
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="" required>
                                                                    @elseif($approval_cost_head->status_atasan == '1') <!-- approved -->
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}" readonly>
                                                                    @elseif($approval_cost_head->status_atasan == '2') <!-- denied -->
    
                                                                    @elseif($approval_cost_head->status_atasan == '3') <!-- pending -->
                                                                        <input type="text" name="ket[]{{ $no }}" id="ket[]{{ $no }}" onkeyup="input_ket( {{ $no }} );" class="form-control" style="height: 20px" value="{{ $row->keterangan_detail }}">
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td class="keterangan_temp" id="keterangan_temp{{ $no }}" hidden></td>
                                                        @endif

                                                        
                                                        
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
                                                            <a href="{{url('images/'. $row->filename)}}">
                                                                {{ $row->filename}}
                                                            </a>
                                                            
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                    @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center">Tidak file yang di lampirkan</td>
                                                    </tr>
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
                                <br>
                                <div class="row">
                                    @if(Auth::user()->kode_divisi == '6') <!-- Jika Accounting-->
                                        @if(Auth::user()->kode_sub_divisi == '5') <!-- Manager Biaya Acc -->
                                            @if($approval_cost_head->status_biaya_pusat  == '1') <!-- 1: approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_head->status_biaya_pusat  == '2') <!-- 2: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_head->status_biaya_pusat  == '3') <!-- 3: Pending -->
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif 
                                        @elseif(Auth::user()->kode_sub_divisi == '4') <!-- Manager Akunting -->
                                            @if($approval_cost_head->status_ka_akunting  == '1') <!-- 1: approved -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_head->status_ka_akunting  == '2') <!-- 2: denied -->
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                                </div>
                                            @elseif($approval_cost_head->status_ka_akunting  == '3') <!-- 3: Pending -->
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                        Approved
                                                    </button>
                                                </div>
                                        
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                        Denied
                                                    </button>
                                                </div>
                                            
                                                <div class="col-md-1 mb-2">
                                                    <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                        Pending
                                                    </button>
                                                </div>
                                            @endif  
                                        @endif
                                    @elseif(Auth::user()->kode_divisi == '16') <!-- Jika Cost/Biaya-->
                                        @if($approval_cost_head->status_biaya  == '1') <!-- approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_biaya  == '2') <!--denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_biaya  == '3') <!-- Pending -->
                                            <div class="col-md-1 mb-2">
                                                <!-- <a href="{{ route('approval_cost_update', $approval_cost_head->no_urut) }}" class="btn btn-success btn-sm">Approved</a> -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <!-- <a href="{{ route('approval_cost_denied', $approval_cost_head->no_urut) }}" class="btn btn-danger btn-sm">Denied</a> -->
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                               <!--  <a href="{{ route('approval_cost_pending', $approval_cost_head->no_urut) }}" class="btn btn-warning btn-sm">Pending</a> -->
                                               <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @elseif($approval_cost_head->status_biaya  == '0' and $approval_cost_head->status_validasi  == '0') <!-- Baru -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                 <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                 <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @elseif(Auth::user()->kode_divisi == '5') <!-- Jika Finance-->
                                        @if($approval_cost_head->status_fin  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_fin  == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_fin  == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @elseif(Auth::user()->kode_divisi == '14') <!-- BOD-->
                                        @if($approval_cost_head->status_bod  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_bod  == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_bod  == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTambahPesan_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        @if($approval_cost_head->status_atasan  == '1') <!-- 1: approved -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_atasan  == '2') <!-- 2: denied -->
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-success btn-sm" disabled>Approved</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-danger btn-sm" disabled>Denied</button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            </div>
                                        @elseif($approval_cost_head->status_atasan  == '3') <!-- 3: Pending -->
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                    
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-success btn-sm" id="button_form_approved">
                                                    Approved
                                                </button>
                                            </div>
                                       
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-danger btn-sm" id="button_form_denied">
                                                    Denied
                                                </button>
                                            </div>
                                        
                                            <div class="col-md-1 mb-2">
                                                <button type="button" class="btn btn-warning btn-sm" id="button_form_pending">
                                                    Pending
                                                </button>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="col-md-9 mb-2" align="right">
                                        <button class="btn btn-primary btn-sm float-right" id="button_form_back">
                                            K e m b a l i
                                        </button>
                                    </div> 

                                    <!-- MODAL APPROVED -->
                                            <div class="modal fade" id="modalTambahPesan_approve" tabindex="-1" aria-labelledby="modalTambahPesan_approve" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval_cost_update', $approval_cost_head->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL DENIED -->
                                            <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk Keterangan ditolak </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval_cost_denied', $approval_cost_head->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->
                                    <!-- MODAL Pending -->
                                            <div class="modal fade" id="modalTambahPesan_pending" tabindex="-1" aria-labelledby="modalTambahPesan_pending" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Isi untuk keterangan ditunda  </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!--FORM TAMBAH BARANG-->
                                                            <form action="{{ route('approval_cost_pending', $approval_cost_head->no_urut) }}" method="get">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="">keterangan</label>
                                                                    <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                            </form>
                                                            <!--END FORM TAMBAH BARANG-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <!-- End MODAL -->

                                            <div class="modal fade" id="modalTambahPesan" tabindex="-1" aria-labelledby="modalTambahPesan" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Informasi</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                Pengajuan tidak bisa diproses. Pengajuan belum diverifikasi.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>
</main>





@endsection

@section('script')



@endsection




