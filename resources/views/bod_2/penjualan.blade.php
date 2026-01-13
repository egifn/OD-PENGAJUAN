@extends('page_layout.layout_master')
@push('style')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-16">MONITORING<br>
                            <p style="font-size: 10px;margin: 0px; font-weight: normal;">MONTH : <span
                                    id="label_month">0000-00-00</span></p>
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 0 0 14px 0;">
                <div class="col-md-12">
                    <div class="card card-accent-primary" style="border: 1px #cfcfcf dashed;">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="principal" class="col-sm-2 col-form-label">PRINCIPAL</label>
                                <div class="col-sm-4">
                                    <select name="principal" id="principal" class="form-control form-control-sm">
                                        <option value="">Pilih</option>
                                        <option value="PT. TIRTA INVESTAMA"
                                            {{ request('principal') == 'PT. TIRTA INVESTAMA' ? 'selected' : '' }}>PT.
                                            TIRTA INVESTAMA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="entitas" class="col-sm-2 col-form-label">ENTITAS</label>
                                <div class="col-sm-4">
                                    <select name="short_by_company" id="short_by_company"
                                        class="form-control form-control-sm">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="depo" class="col-sm-2 col-form-label">DEPO</label>
                                <div class="col-sm-4">
                                    <select name="short_by_branch" id="short_by_branch"
                                        class="form-control form-control-sm">
                                        <option value="">Pilih Depo</option>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="short_by_month" class="col-sm-2 col-form-label">BULAN</label>
                                <div class="col-sm-4">
                                    <input type="month" name="short_by_month" id="short_by_month"
                                        class="form-control form-control-sm" value="{{ request('short_by_month') }}"
                                        required>
                                </div>


                                <div class="col-sm-6">
                                    <button type="submit" id="button_sort" style="width: 125px;"
                                        class="btn btn-primary btn-sm">Cari</button>
                                </div>
                                <button type="button" id="button_sort_load" style="display: none"
                                    class="btn btn-soft-secondary btn-sm btn-load">
                                    <span class="d-flex align-items-center">
                                        <span class="flex-grow-1 me-2">
                                            Loading...
                                        </span>
                                        <span class="spinner-border flex-shrink-0" role="status"
                                            style="width: 15px; height: 15px;">
                                            <span class="visually-hidden">Loading...</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-h-100" style="border: 1px #cfcfcf dashed;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div>
                                <table class="table table-bordered table-sm nowrap w-100"
                                    style="max-width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                    <thead
                                        style="font-weight: 700; background-color: #e4e4e4;background-color: #e4e4e4;border: 1px solid #cacaca;">
                                        <tr class="text-center">
                                            <th rowspan="3" style="align-content: center;">TANGGAL</th>
                                            <th colspan="8">PENJUALAN</th>
                                            <th colspan="8">RUPIAH</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th colspan="3">QTY</th>
                                            <th colspan="3">KREDIT</th>
                                            <th rowspan="2" style="align-content: center;">SELISIH PENJUALAN</th>
                                            <th rowspan="2" style="align-content: center;">KET</th>
                                            <th colspan="3">TUNAI</th>
                                            <th colspan="3">KREDIT</th>
                                            <th rowspan="2" style="align-content: center;">SELISIH PENJUALAN</th>
                                            <th rowspan="2" style="align-content: center;">KET</th>
                                        </tr>
                                        <tr class="">
                                            <th>SPS</th>
                                            <th>JUGS</th>
                                            <th>OTHER</th>
                                            <th>SPS</th>
                                            <th>JUGS</th>
                                            <th>OTHER</th>
                                            <th>SPS</th>
                                            <th>JUGS</th>
                                            <th>OTHER</th>
                                            <th>SPS</th>
                                            <th>JUGS</th>
                                            <th>OTHER</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data_table">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modal')
