@extends('layouts.admin')

@section('title')
<title>Status Cheque</title>
@endsection

@section('content')
<style>
    /* CUSTOM STYLES */
    .col-md-2 {
        padding-right: 5px !important;
        padding-left: 5px !important;
    }

    .card-info {
        border-radius: 5px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card-title-info {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center !important;
        text-transform: uppercase !important;
        font-size: 12px;
        font-weight: 600;
        height: 55px;
    }

    .card-body-info {
        font-size: 12px;
        padding: 5px;
        height: 100px;
        display: grid;
        align-items: center;
    }

    .card-body-info p {
        margin: 0;
        padding: 0;
        text-align: left;
    }

    .text-info {
        color: #505050 !important;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .text-info h5 {
        font-size: 20px;
        margin: 0;
        padding: 0;
        font-weight: 700;
    }

    /* STATUS CARD HOVER */
    .status-card {
        /* transition: all 0.3s ease; */
        cursor: pointer;
        /* border-left-width: 4px !important; */
    }

    .status-card:hover {
        /* transform: translateY(-5px); */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        opacity: 0.7;
    }

    /* MODAL STYLING */
    .modal-lg {
        max-width: 90%;
    }

    .modal-header {
        padding: 0.75rem 1rem;
    }

    .modal-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .modal-body {
        padding: 1rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        background-color: #f8f9fa;
    }

    .table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .text-muted {
        color: #23b8ff !important;
    }

    @@media (min-width: 992px) {
        .modal-lg {
            max-width: 90%;
        }
    }

    /* RESPONSIVE */
    @@media (min-width: 992px) {
        .modal-lg {
            max-width: 90%;
        }
    }

    @@media (max-width: 768px) {
        .status-count {
            font-size: 2rem;
        }
    }

</style>
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Status Cheque</li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-12">
                    <!-- MAIN CARD -->
                    <div class="card shadow-sm">

                        <!-- CARD HEADER -->
                        <div class="card-header py-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="card-title mb-0" style="margin-left: -9px">
                                        <i class="fas fa-file-invoice-dollar mr-2"></i> Status Cheque
                                    </h4>
                                    <small>Monitoring Status Cheque Perusahaan</small>
                                </div>
                            </div>
                        </div>

                        <!-- CARD BODY - STATUS CARDS -->
                        <div class="card-body">
                            <div class="row">
                                <!-- STATUS CARD TEMPLATE - Gunakan pola ini untuk semua card -->
                                <!-- Card 1: Cheque Blank -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-secondary h-100"
                                        data-status="cheque_blank" data-title="Cheque Blank" data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #96cede;">
                                            <h6 class="card-title-info mb-0">Cheque Blank</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Buku Cheque</p>
                                                <h5 data-counter="books">5</h5>
                                            </div>
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="43">43</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: Isi Tujuan & Nominal -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-info h-100"
                                        data-status="isi_tujuan_nominal" data-title="Cheque Isi Tujuan & Nominal"
                                        data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #c7bbd5;">
                                            <h6 class="card-title-info mb-0">Isi Tujuan & Nominal</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="5">5</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Isi Tujuan, Nominal & TTD 1 -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-warning h-100"
                                        data-status="isi_tujuan_nominal_ttd1" data-title="Isi Tujuan, Nominal & TTD 1"
                                        data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #ffce3c">
                                            <h6 class="card-title-info mb-0">Isi Tujuan, Nominal & TTD 1</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="7">7</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 4: Isi Tujuan, Nominal & TTD Lengkap -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-success h-100"
                                        data-status="isi_tujuan_nominal_ttdlengkap"
                                        data-title="Cheque Isi, Tujuan, Nominal & TTD Lengkap" data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #7ec234">
                                            <h6 class="card-title-info mb-0">Isi Tujuan, Nominal & TTD Lengkap</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="10">10</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 5: Cheque di Serahkan Ke Metro/HO -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-primary h-100"
                                        data-status="cheque_diserahkan_ke_metro"
                                        data-title="Cheque di Serahkan Ke Metro/HO" data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #f2872f">
                                            <h6 class="card-title-info mb-0">Cheque di Serahkan Ke Metro/HO</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="15">15</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 6: Cheque di Serahkan ke Vendor -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-info h-100" data-status="ttd1"
                                        data-title="Cheque di Serahkan ke Vendor" data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #008fc6">
                                            <h6 class="card-title-info mb-0">Cheque di Serahkan ke Vendor</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="21">21</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 7: Cheque Yang Batal -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-success h-100"
                                        data-status="tujuan_nominal_ttd1" data-title="Cheque Batal"
                                        data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #ff0000">
                                            <h6 class="card-title-info mb-0">Cheque Yang Batal</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="0">0</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 8: Cheque Isi Lengkap & TTD 1+2 -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-success h-100"
                                        data-status="cheque_isi_tujuan" data-title="Cheque Isi Tujuan"
                                        data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #f9d5b7">
                                            <h6 class="card-title-info mb-0">Isi Tujuan</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="5">5</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 9: Cheque Serahkan ke Vendor -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-warning h-100"
                                        data-status="isi_tujuan_ttd1" data-title="Isi Tujuan dan TTD 1"
                                        data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #fedb70">
                                            <h6 class="card-title-info mb-0">Isi Tujuan dan TTD 1</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="8">8</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 10: Cheque Transfer ke Bank -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-info h-100"
                                        data-status="isi_tujuan_ttd_lengkap" data-title="Isi Tujuan, TTD Lengkap"
                                        data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #e7bdba">
                                            <h6 class="card-title-info mb-0">Isi Tujuan, TTD Lengkap</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="7">7</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 11: Cheque Serahkan ke Metro/HO -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-primary h-100"
                                        data-status="isi_nominal" data-title="Cheque Nominal" data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #b3c983">
                                            <h6 class="card-title-info mb-0">Isi Nominal</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="12">12</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 12: Cheque Batal -->
                                <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-danger h-100"
                                        data-status="cheque_tf_bank" data-title="Cheque Yang Di Transaksikan Ke BANK"
                                        data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #008e40">
                                            <h6 class="card-title-info mb-0">Cheque Yang Di Transaksikan Ke BANK</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="8">8</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 13: Cheque TTD 1 -->
                                {{-- <div class="col-md-2 mb-2" style="opacity: 0%">
                                    <div class="card-info  border-left-danger h-100">
                                        <div class="card-header p-1" style="background: #b3c983">
                                            <h6 class="card-title-info mb-0"></h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-2 mb-2">
                                    <div class="card-info status-card border-left-danger h-100" data-status="ttd1_only"
                                        data-title="Cheque TTD 1" data-api-endpoint="#">
                                        <div class="card-header p-1" style="background: #b3c983">
                                            <h6 class="card-title-info mb-0">Cheque TTD 1</h6>
                                        </div>
                                        <div class="card-body-info text-center">
                                            <div class="text-info">
                                                <p>Total Lembar Cheque</p>
                                                <h5 data-counter="sheets" data-value="10">10</h5>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <small class="text-muted">Klik untuk detail</small>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- ==================== MODAL DETAIL CHEQUE ==================== -->
<div class="modal fade" id="modalDetailCheque" tabindex="-1" role="dialog" aria-labelledby="modalDetailChequeLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>
                    <span id="modalStatusTitle">Detail Cheque</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- MODAL BODY -->
            <div class="modal-body">
                <!-- INFO ALERT -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    Menampilkan data cheque untuk status: <strong id="modalStatusDesc">-</strong>
                </div>

                <!-- FILTER CONTROLS -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small">Tampilkan per halaman:</label>
                            <select class="form-control form-control-sm" id="modalItemsPerPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small">Cari data:</label>
                            <input type="text" class="form-control form-control-sm" id="modalSearchInput"
                                placeholder="Cari berdasarkan no cheque, vendor, dll...">
                        </div>
                    </div>
                </div>

                <!-- TABLE CONTAINER -->
                <div class="table-responsive" id="modalTableContainer">
                    <!-- Tabel akan di-render via JavaScript -->
                </div>

                <!-- PAGINATION INFO -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Menampilkan <span id="modalPageStart">0</span> - <span id="modalPageEnd">0</span>
                        dari <span id="modalTotalData">0</span> data
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0" id="modalPagination">
                            <!-- Pagination akan diisi via JavaScript -->
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- MODAL FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="btnExport">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // ==================== CHEQUE STATUS MODULE ====================
    const ChequeModule = (function () {
        // Configuration object
        const config = {
            itemsPerPage: 10, // Akan di-set ulang pada init jika ditemukan h5[data-counter]
            currentPage: 1,
            searchTerm: '',
            currentStatus: '',
            currentTitle: '',
            debounceTimer: null
        };

        // Complete table templates for ALL statuses
        const tableTemplates = {
            // ===== STATUS YANG SUDAH ADA =====
            cheque_blank: {
                columns: ['No', 'Kode Buku Cheque', 'Penerima cheque dari Bank', 'Pemegang Buku Cheque',
                    'BANK', 'Perusahaan'
                ],
                fields: ['kode_buku', 'penerima_bank', 'pemegang_buku', 'bank', 'perusahaan'],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku Cheque</th>
                    <th>Penerima cheque dari Bank</th>
                    <th>Pemegang Buku Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                </tr>
            `
            },
            isi_tujuan_nominal: {
                columns: ['No', 'Kode Buku Cheque', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi Cheque',
                    'Tujuan Cheque', 'Nominal'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'nominal'],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku Cheque</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi Cheque</th>
                    <th>Tujuan Cheque</th>
                    <th>Nominal</th>
                </tr>
            `
            },
            isi_tujuan_nominal_ttd1: {
                columns: ['No', 'Kode Buku Cheque', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi Cheque',
                    'Tujuan Cheque', 'TTD'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'ttd'],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku Cheque</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi Cheque</th>
                    <th>Tujuan Cheque</th>
                    <th>TTD</th>
                </tr>
            `
            },
            isi_tujuan_nominal_ttdlengkap: {
                columns: ['No', 'Kode Buku Cheque', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi Cheque',
                    'Tujuan Cheque', 'Nominal', 'TTD 1', 'TTD 2'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'nominal',
                    'ttd1', 'ttd2'
                ],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku Cheque</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi Cheque</th>
                    <th>Tujuan Cheque</th>
                    <th>Nominal</th>
                    <th>TTD 1</th>
                    <th>TTD 2</th>
                </tr>
            `
            },

            // ===== STATUS YANG BELUM ADA - DITAMBAHKAN =====
            cheque_diserahkan_ke_metro: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'Tujuan',
                    'Nominal', 'TTD 1', 'TTD 2', 'Tanggal Serah'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'nominal',
                    'ttd1', 'ttd2', 'tanggal_serah'
                ],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Tujuan</th>
                    <th>Nominal</th>
                    <th>TTD 1</th>
                    <th>TTD 2</th>
                    <th>Tanggal Serah</th>
                </tr>
            `
            },

            ttd1: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'Tujuan',
                    'TTD 1', 'Tanggal TTD'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'ttd1',
                    'tanggal_ttd'
                ],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Tujuan</th>
                    <th>TTD 1</th>
                    <th>Tanggal TTD</th>
                </tr>
            `
            },

            tujuan_nominal_ttd1: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'Tujuan',
                    'Nominal', 'TTD 1', 'TTD 2'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'nominal',
                    'ttd1', 'ttd2'
                ],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Tujuan</th>
                    <th>Nominal</th>
                    <th>TTD 1</th>
                    <th>TTD 2</th>
                </tr>
            `
            },

            cheque_isi_tujuan: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'Tujuan'],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan'],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Tujuan</th>
                </tr>
            `
            },

            isi_tujuan_ttd1: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'Tujuan',
                    'TTD 1'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'ttd1'],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Tujuan</th>
                    <th>TTD 1</th>
                </tr>
            `
            },

            isi_tujuan_ttd_lengkap: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'Tujuan',
                    'TTD 1', 'TTD 2'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan', 'ttd1',
                    'ttd2'
                ],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Tujuan</th>
                    <th>TTD 1</th>
                    <th>TTD 2</th>
                </tr>
            `
            },

            isi_nominal: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Nominal',
                    'TTD 1', 'Penerima Metro', 'Tanggal Serah Metro'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'nominal', 'ttd1',
                    'penerima_metro', 'tanggal_serah_metro'
                ],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Nominal</th>
                    <th>Penerima Metro</th>
                    <th>Tanggal Serah Metro</th>
                </tr>
            `
            },

            cheque_tf_bank: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'Tujuan',
                    'Nominal', 'TTD 1', 'TTD 2'
                ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'tujuan',
                    'nominal', 'ttd1', 'ttd2'
                ],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>Tujuan</th>
                    <th>Nominal</th>
                    <th>TTD 1</th>
                    <th>TTD 2</th>
                </tr>
            `
            },

            ttd1_only: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Pengisi', 'TTD 1', ],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'pengisi', 'ttd1'],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Pengisi</th>
                    <th>TTD 1</th>
                </tr>
            `
            },

            // Default template jika status tidak ditemukan
            default: {
                columns: ['No', 'Kode Buku', 'No. Cheque', 'BANK', 'Perusahaan', 'Status', 'Keterangan'],
                fields: ['kode_buku', 'no_cheque', 'bank', 'perusahaan', 'status', 'keterangan'],
                thead: `
                <tr>
                    <th>No.</th>
                    <th>Kode Buku</th>
                    <th>No. Cheque</th>
                    <th>BANK</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            `
            }
        };

        // Initialize module
        function init() {
            // Cari h5[data-counter] pertama dan gunakan nilainya untuk itemsPerPage jika valid
            const h5Counter = document.querySelector('h5[data-counter]');
            if (h5Counter) {
                const val = parseInt(h5Counter.textContent.trim());
                if (!isNaN(val) && val > 0) {
                    config.itemsPerPage = val;
                    // Set juga select pada modal jika sudah ada
                    if (document.getElementById('modalItemsPerPage')) {
                        document.getElementById('modalItemsPerPage').value = val;
                    }
                }
            }
            bindEvents();
            console.log('Cheque Status Module initialized');
        }

        // Bind all event listeners
        function bindEvents() {
            // Status card click events
            $(document).on('click', '.status-card', function () {
                const status = $(this).data('status');
                const title = $(this).data('title');
                openModal(status, title);
            });

            // Modal filter events
            $('#modalItemsPerPage').on('change', function () {
                config.itemsPerPage = parseInt($(this).val());
                config.currentPage = 1;
                renderModalTable();
            });

            // Modal search with debounce
            $('#modalSearchInput').on('keyup', function () {
                clearTimeout(config.debounceTimer);
                config.debounceTimer = setTimeout(function () {
                    config.searchTerm = $('#modalSearchInput').val().trim();
                    config.currentPage = 1;
                    renderModalTable();
                }, 500);
            });

            // Export button
            $('#btnExport').on('click', exportData);
        }

        // Open modal with status details
        function openModal(status, title) {
            config.currentStatus = status;
            config.currentTitle = title;
            config.currentPage = 1;
            config.searchTerm = '';

            // Set modal title
            $('#modalStatusTitle').text(title);
            $('#modalStatusDesc').text(title);

            // Cari card yang diklik berdasarkan status
            let itemsPerPage = 10;
            // Temukan card yang sesuai status
            const card = document.querySelector('.status-card[data-status="' + status + '"]');
            if (card) {
                // Cari h5[data-counter][data-value] di dalam card
                const h5 = card.querySelector('h5[data-counter][data-value]');
                if (h5) {
                    const val = parseInt(h5.getAttribute('data-value'));
                    if (!isNaN(val) && val >= 0) {
                        itemsPerPage = val;
                    }
                }
            }
            config.itemsPerPage = itemsPerPage;
            // Set juga select pada modal
            $('#modalItemsPerPage').val(itemsPerPage);

            // Reset filters
            $('#modalSearchInput').val('');

            // Show modal
            $('#modalDetailCheque').modal('show');

            // Render initial table
            renderModalTable();
        }

        // Generate mock data for demo
        function generateMockData(count = 15) {
            const data = [];
            for (let i = 1; i <= count; i++) {
                data.push({
                    kode_buku: `BK${String(i).padStart(3, '0')}`,
                    no_cheque: `CHQ${String(i).padStart(5, '0')}`,
                    bank: ['BCA', 'Mandiri', 'BNI', 'BRI'][Math.floor(Math.random() * 4)],
                    perusahaan: ['PT ABC', 'PT XYZ', 'CV Indah', 'UD Jaya'][Math.floor(Math.random() *
                        4)],
                    pengisi: ['John Doe', 'Jane Smith', 'Robert Johnson'][Math.floor(Math.random() *
                        3)],
                    tujuan: ['Pembayaran Vendor', 'Gaji Karyawan', 'Pembelian Barang'][Math.floor(Math
                        .random() * 3)],
                    nominal: Math.floor(Math.random() * 100000000) + 1000000,
                    ttd1: ['Direktur', 'Manager'][Math.floor(Math.random() * 2)],
                    ttd2: ['Finance Manager', 'CEO'][Math.floor(Math.random() * 2)],
                    ttd: ['TTD 1', 'TTD 2'][Math.floor(Math.random() * 2)],
                    penerima_bank: ['Staff Finance', 'Admin'][Math.floor(Math.random() * 2)],
                    pemegang_buku: ['Bagian Keuangan', 'Admin'][Math.floor(Math.random() * 2)],
                    // Additional fields
                    tanggal_serah: new Date().toLocaleDateString('id-ID'),
                    tanggal_ttd: new Date().toLocaleDateString('id-ID'),
                    alasan_batal: 'Cheque rusak/tdk layak',
                    status_lengkap: 'Lengkap',
                    vendor: 'Vendor ABC',
                    tanggal_serah_vendor: new Date().toLocaleDateString('id-ID'),
                    bank_tujuan: 'Bank Mandiri',
                    tanggal_transfer: new Date().toLocaleDateString('id-ID'),
                    penerima_metro: 'Staff Metro',
                    tanggal_serah_metro: new Date().toLocaleDateString('id-ID'),
                    tanggal_batal: new Date().toLocaleDateString('id-ID'),
                    keterangan: 'Cheque untuk pembayaran rutin',
                    status: 'Pending'
                });
            }
            return data;
        }

        // Render table in modal
        function renderModalTable() {
            const template = tableTemplates[config.currentStatus] || tableTemplates.default;
            const allData = generateMockData(25);

            // Filter data
            let filteredData = allData;
            if (config.searchTerm) {
                const term = config.searchTerm.toLowerCase();
                filteredData = allData.filter(item => {
                    return template.fields.some(field => {
                        const value = item[field] || '';
                        return value.toString().toLowerCase().includes(term);
                    });
                });
            }

            // Pagination calculations
            const totalItems = filteredData.length;
            const totalPages = Math.ceil(totalItems / config.itemsPerPage);

            if (config.currentPage > totalPages && totalPages > 0) {
                config.currentPage = totalPages;
            }

            $('#modalTotalData').text(totalItems);

            // Slice data for current page
            const startIndex = (config.currentPage - 1) * config.itemsPerPage;
            const endIndex = Math.min(startIndex + config.itemsPerPage, totalItems);
            $('#modalPageStart').text(totalItems === 0 ? '0' : startIndex + 1);
            $('#modalPageEnd').text(totalItems === 0 ? '0' : endIndex);

            // Render table
            let tableHtml = `
            <table class="table table-sm table-hover">
                <thead>${template.thead}</thead>
                <tbody id="modalChequeData">`;

            const pageData = filteredData.slice(startIndex, endIndex);
            if (pageData.length === 0) {
                tableHtml += `
                <tr>
                    <td colspan="${template.columns.length}" class="text-center py-4">
                        <i class="fas fa-search fa-2x text-muted mb-3"></i>
                        <p class="text-muted">
                            ${config.searchTerm 
                                ? 'Tidak ada data yang sesuai dengan pencarian' 
                                : 'Tidak ada data cheque untuk status ini'}
                        </p>
                    </td>
                </tr>`;
            } else {
                pageData.forEach((item, index) => {
                    tableHtml += `<tr><td class="text-center">${startIndex + index + 1}</td>`;
                    template.fields.forEach(field => {
                        let value = item[field] || '';
                        // Format nominal jika kolom nominal
                        if (field === 'nominal' && value) {
                            value = formatRupiah(value);
                        }
                        tableHtml += `<td>${value}</td>`;
                    });
                    tableHtml += `</tr>`;
                });
            }

            tableHtml += `</tbody></table>`;
            $('#modalTableContainer').html(tableHtml);
            renderPagination(totalPages);
        }

        // Render pagination controls
        function renderPagination(totalPages) {
            if (totalPages <= 1) {
                $('#modalPagination').html('');
                return;
            }

            let paginationHtml = '';
            const current = config.currentPage;

            // Previous button
            paginationHtml += `
            <li class="page-item ${current === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="ChequeModule.changePage(${current - 1})">
                    <span>&laquo;</span>
                </a>
            </li>
        `;

            // Page numbers
            let startPage = Math.max(1, current - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `
                <li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="ChequeModule.changePage(${i})">${i}</a>
                </li>
            `;
            }

            // Next button
            paginationHtml += `
            <li class="page-item ${current === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="ChequeModule.changePage(${current + 1})">
                    <span>&raquo;</span>
                </a>
            </li>
        `;

            $('#modalPagination').html(paginationHtml);
        }

        // Change page in modal
        function changePage(page) {
            if (page < 1 || page > Math.ceil($('#modalTotalData').text() / config.itemsPerPage)) {
                return;
            }

            config.currentPage = page;
            renderModalTable();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Export data function
        function exportData() {
            const status = config.currentStatus;
            const title = config.currentTitle;

            Swal.fire({
                title: 'Export Data',
                html: `Export data untuk:<br><strong>${title}</strong><br><br>Status: <strong>${status}</strong>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Download Excel',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulate export
                    Swal.fire({
                        title: 'Menyiapkan File...',
                        text: 'Sedang mengeksport data ke Excel',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                            setTimeout(() => {
                                Swal.fire(
                                    'Berhasil!',
                                    'File Excel telah siap didownload',
                                    'success'
                                );
                            }, 1500);
                        }
                    });
                }
            });
        }

        // Format currency to Rupiah
        function formatRupiah(angka) {
            if (!angka) return 'Rp 0';
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Public API
        return {
            init: init,
            changePage: changePage,
            openModal: openModal
        };
    })();

    // Initialize when document is ready
    $(document).ready(function () {
        ChequeModule.init();
    });

    // Global refresh function
    window.refreshChequeStatus = function () {
        alert('Refresh data cheque...');
        // Implement API call here if needed
    };

</script>
@endsection
