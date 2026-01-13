@section('js')

<script type="text/javascript">
    function goBack() {
        window.history.back();
    }

    fetchAllData();
    function fetchAllData(){
        // let id = $(this).data('id_program');
        // let perusahaan = $(this).data('perusahaan');

        let perusahaan = $("#kode_perusahaan_tujuan").val();
        let id = $("#id_program").val();
        
        $.ajax({
        type: "GET",
        url: "{{ route('pengajuan_tiv/view_data_all.view_data_all') }}",
        data: {
             id: id,
             perusahaan: perusahaan
        },
        dataType: "json",
        success: function(response) {
            let tabledata_outlet;
            let totalReward = 0;
            let totalReward_tiv = 0;
            let totalPotongan = 0;
            let totalDitransfer = 0;
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
                tabledata_outlet += `<tr>`;
                tabledata_outlet += `<td>` +no+ `</td>`;
                tabledata_outlet += `<td hidden>${program.id_program}</td>`;
                tabledata_outlet += `<td>${program.perusahaan}</td>`;
                tabledata_outlet += `<td>${program.dist_depo}</td>`;
                tabledata_outlet += `<td>${program.cluster}</td>`;
                tabledata_outlet += `<td>${program.customer_id}</td>`;
                tabledata_outlet += `<td>${program.customer_name}</td>`;
                tabledata_outlet += `<td>${program.no_rek}</td>`;
                tabledata_outlet += `<td>${program.bank}</td>`;
                tabledata_outlet += `<td>${program.nama_rekening}</td>`;
                tabledata_outlet += `<td align='right'>${rupiah_reward}</td>`;
                tabledata_outlet += `<td align='right'>${rupiah_reward_tiv}</td>`;
                tabledata_outlet += `<td align='right'>${rupiah_potongan}</td>`;
                tabledata_outlet += `<td align='right'>${ditransfer_rupiah}</td>`;
                tabledata_outlet += `</tr>`;

                totalReward += program.reward;
                totalReward_tiv += program.reward_tiv;
                totalPotongan += parseInt(program.potongan);
                totalDitransfer += program.ditransfer;
            });

            //membuat format rupiah totalReward//
            var reverse_totalReward = totalReward.toString().split('').reverse().join(''),
                ribuan_totalReward  = reverse_totalReward.match(/\d{1,3}/g);
                totalReward_rupiah = ribuan_totalReward.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            //membuat format rupiah totalReward//
            var reverse_totalReward_tiv = totalReward_tiv.toString().split('').reverse().join(''),
                ribuan_totalReward_tiv  = reverse_totalReward_tiv.match(/\d{1,3}/g);
                totalReward_tiv_rupiah = ribuan_totalReward_tiv.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            //membuat format rupiah totalPotongan//
            var reverse_totalPotongan = totalPotongan.toString().split('').reverse().join(''),
                ribuan_totalPotongan  = reverse_totalPotongan.match(/\d{1,3}/g);
                totalPotongan_rupiah = ribuan_totalPotongan.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            //membuat format rupiah totalPotongan//
            var reverse_totalDitransfer = totalDitransfer.toString().split('').reverse().join(''),
                ribuan_totalDitransfer  = reverse_totalDitransfer.match(/\d{1,3}/g);
                totalDitransfer_rupiah = ribuan_totalDitransfer.join(',').split('').reverse().join('');
            //End membuat format rupiah//

            tabledata_outlet += `<tr>`;
            tabledata_outlet += `<td colspan="9" align='center'><b>T o t a l</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalReward_rupiah}</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalReward_tiv_rupiah}</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalPotongan_rupiah}</b></td>`;
            tabledata_outlet += `<td align='right'><b>${totalDitransfer_rupiah}</b></td>`;
            tabledata_outlet += `</tr>`;

            $("#tabledata_outlet").html(tabledata_outlet);
            $("#table_footer").html(table_footer);
        }
        });
    }

    $(document).on("click", "#button_view_data", function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let perusahaan = $(this).data('perusahaan');

        $.ajax({
        type: "GET",
        url: "{{ route('pengajuan_tiv/view_data_all.view_data_all') }}",
        data: {
             id: id,
             perusahaan: perusahaan
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
                    tabledata_list += `<td>${program.perusahaan}</td>`;
                    tabledata_list += `<td>${program.dist_depo}</td>`;
                    tabledata_list += `<td>${program.cluster}</td>`;
                    tabledata_list += `<td>${program.customer_id}</td>`;
                    tabledata_list += `<td>${program.cuastomer_name}</td>`;
                    tabledata_list += `<td>${program.no_rek}</td>`;
                    tabledata_list += `<td>${program.bank}</td>`;
                    tabledata_list += `<td>${program.nama_rekening}</td>`;
                    tabledata_list += `<td>${program.ach}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_reward}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_potongan}</td>`;
                    tabledata_list += `<td alignt='right'>${ditransfer_rupiah}</td>`;
                    tabledata_list += `</tr>`;
                });
                $("#tabledata_list").html(tabledata_list);
            }
        });
        $('#modalView').modal('show');
    });

