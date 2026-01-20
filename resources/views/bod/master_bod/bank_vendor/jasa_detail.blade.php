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
                                        Master Data Vendor
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
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show m-2" role="alert"
                                    style="padding: 0.4rem 1rem; font-size: 0.85rem;">
                                    <i class="nav-icon icon-check mr-1"></i> {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        style="padding: 0.2rem;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show m-2" role="alert"
                                    style="padding: 0.4rem 1rem; font-size: 0.85rem;">
                                    <i class="nav-icon icon-exclamation mr-1"></i>
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        style="padding: 0.2rem;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Filter Controls -->
                            <div
                                class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom bg-light">

                                <div class="mr-3" style="display: flex; gap: 10px">
                                    {{-- <label class="mb-0 text-muted" style="font-size: 0.8rem;">Tampilkan:</label> --}}
                                    <select id="items-per-page" class="form-control form-control-sm"
                                        style="width: 70px; font-size: 0.8rem; height: 28px;">
                                        <option value="10" selected>10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    <select id="items-jenis" class="form-control form-control-sm"
                                        style="width: 150px; font-size: 0.8rem; height: 28px;">
                                        <option value="all" selected>All</option>
                                        <option value="barang">Barang</option>
                                        <option value="jasa">Jasa</option>
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
                                            <th>Pemilih Vendor</th>
                                            <th>Tgl Pengajuan Vendor</th>
                                            <th>Yang Mengajukan Vendor</th>
                                            <th>Tgl Approved Vendor</th>
                                            <th>Di Approved Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bank-data">
                                        <tr style="white-space:nowrap !important;">
                                            <td colspan="13" class="text-center py-3"
                                                style="white-space:nowrap !important;">
                                                <div class="spinner-border spinner-border-sm text-primary" role="status"
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
                                        <td id="detail-nama-vendor" class="font-weight-bold" style="font-size: 0.8rem;">
                                            -</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted" style="font-size: 0.8rem;">Kode Vendor</td>
                                        <td>:</td>
                                        <td id="detail-kode-vendor" style="font-size: 0.8rem;">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted" style="font-size: 0.8rem;">Alamat</td>
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
                                        <td id="detail-nama-bank" class="font-weight-bold" style="font-size: 0.8rem;">-
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted" style="font-size: 0.8rem;">No. Rekening</td>
                                        <td>:</td>
                                        <td id="detail-no-rekening" class="font-weight-bold" style="font-size: 0.8rem;">
                                            -</td>
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
                                        <td class="text-center" style="font-size: 0.8rem;">1</td>
                                        <td style="font-size: 0.8rem;">Laptop Dummy</td>
                                        <td style="font-size: 0.8rem;">DummyTech</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 10.000.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">2</td>
                                        <td style="font-size: 0.8rem;">Printer Dummy</td>
                                        <td style="font-size: 0.8rem;">PrintDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 2.000.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">3</td>
                                        <td style="font-size: 0.8rem;">Meja Kantor</td>
                                        <td style="font-size: 0.8rem;">FurniDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 1.500.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">4</td>
                                        <td style="font-size: 0.8rem;">Kursi Kantor</td>
                                        <td style="font-size: 0.8rem;">ChairDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 800.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">5</td>
                                        <td style="font-size: 0.8rem;">Proyektor</td>
                                        <td style="font-size: 0.8rem;">ViewDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 5.000.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">6</td>
                                        <td style="font-size: 0.8rem;">Scanner</td>
                                        <td style="font-size: 0.8rem;">ScanDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 1.200.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">7</td>
                                        <td style="font-size: 0.8rem;">Kabel LAN</td>
                                        <td style="font-size: 0.8rem;">CableDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 100.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Roll</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">8</td>
                                        <td style="font-size: 0.8rem;">Mouse Wireless</td>
                                        <td style="font-size: 0.8rem;">MouseDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 150.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">9</td>
                                        <td style="font-size: 0.8rem;">Keyboard Wireless</td>
                                        <td style="font-size: 0.8rem;">KeyDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 200.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 0.8rem;">10</td>
                                        <td style="font-size: 0.8rem;">Flashdisk 32GB</td>
                                        <td style="font-size: 0.8rem;">FlashDummy</td>
                                        <td class="text-right" style="font-size: 0.8rem;">Rp 75.000</td>
                                        <td class="text-center" style="font-size: 0.8rem;">Unit</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="font-size: 0.8rem;">
                    <i class="nav-icon icon-close mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
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

    $(document).ready(function () {
        fetchAllDataBank();

        // Sidebar dropdown logic: aktifkan parent dan child sesuai url
        function activateSidebarDropdown() {
            var url = window.location.href;
            // Untuk sidebar utama
            var $dropdown = $(".nav-link.nav-dropdown-toggle:contains('Master data vendor')").closest(
                '.nav-item.nav-dropdown');
            var $dropdownToggle = $dropdown.children('.nav-link.nav-dropdown-toggle');
            var $dropdownMenu = $dropdown.children('.nav-dropdown-items');
            var $jasa = $dropdownMenu.find("a.nav-link:contains('JASA')");
            var $barang = $dropdownMenu.find("a.nav-link:contains('BARANG')");

            // Reset
            $dropdownToggle.removeClass('active');
            $dropdownMenu.removeClass('show').css('display', '');
            $jasa.removeClass('active');
            $barang.removeClass('active');

            // Aktifkan sesuai url
            if (url.includes('type=jasa')) {
                $dropdownToggle.addClass('active');
                $dropdownMenu.addClass('show').css('display', 'block');
                $jasa.addClass('active');
            } else if (url.includes('type=barang')) {
                $dropdownToggle.addClass('active');
                $dropdownMenu.addClass('show').css('display', 'block');
                $barang.addClass('active');
            }
        }

        activateSidebarDropdown();

        // Event untuk tombol refresh
        $(document).on('click', '.refresh-btn', function () {
            fetchAllDataBank();
        });

        // Event untuk change items per page
        $('#items-per-page').on('change', function () {
            itemsPerPage = parseInt($(this).val());
            currentPage = 1;
            filterData();
        });

        // Event untuk search input dengan debounce
        $('#search-input').on('keyup', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                currentPage = 1;
                filterData();
            }, 300); // Debounce 300ms
        });

        // Jika klik JASA/BARANG, pastikan dropdown tetap terbuka
        $(document).on('click', ".nav-dropdown-items a.nav-link", function () {
            setTimeout(activateSidebarDropdown, 100);
        });
    });

    function fetchAllDataBank() {
        $.ajax({
            type: "GET",
            url: "{{ route('bod_bank_vendor/getDataBankVendor.getDataBankVendor') }}",
            dataType: "json",
            beforeSend: function () {
                $('#bank-data').html(`
                    <tr>
                        <td colspan="13" class="text-center py-3">
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
            success: function (response) {
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
            error: function (xhr, status, error) {
                $('#bank-data').html(`
                    <tr>
                        <td colspan="13" class="text-center py-3">
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
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>`;
        }

        $('#bank-data').html(tableHtml);

        // Attach click event to rows
        $('.row-detail-vendor').off('click').on('click', function () {
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
        $('#detail-nama-vendor').text(data.nama_vendor || '-');
        $('#detail-kode-vendor').text(data.kode_vendor || '-');
        $('#detail-alamat').text(data.alamat || '-');
        $('#detail-cara-bayar').text(data.cara_bayar || '-');
        $('#detail-nama-bank').text(data.nama_bank || '-');
        $('#detail-no-rekening').text(data.norek || '-');

        // Update modal title
        $('#modalDetailVendorLabel').html(`
                <i class="nav-icon icon-info mr-2"></i>Detail Vendor - ${data.nama_vendor || 'Vendor'}
            `);

        // Product data (dummy 10 rows if kosong)
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
            // 10 dummy rows
            const dummyBarang = [{
                    nama: 'Laptop Dummy',
                    merk: 'DummyTech',
                    harga: 10000000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Printer Dummy',
                    merk: 'PrintDummy',
                    harga: 2000000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Meja Kantor',
                    merk: 'FurniDummy',
                    harga: 1500000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Kursi Kantor',
                    merk: 'ChairDummy',
                    harga: 800000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Proyektor',
                    merk: 'ViewDummy',
                    harga: 5000000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Scanner',
                    merk: 'ScanDummy',
                    harga: 1200000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Kabel LAN',
                    merk: 'CableDummy',
                    harga: 100000,
                    satuan: 'Roll'
                },
                {
                    nama: 'Mouse Wireless',
                    merk: 'MouseDummy',
                    harga: 150000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Keyboard Wireless',
                    merk: 'KeyDummy',
                    harga: 200000,
                    satuan: 'Unit'
                },
                {
                    nama: 'Flashdisk 32GB',
                    merk: 'FlashDummy',
                    harga: 75000,
                    satuan: 'Unit'
                }
            ];
            dummyBarang.forEach((item, i) => {
                barangHtml += `
                <tr>
                    <td class="text-center">${i + 1}</td>
                    <td>${escapeHtml(item.nama)}</td>
                    <td>${escapeHtml(item.merk)}</td>
                    <td class="text-right">${formatRupiah(item.harga)}</td>
                    <td class="text-center">${escapeHtml(item.satuan)}</td>
                </tr>`;
            });
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
        return text.toString().replace(/[&<>"']/g, function (m) {
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
