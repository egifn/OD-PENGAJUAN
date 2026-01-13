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
    <script>
        $(document).ready(function() {
            const sections = $('.slider-section');
            const totalSections = sections.length;
            let currentSection = 0;
            
            // Initialize first section
            updateNavigation();
            
            // Next button click - prevent form submission
            $('.next-btn').click(function(e) {
                e.preventDefault(); // Add this line to prevent form submission
                if (validateCurrentSection()) {
                    $(sections[currentSection]).removeClass('active');
                    currentSection++;
                    $(sections[currentSection]).addClass('active');
                    updateNavigation();
                } else {
                    alert('Please fill all required fields in this section before proceeding.');
                }
            });
            
            // Previous button click - prevent form submission
            $('.prev-btn').click(function(e) {
                e.preventDefault(); // Add this line to prevent form submission
                $(sections[currentSection]).removeClass('active');
                currentSection--;
                $(sections[currentSection]).addClass('active');
                updateNavigation();
            });
            
            // Update navigation buttons
            function updateNavigation() {
                $('.current-section').text(`${currentSection + 1}/${totalSections}`);
                
                // Update previous button
                if (currentSection === 0) {
                    $('.prev-btn').prop('disabled', true);
                } else {
                    $('.prev-btn').prop('disabled', false);
                }
                
                // Update next button
                if (currentSection === totalSections - 1) {
                    $('.next-btn').hide();
                    $('.save-section').show();
                } else {
                    $('.next-btn').show();
                    $('.save-section').hide();
                }
            }
            
            // Validate current section
            function validateCurrentSection() {
                let isValid = true;
                $(sections[currentSection]).find('.required-field').each(function() {
                    if ($(this).val().trim() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                return isValid;
            }
            
            // Remove validation error when user starts typing
            $('.required-field').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
@stop

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
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        /* Add button styling to prevent default form submission */
        .slider-nav button {
            cursor: pointer;
        }
    </style>
@stop

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
                            <form action="{{ route('daily_activity_asm/update.update') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama</label>
                                            <input type="text" id="nama" name="input" class="form-control bg-light" value="{{Auth::user()->name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jabatan</label>
                                            <input type="text" id="jabatan" name="input" class="form-control bg-light" value="{{ $data_users->nama_divisi_sub }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4" hidden>
                                        <div class="form-group">
                                            <label class="font-weight-bold">Id</label>
                                            <input type="text" id="id" name="input" class="form-control bg-light" value="{{ $data_view->id_activity }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal</label>
                                            <input type="text" id="tgl" name="input" class="form-control bg-light" value="{{ $data_view->tanggal }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="row mb-2">
                                        <div class="col-md-3 font-weight-bold">Sales Operation</div>
                                        <div class="col-md-9 font-weight-bold mb-3"><input name="input"  rows="1" class="form-control form-control-sm" readonly value="{{ $data_view->instruksi }}"></div>
                                        <div class="col-md-9 font-weight-bold mb-3"><input name="input" id="key_challenge" rows="1" class="form-control form-control-sm" readonly></div>
                                        
                                        <div class="col-md-3 font-weight-bold">Sales Strategy Development</div>
                                        <div class="col-md-3 font-weight-bold">Key Challenge per Channel</div>
                                        <div class="col-md-3 font-weight-bold" style="text-align: center">Key Challenge</div>
                                        <div class="col-md-1 font-weight-bold text-center"  style="text-align: center">Check</div>
                                        <div class="col-md-2 font-weight-bold" style="text-align: center">Key Action</div>
                                    </div>
                                <div class="daily-activity-slider">
                                <!-- Slider Navigation -->
                                <div class="slider-nav mb-4">
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
                                                            <input name="input" id="peserta" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Program</label>
                                                            <input name="input" id="program" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Target</label>
                                                            <input name="input" id="target" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Performance/People</label>
                                                            <input name="input" id="pp" rows="1" class="form-control required-field">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Operation (HH, Kendaraan, Gudang, Data, Aplikasi, Sistem)</label>
                                                            <input name="input" id="opr" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Outlet</label>
                                                            <input name="input" id="outlet" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keuangan</label>
                                                            <input name="input" id="keuangan" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Other</label>
                                                            <input name="input" id="other" rows="1" class="form-control">
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
                                                            <input name="input" id="coaching" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Teguran</label>
                                                            <input name="input" id="teguran" rows="1" class="form-control required-field">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Intruksi</label>
                                                            <input name="input" id="intruksi" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Warning</label>
                                                            <input name="input" id="warning" rows="1" class="form-control required-field">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Other</label>
                                                            <input name="input" id="other_eksekusi" rows="1" class="form-control">
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
                                                            <input name="input" id="channel" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Toko</label>
                                                            <input name="input" id="nama_toko" rows="1" class="form-control required-field">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Issue</label>
                                                            <input name="input" id="issue" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Key Action</label>
                                                            <input name="input" id="key_action" rows="1" class="form-control required-field">
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
                                                            <input name="input" id="sales" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Channel</label>
                                                            <input name="input" id="channel_join" rows="1" class="form-control required-field">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Issue</label>
                                                            <input name="input" id="issue_join" rows="1" class="form-control required-field">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Key Action</label>
                                                            <input name="input" id="key_action_join" rows="1" class="form-control required-field">
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
                                        <button class="btn btn-primary px-4">Simpan</button>
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