@endpush
@push('script')
    {{-- -------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
    {{-- VARIABEL --}}
    {{-- -------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        // Variabel untuk filter/search
        const syCompany = document.getElementById('short_by_company');
        const syBranch = document.getElementById('short_by_branch');
        const syMonth = document.getElementById('short_by_month');

        // label
        const labelTotalMo = document.getElementById('label_total_mo');
        const labelTotalAo = document.getElementById('label_total_ao');
        const labelTotalGap = document.getElementById('label_total_gap');
        const labelTotalF2 = document.getElementById('label_total_f2');
        const labelTotalF4 = document.getElementById('label_total_f4');
        const labelTotalFOther = document.getElementById('frekuensi_other');

        // tabel
        const dataBody = document.getElementById('data_body');
        const viewResponseMessage = document.getElementById('view_response_message');
        const buttonSort = document.getElementById('button_sort');
        const buttonSortLoad = document.getElementById('button_sort_load');

        // details modal
        const componentModalDetailListAO = document.getElementById('component_modal_detail_ao');
        const dataTableDetail = document.getElementById('data_table_detail');
        const labelSalesDetail = document.getElementById('label_sales_detail');
        const labelCountDetailAo = document.getElementById('label_count_detail');
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const response = await fetch(`{{ route('monitoring.short_by_company') }}`);
                const data = await response.json();
                syCompany.innerHTML = '';
                syCompany.innerHTML = '<option value="">Pilih Entitas</option>';

                data.data.forEach(item => {
                    syCompany.innerHTML +=
                        `<option value="${item.kode_perusahaan}">${item.kode_perusahaan} | ${item.nama_perusahaan}</option>`;
                });
            } catch (error) {
                console.error('Error:', error);
            }
        });

        // Add event listener to fetch branches based on selected company
        syCompany.addEventListener('change', async function() {
            const selectedCompany = this.value;
            try {
                // Fetch branches filtered by selected company
                const response = await fetch(
                    `{{ route('monitoring.short_by_branch') }}?company=${selectedCompany}`);
                const data = await response.json();
                syBranch.innerHTML = '';
                syBranch.innerHTML = '<option value="">Pilih Depo</option>';
                data.data.forEach(item => {
                    syBranch.innerHTML +=
                        `<option value="${item.kode_depo}">${item.kode_depo} | ${item.nama_depo}</option>`;
                });
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
    <script>
        // Call fetchData when button is clicked
        buttonSort.addEventListener('click', _.debounce(function() {
            const syVCompany = syCompany.value;
            const syVBranch = syBranch.value;
            const syVMonth = syMonth.value;
            // Add missing fetchData call
            fetchData(syVCompany, syVBranch, syVMonth);
        }, 300));

        async function fetchData(syVCompany, syVBranch, syVMonth) {
            try {
                // Show loading state
                buttonSort.style.display = 'none';
                buttonSortLoad.style.display = 'inline-block';

                // Build URL
                const params = new URLSearchParams();
                if (syVCompany) params.append('company', syVCompany.trim());
                if (syVBranch) params.append('branch', syVBranch.trim());
                if (syVMonth) params.append('month', syVMonth.trim());

                const url = `{{ route('penjualan.data') }}${params.toString() ? '?' + params.toString() : ''}`;
                const response = await fetch(url);
                const data = await response.json();

                const dataBody = document.getElementById('data_table');
                dataBody.innerHTML = '';

                if (data.status == false) {
                    alertResponseError(data);
                    return;
                }

                if (!data.data || data.data.length === 0) {
                    alertResponseInfo("Tidak ada data yang ditemukan");
                    return;
                }

                // 1. Group data by date and payment type
                const dateGroups = {};

                data.data.forEach(item => {
                    const date = item.TANGGAL;
                    const paymentType = item['TIPE SALES'] === 'TUNAI' ? 'cash' : 'credit';
                    const sku = item.SKU;
                    const qty = parseFloat(item.QTY) || 0;
                    const amount = parseFloat(item['AFTER PROMO']) || 0;

                    if (!dateGroups[date]) {
                        dateGroups[date] = {
                            cash: {
                                SPS: {
                                    qty: 0,
                                    amount: 0
                                },
                                JUGS: {
                                    qty: 0,
                                    amount: 0
                                },
                                OTHER: {
                                    qty: 0,
                                    amount: 0
                                },
                                totalQty: 0,
                                totalAmount: 0
                            },
                            credit: {
                                SPS: {
                                    qty: 0,
                                    amount: 0
                                },
                                JUGS: {
                                    qty: 0,
                                    amount: 0
                                },
                                OTHER: {
                                    qty: 0,
                                    amount: 0
                                },
                                totalQty: 0,
                                totalAmount: 0
                            }
                        };
                    }

                    if (['SPS', 'JUGS', 'OTHER'].includes(sku)) {
                        dateGroups[date][paymentType][sku].qty += qty;
                        dateGroups[date][paymentType][sku].amount += amount;
                        dateGroups[date][paymentType].totalQty += qty;
                        dateGroups[date][paymentType].totalAmount += amount;
                    }
                });

                // 2. Build table rows
                let tableHTML = '';

                Object.entries(dateGroups).forEach(([date, groups]) => {
                    const cash = groups.cash;
                    const credit = groups.credit;

                    const dateOnly = date.split('-')[2];
                    const dateNumber = parseInt(dateOnly);

                    const qtyDifference = cash.totalQty - credit.totalQty;
                    const amountDifference = cash.totalAmount - credit.totalAmount;

                    tableHTML += `
                <tr>
                     <td>${dateNumber}</td> 
                    
                    <!-- QTY Columns -->
                    <td>${cash.SPS.qty.toLocaleString('id-ID')}</td>
                    <td>${cash.JUGS.qty.toLocaleString('id-ID')}</td>
                    <td>${cash.OTHER.qty.toLocaleString('id-ID')}</td>
                    <td>${credit.SPS.qty.toLocaleString('id-ID')}</td>
                    <td>${credit.JUGS.qty.toLocaleString('id-ID')}</td>
                    <td>${credit.OTHER.qty.toLocaleString('id-ID')}</td>
                    <td>${qtyDifference.toLocaleString('id-ID')}</td>
                    <td></td>
                    
                    <!-- Amount Columns -->
                    <td>${cash.SPS.amount.toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0})}</td>
                    <td>${cash.JUGS.amount.toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0})}</td>
                    <td>${cash.OTHER.amount.toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0})}</td>
                    <td>${credit.SPS.amount.toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0})}</td>
                    <td>${credit.JUGS.amount.toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0})}</td>
                    <td>${credit.OTHER.amount.toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0})}</td>
                    <td>${amountDifference.toLocaleString('id-ID', {style: 'currency', currency: 'IDR', minimumFractionDigits: 0})}</td>
                    <td></td>
                </tr>
            `;
                });

                dataBody.innerHTML = tableHTML;

            } catch (error) {
                console.error("Error:", error);
                alertResponseError("Terjadi kesalahan saat mengambil data: " + error.message);
            } finally {
                buttonSort.style.display = 'inline-block';
                buttonSortLoad.style.display = 'none';
            }
        }
    </script>
@endpush
