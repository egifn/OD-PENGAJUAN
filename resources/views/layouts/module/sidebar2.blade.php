<nav class="sidebar-nav">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="nav-icon icon-home"></i> Home
            </a>
        </li>

        <li class="nav-title">DAFTAR MENU</li>

        @if (Auth::user()->kode_divisi == '21')
            <!-- jika Pembelian -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Master Data
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master_sku.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Harga SKU
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->kode_divisi == '1')
            <!-- HRD -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Master Data
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('karyawan.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Karyawan
                        </a>
                    </li>
                </ul>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tunjangan.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Tunjangan
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->kode_perusahaan == 'TUA')
            @if (Auth::user()->kode_depo == '002')
                @if (Auth::user()->kode_divisi == '13') <!-- jika SND -->
                    @if (Auth::user()->kode_sub_divisi != '12')
                        @if (Auth::user()->type == 'Admin')
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon icon-folder"></i> Master Data
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekening_outlet.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Rekening Outlet
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endif
                @endif
            @endif
        @endif

        @if (Auth::user()->kode_divisi == '100' ||
                Auth::user()->kode_divisi == '5' ||
                Auth::user()->kode_divisi == '23' ||
                Auth::user()->kode_divisi == '8')

            @if (Auth::user()->kode_divisi == '23' && Auth::user()->kode_depo == '002')
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '23')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user_registration.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                                </a>
                            </li>
                            @if (Auth::user()->kode_divisi == '23')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('perusahaan_korsis.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Perusahaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('depo_korsis.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Depo
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('perusahaan.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Perusahaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('depo.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Depo
                                    </a>
                                </li>
                            @endif

                        @endif

                        @if (Auth::user()->kode_divisi == '100')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('divisi.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Divisi
                                </a>
                            </li>


                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Chart Of Account
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('coa_1.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Layer 1
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('coa_2.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Layer 2
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('coa_3.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Layer 3
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('coa_4.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Layer 4
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('coa.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> C O
                                            A
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('coa_transaction.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> COA Transaction
                                </a>
                            </li>


                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Produk
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('category.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Kategori
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('product.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Produk
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        <!-- MENU REKONSILIASI -->
                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '8')
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekonsiliasi
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('bank.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Bank
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekening.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Rekening
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('virtualaccount.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Virtual Account
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('master_selisih.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Selisih
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- MENU KEUANGAN / FINANCE -->
                        @if (Auth::user()->kode_divisi == '5' || Auth::user()->kode_divisi == '100')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bank_fin.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Bank
                                </a>
                            </li>
                            <li class="nav-item" hidden>
                                <a class="nav-link" href="{{ route('rekening_fin.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vendor_fin.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Vendor
                                </a>
                            </li>
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Account
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekening_fin_comp.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Company Account
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekening_fin.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Vendor Account
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Category
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('category_fin.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Book of Cek/Giro
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sub_category_fin.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Expenditure
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Type
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('type.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Type
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sub_type.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Sub
                                            of Type
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        @if (Auth::user()->kode_divisi == '0')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengeluaran.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Pengeluaran
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->kode_divisi == '100')
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Harga Pembelian
                                </a>
                            </li>
                        @endif

                        <!-- @if (Auth::user()->kode_divisi == '12' || Auth::user()->kode_divisi == '100')
<li class="nav-item">
       <a class="nav-link" href="{{ route('vendor_category.index') }}">
        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Vendor Category
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" href="{{ route('vendor_sp.index') }}">
        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Vendor Sparepart
       </a>
      </li>
@endif -->


                        @if (Auth::user()->kode_divisi == '20' || Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '22')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('area.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Area
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('area_sub.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Area Sub
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('warehouse.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Warehouse
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('checker.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Checker
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '16')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tarif_bbm.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tarif BBM
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tarif Uang Rit
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        @elseif(Auth::user()->kode_divisi == '20' || Auth::user()->kode_divisi == '22')
            <!-- Gudang dan Checker -->

            @if (Auth::user()->type == 'Manager')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('area.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Area
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('area_sub.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Area Sub
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('warehouse.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Warehouse
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('checker.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Checker
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @elseif(Auth::user()->kode_divisi == '11')
            <!-- Purchasing -->
            @if (Auth::user()->type == 'Manager')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user_registration.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                            </a>
                        </li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Produk
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('category.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Kategori
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('product.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Produk
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor_fin.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Vendor
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rekening_fin.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('budget_atk.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Budget ATK
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Petty Cash
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Produk
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('category.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Kategori
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('product.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Produk
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor_fin.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Vendor
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rekening_fin.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('budget_atk.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Budget ATK
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Petty Cash
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @elseif(Auth::user()->kode_divisi == '4')
            <!-- GA -->
            @if (Auth::user()->type == 'Manager')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user_registration.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                            </a>
                        </li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Produk
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('category.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Kategori
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('product.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Produk
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('budget_atk.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Budget ATK
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('asset_list.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> List Asset
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('asset_pemegang.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Pemegang Asset
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('asset_penempatan.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Penempatan Asset
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Produk
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('category.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Kategori
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('product.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Produk
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('budget_atk.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Budget ATK
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('asset_list.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> List Asset
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('asset_pemegang.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Pemegang Asset
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('asset_penempatan.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Penempatan Asset
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @elseif(Auth::user()->kode_divisi == '2')
            <!-- OPS HO -->
            @if (Auth::user()->type == 'Manager')
                @if (Auth::user()->kode_perusahaan != 'ARS')
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-folder"></i> Master Data
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user_registration.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('budget_atk.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Budget ATK
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @else
                @if (Auth::user()->kode_sub_divisi == '18' ||
                        Auth::user()->kode_sub_divisi == '19' ||
                        Auth::user()->kode_sub_divisi == '20')
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-folder"></i> Master Data
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user_registration.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('budget_atk.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Budget ATK
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    @if (Auth::user()->kode_perusahaan != 'ARS')
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-folder"></i> Master Data
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('budget_atk.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Budget ATK
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
            @endif
        @elseif(Auth::user()->kode_divisi == '24')
            <!-- Piutang -->
            @if (Auth::user()->type == 'Manager')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user_registration.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('piutang_master_rek.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Norek Pelanggan
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('piutang_master_rek.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Norek Pelanggan
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @elseif(Auth::user()->kode_divisi == '16')
            <!-- biaya/cost -->
            @if (Auth::user()->type == 'Manager')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user_registration.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tarif_bbm.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tarif BBM
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tarif_bbm.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tarif BBM
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @elseif(Auth::user()->kode_divisi == '31')
            <!-- Logistik -->
            @if (Auth::user()->type == 'Manager')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user_registration.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logistik_uang_rit.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Uang RIT
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logistik_uang_rit.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Uang RIT
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @else
            @if (Auth::user()->type == 'Manager')
                @if (Auth::user()->kode_sub_divisi == null)
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-folder"></i> Master Data
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user_registration.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::user()->kode_sub_divisi == '5' || Auth::user()->kode_sub_divisi == '4')
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-folder"></i> Master Data
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user_registration.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> User Registration
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bank_fin.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Bank
                                </a>
                            </li>
                            <li class="nav-item" hidden>
                                <a class="nav-link" href="{{ route('rekening_fin.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vendor_fin.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Vendor
                                </a>
                            </li>
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Account
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekening_fin_comp.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Company Account
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekening_fin.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Vendor Account
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        @endif

        <!--jika Divisi fleet untuk input BBM-->
        @if (Auth::user()->kode_divisi == '36') <!--jika Divisi fleet-->
            @if (Auth::user()->type == 'Manager')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_biaya_masuk_bbm.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Biaya BBM Sales
                            </a>
                        </li>
                    </ul>
                </li>
            @elseif(Auth::user()->type == 'Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan_biaya_bbm_sales.index') }}">
                        <i class="nav-icon icon-folder"></i> Input BBM Sales
                    </a>
                </li>
            @endif
        @endif
        <!--jika Divisi fleet-->

        @if (Auth::user()->type == 'Admin' || Auth::user()->type == 'Administrator' || Auth::user()->type == 'Manager')
            @if (Auth::user()->kode_sub_divisi == '2' || Auth::user()->kode_sub_divisi == '3') <!-- Jatuh Tempo -->
                <li class="nav-item nav-dropdown" hidden>
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Pengajuan
                    </a>
                    <ul class="nav-dropdown-items">
                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '11')
                            <!-- PURCHASING -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_vendor.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Vendor
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_biaya.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sppd.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPPD
                            </a>
                        </li>
                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '11')
                            <!-- PURCHASING -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_spp.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPP
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @elseif(Auth::user()->kode_divisi == '36')
                <!-- jika divisi fleet -->
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Pengajuan
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_biaya.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_b_bbm_sales_lnjtn.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya BBM Sales
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Pengajuan
                    </a>
                    <ul class="nav-dropdown-items">
                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '11')
                            <!-- PURCHASING -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_vendor.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Vendor
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_biaya.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sppd.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPPD
                            </a>
                        </li>
                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '11' || Auth::user()->kode_divisi == '6')
                            <!-- PURCHASING -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_spp.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPP
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        @endif

        <!-- Pelacakan pengajuan -->
        @if (Auth::user()->type == 'Admin' || Auth::user()->type == 'Administrator' || Auth::user()->type == 'Manager')
            @if (Auth::user()->kode_sub_divisi == '2' ||
                    Auth::user()->kode_sub_divisi == '3' ||
                    Auth::user()->kode_sub_divisi == '6') <!-- Jatuh Tempo -->
            @else
                @if (Auth::user()->kode_divisi == '36')
                    <!--jika Divisi fleet-->
                @else
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengajuan_lacak.index') }}">
                            <i class="nav-icon icon-folder"></i> Lacak Pengajuan
                        </a>
                    </li> --}}
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-folder"></i> Lacak Pengajuan
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_lacak.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_lacak_biaya.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        @endif

        @if (Auth::user()->kode_divisi == '11')
            @if (Auth::user()->kode_sub_divisi == '11')
                <li class="nav-title">Barang</li>
            @endif
        @endif

        <!-- VAlidasi/Pengecekan/Pengajuan Masuk  -->
        @if (Auth::user()->type == 'Admin' || Auth::user()->type == 'Administrator')
            @if (Auth::user()->kode_divisi != '20')
                @if (Auth::user()->kode_sub_divisi == '2' ||
                        Auth::user()->kode_sub_divisi == '3' ||
                        Auth::user()->kode_sub_divisi == '9' ||
                        Auth::user()->kode_sub_divisi == '10' ||
                        Auth::user()->kode_sub_divisi == '22')
                    <li class="nav-item" hidden>
                        <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                            <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                        </a>
                    </li>
                @else
                    @if (Auth::user()->kode_divisi == '3' ||
                            Auth::user()->kode_divisi == '4' ||
                            Auth::user()->kode_divisi == '2' ||
                            Auth::user()->kode_divisi == '11')
                        <!-- Jika IT, GA, OPS, Purchasing  -->
                        @if (Auth::user()->kode_perusahaan == 'TUA')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_masuk.index') }}">
                                    <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                                </a>
                            </li>
                        @endif
                    @elseif(Auth::user()->kode_divisi == '6' ||
                            Auth::user()->kode_divisi == '16' ||
                            Auth::user()->kode_divisi == '5' ||
                            Auth::user()->kode_divisi == '10' ||
                            Auth::user()->kode_divisi == '1')
                        <!-- Jika Cost,ACC,Claim,Finance  -->
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                            </a>
                            <ul class="nav-dropdown-items">
                                @if (Auth::user()->kode_divisi == '10')
                                    <!-- Jika Claim  -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                                        </a>
                                    </li>
                                @elseif(Auth::user()->kode_divisi == '5')
                                    <!-- Jika Finance  -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                        </a>
                                    </li>
                                    <li class="nav-item" hidden>
                                        <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                                        </a>
                                    </li>
                                @elseif(Auth::user()->kode_divisi == '1')
                                    <!-- Jika HRD  -->
                                    <li class="nav-item" hidden>
                                        <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                        </a>
                                    </li>
                                    <li class="nav-item" hidden>
                                        <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sppd_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPPD
                                        </a>
                                    </li>
                                @elseif(Auth::user()->kode_divisi == '16')
                                    <!-- Jika Cost/biaya  -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sppd_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPPD
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
            @endif
        @elseif(Auth::user()->type == 'User')
            @if (Auth::user()->kode_sub_divisi == '2' || Auth::user()->kode_sub_divisi == '3')
                <li class="nav-item" hidden>
                    <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                        <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                        <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                    </a>
                </li>
            @endif
        @endif


        <!-- APPROVAL -->
        @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
            @if (Auth::user()->kode_divisi == '100' ||
                    Auth::user()->kode_divisi == '2' ||
                    Auth::user()->kode_divisi == '3' ||
                    Auth::user()->kode_divisi == '4' ||
                    Auth::user()->kode_divisi == '11' ||
                    Auth::user()->kode_divisi == '17')
                @if (Auth::user()->kode_perusahaan == 'TUA')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('approval.index') }}">
                            <i class="nav-icon icon-folder"></i> App Pengajuan
                        </a>
                    </li>
                @endif
            @endif
        @endif

        @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '11')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('approval_kontrabon.index') }}">
                        <i class="nav-icon icon-folder"></i> App Kontrabon
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rekap_atk_app.index') }}">
                        <i class="nav-icon icon-folder"></i> App Rekap ATK
                    </a>
                </li>
            @endif
        @endif

        <!-- Akunting Menu SPP  -->
        @if (Auth::user()->kode_perusahaan == 'TUA')
            @if (Auth::user()->kode_depo == '002')
                @if (Auth::user()->kode_divisi == '6') <!-- jika Akunting -->
                    @if (Auth::user()->type == 'Admin')
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-folder"></i> SPP
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('spp_import.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Import SPP
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('spp.create') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Buat SPP
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('spp_group.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Buat SPP Group
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('spp.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> History SPP
                                    </a>
                                </li>
                                <li class="nav-item" hidden>
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Status SPP
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
            @endif
        @endif

        @if (Auth::user()->type == 'Admin')
            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '6')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('approval_kontrabon.index') }}">
                        <i class="nav-icon icon-folder"></i> App Kontrabon
                    </a>
                </li>
            @endif
        @endif

        <!-- APPROVAL BOD -->
        @if (Auth::user()->type == 'Bod' || Auth::user()->type == 'Administrator')
            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '14')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Master Data
                    </a>
                    <ul class="nav-dropdown-items">
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
                            <a class="nav-link" href="{{ route('bod_cheque.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cheque
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
                <!-- <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Vendor
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_vendor.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Pengajuan Vendor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Vendor disetujui
                            </a>
                        </li>
                    </ul>
                </li> -->

                {{-- <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Daftar Pengajuan
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_bod.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Proses Pengajuan
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_biaya.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                            </a>
                        </li>
                    </ul>
                </li>
                    
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Approval Izin
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_a.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin A
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_b.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin B
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_c.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin C
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_d.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin D
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_e.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin E
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_f.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin F
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin G
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_h.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin H
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bod_otorisasi.index') }}">
                        <i class="nav-icon icon-folder"></i> Otorisasi Transfer
                    </a>
                </li> --}}

                <!-- <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Biaya Non Tunai
                    </a>
  <ul class="nav-dropdown-items">
   <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Pengajuan
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_bod.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Status Pengajuan
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod_biaya.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Approval Izin
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_a.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin A
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_b.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin B
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_c.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin C
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_d.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin D
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_e.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin E
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_f.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin F
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin G
                                    </a>
                                </li>
        <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_h.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin H
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin I
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Izin J
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Otorisasi Transfer
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod_otorisasi.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> HRD
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod_otorisasi_claim.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Program Claim
                                    </a>
                                </li> --}}
                            </ul>

                            {{-- <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Otorisasi Transfer
                            </a> --}}
                        </li>
  </ul>
  </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> SPPD
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Pengajuan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Status Pengajuan
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Biaya Tunai
                    </a>
  <ul class="nav-dropdown-items">
   <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tanpa Persetujuan
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daftar Pengajuan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Status Pengajuan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Saldo
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Persetujuan
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daftar Pengajuan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Status Pengajuan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Saldo
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Petty Cash
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daftar Pengajuan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Status Pengajuan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Saldo
                                    </a>
                                </li>
                            </ul>
                        </li>
  </ul>
  </li>
    <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Claim
                    </a>
  <ul class="nav-dropdown-items">
   {{-- <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Pengajuan
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                        {{-- <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Status Validasi
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod_biaya.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_bod_biaya_claim.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Daftar Program
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bod_biaya_claim.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Status Validasi
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_claim_daftar_do.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>DO Program
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_claim_daftar_perhitungan.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Rekap Perhitungan
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_claim_daftar_hitunga_program.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Perhitungan Program
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_claim_daftar_status_hitung.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Status Pengajuan
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_claim_daftar_persiapan_bayar.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Persiapan Bayar
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_status_pembayaran.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Status Pembayaran
                            </a>
                        </li>
                        
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_claim_daftar_upload.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Upload
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="{{ route('bod_claim_daftar_otorisasi.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Otorisasi
                            </a>
                        </li>
                        <li class="nav-item" hidden>
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Bukti Otorisasi
                            </a>
                        </li>

                        
  </ul>
  </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Biaya Prepaid
                    </a>
  <ul class="nav-dropdown-items">
   {{-- <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Pengajuan
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                        {{-- <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Status Validasi
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Barang
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bod_biaya.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_bod_biaya_prepaid.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daftar Pengajuan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Status Persetujuan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daftar Persetujuan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Jadwal Pembayaran
                            </a>
                        </li>
  </ul>
  </li> -->

                {{-- Monitoring Cek --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('monitoring_cek.index') }}">
                        <i class="nav-icon icon-folder"></i> Monitoring Transaksi
                    </a>
                </li>
            @endif
        @endif

        <!-- Approval Biaya / Non Barang -->
        @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
            <!-- APPROVAL ACCOUNTING -->
            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '6' || Auth::user()->kode_divisi == '5')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Approval
                    </a>
                    <ul class="nav-dropdown-items">
                        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '5')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('approval_cost.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya
                                </a>
                            </li>
                        @elseif(Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '6')
                            @if (Auth::user()->kode_sub_divisi == '5')
                                <!-- Manager Biaya Acc -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_cost.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_tiv.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_spp.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPP
                                    </a>
                                </li>
                            @elseif(Auth::user()->kode_sub_divisi == '4')
                                <!-- Manager Acc -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_cost.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_spp.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPP
                                    </a>
                                </li>
                            @elseif(Auth::user()->kode_sub_divisi == '0')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_cost.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_tiv.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_spp.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPP
                                    </a>
                                </li>
                            @endif
                        @endif

                    </ul>
                </li>
            @endif

            <!-- APPROVAL BIAYA (COST) -->
            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '16')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Approval
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_cost.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_tiv.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_sppd.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPPD
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <!-- APPROVAL CLAIM -->
            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '10')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Approval
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_cost.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('approval_tiv.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan TIV
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <!-- APPROVAL HRD (SPPD) -->
            @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '1')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('approval_sppd.index') }}">
                        <i class="nav-icon icon-folder"></i> Approval SPPD
                    </a>
                </li>
            @endif
        @endif

        <!-- ACCOUNTING -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '6')
            @if (Auth::user()->kode_sub_divisi == '2' || Auth::user()->kode_sub_divisi == '3')
                <!-- Jatuh Tempo -->
                <li class="nav-item" hidden>
                    <a class="nav-link" href="{{ route('jurnal_umum.index') }}">
                        <i class="nav-icon icon-folder"></i> Jurnal Umum
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('jurnal_umum.index') }}">
                        <i class="nav-icon icon-folder"></i> Jurnal Umum
                    </a>
                </li>
            @endif

        @endif
        <!-- ######################################## -->

        <!-- ACCOUNTING dan KORSIS -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '6' || Auth::user()->kode_divisi == '23')
            @if (Auth::user()->kode_sub_divisi == '2' || Auth::user()->kode_sub_divisi == '3')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Jatuh Tempo
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('due_date.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> TUA
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('due_date_alfred.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Alfred
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('due_date_dts.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> DTS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('due_date_sukanda.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Sukanda
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item" hidden>
                    <a class="nav-link" href="{{ route('due_date.index') }}">
                        <i class="nav-icon icon-folder"></i> Jatuh Tempo
                    </a>
                </li>
            @endif
        @endif
        <!-- End ACCOUNTING -->

        <!-- KORSIS -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '6' || Auth::user()->kode_divisi == '23')
            @if (Auth::user()->kode_sub_divisi == '2' || Auth::user()->kode_sub_divisi == '3')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Daftar Jatuh Tempo
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('list_due_date.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> TUA
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('list_due_date_alfred.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Alfred
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('list_due_date_dts.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> DTS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('list_due_date_sukanda.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Sukanda
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item" hidden>
                    <a class="nav-link" href="{{ route('list_due_date.index') }}">
                        <i class="nav-icon icon-folder"></i> Daftar Jatuh Tempo
                    </a>
                </li>
            @endif
        @endif
        <!-- END KORSIS -->

        <!-- PIUTANG dan KASIR -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '24')
            <!-- piutang -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pelunasan.create') }}">
                    <i class="nav-icon icon-folder"></i> Pelunasan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pelunasan.index') }}">
                    <i class="nav-icon icon-folder"></i> Data Pelunasan
                </a>
            </li>
        @elseif(Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '25')
            <!-- Kasir dan Rekon -->
            <li class="nav-item" hidden>
                <a class="nav-link" href="{{ route('pelunasan.create') }}">
                    <i class="nav-icon icon-folder"></i> Pelunasan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pelunasan.index') }}">
                    <i class="nav-icon icon-folder"></i> Data Pelunasan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pelunasan/view.view') }}">
                    <i class="nav-icon icon-folder"></i> Data Validasi
                </a>
            </li>
            <li class="nav-item" hidden>
                <a class="nav-link" href="#">
                    <i class="nav-icon icon-folder"></i> Data Clearing
                </a>
            </li>
        @endif
        <!-- END PIUTANG -->

        <!-- REKONSILIASI dan REKONSILIASI SALDO -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '8')
            <!-- Jika Bagian Rekon SALDO -->
            @if (Auth::user()->kode_sub_divisi == '6')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Wenang Palm Solusindo
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_penjualan_tunai_ta.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Penjualan Tunai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_tagihan_tunai_ta.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tagihan Tunai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_tagihan_kredit_ta.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tagihan Kredit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_rekening_master_ta.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening Master
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Lokon Prima
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_penjualan_tunai_tu.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Penjualan Tunai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_tagihan_tunai_tu.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tagihan Tunai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_tagihan_kredit_tu.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tagihan Kredit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_rekening_master_tu.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening Master
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Tirta Utama Abadi
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_penjualan_tunai_tua.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Penjualan Tunai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_tagihan_tunai_tua.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tagihan Tunai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_tagihan_kredit_tua.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Tagihan Kredit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saldo_rekening_master_tua.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening Master
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Non Gudang
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> No rek 1
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> No Rek 2
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> TGSM
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> No rek 1
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> No Rek 2
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Informasi
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('opening_closing_rek.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Opening Closing
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Saldo Rekening
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <!-- Jika Bagian Rekon bukan SALDO -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rekon_pelunasan.index') }}">
                        <i class="nav-icon icon-folder"></i> Data Pelunasan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('saldo.index') }}">
                        <i class="nav-icon icon-folder"></i> Saldo
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('monitoring.index') }}">
                        <i class="nav-icon icon-folder"></i> Monitoring
                    </a>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Rekonsiliasi
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('catatanrekening.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Import Rekening
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mutasirekening.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Mutasi Rekening
                            </a>
                        </li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Transaksi
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('kredit.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Non
                                        Tunai Kredit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tagihan_tunai.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Tagihan Tunai
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('penjualan_tunai.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Penjualan Tunai
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tunai_transfer.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Tunai
                                        Transfer
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Informasi
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Transaksi
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Non
                                        Tunai Kredit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Tagihan Tunai
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Penjualan Tunai
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Tunai
                                        Transfer
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Reckoning
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Selisih
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Laporan Rekonsiliasi
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif
        <!-- END REKONSILIASI -->

        <!-- FINANCE -->
        @if (Auth::user()->kode_divisi == '5' || Auth::user()->kode_divisi == '100')
            @if (Auth::user()->kode_sub_divisi == '1') <!-- Finance SPP -->
            @elseif(Auth::user()->kode_sub_divisi == '7')
                <!-- Finance SPP -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan_biaya_upload.index') }}">
                        <i class="nav-icon icon-folder"></i> Upload
                    </a>
                </li>
            @elseif(Auth::user()->kode_sub_divisi == '22')
                <!-- Finance SPP -->
                {{-- Mernu Transfer --}}
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Transfer
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Program Claim
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('transfer_program_claim.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        Transfer
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('transfer_program_claim_his.index') }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                        History
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

                {{-- Pengajuan Cek/Giro --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan_cek_giro.index') }}">
                        <i class="nav-icon icon-folder"></i> Pengajuan Cek/Giro
                    </a>
                </li>
            @elseif(Auth::user()->kode_sub_divisi == '8')
                <!-- Finance SPP -->
            @else
                {{-- Pengajuan Cek/Giro --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan_cek_giro.index') }}">
                        <i class="nav-icon icon-folder"></i> Pengajuan Cek/Giro
                    </a>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Finance
                    </a>
                    <ul class="nav-dropdown-items">
                        @if (Auth::user()->kode_sub_divisi != '1' || Auth::user()->kode_sub_divisi == '')
                            <li class="nav-item nav-dropdown">

                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Rekening
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('import_account.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Import Rekening
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('mutasirekening_fin.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Mutasi Rekening
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Opening Closing
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


                        @if (Auth::user()->kode_sub_divisi == '1' || Auth::user()->kode_sub_divisi == '')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('list_spp.index') }}">
                                    &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Pembayaran
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->kode_sub_divisi != '1' || Auth::user()->kode_sub_divisi == '')
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Cek/Giro
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item" hidden>
                                        <a class="nav-link" href="{{ route('pendaftaran_cek_giro.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Registration
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pengisian_cek_giro.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Pengisian
                                        </a>
                                    </li>
                                    <li class="nav-item" hidden>
                                        <a class="nav-link" href="#">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Receipt
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Izin
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_a.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin A
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_b.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin B
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin C
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_d.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin D
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_e.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin E
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_f.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin F
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_g.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin G
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_h.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin H
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_i.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin I
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tanda_terima_j.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Izin J
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Approval
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_a.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval A
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_b.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval B
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_c.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval C
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_d.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval D
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_e.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval E
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_f.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval F
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_g.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval G
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('approval_h.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Approval H
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Report
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> SPP
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('report_cekgiro.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Cek/Giro
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('report_permission.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i> Permission
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>

                {{-- Monitoring Cek --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('monitoring_cek.index') }}">
                        <i class="nav-icon icon-folder"></i> Monitoring Transaksi
                    </a>
                </li>

                {{-- Berita acara --}}
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Berita Acara
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Berita Acara 1
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> satu
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> dua
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Berita Acara 2
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Berita Acara 3
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif

        <!-- PURCHASING -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '11')
            @if (Auth::user()->kode_sub_divisi == '11')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rekap_atk.index') }}">
                        <i class="nav-icon icon-folder"></i> Rekap ATK
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rekap_data_atk.index') }}">
                        <i class="nav-icon icon-folder"></i> Data Rekap ATK
                    </a>
                </li>
            @endif
        @endif

        <!-- PURCHASING -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '11')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Purchase & Payment
                </a>
                <ul class="nav-dropdown-items">
                    @if (Auth::user()->kode_sub_divisi == '10') <!-- jika PO -->
                    @else
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Pengajuan
                            </a>
                            <ul class="nav-dropdown-items">
                                @if (Auth::user()->kode_sub_divisi == '9')
                                    <!-- jika PO -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('request_purchasing.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Barang
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('po_gabungan.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Gabungan
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('request_purchasing.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Barang
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('request_cost.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Biaya
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('request_sppd.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            SPPD
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>
                                            Uang Rit
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif


                    @if (Auth::user()->kode_sub_divisi == '9')
                        <!-- jika PO -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('purchasing.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> PO
                            </a>
                        </li>
                    @elseif(Auth::user()->kode_sub_divisi == '10')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('accepted.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Kontrabon
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('counter_bill.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Kontrabon
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('supplier_bill.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Bayar Vendor
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('purchasing.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> PO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('accepted.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Kontrabon
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('counter_bill.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Daftar Kontrabon
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('supplier_bill.index') }}">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Bayar Vendor
                            </a>
                        </li>

                        <li class="nav-item" hidden>
                            <a class="nav-link" href="#">
                                &nbsp;&nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Laporan
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->kode_divisi == '11')
            @if (Auth::user()->kode_sub_divisi == '11')
                <li class="nav-title">Biaya/Jasa</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan_biaya_masuk.index') }}">
                        <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                    </a>
                </li>
            @endif
        @endif

        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '0')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Cost
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="nav-icon icon-control-play"></i> Bla bla
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- ACCOUNTING dan GA -->
        <!-- @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '6' || Auth::user()->kode_divisi == '16')
<li class="nav-item">
            <a class="nav-link" href="{{ route('approval_cost.index') }}">
                <i class="nav-icon icon-folder"></i> Approval (Cost)
            </a>
        </li>
@endif
  -->



        <!-- CLAIM -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '10')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Surat
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('format_surat.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Format Surat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('isi_surat.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Buat Surat
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        <!-- ####################### -->


        <!-- PENGELUARAN -->
        @if (Auth::user()->kode_divisi == '15' || Auth::user()->kode_divisi == '100')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Pengeluaran
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Credit
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Spare Parts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Non Spare Parts
                                </a>
                            </li>
                            <li class="nav-item" hidden>
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Timur Barat
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> Petty Cash
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('petty_cash_ho.index') }}">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> HO
                                </a>
                            </li>
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Bandung Raya
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekap_pc_vs_cek.index') }}">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rekap
                                            Bdg Vs Cek
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekap_pc_vs_cek_total.index') }}">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total
                                            Bdg
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekap_pc_rutin.index') }}">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rekap
                                            Rutin
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rekap_ops_rit_spp.index') }}">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rekap
                                            Ops Rit
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Rincian Ops Rit
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rekap
                                            Weekly
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Rincian Weekly
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <i class="nav-icon icon-"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rekap
                                            Non Rutin
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Timur Barat
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        @endif

        <!-- SND -->
        @if (Auth::user()->kode_divisi == '100')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> SND
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('due_date.index') }}">
                            <i class="nav-icon icon-control-play"></i> Request
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- SUPPLY DEMAND -->
        @if (Auth::user()->kode_divisi == '100')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Supply Demand
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('supply_demand.index') }}">
                            <i class="nav-icon icon-control-play"></i>Request
                        </a>
                    </li>
                </ul>

            </li>
        @endif

        <!-- BENGKEL
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '12')
<li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-folder"></i> Sparepart
            </a>

            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('purchase_order.index') }}">
                        <i class="nav-icon icon-control-play"></i> Purchase Order
                    </a>
                </li>
            </ul>
            
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kontrabon.index') }}">
                        <i class="nav-icon icon-control-play"></i> Kontra Bon
                    </a>
                </li>
            </ul>
            
        </li>
@endif  -->

        @if (Auth::user()->kode_divisi == '100')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Get In - Get Out
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link " href="#">
                            <i class="nav-icon icon-control-play"></i> Get In
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('getin_getout.create') }}">
                            <i class="nav-icon icon-control-play"></i>Get Out
                        </a>
                    </li>
                </ul>

            </li>
        @endif

        <!-- PEMBELIAN -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '21')
            <!-- Pembelian -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> AQUA
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pembelian_aqua_otm.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Import OTM
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('list_pembelian_aqua.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Data Import
                        </a>
                    </li>
                    <li class="nav-item" hidden>
                        <a class="nav-link" href="{{ route('permintaan_aqua.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i> PO Aqua
                        </a>
                    </li>
                    <li class="nav-item nav-dropdown" hidden>
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Monitoring
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>AQUA Gallon
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>AQUA SPS
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> VIT
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pembelian_vit_import.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Import VIT Compas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('list_pembelian_vit.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Data Import
                        </a>
                    </li>
                    <li class="nav-item nav-dropdown" hidden>
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Monitoring
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('monitoring_vit_gallon.index') }}">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>VIT Gallon
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>VIT SPS
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Tagihan TIV
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tagian_tiv_import.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Import Tagihan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('list_tagihan_tiv.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Data Tagihan
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tagihan_aqua_vit.index') }}">
                    <i class="nav-icon icon-folder"></i> Tagihan Pembelian
                </a>
            </li>
        @endif

        <!-- GUDANG PUSAT -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '22') <!-- GUDANG PUSAT -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i>Gudang In
                </a>

                <ul class="nav-dropdown-items">
                    @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('gudang_in.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check and Verify
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('gudang_in_check_control_history.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Checker
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_Report_gudang_in.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Data Stock
                            </a>
                        </li>
                    @elseif(Auth::user()->type == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check Control Sheet
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Gudang Out
                </a>

                <ul class="nav-dropdown-items">
                    @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('gudang_out.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check and Verify
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('gudang_out_check_control_history.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Checker
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_Report_gudang_out.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Data Stock
                            </a>
                        </li>
                    @elseif(Auth::user()->type == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_out.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check Control Sheet
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Masuk Barang -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '20')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Get In
                </a>

                <ul class="nav-dropdown-items">
                    @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('get_in.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check and Verify
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_history.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Checker
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_Report.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Data Stock
                            </a>
                        </li>
                    @elseif(Auth::user()->type == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check Control Sheet
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Get Out
                </a>

                <ul class="nav-dropdown-items">
                    @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('get_out.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check and Verify
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_out_history.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Checker
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_Report_out.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Data Stock
                            </a>
                        </li>
                    @elseif(Auth::user()->type == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('check_control_out.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Check Control Sheet
                            </a>
                        </li>
                    @endif


                </ul>
            </li>
            @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Mutasi
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mutasi_internal_leader.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Internal
                            </a>
                        </li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle " href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Eksternal
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('mutasi_eksternal_leader.index') }}">
                                        <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Keluar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('mutasi_eksternal_in_leader.index') }}">
                                        <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Masuk
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @elseif (Auth::user()->type == 'Admin')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Mutasi
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Internal
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('mutasi.index') }}">
                                        <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Keluar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('mutasi_internal_in.index') }}">
                                        <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Masuk
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle " href="#">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Eksternal
                            </a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('mutasi_eksternal_out_checker.index') }}">
                                        <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Keluar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('mutasi_eksternal_in_checker.index') }}">
                                        <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Masuk
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif

        @endif

        <!-- LOGISTIK -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '100')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logistik_uang_rit.index') }}">
                    <i class="nav-icon icon-folder"></i>Uang Rit
                </a>
            </li>
        @endif

        <!-- GA (General Affair) -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '4')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('serah_terima_user.index') }}">
                    <i class="nav-icon icon-folder"></i> Serah Terima User
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rab.index') }}">
                    <i class="nav-icon icon-folder"></i> R A B
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('asset_perusahaan.index') }}">
                    <i class="nav-icon icon-folder"></i> Asset
                </a>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Monitoring Asset
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('asset_dashboard.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item" hidden>
                        <a class="nav-link" href="#">
                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Detail
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- SND -->
        <!-- 0 = administrator; 13 = SND -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '13')
            {{-- <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-folder"></i> Surat Program
            </a>

            <ul class="nav-dropdown-items">
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle " href="#">
                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Eksternal
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('format_surat_program_eks.index') }}">
                                <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Format Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('isi_surat_program_ek.index') }}">
                                <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Buat Surat
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Internal
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Format Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="nav-icon icon"></i> &nbsp;&nbsp;&nbsp;&nbsp;Buat Surat
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Upload dan Kirim
                    </a>
                </li>
            </ul>
        </li> --}}

            @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Promo Penjualan
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('upload_kirim_surat_history.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                            </a>
                        </li>

                        @if (Auth::user()->kode_perusahaan == 'TUA')
                            @if (Auth::user()->kode_depo == '002')
                                @if (Auth::user()->kode_divisi == '13')
                                    @if (Auth::user()->type == 'Manager')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('pengajuan_tiv.index') }}">
                                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pengajuan
                                                (Program)
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endif
                        @endif

                        @if (Auth::user()->kode_sub_divisi == '13')
                            <li class="nav-item" hidden>
                                <a class="nav-link" href="{{ route('pengajuan_tiv.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pengajuan (Program)
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                @if (Auth::user()->kode_sub_divisi == '12' ||
                        Auth::user()->kode_sub_divisi == '13' ||
                        Auth::user()->kode_sub_divisi == '14' ||
                        Auth::user()->kode_sub_divisi == '15' ||
                        Auth::user()->kode_sub_divisi == '16')
                    <!-- Surat Program SND -->
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('qr_code.index') }}">
                            <i class="nav-icon icon-folder"></i> Qr Code
                        </a>
                    </li>
                @endif
            @elseif (Auth::user()->type == 'Admin')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Promo Penjualan
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('upload_kirim_surat_history.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                            </a>
                        </li>

                        @if (Auth::user()->kode_sub_divisi == '12')
                            <!-- jika SSD -->
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian Program
                                </a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('import_pencapaian.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i>Daftar
                                            Pencapaian
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i
                                                class="nav-icon icon-arrow-right"></i>Pencapaian Program
                                            <!-- Data Upload -->
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Auth::user()->kode_sub_divisi == '14')
                            <li class="nav-item" hidden>
                                <a class="nav-link" href="{{ route('pengajuan_tiv.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pengajuan (Program)
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_tiv.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pengajuan (Program)
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>


                @if (Auth::user()->kode_sub_divisi == '12' ||
                        Auth::user()->kode_sub_divisi == '13' ||
                        Auth::user()->kode_sub_divisi == '14' ||
                        Auth::user()->kode_sub_divisi == '15' ||
                        Auth::user()->kode_sub_divisi == '16' ||
                        Auth::user()->kode_sub_divisi == '21')
                    <!-- Surat Program SND -->
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="nav-icon icon-folder"></i> Perubahan Data
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('snd_import.index') }}">
                            <i class="nav-icon icon-folder"></i> Import Data
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('qr_code.index') }}">
                            <i class="nav-icon icon-folder"></i> Qr Code
                        </a>
                    </li>
                @endif
            @endif
        @elseif(Auth::user()->kode_divisi == '100' ||
                Auth::user()->kode_divisi == '18' ||
                Auth::user()->kode_divisi == '6' ||
                Auth::user()->kode_divisi == '23' ||
                Auth::user()->kode_divisi == '30' ||
                Auth::user()->kode_divisi == '24' ||
                Auth::user()->kode_divisi == '2' ||
                Auth::user()->kode_divisi == '10')
            <!-- Jika Audit, akunting, korsis, koordinator admin distribusi, Non Gudang, piutang (bu fitri), claim, kops, Claim -->
            @if (Auth::user()->kode_divisi == '6')
                @if (Auth::user()->kode_sub_divisi == '2')
                    <li class="nav-title">Promo Penjualan</li>
                @endif
            @endif

            @if (Auth::user()->type == 'Manager' || Auth::user()->type == 'Administrator')
                @if (Auth::user()->kode_perusahaan == 'TUA')
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-folder"></i> Promo Penjualan
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('upload_kirim_surat_history.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                </a>
                            </li>

                            @if (Auth::user()->kode_divisi == '10')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian Program
                                        <!-- Data Upload -->
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->kode_divisi == '24' || Auth::user()->kode_divisi == '30')
                                <!-- Piutang dan Non Gudang -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('approval_tiv.index') }}">
                                        <!-- 'pengajuan_tiv_masuk.index' -->
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pengajuan (Program)
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @elseif(Auth::user()->type == 'Admin')
                @if (Auth::user()->kode_perusahaan == 'TUA')
                    @if (Auth::user()->kode_divisi == '10') <!-- Jika Divisi Claim -->
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-folder"></i> Promo Penjualan
                            </a>

                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat_history.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                    </a>
                                </li>

                                @if (Auth::user()->kode_divisi == '10')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian Program
                                            <!-- Data Upload -->
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @elseif(Auth::user()->kode_divisi == '23')
                        <!-- Jika Divisi Korsis -->
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-folder"></i> Promo Penjualan
                            </a>

                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat_history.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                    </a>
                                </li>

                                @if (Auth::user()->kode_divisi == '10')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian Program
                                            <!-- Data Upload -->
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @elseif(Auth::user()->kode_divisi == '30')
                        <!-- Jika Divisi Non Gudang -->
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-folder"></i> Promo Penjualan
                            </a>

                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat_history.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                    </a>
                                </li>

                                @if (Auth::user()->kode_divisi == '10')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian Program
                                            <!-- Data Upload -->
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @elseif(Auth::user()->kode_divisi == '18')
                        <!-- Jika Divisi Audit -->
                        <li class="nav-item nav-dropdown">
                            <a class="nav-link nav-dropdown-toggle" href="#">
                                <i class="nav-icon icon-folder"></i> Promo Penjualan
                            </a>

                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('upload_kirim_surat_history.index') }}">
                                        &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                    </a>
                                </li>

                                @if (Auth::user()->kode_divisi == '10')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian Program
                                            <!-- Data Upload -->
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
            @elseif(Auth::user()->type == 'User')
                <!-- Jika Divisi Akunting Piutang Jatuh tempo -->
                @if (Auth::user()->kode_perusahaan == 'TUA')
                    @if (Auth::user()->kode_divisi == '6')
                        <!-- Jika Divisi Akunting Piutang Jatuh tempo -->
                        @if (Auth::user()->kode_sub_divisi == '2')
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon icon-folder"></i> Promo Penjualan
                                </a>

                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('upload_kirim_surat_history.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                        </a>
                                    </li>

                                    @if (Auth::user()->kode_divisi == '10')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian
                                                Program <!-- Data Upload -->
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                @elseif(Auth::user()->kode_perusahaan == 'LP')
                    @if (Auth::user()->kode_divisi == '6')
                        <!-- Jika Divisi Akunting Piutang Jatuh tempo -->
                        @if (Auth::user()->kode_sub_divisi == '2')
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon icon-folder"></i> Promo Penjualan
                                </a>

                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('upload_kirim_surat_history.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                        </a>
                                    </li>

                                    @if (Auth::user()->kode_divisi == '10')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian
                                                Program <!-- Data Upload -->
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                @elseif(Auth::user()->kode_perusahaan == 'WPS')
                    @if (Auth::user()->kode_divisi == '6')
                        <!-- Jika Divisi Akunting Piutang Jatuh tempo -->
                        @if (Auth::user()->kode_sub_divisi == '2')
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon icon-folder"></i> Promo Penjualan
                                </a>

                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('upload_kirim_surat.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Surat Program
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('upload_kirim_surat_history.index') }}">
                                            &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>History Promo
                                        </a>
                                    </li>

                                    @if (Auth::user()->kode_divisi == '10')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('data_upload_dtc.index') }}">
                                                &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pencapaian
                                                Program <!-- Data Upload -->
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                @endif
            @endif
        @endif

        @if (Auth::user()->kode_perusahaan == 'ARS')
            @if (Auth::user()->kode_divisi == '2')
                @if (Auth::user()->type == 'Manager')
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon icon-folder"></i> Promo Penjualan
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan_tiv.index') }}">
                                    <!-- 'pengajuan_tiv_masuk.index' -->
                                    &nbsp;&nbsp;<i class="nav-icon icon-control-play"></i>Pengajuan (Program)
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        @endif

        <!-- (PENGAJUAN BIAYA MASUK PROGRAM TIV UNTUK DIVISI PIUTANG JATUH TEMPO)-->
        @if (Auth::user()->kode_divisi == '6')
            @if (Auth::user()->kode_sub_divisi == '2')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                        <i class="nav-icon icon-folder"></i> Pengajuan TIV
                    </a>
                </li>
            @endif
        @endif

        <!-- (Piutang)-->
        @if (Auth::user()->kode_perusahaan == 'TUA')
            @if (Auth::user()->kode_depo == '902')
                @if (Auth::user()->kode_divisi == '24')
                    @if (Auth::user()->type == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                <i class="nav-icon icon-folder"></i> Pengajuan TIV
                            </a>
                        </li>
                    @endif
                @endif
            @endif
        @endif

        @if (Auth::user()->kode_perusahaan == 'ARS')
            @if (Auth::user()->type == 'Admin')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Pengajuan Masuk
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan Program
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif

        <!-- (Non Gudang)-->
        @if (Auth::user()->kode_perusahaan == 'TUA')
            @if (Auth::user()->kode_depo == '002')
                @if (Auth::user()->kode_divisi == '30')
                    @if (Auth::user()->type == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pengajuan_tiv_masuk.index') }}">
                                <i class="nav-icon icon-folder"></i> Pengajuan TIV
                            </a>
                        </li>
                    @endif
                @endif
            @endif
        @endif

        {{-- DATA CENTER --}}
        @if (Auth::user()->type == 'Administrator' || Auth::user()->type == 'Admin' || Auth::user()->type == 'Manager')
            @if (Auth::user()->kode_divisi == '7')
                <!-- Upload File Data Center Untuk PendukungSurat Program SND -->
                <li class="nav-item" hidden>
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-folder"></i> Import Data DMS
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('data_center_dms.index') }}">
                        <i class="nav-icon icon-folder"></i> Upload File
                    </a>
                </li>
            @endif
        @endif

        @if (Auth::user()->kode_divisi == '1') <!-- HRD -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('remun.index') }}">
                    <i class="nav-icon icon-folder"></i> Remunerasi
                </a>
            </li>
        @elseif(Auth::user()->kode_divisi == '6')
            @if (Auth::user()->type == 'Manager')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('remun.index') }}">
                        <i class="nav-icon icon-folder"></i> Remunerasi
                    </a>
                </li>
            @endif
        @endif

        @if (Auth::user()->type == 'Administrator' || Auth::user()->type == 'Administrator' || Auth::user()->type == 'Manager')
            @if (Auth::user()->kode_sub_divisi == '12' ||
                    Auth::user()->kode_sub_divisi == '13' ||
                    Auth::user()->kode_sub_divisi == '14' ||
                    Auth::user()->kode_sub_divisi == '15' ||
                    Auth::user()->kode_sub_divisi == '16') <!-- Surat Program SND -->
            @else
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Laporan
                    </a>
                    @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '22' || Auth::user()->kode_divisi == '20')
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('l_checker_gudang.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Checker Layak
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('l_checker_gudang_bs.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Checker BS
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('l_get_in.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Get In
                                </a>
                            </li>

                        </ul>
                    @elseif(Auth::user()->kode_divisi == '6')
                        <!-- Jika Divisi Akunting -->
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('laporan_biaya_jasa.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('laporan_spp.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> SPP
                                </a>
                            </li>
                        </ul>
                    @elseif(Auth::user()->kode_divisi == '4')
                        <!-- Jika Divisi GA -->
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ga_rekap_atk.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Rekap ATK
                                </a>
                            </li>
                        </ul>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('laporan_pengajuan.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('laporan_pengajuan_perbarang.index') }}">
                                    &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan Peritem
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>
            @endif
        @elseif(Auth::user()->type == 'Admin')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Laporan
                </a>
                @if (Auth::user()->kode_divisi == '6')
                    <!-- Jika Divisi Akunting -->
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('laporan_biaya_jasa.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Biaya/Jasa
                            </a>
                        </li>
                    </ul>
                @elseif(Auth::user()->kode_divisi == '4')
                    <!-- Jika Divisi GA -->
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ga_rekap_atk.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Rekap ATK
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('laporan_pengajuan.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('laporan_pengajuan_perbarang.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Pengajuan Peritem
                            </a>
                        </li>
                    </ul>
                @endif
            </li>
        @endif



        <!-- @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '0')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-folder"></i> Activity
                </a>
                        
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('daily_activity.index') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daily Activity
                        </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" href="{{ route('daily_activity/view_list.view_list') }}">
                            &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> List Activity
                        </a>
                    </li>
                </ul>
            </li>
@elseif(Auth::user()->kode_divisi == '13')
@if (Auth::user()->kode_sub_divisi == '12')
<li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                            
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('daily_activity_ssd.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daily Activity
                            </a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link" href="{{ route('daily_activity_ssd/view_list.view_list') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> List Activity
                            </a>
                        </li>
                    </ul>
                </li>
@elseif(Auth::user()->kode_sub_divisi == '13')
<li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                            
                    <ul class="nav-dropdown-items">
                        
                        <li class="nav-item" >
                            <a class="nav-link" href="{{ route('daily_activity_asm/view_list.view_list') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> List Activity
                            </a>
                        </li>
                    </ul>
                </li>
@elseif(Auth::user()->kode_sub_divisi == '14')
<li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                            
                    <ul class="nav-dropdown-items">
                        
                        <li class="nav-item" >
                            <a class="nav-link" href="{{ route('daily_activity_kpj/view_list.view_list') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> List Activity
                            </a>
                        </li>
                    </ul>
                </li>
@elseif(Auth::user()->kode_sub_divisi == '16')
<li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                            
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('daily_activity_som.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daily Activity
                            </a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link" href="{{ route('daily_activity_som/view_list.view_list') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> List Activity
                            </a>
                        </li>
                    </ul>
                </li>
@elseif(Auth::user()->kode_sub_divisi == '23')
<li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                            
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('daily_activity_som.index') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> Daily Activity
                            </a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link" href="{{ route('daily_activity_som/view_list.view_list') }}">
                                &nbsp;&nbsp;<i class="nav-icon icon-arrow-right"></i> List Activity
                            </a>
                        </li>
                    </ul>
                </li>
@endif -->
        <!-- dialy activity  -->
        @if (Auth::user()->kode_divisi == '100' || Auth::user()->kode_divisi == '0')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('daily_activity/view_list.view_list') }}">
                    <i class="nav-icon icon-folder"></i> Activity
                </a>
            </li>
        @elseif(Auth::user()->kode_divisi == '13')
            @if (Auth::user()->kode_sub_divisi == '12')
                <!-- SSD -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('daily_activity_ssd/view_list.view_list') }}">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                </li>
            @elseif(Auth::user()->kode_sub_divisi == '13')
                <!-- ASM -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('daily_activity_asm/view_list.view_list') }}">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                </li>
            @elseif(Auth::user()->kode_sub_divisi == '14')
                <!-- KPJ -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggl"
                        href="{{ route('daily_activity_kpj/view_list.view_list') }}">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                </li>
            @elseif(Auth::user()->kode_sub_divisi == '16')
                <!-- SOM -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('daily_activity_som/view_list.view_list') }}">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                </li>
            @elseif(Auth::user()->kode_sub_divisi == '23')
                <!-- SCM -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('daily_activity.dashboard_area') }}">
                        <i class="nav-icon icon-map"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('daily_activity/view_list.view_list') }}">
                        <i class="nav-icon icon-folder"></i> Activity
                    </a>
                </li>
                <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('daily_activity.index') }}">
                            <i class="nav-icon icon-folder"></i> Activity js
                        </a>
                    </li> -->
            @endif
        @endif
        @endif

        <!-- (BOD Monitoring )-->
        @if (Auth::user()->kode_divisi == '104')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('bod_monitoring.index') }}">
                    <i class="nav-icon icon-folder"></i> Monitoring Saldo
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('bod_akunting.index') }}">
                    <i class="nav-icon icon-folder"></i> Monitoring Kasir
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('bod_penjualan.index') }}">
                    <i class="nav-icon icon-folder"></i> Monitoring Penjualan
                </a>
            </li>
        @endif
    </ul>
</nav>
