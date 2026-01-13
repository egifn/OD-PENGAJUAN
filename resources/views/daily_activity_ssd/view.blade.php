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
                            <form action="#" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
                            @csrf
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama</label>
                                            <input type="text" id="nama" name="nama" class="form-control bg-light" value="{{Auth::user()->name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jabatan</label>
                                            <input type="text" id="jabatan" name="jabatan" class="form-control bg-light" value="{{ $data_view->jabatan }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal</label>
                                            <input type="text" id="tgl" name="tgl" class="form-control bg-light" value="{{ $data_view->tanggal }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Depo Tujuan</label>
                                            <input type="text" id="depo" name="depo" class="form-control bg-light" value="{{ $data_view->nama_depo }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                              <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="text-primary mb-3">Sales Operation</h5>
                                    
                                    <!-- Sales Strategy Development Header -->
                                    <div class="row mb-2">
                                        <!-- <div class="col-md-6 font-weight-bold"></div> -->
                                        <div class="col-md-3 font-weight-bold">Sales Operation</div>
                                        <div class="col-md-9 font-weight-bold mb-3"><textarea name="key_challenge" id="key_challenge" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->key_challenge }}</textarea></div>
                                        
                                        <div class="col-md-3 font-weight-bold">Sales Strategy Development</div>
                                        <div class="col-md-3 font-weight-bold">Key Challenge per Channel</div>
                                        <div class="col-md-3 font-weight-bold" style="text-align: center">Key Challenge</div>
                                        <div class="col-md-1 font-weight-bold text-center"  style="text-align: center">Check</div>
                                        <div class="col-md-2 font-weight-bold" style="text-align: center">Key Action</div>
                                    </div>
                                    
                                    <!-- GT-SO -->
                                    @if(Auth::user()->id_segmen == '7' || Auth::user()->id_segmen == '10')
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-SO</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_so1" id="gt_so1" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_so_challenge }}</textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk1" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_so2" id="gt_so2" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_so_action }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- GT-WS -->
                                    @elseif(Auth::user()->id_segmen == '9')
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-WS</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_ws1" id="gt_ws1" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_ws_challenge }}</textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk2" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_ws2" id="gt_ws2" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_ws_action }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- GT-R -->
                                    @elseif(Auth::user()->id_segmen == '6')
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-R</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_r1" id="gt_r1" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_r_challenge }}</textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk3" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_r2" id="gt_r2" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_r_action }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-AHS -->
                                    @elseif(Auth::user()->id_segmen == '3')
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-AHS</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_ahs1" id="gt_ahs1" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_ahs_challenge }}</textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk4" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_ahs2" id="gt_ahs2" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_ahs_action }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-IOD -->
                                    @elseif(Auth::user()->id_segmen == '4')
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-IOD</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_iod1" id="gt_iod1" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_iod_challenge }}</textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk5" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_iod2" id="gt_iod2" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_iod_action }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-AFH -->
                                    @elseif(Auth::user()->id_segmen == '2')
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-AFH</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_afh1" id="gt_afh1" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_afh_challenge }}</textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk6" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_afh2" id="gt_afh2" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_afh_action }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-MT -->
                                    @elseif(Auth::user()->id_segmen == '5')
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-MT</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_mt1" id="gt_mt1" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_mt_challenge }}</textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk7" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_mt2" id="gt_mt2" rows="1" class="form-control form-control-sm" readonly>{{ $data_view->gt_mt_action }}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                                <hr class="my-4">

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
                                                            <textarea name="peserta" id="peserta" rows="1" class="form-control required-field" readonly>{{ $data_view->peserta }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Program</label>
                                                            <textarea name="program" id="program" rows="1" class="form-control required-field" readonly>{{ $data_view->program }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Target</label>
                                                            <textarea name="target" id="target" rows="1" class="form-control required-field" readonly>{{ $data_view->target }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Performance/People</label>
                                                            <textarea name="pp" id="pp" rows="1" class="form-control required-field" readonly>{{ $data_view->perform }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Operation (HH, Kendaraan, Gudang, Data, Aplikasi, Sistem)</label>
                                                            <textarea name="opr" id="opr" rows="1" class="form-control required-field" readonly>{{ $data_view->operation }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Outlet</label>
                                                            <textarea name="outlet" id="outlet" rows="1" class="form-control required-field" readonly>{{ $data_view->outlet }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keuangan</label>
                                                            <textarea name="keuangan" id="keuangan" rows="1" class="form-control required-field" readonly>{{ $data_view->keuangan }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Other</label>
                                                            <textarea name="other" id="other" rows="1" class="form-control" readonly>{{ $data_view->other }}</textarea>
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
                                                            <textarea name="coaching" id="coaching" rows="1" class="form-control required-field" readonly>{{ $data_view->coaching }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Teguran</label>
                                                            <textarea name="teguran" id="teguran" rows="1" class="form-control required-field" readonly>{{ $data_view->teguran }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Intruksi</label>
                                                            <textarea name="intruksi" id="intruksi" rows="1" class="form-control required-field" readonly>{{ $data_view->intruksi }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Warning</label>
                                                            <textarea name="warning" id="warning" rows="1" class="form-control required-field" readonly>{{ $data_view->warning }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Other</label>
                                                            <textarea name="other_eksekusi" id="other_eksekusi" rows="1" class="form-control" readonly>{{ $data_view->other_eksekusi }}</textarea>
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
                                                            <textarea name="channel" id="channel" rows="1" class="form-control required-field" readonly>{{ $data_view->channel }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Toko</label>
                                                            <textarea name="nama_toko" id="nama_toko" rows="1" class="form-control required-field" readonly>{{ $data_view->nama_toko }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Issue</label>
                                                            <textarea name="issue" id="issue" rows="1" class="form-control required-field" readonly>{{ $data_view->issue }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Key Action</label>
                                                            <textarea name="key_action" id="key_action" rows="1" class="form-control required-field" readonly>{{ $data_view->key_action }}</textarea>
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
                                                            <textarea name="sales" id="sales" rows="1" class="form-control required-field" readonly>{{ $data_view->sales }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Channel</label>
                                                            <textarea name="channel_join" id="channel_join" rows="1" class="form-control required-field" readonly>{{ $data_view->channel_join }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Issue</label>
                                                            <textarea name="issue_join" id="issue_join" rows="1" class="form-control required-field" readonly>{{ $data_view->issue_join }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Key Action</label>
                                                            <textarea name="key_action_join" id="key_action_join" rows="1" class="form-control required-field" readonly>{{ $data_view->key_action_join }}</textarea>
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
                                        <button class="btn btn-primary px-4">Kembali</button>
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