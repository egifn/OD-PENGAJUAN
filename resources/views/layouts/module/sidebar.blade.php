<nav class="sidebar-nav">
    <ul class="nav">
        <li class="nav-title">MENU</li>

        {{-- Dashboard --}}
        <li
            class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="nav-icon icon-home"></i> Dashboard
            </a>
        </li>

        {{-- Master Data --}}
        @php
            $masterDataRoutes = [
            'bod_rekening.*',
            'bod_bank_vendor.*',
            'bod_cheque.*'
            ];
            $isMasterDataActive = false;
            foreach($masterDataRoutes as $route) {
            if(request()->routeIs($route)) {
            $isMasterDataActive = true;
            break;
            }
            }
        @endphp

        <li
            class="nav-item nav-dropdown {{ $isMasterDataActive ? 'open' : '' }}">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-drawer"></i> Master Data
            </a>
            <ul class="nav-dropdown-items">
                {{-- Master No. Rek/Token --}}
                <li
                    class="nav-item {{ request()->routeIs('bod_rekening.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('bod_rekening.index') }}">
                        <i class="nav-icon icon-key"></i> Master No. Rek/Token
                    </a>
                </li>

                {{-- Master Data Vendor --}}
                @php
                    $isVendorActive = request()->routeIs('bod_bank_vendor.*');
                @endphp

                <li
                    class="nav-item nav-dropdown {{ $isVendorActive ? 'open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-people"></i> Master Data Vendor
                    </a>
                    <ul class="nav-dropdown-items">
                        <li
                            class="nav-item {{ request()->routeIs('bod_bank_vendor.jasa') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('bod_bank_vendor.jasa') }}">
                                <i class="nav-icon icon-briefcase"></i> Jasa
                            </a>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('bod_bank_vendor.barang') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('bod_bank_vendor.barang') }}">
                                <i class="nav-icon icon-basket"></i> Barang
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Master Cheque --}}
                <li
                    class="nav-item {{ request()->routeIs('bod_cheque.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('bod_cheque.index') }}">
                        <i class="nav-icon icon-docs"></i> Master Cheque
                    </a>
                </li>
            </ul>
        </li>

        {{-- Status Cheque --}}
        <li
            class="nav-item {{ request()->routeIs('status_cheque.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('status_cheque.index') }}">
                <i class="nav-icon icon-list"></i> Status Cheque
            </a>
        </li>

        {{-- Summary Cheque --}}
        @php
            $isSummaryChequeActive = false; // Ganti dengan kondisi sesuai route Anda
        @endphp

        <li
            class="nav-item nav-dropdown {{ $isSummaryChequeActive ? 'open' : '' }}">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-doc"></i> Summary Cheque
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Cheque yang sudah di TTD, dan tujuan
                    </a>
                </li>
            </ul>
        </li>

        {{-- Status Transfer --}}
        @php
            $isStatusTransferActive = false; // Ganti dengan kondisi sesuai route Anda
        @endphp

        <li
            class="nav-item nav-dropdown {{ $isStatusTransferActive ? 'open' : '' }}">
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

        {{-- Status Pembayaran Biaya --}}
        @php
            $isPembayaranBiayaActive = false; // Ganti dengan kondisi sesuai route Anda
        @endphp

        <li
            class="nav-item nav-dropdown {{ $isPembayaranBiayaActive ? 'open' : '' }}">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-wallet"></i> Status Pembayaran Biaya
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Biaya Lunas, cheque only
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Biaya Lunas, cheque Transfer
                    </a>
                </li>
            </ul>
        </li>

        {{-- Settlement Pelunasan Biaya per satu SPP --}}
        @php
            $isSettlementActive = false; // Ganti dengan kondisi sesuai route Anda
        @endphp

        <li
            class="nav-item nav-dropdown {{ $isSettlementActive ? 'open' : '' }}">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-layers"></i> Settlement Pelunasan Biaya per satu SPP
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Cheque Only
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-check"></i> Cheque Transfer
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
    </ul>
</nav>
