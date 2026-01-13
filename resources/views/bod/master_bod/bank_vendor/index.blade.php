@extends('layouts.admin')

@section('title')
    <title>Master Data Vendor</title>
@endsection

@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Master Vendor</li>
            <li class="breadcrumb-item active">Master Data Vendor</li>
        </ol>

        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-accent-primary shadow-sm">
                            <div class="card-header bg-white border-bottom-0 py-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="card-title mb-0" style="font-size: 1.1rem;">
                                            <i class="nav-icon icon-office mr-1"></i> Master Data Vendor
                                        </h4>
                                        <small class="text-muted" style="font-size: 0.8rem;">Daftar Informasi Master Data
                                            Vendor</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 text-right">
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Update:</small>
                                            <span id="last-updated" class="font-weight-bold"
                                                style="font-size: 0.85rem;">{{ date('d/m/Y H:i') }}</span>
                                        </div>
                                        <button onclick="fetchAllDataBank()" class="btn btn-sm btn-outline-primary py-1">
                                            <i class="nav-icon icon-refresh mr-1"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show m-2" role="alert"
                                        style="padding: 0.4rem 1rem; font-size: 0.85rem;">
                                        <i class="nav-icon icon-check mr-1"></i> {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                            style="padding: 0.2rem;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show m-2" role="alert"
                                        style="padding: 0.4rem 1rem; font-size: 0.85rem;">
                                        <i class="nav-icon icon-exclamation mr-1"></i> {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                            style="padding: 0.2rem;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <!-- Filter Controls -->
                                <div
                                    class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom bg-light">

                                    <div class="mr-3">
                                        {{-- <label class="mb-0 text-muted" style="font-size: 0.8rem;">Tampilkan:</label> --}}
                                        <select id="items-per-page" class="form-control form-control-sm"
                                            style="width: 70px; font-size: 0.8rem; height: 28px;">
                                            <option value="10" selected>10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div>
                                        {{-- <label class="mb-0 text-muted" style="font-size: 0.8rem;">Cari:</label> --}}
                                        <input type="text" id="search-input" class="form-control form-control-sm"
                                            placeholder="Ketik untuk mencari..."
                                            style="width: 200px; font-size: 0.8rem; height: 28px;">
                                    </div>

                                    {{-- <div class="text-muted small" style="font-size: 0.8rem;">
                                        Total: <span id="total-items" class="font-weight-bold">0</span> data
                                    </div> --}}
                                </div>

                                <div class="table-responsive">
                                    <table id="datatable-bank" class="table table-hover mb-0" style="width:100%;">
                                        <thead class="thead-light">
                                            <tr style="white-space: nowrap">
                                                <th width="5%" class="text-center">No</th>
                                                <th>Nama Vendor</th>
                                                <th>Nama Rek</th>
                                                <th>No. Rek</th>
                                                <th>Bank</th>
                                                <th>Pajak/Non Pajak</th>
                                                <th>TOP</th>
                                                <th>Jenis Pembayaran</th>
                                                <th>Alamat Vendor</th>
                                                <th>No. Telepon</th>
                                                <th>Pemilik Vendor</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bank-data">
                                            <tr style="white-space:nowrap !important;">
                                                <td colspan="11" class="text-center py-3"
                                                    style="white-space:nowrap !important;">
                                                    <div class="spinner-border spinner-border-sm text-primary"
                                                        role="status"
                                                        style="white-space:nowrap !important; display:inline-block;">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <p class="mt-2 mb-0 text-muted"
                                                        style="font-size:0.85rem; display:inline-block; white-space:nowrap !important;">
                                                        Memuat data...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light"
                                    id="pagination-container">
                                    <div class="text-muted small" style="font-size: 0.8rem;">
                                        Menampilkan <span id="page-start">0</span> - <span id="page-end">0</span> dari
                                        <span id="total-data">0</span> data
                                    </div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm mb-0" id="pagination">
                                            <!-- Pagination will be generated by JavaScript -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detail Vendor -->
    <div class="modal fade" id="modalDetailVendor" tabindex="-1" role="dialog" aria-labelledby="modalDetailVendorLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title" id="modalDetailVendorLabel" style="font-size: 0.95rem;">
                        <i class="nav-icon far fa-address-card mr-2"></i>Detail Vendor
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-2">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-2">
                                <div class="card-body py-2">
                                    <h6 class="font-weight-bold text-primary mb-1" style="font-size: 0.85rem;">
                                        <i class="nav-icon icon-office mr-1"></i>Informasi Vendor
                                    </h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted" style="width: 40%; font-size: 0.8rem;">Nama Vendor</td>
                                            <td style="width: 5%;">:</td>
                                            <td id="detail-nama-vendor" class="font-weight-bold"
                                                style="font-size: 0.8rem;">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted" style="font-size: 0.8rem;">Kode Vendor</td>
                                            <td>:</td>
                                            <td id="detail-kode-vendor" style="font-size: 0.8rem;">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted" style="font-size: 0.8rem;">Perusahaan</td>
                                            <td>:</td>
                                            <td id="detail-perusahaan" style="font-size: 0.8rem;">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-2">
                                <div class="card-body py-2">
                                    <h6 class="font-weight-bold text-primary mb-1" style="font-size: 0.85rem;">
                                        <i class="nav-icon icon-credit-card mr-1"></i>Informasi Pembayaran
                                    </h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted" style="width: 40%; font-size: 0.8rem;">Cara Bayar</td>
                                            <td style="width: 5%;">:</td>
                                            <td id="detail-cara-bayar" style="font-size: 0.8rem;">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted" style="font-size: 0.8rem;">Nama Bank</td>
                                            <td>:</td>
                                            <td id="detail-nama-bank" class="font-weight-bold"
                                                style="font-size: 0.8rem;">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted" style="font-size: 0.8rem;">No. Rekening</td>
                                            <td>:</td>
                                            <td id="detail-no-rekening" class="font-weight-bold"
                                                style="font-size: 0.8rem;">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border">

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%" class="text-center" style="font-size: 0.8rem;">No</th>
                                            <th style="font-size: 0.8rem;">Nama Barang/Jasa</th>
                                            <th style="font-size: 0.8rem;">Merk</th>
                                            <th class="text-right" style="font-size: 0.8rem;">Harga</th>
                                            <th class="text-center" style="font-size: 0.8rem;">Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-barang-body">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-2"
                                                style="font-size: 0.8rem;">
                                                Tidak ada data barang
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                        style="font-size: 0.8rem;">
                        <i class="nav-icon icon-close mr-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .card {
            border-radius: 4px;
        }

        .card-header {
            padding: 0.5rem 1rem;
            border-radius: 4px 4px 0 0 !important;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.85rem;
            white-space: nowrap;
            /* No wrap untuk semua cell */
        }

        .table th {
            white-space: nowrap;
            /* No wrap untuk header */
            border-bottom: 2px solid #e3e6f0;
            color: #2a3f5f;
            font-weight: 600;
            padding: 6px 8px !important;
            font-size: 0.85rem;
            vertical-align: middle;
            white-space: nowrap;
            /* No wrap untuk header */
        }

        .table td {
            padding: 4px 8px !important;
            vertical-align: middle;
            border-color: #e3e6f0;
            font-size: 0.85rem;
            line-height: 1.2;
            white-space: nowrap;
            /* No wrap untuk data */
        }

        /* Truncate long text with ellipsis */
        .table td:not(:first-child) {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table tbody tr {
            transition: background-color 0.15s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .badge {
            font-size: 0.75em;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 500;
        }

        .badge-info {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-danger {
            background-color: #fde8e8;
            color: #e53e3e;
        }

        .badge-success {
            background-color: #e6fffa;
            color: #38a169;
        }

        .pagination-sm .page-link {
            padding: 0.2rem 0.4rem;
            font-size: 0.8rem;
            line-height: 1.3;
        }

        .pagination {
            margin-bottom: 0;
        }

        #pagination-container {
            background-color: #f8f9fa;
            min-height: 40px;
        }

        /* Filter controls */
        .form-control-sm {
            height: 28px;
            padding: 0.2rem 0.5rem;
        }

        /* Compact modal */
        .modal-body {
            padding: 0.5rem;
        }

        .modal-header,
        .modal-footer {
            padding: 0.5rem 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .table-responsive {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 3px 5px !important;
            }

            #pagination-container {
                flex-direction: column;
                white-space: nowrap;
                /* No wrap untuk data */
                text-align: center;
            }

            #pagination-container>div:first-child {
                margin-bottom: 5px;
            }

            /* Filter responsive */
            .bg-light>.d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .bg-light>.d-flex>div {
                margin-bottom: 5px;
            }

            .bg-light>.d-flex>div:last-child {
                align-self: flex-end;
            }
        }

        @media (max-width: 576px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table {
                min-width: 1200px;
                /* Lebar minimum untuk table */
            }

            /* Adjust filter controls for mobile */
            #search-input {
                width: 150px !important;
            }
        }
    </style>
