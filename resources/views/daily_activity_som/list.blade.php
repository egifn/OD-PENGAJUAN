
@extends('layouts.admin')

@section('style')
<style>
     .detail-row {
        background-color: #f8f9fa;
    }
    .btn-toggle {
        cursor: pointer;
    }
    .btn-toggle:focus {
        outline: none;
    }
    .table-sm td {
        padding: 0.3rem;
    }
</style>
@endsection
@section('title')
    <title>List Activity</title>
@endsection

@section('content')

<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Activity</li>
        <li class="breadcrumb-item active">List Activity</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row"> 
                <!-- TABLE LIST CATEGORY  -->
                <div class="col-md-12">
                    @if (session('success'))
                         <div class="alert alert-success">{{ session('success') }}</div>
                     @endif

                     @if (session('error'))
                         <div class="alert alert-danger">{{ session('error') }}</div>
                     @endif
                    <div class="card card-accent-primary">
                        <div class="card-header" style="padding: 5px 10px; display: flex; justify-content: space-between; align-items: center;">
                                <h4 class="card-title mb-0">List Activity</h4>
                                <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#createActivityModal">
                                    Buat Activity
                                </button>
                        </div>
                        <div class="card-body">
                            <form action="#" method="get">
                                <div class="input-group mb-3 col-md-4 float-right p-0   ">  
                                    <input type="text" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal }}">
                                    &nbsp
                                    <button class="btn btn-secondary" type="submit">C a r i</button>
                                </div>    
                            </form>

                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;"></th> 
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Area Tujuan</th>
                                            <th>Status</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1 ?>
                                        @forelse($structuredData as $activity)
                                        <!-- Main Row -->
                                        <tr class="main-row" data-id="{{ $activity['id'] }}">
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-toggle" data-id="{{ $activity['id'] }}" style="padding: 0 5px;">
                                                    <i class="fa fa-plus-circle"></i>
                                                </button>
                                            </td>
                                            <td>{{ $no }}</td>
                                            <td>{{ $activity['tanggal'] }}</td>
                                            <td>{{ $activity['area_name'] }}</td>
                                            <td>
                                                <span class="badge bg-{{ $activity['status'] == 1 ? 'success' : 'danger' }}">
                                                    {{ $activity['status'] == 1 ? 'Dilakukan' : 'Belum Dilakukan' }}
                                                </span>
                                            </td>
                                            <td>{{ $activity['status'] == 0 ? '-' : $activity['tanggal_selesai'] }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm btn-view-modal" style="padding: 1px 5px" data-id="{{ $activity['id'] }}">View</button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Detail Row - Awalnya hidden -->
                                        <tr class="detail-row" id="detail-{{ $activity['id'] }}" style="display: none;">
                                            <td colspan="7" class="p-0">
                                                <div class="p-2 bg-light">
                                                    <table class="table table-sm table-bordered mb-2">
                                                        <thead class="">
                                                            <tr>
                                                                <th>Depo</th>
                                                                <th>Challenge</th>
                                                                <th>Instruksi</th>
                                                                <th>Status</th>
                                                                <th>Tanggal Selesai</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(!empty($activity['depo']) && is_iterable($activity['depo']))
                                                                @foreach($activity['depo'] as $depo)
                                                                <tr>
                                                                    <td>{{ $depo['nama_depo'] }}</td>
                                                                    <td>{{ $depo['challenge'] }}</td>
                                                                    <td>{{ $depo['instruksi'] }}</td>
                                                                    <td>
                                                                        <span class="badge bg-{{ $depo['status'] == 1 ? 'success' : 'danger' }}">
                                                                            {{ $depo['status'] == 1 ? 'Dilakukan' : 'Belum Dilakukan' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ $depo['tanggal_selesai'] ?? '-' }}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-primary btn-sm btn-view-modal depo-modal" 
                                                                                style="padding: 1px 5px" 
                                                                                data-id="{{ $depo['id'] }}">
                                                                            View
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center">Tidak ada detail depo</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Detail Row - Akhir -->
                                        <?php $no++ ?>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data</td>
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
<!-- Modal View Activity -->
<div class="modal fade" id="viewActivityModal" tabindex="-1" role="dialog" aria-labelledby="viewActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewActivityModalLabel">Detail Activity ASM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-activity-content">
                    <div class="text-center">Loading...</div>
                </div>
                <div id="modal-activity-template" style="display:none">
                    <div class="row mb-2">
                        <div class="col-md-3 font-weight-bold">Sales Operation</div>
                        <div class="col-md-9 mb-2">
                            <textarea class="form-control form-control-sm" readonly rows="2" id="modal_instruksi"></textarea>
                        </div>
                        <div class="col-md-9 offset-md-3">
                            <input type="text" class="form-control form-control-sm" id="modal_catatan" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="daily-activity-slider">
                        <div class="slider-sections">
                            <!-- Section 1: Briefing -->
                            <div class="slider-section active">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">A. Briefing</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Peserta</label>
                                                    <input class="form-control" id="modal_peserta" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Program</label>
                                                    <input class="form-control" id="modal_program" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Target</label>
                                                    <input class="form-control" id="modal_target" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Performance/People</label>
                                                    <input class="form-control" id="modal_perform" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Operation (HH, Kendaraan, Gudang, Data, Aplikasi, Sistem)</label>
                                                    <input class="form-control" id="modal_operation" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Outlet</label>
                                                    <input class="form-control" id="modal_outlet" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keuangan</label>
                                                    <input class="form-control" id="modal_keuangan" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Other</label>
                                                    <input class="form-control" id="modal_other" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 2: Eksekusi -->
                            <div class="slider-section">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">B. Eksekusi</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Coaching</label>
                                                    <input class="form-control" id="modal_coaching" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Teguran</label>
                                                    <input class="form-control" id="modal_teguran" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Intruksi</label>
                                                    <input class="form-control" id="modal_intruksi" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Warning</label>
                                                    <input class="form-control" id="modal_warning" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Other</label>
                                                    <input class="form-control" id="modal_other_eksekusi" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 3: Kunjungan Outlet -->
                            <div class="slider-section">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">C. Kunjungan Outlet</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Channel</label>
                                                    <input class="form-control" id="modal_channel" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Toko</label>
                                                    <input class="form-control" id="modal_nama_toko" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Issue</label>
                                                    <input class="form-control" id="modal_issue" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Key Action</label>
                                                    <input class="form-control" id="modal_key_action" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 4: Join Visit -->
                            <div class="slider-section">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">D. Join Visit</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sales</label>
                                                    <input class="form-control" id="modal_sales" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Channel</label>
                                                    <input class="form-control" id="modal_channel_join" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Issue</label>
                                                    <input class="form-control" id="modal_issue_join" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Key Action</label>
                                                    <input class="form-control" id="modal_key_action_join" readonly>
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
    </div>
</div>

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
            <form action="{{ route('daily_activity_som.index') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly>
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
                                <label class="font-weight-bold">Nama Area Tujuan</label>
                                <select name="kode_area" id="kode_area" class="form-control" required>
                                    <option value="">Pilih</option>
                                    @foreach ($area as $row)
                                        <option value="{{ $row->id }}" {{ old('kode_area') == $row->id ? 'selected':'' }}>
                                            {{ $row->area_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3 font-weight-bold">Sales Operation</div>
                                <div class="col-md-9 font-weight-bold mb-2">
                                    <textarea name="key_challenge" id="key_challenge" rows="3" class="form-control form-control-sm" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
        $(document).ready(function() {
            // Date picker initialization
            $('#tanggal').daterangepicker({});

            // Modal view handler
            $('.btn-view-modal:not(.depo-modal)').click(function() {
                var id = $(this).data('id');
                $('#modal-activity-content').hide();
                $('#modal-activity-template').show();
                
                // Clear all fields first
                $('#modal_instruksi, #modal_catatan, #modal_peserta, #modal_program, #modal_target, #modal_perform, #modal_operation, #modal_outlet, #modal_keuangan, #modal_other, #modal_coaching, #modal_teguran, #modal_intruksi, #modal_warning, #modal_other_eksekusi, #modal_channel, #modal_nama_toko, #modal_issue, #modal_key_action, #modal_sales, #modal_channel_join, #modal_issue_join, #modal_key_action_join').val('');
                
                $('#viewActivityModal').modal('show');
                
                $.ajax({
                    url: "{{ route('daily_activity_som/detail') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        console.log(response); // For debugging
                        
                        // Fill header data
                        if (response.header) {
                            $('#modal_instruksi').val(response.header.instruksi || '');
                            $('#modal_catatan').val(response.header.catatan || '');
                        }
                        
                        // Fill answer data
                        if (response.answer) {
                            $('#modal_peserta').val(response.answer.peserta || '');
                            $('#modal_program').val(response.answer.program || '');
                            $('#modal_target').val(response.answer.target || '');
                            $('#modal_perform').val(response.answer.perform || '');
                            $('#modal_operation').val(response.answer.operation || '');
                            $('#modal_outlet').val(response.answer.outlet || '');
                            $('#modal_keuangan').val(response.answer.keuangan || '');
                            $('#modal_other').val(response.answer.other || '');
                            $('#modal_coaching').val(response.answer.coaching || '');
                            $('#modal_teguran').val(response.answer.teguran || '');
                            $('#modal_intruksi').val(response.answer.intruksi || '');
                            $('#modal_warning').val(response.answer.warning || '');
                            $('#modal_other_eksekusi').val(response.answer.other_eksekusi || '');
                            $('#modal_channel').val(response.answer.channel || '');
                            $('#modal_nama_toko').val(response.answer.nama_toko || '');
                            $('#modal_issue').val(response.answer.issue || '');
                            $('#modal_key_action').val(response.answer.key_action || '');
                            $('#modal_sales').val(response.answer.sales || '');
                            $('#modal_channel_join').val(response.answer.channel_join || '');
                            $('#modal_issue_join').val(response.answer.issue_join || '');
                            $('#modal_key_action_join').val(response.answer.key_action_join || '');
                        }
                        
                        // Show the template
                        $('#modal-activity-content').hide();
                        $('#modal-activity-template').show();
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        $('#modal-activity-content').show().html('<div class="alert alert-danger">Gagal mengambil data</div>');
                        $('#modal-activity-template').hide();
                    }
                });
            });
        });

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
<script>
      $(document).ready(function() {
        // Toggle detail rows
        $('.btn-toggle').click(function() {
            const id = $(this).data('id');
            const detailRow = $('#detail-' + id);
            const icon = $(this).find('i');
            
            detailRow.toggle();
            if (detailRow.is(':visible')) {
                icon.removeClass('fa-plus-circle').addClass('fa-minus-circle');
            } else {
                icon.removeClass('fa-minus-circle').addClass('fa-plus-circle');
            }
        });
    });
</script>
 @endsection