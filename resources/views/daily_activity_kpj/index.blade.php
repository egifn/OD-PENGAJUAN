@extends('layouts.admin')

@section('style')
<style>
    .check-box {
        display: flex;
        left: 10px;
        align-items: center;
        justify-content: center;
    }
    .slider-section {
        display: none;
        animation: fadeIn 0.5s;
    }
    .slider-section.active {
        display: block;
    }
    .slider-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px 0;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    /* Add button styling to prevent default form submission */
    .slider-nav button {
        cursor: pointer;
        margin: 0 5px;
    }
    .required-field:invalid {
        border-color: #dc3545;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 80%;
        display: none;
    }
    .required-field:invalid + .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('title')
    <title>Daily Activity</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Daily Activity</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Daily Activity Report</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('daily_activity_kpj.store') }}" method="post" id="dailyActivityForm" enctype="multipart/form-data">
                            @csrf
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal</label>
                                            <input type="text" id="tgl" name="tgl" class="form-control bg-light" value="{{ date('d-M-Y', strtotime(Carbon\Carbon::today()->toDateString())) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Depo</label>
                                            <input type="text" id="depo" name="depo" class="form-control bg-light"
                                            value="{{ $data_users->nama_depo ?? ($data_users[0]->nama_depo ?? '') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Area</label>
                                            <input type="text" id="area" name="area" class="form-control bg-light"
                                            value="{{ $data_users->area_name ?? ($data_users[0]->area_name ?? '') }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jabatan</label>
                                            <input type="text" id="jabatan" name="jabatan" class="form-control bg-light"
                                            value="{{ $data_users->nama_divisi_sub ?? ($data_users[0]->nama_divisi_sub ?? '') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama</label>
                                            <input type="text" id="nama" name="nama" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h5 class="text-primary mb-3">Sales Operation</h5>
                                        
                                        <!-- Sales Strategy Development Header -->
                                        <div class="row mb-2">
                                            <div class="col-md-3 font-weight-bold">Sales Operation</div>
                                            <div class="col-md-9 font-weight-bold mb-3">
                                                <textarea name="key_challenge" id="key_challenge" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            
                                            <div class="col-md-3 font-weight-bold">Sales Strategy Development</div>
                                            <div class="col-md-3 font-weight-bold">Key Challenge per Channel</div>
                                            <div class="col-md-3 font-weight-bold text-center">Key Challenge</div>
                                            <div class="col-md-1 font-weight-bold text-center">Check</div>
                                            <div class="col-md-2 font-weight-bold text-center">Key Action</div>
                                        </div>
                                        
                                        <!-- GT-SO -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">GT-SO</div>
                                            <div class="col-md-3">
                                                <textarea name="gt_so1" id="gt_so1" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            <div class="col-md-1 check-box">
                                                <input type="checkbox" name="chk1" value="1" class="form-check-input">
                                            </div>
                                            <div class="col-md-2">
                                                <textarea name="gt_so2" id="gt_so2" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                        </div>
                                        
                                        <!-- GT-WS -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">GT-WS</div>
                                            <div class="col-md-3">
                                                <textarea name="gt_ws1" id="gt_ws1" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            <div class="col-md-1 check-box">
                                                <input type="checkbox" name="chk2" value="1" class="form-check-input">
                                            </div>
                                            <div class="col-md-2">
                                                <textarea name="gt_ws2" id="gt_ws2" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                        </div>
                                        
                                        <!-- GT-R -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">GT-R</div>
                                            <div class="col-md-3">
                                                <textarea name="gt_r1" id="gt_r1" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            <div class="col-md-1 check-box">
                                                <input type="checkbox" name="chk3" value="1" class="form-check-input">
                                            </div>
                                            <div class="col-md-2">
                                                <textarea name="gt_r2" id="gt_r2" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                        </div>
                                        
                                        <!-- NON GT-AHS -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">GT-AHS</div>
                                            <div class="col-md-3">
                                                <textarea name="gt_ahs1" id="gt_ahs1" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            <div class="col-md-1 check-box">
                                                <input type="checkbox" name="chk4" value="1" class="form-check-input">
                                            </div>
                                            <div class="col-md-2">
                                                <textarea name="gt_ahs2" id="gt_ahs2" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                        </div>
                                        
                                        <!-- NON GT-IOD -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">GT-IOD</div>
                                            <div class="col-md-3">
                                                <textarea name="gt_iod1" id="gt_iod1" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            <div class="col-md-1 check-box">
                                                <input type="checkbox" name="chk5" value="1" class="form-check-input">
                                            </div>
                                            <div class="col-md-2">
                                                <textarea name="gt_iod2" id="gt_iod2" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                        </div>
                                        
                                        <!-- NON GT-AFH -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">GT-AFH</div>
                                            <div class="col-md-3">
                                                <textarea name="gt_afh1" id="gt_afh1" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            <div class="col-md-1 check-box">
                                                <input type="checkbox" name="chk6" value="1" class="form-check-input">
                                            </div>
                                            <div class="col-md-2">
                                                <textarea name="gt_afh2" id="gt_afh2" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                        </div>
                                        
                                        <!-- NON GT-MT -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">GT-MT</div>
                                            <div class="col-md-3">
                                                <textarea name="gt_mt1" id="gt_mt1" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                            <div class="col-md-1 check-box">
                                                <input type="checkbox" name="chk7" value="1" class="form-check-input">
                                            </div>
                                            <div class="col-md-2">
                                                <textarea name="gt_mt2" id="gt_mt2" rows="1" class="form-control form-control-sm required-field"></textarea>
                                                <div class="invalid-feedback">Field ini wajib diisi</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="daily-activity-slider">
                                <!-- Slider Navigation -->
                                <div class="slider-nav">
                                    <button type="button" class="btn btn-outline-primary prev-btn" disabled>&laquo; Previous</button>
                                    <span class="mx-2 current-section">1/4</span>
                                    <button type="button" class="btn btn-outline-primary next-btn">Next &raquo;</button>
                                </div>
                                
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
                                                            <textarea name="peserta" id="peserta" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Program</label>
                                                            <textarea name="program" id="program" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Target</label>
                                                            <textarea name="target" id="target" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Performance/People</label>
                                                            <textarea name="pp" id="pp" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Operation (HH, Kendaraan, Gudang, Data, Aplikasi, Sistem)</label>
                                                            <textarea name="opr" id="opr" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Outlet</label>
                                                            <textarea name="outlet" id="outlet" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keuangan</label>
                                                            <textarea name="keuangan" id="keuangan" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Other</label>
                                                            <textarea name="other" id="other" rows="1" class="form-control"></textarea>
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
                                                            <textarea name="coaching" id="coaching" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Teguran</label>
                                                            <textarea name="teguran" id="teguran" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Intruksi</label>
                                                            <textarea name="intruksi" id="intruksi" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Warning</label>
                                                            <textarea name="warning" id="warning" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Other</label>
                                                            <textarea name="other_eksekusi" id="other_eksekusi" rows="1" class="form-control"></textarea>
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
                                                            <textarea name="channel" id="channel" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Toko</label>
                                                            <textarea name="nama_toko" id="nama_toko" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Issue</label>
                                                            <textarea name="issue" id="issue" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Key Action</label>
                                                            <textarea name="key_action" id="key_action" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
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
                                                            <textarea name="sales" id="sales" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Channel</label>
                                                            <textarea name="channel_join" id="channel_join" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Issue</label>
                                                            <textarea name="issue_join" id="issue_join" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Key Action</label>
                                                            <textarea name="key_action_join" id="key_action_join" rows="1" class="form-control required-field"></textarea>
                                                            <div class="invalid-feedback">Field ini wajib diisi</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Save Button (hidden until last section) -->
                                <div class="row mt-4 save-section" style="display: none;">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            </form>                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                   
