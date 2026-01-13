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
        function goBack() {
            window.history.back();
        }

        var x = 1;
        function tekan_otorisasi(x){
            
            let id = $('#id'+ x +'').val();

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('otorisasi_claim_lp_detail/otorisasi.otorisasi') }}",
                data: {
                    id: id,
                },
                success: function(response) {
                if (response.res == true) {
                    window.location.href = "{{ route('otorisasi_claim_lp/view') }}";
                }else{
                    alert('Gagal, Data tidak berhasil diretur...');
                }
                }
            });
        }
		
		function tekan_batal(x){
            let id = $('#id'+ x +'').val();

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('otorisasi_claim_lp_detail/batal.batal') }}",
                data: {
                    id: id,
                },
                success: function(response) {
                if (response.res == true) {
                    window.location.href = "{{ route('otorisasi_claim_lp/view') }}";
                }else{
                    alert('Gagal, Data tidak berhasil diretur...');
                }
                }
            });
        }
		
		function tekanview(x){
            let kode_pengajuan_b = $('#kode_pengajuan_b'+ x +'').val();
            let perusahaan = $('#kode_perusahaan_detail'+ x +'').val();
            let id_program = $('#id_program_ssd'+ x +'').val();
             
            $.ajax({
            type: "GET",
            url: "{{ route('otorisasi_claim_tua_bocbc/view_data.view_data_all') }}",
            data: {
                id_program: id_program,
                perusahaan: perusahaan,
                kode_pengajuan_b: kode_pengajuan_b
            },
            dataType: "json",
            success: function(response) {
                    let tabledata_list;
                    let no = 0;
                    response.data.forEach(program => {
                        let reward = program.reward;
                        //membuat format rupiah Harga//
                        var reverse_reward = reward.toString().split('').reverse().join(''),
                        ribuan_reward  = reverse_reward.match(/\d{1,3}/g);
                        rupiah_reward = ribuan_reward.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        let reward_tiv = program.reward_tiv;
                        //membuat format rupiah Harga//
                        var reverse_reward_tiv = reward_tiv.toString().split('').reverse().join(''),
                        ribuan_reward_tiv  = reverse_reward_tiv.match(/\d{1,3}/g);
                        rupiah_reward_tiv = ribuan_reward_tiv.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        let potongan = program.potongan;
                        //membuat format rupiah Harga//
                        var reverse_potongan = potongan.toString().split('').reverse().join(''),
                        ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                        rupiah_potongan = ribuan_potongan.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        let ditransfer = program.ditransfer;
                        //membuat format rupiah Harga//
                        var reverse_ditransfer = ditransfer.toString().split('').reverse().join(''),
                        ribuan_ditransfer  = reverse_ditransfer.match(/\d{1,3}/g);
                        ditransfer_rupiah = ribuan_ditransfer.join(',').split('').reverse().join('');
                        //End membuat format rupiah//

                        no = no + 1
                        tabledata_list += `<tr>`;
                        tabledata_list += `<td>` +no+ `</td>`;
                        tabledata_list += `<td hidden>${program.id_program}</td>`;
                        tabledata_list += `<td>${program.kode_perusahaan}</td>`;
                        tabledata_list += `<td>${program.nama_depo}</td>`;
                        tabledata_list += `<td>${program.cluster}</td>`;
                        tabledata_list += `<td>${program.kode_outlet}</td>`;
                        tabledata_list += `<td>${program.nama_outlet}</td>`;
                        tabledata_list += `<td>${program.no_rek}</td>`;
                        tabledata_list += `<td>${program.bank}</td>`;
                        tabledata_list += `<td>${program.nama_rekening}</td>`;
                        // tabledata_list += `<td></td>`;
                        tabledata_list += `<td alignt='right'>${rupiah_reward}</td>`;
                        tabledata_list += `<td alignt='right'>${rupiah_reward_tiv}</td>`;
                        tabledata_list += `<td alignt='right'>${rupiah_potongan}</td>`;
                        tabledata_list += `<td alignt='right'>${ditransfer_rupiah}</td>`;
                        tabledata_list += `</tr>`;
                    });
                    $("#tabledata_list").html(tabledata_list);
                }
            });
            $('#modalView').modal('show')
        }
    </script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Daftar Otorisasi</title>
@endsection

@section('content')

