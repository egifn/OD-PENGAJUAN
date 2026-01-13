@extends('layouts.admin')

@section('title')
    <title>List Activity KPJ</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Activity</li>
        <li class="breadcrumb-item active">List Activity KPJ</li>
    </ol>
    
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <div class="card card-accent-primary">
                        <div class="card-header" style="padding: 6px 10px; display: flex; justify-content: space-between; align-items: center;">
                            <h4 class="card-title mb-0">List Activity KPJ</h4>
                        </div>
                        <div class="card-body">
                            <form action="#" method="get">
                                <div class="input-group mb-3 col-md-4 float-right" style="padding: 0">  
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ request()->tanggal ?? date('Y-m-d') }}" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Cari</button>
                                    </div>
                                </div>    
                            </form>
                            <div class="table-responsive">
                                <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Depo</th>
                                            <th>Intruksi</th>
                                            <th>Status</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data as $val)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $val['tanggal'] ?? '-' }}</td>
                                            <td>{{ $val['name'] ?? '-' }}</td>
                                            <td>{{ $val['jabatan'] ?? '-' }}</td>
                                            <td>{{ $val['nama_depo'] ?? '-' }}</td>
                                            <td class="limit-words" data-full-text="{{ $val['instruksi'] ?? '-' }}">{{ $val['instruksi'] ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $val['status'] == 1 ? 'success' : 'danger' }}">
                                                    {{ $val['status'] == 1 ? 'Dilakukan' : 'Belum Dilakukan' }}
                                                </span>
                                            </td>
                                            <td>{{ $val['status'] == 0 ? '-' : ($val['tanggal_selesai'] ?? '-') }}</td>
                                            <td class="text-center">
                                                @if($val['status'] == 0)
                                                    <button class="btn btn-primary btn-sm btn-jawab" 
                                                        data-id="{{ $val['id'] }}"
                                                        data-kode_depo="{{ $val['kode_depo'] }}"
                                                        data-instruction="{{ $val['instruksi'] ?? '' }}"
                                                        data-depo='@json($val['depo'])'
                                                        data-route="{{ route('daily_activity_kpj.store') }}">
                                                        Jawab 
                                                    </button>
                                                @else
                                                    <button class="btn btn-primary btn-sm btn-view-modal" 
                                                        data-id="{{ $val['id'] }}"
                                                        data-depo='@json($val['depo'])'>
                                                        View 
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data</td>
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

