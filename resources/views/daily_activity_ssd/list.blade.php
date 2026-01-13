
@extends('layouts.admin')

@section('title')
    <title>List Activity</title>
@endsection

@section('content')


<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Activity</li>
        <li class="breadcrumb-item active">List Activity</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row justify-content-center">
                <div class=" col-md-12 mb-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card card-accent-primary shadow-sm">
                        <div class="card-header" style="padding: 5px 10px; display: flex; justify-content: space-between; align-items: center;">
                                <h4 class="card-title mb-0">List Activity</h4>
                                <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#createActivityModal">
                                    Buat Activity
                                </button>
                            </div>
                        <div class="card-body">
                            <form action="{{ route('pengajuan/cari.cari') }}" method="get" class="mb-3">
                                <div class="row justify-content-end">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}" placeholder="Cari tanggal...">
                                            <button class="btn btn-secondary" type="submit">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-hover table-sm align-middle" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th hidden>Id</th>
                                            <th>Tanggal</th>
                                            <th hidden>id_user</th>
                                            <th>Nama Depo Tujuan</th>
                                            <th>Challenge</th>
                                            <th>Status</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1 ?>
                                        @forelse($data as $val)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td hidden>{{ $val->id }}</td>
                                                <td>{{ $val->tanggal }}</td>
                                                <td hidden>{{ $val->id_user }}</td>
                                                <td>{{ $val->nama_depo }}</td>
                                                <td>{{ $val->challenge }}</td>
                                                <td>
                                                    <span class="badge rounded-pill bg-{{ $val->status == 1 ? 'success' : 'danger' }}">
                                                        {{ $val->status == 1 ? 'Dilakukan' : 'Belum Dilakukan' }}
                                                    </span>
                                                </td>
                                                <td>{{ $val->status == 0 ? '-' : $val->tanggal_selesai }}</td>
                                                <td>{{ $val->status == 0 ? '-' : $val->catatan }}</td>
                                                <td align="center">
                                                    @if(!empty($val->id))
                                                        <button type="button" class="btn btn-primary btn-sm btn-view-modal depo-modal" 
                                                                style="padding: 1px 5px" 
                                                                data-id="{{ $val->id  }}">
                                                            View
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="viewDepoModal" tabindex="-1" role="dialog" aria-labelledby="viewDepoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDepoModalLabel">Detail Depo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="depo-modal-content">
                    <div class="text-center">Loading...</div>
                </div>
                <div id="depo-modal-template" style="display:none">
                    <div class="form-group">
                        <label>Instruksi</label>
                        <input type="text" class="form-control" id="depo_instruksi" readonly>
                    </div>
                    <div class="form-group">
                        <label>Challenge</label>
                        <input type="text" class="form-control" id="depo_challenge" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" id="depo_status" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="text" class="form-control" id="depo_tanggal_selesai" readonly>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control" id="depo_catatan" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog" aria-labelledby="createActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 10px;">
                <h5 class="modal-title" id="createActivityModalLabel">Buat Activity Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <form action="{{ route('daily_activity_ssd/store.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                @csrf
                    <div class="row mb-4">
                        <input type="text" id="segment" name="segment" class="form-control bg-light" value="{{$data_users->segment}}" hidden>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control bg-light" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">Jabatan</label>
                                <input type="text" id="jabatan" name="jabatan" class="form-control bg-light" value="{{ $data_users->nama_divisi_sub }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal</label>
                                <input type="date" id="tgl" name="tgl" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Depo Tujuan</label>
                                <select name="kode_depo" id="kode_depo" class="form-control">
                                    <option value="">Pilih</option>
                                    @foreach ($depos as $row)
                                        <option value="{{ $row->kode_depo }}" {{ old('kode_depo') == $row->kode_depo ? 'selected':'' }}>{{ $row->nama_depo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Area</label>
                                <input type="text" id="area" name="area" class="form-control">
                            </div>
                        </div> -->
                    </div>

                    <hr class="my-4">

                    <div class="row mb-4">
                    <div class="col-md-12">
                        <!-- Sales Strategy Development Header -->
                        <div class="row mb-2">
                            <div class="col-md-4 font-weight-bold">Sales Strategy Development (Key Challenge per Channel)</div>
                        </div>
                        
                        @if(Auth::user()->id_segmen == '7' || Auth::user()->id_segmen == '10')
                        <!-- GT-SO -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-1">GT-SO</div>
                            <div class="col-md-11">
                                <textarea required name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                            </div>

                        </div>
                        @elseif(Auth::user()->id_segmen == '9')
                        <!-- GT-WS -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">GT-WS</div>
                            <div class="col-md-7">
                                <textarea required name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                            </div>

                        </div>
                        @elseif(Auth::user()->id_segmen == '6')
                        <!-- GT-R -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">GT-R</div>
                            <div class="col-md-7">
                                <textarea required name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                            </div>

                        </div>
                        @elseif(Auth::user()->id_segmen == '3')
                        <!-- NON GT-AHS -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">NON GT-AHS</div>
                            <div class="col-md-7">
                                <textarea required name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                            </div>

                        </div>
                        @elseif(Auth::user()->id_segmen == '4')
                        <!-- NON GT-IOD -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">NON GT-IOD</div>
                            <div class="col-md-7">
                                <textarea required name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                            </div>

                        </div>
                        @elseif(Auth::user()->id_segmen == '2')
                        <!-- NON GT-AFH -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">NON GT-AFH</div>
                            <div class="col-md-7">
                                <textarea required name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                            </div>

                        </div>
                        @elseif(Auth::user()->id_segmen == '5')
                        <!-- NON GT-MT -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">NON GT-MT</div>
                            <div class="col-md-7">
                                <textarea required name="challenge" id="challenge" rows="1" class="form-control form-control-sm"></textarea>
                            </div>

                        </div>
                        @endif
                    </div>
                </div>
                    <!-- Save Button (hidden until last section) -->
                    <div class="row mt-4 save-section">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>         
        $('.depo-modal').click(function() {
            // Modal view handler untuk data utama
            $('.btn-view-modal').click(function() {
                var id = $(this).data('id');
                var type = $(this).hasClass('depo-modal') ? 'depo' : 'main';
                
                if (type === 'main') {
                    // Handle modal utama
                    $('#modal-activity-content').hide();
                    $('#modal-activity-template').show();
                    $('#viewActivityModal').modal('show');
                    
                    // Kosongkan field
                    $('#modal_instruksi, #modal_catatan, #modal_peserta, #modal_program, #modal_target, #modal_perform, #modal_operation, #modal_outlet, #modal_keuangan, #modal_other, #modal_coaching, #modal_teguran, #modal_intruksi, #modal_warning, #modal_other_eksekusi, #modal_channel, #modal_nama_toko, #modal_issue, #modal_key_action, #modal_sales, #modal_channel_join, #modal_issue_join, #modal_key_action_join').val('');
                } else {
                    // Handle modal depo
                    $('#depo-modal-content').hide();
                    $('#depo-modal-template').show();
                    $('#viewDepoModal').modal('show');
                    
                    // Kosongkan field
                    $('#depo_instruksi, #depo_challenge, #depo_status, #depo_tanggal_selesai, #depo_catatan').val('');
                }

                $.ajax({
                    url: "{{ route('daily_activity_som/detail') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        type: type
                    },
                    success: function(response) {
                        if (response.type === 'main') {
                            // Isi modal utama
                            $('#modal_instruksi').val(response.header?.instruksi || '');
                            $('#modal_catatan').val(response.header?.catatan || '');
                            
                            var ans = response.answer || {};
                            $('#modal_peserta').val(ans.peserta || '');
                            // ... isi field lainnya ...
                            
                            $('#modal-activity-content').hide();
                            $('#modal-activity-template').show();
                        } else {
                            // Isi modal depo
                            $('#depo_instruksi').val(response.data?.instruksi || '');
                            $('#depo_challenge').val(response.data?.challenge || '');
                            $('#depo_status').val(response.data?.status || '');
                            $('#depo_tanggal_selesai').val(response.data?.tanggal_selesai || '');
                            $('#depo_catatan').val(response.data?.catatan || '');
                            
                            $('#depo-modal-content').hide();
                            $('#depo-modal-template').show();
                        }
                    },
                    error: function(xhr) {
                        if (type === 'main') {
                            $('#modal-activity-content').show().html('<div class="alert alert-danger">Gagal mengambil data</div>');
                            $('#modal-activity-template').hide();
                        } else {
                            $('#depo-modal-content').show().html('<div class="alert alert-danger">Gagal mengambil data depo</div>');
                            $('#depo-modal-template').hide();
                        }
                    }
                });
            });
        });      
    </script>



@endsection