<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Biaya Non Tunai</li>
        <li class="breadcrumb-item">Otorisasi Transfer</li>
        <li class="breadcrumb-item">Program Claim</li>
        <li class="breadcrumb-item">Otorisasi Transfer Claim</li>
        <li class="breadcrumb-item active">Daftar Otorisasi</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn" id="page_form">
            <div class="row">
                
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                   Daftar Transfer
                                </h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
    
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif    
                                
                                <div class="table-responsive">
                                        <!-- <table class="table table-hover table-bordered"> -->
                                        <div style="width:100%;">
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>tgl Input</th>
                                                        <th>Jenis Transfer</th>
                                                        <th hidden>tgl Transfer</th>
                                                        <th>Dari Rekening</th>
                                                        <th>Ke Rekening/No BCA/Virtual Account</th>
                                                        <th>Keterangan Program</th>
                                                        <th hidden>Id</th>
                                                        <th hidden>Kode_pengajuan</th>
                                                        <th hidden>Kategori</th>
                                                        <th hidden>No Surat Program</th>
                                                        <th hidden>Id Program</th>
                                                        <th hidden>Nama Program</th>
                                                        <th hidden>Perusahaan</th>
                                                        <th hidden>Depo</th>
                                                        <th hidden>Kode Toko</th>
                                                        <th hidden>Nama Toko</th>
                                                        <th hidden>Bank</th>
                                                        <th hidden>No Rekening</th>
                                                        <th hidden>Atas Nama Rekening</th>
                                                        <th hidden>Reward Distributor</th>
                                                        <th hidden>Reward TIV</th>
                                                        <th hidden>Potongan</th>
                                                        <th>Jumlah</th>
                                                        <th hidden>Pilih &nbsp; <input type="checkbox" id="select-all" class="float-right"></th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no=1 ?>
                                                    @forelse ($data_list_otorisasi as $row)
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>
                                                            <input class="form-control" type="text" name="tgl_input[]" id="tgl_input{{ $no }}" value="{{ $row->tgl_transfer }}" hidden/>
                                                            {{ $row->tgl_transfer }}
                                                        </td>
                                                        <td>
                                                            @if($row->nama_bank == $row->bank_outlet)
                                                                <label>Rekening {{$row->nama_bank}}</label> 
                                                            @else
                                                                <label>Rekening Bank Lain</label> 
                                                            @endif
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="tgl_transfer[]" id="tgl_transfer{{ $no }}" value="{{ $row->tgl_transfer }}" hidden/>
                                                            {{ $row->tgl_transfer }}
                                                        </td>
                                                        <td>
                                                            {{-- <input class="form-control" type="text" name="tgl_transfer[]" id="tgl_transfer{{ $no }}" value="{{ $row->tgl_transfer }}" hidden/> --}}
                                                            {{ $row->norek }}<br>
															{{ $row->nama_perusahaan }}
                                                        </td>
                                                        <td>
                                                            {{-- <input class="form-control" type="text" name="tgl_transfer[]" id="tgl_transfer{{ $no }}" value="{{ $row->tgl_transfer }}" hidden/> --}}
                                                            {{ $row->norek_outlet }} <br>
                                                            {{ $row->nama_rekening_outlet }}
                                                        </td>

                                                        <td>
                                                            {{ $row->keterangan_pengajuan }}
                                                        </td>

                                                        <td hidden>
                                                            <input class="form-control" type="text" name="id[]" id="id{{ $no }}" value="{{ $row->id }}" hidden/>
                                                            {{ $row->id }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="kode_pengajuan_b[]" id="kode_pengajuan_b{{ $no }}" value="{{ $row->kode_pengajuan_b }}" hidden/>
                                                            {{ $row->kode_pengajuan_b }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="kategori[]" id="kategori{{ $no }}" value="{{ $row->kategori }}" hidden/>
                                                            {{ $row->kategori }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="no_surat_program[]" id="no_surat_program{{ $no }}" value="{{ $row->no_surat_program }}" hidden/>
                                                            {{ $row->no_surat_program }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="id_program_ssd[]" id="id_program_ssd{{ $no }}" value="{{ $row->id_program_ssd }}" hidden/>
                                                            {{ $row->id_program_ssd }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="nama_program[]" id="nama_program{{ $no }}" value="{{ $row->nama_program }}" hidden/>
                                                            {{ $row->nama_program }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="kode_perusahaan_detail[]" id="kode_perusahaan_detail{{ $no }}" value="{{ $row->kode_perusahaan_program }}" hidden/>
                                                            {{ $row->kode_perusahaan_program }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="nama_depo[]" id="nama_depo{{ $no }}" value="{{ $row->nama_depo_outlet }}" hidden/>
                                                            {{ $row->nama_depo_outlet }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="kode_outlet[]" id="kode_outlet{{ $no }}" value="{{ $row->kode_outlet }}" hidden/>
                                                            {{ $row->kode_outlet }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="nama_outlet[]" id="nama_outlet{{ $no }}" value="{{ $row->nama_outlet }}" hidden/>
                                                            {{ $row->nama_outlet }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="bank_rekening[]" id="bank_rekening{{ $no }}" value="{{ $row->bank_outlet }}" hidden/>
                                                            {{ $row->bank_outlet }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="no_rekening[]" id="no_rekening{{ $no }}" value="{{ $row->norek_outlet }}" hidden/>
                                                            {{ $row->norek_outlet }}
                                                        </td>
                                                        <td hidden>
                                                            <input class="form-control" type="text" name="nama_rekening[]" id="nama_rekening{{ $no }}" value="{{ $row->nama_rekening_outlet }}" hidden/>
                                                            {{ $row->nama_rekening_outlet }}
                                                        </td>
                                                        <td align="right" hidden>
                                                            <input class="form-control" type="text" name="reward[]" id="reward{{ $no }}" value="{{ $row->reward }}" hidden/>
                                                            {{ number_format($row->reward) }}
                                                        </td >
                                                        <td align="right" hidden>
                                                            <input class="form-control" type="text" name="reward_tiv[]" id="reward_tiv{{ $no }}" value="{{ $row->reward_tiv }}" hidden/>
                                                            {{ number_format($row->reward_tiv) }}
                                                        </td>
                                                        <td align="right" hidden>
                                                            <input class="form-control" type="text" name="potongan[]" id="potongan{{ $no }}" value="{{ $row->potongan }}" hidden/>
                                                            {{ number_format($row->potongan) }}
                                                        </td>
                                                        <td align="right">
                                                            <input class="form-control" type="text" name="total[]" id="total{{ $no }}" value="{{ $row->total }}" hidden/>
                                                            {{ number_format($row->total) }}
                                                        </td>
                                                        <td align="center" hidden>
                                                            <input type="checkbox" name="chk" id="chk"/>
                                                        </td>
                                                        <td align="center">
															@if($row->keterangan == 'bulk')
                                                                <button type="button" name="view[]" id="button_view{{ $no }}" class="btn btn-primary btn-sm" onclick="tekanview( {{ $no }} );">View</button> 
                                                                {{-- <button type="button" data-id="${program.id_program}" data-perusahaan="${program.perusahaan}" data-tgl_import="${program.tgl_import}" id="button_view_data" class="btn btn-success btn-sm">View</button> --}}
                                                            @endif
                                                            <button type="button" name="button_otorisasi[]" id="button_otorisasi{{ $no }}" class="btn btn-success btn-sm" onclick="tekan_otorisasi( {{ $no }} );">Otorisasi</button>
                                                            <button type="button" name="button_batal[]" id="button_batal{{ $no }}" class="btn btn-warning btn-sm" onclick="tekan_batal( {{ $no }} );">B a t a l</button>
                                                        </td>
                                                    </tr>
                                                    <?php $no++; ?>
                                                    @empty
                                                    <tr>
                                                        
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="col-mb-15 float-right">
                                        <button class="btn btn-primary btn-sm" style="width: 100%;" onclick="goBack()">K e m b a l i</button>
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                
                <!-- ##################################################################################################  -->
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="modalView" aria-hidden="true" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right" hidden>
                        <input type="text" name="cari_list" id="cari_list" class="form-control" value="">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_list" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th >No</th>
                                <th hidden>Id</th>
                                <th >Perusahaan</th>
                                <th >Depo</th>
                                <th >Cluster</th>
                                <th >Id Toko</th>
                                <th >Nama Toko</th>
                                <th >No Rek</th>
                                <th >Bank</th>
                                <th >Nama Rekening</th>
                                <th >Reward Distributor</th>
                                <th >Reward TIV</th>
                                <th >Potongan</th>
                                <th >Total</th>
                            </tr>
                        </thead>
                        <tbody id="tabledata_list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
