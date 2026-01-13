<nav class="sidebar-nav">
    <ul class="nav">
        <li class="nav-title">MENU</li>
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-home"></i> Dashboard
        </a>
        {{-- Master data --}}
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-drawer"></i> Master data
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bod_rekening.index') }}">
                        <i class="nav-icon icon-key"></i> Master No. rek/Token
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bod_bank_vendor.index') }}">
                        <i class="nav-icon icon-people"></i> Master data vendor
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bod_cheque.index') }}">
                        <i class="nav-icon icon-docs"></i> Master Cheque
                    </a>
                </li>
            </ul>
        </li>

        {{-- Status Cheque --}}
        <a class="nav-link" href="{{ route('status_cheque.index') }}">
            <i class="nav-icon icon-list"></i> Status Cheque
        </a>
        {{-- <li class="nav-item nav-dropdown">
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-pencil"></i> Persiapan Cheque
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-note"></i> Pengisian Cheque
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-tag"></i> Kategori cheque
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Pemberian cheque only
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-share"></i> Pemberian Cheque Transfer
                    </a>
                </li>
            </ul> 
        </li> --}}

        {{-- Summary Cheque --}}
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-doc"></i> Summary Cheque
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> cheque yang sudah di ttd, dan tujuan
                    </a>
                </li>
            </ul>
        </li>

        {{-- Status Transfer --}}
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-shuffle"></i> Status Transfer
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-cloud-upload"></i> Upload listing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Upload Verification listing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-lock"></i> Upload verification Otorisation listing
                    </a>
                </li>
            </ul>
        </li>

        {{-- status pembayaran biaya --}}
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-wallet"></i> status pembayaran biaya
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> biaya Lunas, cheque only
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> biaya Lunas, cheque Transfer
                    </a>
                </li>
            </ul>
        </li>

        {{-- Settlement Pelunasan Biaya per satu spp --}}
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-layers"></i> Settlement Pelunasan Biaya per satu spp
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Cheque Only
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Cheque transfer
                    </a>
                </li>
            </ul>
        </li>

        {{-- Summary SPP --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon icon-docs"></i> Summary SPP
            </a>
        </li>

        {{-- Menu lain yang tidak ada di gambar, dikomentari --}}
        {{--
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Otorisasi
                </a>
                ...
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('monitoring_cek.index') }}">
                    <i class="nav-icon icon-folder"></i> Monitoring Transaksi
                </a>
            </li>
        --}}
    </ul>
</nav>

@if (Auth::user()->type == 'uuu' || Auth::user()->type == 'uuu')
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="nav-icon icon-home"></i> Home
                </a>
            </li>

            <li class="nav-title">DAFTAR MENU</li>

            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '14')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Master No. Rek/Token
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_bank_vendor.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Master Data Vendor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_cheque.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Master Cheque
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_rekening.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_bank.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Bank Perusahaan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_transfer.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Transfer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_cheque_transfer.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque & Transfer
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Vendor
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_bank_vendor.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Bank
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Otorisasi
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Status Kategori SPP
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_spp_cheque.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> SPP Cheque
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_spp_transfer.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> SPP Tranfer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_spp_transfer_cek.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> SPP Cheque Tranfer
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Settlement
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_settlement_spp_cek.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Pengisian Cheque
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_settlement_permintaan_cek.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Permintaan Cheque
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Status Cheque
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque diterima
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque di TTD
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque diisi Nominal
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque diberikan vendor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque dimasukan ke bank
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Status Transfer
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Transfer Vendor Langsung
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Transfer Vendor Setelah Isi
                                Cheque
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Summary
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Transfer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque dan Transfer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_monitoring_cheque.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Monitoring Cheque
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Otorisasi
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_otorisasi_claim.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> APJ Payroll (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_lp.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> LP Payroll (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_ta_b.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> WPS Biaya (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_ta_b_odbc.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> WPS Biaya (OCBC)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_ta_p.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> WPS Payroll (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_ta_p_odbc.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> WPS Pengeluaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tgsm.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> TGSM Payroll (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tta_p.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> TTA Payroll (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tu_b.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> LP Biaya (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tu_b_odbc.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> LP Biaya (OCBC)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tu_p.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> LP Payroll (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tu_p_odbc.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> LP Pengeluaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tua_bbca.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> TUA Biaya (BCA)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tua_bocbc.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> TUA Biaya (OCBC)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('otorisasi_claim_tua_p.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> TUA Payroll (BCA)
                            </a>
                        </li>
                    </ul>
                </li>


                {{-- Monitoring Cek --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('monitoring_cek.index') }}">
                        <i class="nav-icon icon-folder"></i> Monitoring Transaksi
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