<!-- Modal Form Jawab -->
<div class="modal fade" id="jawabModal" tabindex="-1" role="dialog" aria-labelledby="jawabModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jawabModalLabel">Form Jawaban Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="jawabForm" method="POST">
                @csrf
                <input type="hidden" name="id_instruksi" id="id_instruksi">
                <input type="hidden" name="kode_depo" id="kode_depo">
                <div class="modal-body">
                    <div class="mb-2">
                        <div class="col-md-3 mb-2 font-weight-bold">Sales Operation</div>
                        <div class="col-md-12 mb-2">
                            <textarea class="form-control form-control-sm" readonly id="display_instruksi" rows="2" >{{ $val['instruksi'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="catatan" class="form-control form-control-sm" id="modal_catatan" placeholder="Tambahkan catatan...">
                        </div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <div class="col-md-3 font-weight-bold">Key Challenge</div>
                        <div class="col-md-12 mb-2" id="challenge-container">
                            <!-- Dynamic content will be inserted here -->
                        </div>
                    </div>
                    <hr>
                    <div class="daily-activity-slider">
                        <!-- Slider Sections -->
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
                                                    <input name="peserta" id="peserta" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Program</label>
                                                    <input name="program" id="program" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Target</label>
                                                    <input name="target" id="target" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Performance/People</label>
                                                    <input name="perform" id="pp" class="form-control required-field">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Operation (HH, Kendaraan, Gudang, Data, Aplikasi, Sistem)</label>
                                                    <input name="operation" id="opr" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Outlet</label>
                                                    <input name="outlet" id="outlet" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Keuangan</label>
                                                    <input name="keuangan" id="keuangan" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Other</label>
                                                    <input name="other" id="other" class="form-control">
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
                                                    <input name="coaching" id="coaching" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Teguran</label>
                                                    <input name="teguran" id="teguran" class="form-control required-field">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Intruksi</label>
                                                    <input name="intruksi" id="intruksi" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Warning</label>
                                                    <input name="warning" id="warning" class="form-control required-field">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Other</label>
                                                    <input name="other_eksekusi" id="other_eksekusi" class="form-control">
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
                                                    <input name="channel" id="channel" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Toko</label>
                                                    <input name="nama_toko" id="nama_toko" class="form-control required-field">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Issue</label>
                                                    <input name="issue" id="issue" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Key Action</label>
                                                    <input name="key_action" id="key_action" class="form-control required-field">
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
                                                    <input name="sales" id="sales" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Channel</label>
                                                    <input name="channel_join" id="channel_join" class="form-control required-field">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Issue</label>
                                                    <input name="issue_join" id="issue_join" class="form-control required-field">
                                                </div>
                                                <div class="form-group">
                                                    <label>Key Action</label>
                                                    <input name="key_action_join" id="key_action_join" class="form-control required-field">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- Slider Navigation -->
                         <div class="slider-nav mb-2 mt-4" style="display: flex;justify-content: center;align-items: center;">
                            <button type="button" class="btn btn-outline-primary prev-btn" disabled>&laquo; Previous</button>
                            <span class="mx-2 current-section">1/4</span>
                            <button type="button" class="btn btn-outline-primary next-btn">Next &raquo;</button>
                        </div>
                        
                        <!-- Save Button (hidden until last section) -->
                        <div class="row mt-4 save-section" style="display: none;">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View Activity -->
<div class="modal fade" id="viewActivityModal" tabindex="-1" role="dialog" aria-labelledby="viewActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewActivityModalLabel">Detail Activity KPJ</h5>
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
                            <input type="text" class="form-control form-control-sm" id="modal_catatan_view" readonly>
                        </div>
                    </div>
                    <div class="rowmb-2">
                        <div class="col-md-3 font-weight-bold">Key Challenge</div>
                        <div class="col-md-12 mb-2" id="challenge-container-view">
                            <!-- Dynamic content will be inserted here -->
                        </div>
                    </div>
                    <hr>
                    <div class="daily-activity-slider">
                        <div class="slider-view-sections">
                            <!-- Section 1: Briefing -->
                            <div class="slider-view-section active">
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
                            <div class="slider-view-section">
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
                            <div class="slider-view-section">
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
                            <div class="slider-view-section">
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

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

{{-- Tools --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.limit-words').forEach(element => {
            const fullText = element.getAttribute('data-full-text');
            const words = fullText.split(' ');
            if (words.length > 5) {
                element.textContent = words.slice(0, 5).join(' ') + '...';
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Handle Jawab button click
        $('.btn-jawab').click(function() {
            const id = $(this).data('id');
            const kode_depo = $(this).data('kode_depo');
            const instruction = $(this).data('instruction');
            const formAction = $(this).data('route');
            let depoData = $(this).data('depo');

            console.log('Data Jawab');
            console.log(depoData);


            // Set form action and hidden fields
            $('#jawabForm').attr('action', formAction);
            $('#id_instruksi').val(id);
            $('#kode_depo').val(kode_depo);
            $('#display_instruksi').text(instruction);

            // Handle depo data - tidak perlu parse jika sudah object
            
            // Jika depoData adalah string, parse ke JSON
            if (typeof depoData === 'string') {
                try {
                    depoData = JSON.parse(depoData);
                } catch (e) {
                    console.error('Error parsing depo data:', e);
                    depoData = [];
                }
            }
            
            const container = $('#challenge-container').empty();
            if (depoData && depoData.length > 0) {

                 container.append(`
                    <div class="row mb-2 mt-2">
                        <div class="col-md-4">Channel Segment</div>
                        <div class="col-md-4">Instruksi</div>
                        <div class="col-md-4">Catatan</div>
                    </div>
                `);
                depoData.forEach((depo, index) => {
                    container.append(`
                        <div class="row mb-3 mt-2">
                            <div class="col-md-4">
                                <textarea class="form-control form-control-sm mb-1" readonly>${depo.challenge || ''}</textarea>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control form-control-sm mb-1" readonly>${depo.instruksi || ''}</textarea>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="ssd[${index}][id]" value="${depo.id || ''}">
                                <input type="hidden" name="ssd[${index}][depo]" value="${depo.kode_depo || depo.depo || ''}">
                                <input type="hidden" name="ssd[${index}][tanggal]" value="${depo.tanggal || depo.tanggal || ''}">
                                <input type="text" name="ssd[${index}][catatan]" class="form-control form-control-sm" 
                                    placeholder="Tambahkan catatan..." style="height: 40px;" 
                                    value="${depo.catatan || ''}">
                            </div>
                        </div>
                    `);
                });
            } else {
                container.append('<p>Tidak ada data depo</p>');
            }
            
            // Reset form and show first section
            resetForm();
            showSection(0);
            $('#jawabModal').modal('show');
        });

        // Form submission handler
       $('#jawabForm').submit(function(e) {
            e.preventDefault();
            
            if (validateCurrentSection()) {
                const formData = $(this).serialize();
                
                $.ajax({
                    url: $(this).attr('action'), // Pastikan ini mengarah ke route yang benar
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#jawabModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                    }
                });
            }
        });

        // Slider navigation
        let currentSection = 0;
        const sections = $('.slider-section');
        const totalSections = sections.length;
        
        // Next button
        $('.next-btn').click(function() {
            if (validateCurrentSection()) {
                currentSection++;
                showSection(currentSection);
            }
        });
        
        // Previous button
        $('.prev-btn').click(function() {
            currentSection--;
            showSection(currentSection);
        });
        
        function showSection(index) {
            // Hide all sections
            sections.removeClass('active').hide();
            
            // Show current section
            $(sections[index]).addClass('active').show();
            
            // Update navigation buttons
            $('.prev-btn').prop('disabled', index === 0);
            $('.next-btn').toggle(index < totalSections - 1);
            $('.save-section').toggle(index === totalSections - 1);
            
            // Update section indicator
            $('.current-section').text(`${index + 1}/${totalSections}`);
        }
        
        function validateCurrentSection() {
            let isValid = true;
            $(sections[currentSection]).find('.required-field').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Harap isi semua field yang wajib diisi');
            }
            
            return isValid;
        }
        
        function resetForm() {
            // Reset all form fields
            $('#jawabForm')[0].reset();
            
            // Reset section navigation
            currentSection = 0;
            $('.prev-btn').prop('disabled', true);
            $('.next-btn').show();
            $('.save-section').hide();
            $('.current-section').text('1/' + totalSections);
        }
    });
    
    $(document).ready(function() {
        // Modal view handler
        $('.btn-view-modal').click(function() {
            var id = $(this).data('id');
            let depoData = $(this).data('depo');

            console.log('Depo Data View:', depoData);
            console.log('Depo id:', id);
            
            $('#modal-activity-content').show().html('<div class="text-center">Loading...</div>');
            $('#modal-activity-template').hide();
            $('#viewActivityModal').modal('show');
            // Kosongkan semua field modal
            $('#modal_instruksi, #modal_catatan_view, #modal_peserta, #modal_program, #modal_target, #modal_perform, #modal_operation, #modal_outlet, #modal_keuangan, #modal_other, #modal_coaching, #modal_teguran, #modal_intruksi, #modal_warning, #modal_other_eksekusi, #modal_channel, #modal_nama_toko, #modal_issue, #modal_key_action, #modal_sales, #modal_channel_join, #modal_issue_join, #modal_key_action_join').val('');
            
            // Jika depoData adalah string, parse ke JSON
            if (typeof depoData === 'string') {
                try {
                    depoData = JSON.parse(depoData);
                } catch (e) {
                    console.error('Error parsing depo data:', e);
                    depoData = [];
                }
            }
            
            const container = $('#challenge-container-view').empty();
            if (depoData && depoData.length > 0) {

                 container.append(`
                    <div class="row mb-2 mt-2">
                        <div class="col-md-4">Channel Segment</div>
                        <div class="col-md-4">Instruksi</div>
                        <div class="col-md-4">Catatan</div>
                    </div>
                `);
                depoData.forEach((depo, index) => {
                    container.append(`
                        <div class="row mb-3 mt-2">
                            <div class="col-md-4">
                                <textarea class="form-control form-control-sm mb-1" readonly>${depo.challenge || ''}</textarea>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control form-control-sm mb-1" readonly>${depo.instruksi || ''}</textarea>
                            </div>
                            <div class="col-md-4">
                                <textarea class="form-control form-control-sm mb-1" readonly>${depo.catatan || ''}</textarea>
                            </div>
                            
                        </div>
                    `);
                });
            } else {
                container.append('<p>Tidak ada data depo</p>');
            }

            $.ajax({
                url: "{{ route('daily_activity_kpj/detail') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    // Pastikan response sesuai struktur
                    var header = response.header || response;
                    var answer = response.answer || response;

                    $('#modal_instruksi').val(header.instruksi || '');
                    $('#modal_catatan_view').val(header.catatan || '');

                    $('#modal_peserta').val(answer.peserta || '');
                    $('#modal_program').val(answer.program || '');
                    $('#modal_target').val(answer.target || '');
                    $('#modal_perform').val(answer.perform || '');
                    $('#modal_operation').val(answer.operation || '');
                    $('#modal_outlet').val(answer.outlet || '');
                    $('#modal_keuangan').val(answer.keuangan || '');
                    $('#modal_other').val(answer.other || '');
                    $('#modal_coaching').val(answer.coaching || '');
                    $('#modal_teguran').val(answer.teguran || '');
                    $('#modal_intruksi').val(answer.intruksi || '');
                    $('#modal_warning').val(answer.warning || '');
                    $('#modal_other_eksekusi').val(answer.other_eksekusi || '');
                    $('#modal_channel').val(answer.channel || '');
                    $('#modal_nama_toko').val(answer.nama_toko || '');
                    $('#modal_issue').val(answer.issue || '');
                    $('#modal_key_action').val(answer.key_action || '');
                    $('#modal_sales').val(answer.sales || '');
                    $('#modal_channel_join').val(answer.channel_join || '');
                    $('#modal_issue_join').val(answer.issue_join || '');
                    $('#modal_key_action_join').val(answer.key_action_join || '');

                    $('#modal-activity-content').hide();
                    $('#modal-activity-template').show();
                },
                error: function(xhr) {
                    $('#modal-activity-content').show().html('<div class="alert alert-danger">Gagal mengambil data</div>');
                    $('#modal-activity-template').hide();
                }
            });
        });
    });

</script>
@endsection