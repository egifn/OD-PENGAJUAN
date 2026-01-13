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
                    alert('Harap isi semua kolom yang diperlukan di bagian ini sebelum melanjutkan.');
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
                            <form action="{{ route('daily_activity/store.store') }}" method="post" onkeypress="return event.keyCode != 13" enctype="multipart/form-data">
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
                                            <input type="text" id="jabatan" name="jabatan" class="form-control bg-light" value="{{ $data_users->nama_divisi_sub }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal</label>
                                            <input type="date" id="tgl" name="tgl" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                </div>

                                <hr class="my-4">

                              <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="text-primary mb-3">Sales Operation</h5>
                                    
                                    <!-- Sales Strategy Development Header -->
                                    <div class="row mb-2">
                                        <!-- <div class="col-md-6 font-weight-bold"></div> -->
                                        <div class="col-md-3 font-weight-bold">Sales Operation</div>
                                        <div class="col-md-9 font-weight-bold mb-3"><textarea name="key_challenge" id="key_challenge" rows="1" class="form-control form-control-sm"></textarea></div>
                                        
                                        <div class="col-md-3 font-weight-bold">Sales Strategy Development</div>
                                        <div class="col-md-3 font-weight-bold">Key Challenge per Channel</div>
                                        <div class="col-md-3 font-weight-bold" style="text-align: center">Key Challenge</div>
                                        <div class="col-md-1 font-weight-bold text-center"  style="text-align: center">Check</div>
                                        <div class="col-md-2 font-weight-bold" style="text-align: center">Key Action</div>
                                    </div>
                                    
                                    <!-- GT-SO -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-SO</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_so1" id="gt_so1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk1" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_so2" id="gt_so2" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- GT-WS -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-WS</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_ws1" id="gt_ws1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk2" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_ws2" id="gt_ws2" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- GT-R -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-R</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_r1" id="gt_r1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk3" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_r2" id="gt_r2" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-AHS -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-AHS</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_ahs1" id="gt_ahs1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk4" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_ahs2" id="gt_ahs2" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-IOD -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-IOD</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_iod1" id="gt_iod1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk5" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_iod2" id="gt_iod2" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-AFH -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-AFH</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_afh1" id="gt_afh1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk6" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_afh2" id="gt_afh2" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- NON GT-MT -->
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">GT-MT</div>
                                        <div class="col-md-3">
                                            <textarea name="gt_mt1" id="gt_mt1" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <div class="col-md-1 check-box">
                                            <input type="checkbox" name="chk7" value="1" class="form-check-input">
                                        </div>
                                        <div class="col-md-2">
                                            <textarea name="gt_mt2" id="gt_mt2" rows="1" class="form-control form-control-sm"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                                <div>
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