</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Detail Pengajuan TIV</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Biaya Non Tunai</li>
        <li class="breadcrumb-item">Otorisasi Transfer</li>
        <li class="breadcrumb-item">Program Claim</li>
        <li class="breadcrumb-item">Otorisasi Transfer Claim</li>
        <li class="breadcrumb-item active">Detail Pengajuan Program</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Detail Pengajuan TIV - {{ $pengajuan_biaya_head->kode_pengajuan_b }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" class="form-control" value="{{ $pengajuan_biaya_head->tgl_pengajuan_b }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_biaya_head->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $pengajuan_biaya_head->nama_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="depo" class="form-control" value="{{ $pengajuan_biaya_head->nama_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="nm_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->nama_pengeluaran }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Untuk Perusahaan
                                        <input type="text" name="perusahaan_tujuan" id="perusahaan_tujuan" class="form-control" value="{{ $pengajuan_biaya_head->perusahaan_tujuan }}" required readonly>
                                    </div>
                                    
                                    <div class="col-md-2 mb-2" hidden>
                                        Kode Untuk Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $pengajuan_biaya_head->kode_perusahaan_tujuan }}" required readonly>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_biaya_head->keterangan }}" readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        No Surat 
                                        <input type="text" name="no_surat" id="no_surat" class="form-control" value="{{ $pengajuan_biaya_head->no_surat_program }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Id Program
                                        <input type="text" name="id_program" id="id_program" class="form-control" value="{{ $pengajuan_biaya_head->id_program }}" required readonly>
                                    </div>

                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        Nama Program
                                        <input type="text" name="nama_program" id="nama_program" class="form-control" value="{{ $pengajuan_biaya_head->nama_program }}" required>
                                    </div> --}}

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required>
                                    </div>
                                    
                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        Jenis Surat
                                        <input type="text" name="jenis_surat" id="jenis_surat" class="form-control" value="" required>
                                    </div> --}}
                                </div>
                                
                                <div class="row" hidden>
                                    <div class="col-md-2 mb-2">
                                        Division
                                        <input type="text" name="divisi" class="form-control" value="{{ $pengajuan_biaya_head->nama_divisi }}" readonly>
                                       
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        tipe
                                        <input type="text" name="tipe" class="form-control" value="" readonly>
                                       
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    
                                </div>
                                
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 mb-4">
                                    <div class="nav-tabs-boxed">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#pengajuan" role="tab" aria-controls="pengajuan">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Pengajuan</b>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#detail" role="tab" aria-controls="detail">
                                                    <i class="nav-icon icon-folder"></i>
                                                    &nbsp;<b>Detail Pengajuan</b>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="pengajuan" role="tabpanel">
                                                <br>

                                                <div class="table-responsive">
                                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th hidden>#</th>
                                                                    <th>Id Program</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Jml Toko</th>
                                                                    <th>Total Reward</th>
                                                                    <th>Total Potongan</th>
                                                                    <th>Total</th>
                                                                    <th hidden>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($pengajuan_biaya_detail as $row)
                                                                <tr>
                                                                    <td hidden>#</td>
                                                                    <td>{{ $row->description }}</td>
                                                                    <td>{{ $row->spesifikasi }}</td>
                                                                    <td align="right">{{ $row->qty }}</td>
                                                                    <td align="right">Rp. {{ number_format($row->harga)}}</td>
                                                                    <td align="right">Rp. {{ number_format($row->potongan)}}</td>
                                                                    <td align="right">Rp. {{ number_format($row->tharga)}}</td>
                                                                    <td align="center" hidden>
                                                                        <button type="button" data-id="{{ $row->description }}" data-perusahaan="{{ $row->spesifikasi }}" id="button_view_data" class="btn btn-success btn-sm">View</button>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                
                                                                </tr>
                                                                @endforelse               
                                                            </tbody>
                                                        </table>
                                                    <!--</div>-->
                                                    </div>
                                                    <br>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-8 mb-2">
                                                            <div class="input-group mb-3">
                                                                
                                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                                    <tbody>
                                                                        <?php $no=1 ?>
                                                                        @forelse ($approval_upload as $row)
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
                                                                        
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                
                                                            </div>
                                                        </div>
                
                                                        <div class="col-md-2 mb-2">
                                                            <label for="total" class="float-right" style="font-size:20px; ">Total Rp.</label>
                                                        </div>  
                                                        <div class="col-md-2 mb-2">
                                                            <input type="text" name="total_harga" id="total_harga" class="form-control" value="Rp. {{ number_format($pengajuan_biaya_detail_total) }}" style="text-align:right; font-style:bold;" required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <div class="input-group mb-3">
                                                                
                                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                                    <tbody>
                                                                        <?php $no=1 ?>
                                                                        @forelse ($pengajuan_biaya_upload as $row)
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
                                                                        
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                
                                                            </div>
                                                        </div>
                                                    </div>
                   
                                                    <div class="row">     
                                                        <div class="col-md-12 mb-2">
                                                            <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                            @if(Auth::user()->kode_divisi == '13') <!--SND-->
                                                                @if(Auth::user()->kode_sub_divisi == '12') <!--SSD-->
                                                                    @if($pengajuan_biaya_head->status_ssd  == '1') <!-- 2: approved -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                                        
                                                                    @elseif($pengajuan_biaya_head->status_ssd == '2') <!-- 3: denied -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                                        
                                                                    @elseif($pengajuan_biaya_head->status_ssd == '3') <!-- 4: Pending -->
                                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                            Approved
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                            Denied
                                                                        </button>
                                                                        
                                                                    @else
                                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                            Approved
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                            Denied
                                                                        </button>
                                                                        
                                                                    @endif
                                                                @elseif(Auth::user()->kode_sub_divisi == '16') <!--SOM-->
                                                                    @if($pengajuan_biaya_head->status_som  == '1') <!-- 2: approved -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                                        
                                                                    @elseif($pengajuan_biaya_head->status_som == '2') <!-- 3: denied -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Approve</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm" disabled>Denied</button>
                                                                        
                                                                    @elseif($pengajuan_biaya_head->status_som == '3') <!-- 4: Pending -->
                                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                            Approved
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                            Denied
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                            Approved
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                            Denied
                                                                        </button>
                                                                    @endif
                                                                @elseif(Auth::user()->kode_sub_divisi == '13') <!--ASM-->
                                                                    {{-- <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">Denied</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm">Approve</button> --}}
                                                                @else
                                                                    @if(Auth::user()->type == 'Admin')
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" hidden>Approve</button>
                                                                    @elseif(Auth::user()->type == 'Manager') <!--Manager SND-->
                                                                        @if($pengajuan_biaya_head->status_atasan  == '1') <!-- 2: approved -->
                                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm " disabled>Approve</button>
                                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm " disabled>Denied</button>
                                                                        @elseif($pengajuan_biaya_head->status_atasan == '2') <!-- 3: denied -->
                                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm " disabled>Approve</button>
                                                                            <button type="submit" id="savedatas" name="savedatas" class="btn btn-danger btn-sm " disabled>Denied</button>
                                                                        @elseif($pengajuan_biaya_head->status_atasan == '3') <!-- 4: Pending -->
                                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                                Approved
                                                                            </button>
                                                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                                Denied
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahPesan_approve">
                                                                                Approved
                                                                            </button>
                                                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTambahPesan_denied">
                                                                                Denied
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
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
                                                                    <form action="{{ route('pengajuan_tiv/update', $pengajuan_biaya_head->no_urut) }}" method="get">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required readonly>
                                                                            <label for="">keterangan</label>
                                                                            <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-success btn-sm float-right">S i m p a n</button>
                                                                    </form>
                                                                    <!--END FORM TAMBAH BARANG-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Isi untuk Keterangan..</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!--FORM TAMBAH BARANG-->
                                                                    <form action="{{ route('pengajuan_tiv/denied', $pengajuan_biaya_head->no_urut) }}" method="get">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required readonly>
                                                                            <label for="">keterangan</label>
                                                                            <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-danger btn-sm float-right">S i m p a n</button>
                                                                    </form>
                                                                    <!--END FORM TAMBAH BARANG-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>        
                                            
                                            <div class="tab-pane" id="detail" role="tabpanel">
                                                <br>
                                                <div class="table-responsive">
                                                <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                    <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                        <thead>
                                                            <tr style="background-color: blue;">
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
                                                        <tbody id="tabledata_outlet">
                                                            
                                                        </tbody>
                                                        <tfoot id="table_footer">

                                                        </tfoot>
                                                    </table>
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
                                <th >Qty</th>
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

<div class="modal fade bd-example-modal-lg" id="myModalCoa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" hidden>
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa" id="search_coa" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_coa" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Account Id</th>
                                <th>Account Name</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Daftar Claim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Area</th>
                            <th>Nama Toko</th>
                            <th>No Rekening</th>
                            <th>Bank</th>
                            <th>Pemilik</th>
                            <th>Qty</th>
                            <th>Reward</th>
                            <th>Total</th>
                            <th>Potongan</th>
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