@endsection

@section('js')
    <script>
        // Deklarasi variabel global
        let vendorData = [];
        let filteredData = [];
        let currentPage = 1;
        let itemsPerPage = 10; // Default 10
        let totalPages = 0;
        let totalItems = 0;
        let searchTimeout = null;

        $(document).ready(function() {
            fetchAllDataBank();

            // Event untuk tombol refresh
            $(document).on('click', '.refresh-btn', function() {
                fetchAllDataBank();
            });

            // Event untuk change items per page
            $('#items-per-page').on('change', function() {
                itemsPerPage = parseInt($(this).val());
                currentPage = 1;
                filterData();
            });

            // Event untuk search input dengan debounce
            $('#search-input').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    filterData();
                }, 300); // Debounce 300ms
            });
        });

        function fetchAllDataBank() {
            $.ajax({
                type: "GET",
                url: "{{ route('bod_bank_vendor/getDataBankVendor.getDataBankVendor') }}",
                dataType: "json",
                beforeSend: function() {
                    $('#bank-data').html(`
                    <tr>
                        <td colspan="11" class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2 mb-0 text-muted" style="font-size: 0.85rem;">Memuat data...</p>
                        </td>
                    </tr>
                `);
                    $('#pagination-container').hide();
                    $('#total-items').text('0');
                },
                success: function(response) {
                    vendorData = response.data || [];
                    filteredData = [...vendorData]; // Copy data untuk filtering
                    filterData(); // Apply initial filter

                    // Update last updated time
                    const now = new Date();
                    const timeStr = now.getHours().toString().padStart(2, '0') + ':' +
                        now.getMinutes().toString().padStart(2, '0');
                    $('#last-fetch').text(timeStr);
                    $('#last-updated').text(now.toLocaleDateString('id-ID') + ' ' + timeStr);
                },
                error: function(xhr, status, error) {
                    $('#bank-data').html(`
                    <tr>
                        <td colspan="11" class="text-center py-3">
                            <i class="nav-icon icon-exclamation fa-lg text-danger mb-2"></i>
                            <p class="text-danger mb-0" style="font-size: 0.85rem;">Gagal memuat data</p>
                            <small class="text-muted" style="font-size: 0.8rem;">Silakan refresh halaman</small>
                        </td>
                    </tr>
                `);
                    $('#pagination-container').hide();
                    console.error("AJAX Error:", error);
                }
            });
        }

        function filterData() {
            const searchTerm = $('#search-input').val().toLowerCase().trim();

            if (searchTerm === '') {
                filteredData = [...vendorData];
            } else {
                filteredData = vendorData.filter(item => {
                    // Search in all relevant fields
                    return (
                        (item.nama_vendor && item.nama_vendor.toLowerCase().includes(searchTerm)) ||
                        (item.nama_rek && item.nama_rek.toLowerCase().includes(searchTerm)) ||
                        (item.norek && item.norek.toLowerCase().includes(searchTerm)) ||
                        (item.nama_bank && item.nama_bank.toLowerCase().includes(searchTerm)) ||
                        (item.pajak && item.pajak.toLowerCase().includes(searchTerm)) ||
                        (item.top && item.top.toLowerCase().includes(searchTerm)) ||
                        (item.cara_bayar && item.cara_bayar.toLowerCase().includes(searchTerm)) ||
                        (item.alamat_vendor && item.alamat_vendor.toLowerCase().includes(searchTerm)) ||
                        (item.no_telepon && item.no_telepon.toLowerCase().includes(searchTerm)) ||
                        (item.pemilik_vendor && item.pemilik_vendor.toLowerCase().includes(searchTerm))
                    );
                });
            }

            totalItems = filteredData.length;
            totalPages = Math.ceil(totalItems / itemsPerPage);

            if (currentPage > totalPages && totalPages > 0) {
                currentPage = totalPages;
            }

            if (filteredData.length > 0) {
                renderTable();
                renderPagination();
                $('#pagination-container').show();
            } else {
                $('#bank-data').html(`
                <tr>
                    <td colspan="11" class="text-center py-3">
                        <i class="nav-icon icon-magnifier fa-lg text-muted mb-2"></i>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Tidak ada data yang sesuai dengan pencarian</p>
                        <small class="text-muted" style="font-size: 0.8rem;">Coba kata kunci lain</small>
                    </td>
                </tr>
            `);
                $('#pagination-container').hide();
            }

            // Update total items display
            $('#total-items').text(totalItems);
        }

        function renderTable() {
            let tableHtml = '';
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

            // Update page info
            $('#page-start').text(startIndex + 1);
            $('#page-end').text(endIndex);
            $('#total-data').text(totalItems);

            for (let i = startIndex; i < endIndex; i++) {
                const bn = filteredData[i];

                // Determine badge color for Pajak/Non Pajak
                let pajakBadgeClass = 'badge-secondary';
                let pajakText = bn.pajak || '-';

                if (pajakText.toLowerCase().includes('pajak')) {
                    pajakBadgeClass = 'badge-danger';
                } else if (pajakText.toLowerCase().includes('non')) {
                    pajakBadgeClass = 'badge-success';
                }

                tableHtml += `
            <tr class="row-detail-vendor" data-index="${i}" style="cursor: pointer; white-space:nowrap !important;" title="Klik untuk detail;">
                <td class="text-center" style="white-space:nowrap !important;">${i + 1}</td>
                <td title="${escapeHtml(bn.nama_vendor || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.nama_vendor || '-')}</td>
                <td title="${escapeHtml(bn.nama_rek || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.nama_rek || '-')}</td>
                <td title="${escapeHtml(bn.norek || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.norek || '-')}</td>
                <td title="${escapeHtml(bn.nama_bank || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.nama_bank || '-')}</td>
                <td style="white-space:nowrap !important;"><span class="badge ${pajakBadgeClass}">${escapeHtml(pajakText)}</span></td>
                <td title="${escapeHtml(bn.top || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.top || '-')}</td>
                <td title="${escapeHtml(bn.cara_bayar || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.cara_bayar || '-')}</td>
                <td title="${escapeHtml(bn.alamat_vendor || '')}" style="white-space:nowrap !important;">${escapeHtml(truncateText(bn.alamat_vendor, 30) || '-')}</td>
                <td title="${escapeHtml(bn.no_telepon || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.no_telepon || '-')}</td>
                <td title="${escapeHtml(bn.pemilik_vendor || '')}" style="white-space:nowrap !important;">${escapeHtml(bn.pemilik_vendor || '-')}</td>
            </tr>`;
            }

            $('#bank-data').html(tableHtml);

            // Attach click event to rows
            $('.row-detail-vendor').off('click').on('click', function() {
                const index = $(this).data('index');
                showVendorDetail(index);
            });
        }

        function renderPagination() {
            let paginationHtml = '';

            if (totalPages <= 1) {
                $('#pagination').html('');
                return;
            }

            // Previous button
            paginationHtml += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            // Adjust start page if we're near the end
            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>`;
            }

            // Next button
            paginationHtml += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

            $('#pagination').html(paginationHtml);
        }

        function changePage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;
            currentPage = page;
            renderTable();
            renderPagination();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showVendorDetail(index) {
            const dataIndex = (currentPage - 1) * itemsPerPage + index;
            if (!filteredData[dataIndex]) return;

            const data = filteredData[dataIndex];

            // Fill modal data
            $('#detail-nama-vendor').text(data.nama_jenis_vendor || '-');
            $('#detail-kode-vendor').text(data.kode_vendor || '-');
            $('#detail-perusahaan').text(data.nama_vendor || '-');
            $('#detail-cara-bayar').text(data.cara_bayar || '-');
            $('#detail-nama-bank').text(data.nama_bank || '-');
            $('#detail-no-rekening').text(data.norek || '-');

            // Update modal title
            $('#modalDetailVendorLabel').html(`
                <i class="nav-icon icon-info mr-2"></i>Detail Vendor - ${data.nama_vendor || 'Vendor'}
            `);

            // Product data (adjust according to your data structure)
            let barangHtml = '';

            if (data.barang && data.barang.length > 0) {
                data.barang.forEach((item, i) => {
                    barangHtml += `
                <tr>
                    <td class="text-center">${i + 1}</td>
                    <td>${escapeHtml(item.nama || '-')}</td>
                    <td>${escapeHtml(item.merk || '-')}</td>
                    <td class="text-right">${item.harga ? formatRupiah(item.harga) : '-'}</td>
                    <td class="text-center">${escapeHtml(item.satuan || '-')}</td>
                </tr>`;
                });
            } else {
                barangHtml = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-2">
                        Tidak ada data barang/jasa untuk vendor ini
                    </td>
                </tr>`;
            }

            $('#detail-barang-body').html(barangHtml);
            $('#modalDetailVendor').modal('show');
        }

        function formatRupiah(angka) {
            if (!angka) return 'Rp 0';
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.toString().replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }

        function truncateText(text, maxLength) {
            if (!text) return '';
            if (text.length <= maxLength) return text;
            return text.substring(0, maxLength) + '...';
        }

        // Clear search input
        function clearSearch() {
            $('#search-input').val('');
            currentPage = 1;
            filterData();
        }
    </script>
@endsection
