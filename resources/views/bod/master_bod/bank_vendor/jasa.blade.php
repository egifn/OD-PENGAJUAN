@extends('layouts.admin')

@section('title')
<title>Master Data Vendor Jasa</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Master Vendor</li>
        <li class="breadcrumb-item active">Master Data Vendor Jasa</li>
    </ol>

    <div class="container-fluid">
        <!-- Kategori Jasa Card Grid -->

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-12">
                    <div class="card card-accent-primary shadow-sm">
                        <div class="card-header bg-white border-bottom-0 py-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="card-title mb-0" style="font-size: 1.1rem;">
                                        Master Data Vendor Jasa
                                    </h4>
                                    <small class="text-muted" style="font-size: 0.8rem;">Daftar Informasi Master Data
                                        Vendor</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="row mb-4 justify-content-center">
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/transportasi') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Transportasi</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                7</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/utility') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Utility</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                10</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/bengkel-luar') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Bengkel Luar</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                5</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/perawatan-gedung') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Perawatan Gedung</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                7</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/pajak') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Pajak</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                6</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/administrasi-kendaraan') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Administrasi Kendaraan
                                            </div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                7</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/jasa-perizinan') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Jasa Perizinan</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                7</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/remunerasi') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Remunerasi</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                34</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/jasa-koordinasi') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Jasa Koordinasi</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                34</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12 mb-3"
                                    style="flex:0 0 20%;max-width:20%;">
                                    <a href="{{ url('bod/bank-vendor/jasa/detail/others') }}"
                                        class="card text-center shadow-sm h-100"
                                        style="border:1px solid #ddd; text-decoration:none; color:inherit;">
                                        <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center"
                                            style="background: linear-gradient(to bottom, #f8f8f8 80%, #fff 100%); min-height:80px;">
                                            <div style="font-size:0.95rem; font-weight:500;">Others</div>
                                            <div style="color:#c00; font-size:1.1rem; font-weight:600; margin-top:4px;">
                                                34</div>
                                        </div>
                                    </a>
                                </div>
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

                </div>

                <div class="card border">

                    <div class="card-body p-0">
                        <div class="table-responsive">

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