</main>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(document).ready(function() {
    // Initialize datepicker
    $('#tanggal').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        locale: {
            format: 'DD-MMM-YYYY'
        }
    });

    // Slider functionality
    const sections = $('.slider-section');
    const totalSections = sections.length;
    let currentSection = 0;
    
    // Initialize first section
    updateNavigation();
    
    // Next button click
    $('.next-btn').click(function(e) {
        e.preventDefault();
        
        // Validate current section
        let isValid = true;
        $(sections[currentSection]).find('.required-field').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (isValid) {
            $(sections[currentSection]).removeClass('active');
            currentSection++;
            $(sections[currentSection]).addClass('active');
            updateNavigation();
        } else {
            alert('Harap isi semua kolom yang diperlukan di bagian ini sebelum melanjutkan.');
        }
    });
    
    // Previous button click
    $('.prev-btn').click(function(e) {
        e.preventDefault();
        $(sections[currentSection]).removeClass('active');
        currentSection--;
        $(sections[currentSection]).addClass('active');
        updateNavigation();
    });
    
    // Update navigation buttons
    function updateNavigation() {
        $('.current-section').text(`${currentSection + 1}/${totalSections}`);
        
        // Update previous button
        $('.prev-btn').prop('disabled', currentSection === 0);
        
        // Update next/save buttons
        if (currentSection === totalSections - 1) {
            $('.next-btn').hide();
            $('.save-section').show();
        } else {
            $('.next-btn').show();
            $('.save-section').hide();
        }
    }
    
    // Remove validation error when user starts typing
    $('.required-field').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
        }
    });

    // Form validation
    $("#dailyActivityForm").validate({
        rules: {
            key_challenge: "required",
            gt_so1: "required",
            gt_so2: "required",
            gt_ws1: "required",
            gt_ws2: "required",
            gt_r1: "required",
            gt_r2: "required",
            gt_ahs1: "required",
            gt_ahs2: "required",
            gt_iod1: "required",
            gt_iod2: "required",
            gt_afh1: "required",
            gt_afh2: "required",
            gt_mt1: "required",
            gt_mt2: "required",
            peserta: "required",
            program: "required",
            target: "required",
            pp: "required",
            opr: "required",
            outlet: "required",
            keuangan: "required",
            coaching: "required",
            teguran: "required",
            intruksi: "required",
            warning: "required",
            channel: "required",
            nama_toko: "required",
            issue: "required",
            key_action: "required",
            sales: "required",
            channel_join: "required",
            issue_join: "required",
            key_action_join: "required"
        },
        messages: {
            key_challenge: "Field ini wajib diisi",
            gt_so1: "Field ini wajib diisi",
            gt_so2: "Field ini wajib diisi",
            gt_ws1: "Field ini wajib diisi",
            gt_ws2: "Field ini wajib diisi",
            gt_r1: "Field ini wajib diisi",
            gt_r2: "Field ini wajib diisi",
            gt_ahs1: "Field ini wajib diisi",
            gt_ahs2: "Field ini wajib diisi",
            gt_iod1: "Field ini wajib diisi",
            gt_iod2: "Field ini wajib diisi",
            gt_afh1: "Field ini wajib diisi",
            gt_afh2: "Field ini wajib diisi",
            gt_mt1: "Field ini wajib diisi",
            gt_mt2: "Field ini wajib diisi",
            peserta: "Field ini wajib diisi",
            program: "Field ini wajib diisi",
            target: "Field ini wajib diisi",
            pp: "Field ini wajib diisi",
            opr: "Field ini wajib diisi",
            outlet: "Field ini wajib diisi",
            keuangan: "Field ini wajib diisi",
            coaching: "Field ini wajib diisi",
            teguran: "Field ini wajib diisi",
            intruksi: "Field ini wajib diisi",
            warning: "Field ini wajib diisi",
            channel: "Field ini wajib diisi",
            nama_toko: "Field ini wajib diisi",
            issue: "Field ini wajib diisi",
            key_action: "Field ini wajib diisi",
            sales: "Field ini wajib diisi",
            channel_join: "Field ini wajib diisi",
            issue_join: "Field ini wajib diisi",
            key_action_join: "Field ini wajib diisi"
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
@endsection